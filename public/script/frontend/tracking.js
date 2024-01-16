var table1 ;var table2;var table3;var table4;var table5;var koor_lat;var koor_leng;
// for close page detail taruna
const closeDetailTaruan = () => {
    _initCaptcha(),$('#notar_nama_cekTaruna').val(''),$('#viewProfileTaruna').hide(),$('#cekTarunaTabContent').show(), $('.btn-close-mahasiswa').hide(),  $('#viewDetailDataTaruna').hide();
}
//===>> THIS BELLOW FOR CEK TARUNA AKTIF <<=== //
// for refresh captcha
const _initCaptcha = () => {
    var token = '{!! csrf_token() !!}';
    var request = 1;
    var url = BASE_URL + '/reloadcaptcha';
    $.get(url, {_token:token, request:request}, function(e) {
        $('#captcha_cekTarunaAktif').val('');
        $('#captImg-form').fadeIn('slow').html(e);
    });
}
// for clear form cek taruna
const _clearFormCekTarunaAktif = () => {
    _initCaptcha();
    $('#notar_nama_cekTaruna').val('');
}
// cek taruna aktif
$('#btn-search-cekTarunaAktif').click(function (e) {
    e.preventDefault();
    $('#btn-search-cekTarunaAktif').addClass('spinner spinner-light spinner-right').html('Mencari data...').attr('disabled', true);
    _blockUiPages(1);

    var url;
    var notarNama = $('#notar_nama_cekTaruna');
    var captchaCheck = $('#captcha_cekTarunaAktif');

    if (notarNama.val() == '') {
        toastr.error('Nama/notar mahasiswa masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('[name="notar_nama_cekTaruna"]').addClass('file-input-error').stop().delay(2500).queue(function () {
            $(this).removeClass('file-input-error');
        });
        notarNama.focus();
        $('#btn-search-cekTarunaAktif').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Cari').attr('disabled', false);
        _blockUiPages(0);

        return false;
    }
    if (captchaCheck.val() == '') {
        toastr.error('Kode verifikasi captcha masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('[name="captcha_cekTarunaAktif"]').addClass('file-input-error').stop().delay(2500).queue(function () {
            $(this).removeClass('file-input-error');
        });
        captchaCheck.focus();

        $('#btn-search-cekTarunaAktif').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Cari').attr('disabled', false);
        _blockUiPages(0);

        return false;
    }

    url = BASE_URL+ "/ajax/head_load_data_taruna";
    var formData = new FormData($('#form-cekTarunaAktif')[0]);
    $.ajax({
        url: url,
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            $('#btn-search-cekTarunaAktif').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Cari').attr('disabled', false);
            _blockUiPages(0);
            if (data.status==true){
                $('#viewProfileTaruna').html(data.row);
                
                $('#viewProfileTaruna').show();
                $('#cekTarunaTabContent').hide();
                $('.btn-close-mahasiswa').show()
                $('#nik_check_detail').mask('00000000000000000000');
            }else{
                if(data.pesan_code=='format_inputan') {
                    toastr.error(data.pesan_error[0], 'Uuppss!', {"progressBar": true, "timeOut": 2500});
                }else if(data.notfound){
                    toastr.error("Data taruna tidak ditemukan...", 'Maaf!', {"progressBar": true, "timeOut": 2500});
                    $('[name="notar_nama_cekTaruna"]').addClass('file-input-error').stop().delay(2500).queue(function () {$(this).removeClass('file-input-error');});
                } else {
                    Swal.fire("Ooops!", "Gagal melakukan proses data, mohon cek kembali isian pada form yang tersedia.", "error");  
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#btn-search-cekTarunaAktif').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Cari').attr('disabled', false);
            _blockUiPages(0);
            Swal.fire({title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, mohon hubungi pengembang.", icon: "error"
            }).then(function (result) {
                console.log('Load data is error!');
            });
        }
    });
});
//===>> THIS BELLOW FOR CEK DETAIL TARUNA AKTIF <<=== //
// cek detail taruna aktif
const _lihatDetailTaruna = () =>{
    $('#btn-lihatDetail').addClass('spinner spinner-light spinner-right').html('Mencari data...').attr('disabled', true);
    _blockUiPages(1);

    var url;
    var nik = $('#nik_check_detail');

    if (nik.val() == '') {
        toastr.error('Nik masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('[name="notar_nama_cekTaruna"]').addClass('file-input-error').stop().delay(2500).queue(function () {
            $(this).removeClass('file-input-error');
        });
        nik.focus();
        $('#btn-lihatDetail').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Lihat Detail').attr('disabled', false);
        _blockUiPages(0);

        return false;
    }
    url = BASE_URL+ "/ajax/load_detail_taruna_aktif";
    var nik = $('#nik_check_detail').val();
    var nim = $('#nim_mahasiswa').val();
    $.ajax({
        url: url,
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        dataType: "JSON",
        data: {
            nik, nim
        },success: function (data) {
            $('#btn-lihatDetail').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Lihat Detail').attr('disabled', false);
            _blockUiPages(0);
            if (data.status==true){
                if(data.posisiTaruna.koor_lat == 0 || data.posisiTaruna.koor_long == 0){
                    koor_lat = '-8.531962828359463';
                    koor_leng = '115.10725762668147';
                }else{
                    koor_lat = data.posisiTaruna.koor_lat;
                    koor_leng = data.posisiTaruna.koor_long;
                }
                // menampilkan map lokasi setelah data lat and leng didapatkan
                $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyCXSESO13hs0eNGVv9_Q8Ynbf0NcU4chIg&callback=initMap')
                .done(function(script, textStatus) {
                    initMap();
                })
                .fail(function(jqxhr, settings, exception) {
                    console.error('Gagal memuat skrip Google Maps: ' + exception);
                });
                $('#alert-notfound-detail').html(``);
                $('#viewDetailDataTaruna').show();
                loadRiwayatPendidikan(data.row.nim);
                loadPembayaranPendidikan(data.row.nim);
                loadPeanggaran(data.row.nim);
                loadPrestasi(data.row.nim);
                //this for krs
                $('#tablePersemester').html(``);
                for (i = 0; i < data.krsSemester.length; i++) {
                    var smt = data.krsSemester[i].smt;
                    viewTablekrs(smt);
                    loadkrsMahasiswa(data.row.nim, smt);
                }
                loadkhsMahasiswa(data.row.nim);
            }else{
                if(data.wrongNik){
                    $('#viewDetailDataTaruna').hide();
                    $('#alert-notfound-detail').html(`
                    <div class="alert alert-danger mt-4" role="alert">
                        <strong>Maaf! </strong> data tidak temukan cek kembali nik yang dimasukkan...
                    </div>
                    `);
                    toastr.error("Nik yang kamu masukkan tidak sesuai...", 'Maaf!', {"progressBar": true, "timeOut": 2500});
                    $('[name="nik_check_detail"]').addClass('file-input-error').stop().delay(2500).queue(function () {$(this).removeClass('file-input-error');});
                } else {
                    Swal.fire("Ooops!", "Gagal melakukan proses data, mohon cek kembali isian pada form yang tersedia.", "error");  
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#btn-lihatDetail').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Lihat Detail').attr('disabled', false);
            _blockUiPages(0);
            Swal.fire({title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, mohon hubungi pengembang.", icon: "error"
            }).then(function (result) {
                console.log('Load data is error!');
            });
        }
    });
}
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: parseFloat(koor_lat), lng: parseFloat(koor_leng) },
        zoom: 10,
    });
    var marker = new google.maps.Marker({
        position: {lat: parseFloat(koor_lat), lng: parseFloat(koor_leng)},
        map: map,
        icon: image,
        zIndex: 1,
    });
    var infoWindow = new google.maps.InfoWindow({
        content: '<div><strong>Lokasi Terakhir Taruna</strong></div>'
    });
    marker.addListener('mouseover', function() {
        infoWindow.open(map, marker);
    });
    marker.addListener('mouseout', function() {
        infoWindow.close();
    });
}
//load Riwayat pendidikan
function loadRiwayatPendidikan(nim) {
    //datatables
    table1 = $('#dt-riwayatPendidikan').DataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_riwayat_pendidikan_taruna",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST",
            "data": function ( data ) {
                data.nim= nim;
            }
        },
        "destroy" : true,
        "draw" : true,
        "deferRender" : true,
        "responsive" : false,
        "autoWidth" : true,
        "LengthChange" : true,
        "paginate" : true,
        "pageResize" : true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'periode', name: 'periode'},
            { data: 'jenjang', name: 'jenjang'},
            { data: 'sekolah', name: 'sekolah'},
            { data: 'jurusan', name: 'jurusan'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "align-top" },
            { "width": "10%", "targets": 1, "className": "align-top text-center" },
            { "width": "20%", "targets": 2, "className": "align-top" },
            { "width": "45%", "targets": 3, "className": "align-top"},
            { "width": "20%", "targets": 4, "className": "align-top" },
        ],
        "oLanguage": {
            "sSearch" : "<i class='flaticon-search-1'></i>",
            "sSearchPlaceholder": "Pencarian...",
            "sEmptyTable" : "Tidak ada Data yang dapat ditampilkan..",
            "sInfo" : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            "sInfoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "sInfoFiltered" : "",
            "sProcessing" : `<div class="d-flex justify-content-center align-items-center"><span class="spinner spinner-track position-static spinner-primary spinner-lg spinner-left"></span> <span class="text-dark">Mohon tunggu...</span></div>`,
            "sZeroRecords": "Tidak ada Data yang dapat ditampilkan..",
            "sLengthMenu" : "Tampilkan _MENU_",
            "oPaginate" : {
                "sPrevious" : "Sebelumnya",
                "sNext" : "Selanjutnya"
            }
        },
        "fnDrawCallback": function () {
            $('[name="dt-riwayatPendidikan_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
            $('.image-popup').magnificPopup({
                type: 'image',  closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true, duration: 150
                },
            });
        }
    });
    $('#dt-riwayatPendidikan').css('width', '100%').DataTable().columns.adjust().draw();
};
//load pembayaran pendidikan
function loadPembayaranPendidikan(nim) {
    //datatables
    table2 = $('#dt-pembayaranPendidikan').DataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_pembayaran_pendidikan_taruna",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST",
            "data": function ( data ) {
                data.nim= nim;
            }
        },
        "destroy" : true,
        "draw" : true,
        "deferRender" : true,
        "responsive" : false,
        "autoWidth" : true,
        "LengthChange" : true,
        "paginate" : true,
        "pageResize" : true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'kode_billing', name: 'kode_billing'},
            { data: 'tahun_ajaran', name: 'tahun_ajaran'},
            { data: 'semester', name: 'semester'},
            { data: 'status', name: 'status'},
            { data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "20%", "targets": 1, "className": "align-top text-center" },
            { "width": "25%", "targets": 2, "className": "align-top text-center" },
            { "width": "10%", "targets": 3, "className": "align-top text-center"},
            { "width": "15%", "targets": 4, "className": "align-top text-center"},
            { "width": "20%", "targets": 5, "className": "align-top text-center"},
        ],
        "oLanguage": {
            "sSearch" : "<i class='flaticon-search-1'></i>",
            "sSearchPlaceholder": "Pencarian...",
            "sEmptyTable" : "Tidak ada Data yang dapat ditampilkan..",
            "sInfo" : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            "sInfoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "sInfoFiltered" : "",
            "sProcessing" : `<div class="d-flex justify-content-center align-items-center"><span class="spinner spinner-track position-static spinner-primary spinner-lg spinner-left"></span> <span class="text-dark">Mohon tunggu...</span></div>`,
            "sZeroRecords": "Tidak ada Data yang dapat ditampilkan..",
            "sLengthMenu" : "Tampilkan _MENU_",
            "oPaginate" : {
                "sPrevious" : "Sebelumnya",
                "sNext" : "Selanjutnya"
            }
        },
        "fnDrawCallback": function () {
            $('[name="dt-pembayaranPendidikan_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
            $('.image-popup').magnificPopup({
                type: 'image',  closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true, duration: 150
                },
            });
        }
    });
    $('#dt-pembayaranPendidikan').css('width', '100%').DataTable().columns.adjust().draw();
};
// load detail list pembayaran pendidikan
function _detailPemPendidikan(idp_billing){
    _blockUiPages(1);
    url = BASE_URL+ "/ajax/load_detail_pembayaran_pendidikan_taruna";
    $.ajax({
        url: url,
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        dataType: "JSON",
        data: {
            idp_billing
        },success: function (data) {
            _blockUiPages(0);
            if (data.status==true){
                $('#vieModalDetailPembayaranPendidikan .modal-title').html('Detail Pembayaran Pendidikan ' + data.headerBilling.tahun_ajaran + '('+ data.headerBilling.semester +')');
                $('#mahasiswaBillingInformation').html(data.infoMahasiswa);
                _tableDetailPemPendidikan(idp_billing);
                $('#vieModalDetailPembayaranPendidikan').modal('show');
            }else{
                Swal.fire("Ooops!", "Gagal melakukan proses data, mohon cek kembali isian pada form yang tersedia.", "error");  
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#btn-lihatDetail').removeClass('spinner spinner-light spinner-right').html('<i class="icofont-search-2"></i> Lihat Detail').attr('disabled', false);
            _blockUiPages(0);
            Swal.fire({title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, mohon hubungi pengembang.", icon: "error"
            }).then(function (result) {
                console.log('Load data is error!');
            });
        }
    });
}
// load table detail pembayaran pendidikan
function _tableDetailPemPendidikan(idp_billing)
{
    //datatables
    table5 = $('#dt-detailPembayaranPendidikan').DataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_table_detail_pembayaran_pendidikan_taruna",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST",
            "data": function ( data ) {
                data.idp_billing= idp_billing;
            }
        },
        "destroy" : true,
        "draw" : true,
        "deferRender" : true,
        "responsive" : false,
        "autoWidth" : true,
        "LengthChange" : true,
        "paginate" : true,
        "pageResize" : true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'subjenispenerimaan', name: 'subjenispenerimaan'},
            { data: 'nama_satuan', name: 'nama_satuan'},
            { data: 'tarif', name: 'tarif'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "50%", "targets": 1, "className": "align-top" },
            { "width": "20%", "targets": 2, "className": "align-top" },
            { "width": "25%", "targets": 3, "className": "align-top text-center"},
        ],
        "oLanguage": {
            "sSearch" : "<i class='flaticon-search-1'></i>",
            "sSearchPlaceholder": "Pencarian...",
            "sEmptyTable" : "Tidak ada Data yang dapat ditampilkan..",
            "sInfo" : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            "sInfoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "sInfoFiltered" : "",
            "sProcessing" : `<div class="d-flex justify-content-center align-items-center"><span class="spinner spinner-track position-static spinner-primary spinner-lg spinner-left"></span> <span class="text-dark">Mohon tunggu...</span></div>`,
            "sZeroRecords": "Tidak ada Data yang dapat ditampilkan..",
            "sLengthMenu" : "Tampilkan _MENU_",
            "oPaginate" : {
                "sPrevious" : "Sebelumnya",
                "sNext" : "Selanjutnya"
            }
        },
        "fnDrawCallback": function () {
            $('[name="dt-detailPembayaranPendidikan_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
            $('.image-popup').magnificPopup({
                type: 'image',  closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true, duration: 150
                },
            });
        }
    });
    $('#dt-detailPembayaranPendidikan').css('width', '100%').DataTable().columns.adjust().draw();
}
//load pelanggaran mahasiswa
function loadPeanggaran(nim) {
    //datatables
    table3 = $('#dt-Pelanggaran').DataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_pelanggaran_taruna",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST",
            "data": function ( data ) {
                data.nim= nim;
            }
        },
        "destroy" : true,
        "draw" : true,
        "deferRender" : true,
        "responsive" : false,
        "autoWidth" : true,
        "LengthChange" : true,
        "paginate" : true,
        "pageResize" : true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'jenis_pelanggaran', name: 'jenis_pelanggaran'},
            { data: 'sub_pelanggaran', name: 'sub_pelanggaran'},
            { data: 'skor', name: 'skor'},
            { data: 'tahun_ajaran', name: 'tahun_ajaran'},
            { data: 'tanggal', name: 'tanggal'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "align-top" },
            { "width": "20%", "targets": 1, "className": "align-top" },
            { "width": "50%", "targets": 2, "className": "align-top" },
            { "width": "5%", "targets": 3, "className": "align-top text-center"},
            { "width": "10%", "targets": 4, "className": "align-top text-center"},
            { "width": "10%", "targets": 5, "className": "align-top text-center"},
        ],
        "oLanguage": {
            "sSearch" : "<i class='flaticon-search-1'></i>",
            "sSearchPlaceholder": "Pencarian...",
            "sEmptyTable" : "Tidak ada Data yang dapat ditampilkan..",
            "sInfo" : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            "sInfoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "sInfoFiltered" : "",
            "sProcessing" : `<div class="d-flex justify-content-center align-items-center"><span class="spinner spinner-track position-static spinner-primary spinner-lg spinner-left"></span> <span class="text-dark">Mohon tunggu...</span></div>`,
            "sZeroRecords": "Tidak ada Data yang dapat ditampilkan..",
            "sLengthMenu" : "Tampilkan _MENU_",
            "oPaginate" : {
                "sPrevious" : "Sebelumnya",
                "sNext" : "Selanjutnya"
            }
        },
        "fnDrawCallback": function () {
            $('[name="dt-Pelanggaran_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
            $('.image-popup').magnificPopup({
                type: 'image',  closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true, duration: 150
                },
            });
        }
    });
    $('#dt-Pelanggaran').css('width', '100%').DataTable().columns.adjust().draw();
};
//load prestasi mahasiswa
function loadPrestasi(nim) {
    //datatables
    table4 = $('#dt-prestasi').DataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_prestasi_taruna",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST",
            "data": function ( data ) {
                data.nim= nim;
            }
        },
        "destroy" : true,
        "draw" : true,
        "deferRender" : true,
        "responsive" : false,
        "autoWidth" : true,
        "LengthChange" : true,
        "paginate" : true,
        "pageResize" : true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'jenis_prestasi', name: 'jenis_prestasi'},
            { data: 'sub_prestasi', name: 'sub_prestasi'},
            { data: 'skor', name: 'skor'},
            { data: 'tahun_ajaran', name: 'tahun_ajaran'},
            { data: 'tanggal', name: 'tanggal'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "align-top" },
            { "width": "20%", "targets": 1, "className": "align-top" },
            { "width": "50%", "targets": 2, "className": "align-top" },
            { "width": "5%", "targets": 3, "className": "align-top text-center"},
            { "width": "10%", "targets": 4, "className": "align-top text-center"},
            { "width": "10%", "targets": 5, "className": "align-top text-center"},
        ],
        "oLanguage": {
            "sSearch" : "<i class='flaticon-search-1'></i>",
            "sSearchPlaceholder": "Pencarian...",
            "sEmptyTable" : "Tidak ada Data yang dapat ditampilkan..",
            "sInfo" : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            "sInfoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "sInfoFiltered" : "",
            "sProcessing" : `<div class="d-flex justify-content-center align-items-center"><span class="spinner spinner-track position-static spinner-primary spinner-lg spinner-left"></span> <span class="text-dark">Mohon tunggu...</span></div>`,
            "sZeroRecords": "Tidak ada Data yang dapat ditampilkan..",
            "sLengthMenu" : "Tampilkan _MENU_",
            "oPaginate" : {
                "sPrevious" : "Sebelumnya",
                "sNext" : "Selanjutnya"
            }
        },
        "fnDrawCallback": function () {
            $('[name="dt-prestasi_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
            $('.image-popup').magnificPopup({
                type: 'image',  closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true, duration: 150
                },
            });
        }
    });
    $('#dt-prestasi').css('width', '100%').DataTable().columns.adjust().draw();
};

