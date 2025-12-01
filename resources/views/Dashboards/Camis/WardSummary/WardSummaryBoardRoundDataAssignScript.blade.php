<script>
    function CloseBoardRound(word_name) {


        let check_board_round = localStorage.getItem('run_board_round');
        var click_boardround_close_offcanvas = $('#click_boardround_close_offcanvas').val();

        let check_board_round_check = localStorage.getItem('run_board_round');
        let board_round_missed = localStorage.getItem('board_round_missed');
        if (board_round_missed) {
            localStorage.removeItem('board_round_missed');
        }
        if (($('#board_round_cancel').hasClass('locked')) || ($('#board_round_close').hasClass('locked')) || (
                click_boardround_close_offcanvas == 1) || !check_board_round_check) {

            let browser_id = localStorage.getItem('browser_id');
            var unlock_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            var url = '{{ route('board_round_save_unlocked_status') }}';
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": unlock_patient_id,
                    "browser_id": browser_id
                },
                success: function(result) {

                }
            });
            var url = '{{ route('ward.ward-details', ':id') }}';
            url = url.replace(':id', word_name);

            window.location.href = url;
        } else {



            var token = "{{ csrf_token() }}";
            var check_reason_to_reside = localStorage.getItem('this_is_last_patient');



            var unlock_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            let browser_id = localStorage.getItem('browser_id');
            if (!browser_id) {
                browser_id = GenerateBrowserID();
                localStorage.setItem('browser_id', browser_id);
            }

            var url_unlocked = "{{ route('board_round_save_unlocked_status') }}";

            $.ajax({
                url: url_unlocked,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": unlock_patient_id,
                    "browser_id": browser_id
                },
                success: function(result) {



                    var url = "{{ route('GetReasonToReside') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            "camis_patient_id": unlock_patient_id
                        },
                        success: function(result) {
                            $('#click_boardround_close_offcanvas').val(1);
                            $('.ibox_board_round_content_patient_reason_to_reside').prop(
                                'checked', false);
                            $('.reason_to_reside_modal_title').html('Reason To Reside');
                            if (!$('.reason_to_reside_close_area').hasClass('d-none')) {
                                $('.reason_to_reside_close_area').addClass('d-none');
                            }
                            if ($('.reason_to_reside_save_area').hasClass('d-none')) {
                                $('.reason_to_reside_save_area').removeClass('d-none');
                            }

                            if (!$('.redbed_save_area').hasClass('d-none')) {
                                $('.redbed_save_area').addClass('d-none');
                            }
                            var reason_to_reaside = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_reason_to_reside'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: 'static'
                                });

                            reason_to_reaside.show();
                            $('#r2r_button_text').html('SAVE & NEXT');
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();

                            $('#ibox_board_round_content_med_fit_set_as_no').val(result
                                .patient_medically_fit_status);
                            if (!$('.camis_patient_ward_summary_boardround_save_red_green_bed')
                                .hasClass(
                                    'camis_patient_ward_summary_boardround_save_reason_to_reside'
                                )) {
                                $('.camis_patient_ward_summary_boardround_save_red_green_bed')
                                    .addClass(
                                        'camis_patient_ward_summary_boardround_save_reason_to_reside'
                                    );
                            }
                            if ($(
                                    '.camis_patient_ward_summary_boardround_save_reason_to_reside'
                                    )
                                .hasClass(
                                    'camis_patient_ward_summary_boardround_save_red_green_bed')
                            ) {
                                $('.camis_patient_ward_summary_boardround_save_reason_to_reside')
                                    .removeClass(
                                        'camis_patient_ward_summary_boardround_save_red_green_bed'
                                    );
                            }


                            if (result.patient_medically_fit_status == 1) {
                                if ($('.click_popup_open_ibox_board_round_medfit_no_modal')
                                    .hasClass('active')) {
                                    $('.click_popup_open_ibox_board_round_medfit_no_modal')
                                        .removeClass('active');
                                }
                                if (!$('.click_popup_open_ibox_board_round_medfit_yes_modal')
                                    .hasClass('active')) {
                                    $('.click_popup_open_ibox_board_round_medfit_yes_modal')
                                        .addClass('active');
                                }
                                $('#ibox_board_round_content_med_fit_set_as_no').val(1);
                                $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]")
                                    .prop("checked", true);
                                $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]")
                                    .prop("disabled", false);
                                $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]")
                                    .prop("disabled", true);


                                if ($('.medfit-card').hasClass('d-none')) {
                                    $('.medfit-card').removeClass('d-none');
                                }
                                $('.medfit_yes_consultant_head_doctor_name').html($(
                                        '.boardround_patient_consultant_full_name_show')
                                    .html());
                                if (!$('.r2r_checkbox_section').hasClass('d-none')) {
                                    $('.r2r_checkbox_section').addClass('d-none');
                                }
                                $('#ibox_board_round_content_patient_medically_fit_status_comment')
                                    .val(result.patient_medically_fit_status_comment);
                                EnableSaveButtonForModals();
                            } else {
                                if ($('.click_popup_open_ibox_board_round_medfit_yes_modal')
                                    .hasClass('active')) {
                                    $('.click_popup_open_ibox_board_round_medfit_yes_modal')
                                        .removeClass('active');
                                }
                                if (!$('.click_popup_open_ibox_board_round_medfit_no_modal')
                                    .hasClass('active')) {
                                    $('.click_popup_open_ibox_board_round_medfit_no_modal')
                                        .addClass('active');
                                }
                                $('#ibox_board_round_content_med_fit_set_as_no').val(1);

                                $('#ibox_board_round_content_patient_medically_fit_status_comment')
                                    .val('');
                                $('input[name="ibox_board_round_content_patient_reason_to_reside"]')
                                    .prop('checked', false);
                                if (result.patient_reason_to_reside_status != '') {
                                    $('input[name="ibox_board_round_content_patient_reason_to_reside"][value="' +
                                        result.patient_reason_to_reside_status + '"]').prop(
                                        'checked', true);
                                    EnableSaveButtonForModals();
                                }
                                $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]")
                                    .prop("disabled", false);
                                $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]")
                                    .prop("disabled", true);
                                if (!$('.medfit-card').hasClass('d-none')) {
                                    $('.medfit-card').addClass('d-none');
                                }
                                $('.medfit_yes_consultant_head_doctor_name').html($(
                                        '.boardround_patient_consultant_full_name_show')
                                    .html());
                                if ($('.r2r_checkbox_section').hasClass('d-none')) {
                                    $('.r2r_checkbox_section').removeClass('d-none');
                                }
                            }

                        },
                        error: function(textStatus, errorThrown) {
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });


                }
            });


        }


    }



    $(document).on("click", ".print_ane_discharge_summary", function(e) {
        var w = window.open();
        var html_to_print = $(".print_ane_summary").html();
        var title = 'A&E DISCHARGE SUMMARY';
        var print_title =
            '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">' +
            title + '</div>';

        var html = print_title +
            '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
            html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append(
            '<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">'
        );
        $(w.document.head).append(
            '<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">'
        );
        $(w.document.head).append(
            '<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}">'
        );
        $(w.document.head).append(
            '<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">'
        );
        setTimeout(function() {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });
    $(document).on("click", ".click_open_ipc_infection_history", function() {
        $('.infection_history_data').html('');
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var url = "{{ route('infection.ipc.infection.history') }}";
        var myModal = new bootstrap.Modal(document.getElementById('infectionHistory'), {
    backdrop: false
  });
  myModal.show();

        EnableLoaderAndMakeHiddenInnerBody();
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                '_token': token,
                'camis_patient_id': camis_patient_id
            },
            success: function(result) {
                $('.infection_history_data').html(result.history);
                DisableLoaderAndMakeVisibleInnerBody();

            },
            error: function(textStatus, errorThrown) {
                $('#infectionHistory').modal('hide');
            }
        });
    });
    $(document).on('click', '#admitting_reason_modal', function(e) {
        var token = "{{ csrf_token() }}";
        $('.camis_patient_ward_summary_boardround_save_admitting_reason').addClass("disabled");
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_admitting_reason');
        if (camis_patient_id != '') {

            var admitting_reason_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_patient_ward_summary_boardround_admitting_reason'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            admitting_reason_modal.show();

            CommonDisableEnableOnOpen();
            var url = "{{ route('GetPatientAdmittingReason') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                    $('#ibox_board_round_content_admitting_reason').val(result);
                    $('#ibox_board_round_content_admitting_reason').focus();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on('click', '.cdt_to_review_offcanvas', function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_admitting_reason');
        if (camis_patient_id != '') {

            var cdt_offcanvas = new bootstrap.Offcanvas(document.getElementById(
                'camis_cdt_details_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            cdt_offcanvas.show();
            $('#cdt_comment').val('');
            CommonDisableEnableOnOpen();
            var url = "{{ route('GetPatientCDTDetails') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                    if (result.status == 3) {
                        $('#cdt_status_text').html('CDT Referral Rejected Reason:');
                    } else if (result.status == 4) {
                        $('#cdt_status_text').html('CDT Referral Removed Reason:');
                    }
                    $('#cdt_comment').val(result.return_text);
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on('click', '.camis_patient_ward_summary_boardround_save_admitting_reason', function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_admitting_reason = $('#ibox_board_round_content_admitting_reason').val();
        CommonDisableEnableOnSave();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var url = "{{ route('UpdatePatientAdmittingReason') }}";
        if (camis_patient_id != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': tok,
                    'camis_patient_id': camis_patient_id,
                    'patient_admitting_reason': patient_admitting_reason
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.camis_popup_ibox_board_round_admitting_reason_data_show').html(result
                            .patient_admitting_reason);
                        if (result.patient_admitting_reason != '') {
                            $('.camis_popup_ibox_board_round_admitting_reason_date').html(result
                                .updated_date);
                        } else {
                            $('.camis_popup_ibox_board_round_admitting_reason_date').html('');
                        }

                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();

                        CloseOffcanvas('camis_patient_ward_summary_boardround_admitting_reason');
                        toastr.success(result.message);

                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
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
            CommonErrorModalPopupOpenOnRequest();
        }
    });




    $(document).on('click', '#past_medical_history_modal', function(e) {
        var token = "{{ csrf_token() }}";
        $('.camis_patient_ward_summary_boardround_save_past_medical_history').addClass("disabled");
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_past_medical_history');
        if (camis_patient_id != '') {

            var past_medical_history_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_patient_ward_summary_boardround_past_medical_history'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            past_medical_history_modal.show();

            CommonDisableEnableOnOpen();
            var url = "{{ route('GetPatientPastMedicalHistory') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                    $('#ibox_board_round_content_past_medical_history').val(result);
                    $('#ibox_board_round_content_past_medical_history').focus();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on('click', '.camis_patient_ward_summary_boardround_save_past_medical_history', function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_past_medical_history = $('#ibox_board_round_content_past_medical_history').val();
        CommonDisableEnableOnSave();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var url = "{{ route('UpdatePatientPastMedicalHistory') }}";
        if (camis_patient_id != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': tok,
                    'camis_patient_id': camis_patient_id,
                    'patient_past_medical_history': patient_past_medical_history
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.camis_popup_ibox_board_round_past_medical_history_data_show').html(
                            result.patient_past_medical_history);
                        if (result.patient_past_medical_history != '') {
                            $('.camis_popup_ibox_board_round_past_medical_history_date').html(result
                                .updated_date);
                        } else {
                            $('.camis_popup_ibox_board_round_past_medical_history_date').html('');
                        }

                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();

                        CloseOffcanvas(
                            'camis_patient_ward_summary_boardround_past_medical_history');
                        toastr.success(result.message);

                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
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
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on('click', '#patient_goal_modal', function(e) {
        var token = "{{ csrf_token() }}";
        $('.camis_patient_ward_summary_boardround_save_patient_goal').addClass("disabled");
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_patient_goal');
        if (camis_patient_id != '') {

            var patient_goal_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_patient_ward_summary_boardround_patient_goal'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            patient_goal_modal.show();

            CommonDisableEnableOnOpen();
            var url = "{{ route('GetPatientGoal') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                    $('#ibox_board_round_content_patient_goal').val(result);
                    $('#ibox_board_round_content_patient_goal').focus();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on('click', '.camis_patient_ward_summary_boardround_save_patient_goal', function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_patient_goal = $('#ibox_board_round_content_patient_goal').val();
        CommonDisableEnableOnSave();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var url = "{{ route('UpdatePatientGoal') }}";
        if (camis_patient_id != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': tok,
                    'camis_patient_id': camis_patient_id,
                    'patient_patient_goal': patient_patient_goal
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.camis_popup_ibox_board_round_patient_goal_data_show').html(result
                            .patient_patient_goal);
                        if (result.patient_patient_goal != '') {
                            $('.camis_popup_ibox_board_round_patient_goal_date').html(result
                                .updated_date);
                        } else {
                            $('.camis_popup_ibox_board_round_patient_goal_date').html('');
                        }

                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();

                        CloseOffcanvas('camis_patient_ward_summary_boardround_patient_goal');
                        toastr.success(result.message);

                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
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
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", "#social_history_modal", function(e) {
        var token = "{{ csrf_token() }}";
        $('.camis_patient_ward_summary_boardround_save_social_history').addClass('disabled');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_social_history');
        if (camis_patient_id != '') {

            var social_history_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_patient_ward_summary_boardround_social_history'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            social_history_modal.show();

            CommonDisableEnableOnOpen();
            var url = "{{ route('GetPatientSocialHistory') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                    $('#ibox_board_round_content_social_history').val(result);
                    $('#ibox_board_round_content_social_history').focus();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $(document).on("click", ".camis_patient_ward_summary_boardround_save_social_history", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_social_history = $('#ibox_board_round_content_social_history').val();
        CommonDisableEnableOnSave();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var url = "{{ route('UpdatePatientSocialHistory') }}";
        if (camis_patient_id != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_social_history": patient_social_history
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        $('.camis_popup_ibox_board_round_social_history_data_show').html(result
                            .patient_social_history);
                        $('.camis_popup_ibox_board_round_social_history_date').html(result
                            .updated_date);
                        CloseOffcanvas('camis_patient_ward_summary_boardround_social_history');
                        toastr.success(result.message);
                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
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
            toastr.warning('{{ ErrorOccuredMessage() }}');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on("click", "#working_diagnosis_modal", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $('.camis_patient_ward_summary_boardround_save_working_diagnosis').addClass('disabled');
        DisableButtonClickForPreventFurtherEvent('ward_summary_boardround_modal_popup_camis_patient_id');
        if (camis_patient_id != '') {

            var social_history_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_patient_ward_summary_boardround_working_diagnosis'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });
            social_history_modal.show();

            CommonDisableEnableOnOpen();
            var url = "{{ route('GetPatientWorkingDiagnosis') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                    $('#ibox_board_round_content_working_diagnosis').val(result);
                    $('#ibox_board_round_content_working_diagnosis').focus();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on("click", ".camis_patient_ward_summary_boardround_save_working_diagnosis", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_working_diagnosis = $('#ibox_board_round_content_working_diagnosis').val();
        if (camis_patient_id != '') {
            CommonDisableEnableOnSave();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url = "{{ route('UpdatePatientWorkingDiagnosis') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_working_diagnosis": patient_working_diagnosis
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.camis_popup_ibox_board_round_working_diagnosis_data_show').html(result
                            .patient_working_diagnosis);
                        $('.camis_popup_ibox_board_round_working_diagnosis_date_show').html(result
                            .updated_date);
                        CloseOffcanvas('camis_patient_ward_summary_boardround_working_diagnosis');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.success(result.message);
                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
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
            toastr.warning('{{ ErrorOccuredMessage() }}');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $(document).on("click", ".click_popup_open_ibox_board_round_edd", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_edd');
        $(".boardround_edd_date_first_time_hide_edd_comments").addClass("content_display_none");
        if (camis_patient_id != '') {

            var board_round_edd = new bootstrap.Offcanvas(document.getElementById(
                'camis_patient_ward_summary_boardround_estimated_discharge_date'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            board_round_edd.show();
            CommonDisableEnableOnOpen();
            var url = "{{ route('GetEstimatedDischargeDate') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    $("#ibox_board_round_content_estimated_discharge_date").val(result.date);
                    $('#ibox_board_round_content_estimated_discharge_date_comment').val(result
                        .comment);
                    $('#boardround_edd_date_show_calendar_div').datepicker({
                        language: "nl",
                        dateFormat: 'yy-mm-dd',
                        numberOfMonths: 2,
                        minDate: 0,
                    });

                    $('#boardround_edd_date_show_calendar_div').datepicker('setDate', result.date);
                    if (result.date == '') {
                        $('#ibox_board_round_content_estimated_discharge_date_comment').val('  ');
                        $(".boardround_edd_date_first_time_hide_edd_comments").addClass(
                            "content_display_none");
                    } else {
                        $(".boardround_edd_date_first_time_hide_edd_comments").removeClass(
                            "content_display_none");
                    }

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $('#ibox_board_round_content_estimated_discharge_date_comment').on('keydown', function(e) {
        EnableSaveButtonForModals();
    });
    $('#boardround_edd_date_show_calendar_div').datepicker({
        language: "nl",
        dateFormat: 'yy-mm-dd',
        numberOfMonths: 2,
        minDate: 0,
    });
    $('#boardround_edd_date_show_calendar_div').datepicker().on('change', function(e) {
        var date = $('#boardround_edd_date_show_calendar_div').val();
        $("#ibox_board_round_content_estimated_discharge_date").val(date);
        if (date != "") {
            EnableSaveButtonForModals();
        } else {
            DisableSaveButtonForModals();
        }
    });
    $(document).on("click", ".camis_patient_ward_summary_boardround_save_estimated_discharge_date", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_estimated_discharge_date = $('#ibox_board_round_content_estimated_discharge_date').val();
        var patient_estimated_discharge_date_comment = $(
            '#ibox_board_round_content_estimated_discharge_date_comment').val();

        if (camis_patient_id != '') {
            if (patient_estimated_discharge_date_comment == '') {
                $('#ibox_board_round_content_estimated_discharge_date_comment').focus();
            } else {
                CommonDisableEnableOnSave();
                EnableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                var url = "{{ route('UpdateEstimatedDischargeDate') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "patient_estimated_discharge_date": patient_estimated_discharge_date,
                        "patient_estimated_discharge_date_comment": patient_estimated_discharge_date_comment
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_estimated_discharge_date'
                            );
                            $('.click_popup_open_ibox_board_round_edd').html(result
                                .estimated_discharge_date);
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.success('Please Ensure The EDD Date Is Updated On Lorenzo');
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CommonErrorModalPopupOpenOnRequest();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            }
        } else {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            CommonErrorModalPopupOpenOnRequest();
        }
    });



    $(document).on("click", ".click_popup_open_ibox_board_round_reason_to_reside", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $('#ibox_board_round_content_med_fit_set_as_no').val(0);
        $('.ibox_board_round_content_patient_reason_to_reside').prop('checked', false);
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_reason_to_reside');
        if (camis_patient_id != '') {
            var url = "{{ route('GetReasonToReside') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {

                    $('.reason_to_reside_modal_title').html('Reason To Reside');
                    if (!$('.reason_to_reside_close_area').hasClass('d-none')) {
                        $('.reason_to_reside_close_area').addClass('d-none');
                    }
                    if ($('.reason_to_reside_save_area').hasClass('d-none')) {
                        $('.reason_to_reside_save_area').removeClass('d-none');
                    }

                    if (!$('.redbed_save_area').hasClass('d-none')) {
                        $('.redbed_save_area').addClass('d-none');
                    }
                    $("#resonToResideSection").show();
                    $("#redToGreenSection").hide();

                    var reason_to_reaside = new bootstrap.Offcanvas(document.getElementById(
                        'camis_patient_ward_summary_boardround_reason_to_reside'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: false
                    });

                    reason_to_reaside.show();
                    CommonDisableEnableOnOpen();
                    DisableLoaderAndMakeVisibleInnerBody();
                    $('#ibox_board_round_content_med_fit_set_as_no').val(result
                        .patient_medically_fit_status);
                    if (!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass(
                            'camis_patient_ward_summary_boardround_save_reason_to_reside')) {
                        $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass(
                            'camis_patient_ward_summary_boardround_save_reason_to_reside');
                    }
                    if ($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass(
                            'camis_patient_ward_summary_boardround_save_red_green_bed')) {
                        $('.camis_patient_ward_summary_boardround_save_reason_to_reside')
                            .removeClass(
                                'camis_patient_ward_summary_boardround_save_red_green_bed');
                    }
                    EnableSaveButtonForModals();

                    if (result.patient_medically_fit_status == 1) {
                        if ($('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass(
                                'active')) {
                            $('.click_popup_open_ibox_board_round_medfit_no_modal').removeClass(
                                'active');
                        }
                        if (!$('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass(
                                'active')) {
                            $('.click_popup_open_ibox_board_round_medfit_yes_modal').addClass(
                                'active');
                        }
                        $('#ibox_board_round_content_med_fit_set_as_no').val(1);
                        $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]")
                            .prop("checked", true);
                        $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]")
                            .prop("disabled", false);
                        $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]")
                            .prop("disabled", true);


                        if ($('.medfit-card').hasClass('d-none')) {
                            $('.medfit-card').removeClass('d-none');
                        }
                        $('.medfit_yes_consultant_head_doctor_name').html($(
                            '.boardround_patient_consultant_full_name_show').html());
                        if (!$('.r2r_checkbox_section').hasClass('d-none')) {
                            $('.r2r_checkbox_section').addClass('d-none');
                        }
                        $('#ibox_board_round_content_patient_medically_fit_status_comment').val(
                            result.patient_medically_fit_status_comment);
                        EnableSaveButtonForModals();
                    } else {
                        if ($('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass(
                                'active')) {
                            $('.click_popup_open_ibox_board_round_medfit_yes_modal').removeClass(
                                'active');
                        }
                        if (!$('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass(
                                'active')) {
                            $('.click_popup_open_ibox_board_round_medfit_no_modal').addClass(
                                'active');
                        }
                        $('#ibox_board_round_content_med_fit_set_as_no').val(1);

                        $('#ibox_board_round_content_patient_medically_fit_status_comment').val('');
                        $('input[name="ibox_board_round_content_patient_reason_to_reside"]').prop(
                            'checked', false);
                        if (result.patient_reason_to_reside_status != '') {
                            $('input[name="ibox_board_round_content_patient_reason_to_reside"][value="' +
                                result.patient_reason_to_reside_status + '"]').prop('checked',
                                true);
                            EnableSaveButtonForModals();
                        }
                        $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]")
                            .prop("disabled", false);
                        $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]")
                            .prop("disabled", true);
                        if (!$('.medfit-card').hasClass('d-none')) {
                            $('.medfit-card').addClass('d-none');
                        }
                        $('.medfit_yes_consultant_head_doctor_name').html($(
                            '.boardround_patient_consultant_full_name_show').html());
                        if ($('.r2r_checkbox_section').hasClass('d-none')) {
                            $('.r2r_checkbox_section').removeClass('d-none');
                        }
                    }






                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".click_popup_open_ibox_board_round_green_red_reason", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $('input[name="bed_red_green_name"]').prop('checked', false);
        if (!$("#red_bed_modal").hasClass('d-none')) {
            $("#red_bed_modal").addClass('d-none');
        }
        if (!$("#green_bed_modal").hasClass('d-none')) {
            $("#green_bed_modal").addClass('d-none');
        }
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_green_red_reason');
        if (camis_patient_id != '') {
            var url = "{{ route('GetReasonToReside') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {

                    if ($('.reason_to_reside_close_area').hasClass('d-none')) {
                        $('.reason_to_reside_close_area').removeClass('d-none');
                    }


                    if (!$('.reason_to_reside_save_area').hasClass('d-none')) {
                        $('.reason_to_reside_save_area').addClass('d-none');
                    }

                    if ($('.redbed_save_area').hasClass('d-none')) {
                        $('.redbed_save_area').removeClass('d-none');
                    }
                    $('.red_reason_list_block .reason-list').show();
                    $('#red_to_green_search').val('');
                    var reason_to_reaside = new bootstrap.Offcanvas(document.getElementById(
                        'camis_patient_ward_summary_boardround_reason_to_reside'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: false
                    });

                    reason_to_reaside.show();
                    CommonDisableEnableOnOpen();
                    DisableLoaderAndMakeVisibleInnerBody();
                    $('#red_green_status_type').val(0);
                    if (result.patient_red_green_status == 2) {
                        $('#red_green_status_type').val(2);
                        $('input[name="bed_red_green_name"]').prop('disabled', true);
                        $('input[name="bed_red_green_name"]').prop('checked', false);
                        $('.red_bed_reason_list').addClass('d-none');
                        $('.red_bed_search_input').addClass('d-none');

                        if ($("#green_bed_modal").hasClass('d-none')) {
                            $("#green_bed_modal").removeClass('d-none');
                        }
                        EnableSaveButtonForModals();
                    } else if (result.patient_red_green_status == 1) {
                        $('#red_green_status_type').val(1);
                        $('.red_bed_reason_list').removeClass('d-none');
                        $('.red_bed_search_input').removeClass('d-none');
                        if ($("#red_bed_modal").hasClass('d-none')) {
                            $("#red_bed_modal").removeClass('d-none');
                        }
                        $('input[name="bed_red_green_name"]').prop('disabled', false);
                        var patient_red_green_status_reason_codes = result
                            .patient_red_green_status_reason_code;
                        var checked_text = [];
                        patient_red_green_status_reason_codes.forEach(function(value) {
                            var red_checkbox = $(
                                'input[name="bed_red_green_name"][value="' + value +
                                '"]');
                            var label_text = red_checkbox.closest('li').next('li').text()
                                .trim();

                            checked_text.push(label_text);
                            $('input[name="bed_red_green_name"][value="' + value + '"]')
                                .prop('checked', true);
                        });
                        var reason_spans = checked_text.map(function(text) {
                            return '<span>' + text + '</span>';
                        });
                        var reason_div_html = reason_spans.join('');

                        $('.red_block_list').html(reason_div_html);




                        EnableSaveButtonForModals();
                    } else {
                        $('.red_bed_reason_list').addClass('d-none');
                        $('.red_bed_search_input').addClass('d-none');
                    }

                    $("#resonToResideSection").hide();

                    $(".camis_patient_ward_summary_boardround_save_reason_to_reside").addClass(
                        "camis_patient_ward_summary_boardround_save_red_green_bed");
                    $(".camis_patient_ward_summary_boardround_save_red_green_bed").removeClass(
                        "camis_patient_ward_summary_boardround_save_reason_to_reside");
                    $('#r2r_button_text').html('SAVE');
                    $('.reason_to_reside_modal_title').html('Bed Red Green Status');

                    $("#redToGreenSection").show();
                    DisableSaveButtonLoadImageForModals();


                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on("change", "input[name=ibox_board_round_content_patient_reason_to_reside]", function(e) {
        @if (CheckSpecificPermission('camis_reason_to_reside_update'))
            EnableSaveButtonForModals();
        @else
            e.preventDefault();
            toastr.error('Permission Denied');
            $("input[name='ibox_board_round_content_patient_reason_to_reside']").prop('checked', false);
        @endif
    });

    $(document).on("change", "input[name=bed_red_green_name]", function(e) {
        @if (CheckSpecificPermission('camis_bed_red_green_update'))
            var checked_text = [];

            $('input[name="bed_red_green_name"]:checked').each(function() {
                var label_text = $(this).closest('li').next('li').text().trim();
                checked_text.push(label_text);
            });

            var reason_spans = checked_text.map(function(text) {
                return '<span>' + text + '</span>';
            });

            var reason_div_html = reason_spans.join('');

            $('.red_block_list').html(reason_div_html);

            EnableSaveButtonForModals();
        @else
            e.preventDefault();
            toastr.error('Permission Denied');
            $("input[name='bed_red_green_name']").prop('checked', false);
        @endif
    });




    $(document).on("click", ".camis_patient_ward_summary_boardround_save_red_green_bed", function(e) {
        var patient_red_green_status_reason_code = [];
        $('#is_next_popup_need_to_open').val(0);
        $('input[name="bed_red_green_name"]:checked').each(function() {
            patient_red_green_status_reason_code.push($(this).val());
        });
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var red_green_status_type = $('#red_green_status_type').val();
        $("#red_bed").css("display", "none");
        $("#green_bed").css("display", "none");
        if (!$("#red_bed_modal").hasClass('d-none')) {
            $("#red_bed_modal").addClass('d-none');
        }
        if (!$("#green_bed_modal").hasClass('d-none')) {
            $("#green_bed_modal").addClass('d-none');
        }
        if (patient_red_green_status_reason_code.length === 0 && red_green_status_type == 1) {
            toastr.error('Please Select A Reason');
            return;
        }
        if (camis_patient_id != '') {
            var url = "{{ route('UpdateRedGreenBedStatusReason') }}";


            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_red_green_status_reason_code": patient_red_green_status_reason_code,
                    "patient_red_green_status": red_green_status_type
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        if (result.patient_red_green_status == 1) {
                            $("#red_bed").css("display", "inline");
                        } else if (result.patient_red_green_status == 2) {
                            $("#green_bed").css("display", "inline");
                        } else {
                            $('.red_bed_reason_list').addClass('d-none');
                            $('.red_bed_search_input').addClass('d-none');
                        }


                        if (result.patient_red_green_status == 1) {
                            $('#board_round_show_patient_red_green_status_reason_code').val(
                                patient_red_green_status_reason_code);
                        }




                    } else {

                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {

                    CommonErrorModalPopupOpenOnRequest();
                }
            });

            $("#resonToResideSection").show();
            $("#redToGreenSection").hide();
            CloseOffcanvas('camis_patient_ward_summary_boardround_reason_to_reside');
            toastr.success('{{ DataUpdatedMessage() }}');
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id_next').val();
            var click_next_patient_offcanvas = $('#click_next_patient_offcanvas').val();
            var click_boardround_close_offcanvas = $('#click_boardround_close_offcanvas').val();

            if (click_boardround_close_offcanvas == 1) {
                @php
                    $ward_url_name = isset($success_array['ward_details']['ward_url_name']) ? $success_array['ward_details']['ward_url_name'] : '';
                @endphp
                var url = '{{ route('ward.ward-details', $ward_url_name) }}';

                window.location.href = url;
            }

            $("input[name='bed_red_green_name']").prop('checked', false);
            if (camis_patient_id != '' && click_next_patient_offcanvas == 1) {
                BoardRoundData(camis_patient_id);
            }
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });



    $(document).on("click", ".camis_patient_ward_summary_boardround_save_reason_to_reside", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_medically_fit_status_comment = $(
            '#ibox_board_round_content_patient_medically_fit_status_comment').val();

        $('#is_next_popup_need_to_open').val(0);
        var consultant_name = $('.boardround_patient_consultant_full_name_show').text();
        var patient_medically_fit_status_comment = $(
            '#ibox_board_round_content_patient_medically_fit_status_comment').val();
        if ($('input[name="ibox_board_round_content_patient_reason_to_reside"]:checked').length > 0) {
            var patient_reason_to_reside_status = $(
                'input[name="ibox_board_round_content_patient_reason_to_reside"]:checked').val();
        } else {
            var patient_reason_to_reside_status = 0;
        }

        if ($('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')) {
            var med_fit_set_as_no = 1;
            patient_reason_to_reside_status = 0;
        } else {
            var med_fit_set_as_no = 0;
        }
        if (camis_patient_id != '') {
            CommonDisableEnableOnSave();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url = "{{ route('UpdateReasonToReside') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "med_fit_set_as_no": med_fit_set_as_no,
                    "patient_reason_to_reside_status": patient_reason_to_reside_status,
                    "patient_med_fit_consultant_name": consultant_name,
                    "patient_medically_fit_status_comment": patient_medically_fit_status_comment
                },
                success: function(result) {

                    if (typeof result.message !== 'undefined') {
                        localStorage.setItem('reason_to_review_pending', camis_patient_id);
                        var check_reason_to_reside = localStorage.getItem(
                            'reason_to_review_pending');
                        $('.click_popup_open_ibox_board_round_reason_to_reside_show_category').html(
                            result.reason_to_reside_text_value_category);

                        // $('.click_popup_open_ibox_board_round_reason_to_reside_show_date').html(result.updated_date);


                        var next_patient = $(
                            '#ward_summary_boardround_modal_popup_camis_patient_id_next').val();
                        if (next_patient == '' || next_patient == null) {
                            localStorage.removeItem('reason_to_review_pending');
                            localStorage.setItem('this_is_last_patient', camis_patient_id);
                            var check_last_boardround = $('.add_attendance').css('display') ===
                                'block';

                            if (check_last_boardround) {
                                let board_round_run = localStorage.getItem('run_board_round');
                                if (board_round_run) {
                                    $('.button_ward_summary_boardround_next_patient').attr('id',
                                        'end_boardround');
                                    $('#end_boardround').removeClass(
                                        'button_ward_summary_boardround_next_patient');
                                    var token = "{{ csrf_token() }}";
                                    var ward_id =
                                        @if (isset($success_array['ward_details']['id']))
                                            {{ $success_array['ward_details']['id'] }}
                                        @else
                                            null
                                        @endif ;
                                    var url = "{{ route('KeepCacheBoardRoundConfig') }}";
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: {
                                            "_token": token,
                                            "camis_ward_id": ward_id
                                        },
                                        success: function(result) {



                                        }
                                    });
                                }

                            }
                        } else {
                            localStorage.removeItem('this_is_last_patient');
                        }
                        if (med_fit_set_as_no == 1) {
                            if ($('.click_popup_open_ibox_board_round_medfit_no').hasClass(
                                    'active')) {
                                $('.click_popup_open_ibox_board_round_medfit_no').removeClass(
                                    'active');
                            }


                            if (!$('.click_popup_open_ibox_board_round_medfit_yes').hasClass(
                                    'active')) {
                                $('.click_popup_open_ibox_board_round_medfit_yes').addClass(
                                    'active');
                            }



                            if ($('.path_way_selectbox').hasClass('careRequermentWrap')) {
                                $('.path_way_selectbox').removeClass('careRequermentWrap');
                            }

                            $('#ibox_pathway_data_update').prop("disabled", false);







                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.success('{{ DataUpdatedMessage() }}');
                        } else {

                            if (!$('.path_way_selectbox').hasClass('careRequermentWrap')) {
                                $('.path_way_selectbox').addClass('careRequermentWrap');
                            }
                            $('#ibox_pathway_data_update').prop("disabled", true);
                            if ($('.click_popup_open_ibox_board_round_medfit_yes').hasClass(
                                    'active')) {
                                $('.click_popup_open_ibox_board_round_medfit_yes').removeClass(
                                    'active');
                            }

                            if (!$('.click_popup_open_ibox_board_round_medfit_no').hasClass(
                                    'active')) {
                                $('.click_popup_open_ibox_board_round_medfit_no').addClass(
                                    'active');
                            }

                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.success('{{ DataUpdatedMessage() }}');
                        }



                        var patient_current_ward = $('#camis_patient_current_ward').val();
                        if (patient_current_ward == 'rltsauip') {
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_reason_to_reside');
                            toastr.success('{{ DataUpdatedMessage() }}');
                            var camis_patient_id = $(
                                    '#ward_summary_boardround_modal_popup_camis_patient_id_next')
                                .val();
                            var click_next_patient_offcanvas = $('#click_next_patient_offcanvas')
                                .val();
                            var click_boardround_close_offcanvas = $(
                                '#click_boardround_close_offcanvas').val();

                            if (click_boardround_close_offcanvas == 1) {
                                @php
                                    $ward_url_name = isset($success_array['ward_details']['ward_url_name']) ? $success_array['ward_details']['ward_url_name'] : '';
                                @endphp
                                var url = '{{ route('ward.ward-details', $ward_url_name) }}';

                                window.location.href = url;
                            }

                            $("input[name='bed_red_green_name']").prop('checked', false);
                            if (camis_patient_id != '' && click_next_patient_offcanvas == 1) {
                                BoardRoundData(camis_patient_id);
                            }
                            return;
                        }







                        $('input[name="bed_red_green_name"]').prop('disabled', true);
                        DisableSaveButtonForModals();
                        if (!$("#red_bed_modal").hasClass('d-none')) {
                            $("#red_bed_modal").addClass('d-none');
                        }
                        if (!$("#green_bed_modal").hasClass('d-none')) {
                            $("#green_bed_modal").addClass('d-none');
                        }
                        $("input[name='bed_red_green_name']").prop('checked', false);
                        $('#red_green_status_type').val(0);
                        if (result.patient_red_green_status == 2) {
                            $('#red_green_status_type').val(2);
                            $('input[name="bed_red_green_name"]').prop('disabled', true);
                            $('input[name="bed_red_green_name"]').prop('checked', false);
                            $('.red_bed_reason_list').addClass('d-none');
                            $('.red_bed_search_input').addClass('d-none');

                            if ($("#green_bed_modal").hasClass('d-none')) {
                                $("#green_bed_modal").removeClass('d-none');
                            }
                            EnableSaveButtonForModals();
                        } else if (result.patient_red_green_status == 1) {
                            $('#red_green_status_type').val(1);
                            $('.red_bed_reason_list').removeClass('d-none');
                            $('.red_bed_search_input').removeClass('d-none');
                            if ($("#red_bed_modal").hasClass('d-none')) {
                                $("#red_bed_modal").removeClass('d-none');
                            }
                            $('input[name="bed_red_green_name"]').prop('disabled', false);
                            var patient_red_green_status_reason_codes = result
                                .patient_red_green_status_reason_code;
                            var checked_text = [];
                            patient_red_green_status_reason_codes.forEach(function(value) {
                                var red_checkbox = $(
                                    'input[name="bed_red_green_name"][value="' + value +
                                    '"]');
                                var label_text = red_checkbox.closest('li').next('li')
                                    .text().trim();

                                checked_text.push(label_text);
                                $('input[name="bed_red_green_name"][value="' + value + '"]')
                                    .prop('checked', true);
                            });
                            var reason_spans = checked_text.map(function(text) {
                                return '<span>' + text + '</span>';
                            });
                            var reason_div_html = reason_spans.join('');

                            $('.red_block_list').html(reason_div_html);




                            EnableSaveButtonForModals();
                        } else {
                            $('.red_bed_reason_list').addClass('d-none');
                            $('.red_bed_search_input').addClass('d-none');
                        }

                        $("#resonToResideSection").hide();
                        $('.red_reason_list_block .reason-list').show();
                        $('#red_to_green_search').val('');
                        $(".camis_patient_ward_summary_boardround_save_reason_to_reside").addClass(
                            "camis_patient_ward_summary_boardround_save_red_green_bed");
                        $(".camis_patient_ward_summary_boardround_save_red_green_bed").removeClass(
                            "camis_patient_ward_summary_boardround_save_reason_to_reside");
                        $('#r2r_button_text').html('SAVE');
                        $('.reason_to_reside_modal_title').html('Bed Red Green Status');
                        $("#redToGreenSection").show();

                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).ready(function() {
        $('#red_to_green_search').on('input', function() {
            var filterValue = $(this).val().toLowerCase();
            $('.red_reason_list_block .reason-list').each(function() {
                var text = $(this).find('li:last-child').text().toLowerCase();
                if (text.indexOf(filterValue) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

    $(document).on("click", ".click_popup_open_ibox_board_round_medfit_yes_backup", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_medfit_yes');

        var url = "{{ route('GetMedFitForDischarge') }}";

        if (camis_patient_id != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (result.status == 1) {
                        var r2r_modal = new bootstrap.Offcanvas(document.getElementById(
                            'camis_patient_ward_summary_boardround_reason_to_reside'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: false
                        });

                        if (r2r_modal.isOpen) {
                            r2r_modal.hide();
                        }


                        setTimeout(function() {
                            var medfit_yes_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_medically_fit_for_discharge_yes'
                                ), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });
                            medfit_yes_modal.show();
                        }, 1000);
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableSaveButtonForModals();
                        $('#ibox_board_round_content_patient_medically_fit_status_comment').val(
                            result.patient_medically_fit_status_comment);


                        $('.medfit_yes_consultant_head_doctor_name').html($(
                            '.boardround_patient_consultant_full_name_show').html());
                    } else {

                        var common_modal = new bootstrap.Modal(document.getElementById(
                            'common_message_for_modal_show'));

                        common_modal.show();

                        $(".common_message_for_modal_show_title").html(
                            'Medically Fit For Discharge');
                        $(".common_message_for_modal_show_content").html(
                            '<div class="alert alert-success" style="text-align: center;">Patient Medically Fit Status Is Already Yes!</div>'
                        );
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".cdt_to_review", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var cdt_status_value = $('#cdt_status').val();
        if (cdt_status_value !== '' && cdt_status_value !== '3' && cdt_status_value !== '4') {
            var cdt_status = cdt_status_value;
        } else {
            var cdt_status = 0;
        }


        if (camis_patient_id != '' && cdt_status !== 'undefined') {

            var url = "{{ route('UpdateCDTStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "cdt_status": cdt_status
                },
                success: function(result) {

                    if (typeof result.message !== 'undefined') {
                        $('#cdt_status').val(result.cdt_status);
                        if (result.cdt_status == 0) {
                            $('#cdt_to_review').removeClass('cdt_to_review');
                            $('.cdt_to_review_time').removeClass('d-none');
                            $('#cdt_to_review').removeClass('bg-red');
                            $('#cdt_to_review').addClass('bg-amber');
                            $('#cdt_to_review').addClass('careRequermentWrap');


                            $('.cdt_to_review_time').html(result.cdt_updated_time);
                            toastr.success('{{ DataUpdatedMessage() }}');

                        } else if (result.cdt_status == 3) {
                            $('#cdt_to_review').removeClass('cdt_to_review');
                            $('.cdt_to_review_time').removeClass('d-none');
                            $('#cdt_to_review').removeClass('bg-red');
                            $('#cdt_to_review').addClass('bg-amber');
                            $('#cdt_to_review').addClass('careRequermentWrap');

                            $('.cdt_to_review_time').html(result.cdt_updated_time);
                            toastr.success('{{ DataUpdatedMessage() }}');
                        }
                        if ($('#camis_cdt_details_offcanvas').hasClass('show')) {
                            $('#cdt_text_in_boardround').html('CDT Referral');
                            CloseOffcanvas('camis_cdt_details_offcanvas');
                        }
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        if ($('#camis_cdt_details_offcanvas').hasClass('show')) {
                            CloseOffcanvas('camis_cdt_details_offcanvas');
                        }
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    if ($('#camis_cdt_details_offcanvas').hasClass('show')) {
                        CloseOffcanvas('camis_cdt_details_offcanvas');
                    }
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            if ($('#camis_cdt_details_offcanvas').hasClass('show')) {
                CloseOffcanvas('camis_cdt_details_offcanvas');
            }
            CommonErrorModalPopupOpenOnRequest();
        }



    });


    function ReasonToResideBlock(){
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (camis_patient_id != '') {
            EnableLoaderAndMakeHiddenInnerBody();
            var url = "{{ route('FetchPatientReasonToReside') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {


                        $(".all_reason_list_content").html(result.html);
                        DisableLoaderAndMakeVisibleInnerBody();


                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    }



    $(document).on("click", ".click_popup_open_ibox_board_round_medfit_no_modal", function(e) {



        if ($('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')) {
            $('.click_popup_open_ibox_board_round_medfit_yes_modal').removeClass('active');
        }
        if (!$('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')) {
            $('.click_popup_open_ibox_board_round_medfit_no_modal').addClass('active');
        }
        $('#ibox_board_round_content_med_fit_set_as_no').val(0);




        ReasonToResideBlock();
        DisableSaveButtonForModals();

        if (!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass(
                'camis_patient_ward_summary_boardround_save_reason_to_reside')) {
            $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass(
                'camis_patient_ward_summary_boardround_save_reason_to_reside');
        }

        if ($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass(
                'camis_patient_ward_summary_boardround_save_red_green_bed')) {
            $('.camis_patient_ward_summary_boardround_save_reason_to_reside').removeClass(
                'camis_patient_ward_summary_boardround_save_red_green_bed');
        }

        if (!$('.medfit-card').hasClass('d-none')) {
            $('.medfit-card').addClass('d-none');
        }
        $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show')
            .html());
        DisableSaveButtonForModals();
        if ($('.r2r_checkbox_section').hasClass('d-none')) {
            $('.r2r_checkbox_section').removeClass('d-none');
        }
    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_green_bed_status", function(e) {
        if (!$("#red_bed_modal").hasClass('d-none')) {
            $("#red_bed_modal").addClass('d-none');
        }

        $("#green_bed_modal").toggleClass('d-none');
        var isVisible = !$("#green_bed_modal").hasClass('d-none');
        $('#red_green_status_type').val(isVisible ? 2 : 0);


        if (isVisible) {
            EnableSaveButtonForModals();
            if (!$(".red_bed_reason_list").hasClass('d-none')) {
                $(".red_bed_reason_list").addClass('d-none');
                $('.red_bed_search_input').addClass('d-none');
            }
        } else {
            if (!$(".red_bed_reason_list").hasClass('d-none')) {
                $(".red_bed_reason_list").addClass('d-none');
                $('.red_bed_search_input').addClass('d-none');
            }
            EnableSaveButtonForModals();
        }
    });
    $(document).on("click", ".camis_patient_ward_summary_boardround_save_red_bed_status", function(e) {
        if (!$("#green_bed_modal").hasClass('d-none')) {
            $("#green_bed_modal").addClass('d-none');
        }
        $("#red_bed_modal").toggleClass('d-none');
        var isVisible = !$("#red_bed_modal").hasClass('d-none');
        $('#red_green_status_type').val(isVisible ? 1 : 0);


        if (isVisible) {

            DisableSaveButtonForModals();
            if ($(".red_bed_reason_list").hasClass('d-none')) {
                $(".red_bed_reason_list").removeClass('d-none');
                $('.red_bed_search_input').removeClass('d-none');
                $('.red_reason_list_block .reason-list').show();

            }

            $('input[name="bed_red_green_name"]').prop('disabled', false);
        } else {
            if (!$(".red_bed_reason_list").hasClass('d-none')) {
                $(".red_bed_reason_list").addClass('d-none');
                $('.red_bed_search_input').addClass('d-none');
            }
            EnableSaveButtonForModals();
        }
    });

    $(document).on("click", ".camis_patient_ward_summary_boardround_remove_green_bed_status", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (camis_patient_id != '') {
            var url = "{{ route('RemoveRedGreenBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        CommonDisableEnableAfterSave();
                        $("#camis_patient_ward_summary_boardround_red_green_bed_status_remove")
                            .modal('hide');
                        $(".red_green_tick_on_boardround_patient").addClass("content_display_none");
                        $(".board_round_select_patient_red_green_status_reason_code").removeClass(
                            "no_event_trigger_class");
                        $(".board_round_select_patient_red_green_status_reason_code").html('');


                        $("input[name=bed_red_green_name]").prop("disabled", true);
                        EnableDeleteButtonForModals();
                        var r2r_modal = new bootstrap.Offcanvas(document.getElementById(
                            'camis_patient_ward_summary_boardround_reason_to_reside'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: false
                        });

                        if (!r2r_modal.isOpen) {
                            toastr.success(result.message);
                        }
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });



    $(document).on("click", ".click_popup_open_ibox_board_round_medfit_yes", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $('#ibox_board_round_content_med_fit_set_as_no').val(1);
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_medfit_yes');
        if (camis_patient_id != '') {
            var url = "{{ route('GetReasonToReside') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {


                    if ($('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass(
                            'active')) {
                        $('.click_popup_open_ibox_board_round_medfit_no_modal').removeClass(
                            'active');
                    }
                    if (!$('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass(
                            'active')) {
                        $('.click_popup_open_ibox_board_round_medfit_yes_modal').addClass('active');
                    }
                    if (!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass(
                            'camis_patient_ward_summary_boardround_save_reason_to_reside')) {
                        $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass(
                            'camis_patient_ward_summary_boardround_save_reason_to_reside');
                    }
                    if ($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass(
                            'camis_patient_ward_summary_boardround_save_red_green_bed')) {
                        $('.camis_patient_ward_summary_boardround_save_reason_to_reside')
                            .removeClass(
                                'camis_patient_ward_summary_boardround_save_red_green_bed');
                    }
                    $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]")
                        .prop("disabled", true);
                    $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]")
                        .prop("disabled", false);
                    $('.reason_to_reside_modal_title').html('Reason To Reside');


                    if (!$('.reason_to_reside_close_area').hasClass('d-none')) {
                        $('.reason_to_reside_close_area').addClass('d-none');
                    }
                    if ($('.reason_to_reside_save_area').hasClass('d-none')) {
                        $('.reason_to_reside_save_area').removeClass('d-none');
                    }

                    if ($('.medfit-card').hasClass('d-none')) {
                        $('.medfit-card').removeClass('d-none');
                    }
                    $('#ibox_board_round_content_patient_medically_fit_status_comment').val(result
                        .patient_medically_fit_status_comment);
                    $('.medfit_yes_consultant_head_doctor_name').html($(
                        '.boardround_patient_consultant_full_name_show').html());
                    if (!$('.r2r_checkbox_section').hasClass('d-none')) {
                        $('.r2r_checkbox_section').addClass('d-none');
                    }
                    if (!$('.redbed_save_area').hasClass('d-none')) {
                        $('.redbed_save_area').addClass('d-none');
                    }
                    $("#resonToResideSection").show();
                    $("#redToGreenSection").hide();
                    var reason_to_reaside = new bootstrap.Offcanvas(document.getElementById(
                        'camis_patient_ward_summary_boardround_reason_to_reside'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: false
                    });
                    if (!reason_to_reaside.isOpen) {
                        reason_to_reaside.show();
                    }
                    CommonDisableEnableOnOpen();
                    DisableLoaderAndMakeVisibleInnerBody();



                    $('input[name="ibox_board_round_content_patient_reason_to_reside"]').prop(
                        'checked', false);
                    if (result.patient_reason_to_reside_status != '') {
                        $('input[name="ibox_board_round_content_patient_reason_to_reside"][value="' +
                            result.patient_reason_to_reside_status + '"]').prop('checked', true);
                        EnableSaveButtonForModals();
                    }
                    EnableSaveButtonForModals();

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".click_popup_open_ibox_board_round_medfit_yes_modal", function(e) {

        if ($('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')) {
            $('.click_popup_open_ibox_board_round_medfit_no_modal').removeClass('active');
        }
        if (!$('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')) {
            $('.click_popup_open_ibox_board_round_medfit_yes_modal').addClass('active');
        }
        $('#ibox_board_round_content_med_fit_set_as_no').val(1);
        $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("checked", true);
        $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("disabled", false);
        $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]").prop("disabled", true);
        EnableSaveButtonForModals();

        if (!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass(
                'camis_patient_ward_summary_boardround_save_reason_to_reside')) {
            $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass(
                'camis_patient_ward_summary_boardround_save_reason_to_reside');
        }
        if ($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass(
                'camis_patient_ward_summary_boardround_save_red_green_bed')) {
            $('.camis_patient_ward_summary_boardround_save_reason_to_reside').removeClass(
                'camis_patient_ward_summary_boardround_save_red_green_bed');
        }

        if ($('.medfit-card').hasClass('d-none')) {
            $('.medfit-card').removeClass('d-none');
        }
        $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show')
            .html());
        if (!$('.r2r_checkbox_section').hasClass('d-none')) {
            $('.r2r_checkbox_section').addClass('d-none');
        }

        EnableSaveButtonForModals();

    });




    $('#ibox_board_round_content_patient_medically_fit_status_comment').on('keydown', function(e) {

        EnableSaveButtonForModals();

    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_medfit_for_discharge", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_medically_fit_status_comment = $(
            '#ibox_board_round_content_patient_medically_fit_status_comment').val();
        var consultant_name = $('.boardround_patient_consultant_full_name_show').text();
        if (camis_patient_id != '') {
            localStorage.setItem('reason_to_review_pending', camis_patient_id);
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url = "{{ route('UpdateMedFitForDischargeYes') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_medically_fit_status_comment": patient_medically_fit_status_comment,
                    "patient_med_fit_consultant_name": consultant_name,
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        localStorage.setItem('reason_to_review_pending', camis_patient_id);
                        var check_reason_to_reside = localStorage.getItem(
                            'reason_to_review_pending');


                        var next_patient = $(
                            '#ward_summary_boardround_modal_popup_camis_patient_id_next').val();
                        if (next_patient == '' || next_patient == null) {
                            localStorage.removeItem('reason_to_review_pending');
                            localStorage.setItem('this_is_last_patient', camis_patient_id);
                            var check_last_boardround = $('.add_attendance').css('display') ===
                                'block';

                            if (check_last_boardround) {

                                $('.button_ward_summary_boardround_next_patient').attr('id',
                                    'start_boardround');

                            }
                        } else {
                            localStorage.removeItem('this_is_last_patient');
                        }

                        CloseOffcanvas(
                            'camis_patient_ward_summary_boardround_medically_fit_for_discharge_yes'
                        );
                        $('.click_popup_open_ibox_board_round_reason_to_reside_show_category').html(
                            result.reason_to_reside_text_value_category);
                        $('.click_popup_open_ibox_board_round_reason_to_reside_show_date').html('');


                        if ($('.click_popup_open_ibox_board_round_medfit_no').hasClass('active')) {
                            $('.click_popup_open_ibox_board_round_medfit_no').removeClass('active');
                        }


                        if ($('.click_popup_open_ibox_board_round_medfit_yes').hasClass('active')) {
                            $('.click_popup_open_ibox_board_round_medfit_yes').removeClass(
                                'active');
                        }



                        if (result.patient_medically_fit_status == 1) {
                            $('.click_popup_open_ibox_board_round_medfit_yes').addClass('active');
                        } else {
                            $('.click_popup_open_ibox_board_round_medfit_no').addClass('active');
                        }
                        $('.path_way_selectbox').removeClass('careRequermentWrap');
                        $('#ibox_pathway_data_update').selectric('destroy');
                        $('#ibox_pathway_data_update').prop("disabled", false);
                        $('#ibox_pathway_data_update').selectric();
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.success(result.message);
                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
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


    $(document).on("click", ".click_popup_open_ibox_board_round_medfit_no", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $('#ibox_board_round_content_med_fit_set_as_no').val(0);
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_medfit_no');
        if (camis_patient_id != '') {
            var url = "{{ route('GetReasonToReside') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {


                    if ($('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass(
                            'active')) {
                        $('.click_popup_open_ibox_board_round_medfit_yes_modal').removeClass(
                            'active');
                    }
                    if (!$('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass(
                            'active')) {
                        $('.click_popup_open_ibox_board_round_medfit_no_modal').addClass('active');
                    }
                    if (!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass(
                            'camis_patient_ward_summary_boardround_save_reason_to_reside')) {
                        $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass(
                            'camis_patient_ward_summary_boardround_save_reason_to_reside');
                    }
                    if ($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass(
                            'camis_patient_ward_summary_boardround_save_red_green_bed')) {
                        $('.camis_patient_ward_summary_boardround_save_reason_to_reside')
                            .removeClass(
                                'camis_patient_ward_summary_boardround_save_red_green_bed');
                    }
                    ReasonToResideBlock();
                    $('.reason_to_reside_modal_title').html('Reason To Reside');


                    if (!$('.reason_to_reside_close_area').hasClass('d-none')) {
                        $('.reason_to_reside_close_area').addClass('d-none');
                    }
                    if ($('.reason_to_reside_save_area').hasClass('d-none')) {
                        $('.reason_to_reside_save_area').removeClass('d-none');
                    }

                    if (!$('.redbed_save_area').hasClass('d-none')) {
                        $('.redbed_save_area').addClass('d-none');
                    }

                    if (!$('.medfit-card').hasClass('d-none')) {
                        $('.medfit-card').addClass('d-none');
                    }
                    $('#ibox_board_round_content_patient_medically_fit_status_comment').val('');
                    $('.medfit_yes_consultant_head_doctor_name').html($(
                        '.boardround_patient_consultant_full_name_show').html());
                    if ($('.r2r_checkbox_section').hasClass('d-none')) {
                        $('.r2r_checkbox_section').removeClass('d-none');
                    }

                    $("#resonToResideSection").show();
                    $("#redToGreenSection").hide();
                    var reason_to_reaside = new bootstrap.Offcanvas(document.getElementById(
                        'camis_patient_ward_summary_boardround_reason_to_reside'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: false
                    });
                    if (!reason_to_reaside.isOpen) {
                        reason_to_reaside.show();
                    }
                    CommonDisableEnableOnOpen();
                    DisableLoaderAndMakeVisibleInnerBody();


                    $('input[name="ibox_board_round_content_patient_reason_to_reside"]').prop(
                        'checked', false);
                    if (result.patient_reason_to_reside_status != '') {
                        $('input[name="ibox_board_round_content_patient_reason_to_reside"][value="' +
                            result.patient_reason_to_reside_status + '"]').prop('checked', true);
                        EnableSaveButtonForModals();
                    }



                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });





    $(document).on("click", ".task_assigned_doctors_night", function(e) {

        if ($('.task_assigned_doctors_night:checked').length > 0) {
            EnableSaveButtonForModals();
        } else {
            DisableSaveButtonForModals();
        }


    });










    $(document).on('click', '.click_popup_open_ibox_board_round_red_bed', function() {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_red_bed');
        if (camis_patient_id != '') {
            var url = "{{ route('GetRedGreenBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (result.patient_red_green_status == 1) {
                        $('#camis_patient_ward_summary_boardround_red_green_bed_status_remove')
                            .modal({
                                backdrop: 'static'
                            });
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableDeleteButtonForModals();
                    } else {
                        $('#camis_patient_ward_summary_boardround_red_green_bed_status').modal({
                            backdrop: 'static'
                        });
                        if (result.patient_red_green_status_reason_code != '') {
                            $('#patient_red_green_status_reason_code').val(result
                                .patient_red_green_status_reason_code).selectric('refresh');
                        }
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableSaveButtonForModals();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on('click', '.board_round_select_patient_red_green_status_reason_code', function() {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('board_round_select_patient_red_green_status_reason_code');
        if (camis_patient_id != '') {
            var url = "{{ route('GetRedGreenBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (result.patient_red_green_status == 1) {
                        $('#camis_patient_ward_summary_boardround_red_green_bed_status').modal({
                            backdrop: 'static'
                        });
                        if (result.patient_red_green_status_reason_code != '') {
                            $('#patient_red_green_status_reason_code').val(result
                                .patient_red_green_status_reason_code).selectric('refresh');
                        }
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableSaveButtonForModals();
                    } else {

                        var common_message_modal = new bootstrap.Modal(document.getElementById(
                            'common_message_for_modal_show'));

                        common_message_modal.show();
                        $(".common_message_for_modal_show_title").html('RED TO GREEN');
                        $(".common_message_for_modal_show_content").html(
                            '<div class="alert alert-danger" style="text-align: center;">Please Set The Red To Green Status As Red Before Setting Reason! </div>'
                        );
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $(document).on('click', '.click_popup_open_ibox_board_round_green_bed', function() {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_red_bed');
        if (camis_patient_id != '') {

            var url = "{{ route('GetRedGreenBedStatus') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (result.patient_red_green_status == 2) {
                        $('#camis_patient_ward_summary_boardround_red_green_bed_status_remove')
                            .modal({
                                backdrop: 'static'
                            });
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableDeleteButtonForModals();
                    } else {
                        $('#camis_patient_ward_summary_boardround_red_green_to_green_bed_status')
                            .modal({
                                backdrop: 'static'
                            });
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableSaveButtonForModals();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $('#patient_red_green_status_reason_code').val();

    $(document).on("change", "#board_round_show_patient_red_green_status_reason_code", function(e) {
        var patient_red_green_status_reason_code = $('#board_round_show_patient_red_green_status_reason_code')
            .val();
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $("#red_bed").css("display", "none");
        $("#green_bed").css("display", "none");
        if (camis_patient_id != '') {
            var url = "{{ route('UpdateRedGreenBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_red_green_status_reason_code": patient_red_green_status_reason_code,
                    "patient_red_green_status": 1
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $("#red_bed").css("display", "inline");
                        if (result.patient_red_green_status == 1) {
                            $('#board_round_show_patient_red_green_status_reason_code').prop(
                                "disabled", false);
                            $('#board_round_show_patient_red_green_status_reason_code').val(
                                patient_red_green_status_reason_code);
                        }
                        toastr.success(result.message);
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("change", "#ibox_pathway_data_update", function(e) {
        var pathway_id = $('#ibox_pathway_data_update').val();
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (camis_patient_id != '') {
            if (pathway_id == '') {
                toastr.warning('Please Select A Pathway Option');
                return;
            }
            var url = "{{ route('SaveDtocPathway') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "pathway_id": pathway_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        if (result.status == 1) {
                            $('#ibox_pathway_data_update').prop("disabled", false);
                            $('#ibox_pathway_data_update option[value="18"]').removeAttr(
                                'disabled');
                            $('#ibox_pathway_data_update option[value="19"]').removeAttr(
                                'disabled');
                            $('#ibox_pathway_data_update option:not([value="18"]):not([value="19"])')
                                .attr('disabled', true);
                            $('#ibox_pathway_data_update').prop("disabled", true);
                            toastr.success(result.message);

                        } else {
                            toastr.warning(result.message);
                        }

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });




    $(document).on("click", ".click_popup_open_ibox_board_round_potential_definite", function(e) {
        var token = "{{ csrf_token() }}";

        var old_pd_date = $('#pd_discharge_date').val();
        var old_pd_type = $('#pd_discharge_type').val();

        var patient_potential_definite_status = $(this).data('pd-option-value');
        var patient_potential_definite_date = $(this).data('pd-option-date');
        var patient_potential_definite_type = $(this).data('pd-option-type');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        //$(this).addClass('active');

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            var action_type = 'remove';
        } else {
            $('.click_popup_open_ibox_board_round_potential_definite').removeClass('active');
            $(this).addClass('active');
            var action_type = 'add';
        }

        if (camis_patient_id != '') {
            CommonToHideSubInnerPopupBoardround();
            var url = "{{ route('UpdatePotentialDefiniteBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id,
                    "patient_potential_definite_status": patient_potential_definite_status,
                    "patient_potential_definite_date": patient_potential_definite_date,
                    "patient_potential_definite_type": patient_potential_definite_type,
                    "action_type": action_type
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('#pd_discharge_date').val(patient_potential_definite_date);
                        $('#pd_discharge_type').val(patient_potential_definite_type);
                        toastr.success(result.message);
                    } else {

                        $('.click_popup_open_ibox_board_round_potential_definite').removeClass(
                            'active');
                        $('.click_popup_open_ibox_board_round_potential_definite').each(function() {
                            var $button = $(this);
                            var optionType = $button.data('pd-option-type');
                            var optionDate = $button.data('pd-option-date');

                            if (optionType == old_pd_type && optionDate == old_pd_date) {
                                $button.addClass('active');
                            }
                        });

                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $('.click_popup_open_ibox_board_round_potential_definite').removeClass(
                        'active');
                    $('.click_popup_open_ibox_board_round_potential_definite').each(function() {
                        var $button = $(this);
                        var optionType = $button.data('pd-option-type');
                        var optionDate = $button.data('pd-option-date');

                        if (optionType == old_pd_type && optionDate == old_pd_date) {
                            $button.addClass('active');
                        }
                    });
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('.click_popup_open_ibox_board_round_potential_definite').removeClass('active');
            $('.click_popup_open_ibox_board_round_potential_definite').each(function() {
                var $button = $(this);
                var optionType = $button.data('pd-option-type');
                var optionDate = $button.data('pd-option-date');

                if (optionType == old_pd_type && optionDate == old_pd_date) {
                    $button.addClass('active');
                }
            });
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".click_open_camis_patinet_dtoc_comments", function(e) {

        CommonDisableEnableOnOpen();
        DisableButtonClickForPreventFurtherEvent('click_open_camis_patinet_dtoc_comments');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var url = "{{ route('BoardRoundDtocWardAllComment', ':patientId') }}";
        url = url.replace(':patientId', camis_patient_id);

        var dtoc_comments_modal_modal = new bootstrap.Offcanvas(document.getElementById(
            'camis_dtoc_all_comments'), {
            relatedTarget: 'offcanvasRight',
            backdrop: false
        });

        dtoc_comments_modal_modal.show();


        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                if (result != '{{ PermissionDenied() }}') {
                    $('#viewAllCommentsBody').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                } else {
                    CloseOffcanvas('camis_dtoc_all_comments');
                    DisableLoaderAndMakeVisibleInnerBody();
                    toastr.error('Permission Restricted.');
                }
            },
            error: function(textStatus, errorThrown) {
                CloseOffcanvas('camis_dtoc_all_comments');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_remove_potential_definite_status", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (camis_patient_id != '') {
            CommonToHideSubInnerPopupBoardround();
            var url = "{{ route('RemovePotentialDefiniteBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $("#camis_patient_ward_summary_boardround_potential_definite_status_remove")
                            .modal('hide');
                        $(".potential_defenite_tick_on_boardround_patient").addClass(
                            "content_display_none");
                        toastr.success(result.message);
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on('click', '.click_popup_open_ibox_board_round_discharge_planning_tto', function() {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_tto_status = $(this).data('tto-option-value');
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_discharge_planning_tto');
        $("#boardround_tto_set_text_value").html('');
        if (camis_patient_id != '') {
            var url = "{{ route('GetTTOBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (result.discharge_planning_tto_status == patient_tto_status) {
                        $('#camis_patient_ward_summary_boardround_tto_status_remove').modal({
                            backdrop: 'static'
                        });
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableDeleteButtonForModals();
                    } else {
                        $('#camis_patient_ward_summary_boardround_tto_status').modal({
                            backdrop: 'static'
                        });
                        $('#ibox_board_round_patient_tto_status').val(patient_tto_status);
                        var set_text_tto_value = '';
                        if (patient_tto_status == 1) {
                            set_text_tto_value = 'YES';
                        } else if (patient_tto_status == 2) {
                            set_text_tto_value = 'NO';
                        } else if (patient_tto_status == 3) {
                            set_text_tto_value = 'NA';
                        }

                        $(".boardround_tto_set_text_value").html(
                            "<div class='tto_set_status_popup_style_" + set_text_tto_value +
                            "'>" + set_text_tto_value + "</div>");
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableSaveButtonForModals();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $(document).on("click", ".camis_patient_ward_summary_boardround_save_edn_status", function(e) {
        var token = "{{ csrf_token() }}";


        var old_edn_status = $('#current_edn_status').val();
        var discharge_planning_edn_status = $(this).data('edn-option-value');

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $('.camis_patient_ward_summary_boardround_save_edn_status').removeClass('active');
            $(this).addClass('active');
        }



        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $(".ibox_board_round_discharge_planning_edn_updated_date").html('');
        if (camis_patient_id != '') {
            CommonToHideSubInnerPopupBoardround();
            var url = "{{ route('UpdateEDNBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "discharge_planning_edn_status": discharge_planning_edn_status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('#current_edn_status').val(discharge_planning_edn_status);
                        toastr.success(result.message);

                    } else {
                        $('.camis_patient_ward_summary_boardround_save_edn_status').removeClass(
                            'active');
                        $('.camis_patient_ward_summary_boardround_save_edn_status').each(
                            function() {
                                var $button = $(this);
                                var edn_option = $button.data('edn-option-value');

                                if (edn_option == old_edn_status) {
                                    $button.addClass('active');
                                }
                            });


                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $('.camis_patient_ward_summary_boardround_save_edn_status').removeClass(
                        'active');
                    $('.camis_patient_ward_summary_boardround_save_edn_status').each(function() {
                        var $button = $(this);
                        var edn_option = $button.data('edn-option-value');

                        if (edn_option == old_edn_status) {
                            $button.addClass('active');
                        }
                    });
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('.camis_patient_ward_summary_boardround_save_edn_status').removeClass('active');
            $('.camis_patient_ward_summary_boardround_save_edn_status').each(function() {
                var $button = $(this);
                var edn_option = $button.data('edn-option-value');

                if (edn_option == old_edn_status) {
                    $button.addClass('active');
                }
            });
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on("click", ".camis_patient_ward_summary_boardround_save_tto_status", function(e) {
        var token = "{{ csrf_token() }}";


        var old_tto_status = $('#current_tto_status').val();
        var discharge_planning_tto_status = $(this).data('tto-option-value');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $('.camis_patient_ward_summary_boardround_save_tto_status').removeClass('active');
            $(this).addClass('active');
        }


        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $(".ibox_board_round_discharge_planning_tto_updated_date").html('');
        if (camis_patient_id != '') {
            CommonToHideSubInnerPopupBoardround();
            var url = "{{ route('UpdateTTOBedStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "discharge_planning_tto_status": discharge_planning_tto_status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('#current_tto_status').val(discharge_planning_tto_status);
                        toastr.success(result.message);
                    } else {
                        $('.camis_patient_ward_summary_boardround_save_tto_status').removeClass(
                            'active');
                        $('.camis_patient_ward_summary_boardround_save_tto_status').each(
                            function() {
                                var $button = $(this);
                                var tto_option = $button.data('tto-option-value');

                                if (tto_option == old_tto_status) {
                                    $button.addClass('active');
                                }
                            });

                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    $('.camis_patient_ward_summary_boardround_save_tto_status').removeClass(
                        'active');
                    $('.camis_patient_ward_summary_boardround_save_tto_status').each(function() {
                        var $button = $(this);
                        var tto_option = $button.data('tto-option-value');

                        if (tto_option == old_tto_status) {
                            $button.addClass('active');
                        }
                    });
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('.camis_patient_ward_summary_boardround_save_tto_status').removeClass('active');
            $('.camis_patient_ward_summary_boardround_save_tto_status').each(function() {
                var $button = $(this);
                var tto_option = $button.data('tto-option-value');

                if (tto_option == old_tto_status) {
                    $button.addClass('active');
                }
            });
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });




    $(document).on('click', '.click_popup_open_ibox_board_round_pharmacy', function() {

        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_pharmacy');
        $(".camis_patient_ward_summary_boardround_pharmacy_inner").html('');
        if (camis_patient_id != '') {
            var url = "{{ route('GetPharmacyStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {

                    if (result != '') {
                        $(".patient_drug_history_tick_icon").css("display", "none");
                        $(".camis_patient_ward_summary_boardround_pharmacy_inner").html(result);

                        var pharmacy_modal = new bootstrap.Offcanvas(document.getElementById(
                            'camis_patient_ward_summary_boardround_pharmacy'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: false
                        });
                        pharmacy_modal.show();
                        $("#pharmacy_latest_comment").focus();

                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        DisableSaveButtonForModals();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });



    $(document).on('click', '.patient_pharmacy_drug_history', function() {
        var current_date_to_add = $('#ibox_board_round_patient_current_date').val();
        var current_date_to_add_formatted = $('#ibox_board_round_patient_current_date_formatted').val();
        var pharmacy_data_history_value = $(this).data('pharmacy-drug-history-value');
        var pharmacy_data_history_type = $(this).data('pharmacy-drug-history-type');
        $('.patient_drug_history_updated_date').html('');
        $(".patient_drug_history_tick_icon").css("display", "none");
        $(".patient_drug_history_tick_icon_" + pharmacy_data_history_value).css("display", "inline");
        $('.pharmacy_update_time').html('');
        var current_time = moment();



        if ($(".patient_pharmacy_drug_history_" + pharmacy_data_history_value).hasClass("active")) {

            $(".patient_pharmacy_drug_history").removeClass("active");
            $('#ibox_board_round_patient_pharmacy_drug_history').val('');
            $('.pharmacy_update_time').html('');
            EnableSaveButtonForModals();
        } else {
            $('.pharmacy_update_time').html('');
            $(".patient_pharmacy_drug_history").removeClass("active");
            $(".patient_drug_history_updated_date_" + pharmacy_data_history_value).html(current_time.format(
                'ddd DD MMM  YYYY, HH:mm'));
            $("#ibox_board_round_patient_pharmacy_drug_history_date").val(current_time.format(
                'YYYY-MM-DD HH:mm:ss'));
            $(".patient_pharmacy_drug_history_" + pharmacy_data_history_value).addClass("active");
            $('#ibox_board_round_patient_pharmacy_drug_history').val(pharmacy_data_history_value);

            EnableSaveButtonForModals();
        }
        checkInputs();



    });

    function checkInputs() {
        var pharmacy_data_history_value = $('#ibox_board_round_patient_pharmacy_drug_history').val();
        var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();
        var patient_screened_val = $('#patient_screened_val').val();
        var content = $('.patient_drug_history_updated_date_partial').text();


        if (pharmacy_data_history_value !== '' || pharmacy_latest_comment !== '' || patient_screened_val !== '' ||
            content !== '') {
            EnableSaveButtonForModals();
        } else {

            EnableSaveButtonForModals();
        }
    }





    $(document).on('click', '.patient_screened', function() {

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('#patient_screened_val').val('');
            $('.patient_drug_history_updated_date_partial_pharmasict_screen').html('');




        } else {
            $(this).addClass('active');
            var patient_screened_date_val = $('#patient_screened_date_val').val();
            var patient_screened_val = $(this).data('patient_screened');
            $('#patient_screened_val').val(patient_screened_val);
            $('.patient_drug_history_updated_date_partial_pharmasict_screen').html(patient_screened_date_val);

        }
        checkInputs();

    });
    $(document).on("input", "#pharmacy_latest_comment", function(e) {
        checkInputs();
        var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();
        if (pharmacy_latest_comment != "") {
            EnableSaveButtonForModals();
        } else {
            DisableSaveButtonForModals();
        }
    });

    $(document).on('click', '.boardround_pharmacy_patient_comment_text_copy', function() {
        var pharmacy_data_copy_id = $(this).data('comment-text-show-id');
        var pharmacy_copy_text = $('.boardround_pharmacy_patient_comment_text_show_' + pharmacy_data_copy_id)
            .html();
        if (pharmacy_copy_text != '') {
            $('#pharmacy_latest_comment').val(pharmacy_copy_text);
        }

    });

    $(document).on('click', '.patient_pharmacy_antibiotic_iv', function() {

        var old_iv_date = $('#old_antibiotic_iv_time').val();
        var old_iv_since = $('#old_antibiotic_iv_time_since').val();

        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var pharmacy_antibiotic_iv_status = $('.patient_pharmacy_antibiotic_iv').data('antibiotic-iv');


        var now = moment();
        var var_current_time_update = now.format("Do MMM YYYY, HH:mm");
        var var_current_time_since = 'Since 0 Minutes';
        if (pharmacy_antibiotic_iv_status == 0) {
            var iv_status = 1;
            $(".patient_antibiotic_iv_updated_date").html(var_current_time_update);

            $(".patient_antibiotic_iv_updated_timestamp").html(var_current_time_since);

        } else {
            $(".patient_antibiotic_iv_updated_timestamp").html('');
            $(".patient_antibiotic_iv_updated_date").html('');
            var iv_status = 0;
        }
        var url = "{{ route('UpdateAntibioticIV') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "camis_patient_id": camis_patient_id,
                "pharmacy_antibiotic_iv_status": iv_status
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {


                    if (iv_status == 1) {
                        $('#old_antibiotic_iv_time').val(var_current_time_update);
                        $('#old_antibiotic_iv_time_since').val(var_current_time_since);
                        $('.patient_pharmacy_antibiotic_iv').data('antibiotic-iv', 1);
                    } else {
                        $('#old_antibiotic_iv_time').val('');
                        $('#old_antibiotic_iv_time_since').val('');
                        $('.patient_pharmacy_antibiotic_iv').data('antibiotic-iv', 0);
                    }
                    toastr.success(result.message);
                } else {
                    $(".patient_antibiotic_iv_updated_date").html(old_iv_date);

                    $(".patient_antibiotic_iv_updated_timestamp").html(old_iv_since);


                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            },
            error: function(textStatus, errorThrown) {
                $(".patient_antibiotic_iv_updated_date").html(old_iv_date);

                $(".patient_antibiotic_iv_updated_timestamp").html(old_iv_since);

                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });

    });



    $(document).on('click', '.patient_pharmacy_antibiotic_oral', function() {

        var old_oral_date = $('#old_antibiotic_oral_time').val();
        var old_oral_since = $('#old_antibiotic_oral_time_since').val();

        var now = moment();
        var var_current_time_update = now.format("Do MMM YYYY, HH:mm");
        var var_current_time_since = 'Since 0 Minutes';
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var pharmacy_antibiotic_oral_status = $('.patient_pharmacy_antibiotic_oral').data('antibiotic-oral');
        if (pharmacy_antibiotic_oral_status == 0) {
            var oral_status = 1;
            $(".patient_antibiotic_oral_updated_date").html(var_current_time_update);
            $(".patient_antibiotic_oral_updated_timestamp").html(var_current_time_since);

        } else {
            $(".patient_antibiotic_oral_updated_date").html('');
            $(".patient_antibiotic_oral_updated_timestamp").html('');
            var oral_status = 0;
        }
        var url = "{{ route('UpdateAntibioticOral') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "camis_patient_id": camis_patient_id,
                "pharmacy_antibiotic_oral_status": oral_status
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {


                    if (oral_status == 1) {
                        $('.patient_pharmacy_antibiotic_oral').data('antibiotic-oral', 1);
                        $('#old_antibiotic_oral_time').val(var_current_time_update);
                        $('#old_antibiotic_oral_time_since').val(var_current_time_since);
                    } else {
                        $('#old_antibiotic_oral_time').val('');
                        $('#old_antibiotic_oral_time_since').val('');
                        $('.patient_pharmacy_antibiotic_oral').data('antibiotic-oral', 0);
                    }
                    toastr.success(result.message);
                } else {
                    $(".patient_antibiotic_oral_updated_date").html(old_oral_date);
                    $(".patient_antibiotic_oral_updated_timestamp").html(old_oral_since);
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            },
            error: function(textStatus, errorThrown) {
                $(".patient_antibiotic_oral_updated_date").html(old_oral_date);
                $(".patient_antibiotic_oral_updated_timestamp").html(old_oral_since);
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });

    });

    $(document).ready(function() {
        $(document).on("keydown", ".pharmacy_content_textarea", function(e) {
            var pharmacy_drug_history = $('#ibox_board_round_patient_pharmacy_drug_history').val();
            var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();

            if (pharmacy_drug_history > 0 && pharmacy_latest_comment != '') {
                EnableSaveButtonForModals();
            }
        });
    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_pharmacy_info", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var pharmacy_drug_history = $('#ibox_board_round_patient_pharmacy_drug_history').val();
        var pharmacy_drug_history_date = $('#ibox_board_round_patient_pharmacy_drug_history_date').val();
        var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();
        var patient_screened_val = $('#patient_screened_val').val();
        var patient_screened_date_val = $('#patient_screened_date_val').val();
        $(".ibox_board_round_discharge_planning_tto_updated_date").html('');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();


        if (camis_patient_id != '') {
            console.log('success');
            var url = "{{ route('UpdatePharmacyStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "pharmacy_drug_history": pharmacy_drug_history,
                    "pharmacy_drug_history_date": pharmacy_drug_history_date,
                    "pharmacy_latest_comment": pharmacy_latest_comment,
                    "patient_screened_val": patient_screened_val,
                    "patient_screened_date_val": patient_screened_date_val,
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        CloseOffcanvas('camis_patient_ward_summary_boardround_pharmacy');
                        $(".ibox_board_round_pharmacy_updated_comment_show").val(result
                            .pharmacy_latest_comment);
                        $(".ibox_board_round_pharmacy_updated_text_show").html(result
                            .update_pharmacy_status);
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.success(result.message);
                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            toastr.warning('{{ ErrorOccuredMessage() }}');
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on("click", ".pharmacy_history_close", function(e) {
        CommonDisableEnableOnSave();


        CloseOffcanvas('camis_patient_ward_summary_boardround_pharmacy_history_modal');


        setTimeout(function() {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

            DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_pharmacy');
            $(".camis_patient_ward_summary_boardround_pharmacy_inner").html('');
            if (camis_patient_id != '') {
                var url = "{{ route('GetPharmacyStatus') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id
                    },
                    success: function(result) {

                        if (result != '') {
                            $(".patient_drug_history_tick_icon").css("display", "none");
                            $(".camis_patient_ward_summary_boardround_pharmacy_inner").html(
                                result);
                            var pharmacy_modal = new bootstrap.Offcanvas(document
                                .getElementById(
                                    'camis_patient_ward_summary_boardround_pharmacy'), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });
                            pharmacy_modal.show();


                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            DisableSaveButtonForModals();
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CommonErrorModalPopupOpenOnRequest();
            }
        }, 1000);

    });




    $(document).on('click', '.click_popup_open_ibox_board_round_allowed_to_move', function() {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();




        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_allowed_to_move');
        $(".camis_patient_ward_summary_boardround_pharmacy_inner").html('');
        if (camis_patient_id != '') {
            var url = "{{ route('GetAllowedToBeMoved') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.status !== 'undefined') {
                        var allowed_to_move_modal = new bootstrap.Offcanvas(document.getElementById(
                            'camis_patient_ward_summary_boardround_allowed_to_move'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: 'static'
                        });


                        allowed_to_move_modal.show();
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableSaveButtonForModals();
                        if (result.patient_allowed_to_be_moved_to != '') {


                            EnableDeleteButtonForModals();
                        }
                        $('#boardround_patient_allowed_to_be_moved_from').val(result
                            .patient_current_ward);
                        $('#allow_to_move_radio_yes').prop('checked', false);
                        $('#allow_to_move_radio_no').prop('checked', false);

                        $('input[name="allowed_to_move_checked_ward"]').prop('checked', false);
                        if (result.allowed_to_move_to != 0) {
                            if (result.allowed_to_move_to == 1) {
                                $('#allow_to_move_radio_yes').prop('checked', true);
                                $('input[name="allowed_to_move_checked_ward"][value="' + result
                                    .patient_allowed_to_be_moved_to + '"]').prop('checked',
                                    true);
                            } else if (result.allowed_to_move_to == 2) {
                                $('input[name="allowed_to_move_checked_ward"]').prop('checked',
                                    false);
                                $('input[name="allowed_to_move_checked_ward"]').prop('disabled',
                                    true);
                                $('#allow_to_move_radio_no').prop('checked', true);
                            }
                        } else {
                            $('input[name="allowed_to_move_checked_ward"]').prop('checked', false);
                            $('input[name="allowed_to_move_checked_ward"]').prop('disabled', true);
                            $('#allow_to_move_radio_no').prop('checked', false);
                        }
                        $('input[name="allowed_to_move_checked_ward"][value="' + result
                            .patient_current_ward + '"]').prop('disabled', true);

                        $("#boardround_patient_allowed_to_be_moved_comment").val(result
                            .patient_allowed_to_be_moved_comment);
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $("input[name='allow_to_move_radio']").on("change", function() {

        if ($(this).val() === "1") {
            $('input[name="allowed_to_move_checked_ward"]').prop('disabled', false);
        } else if ($(this).val() === "0") {
            $('input[name="allowed_to_move_checked_ward"]').prop('checked', false);
            $('input[name="allowed_to_move_checked_ward"]').prop('disabled', true);
        }
        var current_ward_name = $('#boardround_patient_allowed_to_be_moved_from').val();
        $('input[name="allowed_to_move_checked_ward"][value="' + current_ward_name + '"]').prop('disabled',
            true);

    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_remove_allowed_to_be_moved", function(e) {
        @if (CheckSpecificPermission('camis_allowed_to_move_delete'))

            DisableSaveButtonForModals();
            DisableDeleteButtonForModals();
            EnableDeleteButtonLoadImageForModals();
            HideModalFooterButtonForClick();
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            if (camis_patient_id != '') {
                CommonToHideSubInnerPopupBoardround();
                var url = "{{ route('RemoveAllowedToBeMoved') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            $('#boardround_patient_allowed_to_be_moved_to').val('').change()
                                .selectric('refresh');
                            CloseOffcanvas('camis_patient_ward_summary_boardround_allowed_to_move');
                            $(".click_popup_open_ibox_board_round_allowed_to_move").removeClass(
                                    "button_grey_gradiant").removeClass("button_red_gradiant")
                                .removeClass("button_blue_gradiant");
                            $(".click_popup_open_ibox_board_round_allowed_to_move").addClass(
                                "button_grey_gradiant");
                            $(".allowed_to_move_text").html('Allowed To Be Moved ?');

                            if ($(".allowed_to_move_color").hasClass("bg-btn-red")) {
                                $(".allowed_to_move_color").removeClass("bg-btn-red");
                            }
                            $('input[name="allowed_to_move_checked_ward"]').prop('checked', false);
                            toastr.success(result.message);
                            EnableDeleteButtonForModals();
                            DisableSaveButtonLoadImageForModals();
                            DisableDeleteButtonLoadImageForModals();
                            ShowModalFooterButtonForClick();
                        } else {
                            DisableDeleteButtonForModals();
                            DisableSaveButtonLoadImageForModals();
                            DisableDeleteButtonLoadImageForModals();
                            ShowModalFooterButtonForClick();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CommonErrorModalPopupOpenOnRequest();
            }
        @else
            PermissionDeniedAlert();
        @endif
    });

    $(document).on("click", ".camis_patient_ward_summary_boardround_save_allowed_to_be_moved", function(e) {

        if ($('#allow_to_move_radio_yes').is(':checked') || $('#allow_to_move_radio_no').is(':checked')) {
            if ($('#allow_to_move_radio_yes').is(':checked') && $(
                    "input[name='allowed_to_move_checked_ward']:checked").length === 0) {
                toastr.warning('Please Select Ward');
                return;
            }
        } else {
            toastr.warning('Please select Allowed To Be Moved option.');
            return
        }



        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        HideModalFooterButtonForClick();
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var patient_allowed_to_be_moved_to = $('input[name="allowed_to_move_checked_ward"]:checked').val();
        var patient_allowed_to_be_moved_from = $('#boardround_patient_allowed_to_be_moved_from').val();
        var patient_allowed_to_be_moved_comment = $('#boardround_patient_allowed_to_be_moved_comment').val();
        var allowed_radio_value = $("#allow_to_move_radio:checked").val();
        if (allowed_radio_value == 0) {
            var patient_allowed_to_be_moved_to = 'Do Not Move';
        }

        if ($('#allow_to_move_radio_no').is(':checked')) {
            var patient_allowed_to_be_moved_to = 'Do Not Move';
        }
        if (patient_allowed_to_be_moved_to == null || patient_allowed_to_be_moved_to == '') {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            ShowModalFooterButtonForClick();
            toastr.warning('Please Select A Ward');
            return;
        }

        if (camis_patient_id != '' && patient_allowed_to_be_moved_to != "") {
            CommonToHideSubInnerPopupBoardround();
            var url = "{{ route('UpdateAllowedToBeMoved') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "patient_allowed_to_be_moved_to": patient_allowed_to_be_moved_to,
                    "patient_allowed_to_be_moved_from": patient_allowed_to_be_moved_from,
                    "patient_allowed_to_be_moved_comment": patient_allowed_to_be_moved_comment
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        CloseOffcanvas('camis_patient_ward_summary_boardround_allowed_to_move');
                        $(".click_popup_open_ibox_board_round_allowed_to_move").removeClass(
                                "button_grey_gradiant").removeClass("button_red_gradiant")
                            .removeClass("button_blue_gradiant");
                        $(".allowed_to_move_text").html('Allowed To Be Moved ?');
                        if (result.patient_allowed_to_be_moved_to == '') {
                            $(".click_popup_open_ibox_board_round_allowed_to_move").addClass(
                                "button_grey_gradiant");
                            $(".allowed_to_move_text").html('Allowed To Be Moved ?');
                        } else if (result.patient_allowed_to_be_moved_to == 'Do Not Move') {
                            $(".click_popup_open_ibox_board_round_allowed_to_move").addClass(
                                "button_red_gradiant");

                            $(".allowed_to_move_color").addClass("bg-btn-red");
                            $(".allowed_to_move_text").html('Do Not Move');
                        } else {
                            $(".click_popup_open_ibox_board_round_allowed_to_move").addClass(
                                "button_blue_gradiant");
                            $(".allowed_to_move_color").removeClass("bg-btn-red");
                            $(".allowed_to_move_text").html(result.patient_allowed_to_be_moved_to);
                        }
                        toastr.success(result.message);
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    DisableSaveButtonForModals();
                    DisableDeleteButtonForModals();
                    ShowModalFooterButtonForClick();
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    DisableSaveButtonLoadImageForModals();
                    DisableSaveButtonForModals();
                    DisableDeleteButtonForModals();
                    ShowModalFooterButtonForClick();
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            toastr.warning('{{ ErrorOccuredMessage() }}');
            DisableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            DisableDeleteButtonForModals();
            ShowModalFooterButtonForClick();
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $(document).on("click", ".board_round_restart", function(e) {
        var boardround_config = $('#board_round_selected_config').val();
        var type = "";
        var doctor_id = "";

        if (boardround_config == 'stranded') {
            var type = "stranded";
        } else if (boardround_config == "bed_order") {
            var type = "bed_order";
        } else {
            var type = "doctor";
            var doctor_id = boardround_config;
        }

        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('CamisStartBoardRound') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id,
                "type": "bed_order",
                "restart_bed_order": 1
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {

                    $('.show_boardround_history').html(result.sections);
                    $('#board_round_selected_config_current').val(boardround_config);
                    $('#board_round_selected_config').val(boardround_config);
                    $(".boardround_tick").css("display", "none");
                    $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display",
                        "inline");
                    $('.board_round_button_text').html('Resume');
                    $(".boardround_cancel_button").addClass('d-none');
                    $(".finish_boardround").removeClass('d-none');
                    $(".camis_ward_action_boardround").addClass('board_round_resume');
                    $(".camis_ward_action_boardround").removeClass('board_round_start');
                    $("#modal_start_boardround").offcanvas('hide');
                    $(".add_attendance").css("display", "block");
                    $('#is_next_popup_need_to_open').val(1);
                    let board_round_run = localStorage.getItem('run_board_round');
                    if (!board_round_run) {
                        localStorage.setItem('run_board_round', 1);
                    }


                    @if (
                        !in_array(request()->route()->getName(), [
                            'ward.ward-details',
                            'CcuItuWard.ward-details',
                            'site.stranded_patients',
                        ]))
                        $('#homepage_id').attr('href', '#');
                        $('#homepage_id').attr('onclick',
                            "CloseBoardRound('{{ $success_array['ward_details']['ward_url_name'] }}')"
                        );
                    @endif
                    @if (in_array(request()->route()->getName(), ['ward.ward-details', 'CcuItuWard.ward-details']))
                        @php
                            $ward_url_name = isset($success_array['ward_details']['ward_url_name']) ? $success_array['ward_details']['ward_url_name'] : '';
                        @endphp
                        var url =
                            "{{ route('ward.boardround', ['ward' => $ward_url_name, 'patient_id' => ':id']) }}";
                        url = url.replace(':id', result.boardround_resume_last_patient);
                        var board_round = window.open(url, '_self');
                        if (result.boardround_resume_last_patient != "") {
                            board_round.focus();
                        }
                    @else
                        $("#modal_start_boardround").offcanvas('hide');
                        CloseOffcanvas('modal_start_boardround');
                        BoardRoundData(result.boardround_resume_last_patient);
                    @endif
                    toastr.success('Board Round Started');
                    DisableLoaderAndMakeVisibleInnerBody();
                } else {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }

            },
            error: function(textStatus, errorThrown) {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });


    });
    $(document).on("click", ".click_popup_open_ibox_board_round_doctors_at_night", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_doctors_at_night');

        if (camis_patient_id != '') {
            var url = "{{ route('GetDoctorAtNight') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    $('.show_doctors_at_night_task').html(result);

                    var doctor_at_night_modal = new bootstrap.Offcanvas(document.getElementById(
                        'camis_patient_ward_summary_boardround_doctors_at_night'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: false
                    });

                    doctor_at_night_modal.show();
                    CommonDisableEnableOnOpen();
                    DisableSaveButtonForModals();
                    DisableLoaderAndMakeVisibleInnerBody();

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $(document).on("click", ".task_assigned_doctors_night", function(e) {
        @if (CheckSpecificPermission('camis_doctor_at_night_add'))
            if ($('.task_assigned_doctors_night:checked').length > 0) {
                EnableSaveButtonForModals();
            } else {
                DisableSaveButtonForModals();
            }
        @else
            e.preventDefault();
            toastr.error('Permission Denied');
        @endif
    });

    $(document).on("click", ".camis_patient_ward_summary_boardround_update_doctor_at_night", function(e) {
        @if (CheckSpecificPermission('camis_doctor_at_night_add'))


            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            HideModalFooterButtonForClick();
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            var tasks_to_be_assigned = [];
            $('.task_assigned_doctors_night:checked').each(function(index, value) {
                tasks_to_be_assigned.push($(value).val());
            });

            DisableButtonClickForPreventFurtherEvent(
                'camis_patient_ward_summary_boardround_update_doctor_at_night');
            var url = "{{ route('UpdateDoctorAtNight') }}";

            if (camis_patient_id != '') {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id,
                        "tasks_to_be_assigned": tasks_to_be_assigned
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_doctors_at_night');
                            toastr.success(result.message);
                            EnableSaveButtonForModals();
                            ShowModalFooterButtonForClick();
                            DisableLoaderAndMakeVisibleInnerBody();
                        } else {
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            EnableSaveButtonForModals();
                            ShowModalFooterButtonForClick();
                            DisableLoaderAndMakeVisibleInnerBody();
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                    error: function(textStatus, errorThrown) {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        EnableSaveButtonForModals();
                        ShowModalFooterButtonForClick();
                        DisableLoaderAndMakeVisibleInnerBody();
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                EnableSaveButtonForModals();
                ShowModalFooterButtonForClick();
                DisableLoaderAndMakeVisibleInnerBody();
                CommonErrorModalPopupOpenOnRequest();
                CommonErrorModalPopupOpenOnRequest();
            }
        @else
            toastr.error('Permission Denied');
        @endif
    });



    $(document).on("click", ".ward_movement_history_details", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_nok');
        DisableLoaderAndMakeVisibleInnerBody();
        if (camis_patient_id != '') {
            var url = "{{ route('GetPatientWardMovementHistory') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result !== '') {
                        $('.ibox_board_round_patient_ward_movement_history').html(result);
                        var patient_history_modal = new bootstrap.Offcanvas(document.getElementById(
                            'camis_patient_ward_summary_boardround_ward_movement_history'
                        ), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: false
                        });

                        patient_history_modal.show();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".click_open_boardround_outstanding_task_offcanvas", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_pmi_link').val();
        var outstanding_modal = new bootstrap.Offcanvas(document.getElementById(
            'board_round_outstanding_tasks_offcanvas'), {
            relatedTarget: 'offcanvasRight',
            backdrop: false
        });

        outstanding_modal.show();
        EnableLoaderAndMakeHiddenInnerBody();
        DisableButtonClickForPreventFurtherEvent('click_open_boardround_outstanding_task_offcanvas');

        if (camis_patient_id != '') {
            var url = "{{ route('GetPatientOutstandingTasks') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.patient_outstanding_task_data').html(result.sections);
                        DisableLoaderAndMakeVisibleInnerBody();

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".click_popup_open_ibox_board_round_nok", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();


        DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_nok');
        DisableLoaderAndMakeVisibleInnerBody();
        if (camis_patient_id != '') {
            var url = "{{ route('GetNextOfKin') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_nok_show').html(result.sections);
                        var nok_modal = new bootstrap.Offcanvas(document.getElementById(
                            'camis_patient_ward_summary_boardround_nok'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: false
                        });

                        nok_modal.show();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".show_pathway_history", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $('.show_boardround_pathway_history').html('');

        var history_modal = new bootstrap.Offcanvas(document.getElementById(
            'camis_patient_ward_boardround_show_pathway_history'), {
            relatedTarget: 'offcanvasRight',
            backdrop: false
        });

        history_modal.show();
        if (camis_patient_id != '') {
            var url = "{{ route('FetchBoardRoundPathwayHistory') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result != '') {

                        $('.show_boardround_pathway_history').html(result);
                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", ".button_ward_summary_boardround_show_history", function(e) {
        $('.modal-popup-loader-content').show();
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        $('.show_boardround_history').html('');

        var history_modal = new bootstrap.Offcanvas(document.getElementById(
            'camis_patient_ward_boardround_show_history'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        history_modal.show();
        if (camis_patient_id != '') {
            var url = "{{ route('FetchBoardRoundHistory') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id,
                    @isset($success_array['ward_details']['ward_name'])
                        "ward_name": "{{ $success_array['ward_details']['ward_name'] }}"
                    @endisset
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {

                        $('.show_boardround_history').html(result.sections);
                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    $('.modal-popup-loader-content').hide();

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    $('.modal-popup-loader-content').hide();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("click", "#start_boardround", function(e) {
        $('.boardround_config_type').removeClass('active');
        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById(
            'modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: true
        });

        start_boardround_modal.show();
        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);

                var is_board_round_done = $('#is_board_round_done').val();
                if (is_board_round_done == 1) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                } else {
                    $('.camis_ward_action_boardround').removeClass('board_round_done');
                }
                if ($('.boardround_config_type.bg-complete.active').length > 0) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }

                var all_have_bg_complete = true;
                $('.boardround_type_other').each(function() {
                    if (!$(this).hasClass('bg-complete')) {
                        all_have_bg_complete = false;
                        return false;
                    }
                });

                if (all_have_bg_complete) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                    $('.config_type_bed_order').addClass('bg-complete');
                    $('.time_bed_order').html(function(index, old_html) {

                        var time_string = '({{ CurrentDateOnFormat() }})';

                        return 'Completed' + time_string;
                    });

                }
                if (!$('.boardround_config_type').hasClass('active')) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var board_round_selected_config = $('#board_round_selected_config').val();
                if (board_round_selected_config == '') {
                    $('.boardround_config_type').removeClass('active');
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }

                $('.boardround_config_type').each(function() {
                    if ($(this).hasClass('bg-complete') && $(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                var missed_patient = $('#missed_boardround_patients').val();

                if (missed_patient > 0) {
                    if ($('.finish_boardround').hasClass('get_board_round_user_list')) {
                        $('.finish_boardround').removeClass('get_board_round_user_list');
                    }

                    if (!$('.finish_boardround').hasClass(
                            'get_board_round_user_list_with_warning')) {
                        $('.finish_boardround').addClass('get_board_round_user_list_with_warning');
                    }
                } else {
                    if ($('.finish_boardround').hasClass('get_board_round_user_list')) {
                        $('.finish_boardround').addClass('get_board_round_user_list');
                    }

                    if (!$('.finish_boardround').hasClass(
                            'get_board_round_user_list_with_warning')) {
                        $('.finish_boardround').removeClass(
                            'get_board_round_user_list_with_warning');
                    }
                }
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    });

    $(document).on("click", "#end_boardround", function(e) {



        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('KeepCacheBoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {



            }
        });


        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById(
            'modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: true
        });

        start_boardround_modal.show();
        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);

                var is_board_round_done = $('#is_board_round_done').val();
                if (is_board_round_done == 1) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                } else {
                    $('.camis_ward_action_boardround').removeClass('board_round_done');
                }
                if ($('.boardround_config_type.bg-complete.active').length > 0) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var all_have_bg_complete = true;
                $('.boardround_type_other').each(function() {
                    if (!$(this).hasClass('bg-complete')) {
                        all_have_bg_complete = false;
                        return false;
                    }
                });

                if (all_have_bg_complete) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                    $('.config_type_bed_order').addClass('bg-complete');
                    $('.time_bed_order').html(function(index, old_html) {

                        var time_string = '({{ CurrentDateOnFormat() }})';

                        return 'Completed' + time_string;
                    });

                }
                if (!$('.boardround_config_type').hasClass('active')) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var board_round_selected_config = $('#board_round_selected_config').val();
                if (board_round_selected_config == '') {
                    $('.boardround_config_type').removeClass('active');
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                $('.boardround_config_type').each(function() {
                    if ($(this).hasClass('bg-complete') && $(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    });


    $(document).on("click", ".confirm_boardround", function(e) {

        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById(
            'modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: true
        });

        start_boardround_modal.show();
        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);

                var is_board_round_done = $('#is_board_round_done').val();
                if (is_board_round_done == 1) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                } else {
                    $('.camis_ward_action_boardround').removeClass('board_round_done');
                }
                if ($('.boardround_config_type.bg-complete.active').length > 0) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var all_have_bg_complete = true;
                $('.boardround_type_other').each(function() {
                    if (!$(this).hasClass('bg-complete')) {
                        all_have_bg_complete = false;
                        return false;
                    }
                });

                if (all_have_bg_complete) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                    $('.config_type_bed_order').addClass('bg-complete');
                    $('.time_bed_order').html(function(index, old_html) {

                        var time_string = '({{ CurrentDateOnFormat() }})';

                        return 'Completed' + time_string;
                    });

                }
                if (!$('.boardround_config_type').hasClass('active')) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                $('.boardround_config_type').each(function() {
                    if ($(this).hasClass('bg-complete') && $(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                var board_round_selected_config = $('#board_round_selected_config').val();
                if (board_round_selected_config == '') {
                    $('.boardround_config_type').removeClass('active');
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    });

    $(document).on("click", ".boardround_config_type", function(e) {
        //if(!$(this).hasClass('bg-complete')){

        $('.missing-patients-card').html('');
        $('.boardround_config_type').removeClass('active');
        $(".boardround_tick").css("display", "none");
        var boardround_config = $(this).data('boardround-config');
        $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display", "inline");
        $("." + $.escapeSelector("config_type_" + boardround_config)).addClass('active');

        $('.board_round_button_text').html('Start');
        $(".camis_ward_action_boardround").removeClass('board_round_resume');
        $(".camis_ward_action_boardround").addClass('board_round_start');
        $('#board_round_selected_config').val(boardround_config);

        $('.camis_ward_action_boardround').removeClass('board_round_done');
        if ($(this).hasClass('bg-complete')) {
            $('.board_round_button_text').html('Start Again');
        }
        var boardround_config_current = $('#board_round_selected_config_current').val();
        if (boardround_config == boardround_config_current && !$(this).hasClass('bg-complete')) {
            $('.board_round_button_text').html('Resume');
            $(".camis_ward_action_boardround").addClass('board_round_resume');
            $(".camis_ward_action_boardround").removeClass('board_round_start');
        }

        EnableSaveButtonForModals();
        // } else {
        //     toastr.warning('Board Round Already Completed For The Selected Type');
        // }

    });

    $(document).on("click", ".board_round_start", function(e) {
        var boardround_config = $('#board_round_selected_config').val();
        var type = "";
        var doctor_id = "";
        if (boardround_config) {

            if (boardround_config == 'stranded') {
                var type = "stranded";
            } else if (boardround_config == "bed_order") {
                var type = "bed_order";
            } else {
                var type = "doctor";
                var doctor_id = boardround_config;
            }

            var token = "{{ csrf_token() }}";
            var ward_id =
                @if (isset($success_array['ward_details']['id']))
                    {{ $success_array['ward_details']['id'] }}
                @else
                    null
                @endif ;
            var url = "{{ route('CamisStartBoardRound') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_ward_id": ward_id,
                    "type": type,
                    "doctor_id": doctor_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {

                        $('.show_boardround_history').html(result.sections);
                        $('#board_round_selected_config_current').val(boardround_config);
                        $('#board_round_selected_config').val(boardround_config);
                        $(".boardround_tick").css("display", "none");
                        $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display",
                            "inline");

                        $('.board_round_button_text').html('Resume');
                        $(".boardround_cancel_button").addClass('d-none');
                        $(".finish_boardround").removeClass('d-none');
                        $(".camis_ward_action_boardround").addClass('board_round_resume');
                        $(".camis_ward_action_boardround").removeClass('board_round_start');
                        $("#modal_start_boardround").offcanvas('hide');
                        $(".add_attendance").css("display", "block");
                        $('#is_next_popup_need_to_open').val(1);
                        let board_round_run = localStorage.getItem('run_board_round');
                        if (!board_round_run) {
                            localStorage.setItem('run_board_round', 1);
                        }


                        @if (!in_array(request()->route()->getName(), ['ward.ward-details', 'site.stranded_patients']))
                            $('#homepage_id').attr('href', '#');
                            $('#homepage_id').attr('onclick',
                                "CloseBoardRound('{{ $success_array['ward_details']['ward_url_name'] }}')"
                            );
                        @endif
                        @if (request()->route()->getName() == 'ward.ward-details')
                            @php
                                $ward_url_name = isset($success_array['ward_details']['ward_url_name']) ? $success_array['ward_details']['ward_url_name'] : '';
                            @endphp
                            var url =
                                "{{ route('ward.boardround', ['ward' => $ward_url_name, 'patient_id' => ':id']) }}";
                            url = url.replace(':id', result.boardround_resume_last_patient);
                            var board_round = window.open(url, '_self');
                            if (result.boardround_resume_last_patient != "") {
                                board_round.focus();
                            }
                        @else
                            $("#modal_start_boardround").offcanvas('hide');
                            BoardRoundData(result.boardround_resume_last_patient);
                        @endif
                        toastr.success('Board Round Started');
                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        } else {
            toastr.error('Please Select Any Options To Run Board Round');
        }
    });


    $(document).on("click", ".board_round_resume", function(e) {
        $('.boardround_config_type').removeClass('active');
        var boardround_config = $('#board_round_selected_config').val();
        var type = "";
        var doctor_id = "";


        let board_round_missed = localStorage.getItem('board_round_missed');
        if (board_round_missed) {
            localStorage.removeItem('board_round_missed');
        }

        var boardround_type = $(this).data('boardround-missed');
        if (boardround_type == 1) {
            localStorage.setItem('board_round_missed', 1);
        }
        if (boardround_config) {

            if (boardround_config == 'stranded') {
                var type = "stranded";
            } else if (boardround_config == "bed_order") {
                var type = "bed_order";
            } else {
                var type = "doctor";
                var doctor_id = boardround_config;
            }

            var token = "{{ csrf_token() }}";
            var ward_id =
                @if (isset($success_array['ward_details']['id']))
                    {{ $success_array['ward_details']['id'] }}
                @else
                    null
                @endif ;
            var url = "{{ route('CamisResumeBoardRound') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_ward_id": ward_id,
                    "type": type,
                    "doctor_id": doctor_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {

                        $('.show_boardround_history').html(result.sections);
                        var checkdata = "Option 2";
                        $('#board_round_selected_config_current').val(boardround_config);
                        $('#board_round_selected_config').val(boardround_config);
                        $(".boardround_tick").css("display", "none");
                        $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display",
                            "inline");

                        $("#camis_patients_start_boardround").modal('hide');
                        $(".add_attendance").css("display", "block");
                        $('#is_next_popup_need_to_open').val(1);
                        let board_round_run = localStorage.getItem('run_board_round');
                        if (!board_round_run) {
                            localStorage.setItem('run_board_round', 1);
                        }
                        $("#modal_start_boardround").offcanvas('hide');
                        @if (request()->route()->getName() == 'ward.ward-details')
                            @php
                                $ward_url_name = isset($success_array['ward_details']['ward_url_name']) ? $success_array['ward_details']['ward_url_name'] : '';
                            @endphp
                            var url =
                                "{{ route('ward.boardround', ['ward' => $ward_url_name, 'patient_id' => ':id']) }}";
                            url = url.replace(':id', result.boardround_resume_last_patient);
                            var board_round = window.open(url, '_self');
                            if (result.boardround_resume_last_patient != "") {
                                board_round.focus();
                            }
                        @else
                            BoardRoundData(result.boardround_resume_last_patient);
                        @endif
                        DisableLoaderAndMakeVisibleInnerBody();
                        toastr.success('Board Round Started');
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        } else {
            toastr.error('Please Select Any Options To Run Board Round');
        }
    });

    $(document).on("click", ".get_board_round_user_list", function(e) {


        $("#modal_start_boardround").offcanvas('hide');
        if ($('#get_board_round_user_list_with_warning').hasClass('show')) {
            $('#get_board_round_user_list_with_warning').modal('hide');
        }
        setTimeout(function() {
            var attendance_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_boardround_attendance'), {
                relatedTarget: 'offcanvasRight',
                backdrop: true
            });
            attendance_modal.show();
        }, 1000);

        DisableDeleteButtonForModals();
        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('GetWardRoundUser') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {

                    $('#attendance_user_list').html(result.sections);

                    setTimeout(function() {
                        DisableLoaderAndMakeVisibleInnerBody();
                    }, 1000);

                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }

            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });



    });


    $(document).on("click", ".get_board_round_user_list_with_warning", function(e) {
        var missed_patient = $('#missed_boardround_patients').val();
        $('.show_missing_number').html(missed_patient);
        var finished_boardround_modal = new bootstrap.Modal(document.getElementById(
            'get_board_round_user_list_with_warning'), {
            backdrop: false
        });

        finished_boardround_modal.show();
    });

    $(document).on("click", ".addAttBtn", function(e) {



        $('.boardround_config_type').removeClass('active');
        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById(
            'modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: true
        });

        start_boardround_modal.show();


        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);
                var is_board_round_done = $('#is_board_round_done').val();
                if (is_board_round_done == 1) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                } else {
                    $('.camis_ward_action_boardround').removeClass('board_round_done');
                }
                if ($('.boardround_config_type.bg-complete.active').length > 0) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var all_have_bg_complete = true;
                $('.boardround_type_other').each(function() {
                    if (!$(this).hasClass('bg-complete')) {
                        all_have_bg_complete = false;
                        return false;
                    }
                });

                if (all_have_bg_complete) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                    $('.config_type_bed_order').addClass('bg-complete');
                    $('.time_bed_order').html(function(index, old_html) {

                        var time_string = '({{ CurrentDateOnFormat() }})';

                        return 'Completed' + time_string;
                    });

                }
                if (!$('.boardround_config_type').hasClass('active')) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }

                $('.boardround_config_type').each(function() {
                    if ($(this).hasClass('bg-complete') && $(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });


                var board_round_selected_config = $('#board_round_selected_config').val();
                if (board_round_selected_config == '') {
                    $('.boardround_config_type').removeClass('active');
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var missed_patient = $('#missed_boardround_patients').val();

                if (missed_patient > 0) {
                    if ($('.finish_boardround').hasClass('get_board_round_user_list')) {
                        $('.finish_boardround').removeClass('get_board_round_user_list');
                    }

                    if (!$('.finish_boardround').hasClass(
                            'get_board_round_user_list_with_warning')) {
                        $('.finish_boardround').addClass('get_board_round_user_list_with_warning');
                    }
                } else {
                    if ($('.finish_boardround').hasClass('get_board_round_user_list')) {
                        $('.finish_boardround').addClass('get_board_round_user_list');
                    }

                    if (!$('.finish_boardround').hasClass(
                            'get_board_round_user_list_with_warning')) {
                        $('.finish_boardround').removeClass(
                            'get_board_round_user_list_with_warning');
                    }
                }
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });


        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();



    });



    $(document).on("click", ".attendance_user_list", function(e) {
        $(this).toggleClass("active");

        EnableSaveButtonForModals();
    });

    $(document).on("click", ".save_attendance_ward", function(e) {


        var selected_user = $('.attendance_user_list.active').map(function() {
            return $(this).data('attendance_user_id');
        }).get().join(',');

        var token = "{{ csrf_token() }}";
        var ward_id =
            @if (isset($success_array['ward_details']['id']))
                {{ $success_array['ward_details']['id'] }}
            @else
                null
            @endif ;
        var url = "{{ route('SaveWardRoundUser') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id,
                "boardround_user": selected_user
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {


                    $(".add_attendance").css("display", "none");
                    $('.board_round_text').html('Start Board Round');
                    $('.board_round_button_text').html('Start');
                    $(".boardround_cancel_button").addClass('d-none');
                    $(".stop_boardround").removeClass('d-none');
                    $(".camis_ward_action_boardround").removeClass('board_round_resume');
                    $(".boardround_config_type ").removeClass('active');
                    $(".camis_ward_action_boardround").addClass('board_round_start');
                    $("#modal_start_boardround").offcanvas('hide');
                    $("#camis_boardround_attendance").offcanvas('hide');
                    $('.button_ward_summary_boardround_next_patient').removeAttr('id');

                    toastr.success('Board Round Completed');
                    @if (!in_array(request()->route()->getName(), ['site.stranded_patients']))
                        var url =
                            "{{ route('ward.ward-details', $success_array['ward_details']['ward_url_name']) }}"
                        setTimeout(function() {
                            window.location.href = url;
                        }, 1000);
                        localStorage.removeItem('check_board_round');
                    @endif

                } else {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }

            },
            error: function(textStatus, errorThrown) {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });


    });




    $(document).on('click', '.search_ane_patient_history_symphony', function() {
        $('.modal-popup-loader-content').show();
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var token = "{{ csrf_token() }}";
        var pass_number = $('#ward_summary_boardround_modal_popup_camis_patient_pass_number').val();
        $("#symphony_search_prev_attendance_note").html('');
        $("#symphony_search_next_attendance_note").html('');
        $("#symphony_search_curr_attendance_note").html('');
        $("#symphony_data_search_show_data_sec_body").html('');
        $('#modal_patient_list_popup').modal('toggle');

        var ane_discharge_modal = new bootstrap.Offcanvas(document.getElementById(
            'ane_patient_history_all_symphony_data'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        ane_discharge_modal.show();
        var url = "{{ route('FetchAneDischargeSummary') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "patient_id": camis_patient_id,
                "check_pas_id": pass_number
            },
            success: function(result) {
                data_ret_html = JSON.parse(result);
                var current_att_number = data_ret_html.current_attendence_number;
                var next_att_number = data_ret_html.next_attendence_number;
                var prev_att_number = data_ret_html.previous_attendence_number;

                if (prev_att_number != '') {
                    $("#symphony_search_prev_attendance_note").html(' - ' + prev_att_number);
                    $("#symphony_search_patient_popup_back").attr("disabled", false);
                    $('#symphony_search_patient_popup_back').removeClass('inactive');

                } else {
                    $("#symphony_search_patient_popup_back").attr("disabled", true);
                    $('#symphony_search_patient_popup_back').addClass('inactive');
                }
                if (next_att_number != '') {
                    $("#symphony_search_next_attendance_note").html(' - ' + next_att_number);
                    $("#symphony_search_patient_popup_next").attr("disabled", false);
                    $('#symphony_search_patient_popup_next').removeClass('inactive');
                } else {
                    $("#symphony_search_patient_popup_next").attr("disabled", true);
                    $('#symphony_search_patient_popup_next').addClass('inactive');
                }
                if (current_att_number != '') {
                    $(".symphony_search_patient_popup_print").attr("disabled", false);
                    $('.symphony_search_patient_popup_print').removeClass('inactive');
                    $("#symphony_search_curr_attendance_note").html(' ( ' + current_att_number +
                        ' )');
                }
                $("#symphony_data_search_show_data_sec_body").html(data_ret_html.returnHTML);
                DisableLoaderAndMakeVisibleInnerBody();
                $('.modal-popup-loader-content').hide();
            }
        });
    });


    $(document).on('click', '.symphony_search_patient_popup_back', function() {
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var token = "{{ csrf_token() }}";
        var pass_number = $('#ward_summary_boardround_modal_popup_camis_patient_pass_number').val();
        var symphony_atd_num = $('#board_symphony_search_attendance_number_prev').val();
        $("#symphony_search_prev_attendance_note").html('');
        $("#symphony_search_next_attendance_note").html('');
        $("#symphony_search_curr_attendance_note").html('');
        $(".ward_summary_sub_modal_inner_body").css("visibility", "hidden");
        $(".modal-popup-loader-content").show();

        $("#symphony_data_search_show_data_sec_body").html('');


        var url = "{{ route('FetchAneDischargeSummary') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "patient_id": camis_patient_id,
                "symphony_atd_num": symphony_atd_num,
                "check_pas_id": pass_number
            },
            success: function(result) {
                data_ret_html = JSON.parse(result);
                var current_att_number = data_ret_html.current_attendence_number;
                var next_att_number = data_ret_html.next_attendence_number;
                var prev_att_number = data_ret_html.previous_attendence_number;

                if (prev_att_number != '') {
                    $("#symphony_search_prev_attendance_note").html(' - ' + prev_att_number);
                    $("#symphony_search_patient_popup_back").attr("disabled", false);
                    $('#symphony_search_patient_popup_back').removeClass('inactive');
                } else {
                    $("#symphony_search_patient_popup_back").attr("disabled", true);
                    $('#symphony_search_patient_popup_back').addClass('inactive');
                }
                if (next_att_number != '') {
                    $("#symphony_search_next_attendance_note").html(' - ' + next_att_number);
                    $("#symphony_search_patient_popup_next").attr("disabled", false);
                    $('#symphony_search_patient_popup_next').removeClass('inactive');
                } else {
                    $("#symphony_search_patient_popup_next").attr("disabled", true);
                    $('#symphony_search_patient_popup_next').addClass('inactive');
                }
                if (current_att_number != '') {
                    $("#symphony_search_curr_attendance_note").html(' ( ' + current_att_number +
                        ' )');
                }
                $("#symphony_data_search_show_data_sec_body").html(data_ret_html.returnHTML);
                DisableLoaderAndMakeVisibleInnerBody();
            }
        });
    });





    $(document).on('click', '.symphony_search_patient_popup_next', function() {
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var token = "{{ csrf_token() }}";
        var pass_number = $('#ward_summary_boardround_modal_popup_camis_patient_pass_number').val();
        var symphony_atd_num = $('#board_symphony_search_attendance_number_next').val();
        $("#symphony_search_prev_attendance_note").html('');
        $("#symphony_search_next_attendance_note").html('');
        $("#symphony_search_curr_attendance_note").html('');
        $("#symphony_data_search_show_data_sec_body").html('');
        $(".ward_summary_sub_modal_inner_body").css("visibility", "hidden");
        $(".modal-popup-loader-content").show();


        var url = "{{ route('FetchAneDischargeSummary') }}";
        $.ajax({

            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "patient_id": camis_patient_id,
                "symphony_atd_num": symphony_atd_num,
                "check_pas_id": pass_number
            },
            success: function(result) {
                data_ret_html = JSON.parse(result);
                var current_att_number = data_ret_html.current_attendence_number;
                var next_att_number = data_ret_html.next_attendence_number;
                var prev_att_number = data_ret_html.previous_attendence_number;

                if (prev_att_number != '') {
                    $("#symphony_search_prev_attendance_note").html('- ' + prev_att_number);
                    $("#symphony_search_patient_popup_back").attr("disabled", false);
                    $('#symphony_search_patient_popup_back').removeClass('inactive');
                } else {
                    $("#symphony_search_patient_popup_back").attr("disabled", true);
                    $('#symphony_search_patient_popup_back').addClass('inactive');
                }
                if (next_att_number != '') {
                    $("#symphony_search_next_attendance_note").html('- ' + next_att_number);
                    $("#symphony_search_patient_popup_next").attr("disabled", false);
                    $('#symphony_search_patient_popup_next').removeClass('inactive');
                } else {
                    $("#symphony_search_patient_popup_next").attr("disabled", true);
                    $('#symphony_search_patient_popup_next').addClass('inactive');
                }
                if (current_att_number != '') {
                    $("#symphony_search_curr_attendance_note").html(' ( ' + current_att_number +
                        ' )');
                }
                $("#symphony_data_search_show_data_sec_body").html(data_ret_html.returnHTML);
                DisableLoaderAndMakeVisibleInnerBody();
            }
        });
    });




    $(document).on('click', '.symphony_search_patient_popup_printss', function() {
        var newdata = $("#ane_patient_history_all_symphony_data").html();
        var html_to_print_id_title = $("#symphony_search_curr_attendance_note").html();
        var print_title =
            '<div class="print_title_star_styling_head" style="border-radius:8px;">A&E Discharge Summary ' +
            html_to_print_id_title + ' </div>';
        var html_to_print = $("#symphony_data_search_show_data_sec_body").html();
        var printContents = print_title +
            '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
            html_to_print + '</div>';
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write(
            '<html><link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/css/bootstrap.min.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Style.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/StyleNew.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeSummary.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Discharges.css') }}" crossorigin="anonymous"><body onload="window.print()"><div class="ae-summary-offcanvas">' +
            newdata + '</div></body></html>');

        var buttons = newWin.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].style.display = 'none';
        }
        setTimeout(function() {
            newWin.print();
            newWin.close();
        }, 1000);

    });
</script>
<script>
    $(document).on('click', '.discharge_lounge_handover', function(e) {

        DisableButtonClickForPreventFurtherEvent('discharge_lounge_handover');
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (camis_patient_id != '') {

            var discharge_lounge_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_board_round_discharge_lounge_handover'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            discharge_lounge_modal.show();

            CommonDisableEnableOnOpen();
            var url = "{{ route('GetDischargeLoungeHandover') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                    $('.di_tabs').html(result);
                    $('.clockpicker_nurse').clockpicker({
                        'default': 'now',
                        vibrate: true,
                        autoclose: true
                    });
                    $('.clockpicker_handover').clockpicker({
                        'default': 'now',
                        vibrate: true,
                        autoclose: true
                    });
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }

    });

    $(document).ready(function() {
        $('#previous-tab').click(function() {
            var activeTab = $('.nav-tabs .active');
            var prevTab = activeTab.parent().prev().find('a');

            if (prevTab.length > 0) {
                prevTab.tab('show');
            } else {
                $('.nav-tabs li:last-child a').tab('show');
            }
        });
    });


    $(document).ready(function() {
        $('#next-tab').click(function() {
            var activeTab = $('.nav-tabs .active');




            var currentTabId = activeTab.attr('href');


            if (currentTabId === '#tab4') {
                $('#dl_button_text').html('SAVE');
            } else {
                $('#dl_button_text').html('NEXT');
            }


            var nextTab = activeTab.parent().next().find('a');
            var dl_admitting_reason = $('#dl_admitting_reason').val();
            var dl_pmh = $('#dl_pmh').val();
            var dl_dncpar = $('#dl_dncpar').val();
            var dl_allergy = $('#dl_allergy').val();
            var dl_ews = $('#dl_ews').val();
            var dl_ews2 = $('#dl_ews2').val();
            var dl_type_of_mask = $('#dl_type_of_mask').val();
            var dl_learning_disability = $('#dl_learning_disability').val();
            var dl_safeguarding_issues = $('#dl_safeguarding_issues').val();
            var dl_critical_medication = $('#dl_critical_medication').val();
            var dl_mobility = $('#dl_mobility').val();
            var dl_diet = $('#dl_diet').val();
            var dl_pressure_ulcer = $('#dl_pressure_ulcer').val();
            var dl_continence = $('#dl_continence').val();

            var dl_contact_number_of_carers = $('#dl_contact_number_of_carers').val();
            var dl_cut_of_time = $('#dl_cut_of_time').val();
            if ($("#care_home_other_setting").is(":checked")) {
                var dl_care_home_other_setting = 1;
            } else {
                dl_care_home_other_setting = 0;
            }

            var dl_name_of_care_home = $('#dl_name_of_care_home').val();
            var dl_number_of_care_home = $('#dl_number_of_care_home').val();
            var dl_next_to_kin_aware = $('#dl_next_to_kin_aware').val();

            var dl_edn_status = $("input[name='edn_status']:checked").val();
            var dl_medication_status = $("input[name='medication_status']:checked").val();
            var dl_referral_status = $("input[name='referral_status']:checked").val();



            if ($("#tto_awaiting_authorization").is(":checked")) {
                var dl_tto_awaiting_authorization = 1;
            } else {
                dl_tto_awaiting_authorization = 0;
            }


            if ($("#family_to_collect").is(":checked")) {
                var dl_family_to_collect = 1;
            } else {
                dl_family_to_collect = 0;
            }
            if ($("#family_at_home").is(":checked")) {
                var dl_family_at_home = 1;
            } else {
                dl_family_at_home = 0;
            }
            if ($("#key_safe").is(":checked")) {
                var dl_key_safe = 1;
            } else {
                dl_key_safe = 0;
            }
            if ($("#patient_has_a_key").is(":checked")) {
                var dl_patient_has_a_key = 1;
            } else {
                dl_patient_has_a_key = 0;
            }

            var dl_contact_number = $('#contact_number').val();
            if ($("#hospital_ambulance").is(":checked")) {
                var dl_hospital_ambulance = 1;
            } else {
                dl_hospital_ambulance = 0;
            }

            if ($("#booked").is(":checked")) {
                var dl_booked = 1;
            } else {
                dl_booked = 0;
            }
            if ($("#job_reference").is(":checked")) {
                var dl_job_reference = 1;
            } else {
                dl_job_reference = 0;
            }
            var dl_to_be_booked = $('#to_be_booked').val();
            if ($("#private_crew").is(":checked")) {
                var dl_private_crew = 1;
            } else {
                dl_private_crew = 0;
            }

            if ($("#zimer_frame").is(":checked")) {
                var dl_zimer_frame = 1;
            } else {
                dl_zimer_frame = 0;
            }

            if ($("#stick").is(":checked")) {
                var dl_stick = 1;
            } else {
                dl_stick = 0;
            }

            if ($("#commode").is(":checked")) {
                var dl_commode = 1;
            } else {
                dl_commode = 0;
            }

            if ($("#bed_pan").is(":checked")) {
                var dl_bed_pan = 1;
            } else {
                dl_bed_pan = 0;
            }

            if ($("#equipment_not_applicable").is(":checked")) {
                var dl_equipment_not_applicable = 1;
            } else {
                dl_equipment_not_applicable = 0;
            }
            var dl_name_of_ward = $('#name_of_ward').val();
            var dl_name_of_staff_nurse = $('#name_of_staff_nurse').val();
            var dl_nurse_time = $('#nurse_time').val();
            var dl_handover_appointed_by = $('#handover_appointed_by').val();
            var dl_handover_time = $('#handover_time').val();
            var dl_note = $('#dl_note').val();
            if (nextTab.length > 0) {


                if (currentTabId == '#tab1') {
                    if (dl_admitting_reason == '') {
                        toastr.warning('Admitting Reason Left Empty');
                    } else if (dl_pmh == '') {
                        toastr.warning('PMH Left Empty');
                    } else if (dl_dncpar == '') {
                        toastr.warning('DNCPAR Left Empty');
                    } else if (dl_allergy == '') {
                        toastr.warning('Allergy Left Empty');
                    } else if (dl_ews == '') {
                        toastr.warning('EWS Left Empty');
                    } else if (dl_ews2 == '') {
                        toastr.warning('EWS 2 Left Empty');
                    } else if (dl_type_of_mask == '') {
                        toastr.warning('Type Of Mask Left Empty');
                    } else if (dl_learning_disability == '') {
                        toastr.warning('Learning Disability Left Empty');
                    } else if (dl_safeguarding_issues == '') {
                        toastr.warning('Safegurding Left Empty');
                    } else if (dl_critical_medication == '') {
                        toastr.warning('Clinical Medication Left Empty');
                    } else if (dl_mobility == '') {
                        toastr.warning('Mobility Left Empty');
                    } else if (dl_diet == '') {
                        toastr.warning('Diet Left Empty');
                    } else if (dl_pressure_ulcer == '') {
                        toastr.warning('Pressure Ulcer Left Empty');
                    } else if (dl_continence == '') {
                        toastr.warning('Continence Left Empty');
                    } else {
                        if ($('.dl_tab_2').hasClass('permission_restricted')) {
                            $('.dl_tab_2').removeClass('permission_restricted');
                        }

                        nextTab.tab('show');
                    }

                } else if (currentTabId == '#tab2') {
                    if (dl_contact_number_of_carers == '') {
                        toastr.warning('Contact Number Of Carers Left Empty');
                    } else if (dl_cut_of_time == '') {
                        toastr.warning('Cut Of Of Time Left Empty');
                    } else if (dl_name_of_care_home == '') {
                        toastr.warning('Name Of Care Home Empty');
                    } else if (dl_number_of_care_home == '') {
                        toastr.warning('Number Of Care Home Empty');
                    } else if (dl_next_to_kin_aware == '') {
                        toastr.warning('Next To Kin Aware Left Empty');
                    } else {
                        if ($('.dl_tab_3').hasClass('permission_restricted')) {
                            $('.dl_tab_3').removeClass('permission_restricted');
                        }

                        nextTab.tab('show');
                    }

                } else if (currentTabId == '#tab3') {
                    if (!dl_edn_status) {
                        toastr.warning('Please Select EDN Status');
                    } else if (!dl_medication_status) {
                        toastr.warning('Please Select Medication Status');
                    } else if (!dl_referral_status) {
                        toastr.warning('Please Select Referral Status');
                    } else {
                        if ($('.dl_tab_4').hasClass('permission_restricted')) {
                            $('.dl_tab_4').removeClass('permission_restricted');
                        }

                        nextTab.tab('show');
                    }

                }

            } else {
                if (dl_contact_number == '') {
                    toastr.warning('Contact Number Left Empty');
                } else if (dl_name_of_ward == '') {
                    toastr.warning('Name Of Ward Left Empty');
                } else if (dl_name_of_staff_nurse == '') {
                    toastr.warning('Name Of Staff Nurse Left Empty');
                } else if (dl_nurse_time == '') {
                    toastr.warning('Nurse Time Empty');
                } else if (dl_handover_appointed_by == '') {
                    toastr.warning('Handover Appointed By Left Empty');
                } else if (dl_handover_time == '') {
                    toastr.warning('Handover Time Left Empty');
                } else {

                    CommonDisableEnableOnSave();
                    EnableSaveButtonLoadImageForModals();
                    DisableSaveButtonForModals();


                    var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id')
                        .val();
                    var url = "{{ route('SaveDischargeLoungeHandover') }}";
                    var token = "{{ csrf_token() }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            "camis_patient_id": camis_patient_id,
                            "patient_admitting_reason": dl_admitting_reason,
                            "pmh": dl_pmh,
                            "dncpar": dl_dncpar,
                            "allergy": dl_allergy,
                            "ews": dl_ews2,
                            "type_of_mask": dl_type_of_mask,
                            "learning_disability": dl_learning_disability,
                            "safeguarding_issues": dl_safeguarding_issues,
                            "critical_medication": dl_critical_medication,
                            "mobility": dl_mobility,
                            "diet": dl_diet,
                            "pressure_ulcer": dl_pressure_ulcer,
                            "continence": dl_continence,
                            "contact_number_of_carers": dl_contact_number_of_carers,
                            "care_home_other_setting": dl_care_home_other_setting,
                            "cut_off_time": dl_cut_of_time,
                            "name_of_care_home": dl_name_of_care_home,
                            "contact_number_of_care_home": dl_number_of_care_home,
                            "next_of_kin_aware": dl_next_to_kin_aware,
                            "edn_status": dl_edn_status,
                            "medication_status": dl_medication_status,
                            "tto_awaiting_authorization": dl_tto_awaiting_authorization,
                            "referral_status": dl_referral_status,
                            "family_to_collect": dl_family_to_collect,
                            "family_at_home": dl_family_at_home,
                            "key_safe": dl_key_safe,
                            "patient_has_a_key": dl_patient_has_a_key,
                            "contact_number": dl_contact_number,
                            "hospital_ambulance": dl_hospital_ambulance,
                            "booked": dl_booked,
                            "job_reference": dl_job_reference,
                            "to_be_booked": dl_to_be_booked,
                            "private_crew": dl_private_crew,
                            "zimer_frame": dl_zimer_frame,
                            "stick": dl_stick,
                            "commode": dl_commode,
                            "bed_pan": dl_bed_pan,
                            "equipment_not_applicable": dl_equipment_not_applicable,
                            "name_of_ward": dl_name_of_ward,
                            "name_of_staff_nurse": dl_name_of_staff_nurse,
                            "nurse_time": dl_nurse_time,
                            "handover_appointed_by": dl_handover_appointed_by,
                            "handover_time": dl_handover_time,
                            "note": dl_note
                        },
                        success: function(result) {
                            if (typeof result.message !== 'undefined') {
                                if (result.status == 1) {
                                    toastr.success(result.message);
                                    DisableSaveButtonLoadImageForModals();
                                    EnableSaveButtonForModals();
                                    $('#dl_handover').html(
                                        '<button class="btn btn-discharge-lounge bg-amber-btn">Discharge Lounge Handover Pending</button>'
                                    );

                                    CloseOffcanvas(
                                        'camis_board_round_discharge_lounge_handover');
                                } else {
                                    toastr.warning(result.message);
                                    DisableSaveButtonLoadImageForModals();
                                    EnableSaveButtonForModals();
                                    CloseOffcanvas(
                                        'camis_board_round_discharge_lounge_handover');
                                }
                            } else {
                                toastr.warning('{{ ErrorOccuredMessage() }}');
                                DisableSaveButtonLoadImageForModals();
                                EnableSaveButtonForModals();
                                CloseOffcanvas(
                                    'camis_board_round_discharge_lounge_handover');
                            }
                        },
                        error: function(textStatus, errorThrown) {
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOffcanvas('camis_board_round_discharge_lounge_handover');
                        }
                    });
                }
            }
        });
    });
    $(document).on('shown.bs.tab', '#dltab a', function(e) {
        var activeTab = $(e.target).attr('href');
        console.log(activeTab);
        if (activeTab === '#tab4') {
            $('#dl_button_text').html('SAVE');
        } else {
            $('#dl_button_text').html('NEXT');
        }
    });

    $(document).on("click", ".level_status_update", function(e) {
        var token = "{{ csrf_token() }}";
        var level_id = $(this).data('level-id');
        var old_level_status = $('#old_level_status').val();
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $('.level_status_update').removeClass('active');
            $(this).addClass('active');
        }
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (camis_patient_id != '' && level_id !== 'undefined') {

            var url = "{{ route('UpdatePatientLevel') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "level_id": level_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        if (result.update_type == 'create') {
                            $('#old_level_status').val(level_id);

                            toastr.success(result.message);
                        } else {
                            $('#old_level_status').val('');
                            toastr.success(result.message);
                        }

                    } else {
                        $('.level_status_update').removeClass('active');
                        $('.level_status_update').each(function() {
                            var $button = $(this);
                            var current_level_id = $button.data('level-id');

                            if (current_level_id == old_level_status) {
                                $button.addClass('active');
                            }
                        });


                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $('.level_status_update').removeClass('active');
                    $('.level_status_update').each(function() {
                        var $button = $(this);
                        var current_level_id = $button.data('level-id');

                        if (current_level_id == old_level_status) {
                            $button.addClass('active');
                        }
                    });
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('.level_status_update').removeClass('active');
            $('.level_status_update').each(function() {
                var $button = $(this);
                var current_level_id = $button.data('level-id');

                if (current_level_id == old_level_status) {
                    $button.addClass('active');
                }
            });
            CommonErrorModalPopupOpenOnRequest();
        }
    });

    $(document).on("click", ".click_open_patient_therapy_status", function(e) {
        var token = "{{ csrf_token() }}";
        var therapy_status = $(this).data('therapy-fit');
        var old_therapy_status = $('#current_therapy_status').val();
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $('.click_open_patient_therapy_status').removeClass('active');
            $(this).addClass('active');
        }
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (camis_patient_id != '' && therapy_status !== 'undefined') {

            var url = "{{ route('UpdateTherapyFitStatus') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "therapy_status": therapy_status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {

                        toastr.success(result.message);


                    } else {
                        $('.click_open_patient_therapy_status').removeClass('active');
                        $('.click_open_patient_therapy_status').each(function() {
                            var $button = $(this);
                            var current_therapy_status = $button.data('therapy-fit');

                            if (current_therapy_status == old_therapy_status) {
                                $button.addClass('active');
                            }
                        });


                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $('.click_open_patient_therapy_status').removeClass('active');
                    $('.click_open_patient_therapy_status').each(function() {
                        var $button = $(this);
                        var current_therapy_status = $button.data('therapy-fit');

                        if (current_therapy_status == old_therapy_status) {
                            $button.addClass('active');
                        }
                    });
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('.click_open_patient_therapy_status').removeClass('active');
            $('.click_open_patient_therapy_status').each(function() {
                var $button = $(this);
                var current_therapy_status = $button.data('therapy-fit');

                if (current_therapy_status == old_level_status) {
                    $button.addClass('active');
                }
            });
            CommonErrorModalPopupOpenOnRequest();
        }
    });
</script>
