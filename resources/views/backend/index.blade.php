@extends('backend.layouts', ['activeMenu' => 'DASHBOARD', 'activeSubMenu' => '', 'title' => 'Dahsboard'])
@section('content')
<div class="container">
    <!--End::Begin-->
    <div class="row" id="userInfoWidget">
        
    </div>
    <!--End::Row-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-custom">
                <div class="card-body">
                    <div id="trend-trecking-data"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script type="text/javascript" src="{{ asset('script/backend/dashboard.js') }}"></script>
@stop
@endsection
