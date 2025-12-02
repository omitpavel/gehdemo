@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Referral To Speciality')
@section('page-top-title', 'Referral To Speciality')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/C3.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/AneReferralSpecialityPageStyle.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/SpecialityRefferal.css') }}" />
    <style>

    </style>
    <script src="{{ url('asset_v2/Generic/Js/HighCharts.js') }}" charset="utf-8"></script>
    <script src="{{ url('asset_v2/Generic/Js/HighChartsMore.js') }}" charset="utf-8"></script>
    <script src="{{ url('asset_v2/Generic/Js/HighChartDrawBoxPlot.js') }}" charset="utf-8"></script>
@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <div class="container-fluid refresh-content" style='display:block !important'>
        @include('Dashboards.Symphony.ReferralToSpeciality.IndexDataLoad')
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

        var check_first_tab_loading = 0;
        var check_second_tab_loading = 0;
        var check_third_tab_loading = 0;

        function CommonJsFunctionCallAfterContentRefersh() {
            check_first_tab_switch = 1;
            setTimeout(function() {


                $('.all_tab_content_loader_image_1').hide();
                check_first_tab_switch = 0;
            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
            $('.week_summary_tab_content_data_load').show();
            $('.all_tab_content_loader_image_1').hide();
            if (!$('#data_summary_filter_1').hasClass('selectric-initialized')) {
                // Add a delay to ensure the content is fully rendered
                setTimeout(function() {
                    $('#data_summary_filter_1').selectric();
                }, 100);
            }

        }
        jQuery(document).ready(function($) {
            $('.loader-bg hide-on-first-load').hide();
            $(document).on("click", "#week_summary_tab, #week_summary_tab_reponsive", function(e) {
                if (check_first_tab_switch == 0) {
                    if (check_first_tab_loading == 0) {
                        check_first_tab_switch = 1;
                        setTimeout(function() {
                            check_first_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        var filter_value = $('#data_summary_filter_1').val();
                        WeekSummaryReferralSpecialityDataLoad(filter_value);
                    }
                } else {

                    if (check_first_tab_loading == 0) {
                        $('.all_tab_content_loader_image_1').show();
                        setTimeout(function() {

                            $('.all_tab_content_loader_image_1').hide();
                        }, 500);
                    }
                }
            });
            $(document).on("click", "#month_summary_tab, #month_summary_tab_reponsive", function(e) {
                if (check_second_tab_switch == 0) {

                    if (check_second_tab_loading == 0) {
                        check_second_tab_switch = 1;
                        setTimeout(function() {
                            check_second_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        var filter_value = $('#data_summary_filter_2').val();
                        MonthSummaryReferralSpecialityDataLoad(filter_value);
                    }
                } else {

                    if (check_second_tab_loading == 0) {
                        $('.all_tab_content_loader_image_2').show();
                        setTimeout(function() {

                            $('.all_tab_content_loader_image_2').hide();
                        }, 500);
                    }
                }
            });
            $(document).on("click", "#last_thousand_summary_tab, #last_thousand_summary_tab_reponsive", function(
                e) {
                if (check_third_tab_switch == 0) {
                    if (check_third_tab_loading == 0) {
                        check_third_tab_switch = 1;
                        setTimeout(function() {
                            check_third_tab_switch = 0;
                        }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                        LastThousandSummaryReferralSpecialityDataLoad('');
                    }
                } else {

                    if (check_third_tab_loading == 0) {
                        $('.all_tab_content_loader_image_3').show();
                        setTimeout(function() {

                            $('.all_tab_content_loader_image_3').hide();
                        }, 500);
                    }
                }
            });
            $(document).on('change', '#data_summary_filter_1', function() {
                var filter_value = $('#data_summary_filter_1').val();
                WeekSummaryReferralSpecialityDataLoad(filter_value);
            });
            $(document).on('change', '#data_summary_filter_2', function() {
                var filter_value = $('#data_summary_filter_2').val();
                MonthSummaryReferralSpecialityDataLoad(filter_value);
            });
        });

        function WeekSummaryReferralSpecialityDataLoad(filter_value) {

            $('.all_tab_content_loader_image_1').show();
            $('.week_summary_tab_content_data_load').hide();
            $('.week_summary_tab_content_data_load').html('');
            check_first_tab_loading = 1;

            $.ajax({
                url: "{{ url('/ane/dashboards/referral-to-speciality/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "filter_mode": 1,
                },
                success: function(page_load_data) {
                    if (page_load_data != '{{ PermissionDenied() }}') {
                        check_first_tab_loading = 0;
                        $('.week_summary_tab_content_data_load').show();

                        $('.week_summary_tab_content_data_load').html(page_load_data);
                        $('.all_tab_content_loader_image_1').hide();
                        if (!$('#data_summary_filter_1').hasClass('selectric-initialized')) {
                            // Add a delay to ensure the content is fully rendered
                            setTimeout(function() {
                                $('#data_summary_filter_1').selectric();
                            }, 100);
                        }
                    } else {
                        check_first_tab_loading = 0;
                        $('.all_tab_content_loader_image_1').hide();
                        $('#permission_modal').modal({
                            backdrop: 'static'
                        });
                    }
                },
                error: function(textStatus, errorThrown) {
                    check_first_tab_loading = 0;
                    $('.all_tab_content_loader_image_1').hide();
                    $('#common_error_modal_show').modal({
                        backdrop: 'static'
                    });
                }
            });


        }

        function MonthSummaryReferralSpecialityDataLoad(filter_value) {
            $('.all_tab_content_loader_image_2').show();
            $('.month_summary_tab_content_data_load').hide();
            $('.month_summary_tab_content_data_load').html('');
            check_second_tab_loading = 1;

            $.ajax({
                url: "{{ url('/ane/dashboards/referral-to-speciality/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "filter_mode": 2,
                },
                success: function(page_load_data) {
                    if (page_load_data != '{{ PermissionDenied() }}') {
                        check_second_tab_loading = 0;
                        $('.month_summary_tab_content_data_load').show();

                        $('.month_summary_tab_content_data_load').html(page_load_data);
                        $('.all_tab_content_loader_image_2').hide();
                        if (!$('#data_summary_filter_2').hasClass('selectric-initialized')) {
                            // Add a delay to ensure the content is fully rendered
                            setTimeout(function() {
                                $('#data_summary_filter_2').selectric();
                            }, 100);
                        }
                    } else {
                        check_second_tab_loading = 0;
                        $('.all_tab_content_loader_image_2').hide();
                        $('#permission_modal').modal({
                            backdrop: 'static'
                        });
                    }
                },
                error: function(textStatus, errorThrown) {
                    check_second_tab_loading = 0;
                    $('.all_tab_content_loader_image_2').hide();
                    $('#common_error_modal_show').modal({
                        backdrop: 'static'
                    });
                }
            });


        }

        function LastThousandSummaryReferralSpecialityDataLoad(filter_value) {
            $('.all_tab_content_loader_image_3').show();
            $('.last_thousand_summary_tab_content_data_load').hide();
            $('.last_thousand_summary_tab_content_data_load').html('');
            check_third_tab_loading = 1;


            $.ajax({
                url: "{{ url('/ane/dashboards/referral-to-speciality/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "filter_mode": 3,
                },
                success: function(page_load_data) {
                    if (page_load_data != '{{ PermissionDenied() }}') {
                        check_third_tab_loading = 0;
                        $('.last_thousand_summary_tab_content_data_load').show();
                        $('.last_thousand_summary_tab_content_data_load').html(page_load_data);
                        $('.all_tab_content_loader_image_3').hide();

                    } else {
                        check_third_tab_loading = 0;
                        $('.all_tab_content_loader_image_3').hide();
                        $('#permission_modal').modal({
                            backdrop: 'static'
                        });
                    }
                },
                error: function(textStatus, errorThrown) {
                    check_third_tab_loading = 0;
                    $('.all_tab_content_loader_image_3').hide();
                    $('#common_error_modal_show').modal({
                        backdrop: 'static'
                    });
                }
            });


        }
        @if (CheckSpecificPermission('referral_to_speciality_week_view'))
            $(document).ready(function() {
                $('#week_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#week_summary_tab'));
                myTabs.show();

                var filter_value = $('#data_summary_filter_1').val();
                WeekSummaryReferralSpecialityDataLoad('{{ \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d') }}');
            });
        @elseif (CheckSpecificPermission('referral_to_speciality_month_view'))

            $(document).ready(function() {
                $('#month_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#month_summary_tab'));
                myTabs.show();
            });
        @elseif (CheckSpecificPermission('referral_to_speciality_last_1000_view'))

            $(document).ready(function() {
                $('#last_thousand_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#last_thousand_summary_tab'));
                myTabs.show();
            });
        @endif
    </script>
@endpush
