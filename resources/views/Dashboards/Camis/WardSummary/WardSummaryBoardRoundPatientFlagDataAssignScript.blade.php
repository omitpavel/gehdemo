<script>
    function initSingleDatePicker($context) {
        $context.find('.ic_date').each(function() {
            var $input = $(this);

            if ($input.data('daterangepicker')) {
                $input.data('daterangepicker').remove();
                $input.off('.daterangepicker');
            }

            $input.daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                autoApply: true,
                minDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'Apply',
                    cancelLabel: 'Clear'
                }
            });

            $input.on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
                EnableSaveButtonForModals();
            });

            $input.on('cancel.daterangepicker', function() {
                $(this).val('');
            });
        });
    }

    $(document).on('click', '.ibox_board_round_patient_flag_list_assign', function(e) {



        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var boardround_flag_name = $(this).data('patient-flag-stored-name');
        var boardround_flag_show_name = $(this).data('patient-flag-show-name');

        var actionable_flag_list = [
            'ibox_patient_flag_plasma',
            'ibox_patient_flag_one_one_care',
            'ibox_patient_flag_infection_risk',
            'ibox_patient_flag_leaflet_one',
            'ibox_patient_flag_leaflet_two',
            'ibox_patient_flag_nof',
            'ibox_patient_flag_off_the_ward',
            'ibox_patient_flag_cld',
            'ibox_patient_flag_outlier',
            'ibox_patient_flag_dialysis',
            'ibox_patient_flag_ambo',
            'ibox_patient_flag_nurse_concern',
            'ibox_patient_flag_covid_dp'
        ];

        if (!actionable_flag_list.includes(boardround_flag_name)) {
            $(".ibox_board_round_patient_flag_active_" + boardround_flag_name).toggleClass('flag_inactive');
        }


        DisableButtonClickForPreventFurtherEvent("ibox_board_round_patient_flag_active_" +
            boardround_flag_name);

        if (camis_patient_id != '' && boardround_flag_name != '') {
            if (boardround_flag_name != 'ibox_patient_flag_nof') {
                $('.ibox_board_round_popup_opened_patient_flag_name').val('');
                $('.boardround_patient_flag_image_content_show').html('');
                $('.boardround_patient_flag_text_content_show').html('');
            }

            var url = "{{ route('GetPatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id,
                    'boardround_flag_name': boardround_flag_name
                },
                success: function(result) {
                    if (result.patient_flag_name != '') {
                        if (result.patient_flag_name == 'ibox_patient_flag_nurse_concern') {
                            if (result.patient_flag_status_value == 1 && result.dp_exists == 1) {
                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);
                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);
                                var nurse_concern_modal = new bootstrap.Offcanvas(document
                                    .getElementById(
                                        'camis_patient_ward_summary_boardround_patient_nurse_concern'
                                    ), {
                                        relatedTarget: 'offcanvasRight',
                                        backdrop: false
                                    });

                                nurse_concern_modal.show();
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableSaveButtonForModals();
                            } else if (result.patient_flag_status_value == 1) {
                                var camis_patient_id = $(
                                        '#ward_summary_boardround_modal_popup_camis_patient_id')
                                    .val();
                                $.ajax({
                                    url: '{{ route('RemovePatientFlagDetails') }}',
                                    type: 'POST',
                                    data: {
                                        "_token": tok,
                                        "camis_patient_id": camis_patient_id,
                                        "patient_flag_name": boardround_flag_name
                                    },
                                    success: function(result) {
                                        if (typeof result.message !== 'undefined') {
                                            if (result.sections != '') {
                                                $('.ibox_board_round_patient_task_content_show')
                                                    .html(result.sections);
                                                $(".ibox_board_round_patient_flag_active_" +
                                                    boardround_flag_name).addClass(
                                                    "flag_inactive");
                                            }
                                            $(".ibox_board_round_patient_flag_active_" +
                                                boardround_flag_name).addClass(
                                                "flag_inactive");
                                            toastr.success(
                                                "{{ DataRemovalMessage() }}");
                                        } else {
                                            toastr.warning(
                                                '{{ ErrorOccuredMessage() }}');
                                            CommonErrorModalPopupOpenOnRequest();
                                        }
                                    },
                                    error: function(textStatus, errorThrown) {
                                        toastr.warning('{{ ErrorOccuredMessage() }}');
                                        CommonErrorModalPopupOpenOnRequest();
                                    }
                                });

                            } else if (result.patient_flag_status_value == 0) {
                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);




                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);

                                var nurse_concern_modal = new bootstrap.Offcanvas(document
                                    .getElementById(
                                        'camis_patient_ward_summary_boardround_patient_nurse_concern'
                                    ), {
                                        relatedTarget: 'offcanvasRight',
                                        backdrop: false
                                    });

                                nurse_concern_modal.show();
                                if (result.patient_flag_status_value == 1) {
                                    CommonDisableEnableOnOpen();
                                    DisableLoaderAndMakeVisibleInnerBody();
                                    EnableSaveButtonForModals();
                                } else {
                                    CommonDisableEnableOnOpen();
                                    DisableLoaderAndMakeVisibleInnerBody();
                                    EnableSaveButtonForModals();
                                }
                            }

                        } else if (result.patient_flag_name == 'ibox_patient_flag_covid_dp') {
                            DisableLoaderAndMakeVisibleInnerBody();
                            var camis_patient_id = $(
                                '#ward_summary_boardround_modal_popup_camis_patient_id').val();
                            dp_patient_timeline(camis_patient_id);
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);

                            var deteriorating_patient_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_deteriorating_patient_timeline'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: 'static'
                                });

                            deteriorating_patient_modal.show();
                        } else if (result.patient_flag_name == 'ibox_patient_flag_outlier') {
                            DisableLoaderAndMakeVisibleInnerBody();
                            var camis_patient_id = $(
                                '#ward_summary_boardround_modal_popup_camis_patient_id').val();
                            dp_patient_timeline(camis_patient_id);
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);

                            var outlier_flag_modal_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_patient_flag_outlier'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });

                            outlier_flag_modal_modal.show();
                            if (result.patient_flag_status_value == 1) {
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableDeleteButtonForModals();
                            } else {
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableSaveButtonForModals();
                            }


                            if (result.patient_flag_status_value != 0) {

                                if (typeof result.flag_outlier_value !== 'undefined' &&
                                    typeof result.flag_outlier_value !== '.') {
                                    $('input[name="flag_outlier_value"][value="' + result
                                        .flag_outlier_value + '"]').prop('checked', true);
                                }
                            } else {
                                $('input[name="flag_outlier_value"]').prop('checked', false);
                            }

                        } else if (result.patient_flag_name == 'ibox_patient_flag_nof') {
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);

                            var nof_patient_modal = new bootstrap.Offcanvas(document.getElementById(
                                'camis_patient_ward_summary_boardround_patient_flag_nof'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: false
                            });

                            nof_patient_modal.show();

                            if (result.patient_flag_status_value == 1) {
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableDeleteButtonForModals();
                            } else {
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableSaveButtonForModals();
                            }
                        } else if (result.patient_flag_name == 'ibox_patient_flag_off_the_ward') {

                            var off_the_ward_patient_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_patient_flag_off_the_ward'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });

                            off_the_ward_patient_modal.show();

                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);
                            $(".ibox_boardround_patient_flag_off_the_ward_button").removeClass(
                                "active");
                            $(".off_the_ward_tick").css("display", "none");
                            if (typeof result.patient_flag_off_the_ward_selected_data !==
                                'undefined') {
                                if (result.patient_flag_off_the_ward_selected_data == 'Surgary') {
                                    $(".ibox_boardround_patient_flag_off_the_ward_surgary")
                                        .addClass("active");

                                } else if (result.patient_flag_off_the_ward_selected_data ==
                                    'Therapies') {

                                    $(".ibox_boardround_patient_off_the_ward_therapies").addClass(
                                        "active");
                                } else if (result.patient_flag_off_the_ward_selected_data ==
                                    'Other') {

                                    $(".ibox_boardround_patient_flag_off_the_ward_other").addClass(
                                        "active");
                                }
                            }
                            if (result.patient_flag_status_value == 1) {
                                EnableDeleteButtonForModals();
                            }
                        } else if (result.patient_flag_name == 'ibox_patient_flag_plasma') {

                            var plasma_patient_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_patient_flag_plasma'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });

                            plasma_patient_modal.show();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);
                            $(".plasma_tick").css("display", "none");
                            $(".ibox_boardround_patient_flag_plasma_button").removeClass("active");
                            if (typeof result.patient_flag_plasma_selected_data !== 'undefined') {
                                if (result.patient_flag_plasma_selected_data == 'On Plasma') {
                                    $("#plasma_tick_1").css("display", "inline");
                                    $(".ibox_boardround_patient_flag_plasma_on_plasma").addClass(
                                        "active");
                                } else if (result.patient_flag_plasma_selected_data ==
                                    'Requiring Plasma') {
                                    $("#plasma_tick_2").css("display", "inline");
                                    $(".ibox_boardround_patient_flag_plasma_requiring_plasma")
                                        .addClass("active");
                                }
                            }
                            if (result.patient_flag_status_value == 1) {
                                EnableDeleteButtonForModals();
                            }
                        } else if (result.patient_flag_name == 'ibox_patient_flag_cld') {
                            $('#cld_datepicker').datepicker({
                                language: "nl",
                                calendarWeeks: true,
                                todayHighlight: true,
                                numberOfMonths: 1,
                                dateFormat: 'yy-mm-dd',
                                onSelect: function(dateText, inst) {
                                    EnableSaveButtonForModals();
                                }
                            });

                            $('#ibox_board_round_content_cld_comment').on('keydown', function(e) {
                                EnableSaveButtonForModals();
                            });
                            if (result.patient_flag_status_value != 0) {
                                if (typeof result.patient_flag_cld_date_set !== 'undefined') {
                                    var predefinedDate = new Date(result.patient_flag_cld_date_set);
                                    $('#cld_datepicker').datepicker('setDate', predefinedDate);
                                }

                                if (typeof result.patient_flag_cld_comment !== 'undefined' &&
                                    typeof result.patient_flag_cld_comment !== '.') {
                                    $("#ibox_board_round_content_cld_comment").val(result
                                        .patient_flag_cld_comment);
                                }
                            } else {
                                $("#ibox_board_round_content_cld_comment").val('');
                                $('#cld_datepicker').datepicker('setDate', '');
                            }


                            var cld_patient_modal = new bootstrap.Offcanvas(document.getElementById(
                                'camis_patient_ward_summary_boardround_patient_flag_cld'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: false
                            });

                            cld_patient_modal.show();

                            if (result.patient_flag_status_value == 1) {
                                $("#one_one_checkbox_1").prop("checked", true);
                                $("#one_one_checkbox_2").prop("checked", true);
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                            } else {
                                $("#one_one_checkbox_1").prop("checked", false);
                                $("#one_one_checkbox_2").prop("checked", false);
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableSaveButtonForModals();
                            }
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);
                            $(".ibox_boardround_patient_flag_infection_risk_button").removeClass(
                                "active");
                            if (typeof result.patient_flag_infection_risk_selected_data !==
                                'undefined') {
                                if (result.patient_flag_infection_risk_selected_data == 'Query') {
                                    $(".ibox_boardround_patient_flag_infection_risk_query")
                                        .addClass("active");
                                } else if (result.patient_flag_infection_risk_selected_data ==
                                    'Confirmed') {
                                    $(".ibox_boardround_patient_flag_infection_risk_confirmed")
                                        .addClass("active");
                                } else if (result.patient_flag_infection_risk_selected_data ==
                                    'Resolved') {
                                    $(".ibox_boardround_patient_flag_infection_risk_resolved")
                                        .addClass("active");
                                } else if (result.patient_flag_infection_risk_selected_data ==
                                    'Can Stay In Bay') {
                                    $(".ibox_boardround_patient_flag_infection_risk_can_stay_in_bed")
                                        .addClass("active");
                                }
                            }
                            $('#patient_flag_infection_risk_reason').val('').selectric('refresh');
                            if (typeof result.patient_flag_infection_risk_reason_id !==
                                'undefined') {
                                if (result.patient_flag_infection_risk_reason_id != '') {
                                    $('#patient_flag_infection_risk_reason').val(result
                                        .patient_flag_infection_risk_reason_id).selectric(
                                        'refresh');
                                }
                            }


                            if (result.patient_flag_status_value == 1) {
                                EnableDeleteButtonForModals();
                            }
                        } else if (result.patient_flag_name == 'ibox_patient_flag_ambo') {
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);
                            var ambo_modal = new bootstrap.Offcanvas(document.getElementById(
                                'camis_patient_ward_summary_boardround_patient_flag_ambo'
                            ), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: false
                            });

                            ambo_modal.show();
                            $('.clockpicker_2').clockpicker({
                                'default': 'now',
                                vibrate: true,
                                autoclose: true,
                                afterDone: function() {
                                    EnableSaveButtonForModals();
                                }
                            });
                            if (result.patient_flag_status_value == 1) {
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableDeleteButtonForModals();
                            } else {
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableSaveButtonForModals();
                            }


                            if (result.patient_flag_status_value != 0) {



                                if (typeof result.flag_ambo_ref !== 'undefined' && typeof result
                                    .flag_ambo_ref !== '.') {
                                    $("#flag_ambo_ref").val(result.flag_ambo_ref);
                                }
                                if (typeof result.flag_ambo_time !== 'undefined' && typeof result
                                    .flag_ambo_time !== '.') {
                                    $("#flag_ambo_time").val(result.flag_ambo_time);
                                }

                            } else {

                                $("#flag_ambo_ref").val('');
                                $("#flag_ambo_time").val('');
                            }

                        } else if (result.patient_flag_name == 'ibox_patient_flag_one_one_care') {
                            if (result.patient_flag_status_value == 0) {
                                var one_on_one_patient_modal = new bootstrap.Offcanvas(document
                                    .getElementById(
                                        'camis_patient_ward_summary_boardround_patient_flag_one_one_care'
                                    ), {
                                        relatedTarget: 'offcanvasRight',
                                        backdrop: false
                                    });
                                one_on_one_patient_modal.show();

                                if (result.patient_flag_status_value == 1) {
                                    $("#one_one_checkbox_1").prop("checked", true);
                                    $("#one_one_checkbox_2").prop("checked", true);
                                    CommonDisableEnableOnOpen();
                                    DisableLoaderAndMakeVisibleInnerBody();
                                } else {
                                    $("#one_one_checkbox_1").prop("checked", false);
                                    $("#one_one_checkbox_2").prop("checked", false);
                                    CommonDisableEnableOnOpen();
                                    DisableLoaderAndMakeVisibleInnerBody();
                                    EnableSaveButtonForModals();
                                }
                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);
                                $(".ibox_boardround_patient_flag_infection_risk_button")
                                    .removeClass("active");
                                if (typeof result.patient_flag_infection_risk_selected_data !==
                                    'undefined') {
                                    if (result.patient_flag_infection_risk_selected_data ==
                                        'Query') {
                                        $(".ibox_boardround_patient_flag_infection_risk_query")
                                            .addClass("active");
                                    } else if (result.patient_flag_infection_risk_selected_data ==
                                        'Confirmed') {
                                        $(".ibox_boardround_patient_flag_infection_risk_confirmed")
                                            .addClass("active");
                                    } else if (result.patient_flag_infection_risk_selected_data ==
                                        'Resolved') {
                                        $(".ibox_boardround_patient_flag_infection_risk_resolved")
                                            .addClass("active");
                                    } else if (result.patient_flag_infection_risk_selected_data ==
                                        'Can Stay In Bay') {
                                        $(".ibox_boardround_patient_flag_infection_risk_can_stay_in_bed")
                                            .addClass("active");
                                    }
                                }
                                $('#patient_flag_infection_risk_reason').val('').selectric(
                                    'refresh');
                                if (typeof result.patient_flag_infection_risk_reason_id !==
                                    'undefined') {
                                    if (result.patient_flag_infection_risk_reason_id != '') {
                                        $('#patient_flag_infection_risk_reason').val(result
                                            .patient_flag_infection_risk_reason_id).selectric(
                                            'refresh');
                                    }
                                }

                                if (result.patient_flag_status_value == 1) {
                                    EnableDeleteButtonForModals();
                                }
                            } else {
                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);
                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);
                                $('#ibox_board_round_one_one_reason').val('');
                                var one_on_one_modal = new bootstrap.Offcanvas(document
                                    .getElementById('one_to_one_cancel'), {
                                        relatedTarget: 'offcanvasRight',
                                        backdrop: false
                                    });

                                one_on_one_modal.show();
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                EnableSaveButtonForModals();
                            }

                        } else if (result.patient_flag_name == 'ibox_patient_flag_infection_risk') {

                            var infection_risk_patient_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_patient_flag_infection_risk'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });
                            infection_risk_patient_modal.show();
                            CommonDisableEnableOnOpen();
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);
                            $('.infection_list_class').html(result.sections);
                            $('#past_infection_history').html(result.old_infection_history);
                            initSingleDatePicker($('.infection_list_class'));

                            if (result.patient_flag_status_value == 1) {
                                EnableDeleteButtonForModals();
                            }
                        } else if (result.patient_flag_name == 'ibox_patient_flag_dialysis') {
                            var dialysis_patient_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_patient_flag_dialysis'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });
                            dialysis_patient_modal.show();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);
                            $("#on_dialysis").css("display", "none");
                            $("#require_dialysis").css("display", "none");
                            $(".ibox_boardround_patient_flag_dialysis_button").removeClass(
                                "ibox_boardround_patient_flag_dialysis_active");
                            if (typeof result.patient_flag_dialysis_selected_data !== 'undefined') {
                                if (result.patient_flag_dialysis_selected_data == 'On Dialysis') {
                                    $("#on_dialysis").css("display", "inline");
                                    $(".ibox_boardround_patient_flag_dialysis_on_dialysis")
                                        .addClass("ibox_boardround_patient_flag_dialysis_active");
                                } else if (result.patient_flag_dialysis_selected_data ==
                                    'Requiring Dialysis') {
                                    $("#require_dialysis").css("display", "inline");
                                    $(".ibox_boardround_patient_flag_dialysis_requiring_dialysis")
                                        .addClass("ibox_boardround_patient_flag_dialysis_active");
                                }
                            }
                            if (result.patient_flag_status_value == 1) {
                                EnableDeleteButtonForModals();
                            }
                        } else if (result.patient_flag_name == 'ibox_patient_flag_leaflet_one' &&
                            result.patient_flag_status_value == 0) {


                            var leaflet_one_patient_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_patient_flag_leaflet_one'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });
                            leaflet_one_patient_modal.show();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);

                        } else if (result.patient_flag_name == 'ibox_patient_flag_leaflet_two' &&
                            result.patient_flag_status_value == 0) {


                            var leaflet_two_patient_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_patient_flag_leaflet_two'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });
                            leaflet_two_patient_modal.show();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();
                            $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                .patient_flag_name);
                            $(".ibox_boardround_patient_flag_leaflet_two_button").removeClass(
                                "flag_inactive");

                        } else {

                            if (result.patient_flag_status_value == 0) {
                                var camis_patient_id = $(
                                        '#ward_summary_boardround_modal_popup_camis_patient_id')
                                    .val();
                                var url = "{{ route('UpdatePatientFlagDetails') }}";
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: {
                                        "_token": tok,
                                        "camis_patient_id": camis_patient_id,
                                        "patient_flag_name": boardround_flag_name,
                                        "patient_flag_status_value": 1
                                    },
                                    success: function(result) {
                                        if (typeof result.message !== 'undefined') {
                                            if (result.sections != '') {
                                                $('.ibox_board_round_patient_task_content_show')
                                                    .html(result.sections);
                                                if (patient_flag_name ==
                                                    'ibox_patient_flag_nurse_concern') {
                                                    $(".ibox_board_round_patient_flag_active_ibox_patient_flag_covid_dp")
                                                        .removeClass("flag_inactive");
                                                }
                                            }
                                            toastr.success(result.message);
                                            $(".ibox_board_round_patient_flag_active_" +
                                                    result.patient_flag_stored_name)
                                                .removeClass("flag_inactive");
                                        } else {
                                            $(".ibox_board_round_patient_flag_active_" +
                                                boardround_flag_name).toggleClass(
                                                'flag_inactive');
                                            toastr.warning(
                                                '{{ ErrorOccuredMessage() }}');
                                            CommonErrorModalPopupOpenOnRequest();
                                        }
                                    },
                                    error: function(textStatus, errorThrown) {
                                        $(".ibox_board_round_patient_flag_active_" +
                                            boardround_flag_name).toggleClass(
                                            'flag_inactive');
                                        toastr.warning('{{ ErrorOccuredMessage() }}');
                                        CommonErrorModalPopupOpenOnRequest();
                                    }
                                });

                            } else {
                                if (result.patient_flag_status_value == 1) {

                                    var camis_patient_id = $(
                                            '#ward_summary_boardround_modal_popup_camis_patient_id')
                                        .val();
                                    if (boardround_flag_name == 'ibox_patient_flag_leaflet_one' ||
                                        boardround_flag_name == 'ibox_patient_flag_leaflet_two') {
                                        $(".ibox_board_round_patient_flag_active_" +
                                            boardround_flag_name).toggleClass('flag_inactive');
                                    }
                                    var url = "{{ route('RemovePatientFlagDetails') }}";
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: {
                                            "_token": tok,
                                            "camis_patient_id": camis_patient_id,
                                            "patient_flag_name": boardround_flag_name
                                        },
                                        success: function(result) {
                                            if (typeof result.message !== 'undefined') {
                                                if (result.sections != '') {
                                                    $('.ibox_board_round_patient_task_content_show')
                                                        .html(result.sections);
                                                }
                                                toastr.success(result.message);
                                            } else {
                                                $(".ibox_board_round_patient_flag_active_" +
                                                        boardround_flag_name)
                                                    .toggleClass('flag_inactive');
                                                toastr.warning(
                                                    '{{ ErrorOccuredMessage() }}');
                                                CommonErrorModalPopupOpenOnRequest();
                                            }
                                        },
                                        error: function(textStatus, errorThrown) {
                                            $(".ibox_board_round_patient_flag_active_" +
                                                boardround_flag_name).toggleClass(
                                                'flag_inactive');
                                            toastr.warning(
                                                '{{ ErrorOccuredMessage() }}');
                                            CommonErrorModalPopupOpenOnRequest();
                                        }
                                    });
                                }


                            }
                        }
                    }
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + boardround_flag_name).toggleClass(
                        'flag_inactive');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + boardround_flag_name).toggleClass('flag_inactive');
            CommonErrorModalPopupOpenOnRequest();
        }
    });





    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag", function(e) {
        var token = "{{ csrf_token() }}";
        var patient_flag_name = $('.ibox_board_round_popup_opened_patient_flag_name').val();
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (patient_flag_name == 'ibox_patient_flag_nurse_concern') {
            if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name).hasClass('flag_inactive')) {
                $(".ibox_board_round_patient_flag_active_" + patient_flag_name).removeClass('flag_inactive')
            }
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
        }
        DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_save_patient_flag');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {

            var url = "{{ route('UpdatePatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        if (result.sections != '') {
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);
                            if (patient_flag_name == 'ibox_patient_flag_nurse_concern') {
                                $(".ibox_board_round_patient_flag_active_ibox_patient_flag_covid_dp")
                                    .removeClass("flag_inactive");
                                CloseOffcanvas(
                                    'camis_patient_ward_summary_boardround_patient_nurse_concern'
                                );
                            }
                        }
                        if (patient_flag_name == 'ibox_patient_flag_leaflet_one') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_leaflet_one'
                            );
                        } else if (patient_flag_name == 'ibox_patient_flag_nof') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_nof');
                        }
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.success(result.message);
                    } else {
                        if (patient_flag_name == 'ibox_patient_flag_nurse_concern') {
                            if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name)
                                .hasClass('flag_inactive')) {
                                $(".ibox_board_round_patient_flag_active_" + patient_flag_name)
                                    .removeClass('flag_inactive')
                            }
                        } else {
                            $(".ibox_board_round_patient_flag_active_" + patient_flag_name)
                                .toggleClass('flag_inactive');
                        }
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    if (patient_flag_name == 'ibox_patient_flag_nurse_concern') {
                        if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name)
                            .hasClass('flag_inactive')) {
                            $(".ibox_board_round_patient_flag_active_" + patient_flag_name)
                                .removeClass('flag_inactive')
                        }
                    } else {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                    }
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            if (patient_flag_name == 'ibox_patient_flag_nurse_concern') {
                if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name).hasClass('flag_inactive')) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).removeClass('flag_inactive')
                }
            } else {
                $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            }
            CommonErrorModalPopupOpenOnRequest();
        }
    });




    $(document).on("click", ".camis_nof_removal_confirmation", function(e) {
        var token = "{{ csrf_token() }}";
        var patient_flag_name = $('.ibox_board_round_popup_opened_patient_flag_name').val();
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (camis_patient_id != '') {
            CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_nof');
            setTimeout(function() {
                var mobility_pre_score_modal = new bootstrap.Offcanvas(document.getElementById(
                    'nof_removal_confirmation'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: false
                });
                mobility_pre_score_modal.show();
            }, 1000);
        } else {
            toastr.warning('{{ ErrorOccuredMessage() }}');

        }
    });

    $(document).on("click", ".remove_nof_flag_without_auto_task", function(e) {
        var token = "{{ csrf_token() }}";
        var patient_flag_name = $('.ibox_board_round_popup_opened_patient_flag_name').val();
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var one_on_once_comment = $('#ibox_board_round_one_one_reason').val();
        DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_remove_patient_flag');
        EnableDeleteButtonForModals();
        EnableDeleteButtonLoadImageForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('RemovePatientFlagDetails') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "nof_task_keep": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        if (result.sections != '') {
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);
                            $(".ibox_board_round_patient_flag_active_" + result.patient_flag_name)
                                .addClass("flag_inactive");
                            DisableDeleteButtonForModals();
                            EnableDeleteButtonLoadImageForModals();


                        }
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).addClass(
                            "flag_inactive");
                        if (patient_flag_name == 'ibox_patient_flag_cld') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_cld');
                        } else if (patient_flag_name == 'ibox_patient_flag_leaflet_one') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_leaflet_one'
                            );
                        } else if (patient_flag_name == 'ibox_patient_flag_infection_risk') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_infection_risk'
                            );
                        } else if (patient_flag_name == 'ibox_patient_flag_off_the_ward') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_off_the_ward'
                            );
                        } else if (patient_flag_name == 'ibox_patient_flag_dialysis') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_dialysis');
                        } else if (patient_flag_name == 'ibox_patient_flag_nof') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_nof');
                        } else if (patient_flag_name == 'ibox_patient_flag_plasma') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_plasma');
                        } else if (patient_flag_name == 'ibox_patient_flag_renal_support') {
                            CloseOffcanvas('renal_support_modal');
                        } else if (patient_flag_name == 'ibox_patient_flag_tracheostomy') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_tracheostomy'
                            );
                        } else if (patient_flag_name ==
                            'ibox_patient_flag_cardiovascular_support') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_cardiovascular_support'
                            );
                        }
                        toastr.success('{{ DataRemovalMessage() }}');
                    } else {
                        DisableDeleteButtonForModals();
                        EnableDeleteButtonLoadImageForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    DisableDeleteButtonForModals();
                    EnableDeleteButtonLoadImageForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            toastr.warning('{{ ErrorOccuredMessage() }}');
            DisableDeleteButtonForModals();
            EnableDeleteButtonLoadImageForModals();
            CommonErrorModalPopupOpenOnRequest();
        }


    });








    $(document).on("click", ".camis_patient_ward_summary_boardround_remove_patient_flag", function(e) {
        var token = "{{ csrf_token() }}";
        var patient_flag_name = $('.ibox_board_round_popup_opened_patient_flag_name').val();
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var one_on_once_comment = $('#ibox_board_round_one_one_reason').val();
        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
        if (patient_flag_name == 'ibox_patient_flag_plasma') {
            $(".ibox_boardround_patient_flag_plasma_button").removeClass("active");
        } else if (patient_flag_name == 'ibox_patient_flag_infection_risk') {
            $(".ibox_boardround_patient_flag_infection_risk_button").removeClass("active");
            $('#patient_flag_infection_risk_reason').val('').selectric('refresh');
        } else if (patient_flag_name == 'ibox_patient_flag_off_the_ward') {
            $(".ibox_boardround_patient_flag_off_the_ward_button").removeClass("active");
        }

        DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_remove_patient_flag');
        EnableDeleteButtonForModals();
        EnableDeleteButtonLoadImageForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('RemovePatientFlagDetails') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "one_on_once_comment": one_on_once_comment
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        if (result.sections != '') {
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);
                            $(".ibox_board_round_patient_flag_active_" + result.patient_flag_name)
                                .addClass("flag_inactive");
                            DisableDeleteButtonForModals();
                            EnableDeleteButtonLoadImageForModals();


                        }
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).addClass(
                            "flag_inactive");
                        if (patient_flag_name == 'ibox_patient_flag_cld') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_cld');
                        } else if (patient_flag_name == 'ibox_patient_flag_outlier') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_outlier');
                        } else if (patient_flag_name == 'ibox_patient_flag_leaflet_one') {
                            CloseOffcanvas('one_to_one_cancel');
                        } else if (patient_flag_name == 'ibox_patient_flag_infection_risk') {

                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_infection_risk'
                            );
                            if ($('#covid_status_bg').hasClass('bg-covid-positive')) {
                                $('#covid_status_bg').removeClass('bg-covid-positive');

                            }
                            if (!$('#covid_status_bg').hasClass('bg-covid-negative')) {
                                $('#covid_status_bg').addClass('bg-covid-negative');
                            }
                            $('#covid_status_text').html('No Infection');


                            $('#ibox_board_round_pharmacy_updated_comment_show').removeClass(
                                'custom_height_boardround_page_with_ic');
                            $('#ibox_board_round_pharmacy_updated_comment_show').addClass(
                                'custom_height_boardround_page');

                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_infection_risk'
                            );

                        } else if (patient_flag_name == 'ibox_patient_flag_off_the_ward') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_off_the_ward'
                            );
                        } else if (patient_flag_name == 'ibox_patient_flag_dialysis') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_dialysis');
                        } else if (patient_flag_name == 'ibox_patient_flag_nof') {
                            CloseOffcanvas('nof_removal_confirmation');
                        } else if (patient_flag_name == 'ibox_patient_flag_plasma') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_plasma');
                        } else if (patient_flag_name == 'ibox_patient_flag_ambo') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_ambo');
                        }
                        toastr.success('{{ DataRemovalMessage() }}');
                    } else {
                        DisableDeleteButtonForModals();
                        EnableDeleteButtonLoadImageForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                        'flag_inactive');
                    DisableDeleteButtonForModals();
                    EnableDeleteButtonLoadImageForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            toastr.warning('{{ ErrorOccuredMessage() }}');
            DisableDeleteButtonForModals();
            EnableDeleteButtonLoadImageForModals();
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on("input", "#flag_ambo_ref", function(e) {
        EnableSaveButtonForModals();

    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_ambo ", function(e) {

        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_ambo';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        var flag_ambo_ref = $('#flag_ambo_ref').val();
        var flag_ambo_time = $('#flag_ambo_time').val();


        if (flag_ambo_ref == '' || flag_ambo_ref == null) {
            toastr.warning('Please Enter Reference');
            return;
        }



        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');



        DisableButtonClickForPreventFurtherEvent(
            'camis_patient_ward_summary_boardround_save_patient_renal_support');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('UpdatePatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "flag_ambo_ref": flag_ambo_ref,
                    "flag_ambo_time": flag_ambo_time,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        toastr.success(result.message);
                        CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_ambo');
                    } else {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                        'flag_inactive');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on('click', '.ibox_boardround_patient_flag_plasma_button', function() {
        $(".plasma_tick").css("display", "none");
        var plasma_tick = $(this).data('plasma-id');
        $('#plasma_tick_' + plasma_tick).css("display", "inline");
        $(".ibox_boardround_patient_flag_plasma_button").removeClass("active");
        $(this).addClass("active");
        EnableSaveButtonForModals();
    });



    $(document).on('click', '.ibox_boardround_patient_flag_off_the_ward_button', function() {
        var ow_tick_1 = $(this).data('ow-option-value');
        $(".off_the_ward_tick").css("display", "none");
        $('#ow_tick_' + ow_tick_1).css("display", "inline");
        $(".ibox_boardround_patient_flag_off_the_ward_button").removeClass("active");
        $(this).addClass("active");
        EnableSaveButtonForModals();
    });

    function RemovePatientFlagForOnclickInactive(patient_flag_name, camis_patient_id) {

        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_remove_patient_flag');
        EnableDeleteButtonLoadImageForModals();
        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
        if (camis_patient_id != '') {
            var url = "{{ route('RemovePatientFlagDetails') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {

                        DisableDeleteButtonForModals();
                        DisableDeleteButtonLoadImageForModals();

                        toastr.success('{{ DataRemovalMessage() }}');
                    } else {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                        DisableDeleteButtonForModals();
                        DisableDeleteButtonLoadImageForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');

                    }
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                        'flag_inactive');
                    DisableDeleteButtonForModals();
                    DisableDeleteButtonLoadImageForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');

                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            toastr.warning('{{ ErrorOccuredMessage() }}');
            DisableDeleteButtonForModals();
            DisableDeleteButtonLoadImageForModals();
        }
    }






    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_dialysis", function(e) {

        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_dialysis';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_flag_dialysis_selected_data = '';
        if ($('.ibox_boardround_patient_flag_dialysis_on_dialysis').hasClass(
                "ibox_boardround_patient_flag_dialysis_active")) {
            patient_flag_dialysis_selected_data = 'On Dialysis';
        }
        if ($('.ibox_boardround_patient_flag_dialysis_requiring_dialysis').hasClass(
                "ibox_boardround_patient_flag_dialysis_active")) {
            patient_flag_dialysis_selected_data = 'Requiring Dialysis';
        }
        if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name).hasClass('flag_inactive')) {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).removeClass('flag_inactive');
        }
        DisableButtonClickForPreventFurtherEvent(
            'camis_patient_ward_summary_boardround_save_patient_flag_dialysis');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('UpdatePatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "patient_flag_dialysis_selected_data": patient_flag_dialysis_selected_data,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        CloseOffcanvas(
                            'camis_patient_ward_summary_boardround_patient_flag_dialysis');
                        toastr.success(result.message);
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_plasma", function(e) {
        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_plasma';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_flag_plasma_selected_data = '';
        if ($('.ibox_boardround_patient_flag_plasma_on_plasma').hasClass("active")) {
            patient_flag_plasma_selected_data = 'On Plasma';
        }
        if ($('.ibox_boardround_patient_flag_plasma_requiring_plasma').hasClass("active")) {
            patient_flag_plasma_selected_data = 'Requiring Plasma';
        }
        DisableButtonClickForPreventFurtherEvent(
            'camis_patient_ward_summary_boardround_save_patient_flag_plasma');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name).hasClass('flag_inactive')) {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).removeClass('flag_inactive');
        }
        if (camis_patient_id != '') {
            var url = "{{ route('UpdatePatientFlagDetails') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "patient_flag_plasma_selected_data": patient_flag_plasma_selected_data,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_plasma');
                        toastr.success(result.message);

                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });



    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_off_the_ward", function(e) {
        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_off_the_ward';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name).hasClass('flag_inactive')) {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).removeClass('flag_inactive');
        }
        var patient_flag_off_the_ward_selected_data = '';
        if ($('.ibox_boardround_patient_flag_off_the_ward_surgary').hasClass("active")) {
            patient_flag_off_the_ward_selected_data = 'Surgary';
        }
        if ($('.ibox_boardround_patient_off_the_ward_therapies').hasClass("active")) {
            patient_flag_off_the_ward_selected_data = 'Therapies';
        }
        if ($('.ibox_boardround_patient_flag_off_the_ward_other').hasClass("active")) {
            patient_flag_off_the_ward_selected_data = 'Other';
        }
        DisableButtonClickForPreventFurtherEvent(
            'camis_patient_ward_summary_boardround_save_patient_flag_off_the_ward');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {

            var url = "{{ route('UpdatePatientFlagDetails') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "patient_flag_off_the_ward_selected_data": patient_flag_off_the_ward_selected_data,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        toastr.success(result.message);
                        CloseOffcanvas(
                            'camis_patient_ward_summary_boardround_patient_flag_off_the_ward');
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_cld", function(e) {




        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_cld';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var selectedDate = $("#cld_datepicker").datepicker("getDate");


        if (selectedDate == '' || selectedDate == null) {
            toastr.warning('Please Select A Date');
            return;
        }
        var formattedDate = selectedDate.getFullYear() + "-" + (selectedDate.getMonth() + 1) + "-" +
            selectedDate.getDate();
        var additional_information = $("#ibox_board_round_content_cld_comment").val();
        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
        DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_save_patient_flag_cld');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('UpdatePatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "patient_flag_cld_date_set": formattedDate,
                    "patient_flag_cld_comment": additional_information,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        toastr.success(result.message);
                        CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_cld');
                    } else {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                        'flag_inactive');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on('click', '.ibox_boardround_patient_flag_dialysis_button', function() {

        $("#on_dialysis").css("display", "none");
        $("#require_dialysis").css("display", "none");

        var dialysis_Value = $(this).data('dialysis');
        if (dialysis_Value == 1) {
            $("#on_dialysis").css("display", "inline");
        } else if (dialysis_Value == 2) {
            $("#require_dialysis").css("display", "inline");
        }

        $(".ibox_boardround_patient_flag_dialysis_button").removeClass(
            "ibox_boardround_patient_flag_dialysis_active");
        $(this).addClass("ibox_boardround_patient_flag_dialysis_active");
        EnableSaveButtonForModals();
    });



    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_outlier", function(e) {

        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_outlier';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var flag_outlier_value = $('input[name="flag_outlier_value"]:checked').val();

        if (flag_outlier_value == '' || flag_outlier_value == null) {
            toastr.warning('Please Select A Option');
            return;
        }

        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
        DisableButtonClickForPreventFurtherEvent(
            'camis_patient_ward_summary_boardround_save_patient_flag_outlier');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('UpdatePatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "flag_outlier_value": flag_outlier_value,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        toastr.success(result.message);
                        CloseOffcanvas(
                            'camis_patient_ward_summary_boardround_patient_flag_outlier');
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                        'flag_inactive');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("change", "input[name=flag_outlier_value]", function(e) {
        EnableSaveButtonForModals();

    });




    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_one_one_care", function(e) {

        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_one_one_care';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
        if ($("#one_one_checkbox_1").is(":checked") && $("#one_one_checkbox_2").is(":checked")) {
            DisableButtonClickForPreventFurtherEvent(
                'camis_patient_ward_summary_boardround_save_patient_flag_one_one_care');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            if (camis_patient_id != '') {
                var url = "{{ route('UpdatePatientFlagDetails') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "patient_flag_name": patient_flag_name,
                        "patient_flag_one_one_care_risk_assessment": 'Yes',
                        "patient_flag_one_one_care_agreed_one_one_care": 'Yes',
                        "patient_flag_status_value": 1
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            toastr.success(result.message);
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_one_one_care'
                            );

                        } else {
                            $(".ibox_board_round_patient_flag_active_" + patient_flag_name)
                                .toggleClass('flag_inactive');
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModals();
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('Please Tick All The Checkbox');
        }
    });



    $(document).on("click", ".clone_infection_div", function(e) {
        $('.ic_id').selectric('destroy');
        var ic_div = $('.infection_risk_master_div_for_repeat').html();
        $('.infection_list_class').append(ic_div);
        initSingleDatePicker($('.infection_list_class'));
        $('.ic_id').selectric('refresh');
    });

    $(document).on("click", ".infection_risk_button", function() {
        $(this).closest('.row').find('.infection_risk_button').removeClass('active');
        $(this).addClass('active');
        EnableSaveButtonForModals();
    });


    $(document).on("click", ".make_primary_infection", function() {
        $('.make_primary_infection').removeClass('active');
        $(this).addClass('active');


        EnableSaveButtonForModals();

    });

    $(document).on("change", ".ic_id", function() {

        EnableSaveButtonForModals();
    });

    $(document).on("click", ".infection_risk_delete", function() {
        var $card = $(this).closest('.card-infection-data');
        $card.addClass('infection_risk_disabled').find('.infection_risk_button').removeClass('active');

        if ($card.find('.make_primary_infection').hasClass('active')) {
            $card.find('.make_primary_infection').removeClass('active');
            var $nearestCard = $card.siblings('.card-infection-data:not(.infection_risk_disabled)').first();

            if ($nearestCard.length === 0) {
                $nearestCard = $card.prevAll('.card-infection-data:not(.infection_risk_disabled)').first();
            }

            $nearestCard.find('.make_primary_infection').first().addClass('active');
        }
        EnableSaveButtonForModals();
        $('.ic_id').selectric('refresh');
    });






    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_infection_risk", function() {
        let infection_data = [];
        let valid = true;
        let has_primary = false;
        $(".infection_list_class .card-infection-data").each(function() {
            let $this = $(this);
            let infection_item = {};
            let selected_option = $this.find("select.ic_id option:selected");

            // Prefer a stored existing-id (set on server when rendering the card)
            // e.g. <div class="card-infection-data" data-existing-id="22">...
            infection_item.infection_id = $this.data('existing-id') || $this.find(
                'input.hidden_existing_id').val() || (selected_option.length ? selected_option
                .val() : '');

            infection_item.infection_text = selected_option.data('infection-name') || $this.find(
                '.selectric .label').text() || '';
            infection_item.infection_type = $this.find(".infection_risk_button.active").text() || '';
            infection_item.next_review_date = $this.find(".ic_date").val() || null;
            infection_item.is_primary = $this.find(".make_primary_infection").hasClass("active") ?
                1 : 0;
            infection_item.action_type = $this.hasClass("infection_risk_disabled") ? "delete" :
                "update";

            // validations only for updates
            if (infection_item.action_type === "update") {
                if (infection_item.is_primary) {
                    has_primary = true;
                    if (infection_item.infection_id !== '' && !infection_item.next_review_date) {
                        toastr.warning("Primary infection must have a next review date.");
                        valid = false;
                        return false; // break .each()
                    }
                }

                if (infection_item.infection_id !== '' && infection_item.infection_type === '') {
                    toastr.warning(
                        "Some Of The Infection Risk Data Missed. Please Either Select Reason Details Or Delete That"
                    );
                    valid = false;
                    return false; // break .each()
                }
            }

            // push single time: send when has an id OR it's a delete action (delete must carry an id to remove server-side)
            if ((infection_item.infection_id !== '' && infection_item.infection_id != null) ||
                infection_item.action_type === 'delete') {
                infection_data.push(infection_item);
            }
        });



        if (!valid) return;

        if (!has_primary) {
            toastr.warning("At least one infection must be marked as primary.");
            return;
        }
        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_infection_risk';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name).hasClass('flag_inactive')) {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).removeClass('flag_inactive');
        }
        DisableButtonClickForPreventFurtherEvent(
            'camis_patient_ward_summary_boardround_save_patient_flag_infection_risk');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('UpdatePatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "patient_flag_infection_data": infection_data,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        CloseOffcanvas(
                            'camis_patient_ward_summary_boardround_patient_flag_infection_risk');

                        if ($('#covid_status_bg').hasClass('d-none')) {
                            $('#covid_status_bg').removeClass('d-none');
                        }
                        $('#ibox_board_round_pharmacy_updated_comment_show').removeClass(
                            'custom_height_boardround_page');
                        $('#ibox_board_round_pharmacy_updated_comment_show').addClass(
                            'custom_height_boardround_page_with_ic');
                        if (result.patient_flag_infection_risk_selected_data == 'Query' || result
                            .patient_flag_infection_risk_selected_data == 'Confirmed') {
                            if (!$('#covid_status_bg').hasClass('bg-covid-positive')) {
                                $('#covid_status_bg').addClass('bg-covid-positive');

                            }
                            if ($('#covid_status_bg').hasClass('bg-covid-negative')) {
                                $('#covid_status_bg').removeClass('bg-covid-negative');
                            }
                            $('#covid_status_text').html('' + result
                                .patient_flag_infection_risk_reason_text + ' - ' + result
                                .patient_flag_infection_risk_selected_data);

                        } else {
                            if ($('#covid_status_bg').hasClass('bg-covid-positive')) {
                                $('#covid_status_bg').removeClass('bg-covid-positive');

                            }
                            if (!$('#covid_status_bg').hasClass('bg-covid-negative')) {
                                $('#covid_status_bg').addClass('bg-covid-negative');
                            }
                            $('#covid_status_text').html('' + result
                                .patient_flag_infection_risk_reason_text + ' - ' + result
                                .patient_flag_infection_risk_selected_data);

                        }
                        toastr.success(result.message);
                    } else {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                        'flag_inactive');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_leaflet_two", function(e) {
        var token = "{{ csrf_token() }}";
        var patient_flag_name = 'ibox_patient_flag_leaflet_two';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var selected_value = $('input[name="leaflet_two"]:checked').val();
        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
        DisableButtonClickForPreventFurtherEvent(
            'camis_patient_ward_summary_boardround_patient_flag_leaflet_two');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {
            var url = "{{ route('UpdatePatientFlagDetails') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_flag_name": patient_flag_name,
                    "leaflet": selected_value,
                    "patient_flag_status_value": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        CloseOffcanvas(
                            'camis_patient_ward_summary_boardround_patient_flag_leaflet_two');
                        toastr.success(result.message);
                    } else {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                        'flag_inactive');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }

    });


    function dp_patient_timeline(camis_patient_id, date_value) {
        CommonDisableEnableOnOpen();
        $("#dp_task").html('');
        var token = "{{ csrf_token() }}";
        if (typeof date_value !== 'undefined') {
            var date = date_value;
        } else {
            var date = '';
        }
        var url = "{{ route('GetDeterioratingPatientTimeline') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": tok,
                "camis_patient_id": camis_patient_id,
                "date": date
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {

                    $("#dp_task").html(result.data);
                    $.getScript('/asset_v2/Ibox/Js/timeline.js', function() {});

                    DisableLoaderAndMakeVisibleInnerBody();
                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }
            },
            error: function(textStatus, errorThrown) {
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    }
</script>
