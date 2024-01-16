<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Shortcut;
use App\Http\Controllers\Controller;
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
            ->rawColumns(['prodi', 'tgl_akreditasi', 'exp_akreditasi'])
            ->make(true);
    }
}
