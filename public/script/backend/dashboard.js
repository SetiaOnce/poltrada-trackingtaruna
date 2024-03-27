//Class Definition
function load_init() {
    //Load User Profil
    $.ajax({
		url: BASE_URL+ "/app_admin/load_user_profile",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
            /*User SideRight*/
            var userThumbSide=`<div class="symbol symbol-50 symbol-lg-120 symbol-primary">
                <span class="font-size-h3 symbol-label font-weight-boldest">` +data.foto+ `</span>
            </div>`;
            if(data.foto=='' || data.foto==null){
                userThumbSide=`<div class="symbol symbol-50 symbol-lg-120 symbol-primary">
                    <span class="font-size-h3 symbol-label font-weight-boldest">` +data.foto+ `</span>
                </div>`;
            }else{
                userThumbSide=`<div class="symbol symbol-50 symbol-lg-120">
                    <img src="` +data.foto+ `" alt="user-image" />
                </div>`;
            }
            var userInfo = `<div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom shadow-md gutter-b">
                    <div class="card-body">
                        <!--begin::Details-->
                        <div class="d-flex">
                            <!--begin: Pic-->
                            <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                ` +userThumbSide+ `
                            </div>
                            <!--end::Pic-->
                            <!--begin::Info-->
                            <div class="flex-grow-1">
                                <!--begin::Title-->
                                <div class="d-flex justify-content-between flex-wrap mt-1">
                                    <div class="d-flex mr-3">
                                        <a href="javascript:void(0);" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">` +data.level+ `</a> <i class="flaticon2-correct text-success font-size-h5"></i>
                                    </div>
                                </div>
                                <!--end::Title-->
                                <!--begin::Content-->
                                <div class="d-flex flex-wrap justify-content-between mt-1">
                                    <div class="d-flex flex-column flex-grow-1 pr-8">
                                        <div class="d-flex flex-wrap mb-4">
                                            <a href="javascript:void(0);" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-user mr-2 font-size-lg"></i>` +data.nama+ `</a>
                                            <a href="javascript:void(0);" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-new-email mr-2 font-size-lg"></i>` +data.email+ `</a>
                                            <a href="javascript:void(0);" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="fab la-buffer mr-2 font-size-lg"></i>` +data.unit_kerja+ `</a>
                                        </div>
                                        <span class="font-weight-bold text-dark-50"><i class="flaticon-placeholder-2 mr-2 font-size-lg"></i>` +data.alamat+ `</span>
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Info-->
                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </div>`;
            $('#userInfoWidget').html(userInfo);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Load data error!');
        }
    });
}
//Class Definition
function _loadFirstWidget() {
    //Load Firts Counter
    $.ajax({
		url: BASE_URL+ "/app_admin/ajax_get_count_widget",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var widgetDiv1 = `<div class="col-xl-4 col-md-6">
                <a href="javascript:void(0);">
                    <!--begin::Stats Widget 10-->
                    <div class="card card-custom card-stretch gutter-b shadow-md bg-primary">
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                <span class="symbol symbol-50 symbol-light-primary mr-2">
                                    <span class="symbol-label">
                                        <i class="bi bi-people-fill icon-2x text-primary"></i>
                                    </span>
                                </span>
                                <div class="d-flex flex-column text-right text-light">
                                    <span class="font-weight-bolder font-size-h3">` +data.jmlh_taruna+ `</span>
                                    <span class="font-weight-bold mt-2">JUMLAH TARUNA</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 10-->
                </a>
            </div>
            <div class="col-xl-4 col-md-6">
                <a href="javascript:void(0);">
                    <!--begin::Stats Widget 10-->
                    <div class="card card-custom card-stretch gutter-b shadow-md bg-info">
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                <span class="symbol symbol-50 symbol-light-info mr-2">
                                    <span class="symbol-label">
                                        <i class="fa fa-male icon-2x text-info"></i>
                                    </span>
                                </span>
                                <div class="d-flex flex-column text-right text-light">
                                    <span class="font-weight-bolder font-size-h3">` +data.jmlh_taruna_p+ `</span>
                                    <span class="font-weight-bold mt-2">TARUNA LAKI-LAKI</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 10-->
                </a>
            </div>
            <div class="col-xl-4 col-md-6">
                <a href="javascript:void(0);">
                    <!--begin::Stats Widget 10-->
                    <div class="card card-custom card-stretch gutter-b shadow-md bg-success">
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                <span class="symbol symbol-50 symbol-light-success mr-2">
                                    <span class="symbol-label">
                                        <i class="fa fa-female icon-2x text-success"></i>
                                    </span>
                                </span>
                                <div class="d-flex flex-column text-right text-light">
                                    <span class="font-weight-bolder font-size-h3">` +data.jmlh_taruna_l+ `</span>
                                    <span class="font-weight-bold mt-2">TARUNA WANITA</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 10-->
                </a>
            </div>`;
            $('#firstWidget').html(widgetDiv1);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('load data is error!');
		}
	});
}
// for trend trecking data for 1 month
const _loadTrendTreckingTaruna = () => {
    var optionsChart1 = {
        series: [],
        chart: {
        height: 350,
        type: 'area',
        zoom: {
            enabled: false
        }
      },
      dataLabels: {
        enabled: true,
        textAnchor: 'start',
        formatter: function(val, opt) { 
        return val
            // return opt.w.globals.categoryLabels[opt.seriesIndex]
        },
        offsetX: 0,
      },
      stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        colors: undefined,
        width: 2,
        dashArray: 0,
      },
        title: {
            text: '',
            align: 'center'
        },
        grid: {
            row: {
            colors: ['#FFFFFF'], // takes an array which will be repeated on columns
            opacity: 0.5
            },
        },
      xaxis: {
        categories: [],
        title: {
            text: 'TANGGAL'
        }
      },
      yaxis: {
        title: {
            text: 'JUMLAH TRACKER'
            }
        },
      fill: {
            opacity: 1
        },
      tooltip: {
            y: {
                formatter: function (val) {
                    return val
                }
            }
        },
    };
    var chart1 = new ApexCharts(document.querySelector("#trend-trecking-data"), optionsChart1);
    chart1.render();
    $.ajax({
        url: BASE_URL+ "/app_admin/load_trend_tracker",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            chart1.updateOptions({
                series: [{
                    name: 'JUMLAH TRACKER',
                    data: data.dataViews,
                }],
                xaxis: {
                        categories: data.dateViews,
                },
                title: {
                    text: 'TREND JUMLAH JUMLAH PENCARI DATA BULAN '+ data.monthYear,
                },
            });
        }, error: function (jqXHR, textStatus, errorThrown) {
            console.log('Load data is error');
        }
    });
}

//Class Initialization
jQuery(document).ready(function() {
    load_init(), _loadFirstWidget(), _loadTrendTreckingTaruna();
});