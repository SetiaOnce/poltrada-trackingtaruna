<?php
namespace App\Helpers;

use App\Models\AkademikKelasDetail;
use App\Models\TrackingIncrement;
use DateTime, DateInterval, DatePeriod;
use Illuminate\Support\Facades\Request;


class Shortcut {  

    public function inf_medium_bulan($bln)
	{
		switch ($bln)
		{
			case 1:
				return "Jan";
				break;
			case 2:
				return "Feb";
				break;
			case 3:
				return "Mar";
				break;
			case 4:
				return "Apr";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Jun";
				break;
			case 7:
				return "Jul";
				break;
			case 8:
				return "Ags";
				break;
			case 9:
				return "Sep";
				break;
			case 10:
				return "Okt";
				break;
			case 11:
				return "Nov";
				break;
			case 12:
				return "Des";
				break;
		}
	}

    public static function medium_bulan($bln) 
	{
		switch ($bln)
		{
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	} 

    public static function daydate_indo($tanggal){
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	} 

    public function tanggalHarian() 
	{
		date_default_timezone_set("Asia/Jakarta");  
		if(Request::segment(3) AND Request::segment(4)) { 
			$bulan = Request::segment(4);
			$tahun = Request::segment(3);
			$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
		} else { 
			$bulan = date('m');
			$tahun = date('Y');
			$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
		}
		
		$start = $tahun.'-'.$bulan.'-1';
		$end = $tahun.'-'.$bulan.'-'.$tanggal;
		$loop_date =  Shortcut::loop_date($start,$end);   
		
		$val = array();
		foreach($loop_date as $i) 
		{
			$val[] = $this->tanggal_short($i);
		}
		return json_encode($val);
	}
 
	public static function tanggalLower($tanggal)
    {
        $arr_bln = ["Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember"];
        $cek_time = explode(' ',$tanggal);
        if($cek_time[0]){
            $bln = explode('-',$cek_time[0]);
        }else{
            $bln = explode('-',$tanggal);
        }
         return $bln[2].' '.$arr_bln[$bln[1]-1].' '.$bln[0];
        
    } 
	public static function tanggal($tanggal)
    {
        $arr_bln = ["JANUARI","FEBRUARI","MARET", "APRIL", "MEI", "JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER", "NOVEMBER","DESEMBER"];
        $cek_time = explode(' ',$tanggal);
        if($cek_time[0]){
            $bln = explode('-',$cek_time[0]);
        }else{
            $bln = explode('-',$tanggal);
        }
         return $bln[2].' '.$arr_bln[$bln[1]-1].' '.$bln[0];
        
    } 
 
	public static function tanggal_short($tanggal)
    {
        $arr_bln = ["JAN","FEB","MAR", "APR", "MEI", "JUN","JUL","AGU","SEP","OKT", "NOV","DES"];
        $cek_time = explode(' ',$tanggal);
        if($cek_time[0]){
            $bln = explode('-',$cek_time[0]);
        }else{
            $bln = explode('-',$tanggal);
        }
         return $bln[2].' '.$arr_bln[$bln[1]-1].' '.$bln[0];
        
    } 
	
	function formatRupiah($angka) 
	{
 
		if(is_numeric($angka)) {
			$format_rupiah = 'Rp ' . number_format($angka, '2', ',', '.');
			return $format_rupiah;
		}
		else {
			echo "$angka" . " bukan angka yang valid!" . "\n";
		}
	}

    public static function loop_date($start, $end)
    {
		date_default_timezone_set("Asia/Jakarta");  
        $begin = new DateTime(strtolower($start));
        $end = new DateTime(strtolower($end));
        $end = $end->modify( '+1 day' ); 

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        foreach($daterange as $rs){
            $new_daterange[] = $rs->format('Y-m-d');
        }
        return $new_daterange;
    }

    public static function loop_month()
    {
		date_default_timezone_set("Asia/Jakarta");   
		$new_month = array();
        for($i = 1; $i <= 12; $i++){
            $new_month[] = $i;
        }
        return $new_month;
    }
    
    public static function AuthLogin($jenis) 
	{
        $response = array(
            'pegawaiId'=> session()->get('pegawaiId'),  
            'nama'=> session()->get('nama'),  
            'nik'=> session()->get('nik'),  
            'npwp'=> session()->get('npwp'),  
            'nip'=> session()->get('nip'),
            'pin'=> session()->get('pin'),  
            'email'=> session()->get('email'),  
            'nidn'=> session()->get('nidn'),  
            'no_kk'=> session()->get('no_kk'),  
            'agama'=> session()->get('agama'),  
            'alamat'=> session()->get('alamat'),  
            'nikah'=> session()->get('nikah'),  
            'golongan_darah'=> session()->get('golongan_darah'),  
            'status'=> session()->get('status'),  
            'telp'=> session()->get('telp'),  
            'jk'=> session()->get('jk'),  
            'sk_cpns'=> session()->get('sk_cpns'),  
            'tgl_sk_cpns'=> session()->get('tgl_sk_cpns'),  
            'sk_pengangkatan'=> session()->get('sk_pengangkatan'),  
            'tgl_pengangkatan'=> session()->get('tgl_pengangkatan'),  
            'lembaga_pengangkatan'=> session()->get('lembaga_pengangkatan'),  
            'unit_kerja'=> session()->get('unit_kerja'),  
            'foto'=> session()->get('foto'),  
            'aplikasi'=> session()->get('aplikasi'),  
            'level'=> session()->get('level'), 
        );
		$response = $response[$jenis];
		return json_encode($response);
	}
    public static function random_strings($length_of_string)
	{
	
		// String of all alphanumeric character
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	
		// Shuffle the $str_result and returns substring
		// of specified length
		return substr(str_shuffle($str_result),
						0, $length_of_string);
	}

	public static function tarunaHead($row)
	{
		// this for status taruna
		if($row->status == 1){
			$status_taruna = '<span class="badge badge-success text-white"> Aktif</span>';
		}else if($row->status == 2){
			$status_taruna = '<span class="badge badge-warning text-white"> Tahan Tingkat</span>';
		}else if($row->status == 3){
			$status_taruna = '<span class="badge badge-danger text-white"> Drop Out</span>';
		}else if($row->status == 4){
			$status_taruna = '<span class="badge badge-info text-white"> Lulus</span>';
		}

		// this for responsive profile
		$fotoMobile = '';
		$fotoDesktop = '
		<div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
			<div class="symbol symbol-50 symbol-lg-120">
				<img src="https://sitaruna.poltradabali.ac.id/storage/taruna/'.$row->foto.'" alt="profile-taruna" />
			</div>
		</div>
		';
		if((new \Jenssegers\Agent\Agent())->isMobile()){
			$fotoMobile = '
			<div class="text-center">
				<div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
					<div class="symbol symbol-50 symbol-lg-120">
						<img src="https://sitaruna.poltradabali.ac.id/storage/taruna/'.$row->foto.'" alt="profile-taruna" />
					</div>
				</div>
			</div>
			';
			$fotoDesktop = '';
		}
		$output = '
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<!--begin: Foto Profile mobile-->
					'.$fotoMobile.'
					<!--end::Foto Profile mobile-->
					<div class="d-flex">
						<!--begin: Foto Profile desktop-->
						'.$fotoDesktop.'
						<!--end::Foto Profile desktop-->
						<!--begin::Info-->
						<div class="flex-grow-1">
							<!--begin::Title-->
							<div class="d-flex justify-content-between flex-wrap mt-1">
								<div class="d-flex mr-3">
									<a href="javascript:void(0);" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">PROFILE TARUNA/I</a>
								</div>
							</div>
							<hr>
							<!--end::Title-->
							<!--begin::Content-->
							<div class="d-flex flex-wrap justify-content-between mt-1">
								<div class="d-flex flex-column flex-grow-1 pr-8">
									<table style="margin-left: 0; width: 100%;">
										<tr>
											<td class="td-head"><b>Nama </b></td>
											<td class="td-middle"><b>: </b></td>
											<td class="td-body"><b> '.$row->nama.' </b></td>
										</tr>
										<tr>
											<td class="td-head"><b>Jenis Kelamin </b></td>
											<td class="td-middle"><b>: </b></td>
											<td class="td-body"><b> '.$row->jenis_kelamin.' </b></td>
										</tr>
										<tr>
											<td class="td-head"><b>Program Studi </b></td>
											<td class="td-middle"><b>: </b></td>
											<td class="td-body"><b> '.$row->prodi->nama_jenjang.' '.$row->prodi->nama_prodi.' </b></td>
										</tr>
										<tr>
											<td class="td-head"><b>Alamat </b></td>
											<td class="td-middle"><b>: </b></td>
											<td class="td-body"><b> '.$row->alamat.' </b></td>
										</tr>
										<tr>
											<td class="td-head"><b>NIM/No.Taruna </b></td>
											<td class="td-middle"><b>: </b></td>
											<td class="td-body"><b> '.$row->nim.' </b></td>
										</tr>
										<tr>
											<td class="td-head"><b>Nama Polbit </b></td>
											<td class="td-middle"><b>: </b></td>
											<td class="td-body"><b> '.$row->nama_polbit.' </b></td>
										</tr>
										<tr>
											<td class="td-head"><b>Status </b></td>
											<td class="td-middle"><b>: </b></td>
											<td class="td-body-noopas"><b> '.$status_taruna.' </b></td>
										</tr>
									</table>
								</div>
							</div>
							<!--end::Content-->
						</div>
						<!--end::Info-->
					</div>

					<div class="text-center">
						<div class="alert alert-warning mt-4" role="alert">
							Untuk info lebih lengkap silakan klik lihat detail yang disertakan dengan NIK.
						</div>
						<div class="col-md-12 d-flex justify-content-center">
							<div class="form-group">
								<input type="hidden" id="nim_mahasiswa" name="nim_mahasiswa" value="'.$row->nim.'">
								<input type="text" id="nik_check_detail" name="nik_check_detail" class="form-control" placeholder="isi nik..." autocomplete="off">
							</div>
							<div class="form-group ml-3">
								<button type="button" class="btn btn-info btn-sm waves-effect waves-light" id="btn-lihatDetail" onclick="_lihatDetailTaruna()"><i class="icofont-search-2"></i> Lihat Detail </button>
							</div>
						</div>
						<div id="alert-notfound-detail">

						</div>
					</div>

				</div>
			</div>
		';
		return $output;
	}
	public static function mahasiswaKrs($nim)
	{
        $data = AkademikKelasDetail::select(
            'akademik_kurikulum_mk.*'
        )
        ->join('akademik_kelas', 'akademik_kelas.id', 'akademik_kelas_detail.kelas_id')
        ->join('akademik_kelas_header', 'akademik_kelas_header.id', 'akademik_kelas_detail.kelas_id')
        ->join('akademik_kurikulum_mk', 'akademik_kurikulum_mk.kurikulum_id', 'akademik_kelas_header.kurikulum_id')
        ->join('akademik_mata_kuliah', 'akademik_mata_kuliah.id', 'akademik_kurikulum_mk.mk_id')
        ->where('akademik_kelas_detail.nim', $nim)
        ->groupBy('akademik_kurikulum_mk.smt')
        ->get();
		return $data;
	}

	public static function incrementTracking()
	{
		$date =  date("Y-m-d");
        $checkDate =  TrackingIncrement::where('date', $date)->first();
		if(!empty($checkDate)){
			TrackingIncrement::where('date', $date)->increment('tracking_increment');
		}else{
			TrackingIncrement::create([
				'date' => $date,
				'tracking_increment' => 1,
			]);
		}
	}
}