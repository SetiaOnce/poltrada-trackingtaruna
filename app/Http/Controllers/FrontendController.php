<?php

namespace App\Http\Controllers;

use App\Models\AkademikKelasDetail;
use App\Models\BannerHome;
use App\Models\ProfileApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    protected $base_view = 'frontend.';
    public function index()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return view('frontend.index');
    }

    public function loadSystemInfo()
    {
        $banner = BannerHome::where('id', 1)->first();
        $profile_app = ProfileApp::where('id', 1)->first();
        $url_banner = asset('dist/img/banner/'.$banner->file_banner);
        
        $response = array(
            'status' => TRUE,
            'url_banner' => $url_banner,
            'banner_text' => $banner->description,
            'copyright' => $profile_app->copyright_site,
            'url_logo_public' => asset('dist/img/logo/'.$profile_app->logo_public_head),
        );
        return response()->json($response);
    }
}
