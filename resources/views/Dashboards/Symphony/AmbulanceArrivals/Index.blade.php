@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Ambulance Analytics')
@section('page-top-title', 'Ambulance Analytics')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/AmbulanceDashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/AmbulanceDashboard.css') }}" />
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/ApexCharts.js') }}"></script>
    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/AmbulanceArrivalsApexGraphBasicSettings.js') }}" charset="utf-8"></script>
@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Symphony.AmbulanceArrivals.Modals')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
        @include('Dashboards.Symphony.AmbulanceArrivals.IndexDataLoad')
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
        var check_third_tab_switch = 0;
        var check_fourth_tab_switch = 0;

        var check_first_tab_loading = 0;
        var check_second_tab_loading = 0;
        var check_third_tab_loading = 0;
        var check_fourth_tab_loading = 0;

        function CommonJsFunctionCallAfterContentRefersh() {
            check_first_tab_switch = 1;
            setTimeout(function() {
                check_first_tab_switch = 0;
            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
            setTimeout(function() {
                $('.all_tab_content_loader_image_1').hide();


                if (typeof AmbulanceDataC3GraphReloadOnPageRefreshTabOne == 'function') {
                    AmbulanceDataC3GraphReloadOnPageRefreshTabOne();
                }
            }, 1000);
        }
        jQuery(document).ready(function($) {

            $(document).on("click", "#day_summary_tab, #day_summary_tab_reponsive", function(e) {
                if (check_first_tab_switch == 0) {
                    if (check_first_tab_loading == 0) {
                        check_first_tab_switch = 1;
                        setTimeout(function() {
                            check_first_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        var filter_value = $('.ambulance_tab_1_date_selected').val();
                        AmbulanceDashboardDaySummaryDataLoad(filter_value);
                    }
                } else {
                    if (check_first_tab_loading == 0) {
                        $('.all_tab_content_loader_image_1').show();
                        setTimeout(function() {
                            if (typeof AmbulanceDataC3GraphReloadOnPageRefreshTabOne ==
                                'function') {
                                AmbulanceDataC3GraphReloadOnPageRefreshTabOne();
                            }
                            $('.all_tab_content_loader_image_1').hide();
                        }, 500);
                    }
                }
            });
            $(document).on("click", "#week_summary_tab, #week_summary_tab_reponsive", function(e) {
                if (check_second_tab_switch == 0) {
                    if (check_second_tab_loading == 0) {
                        check_second_tab_switch = 1;
                        setTimeout(function() {
                            check_second_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        var filter_value = $('#start_date_week_summary').val();
                        AmbulanceDashboardWeekSummaryDataLoad(filter_value);
                    }
                } else {
                    if (check_second_tab_loading == 0) {
                        $('.all_tab_content_loader_image_2').show();
                        setTimeout(function() {

                            if (typeof AmbulanceDataC3GraphReloadOnPageRefreshTabTwo ==
                                'function') {
                                AmbulanceDataC3GraphReloadOnPageRefreshTabTwo();
                            }

                            $('.all_tab_content_loader_image_2').hide();
                        }, 500);
                    }
                }
            });
            $(document).on("click", "#month_summary_tab, #month_summary_tab_reponsive", function(e) {
                if (check_third_tab_switch == 0) {
                    if (check_third_tab_loading == 0) {
                        check_third_tab_switch = 1;
                        setTimeout(function() {
                            check_third_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        var filter_value = $('#start_date_month_summary').val();
                        AmbulanceDashboardMonthSummaryDataLoad(filter_value);
                    }
                } else {

                    if (check_third_tab_loading == 0) {
                        $('.all_tab_content_loader_image_3').show();
                        setTimeout(function() {
                            if (typeof AmbulanceDataC3GraphReloadOnPageRefreshTabThree ==
                                'function') {
                                AmbulanceDataC3GraphReloadOnPageRefreshTabThree();
                            }
                            $('.all_tab_content_loader_image_3').hide();
                        }, 500);
                    }
                }
            });
            $(document).on("click", "#last_thousand_summary_tab, #last_thousand_summary_tab_reponsive", function(e) {
                if (check_fourth_tab_switch == 0) {
                    if (check_fourth_tab_loading == 0) {
                        check_fourth_tab_switch = 1;
                        setTimeout(function() {
                            check_fourth_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        AmbulanceDashboardLastThousandSummaryDataLoad('');
                    }
                } else {
                    if (check_fourth_tab_loading == 0) {
                        $('.all_tab_content_loader_image_4').show();
                        setTimeout(function() {
                            if (typeof AmbulanceDataC3GraphReloadOnPageRefreshTabFour ==
                                'function') {
                                AmbulanceDataC3GraphReloadOnPageRefreshTabFour();
                            }
                            $('.all_tab_content_loader_image_4').hide();
                        }, 500);
                    }
                }
            });
            $(document).on('click', '#start_date_day_summary', function() {
                var filter_value = $('#ambulance_tab_1_date_selected').val();
                AmbulanceDashboardDaySummaryDataLoad(filter_value);
            });
            $(document).on('change', '#start_date_week_summary', function() {
                var filter_value = $('#start_date_week_summary').val();
                AmbulanceDashboardWeekSummaryDataLoad(filter_value);
            });
            $(document).on('change', '#start_date_month_summary', function() {
                var filter_value = $('#start_date_month_summary').val();
                AmbulanceDashboardMonthSummaryDataLoad(filter_value);
            });
        });

        function AmbulanceDashboardDaySummaryDataLoad(filter_value) {
            if (typeof AmbulanceArrivalApexChartDestroyTab1 == "function") {
                AmbulanceArrivalApexChartDestroyTab1();
            }
            $('.all_tab_content_loader_image_1').show();
            $('.day_summary_tab_content_data_load').hide();
            $('.day_summary_tab_content_data_load').html('');
            check_first_tab_loading = 1;
            $.ajax({
                url: "{{ url('/ane/dashboards/ambulance-arrivals/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 1,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        $('.day_summary_tab_content_data_load').show();
                        check_first_tab_loading = 0;

                        $('.day_summary_tab_content_data_load').html(page_load_data);
                        $('.all_tab_content_loader_image_1').hide();


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

        function AmbulanceDashboardWeekSummaryDataLoad(filter_value) {

            if (typeof AmbulanceArrivalApexChartDestroyTab2 == "function") {
                AmbulanceArrivalApexChartDestroyTab2();
            }
            check_second_tab_loading = 1;
            $('.all_tab_content_loader_image_2').show();
            $('.week_summary_tab_content_data_load').hide();
            $('.week_summary_tab_content_data_load').html('');
            $.ajax({
                url: "{{ url('/ane/dashboards/ambulance-arrivals/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 2,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        $('.week_summary_tab_content_data_load').show();
                        check_second_tab_loading = 0;

                        $('.week_summary_tab_content_data_load').html(page_load_data);
                        $('.all_tab_content_loader_image_2').hide();
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


        function AmbulanceDashboardMonthSummaryDataLoad(filter_value) {
            if (typeof AmbulanceArrivalApexChartDestroyTab3 == "function") {
                AmbulanceArrivalApexChartDestroyTab3();
            }
            check_third_tab_loading = 1;
            $('.all_tab_content_loader_image_3').show();
            $('.month_summary_tab_content_data_load').hide();
            $('.month_summary_tab_content_data_load').html('');
            $.ajax({
                url: "{{ url('/ane/dashboards/ambulance-arrivals/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 3,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_third_tab_loading = 0;
                        $('.month_summary_tab_content_data_load').show();
                        $('.month_summary_tab_content_data_load').html(page_load_data);
                        $('.all_tab_content_loader_image_3').hide();
                    } else {
                        check_third_tab_loading = 0;
                        $('.all_tab_content_loader_image_3').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    check_third_tab_loading = 0;
                    $('.all_tab_content_loader_image_3').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }


        function AmbulanceDashboardLastThousandSummaryDataLoad(filter_value) {
            check_fourth_tab_loading = 1;
            $('.all_tab_content_loader_image_4').show();
            $('.last_thousand_summary_tab_content_data_load').hide();
            $('.last_thousand_summary_tab_content_data_load').html('');
            $.ajax({
                url: "{{ url('/ane/dashboards/ambulance-arrivals/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 4,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        $('.last_thousand_summary_tab_content_data_load').show();
                        check_fourth_tab_loading = 0;
                        $('.last_thousand_summary_tab_content_data_load').html(page_load_data);
                        $('.all_tab_content_loader_image_4').hide();
                    } else {
                        check_fourth_tab_loading = 0;
                        $('.all_tab_content_loader_image_4').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    check_fourth_tab_loading = 0;
                    $('.all_tab_content_loader_image_4').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }

        @if(CheckSpecificPermission('ambulance_dashboard_live_view'))
            $(document).ready(function() {
                AmbulanceDashboardDaySummaryDataLoad('');
            });
        @elseif(CheckSpecificPermission('ambulance_dashboard_week_to_date_view'))

            $(document).ready(function() {
                $('#week_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#week_summary_tab'));
                myTabs.show();
            });

        @elseif(CheckSpecificPermission('ambulance_dashboard_last_four_week_view'))
            $(document).ready(function() {
                $('#month_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#month_summary_tab'));
                myTabs.show();
            });
        @elseif(CheckSpecificPermission('ambulance_dashboard_last_thousand_arrival_view'))
            $(document).ready(function() {
                $('#last_thousand_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#last_thousand_summary_tab'));
                myTabs.show();
            });
        @endif
    </script>

    <script type="text/javascript" src="{{ url('asset_v2/Generic/Js/EasyPieChart.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}" charset="utf-8"></script>
@endpush
