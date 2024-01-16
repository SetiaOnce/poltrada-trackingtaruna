"use strict";
//Class Definition
// var save_method;
var table;
//Load Datatables banner
const _loadDataProdi = () => {
    //datatables
    table = $('#dt-Prodi').DataTable({
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            }
        ],
        "processing": true,
        "serverSide": true,
        "order" : [],
        // Load data for the table's content from an Ajax source
        "ajax" : {
            "url" : BASE_URL+ "/ajax/load_data_prodi",
            'headers': { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            "type" : "POST"
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
            { data: 'kode_prodi', name: 'kode_prodi'},
            { data: 'prodi', name: 'prodi'},
            { data: 'sk_akreditasi', name: 'sk_akreditasi'},
            { data: 'tgl_akreditasi', name: 'tgl_akreditasi'},
            { data: 'exp_akreditasi', name: 'exp_akreditasi'},
            { data: 'no_sk_prodi', name: 'no_sk_prodi'},
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
            { "width": "1%", "targets": 0, "className": "align-top text-center" },
            { "width": "5%", "targets": 1, "className": "align-top" },
            { "width": "25%", "targets": 2, "className": "align-top" },
            { "width": "25%", "targets": 3, "className": "align-top"},
            { "width": "5%", "targets": 4, "className": "align-top text-center" },
            { "width": "5%", "targets": 5, "className": "align-top text-center" },
            { "width": "19%", "targets": 6, "className": "align-top ", "orderable": false },
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
            $('[name="dt-Prodi_length"]').removeClass('custom-select custom-select-sm').selectpicker(), $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
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
    $('#dt-Prodi').css('width', '100%').DataTable().columns.adjust().draw();
    $('#export-excel').on('click', function(e) {
        e.preventDefault();
        table.button(0).trigger();
    });
}

//Class Initialization
jQuery(document).ready(function() {
    _loadDataProdi();
});