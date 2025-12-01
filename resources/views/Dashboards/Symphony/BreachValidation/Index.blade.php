@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Breach Validation Tool')
@section('page-top-title', 'Breach Validation Tool')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BreachValidation.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/BreachValidationCustom.css') }}" />
@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Symphony.BreachValidation.Modals')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
        @include('Dashboards.Symphony.BreachValidation.IndexDataLoad')
    </div>
@endsection
@push('custom-script')
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/ApexCharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/Chart.js') }}"></script>

    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/ChartGauge.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/d3.v7.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/EasyPieChart.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JquerySelectric.js') }}"></script>

    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/Chart.js') }}"></script>

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
        var check_fifth_tab_switch = 0;


        var check_first_tab_loading = 0;
        var check_second_tab_loading = 0;
        var check_third_tab_loading = 0;
        var check_fourth_tab_loading = 0;
        var check_fifth_tab_loading = 0;


        function CommonJsFunctionCallAfterContentRefersh() {
            check_first_tab_switch = 1;

            setTimeout(function() {
                $('.breach_list_tab_content_data_load').show();
                $('.all_tab_content_loader_image_1').hide();


            }, 1000);
            setTimeout(function() {
                check_first_tab_switch = 0;
            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
        }
        jQuery(document).ready(function($) {


            $(document).on("click", "#day_summary_tab", function(e) {
                @if(CheckSpecificPermission('breach_dashboard_view'))
                    if (check_second_tab_switch == 0) {
                        if (check_second_tab_loading == 0) {
                            check_second_tab_switch = 1;
                            setTimeout(function() {
                                check_second_tab_switch = 0;
                            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                            var filter_value = $('#breach_tab_2_date_selected').val();
                            DaySummaryBreachValidationDataLoad(filter_value);
                        }
                    } else {

                        if (check_second_tab_loading == 0) {
                            $('.all_tab_content_loader_image_2').show();
                            setTimeout(function() {

                                $('.all_tab_content_loader_image_2').hide();
                            }, 500);
                        }
                    }
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });
            $(document).on("click", "#week_summary_tab", function(e) {
                @if(CheckSpecificPermission('breach_weekly_dashboard_view'))
                    if (check_fifth_tab_switch == 0) {
                        if (check_fifth_tab_loading == 0) {
                            check_fifth_tab_switch = 1;
                            setTimeout(function() {
                                check_fifth_tab_switch = 0;
                            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                            var filter_value = $('#date_picker_tab_5').val();
                            WeekSummaryBreachValidationDataLoad(filter_value);
                        }
                    } else {

                        if (check_second_tab_loading == 0) {
                            $('.all_tab_content_loader_image_3').show();
                            setTimeout(function() {

                                $('.all_tab_content_loader_image_3').hide();
                            }, 500);
                        }
                    }
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });
            $(document).on("click", "#month_summary_tab", function(e) {
                @if(CheckSpecificPermission('breach_monthly_report_view'))
                    if (check_third_tab_switch == 0) {
                        if (check_third_tab_loading == 0) {
                            check_third_tab_switch = 1;
                            setTimeout(function() {
                                check_third_tab_switch = 0;
                            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                            var filter_value = $('#date_picker_tab_3').val();
                            MonthSummaryBreachValidationDataLoad(filter_value);
                        }
                    } else {

                        if (check_third_tab_loading == 0) {
                            $('.all_tab_content_loader_image_4').show();
                            setTimeout(function() {

                                $('.all_tab_content_loader_image_4').hide();
                            }, 500);
                        }
                    }
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });
            $(document).on("click", "#month_summary_overall_tab", function(e) {
                @if(CheckSpecificPermission('breach_monthly_report_view'))
                    if (check_fourth_tab_switch == 0) {
                        if (check_fourth_tab_loading == 0) {
                            check_fourth_tab_switch = 1;
                            setTimeout(function() {
                                check_fourth_tab_switch = 0;
                            }, <?php echo $success_array['ibox_tab_switch_refresh_time']; ?>);
                            var filter_value = $('#date_picker_tab_4').val();
                            MonthSummaryOverallBreachValidationDataLoad(filter_value);
                        }
                    } else {
                        if (check_fourth_tab_loading == 0) {
                            $('.all_tab_content_loader_image_5').show();
                            setTimeout(function() {

                                $('.all_tab_content_loader_image_5').hide();
                            }, 500);
                        }
                    }
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });


            $(document).on('click', '.breach_reason_dashboard_search', function() {
                @if(CheckSpecificPermission('breach_reason_view'))
                    var filter_value = $('#breach_tab_1_date_selected').val();
                    BreachValidationPatientListDataLoad(filter_value);
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });

            $(document).on('click', '.breach_day_summary_search', function() {
                @if(CheckSpecificPermission('breach_dashboard_view'))
                    var filter_value = $('#breach_tab_2_date_selected').val();
                    DaySummaryBreachValidationDataLoad(filter_value);
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });

            $(document).on('change', '#date_picker_tab_5', function() {
                @if(CheckSpecificPermission('breach_weekly_dashboard_view'))
                    var filter_value = $('#date_picker_tab_5').val();
                    WeekSummaryBreachValidationDataLoad(filter_value);
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });
            $(document).on('change', '#date_picker_tab_3', function() {
                @if(CheckSpecificPermission('breach_monthly_dashboard_view'))
                    var filter_value = $('#date_picker_tab_3').val();
                    MonthSummaryBreachValidationDataLoad(filter_value);
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });
            $(document).on('change', '#date_picker_tab_4', function() {
                @if(CheckSpecificPermission('breach_monthly_report_view'))
                    var filter_value = $('#date_picker_tab_4').val();
                    MonthSummaryOverallBreachValidationDataLoad(filter_value);
                @else
                    CommonLoginModalPopupOpenOnRequest();
                @endif
            });
            $(document).on('focus', '#date_picker_6_start_date', function() {
                $('#date_picker_6_start_date').attr("placeholder", "Select From Date");
                $('#date_picker_6_end_date').attr("placeholder", "Select To Date");

            });




            $(document).on('click', '.breach_data_export_list_search', function() {
                var filter_value_start_date = $('#date_picker_6_start_date').val();
                var filter_value_end_date = $('#date_picker_6_end_date').val();
                if (filter_value_start_date == '') {
                    $('#date_picker_6_start_date').datepicker('show');
                } else if (filter_value_end_date == '') {
                    $('#date_picker_6_end_date').datepicker('show');
                } else {
                    ExportBreachValidationPatientListDataLoad(filter_value_start_date, filter_value_end_date);
                }
            });



            $(document).on('click', '.breach_data_export_as_csv', function() {
                var filter_value_start_date = $('#breach_tab_6_start_date').val();
                var filter_value_end_date = $('#breach_tab_6_end_date').val();
                if (filter_value_start_date == '') {
                    $('#date_picker_6_start_date').datepicker('show');
                } else if (filter_value_end_date == '') {
                    $('#date_picker_6_end_date').datepicker('show');
                } else {
                    var t = "{{ url('ane/dashboards/breach-validation/breach-list-export-custom') }}?filter_value_start_date=" + filter_value_start_date + "&filter_value_end_date=" + filter_value_end_date;
                    $(this).attr("href", t);
                }
            });
        });

        function BreachValidationPatientListDataLoad(filter_value) {
            $('.all_tab_content_loader_image_1').show();
            $('.breach_list_tab_content_data_load').hide();
            check_first_tab_loading = 1;
            $.ajax({
                url: "{{ url('/ane/dashboards/breach-validation/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 1,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_first_tab_loading = 0;
                        $('.breach_list_tab_content_data_load').html(page_load_data);
                        $('.breach_list_tab_content_data_load').show();
                        $('.all_tab_content_loader_image_1').hide();


                    } else {
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


        function ExportBreachValidationPatientListDataLoad(filter_value_start_date, filter_value_end_date) {
            $('.all_tab_content_loader_image_6').show();
            $('.export_list_tab_content_data_load').hide();
            check_first_tab_loading = 1;
            $.ajax({
                url: "{{ url('/ane/dashboards/breach-validation/content-data-load-export') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value_start_date": filter_value_start_date,
                    "filter_value_end_date": filter_value_end_date,
                    "tab_filter_mode": 6,
                },
                success: function(page_load_data) {
                    check_first_tab_loading = 0;
                    $('.export_list_tab_content_data_load').show();
                    $('.export_list_tab_content_data_load').html(page_load_data);

                    $('.all_tab_content_loader_image_6').hide();

                    if ($("#date_picker_6_end_date").length > 0) {
                        $("#date_picker_6_end_date").datepicker({
                            format: "dd/mm/yyyy",
                            maxDate: new Date
                        });
                    } else {
                        $("#date_picker_6_end_date").datepicker();
                    }

                    if ($("#date_picker_6_start_date").length > 0) {
                        $("#date_picker_6_start_date").datepicker({
                            format: "dd/mm/yyyy",
                            maxDate: new Date
                        });
                    } else {
                        $("#date_picker_6_start_date").datepicker();
                    }
                },
                error: function(textStatus, errorThrown) {
                    check_first_tab_loading = 0;
                    $('.all_tab_content_loader_image_1').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }

        function DaySummaryBreachValidationDataLoad(filter_value) {

            check_second_tab_loading = 1;
            $('.all_tab_content_loader_image_2').show();
            $('.day_summary_tab_content_data_load').hide();
            $.ajax({
                url: "{{ url('/ane/dashboards/breach-validation/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 2,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_second_tab_loading = 0;

                        $('.day_summary_tab_content_data_load').html(page_load_data);
                        $('.day_summary_tab_content_data_load').show();
                        $('.all_tab_content_loader_image_2').hide();


                    } else {
                        $('.all_tab_content_loader_image_2').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }
                    // var ctx = document.getElementById('guage_chart_day_canvas').getContext('2d');
                    // window.myGauge = new Chart(ctx, config);
                },
                error: function(textStatus, errorThrown) {
                    check_second_tab_loading = 0;
                    $('.all_tab_content_loader_image_2').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }



        function WeekSummaryBreachValidationDataLoad(filter_value) {
            check_fifth_tab_loading = 1;
            $('.all_tab_content_loader_image_3').show();
            $('.week_summary_tab_content_data_load').hide();
            $.ajax({
                url: "{{ url('/ane/dashboards/breach-validation/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 5,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_fifth_tab_loading = 0;
                        $('.week_summary_tab_content_data_load').html(page_load_data);
                        $('.week_summary_tab_content_data_load').show();
                        $('.all_tab_content_loader_image_3').hide();
                    } else {
                        $('.all_tab_content_loader_image_3').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                    // var ctx = document.getElementById('guage_chart_week_canvas').getContext('2d');
                    // window.myGauge = new Chart(ctx, config);
                },
                error: function(textStatus, errorThrown) {
                    check_second_tab_loading = 0;
                    $('.all_tab_content_loader_image_3').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }


        function MonthSummaryBreachValidationDataLoad(filter_value) {
            $('.all_tab_content_loader_image_4').show();
            $('.month_summary_tab_content_data_load').hide();
            check_third_tab_loading = 1;
            $.ajax({
                url: "{{ url('/ane/dashboards/breach-validation/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 3,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_third_tab_loading = 0;
                        $('.month_summary_tab_content_data_load').html(page_load_data);
                        $('.month_summary_tab_content_data_load').show();
                        $('.all_tab_content_loader_image_4').hide();
                    } else {
                        $('.all_tab_content_loader_image_4').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }
                    // var ctx = document.getElementById('guage_chart_month_canvas').getContext('2d');
                    // window.myGauge = new Chart(ctx, config);
                },
                error: function(textStatus, errorThrown) {
                    check_third_tab_loading = 0;
                    $('.all_tab_content_loader_image_4').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }


        function MonthSummaryOverallBreachValidationDataLoad(filter_value) {
            $('.all_tab_content_loader_image_5').show();
            $('.month_summary_overall_tab_content_data_load').hide();
            check_fourth_tab_loading = 1;
            $.ajax({
                url: "{{ url('/ane/dashboards/breach-validation/content-data-load') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "filter_value": filter_value,
                    "tab_filter_mode": 4,
                },
                success: function(page_load_data) {
                    if(page_load_data != '{{PermissionDenied()}}'){
                        check_fourth_tab_loading = 0;
                        $('.month_summary_overall_tab_content_data_load').html(page_load_data);
                        $('.month_summary_overall_tab_content_data_load').show();
                        $('.all_tab_content_loader_image_5').hide();
                    } else {
                        $('.all_tab_content_loader_image_5').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    check_fourth_tab_loading = 0;
                    $('.all_tab_content_loader_image_5').hide();
                    CommonErrorModalPopupOpen();
                }
            });
        }

        function OpenBreachReasonPopupIndividualToUpdateReason(attendace_id) {
            DisableSaveButtonLoadImageForModals();
            if (attendace_id != '') {
                $('.breach_dashboard_breach_reason_update_content_data_load').html('<span class="modal-screen-center" ></span>');
                $('.breach_reason_attendance_next_patient').removeClass('bottom-next-button');
                $('.breach_reason_attendance_next_patient').addClass('bottom-next-button-disabled');
                $('.breach_reason_attendance_previous_patient').removeClass('bottom-prev-button');
                $('.breach_reason_attendance_previous_patient').addClass('bottom-prev-button-disabled');
                $('.breach_reason_attendance_save_patient').removeClass('bottom-save-button');
                $('.breach_reason_attendance_save_patient').addClass('bottom-save-button-disabled');
                $('#breach_reason_update_id_to_store_field').prop('disabled', false);


                var next_patient = $('#breach_reason_next_attendence_id_' + attendace_id).val();
                var prev_patient = $('#breach_reason_previous_attendence_id_' + attendace_id).val();

                $.ajax({
                    url: "{{ url('/ane/dashboards/breach-validation/breach-content-data-load') }}",
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "attendace_id": attendace_id
                    },
                    success: function(page_load_data) {

                        if(page_load_data != '{{PermissionDenied()}}'){
                            $('.breach_dashboard_breach_reason_update_content_data_load').html(page_load_data);
                            if (next_patient != '') {
                                $('.breach_reason_attendance_next_patient').removeClass(
                                    'bottom-next-button-disabled');
                                $('.breach_reason_attendance_next_patient').addClass('bottom-next-button');
                            }

                            if (prev_patient != '') {
                                $('.breach_reason_attendance_previous_patient').removeClass(
                                    'bottom-prev-button-disabled');
                                $('.breach_reason_attendance_previous_patient').addClass('bottom-prev-button');
                            }
                            var breach_reason_check = $('#breach_reason_update_id_to_store_field').val();
                            if (breach_reason_check != '') {
                                $('#breach_reason_update_id_to_store_field').prop('disabled', 'disabled');

                                $("#breach_form_reason_value").css("width", "95%");
                                $("#breach_unlock_reason").html(
                                    "<div title='Click to Unlock Breach Reason' class='col-md-12 unlock-breach-reason-container' ><img class='unloack_reason_value' src='{{ url('asset_v2/Ibox/Images/unlock.png') }}'></div>"
                                );
                            } else {
                                $('#breach_reason_update_id_to_store_field').prop('disabled', false);
                                $("#breach_unlock_reason").html("");

                                $("#breach_form_reason_value").css("width", "100%");
                            }
                        } else {
                            setTimeout(function() {
                                $("#staticBackdrop-reason").modal('hide');
                                CommonLoginModalPopupOpenOnRequest();
                            }, 1000);
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        setTimeout(function() {
                            $("#staticBackdrop-reason").modal('hide');
                            CommonErrorModalPopupOpen();
                        }, 1000);
                    }
                });
            } else {
                CommonErrorModalPopupOpen();
            }
        }

        $(document).on("click", ".unloack_reason_value", function(e) {
            $("#breach_reason_update_id_to_store_field").removeAttr("disabled");
            $("#breach_unlock_reason").html("");

            $("#breach_form_reason_value").css("width", "100%");
        });


        $(document).on("change", "#breach_reason_update_id_to_store_field", function(e) {
            var breach_reason_check = $('#breach_reason_update_id_to_store_field').val();
            if (breach_reason_check != '') {
                $('.breach_reason_attendance_save_patient').removeClass('bottom-save-button-disabled');
                $('.breach_reason_attendance_save_patient').addClass('bottom-save-button');
            } else {
                $('.breach_reason_attendance_save_patient').removeClass('bottom-save-button');
                $('.breach_reason_attendance_save_patient').addClass('bottom-save-button-disabled');
            }
        });

        $(document).on("click", ".add_update_breach_reason", function(e) {
            var attendace_id = $(this).data('patient-attendance-id');
            if (attendace_id != '') {
                $("#breach_dashboard_breach_reason_update").modal({
                    show: false,
                    backdrop: 'static'
                });
                $("#breach_dashboard_breach_reason_update").modal("show");

                OpenBreachReasonPopupIndividualToUpdateReason(attendace_id);
            }
        });

        $(document).on("click", ".breach_reason_attendance_previous_patient", function(e) {
            var attendace_id = $('#breach_reason_popup_current_attendence_id').val();
            var prev_patient = $('#breach_reason_previous_attendence_id_' + attendace_id).val();
            if (prev_patient != '') {
                OpenBreachReasonPopupIndividualToUpdateReason(prev_patient);
            }
        });

        $(document).on("click", ".breach_reason_attendance_next_patient", function(e) {
            var attendace_id = $('#breach_reason_popup_current_attendence_id').val();
            var next_patient = $('#breach_reason_next_attendence_id_' + attendace_id).val();
            if (next_patient != '') {
                OpenBreachReasonPopupIndividualToUpdateReason(next_patient);
            }
        });


        $(document).on("click", ".breach_reason_attendance_save_patient", function(e) {
            var attendace_id = $('#breach_reason_popup_current_attendence_id').val();
            var breach_reason_update_id_to_store_field = $('#breach_reason_update_id_to_store_field').val();
            EnableSaveButtonLoadImageForModals();
            $('#breach_reason_update_id_to_store_field').prop('disabled', 'disabled');

            $("#breach_form_reason_value").css("width", "95%");
            $("#breach_unlock_reason").html(
                "<div title='Click to Unlock Breach Reason' class='col-md-12 unlock-breach-reason-container' ><img class='unloack_reason_value' src='{{ url('asset_v2/Ibox/Images/unlock.png') }}'></div>"
            );
            $('.breach_reason_attendance_save_patient').removeClass('bottom-save-button');
            $('.breach_reason_attendance_save_patient').addClass('bottom-save-button-disabled');

            if (attendace_id != '' && breach_reason_update_id_to_store_field != '') {
                $.ajax({
                    url: "{{ url('/ane/dashboards/breach-validation/breach-reason-data-store') }}",
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "attendace_id": attendace_id,
                        "breach_reason_update_id_to_store_field": breach_reason_update_id_to_store_field,
                        "tab_filter_mode": 4,
                    },
                    success: function(result) {
                        if(result != '{{PermissionDenied()}}'){
                            if (typeof result.message !== 'undefined') {
                                DisableSaveButtonLoadImageForModals();
                                if (result.status == 1) {
                                    $("#breach_reason_update_success_message").html(
                                        '<div class="alert alert-success" style="text-align: center;"><button type="button" class="close" style="padding-right: 15px;">×</button>' +
                                        result.message + '</div>');
                                } else {
                                    $("#breach_reason_update_success_message").html(
                                        '<div class="alert alert-danger" style="text-align: center;"><button type="button" class="close" style="padding-right: 15px;">×</button>' +
                                        result.message + '</div>');
                                }
                                window.setTimeout(function() {
                                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                                        $(this).remove();
                                    });
                                }, 100);

                                if (typeof result.show_message !== 'undefined') {
                                    $(".breach_reason_show_data_column_" + attendace_id).html(
                                        ' <div class="data-breach-reason">\n' +
                                        '                                                    <div class="reason">'+ result.show_message +
                                        '                                                        </div>\n' +
                                        '                                                    <div class="icon-lock">\n' +
                                        '                                                        <img src="{{ asset('asset_v2/Ibox') }}/icons/lock-black.svg" alt="">\n' +
                                        '                                                    </div>\n' +
                                        '                                                </div>'

                                    );
                                    $(".breach-row-data-tr-" + attendace_id).addClass(
                                        'breach-row-data-tr-reason-added');
                                }
                            } else {
                                $('.all_tab_content_loader_image').hide();
                                CommonErrorModalPopupOpen();
                                DisableSaveButtonLoadImageForModals();
                            }
                        } else {
                                $('.all_tab_content_loader_image').hide();
                                CommonLoginModalPopupOpenOnRequest();
                                DisableSaveButtonLoadImageForModals();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        $('.all_tab_content_loader_image').hide();
                        CommonErrorModalPopupOpen();
                        DisableSaveButtonLoadImageForModals();
                    }
                });
            } else {
                setTimeout(function() {
                    $("#staticBackdrop-reason").modal('hide');
                    CommonErrorModalPopupOpen();
                    DisableSaveButtonLoadImageForModals();
                }, 1000);
            }
        });



        $(document).on("click", ".ambulance_data_adjust_on_date", function(e) {
            DisableSaveButtonLoadImageForModals();
            ShowModalFooterButtonForClick();
            var total_amb_val_ovr_30_min = $('#total_ambulance_value_over_30_minute_show').html();
            var total_amb_val_ovr_60_min = $('#total_ambulance_value_over_60_minute_show').html();
            $('#min_30_count').val(+total_amb_val_ovr_30_min);
            $('#min_60_count').val(+total_amb_val_ovr_60_min);
            $('.breach_dashboard_save_ambulance_count').removeClass('bottom-save-button-disabled');
            $('.breach_dashboard_save_ambulance_count').addClass('bottom-save-button');
            EnableSaveButtonForModals();
            $("#breach_dashboard_ambulance_data_update").modal({
                show: false,
                backdrop: 'static'
            });
            $("#breach_dashboard_ambulance_data_update").modal("show");
        });

        $(document).on("click", ".breach_dashboard_save_ambulance_count", function(e) {
            var min_30_count = $('#min_30_count').val();
            var min_60_count = $('#min_60_count').val();
            var reg_date_selected = $('#breach_tab_2_date_selected').val();
            DisableSaveButtonForModals();
            HideModalFooterButtonForClick();
            EnableSaveButtonLoadImageForModals();
            $('.breach_dashboard_save_ambulance_count').removeClass('bottom-save-button');
            $('.breach_dashboard_save_ambulance_count').addClass('bottom-save-button-disabled');
            check_fifth_tab_switch = 0;
            check_third_tab_switch = 0;
            if (min_30_count == '' || min_60_count == '') {
                $("#breach_dashboard_ambulance_data_success_message").html(
                    '<div class="alert alert-danger" style="text-align: center;"><button type="button" class="close" style="padding-right: 15px;">×</button>Please Enter Valid Digits!</div>'
                );
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 1000);
                $('.breach_dashboard_save_ambulance_count').removeClass('bottom-save-button-disabled');
                $('.breach_dashboard_save_ambulance_count').addClass('bottom-save-button');
                EnableSaveButtonForModals();
                ShowModalFooterButtonForClick();
            } else {
                $.ajax({
                    url: "{{ url('/ane/dashboards/breach-validation/breach-dashboard-ambulance-data-store') }}",
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "reg_date_selected": reg_date_selected,
                        "min_30_count": min_30_count,
                        "min_60_count": min_60_count
                    },
                    success: function(result) {
                        if(result != '{{PermissionDenied()}}'){
                            if (typeof result.message !== 'undefined') {
                                DisableSaveButtonLoadImageForModals();
                                ShowModalFooterButtonForClick();
                                EnableSaveButtonForModals();
                                if (result.status == 1) {
                                    $("#breach_dashboard_ambulance_data_success_message").html(
                                        '<div class="alert alert-success" style="text-align: center;">' +
                                        result.message + '</div>');
                                    $('#total_ambulance_value_over_30_minute_show').html(min_30_count);
                                    $('#total_ambulance_value_over_60_minute_show').html(min_60_count);
                                } else {
                                    $("#breach_dashboard_ambulance_data_success_message").html(
                                        '<div class="alert alert-danger" style="text-align: center;">' +
                                        result.message + '</div>');
                                }
                                window.setTimeout(function() {
                                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                                        $(this).remove();
                                    });
                                    $("#breach_dashboard_ambulance_data_update").modal('hide');
                                }, 100);
                            } else {
                                setTimeout(function() {
                                    $("#breach_dashboard_ambulance_data_update").modal('hide');
                                    CommonErrorModalPopupOpen();
                                    DisableSaveButtonLoadImageForModals();
                                    EnableSaveButtonForModals();
                                    ShowModalFooterButtonForClick();
                                }, 100);
                            }
                        } else {
                                setTimeout(function() {
                                    $("#breach_dashboard_ambulance_data_update").modal('hide');
                                    CommonLoginModalPopupOpenOnRequest();
                                    DisableSaveButtonLoadImageForModals();
                                    EnableSaveButtonForModals();
                                    ShowModalFooterButtonForClick();
                                }, 100);
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        setTimeout(function() {
                            $("#breach_dashboard_ambulance_data_update").modal('hide');
                            CommonErrorModalPopupOpen();
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            ShowModalFooterButtonForClick();
                        }, 1000);
                    }
                });
            }
        });
    </script>

    <script>
        function daily_js_function() {

        }
        $(function() {
        });


        @if(CheckSpecificPermission('breach_reason_view'))
            $(document).ready(function() {
                $('#breach_list_tab').click();
                var myTabs = new bootstrap.Tab($('#breach_list_tab'));
                myTabs.show();
            });
        @elseif(CheckSpecificPermission('breach_dashboard_view'))

            $(document).ready(function() {
                $('#day_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#day_summary_tab'));
                myTabs.show();
            });
        @elseif(CheckSpecificPermission('breach_weekly_dashboard_view'))

            $(document).ready(function() {
                $('#week_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#week_summary_tab'));
                myTabs.show();
            });
        @elseif(CheckSpecificPermission('breach_monthly_dashboard_view'))

            $(document).ready(function() {
                $('#month_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#month_summary_tab'));
                myTabs.show();
            });
        @elseif(CheckSpecificPermission('breach_monthly_report_view'))
            $(document).ready(function() {
                $('#month_summary_overall_tab').click();
                var myTabs = new bootstrap.Tab($('#month_summary_overall_tab'));
                myTabs.show();
            });
        @endif
    </script>

    <script>


        @if(CheckSpecificPermission('breach_reason_view'))
            $(document).ready(function() {

                var filter_value = '';
                BreachValidationPatientListDataLoad(filter_value);

            });
        @elseif(CheckDashboardPermission('breach_day_summary_tab'))

            $(document).ready(function() {
                $('#day_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#day_summary_tab'));
                myTabs.show();
            });

        @elseif(CheckDashboardPermission('breach_week_summary_tab'))
            $(document).ready(function() {
                $('#week_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#week_summary_tab'));
                myTabs.show();
            });
        @elseif(CheckDashboardPermission('breach_month_summary_tab'))
            $(document).ready(function() {
                $('#month_summary_tab').click();
                var myTabs = new bootstrap.Tab($('#month_summary_tab'));
                myTabs.show();
            });
        @elseif(CheckDashboardPermission('breach_month_summary_overall_tab'))
            $(document).ready(function() {
                $('#month_summary_overall_tab').click();
                var myTabs = new bootstrap.Tab($('#month_summary_overall_tab'));
                myTabs.show();
            });
        @endif
    </script>
@endpush
