<!DOCTYPE html>
<html lang="en">
<head>
    @include('Layouts.Common.MasterLayoutMetaData')
    <title>@yield('page-title')</title>
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/JqueryUi.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCommonStyles.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/css/bootstrap.min.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/icons/font/bootstrap-icons.css') }}" crossorigin="anonymous" />
  
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCustomStyles.css') }}" crossorigin="anonymous" />
    
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/modal-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Normalise.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/style.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Selectric.css') }}" crossorigin="anonymous">
    @stack('custom-style')
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/Jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryUi.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryMigrate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JquerySelectric.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/popper.min.js') }}"></script>
</head>

<body>
   
    <div class="loader-bg hide-on-first-load">
        <span class="screen-center"></span>
    </div>
    <div class="page-data-loader"></div>
    <div class="page-loader"></div>
    @include('Layouts.Common.MasterLayoutHeader')
    <div class="container-fluid page-body-wrapper">
       
        <div class="main-panel" id="content">
            @include('Layouts.Common.MasterLayoutTopbar')
            @yield('content')
        </div>
    </div>
    @section('footer')
        @include('Layouts.Common.MasterLayoutFooter')
        @include('Common.Scripts.FooterScripts')
        <!-- ///////////////////ibox Scripts//////////////////// -->
        <script src="{{ asset('asset_v2/Template/js/script.js') }}"></script>
        <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxCommonScript.js') }}"></script>
        @stack('custom-script')
    @show
</body>
</html>
