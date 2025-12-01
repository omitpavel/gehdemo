@extends('Layouts.Common.MasterLayout')
@section('page-title', 'A&E Welcome Screen')
@section('page-top-title', 'A&E Welcome Screen')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WelcomeScreen.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/AneWelcomeScreenStyle.css') }}" crossorigin="anonymous">
@endpush
<style>
    .main-panel {
        min-height: 100vh;
    }
</style>
@section('content')
    <div class="container-fluid refresh-content" style='display:block !important'>
        @include('Dashboards.Symphony.EDHome.IndexDataLoad')
    </div>
@endsection
@push('custom-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var ajax_refresh_url = "{{ url('/ane/dashboards/ed-home/content-data-load') }}";
    </script>
    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
@endpush