// THIS BELOW FOR VIEW DATA KRS
function viewTablekrs(smt){
    $('#tablePersemester').append(`
        <span class="text-dark-50 text-hover-primary font-weight-bold">Semester `+ smt +`</span>
        <div class="table-responsive">
            <table id="dt-krs`+ smt +`" class="table table-hover table-bordered table-head-custom dtr-inline w-100">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center align-middle">No.</th>
                        <th class="align-middle">KODE MK</th>
                        <th class="align-middle">NAMA MATA KULIAH</th>
                        <th class="align-middle">SKS</th>
                        <th class="align-middle">KELAS</th>
                        <th class="align-middle">JML.PERTEMUAN</th>
                    </tr>
                </thead>
            </table>
        </div>
    `)
}
//load krs mahasiswa
function loadkrsMahasiswa(nim, smt) {
    //datatables
    $('#dt-krs'+ smt +'').DataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_krs_mahasiswa",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST",
            "data": function ( data ) {
                data.nim= nim;
                data.smt= smt;
            }
        },
        "destroy" : true,
        "draw" : true,
        "deferRender" : true,
        "responsive" : false,
        "autoWidth" : true,
        "LengthChange" : true,
        "paginate" : true,
        "pageResize" : true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'kode_mk', name: 'kode_mk'},
            { data: 'nama_mk', name: 'nama_mk'},
            { data: 'jmlh_sks', name: 'jmlh_sks'},
            { data: 'nama_kelas', name: 'nama_kelas'},
            { data: 'jumlah_pertemuan', name: 'jumlah_pertemuan'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "align-top" },
            { "width": "20%", "targets": 1, "className": "align-top" },
            { "width": "50%", "targets": 2, "className": "align-top" },
            { "width": "5%", "targets": 3, "className": "align-top text-center"},
            { "width": "10%", "targets": 4, "className": "align-top text-center"},
            { "width": "10%", "targets": 5, "className": "align-top text-center"},
        ],
        "oLanguage": {
            "sSearch" : "<i class='flaticon-search-1'></i>",
            "sSearchPlaceholder": "Pencarian...",
            "sEmptyTable" : "Tidak ada Data yang dapat ditampilkan..",
            "sInfo" : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            "sInfoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "sInfoFiltered" : "",
            "sProcessing" : `<div class="d-flex justify-content-center align-items-center"><span class="spinner spinner-track position-static spinner-primary spinner-lg spinner-left"></span> <span class="text-dark">Mohon tunggu...</span></div>`,
            "sZeroRecords": "Tidak ada Data yang dapat ditampilkan..",
            "sLengthMenu" : "Tampilkan _MENU_",
            "oPaginate" : {
                "sPrevious" : "Sebelumnya",
                "sNext" : "Selanjutnya"
            }
        },
        "fnDrawCallback": function () {
            $('[name="dt-krs'+ smt +'_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
            $('.image-popup').magnificPopup({
                type: 'image',  closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true, duration: 150
                },
            });
        }
    });
    $('#dt-krs'+ smt +'').css('width', '100%').DataTable().columns.adjust().draw();
};
//load khs mahasiswa
function loadkhsMahasiswa(nim) {
    //datatables
    $('#dt-khs').DataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_khs_mahasiswa",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST",
            "data": function ( data ) {
                data.nim= nim;
            }
        },
        "destroy" : true,
        "draw" : true,
        "deferRender" : true,
        "responsive" : false,
        "autoWidth" : true,
        "LengthChange" : true,
        "paginate" : true,
        "pageResize" : true,
        "paging": false,
        "info" : false,
        columns: [
            { data: 'semester', name: 'semester'},
            { data: 'kode_matakuliah', name: 'kode_matakuliah'},
            { data: 'nama_matakuliah', name: 'nama_matakuliah'},
            { data: 'sks_matakuliah', name: 'sks_matakuliah'},
            { data: 'nilai_total', name: 'nilai_total'},
            { data: 'grade', name: 'grade'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "align-top text-center", "visible": false},
            { "width": "10%", "targets": 1, "className": "align-top text-center",  "orderable": false},
            { "width": "30%", "targets": 2, "className": "align-top",  "orderable": false},
            { "width": "15%", "targets": 3, "className": "align-top text-center", "orderable": false},
            { "width": "15%", "targets": 4, "className": "align-top text-center", "orderable": false},
            { "width": "15%", "targets": 5, "className": "align-top text-center",  "orderable": false},
        ],
        "oLanguage": {
            "sSearch" : "<i class='flaticon-search-1'></i>",
            "sSearchPlaceholder": "Pencarian...",
            "sEmptyTable" : "Tidak ada Data yang dapat ditampilkan..",
            "sInfo" : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            "sInfoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "sInfoFiltered" : "",
            "sProcessing" : `<div class="d-flex justify-content-center align-items-center"><span class="spinner spinner-track position-static spinner-primary spinner-lg spinner-left"></span> <span class="text-dark">Mohon tunggu...</span></div>`,
            "sZeroRecords": "Tidak ada Data yang dapat ditampilkan..",
            "sLengthMenu" : "Tampilkan _MENU_",
            "oPaginate" : {
                "sPrevious" : "Sebelumnya",
                "sNext" : "Selanjutnya"
            }
        },
        "fnDrawCallback": function () {
            $('[name="dt-alumni_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
            $('.image-popup').magnificPopup({
                type: 'image',  closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true, duration: 150
                },
            });
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;
            api.column(0, {
                page: 'current'
            }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="align-middle"><td class="bg-secondary" colspan="6"><b>SEMESTER ' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        }
    });
    $('#dt-khs').css('width', '100%').DataTable().columns.adjust().draw();
};