<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Shortcut;
use App\Http\Controllers\Controller;
use App\Models\AkademikBilling;
use App\Models\AkademikKelasDetail;
use App\Models\AkademikMahasiswa;
use App\Models\AkademikPenerbitTranskip;
use App\Models\AkademikPosisiTaruna;
use App\Models\AkademikRiwayatPendidikan;
use App\Models\PermohonanPelanggaran;
use App\Models\PermohonanPrestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class TrackingTarunaController extends Controller
{
    public function headLoadTaruna(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $errors					= [];
        $validator = Validator::make($request->all(), [
            'notar_nama_cekTaruna' => 'required',
            // 'captcha_cekTarunaAktif' => [
            //     'required', function ($attribute, $value, $fail) {
            //         if ( captcha_check($value) == false ) {
            //             $fail('Kode verifikasi captcha tidak sesuai. Reset captcha lalu coba lagi...');
            //         }
            //     },
            // ],
        ],[
            'notar_nama_cekTaruna.required' => 'Nama/notar mahasiswa masih kosong...',
            'captcha_cekTarunaAktif.required' => 'Kode verifikasi captcha masih kosong...',
        ]);

        if($validator->fails()){
            foreach ($validator->errors()->getMessages() as $item) {
                $errors[] = $item;
            }
            $response = array("status" => FALSE, "pesan_code" => 'format_inputan', "pesan_error" => $errors);
        } else {
            if (filter_var($request->input('notar_nama_cekTaruna'), FILTER_VALIDATE_INT) !== false) {
                // if input is notar
                $notar = $request->input('notar_nama_cekTaruna');
                $taruna = AkademikMahasiswa::where('nim', $notar)->first();
                if(!empty($taruna)){
                    $output = Shortcut::tarunaHead($taruna);
                    Shortcut::incrementTracking();
                    $response = array(
                        'status' => TRUE,
                        'row' => $output
                    );
                }else{
                    $response = array(
                        'notfound' => TRUE,
                    );
                }
            } else {
                // if input is name 
                $name = $request->input('notar_nama_cekTaruna');
                $taruna = AkademikMahasiswa::where('nama', 'LIKE', "%{$name}%")->first();
                if(!empty($taruna)){
                    $output = Shortcut::tarunaHead($taruna);
                    Shortcut::incrementTracking();
                    $response = array(
                        'status' => TRUE,
                        'row' => $output
                    );
                }else{
                    $response = array(
                        'notfound' => TRUE,
                    );
                }
            }
        }
        return response()->json($response);
    }
    public function loadDetailTaruna(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        // checking data taruna by input nik
        $nik = $request->input('nik');
        $nim = $request->input('nim');
        $checkTaruna = AkademikMahasiswa::where('nim', $nim)->where('nik', $nik)->first();
        if(!empty($checkTaruna)){
            $krsSemester = Shortcut::mahasiswaKrs($checkTaruna->nim);
            $posisiTaruna = AkademikPosisiTaruna::whereNim($nim)->first();
            $response = array(
                'status' => TRUE,
                'krsSemester' => $krsSemester,
                'posisiTaruna' => $posisiTaruna,
                'row' => $checkTaruna
            );
        }else{
            $response = array(
                'wrongNik' => TRUE,
                'nik' =>  $nik,
            );
        }
        return response()->json($response);
    }
    public function riwayatPendidikan(Request $request)
    {
        $data = AkademikRiwayatPendidikan::orderBy('periode', 'ASC')->where('nim', $request->input('nim'))->get();

        return Datatables::of($data)->addIndexColumn()
            ->rawColumns([''])
            ->make(true);
    } 
    public function pembayaranPendidikan(Request $request)
    {
        $data = AkademikBilling::select(
            'akademik_billing.id',
            'akademik_billing.status_bayar',
            'akademik_billing.kode_billing',
            'akademik_billing.status_bayar',
            'akademik_tahun_ajaran.tahun_ajaran',
            'akademik_tahun_ajaran.semester',
        )
        ->join('akademik_tahun_ajaran', 'akademik_billing.tahun_ajaran_id', 'akademik_tahun_ajaran.id')
        ->where('akademik_billing.nim', $request->nim)
        ->get();

        return Datatables::of($data)->addIndexColumn()
            ->editColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0);" class="btn btn-sm btn-info" onclick="_detailPemPendidikan('.$row->id.')">List Pembayaran</a>';
                return $btn;
            })
            ->editColumn('status', function ($row) {
                $status = '<span class="label label-danger label-inline mr-2">BELUM BAYAR</span>';
                if($row->status_bayar == 1){
                    $status = '<span class="label label-success label-inline mr-2">LUNAS</span>';
                }
                return $status;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    } 
    public function pembayaranPendidikanDetail(Request $request)
    {
        $headerBilling = AkademikBilling::select(
            'akademik_billing.id',
            'akademik_billing.kode_billing',
            'akademik_billing.status_bayar',
            'akademik_mahasiswa.nama',
            'akademik_mahasiswa.nim',
            'akademik_tahun_ajaran.tahun_ajaran',
            'akademik_tahun_ajaran.semester',
        )
        ->join('akademik_mahasiswa', 'akademik_billing.nim', 'akademik_mahasiswa.nim')
        ->join('akademik_tahun_ajaran', 'akademik_billing.tahun_ajaran_id', 'akademik_tahun_ajaran.id')
        ->where('akademik_billing.id', $request->idp_billing)
        ->first();
        $infoMahasiswa = '
            <div class="alert alert-custom alert-notice alert-light-primary fade show" role="alert">
                <table style="margin-left: 0; width: 100%;">
                    <tr>
                        <td class="td-head"><b>Nama </b></td>
                        <td class="td-middle"><b>: </b></td>
                        <td class="td-body"><b> '. $headerBilling->nama .' </b></td>
                    </tr>
                    <tr>
                        <td class="td-head"><b>NIM </b></td>
                        <td class="td-middle"><b>: </b></td>
                        <td class="td-body"><b> '. $headerBilling->nim .' </b></td>
                    </tr>
                </table>             
            </div>
        ';
        $response = array(
            'status' => TRUE,
            'headerBilling' => $headerBilling,
            'infoMahasiswa' => $infoMahasiswa,
        );
        return response()->json($response);
    }
    public function tablePembayaranPendidikanDetail(Request $request)
    {
        $data = AkademikBilling::select(
            'akademik_billing_detail.tarif_id',
            'keuangan_tarif.tarif',
            'keuangan_sub_jenis_penerimaan.subjenispenerimaan',
            'keuangan_satuan.nama_satuan'
        )
        ->join('akademik_billing_detail', 'akademik_billing_detail.billing_id', 'akademik_billing.id')
        ->join('keuangan_tarif', 'keuangan_tarif.id', 'akademik_billing_detail.tarif_id')
        ->join('keuangan_sub_jenis_penerimaan', 'keuangan_sub_jenis_penerimaan.id', 'keuangan_tarif.subjenis_id')
        ->join('keuangan_satuan', 'keuangan_satuan.id', 'keuangan_tarif.satuan_id')
        ->where('akademik_billing.id', $request->idp_billing)
        ->get();
        
        return Datatables::of($data)->addIndexColumn()
        ->editColumn('tarif', function ($row) {
            return number_format($row->tarif, 0, ',', '.');
        })
        ->rawColumns(['tarif'])
        ->make(true);
    }
    public function pelanggaranTaruna(Request $request)
    {
        $data = PermohonanPelanggaran::orderBy('tanggal', 'DESC')->where('nim', $request->input('nim'))->get();

        return Datatables::of($data)->addIndexColumn()
            ->editColumn('jenis_pelanggaran', function ($row) {
                return $row->pelanggaran->nama_jenis_pelanggaran;
            })
            ->editColumn('sub_pelanggaran', function ($row) {
                return $row->subpelanggaran->nama_jenis_sub_pelanggaran;
            })
            ->editColumn('tahun_ajaran', function ($row) {
                return $row->tahunajaran->tahun_ajaran;
            })
            ->editColumn('tanggal', function ($row) {
                return Shortcut::tanggalLower($row->tanggal);
            })
            ->rawColumns(['jenis_pelanggaran', 'sub_pelanggaran', 'tahun_ajaran', 'tanggal'])
            ->make(true);
    } 
    public function prestasiTaruna(Request $request)
    {
        $data = PermohonanPrestasi::orderBy('tanggal_prestasi', 'DESC')->where('nim', $request->input('nim'))->get();

        return Datatables::of($data)->addIndexColumn()
            ->editColumn('jenis_prestasi', function ($row) {
                return $row->prestasi->nama_jenis_prestasi;
            })
            ->editColumn('sub_prestasi', function ($row) {
                return $row->subPrestasi->nama_jenis_sub_prestasi;
            })
            ->editColumn('tahun_ajaran', function ($row) {
                return $row->tahunajaran->tahun_ajaran;
            })
            ->editColumn('tanggal', function ($row) {
                return Shortcut::tanggalLower($row->tanggal_prestasi);
            })
            ->rawColumns(['jenis_prestasi', 'sub_prestasi', 'tahun_ajaran', 'tanggal'])
            ->make(true);
    } 
    public function krsTaruna(Request $request)
    {
        $data = AkademikKelasDetail::select(
            'akademik_kelas.nama_kelas as nama_kelas',
            'akademik_kelas_header.jumlah_pertemuan as jumlah_pertemuan',
            'akademik_mata_kuliah.nama_mata_kuliah as nama_mk',
            'akademik_mata_kuliah.kode_mata_kuliah as kode_mk',
            'akademik_mata_kuliah.sks_mata_kuliah as jmlh_sks',
        )
        ->join('akademik_kelas', 'akademik_kelas.id', 'akademik_kelas_detail.kelas_id')
        ->join('akademik_kelas_header', 'akademik_kelas_header.id', 'akademik_kelas_detail.kelas_id')
        ->join('akademik_kurikulum_mk', 'akademik_kurikulum_mk.kurikulum_id', 'akademik_kelas_header.kurikulum_id')
        ->join('akademik_mata_kuliah', 'akademik_mata_kuliah.id', 'akademik_kurikulum_mk.mk_id')
        ->where('akademik_kelas_detail.nim', $request->input('nim'))
        ->where('akademik_kurikulum_mk.smt', $request->input('smt'))
        ->get();

        return Datatables::of($data)->addIndexColumn()
            ->editColumn('kode_mk', function ($row) {
                return $row->kode_mk;
            })
            ->editColumn('nama_mk', function ($row) {
                return $row->nama_mk;
            })
            ->editColumn('jmlh_sks', function ($row) {
                return $row->jmlh_sks;
            })
            ->editColumn('nama_kelas', function ($row) {
                return $row->nama_kelas;
            })
            ->editColumn('jumlah_pertemuan', function ($row) {
                return $row->jumlah_pertemuan;
            })
            ->rawColumns(['kode_mk', 'nama_mk', 'jmlh_sks', 'nama_kelas', 'jumlah_pertemuan'])
            ->make(true);
    } 
    public function khsTaruna(Request $request)
    {
        $data = AkademikPenerbitTranskip::where('notar', $request->nim)
        ->groupBy([
            'semester',
            'kode_matakuliah',
        ])
        ->orderBy('semester', 'ASC')
        ->get();
        return Datatables::of($data)->addIndexColumn()
            ->editColumn('grade', function ($row) {
                $result = DB::select("
                    SELECT akademik_skala_nilai.grade, akademik_skala_nilai.minimal, akademik_skala_nilai.maksimal
                    FROM akademik_skala_nilai
                    INNER JOIN akademik_kurikulum ON akademik_skala_nilai.kurikulum_id = akademik_kurikulum.id
                    WHERE :nilai_total BETWEEN akademik_skala_nilai.minimal AND akademik_skala_nilai.maksimal 
                    AND akademik_kurikulum.id = :kurikulum_id
                    LIMIT 1;
                ", ['nilai_total' => $row->nilai_total, 'kurikulum_id' => $row->kurikulum_id]);
            
                $result = collect($result)->first();
                return $result->grade; 
            })
            ->rawColumns(['grade'])
            ->make(true);
    }
}
