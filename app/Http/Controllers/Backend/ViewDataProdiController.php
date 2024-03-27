<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Shortcut;
use App\Http\Controllers\Controller;
use App\Models\AkademikMahasiswa;
use App\Models\AkademikProdi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ViewDataProdiController extends Controller
{
    public function index()
    {
        if(!session()->get('login_akses')) { 
            return redirect('/login'); 
        }
        return  view('backend.view_data_prodi');
    }
    public function data(Request $request)
    { 
        $data = AkademikProdi::orderBy('id', 'DESC')->get();
        return Datatables::of($data)->addIndexColumn()
            ->editColumn('prodi', function ($row) {
                $output = '<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$row->nama_prodi.' </div>
                <a href="javascript:void(0);" class="text-muted font-weight-bold text-hover-primary"><strong>Jenjang : </strong>'.$row->nama_jenjang.'</a>
                <br><a href="javascript:void(0);" class="text-muted font-weight-bold text-hover-primary"><strong>Akreditasi : </strong> '.$row->akreditasi.'</a>';
                return $output;
            })
            ->editColumn('tgl_akreditasi', function ($row) {
                return Shortcut::tanggalLower($row->tgl_akreditasi);
            })
            ->editColumn('exp_akreditasi', function ($row) {
                return Shortcut::tanggalLower($row->exp_tgl_akreditasi);
            })
            ->editColumn('jmlh_taruna', function ($row) {
                $jmlhTaruna = AkademikMahasiswa::whereStatus(1)->whereKodeProdi($row->kode_prodi)->count();
                return '<a class="badge badge-dark" href="javascript:void(0);" onclick="viewListTaruna('."'".$row->kode_prodi."'".')" data-toggle="tooltip" title="Klik untuk melihat detail!">'.$jmlhTaruna.'</a>';
            })
            ->rawColumns(['prodi', 'tgl_akreditasi', 'exp_akreditasi', 'jmlh_taruna'])
            ->make(true);
    }
    public function listTaruna(Request $request)
    { 
        $prodi = AkademikProdi::whereKodeProdi($request->kode_prodi)->first();
        $data = AkademikMahasiswa::whereStatus(1)->orderBy('nama', 'ASC')->whereKodeProdi($request->kode_prodi)->get();
        $output = '';
        foreach($data as $key => $row){
            $key = $key+1;
            $output .= '
            <tr>
                <td align="middle">'.$key.'</td>
                <td align="middle">'.$row->nim.'</td>
                <td>'.$row->nama.'</td>
                <td>'.$row->alamat.'</td>
                <td align="middle">'.$row->jenis_kelamin.'</td>
                <td>'.$row->telp.'</td>
                <td>'.$row->tempat_lahir.'/'.date('d-m-Y', strtotime($row->tanggal_lahir)).'</td>
            </tr>';
        }
        $row = ['data_taruna' => $output, 'prodi' => $prodi,];
        return response()->json(['status' => true, 'message' => 'success', 'row' => $row]);
    }
}
