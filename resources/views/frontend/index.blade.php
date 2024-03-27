@extends('frontend.layouts', ['activeMenu' => 'Home', 'activeSubMenu' => '', 'title' => 'Tracking Taruna'])
@section('content')
@section('css')
<style>
.td-head{
    width: 25%; line-height: 1.5; font-size: 10pt; vertical-align: top;
}
.td-middle{
    width: 1%; line-height: 1.5; font-size: 10pt; vertical-align: top;
}
.td-body{
    line-height: 1.5; font-size: 10pt; vertical-align: top; opacity: 0.5;
}
.td-body-noopas{
    line-height: 1.5; font-size: 10pt; vertical-align: top;
}
@media print {
    .hide-on-print {
        display: none !important;
    }
}
</style>    
@stop
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row ng-scope">
            <div class="col-xl-12">
                <div class="card card-custom card-custom-sticky animate__animated animate__fadeInUp gutter-b" id="kt_page_sticky_card">
                    <div class="card-header border-bottom-0">
                        <div class="card-title mt-0">
                            <ul class="nav nav-tabs justify-content-sm-center" id="cekTarunaTab">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tarunaAktif-tab" data-tabs-content="tarunaAktif-tabContent" href="javascript:void(0);">
                                        <span class="nav-icon">
                                            <i class="flaticon-users"></i>
                                        </span>
                                        <span class="nav-text">TARUNA</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-header btn-close-mahasiswa" style="display: none">
                        <div class="card-title"></div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <button type="button" class="btn btn-sm btn-danger font-weight-bolder mr-2" onclick="_printDetailTaruna()"><i class="fa fa-print"></i> Print</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="button" class="btn btn-sm btn-light font-weight-bolder" onclick="closeDetailTaruan()"><i class="fas fa-times"></i> Tutup</button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body pt-0 border-top-0">
                        <div class="tab-content mt-5" id="cekTarunaTabContent">
                            <div class="tab-pane animate__animated animate__fadeIn show active" id="tarunaAktif-tabContent">
                                <!--begin::Notice-->
                                <div class="alert alert-custom alert-primary animate__animated animate__fadeIn show gutter-b textAlert-tarunaAktif" role="alert">
                                    <div class="alert-icon">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                            <i class="bi bi-megaphone-fill"></i>
                                        </span>
                                    </div>
                                    <div class="alert-text">
                                        ATURAN PENCARIAN DATA TARUNA POLTRADA SEBAGAI BERIKUT : GUNAKAN NIM/NOTAR DAN ATAU NAMA SEBAGAI ACUAN PENCARIAN DATA DI PUSAT DATA TARUNA POLTRADA. PASTIKAN KERAHASIAN DATA DIJAGA DENGAN BAIK DAN JANGAN BERIKAN DATA TERSEBUT KE ORANG YANG TIDAK DIKENAL.
                                    </div>
                                </div>
                                <!--end::Notice-->
                                <!--begin::Form Cek Taruna Aktif-->
                                <form class="form ng-pristine ng-valid" autocomplete="off" id="form-cekTarunaAktif">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-lg-8 offset-lg-2">
                                            <div class="form-group">
                                                <label for="notar_nama_cekTaruna">NAMA/NOTAR: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user-edit"></i></span>
                                                    </div>
                                                    <input type="text" id="notar_nama_cekTaruna" name="notar_nama_cekTaruna" class="form-control" placeholder="Isi Nama/ NOTAR Mahasiswa..." autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="separator separator-dashed my-5"></div>
                                            <div class="form-group">
                                                <label for="captcha_cekTarunaAktif">Kode Captcha: <span class="text-danger">*</span></label>
                                                <div class="row justify-content-start align-items-center">
                                                    <div class="col-md-4 mb-3 mb-md-0">
                                                        <span class="captcha-img mr-1" id="captImg-form" data-toggle="tooltip" title="" data-original-title="Kode verifikasi captcha">{!! captcha_img() !!}</span>
                                                        <button type="button" class="btn btn-icon btn-dark btn-circle btn-sm" data-toggle="tooltip" title="" onclick="_initCaptcha();" data-original-title="Reset kode verifikasi captcha!"><i class="fas fa-spin fa-sync-alt"></i></button>
                                                    </div>
                                                    <div class="col-md-8 input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="icofont-pixels"></i></span>
                                                        </div>
                                                        <input type="text" id="captcha_cekTarunaAktif" name="captcha_cekTarunaAktif" class="form-control mask_max4" placeholder="Isi sesuai gambar captcha..." maxlength="4" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                    <div class="d-flex justify-content-end mt-10">
                                        <button type="button" id="btn-search-cekTarunaAktif" class="btn btn-info mr-2"><i class="icofont-search-2"></i> Cari</button>
                                        <button type="button" id="btn-reset-cekTarunaAktif" class="btn btn-secondary" onclick="_clearFormCekTarunaAktif();"><i class="flaticon2-refresh-1"></i> Reset</button>
                                    </div>
                                </form>
                                <!--end::Form Cek Taruna Aktif-->
                            </div>
                        </div>
                        <div class="tab-content mt-5" id="viewProfileTaruna" style="display: none">

                        </div>
                        <div class="tab-content mt-5" id="viewDetailDataTaruna" style="display: none">
                            <div class="row">
                                <div class="col-lg-10 offset-lg-1">
                                    <div class="d-flex align-items-baseline flex-wrap mr-5 titlePageBreadcrumb">
                                        <h5 class="text-dark font-weight-bold my-1 mr-5"><i class="bi bi-geo-alt-fill text-dark"></i> Lokasi Terakhir</h5>
                                    </div>
                                    <div id="map" class="mb-5" style="height: 250px;"></div>
                                    <div id="riwayat-pendidikan">
                                        <div class="d-flex align-items-baseline flex-wrap mr-5 titlePageBreadcrumb">
                                            <h5 class="text-dark font-weight-bold my-1 mr-5"><i class="flaticon2-website text-dark"></i> Riwayat Pendidikan</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dt-riwayatPendidikan" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center align-middle">No.</th>
                                                        <th class="align-middle">PERIODE</th>
                                                        <th class="align-middle">JENJANG</th>
                                                        <th class="align-middle">SEKOLAH/INSTANSI</th>
                                                        <th class="align-middle">JURUSAN</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="pembayaran-pendidikan" class="mt-4">
                                        <div class="d-flex align-items-baseline flex-wrap mr-5 titlePageBreadcrumb">
                                            <h5 class="text-dark font-weight-bold my-1 mr-5"><i class="flaticon2-website text-dark"></i> Pembayaran Pendidikan</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dt-pembayaranPendidikan" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center align-middle">No.</th>
                                                        <th class="align-middle">KODE BILLING</th>
                                                        <th class="align-middle">TAHUN AJARAN</th>
                                                        <th class="align-middle">SEMESTER</th>
                                                        <th class="align-middle">STATUS</th>
                                                        <th class="align-middle">#</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="mahasiswa-pelanggaran" class="mt-4">
                                        <div class="d-flex align-items-baseline flex-wrap mr-5 titlePageBreadcrumb">
                                            <h5 class="text-dark font-weight-bold my-1 mr-5"><i class="flaticon2-website text-dark"></i> Pelanggaran</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dt-Pelanggaran" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center align-middle">No.</th>
                                                        <th class="align-middle">JENIS PELANGGARAN</th>
                                                        <th class="align-middle">SUB JENIS PELANGGARAN</th>
                                                        <th class="align-middle">SKOR</th>
                                                        <th class="align-middle">TAHUN AJARAN</th>
                                                        <th class="align-middle">TANGGAL/WAKTU</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="mahasiswa-prestasi" class="mt-4">
                                        <div class="d-flex align-items-baseline flex-wrap mr-5 titlePageBreadcrumb">
                                            <h5 class="text-dark font-weight-bold my-1 mr-5"><i class="flaticon2-website text-dark"></i> Prestasi</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dt-prestasi" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center align-middle">No.</th>
                                                        <th class="align-middle">JENIS PRESTASI</th>
                                                        <th class="align-middle">SUB JENIS PRESTASI</th>
                                                        <th class="align-middle">SKOR</th>
                                                        <th class="align-middle">TAHUN AJARAN</th>
                                                        <th class="align-middle">TANGGAL/WAKTU</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="mahasiswa-krs" class="mt-4">
                                        <div class="d-flex align-items-baseline flex-wrap mr-5 titlePageBreadcrumb">
                                            <h5 class="text-dark font-weight-bold my-1 mr-5"><i class="flaticon2-website text-dark"></i> KRS</h5>
                                        </div>
                                        <div id="tablePersemester"></div>
                                        <div class="table-responsive">
                                            <table id="dt-krs" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="align-middle">SEMESTER</th>
                                                        <th class="align-middle">KODE MK</th>
                                                        <th class="align-middle">NAMA MATA KULIAH</th>
                                                        <th class="align-middle">SKS</th>
                                                        <th class="align-middle">JML.PERTEMUAN</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="mahasiswa-khs" class="mt-4">
                                        <div class="d-flex align-items-baseline flex-wrap mr-5 titlePageBreadcrumb">
                                            <h5 class="text-dark font-weight-bold my-1 mr-5"><i class="mdi mdi-card-account-details text-dark"></i> KHS</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dt-khs" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="align-middle">SEMESTER</th>
                                                        <th class="align-middle">KODE</th>
                                                        <th class="align-middle">NAMA MATA KULIAH</th>
                                                        <th class="align-middle">SKS</th>
                                                        <th class="align-middle">NILAI</th>
                                                        <th class="align-middle">GRADE</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--begin View Modal Detail Pembayaran Pendidikan-->
<div class="modal fade" id="vieModalDetailPembayaranPendidikan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="scroll scroll-pull" data-scroll="true" data-height="400">
                    <!--begin::Content-->
                    <div class="d-flex flex-wrap justify-content-between mb-2">
                        <div class="d-flex flex-column flex-grow-1 pr-8" id="mahasiswaBillingInformation">
                            <div class="alert alert-custom alert-notice alert-light-primary fade show" role="alert">
                              
                            </div>
                        </div>
                    </div>
                    <!--end::Content-->
                    <!-- begin:Table Detail Pembayaran View-->
                    <div class="row justify-content-center mt-4">
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="dt-detailPembayaranPendidikan" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-center align-middle">No.</th>
                                                <th class="align-middle">ITEM TAGIHAN</th>
                                                <th class="align-middle">SATUAN</th>
                                                <th class="align-middle text-center">TARIF(RP)</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end:Table Detail Pembayaran View-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal"><i aria-hidden="true" class="ki ki-close"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end View Modal Detail Pembayaran Pendidikan-->
@section('js')
    <script>
        var image = "{{ asset ('dist/img/marker.png')}}"
    </script>
    <script src="{{ asset('script/frontend/tracking.js') }}"></script>
@stop
@endsection
