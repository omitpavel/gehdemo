@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Leaflet Dashboard')
@section('page-top-title', 'Leaflet Dashboard')
@section('page-top-title-sub', 'autotimer')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/LeafletVirtualWard.css') }}" crossorigin="anonymous">
@endpush
@section('content')
    <div class="container-fluid refresh-content">
    </div>

@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var ajax_refresh_url = "{{ url('/inpatients/report/leaflet-page-refresh') }}";
    </script>

<script>
    $( document ).ready(function()
    {
        $('.page-data-loader').show();
        var url = "{{ route('leaflet.page.refresh') }}";
        $.ajax({
            _token:tok,
            url: url,
            type: 'GET',
            success: function (result)
            {
                if(result != ''){
                    $('.refresh-content').html(result);
                    $('.page-data-loader').hide();
                } else {
                    $('.page-data-loader').hide();
                }

            }
        });
    });
</script>

    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

@endsection
