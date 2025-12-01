@extends('Layouts.Common.MasterLayout')
@section('page-title', 'ED Overview')
@section('page-top-title', 'ED Overview')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/EDOverview.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/EdOverview.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/C3.css') }}" crossorigin="anonymous">
    <script src="{{ asset('asset_v2/Generic/Js/HighCharts.js') }}" charset="utf-8"></script>
    <script src="{{ asset('asset_v2/Generic/Js/HighChartsMore.js') }}" charset="utf-8"></script>
    <script src="{{ asset('asset_v2/Generic/Js/HighChartDrawBoxPlot.js') }}" charset="utf-8"></script>
    <script src="{{ asset('asset_v2/Generic/Js/PlotlyLatest.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/ApexCharts.js') }}"></script>

    <style>
        .attendanceTableWrap .attendTableRow .attendanceTableBodyFirstClm .cell {
            min-height: 33px;
        }
    </style>
@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Symphony.EDOverview.Modals')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
        @include('Dashboards.Symphony.EDOverview.IndexDataLoad')
    </div>
@endsection
@push('custom-script')
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";
        var ajax_refresh_url = "";
        var check_first_tab_switch = 0;
        var check_second_tab_switch = 0;
        var check_first_tab_loading = 0;
        var check_second_tab_loading = 0;

        function CommonJsFunctionCallAfterContentRefersh() {
            check_first_tab_switch = 1;
            setTimeout(function() {
                $('.live_summary_tab_content_data_load').show();
                $('.all_tab_content_loader_image_1').hide();
                GroupBoxPlotRerenderDataLoad();
            }, 1000);
            check_first_tab_switch = 1;
            setTimeout(function() {
                check_first_tab_switch = 0;
            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
        }

        function GroupBoxPlotRerenderDataLoad() {
            if (typeof EdOverviewLoadAfterScriptGraphLive == "function") {
                EdOverviewLoadAfterScriptGraphLive();
            }
            if (typeof EdOverviewLoadAfterScriptGraphDaySummary == "function") {
                EdOverviewLoadAfterScriptGraphDaySummary();
            }
        }

        jQuery(document).ready(function($) {
            $(document).on("click", "#live_summary_tab, #live_summary_tab_reponsive", function(e) {
                if (check_first_tab_switch == 0) {
                    if (check_first_tab_loading == 0) {
                        check_first_tab_switch = 1;
                        setTimeout(function() {
                            check_first_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        EdOverviewDashboardLiveDataSummaryDataLoad('');

                    }
                } else {
                    if (check_first_tab_loading == 0) {
                        $('.all_tab_content_loader_image_1').show();
                        setTimeout(function() {
                            $('.all_tab_content_loader_image_1').hide();
                            GroupBoxPlotRerenderDataLoad();
                        }, 500);
                    }
                }
            });
            $(document).on("click", "#day_summary_tab, #day_summary_tab_reponsive", function(e) {
                if (check_second_tab_switch == 0) {
                    if (check_second_tab_loading == 0) {
                        check_second_tab_switch = 1;
                        setTimeout(function() {
                            check_second_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        var filter_value = $('#start_date_day_summary_val').val();
                        EdOverviewDashboardDaySummaryDataLoad(filter_value);
                    }
                } else {
                    if (check_second_tab_loading == 0) {
                        $('.all_tab_content_loader_image_2').show();
                        setTimeout(function() {
                            $('.all_tab_content_loader_image_2').hide();
                            GroupBoxPlotRerenderDataLoad();
                        }, 500);
                    }
                }
            });
            $(document).on('click', '.ed_overview_day_summary_search', function() {
                var filter_value = $('#start_date_day_summary_val').val();
                EdOverviewDashboardDaySummaryDataLoad(filter_value);
            });

            $(document).on('click', '.summary_data_load_of_ed_overview_tab_1', function() {
                var filter_value = '';
                var referral_type = $(this).data('spec-click-ajax-load');
                $('#content_load_summary_data_load_of_ed_overview_tab_1').html('<div class="modal-screen-center  "></div>');
                $.ajax({
                    url: "{{ url('/ane/dashboards/ed-overview/summary-speciality-specific-data') }}",
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "filter_value": filter_value,
                        "referral_type": referral_type,
                        "tab_filter_mode": 1,
                    },
                    success: function(page_load_data) {
                        $('#content_load_summary_data_load_of_ed_overview_tab_1').html(page_load_data);
                        GroupBoxPlotRerenderDataLoad();
                    },
                    error: function(textStatus, errorThrown) {
                        $('.all_tab_content_loader_image').hide();
                        CommonErrorModalPopupOpen();
                    }
                });
            });


            $(document).on('click', '.summary_data_load_of_ed_overview_tab_2', function() {
                var filter_value = $('#start_date_day_summary_val').val();
                var referral_type = $(this).data('spec-click-ajax-load');
                $('#content_load_summary_data_load_of_ed_overview_tab_2').html('<div class="modal-screen-center  "></div>');
                $.ajax({
                    url: "{{ url('/ane/dashboards/ed-overview/summary-speciality-specific-data') }}",
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "filter_value": filter_value,
                        "referral_type": referral_type,
                        "tab_filter_mode": 2,
                    },
                    success: function(page_load_data) {
                        $('#content_load_summary_data_load_of_ed_overview_tab_2').html(page_load_data);
                        GroupBoxPlotRerenderDataLoad();
                    },
                    error: function(textStatus, errorThrown) {
                        $('.all_tab_content_loader_image').hide();
                        CommonErrorModalPopupOpen();
                    }
                });
            });
        });


        function EdOverviewDashboardLiveDataSummaryDataLoad(filter_value) {
            $('.all_tab_content_loader_image_1').show();
            $('.live_summary_tab_content_data_load').hide();
            $('.live_summary_tab_content_data_load').html('');
            check_first_tab_loading = 1;
            $.ajax({
                url: "{{ url('/ane/dashboards/ed-overview/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": '',
                    "tab_filter_mode": 1,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_first_tab_loading = 0;
                        $('.live_summary_tab_content_data_load').show();
                        $('.live_summary_tab_content_data_load').html(page_load_data);
                        setTimeout(function() {
                            $('.all_tab_content_loader_image_1').hide();
                            GroupBoxPlotRerenderDataLoad();
                        }, 500);
                    } else {
                        check_first_tab_loading = 0;
                        $('.all_tab_content_loader_image_1').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    check_first_tab_loading = 0;
                    $('.all_tab_content_loader_image_1').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }

        function EdOverviewDashboardDaySummaryDataLoad(filter_value) {
            check_second_tab_loading = 1;
            GroupBoxPlotRerenderDataLoad();
            $('.all_tab_content_loader_image_2').show();
            $('.day_summary_tab_content_data_load').hide();
            $('.day_summary_tab_content_data_load').html('');
            $.ajax({
                url: "{{ url('/ane/dashboards/ed-overview/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 2,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_second_tab_loading = 0;
                        $('.day_summary_tab_content_data_load').show();
                        $('.day_summary_tab_content_data_load').html(page_load_data);
                        setTimeout(function() {
                            $('.all_tab_content_loader_image_2').hide();
                            GroupBoxPlotRerenderDataLoad();

                        }, 500);
                    } else {
                        check_second_tab_loading = 0;
                        $('.all_tab_content_loader_image_2').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    check_second_tab_loading = 0;
                    $('.all_tab_content_loader_image_2').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }

        @if(CheckSpecificPermission('ed_live_summary_view'))
            $(document).ready(function() {
                $('#live_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#live_summary_tab'));
                myTabs.show();
            });
        @elseif(CheckSpecificPermission('ed_day_summary_view'))

            $(document).ready(function() {
                $('#day_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#day_summary_tab'));
                myTabs.show();
            });

        @endif
    </script>
    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
@endpush
