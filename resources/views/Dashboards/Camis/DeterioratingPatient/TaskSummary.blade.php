@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Deteriorating Patients Summary')
@section('page-top-title', 'Deteriorating Patients Summary')
@section('page-top-title-sub', 'autotimer')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/billboard.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DeterioratingSummary.css') }}" crossorigin="anonymous">
    <script src="{{ asset('asset_v2/Template/js/ApexCharts.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/d3.v7.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/billboard.js') }}"></script>
@endsection

@section('modal')

@endsection
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
        var tok = "{{ csrf_token() }}";
        $( document ).ready(function()
        {
            var ward_id = $('#ward_id').val();
            var month = $('#month').val();
            var ajax_refresh_url = '{{ route('task_summary.filter') }}?ward_id='+ward_id+'&month='+month;
            function CommonJsFunctionCallAfterContentRefersh(){
                MultiSelectJs('ward_id', 'Ward');
            }
        });
    </script>

    <script>

        function DataPageLoad(ward_id, date_value){
            @if(CheckSpecificPermission('dp_dashboard_summary_view'))
                $('.page-data-loader').show();

                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: 'get',
                    url: '{{ route('task_summary.filter') }}',
                    data: {
                        '_token': token,
                        'ward_id': ward_id,
                        'month': date_value
                    },
                    success(result) {

                        $('.refresh-content').html(result);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.page-data-loader').hide();

                    },
                    error: function(status, err){
                        toastr.warning('Something Went Wrong');
                        $('.page-data-loader').hide();
                    }
                })
            @else
                PermissionDeniedAlert();
            @endif
        };
        $( document ).ready(function()
        {
            var ward_id = $('#ward_id').val();
            var date_value = $('#month').val();
            DataPageLoad(ward_id, date_value);
        });
        $(document).on("change", "#ward_id, #month", function(e) {
            var ward_id         = $('#ward_id').val();
            var date_value          = $('#month').val();
            DataPageLoad(ward_id, date_value);
        });
    </script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

@endsection
