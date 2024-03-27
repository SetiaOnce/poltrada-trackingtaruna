<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\ProfileAppController;
use App\Http\Controllers\Backend\ViewDataProdiController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Frontend\TrackingTarunaController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Login\LoginController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return 'DONE';
});

Route::controller(FrontendController::class)->group(function(){
    Route::get('/', 'index');
});

//  ===========>> FOR LOGIN ADMIN <<============== //
Route::group(['prefix' => 'front'], function () {
    Route::controller(LoginController::class)->group(function(){
        Route::get('/load_login_info', 'loadLoginInfo');
    });
    Route::controller(FrontendController::class)->group(function(){
        Route::get('/load_info_system', 'loadSystemInfo');
    });
});
Route::get('/reloadcaptcha', function () {
	return captcha_img();
});
Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index');
    Route::post('/ajax_login', 'login');
});
Route::get('/logout', function () {
    Session::flush();
    return redirect('/'); 
});
//  ===========>> END LOGIN ADMIN<<============== //

// App Admin
Route::group(['middleware' => 'Session'], function() {
    Route::group(['prefix' => 'app_admin'], function () {
        Route::get('/dashboard', function () {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            if(!session()->get('login_akses')) { 
                return redirect('/login'); 
            } 
            $data['header_title'] = 'DASHBOARD';
            return view('backend.index', $data);
        });
        Route::get('/user_profile', function () {
            if(!session()->get('login_akses')) { 
                return redirect('/login'); 
            } 
            $data['header_title'] = 'USER PROFILE';
            return view('backend.common.profile', $data);
        });
        //  ===========>> CUMMON  <<============== //
        Route::get('/load_user_profile', [CommonController::class, 'loaduserProfile']);
        Route::get('/ajax_get_count_widget', [CommonController::class, 'countWidget']);
        Route::get('/load_profile', [CommonController::class, 'loadProfile']);
        Route::get('/load_app_profile_site', [CommonController::class, 'loadProfileApp']);
        Route::get('/load_trend_tracker', [CommonController::class, 'loadTrendTracker']);
        //  ===========>> END COMMON <<============== //  
        
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/profileapps', [ProfileAppController::class, 'index']);
            Route::controller(ProfileAppController::class)->group(function(){
                Route::get('/load_profileapps', 'loadProfileApp');
                Route::post('/profileapps_update', 'profileAppUpdate');
            });
            Route::get('/banner', [BannerController::class, 'index']);
        });
        Route::get('/viewprodi', [ViewDataProdiController::class, 'index']);
    });
});

// for setting banner
Route::controller(BannerController::class)->group(function(){
    Route::get('/ajax/load_banner', 'data');
    Route::post('/ajax/banner_update', 'update');
});
// for view data prodi
Route::controller(ViewDataProdiController::class)->group(function(){
    Route::post('/ajax/load_data_prodi', 'data');
    Route::get('/ajax/load_list_taruna', 'listTaruna');
});

// THIS BELLOW FOR TRACKING TARUNA FRONT//
Route::controller(TrackingTarunaController::class)->group(function(){
    Route::post('/ajax/head_load_data_taruna', 'headLoadTaruna');
    Route::post('/ajax/load_detail_taruna_aktif', 'loadDetailTaruna');
    Route::post('/ajax/load_riwayat_pendidikan_taruna', 'riwayatPendidikan');
    Route::post('/ajax/load_pembayaran_pendidikan_taruna', 'pembayaranPendidikan');
    Route::post('/ajax/load_detail_pembayaran_pendidikan_taruna', 'pembayaranPendidikanDetail');
    Route::post('/ajax/load_table_detail_pembayaran_pendidikan_taruna', 'tablePembayaranPendidikanDetail');
    Route::post('/ajax/load_pelanggaran_taruna', 'pelanggaranTaruna');
    Route::post('/ajax/load_prestasi_taruna', 'prestasiTaruna');
    Route::post('/ajax/load_krs_mahasiswa', 'krsTaruna');
    Route::post('/ajax/load_khs_mahasiswa', 'khsTaruna');
});