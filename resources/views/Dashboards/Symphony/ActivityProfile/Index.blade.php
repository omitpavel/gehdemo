@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Activity Profile')
@section('page-top-title', 'Activity Profile')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/billboard.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/EDActivityStyle.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/EdActivity.css') }}" />
@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
        <div class="col-lg-12  ">
            <div class="loader-bg-inside-content all_tab_content_loader_image">
                <span class="screen-center"></span>
            </div>
            <div class="ed_activity_content_data_load"></div>
        </div>
    </div>
@endsection
@push('custom-script')
    <!-- Load d3.js and c3.js -->
    <script>
        $('.page-loader').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";
        var ajax_refresh_url = "";

        function CommonJsFunctionCallAfterContentRefersh() {
            EdActivityDataLoad('');
        }

        function EdActivityDataLoad(filter_value_start, filter_value_end) {
            if (typeof EdActivityChartApexChartDestroy == "function") {
                EdActivityChartApexChartDestroy();
            }
            $('.all_tab_content_loader_image').show();
            $('.ed_activity_content_data_load').hide();
            $('.ed_activity_content_data_load').html('');
            $.ajax({
                url: "{{ url('/ane/dashboards/activity-profile/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value_start": filter_value_start,
                    "filter_value_end": filter_value_end,
                },
                success: function(page_load_data) {
                    $('.ed_activity_content_data_load').show();
                     $('.ed_activity_content_data_load').html(page_load_data);

                   EdActivityChartLoadAfterScriptGraph();

                    setTimeout(function() {


                          $('.all_tab_content_loader_image').hide();
                    }, 5000);
                },
                error: function(textStatus, errorThrown) {
                    $('.all_tab_content_loader_image').hide();
                    $('.ed_activity_content_data_load').html('');
                    CommonErrorModalPopupOpen();
                }
            });
        }


    </script>
    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/custom.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/ActivityProfile.js') }}" charset="utf-8"></script>

    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/ApexCharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/PlotlyLatest.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/EasyPieChart.js') }}" charset="utf-8"></script>
@endpush
