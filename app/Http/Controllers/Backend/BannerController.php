<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Shortcut;
use App\Http\Controllers\Controller;
use App\Models\BannerHome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function index()
    {
        if(!session()->get('login_akses')) { 
            return redirect('/login'); 
        }
        return view('backend.banner');
    }

    public function data()
    {
        $banner = BannerHome::where('id', 1)->first();
        
        $response = array(
            'status' => TRUE,
            'dataId' => $banner->id,
            'description' => $banner->description,
            'url_banner' => asset('dist/img/banner/'.$banner->file_banner),
        );
        return response()->json($response);
    }

    public function update(Request $request)
    {
		date_default_timezone_set("Asia/Makassar");

        $errors					= [];
        $validator = Validator::make($request->all(), [
            'description' => 'max:500',
        ],[
            'description.max' => 'Deskripsi tidak lebih dari 500 karakter.',
        ]);
    
        if($validator->fails()){
            foreach ($validator->errors()->getMessages() as $item) {
                $errors[] = $item;
            }
            $output = array("status" => FALSE, "pesan_code" => 'format_inputan', "pesan_error" => $errors);
        } else {
            
            if($request->file('file_banner')){
                $validator = Validator::make($request->all(), [
                    'file_banner' => 'mimes:png,jpg,jpeg|max:2048',
                ],[
                    'file_banner.required' => 'Background banner tidak boleh kosong.',
                    'file_banner.max' => 'Background banner tidak lebih dari 2MB.',
                    'file_banner.mimes' => 'Background banner berekstensi jpg jepg png.',
                ]);
            
                $mainImage = $request->file('file_banner');
                $filename = strtolower(Shortcut::random_strings(20)) . '-bgpublic.' . $mainImage->extension();
                Image::make($mainImage)->resize(1920,626)->save(public_path('dist/img/banner/'.$filename));
                BannerHome::where('id', 1)->update([
                    'file_banner' => $filename,
                ]);
            }
            
            BannerHome::where('id', 1)->update([
                'description' => $request->input('description'),
                'user_updated' => session()->get('nama'),
                'updated_at' => Carbon::now()
            ]);
            $output = array("status" => TRUE);
        }
        return response()->json($output);
    }
}
