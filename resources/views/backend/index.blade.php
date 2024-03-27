@extends('backend.layouts', ['activeMenu' => 'DASHBOARD', 'activeSubMenu' => '', 'title' => 'Dahsboard'])
@section('content')
<div class="container">
    <!--Begin::user profile-->
    <div class="row" id="userInfoWidget"></div>
    <!--End::user profile-->
    <!--Begin::widget-->
    <div class="row mb-3" id="firstWidget">
        <div class="col-lg-4">
            <svg class="bd-placeholder-img rounded w-100 h-110px app-sidebar-logo-default" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                <rect width="100%" height="100%" fill="#868e96"></rect>
            </svg>
        </div>
        <div class="col-lg-4">
            <svg class="bd-placeholder-img rounded w-100 h-110px app-sidebar-logo-default" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                <rect width="100%" height="100%" fill="#868e96"></rect>
            </svg>
        </div>
        <div class="col-lg-4">
            <svg class="bd-placeholder-img rounded w-100 h-110px app-sidebar-logo-default" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                <rect width="100%" height="100%" fill="#868e96"></rect>
            </svg>
        </div>
    </div>
    <!--End::widget-->
    <!--Begin::trend tracker-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-custom">
                <div class="card-body">
                    <div id="trend-trecking-data"></div>
                </div>
            </div>
        </div>
    </div>
    <!--End::trend tracker-->
</div>
@section('js')
<script type="text/javascript" src="{{ asset('script/backend/dashboard.js') }}"></script>
@stop
@endsection
