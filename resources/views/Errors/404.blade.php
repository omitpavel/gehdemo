@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Page Not Found')
@section('header')
    @push('custom-style')
        <link rel="stylesheet" type="text/css" href="{{ url('asset_v2/Ibox/Css/ErrorPageStyle.css') }}">
    @endpush
@section('content')
    <div class="container-fluid refresh-content">
        <h1>404</h1>
        <h2>Page Not Found!</h2>
        <h2>
            <p>
                <a class="errorpagebackbutton" href="javascript:void(0)" onclick="backhistory()" style="text-decoration: none;">Go Back </a>
            </p>
        </h2>
        <div class="gears">
            <div class="gear one">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="gear two">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="gear three">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @parent
    <script>
        $(function() {
            setTimeout(function() {
                $('body').removeClass('loading');
            }, 1000);
        });

        function backhistory() {
            history.back();
        }
    </script>
@endsection
