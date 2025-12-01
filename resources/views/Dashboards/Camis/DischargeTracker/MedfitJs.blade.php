
<script>
$(document).on("click", ".click_popup_open_ibox_board_round_medfit_yes", function(e) {
    var token = "{{ csrf_token() }}";
    var camis_patient_id = $('#dtoc_patient_id').val();
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


                if($('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')){
                    $('.click_popup_open_ibox_board_round_medfit_no_modal').removeClass('active');
                }
                if(!$('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')){
                    $('.click_popup_open_ibox_board_round_medfit_yes_modal').addClass('active');
                }
                if(!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass('camis_patient_ward_summary_boardround_save_reason_to_reside')){
                    $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass('camis_patient_ward_summary_boardround_save_reason_to_reside');
                }
                if($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass('camis_patient_ward_summary_boardround_save_red_green_bed')){
                    $('.camis_patient_ward_summary_boardround_save_reason_to_reside').removeClass('camis_patient_ward_summary_boardround_save_red_green_bed');
                }
                $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("disabled", true);
                $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]").prop("disabled", false);
                $('.reason_to_reside_modal_title').html('Reason To Reside');


                if(!$('.reason_to_reside_close_area').hasClass('d-none')){
                    $('.reason_to_reside_close_area').addClass('d-none');
                }
                if($('.reason_to_reside_save_area').hasClass('d-none')){
                    $('.reason_to_reside_save_area').removeClass('d-none');
                }

                if($('.medfit-card').hasClass('d-none')){
                    $('.medfit-card').removeClass('d-none');
                }
                $('#ibox_board_round_content_patient_medically_fit_status_comment').val(result.patient_medically_fit_status_comment);
                $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show').val());
                if(!$('.r2r_checkbox_section').hasClass('d-none')){
                    $('.r2r_checkbox_section').addClass('d-none');
                }
                if(!$('.redbed_save_area').hasClass('d-none')){
                    $('.redbed_save_area').addClass('d-none');
                }
                $("#resonToResideSection").show();
                $("#redToGreenSection").hide();
                var reason_to_reaside = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_reason_to_reside'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: false
                });
                if (!reason_to_reaside.isOpen) {
                    reason_to_reaside.show();
                }
                CommonDisableEnableOnOpen();
                DisableLoaderAndMakeVisibleInnerBody();



                $('input[name="ibox_board_round_content_patient_reason_to_reside"]').prop('checked', false);
                if (result.patient_reason_to_reside_status != '') {
                    $('input[name="ibox_board_round_content_patient_reason_to_reside"][value="' + result.patient_reason_to_reside_status + '"]').prop('checked', true);
                    EnableSaveButtonForModalsMedfit();
                }
                EnableSaveButtonForModalsMedfit();

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

    if($('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')){
        $('.click_popup_open_ibox_board_round_medfit_no_modal').removeClass('active');
    }
    if(!$('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')){
        $('.click_popup_open_ibox_board_round_medfit_yes_modal').addClass('active');
    }
    $('#ibox_board_round_content_med_fit_set_as_no').val(1);
    $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("checked", true);
    $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("disabled", false);
    $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]").prop("disabled", true);
    EnableSaveButtonForModalsMedfit();

    if(!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass('camis_patient_ward_summary_boardround_save_reason_to_reside')){
        $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass('camis_patient_ward_summary_boardround_save_reason_to_reside');
    }
    if($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass('camis_patient_ward_summary_boardround_save_red_green_bed')){
        $('.camis_patient_ward_summary_boardround_save_reason_to_reside').removeClass('camis_patient_ward_summary_boardround_save_red_green_bed');
    }

    if($('.medfit-card').hasClass('d-none')){
        $('.medfit-card').removeClass('d-none');
    }
    $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show').val());
    if(!$('.r2r_checkbox_section').hasClass('d-none')){
        $('.r2r_checkbox_section').addClass('d-none');
    }

    EnableSaveButtonForModalsMedfit();

});




$('#ibox_board_round_content_patient_medically_fit_status_comment').on('keydown', function(e) {

        EnableSaveButtonForModalsMedfit();

});


$(document).on("click", ".camis_patient_ward_summary_boardround_save_medfit_for_discharge", function(e) {
    var token = "{{ csrf_token() }}";
    var camis_patient_id = $('#dtoc_patient_id').val();
    var patient_medically_fit_status_comment = $('#ibox_board_round_content_patient_medically_fit_status_comment').val();
    var consultant_name = $('.boardround_patient_consultant_full_name_show').val();
    if (camis_patient_id != '') {
        localStorage.setItem('reason_to_review_pending', camis_patient_id);
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModalsMedfit();
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
                    var check_reason_to_reside = localStorage.getItem('reason_to_review_pending');


                    var next_patient = $('#dtoc_patient_id_next').val();
                    if(next_patient == '' || next_patient == null){
                        localStorage.removeItem('reason_to_review_pending');
                        localStorage.setItem('this_is_last_patient', camis_patient_id);
                        var check_last_boardround = $('.add_attendance').css('display') === 'block';

                        if (check_last_boardround) {

                            $('.button_ward_summary_boardround_next_patient').attr('id', 'start_boardround');

                        }
                    } else {
                        localStorage.removeItem('this_is_last_patient');
                    }

                    CloseOffcanvas('camis_patient_ward_summary_boardround_medically_fit_for_discharge_yes');
                    $('.click_popup_open_ibox_board_round_reason_to_reside_show_category').html(result.reason_to_reside_text_value_category);
                    $('.click_popup_open_ibox_board_round_reason_to_reside_show_date').html('');


                    if($('.click_popup_open_ibox_board_round_medfit_no').hasClass('active')){
                        $('.click_popup_open_ibox_board_round_medfit_no').removeClass('active');
                    }


                    if($('.click_popup_open_ibox_board_round_medfit_yes').hasClass('active')){
                        $('.click_popup_open_ibox_board_round_medfit_yes').removeClass('active');
                    }



                    if (result.patient_medically_fit_status == 1) {
                        $('.click_popup_open_ibox_board_round_medfit_yes').addClass('active');
                    } else {
                        $('.click_popup_open_ibox_board_round_medfit_no').addClass('active');
                    }
                    $('.path_way_selectbox').removeClass('careRequermentWrap');
                    $('#ibox_pathway_data_update').prop("disabled", false);
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModalsMedfit();
                    toastr.success(result.message);
                } else {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModalsMedfit();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            },
            error: function(textStatus, errorThrown) {
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModalsMedfit();
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    } else {
        DisableSaveButtonLoadImageForModals();
        EnableSaveButtonForModalsMedfit();
        toastr.warning('{{ ErrorOccuredMessage() }}');
        CommonErrorModalPopupOpenOnRequest();
    }
});

$(document).on("click", ".click_popup_open_ibox_board_round_medfit_no_modal", function(e) {



    if($('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')){
        $('.click_popup_open_ibox_board_round_medfit_yes_modal').removeClass('active');
    }
    if(!$('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')){
        $('.click_popup_open_ibox_board_round_medfit_no_modal').addClass('active');
    }
    $('#ibox_board_round_content_med_fit_set_as_no').val(0);
    $("input[name=ibox_board_round_content_patient_reason_to_reside]").prop("checked", false);
    $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("disabled", true);
    $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]").prop("disabled", false);
    DisableSaveButtonForModalsMedfit();

    if(!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass('camis_patient_ward_summary_boardround_save_reason_to_reside')){
        $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass('camis_patient_ward_summary_boardround_save_reason_to_reside');
    }

    if($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass('camis_patient_ward_summary_boardround_save_red_green_bed')){
        $('.camis_patient_ward_summary_boardround_save_reason_to_reside').removeClass('camis_patient_ward_summary_boardround_save_red_green_bed');
    }

    if(!$('.medfit-card').hasClass('d-none')){
        $('.medfit-card').addClass('d-none');
    }
    $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show').val());
    DisableSaveButtonForModalsMedfit();
    if($('.r2r_checkbox_section').hasClass('d-none')){
        $('.r2r_checkbox_section').removeClass('d-none');
    }
});
$(document).on("click", ".click_popup_open_ibox_board_round_medfit_no", function(e) {
    var token = "{{ csrf_token() }}";
    var camis_patient_id = $('#dtoc_patient_id').val();
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


                if($('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')){
                    $('.click_popup_open_ibox_board_round_medfit_yes_modal').removeClass('active');
                }
                if(!$('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')){
                    $('.click_popup_open_ibox_board_round_medfit_no_modal').addClass('active');
                }
                if(!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass('camis_patient_ward_summary_boardround_save_reason_to_reside')){
                    $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass('camis_patient_ward_summary_boardround_save_reason_to_reside');
                }
                if($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass('camis_patient_ward_summary_boardround_save_red_green_bed')){
                    $('.camis_patient_ward_summary_boardround_save_reason_to_reside').removeClass('camis_patient_ward_summary_boardround_save_red_green_bed');
                }
                $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("disabled", true);
                $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]").prop("disabled", false);
                $('.reason_to_reside_modal_title').html('Reason To Reside');


                if(!$('.reason_to_reside_close_area').hasClass('d-none')){
                    $('.reason_to_reside_close_area').addClass('d-none');
                }
                if($('.reason_to_reside_save_area').hasClass('d-none')){
                    $('.reason_to_reside_save_area').removeClass('d-none');
                }

                if(!$('.redbed_save_area').hasClass('d-none')){
                    $('.redbed_save_area').addClass('d-none');
                }

                if(!$('.medfit-card').hasClass('d-none')){
                    $('.medfit-card').addClass('d-none');
                }
                $('#ibox_board_round_content_patient_medically_fit_status_comment').val('');
                $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show').val());
                if($('.r2r_checkbox_section').hasClass('d-none')){
                    $('.r2r_checkbox_section').removeClass('d-none');
                }

                $("#resonToResideSection").show();
                $("#redToGreenSection").hide();
                var reason_to_reaside = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_reason_to_reside'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: false
                });
                if (!reason_to_reaside.isOpen) {
                    reason_to_reaside.show();
                }
                CommonDisableEnableOnOpen();
                DisableLoaderAndMakeVisibleInnerBody();


                $('input[name="ibox_board_round_content_patient_reason_to_reside"]').prop('checked', false);
                if (result.patient_reason_to_reside_status != '') {
                    $('input[name="ibox_board_round_content_patient_reason_to_reside"][value="' + result.patient_reason_to_reside_status + '"]').prop('checked', true);
                    EnableSaveButtonForModalsMedfit();
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

$(document).on("change", "input[name=ibox_board_round_content_patient_reason_to_reside]", function(e) {
    @if(CheckSpecificPermission('camis_reason_to_reside_update'))
    EnableSaveButtonForModalsMedfit();
    @else
    e.preventDefault();
    toastr.error('Permission Denied');
    $("input[name='ibox_board_round_content_patient_reason_to_reside']").prop('checked', false);
    @endif
});

function EnableSaveButtonForModalsMedfit() {

    $(".camis_patient_ward_summary_boardround_save_reason_to_reside").removeClass(
        "bottom-save-button-disabled"
    );
    $(".camis_patient_ward_summary_boardround_save_reason_to_reside").addClass("bottom-save-button");
}

function DisableSaveButtonForModalsMedfit() {
    $(".camis_patient_ward_summary_boardround_save_reason_to_reside").removeClass("bottom-save-button");
    $(".camis_patient_ward_summary_boardround_save_reason_to_reside").addClass("bottom-save-button-disabled");
}

$(document).on("click", ".camis_patient_ward_summary_boardround_save_reason_to_reside", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#dtoc_patient_id').val();
        var patient_medically_fit_status_comment = $('#ibox_board_round_content_patient_medically_fit_status_comment').val();

        $('#is_next_popup_need_to_open').val(0);
        $('.boardround_patient_consultant_full_name_show').val()
        var consultant_name = $('.boardround_patient_consultant_full_name_show').val();
        var patient_medically_fit_status_comment = $('#ibox_board_round_content_patient_medically_fit_status_comment').val();
        if ($('input[name="ibox_board_round_content_patient_reason_to_reside"]:checked').length > 0) {
            var patient_reason_to_reside_status = $('input[name="ibox_board_round_content_patient_reason_to_reside"]:checked').val();
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
            DisableSaveButtonForModalsMedfit();
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
                        $('.click_popup_open_ibox_board_round_reason_to_reside_show_category').html(result.reason_to_reside_text_value_category);

                        // $('.click_popup_open_ibox_board_round_reason_to_reside_show_date').html(result.updated_date);


                        if (med_fit_set_as_no == 1) {
                            if($('.click_popup_open_ibox_board_round_medfit_no').hasClass('active')){
                                $('.click_popup_open_ibox_board_round_medfit_no').removeClass('active');
                            }


                            if(!$('.click_popup_open_ibox_board_round_medfit_yes').hasClass('active')){
                                $('.click_popup_open_ibox_board_round_medfit_yes').addClass('active');
                            }



                            if($('.path_way_selectbox').hasClass('careRequermentWrap')){
                                $('.path_way_selectbox').removeClass('careRequermentWrap');
                            }
                            $('#ibox_pathway_data_update').prop("disabled", false);


                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModalsMedfit()
                            toastr.success('{{ DataUpdatedMessage() }}');
                        } else {



                            if($('.click_popup_open_ibox_board_round_medfit_yes').hasClass('active')){
                                $('.click_popup_open_ibox_board_round_medfit_yes').removeClass('active');
                            }

                            if(!$('.click_popup_open_ibox_board_round_medfit_no').hasClass('active')){
                                $('.click_popup_open_ibox_board_round_medfit_no').addClass('active');
                            }

                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModalsMedfit()
                            toastr.success('{{ DataUpdatedMessage() }}');
                        }

                        if (result.patient_medically_fit_status == 1) {
                            var medfit_status = `Yes - ${moment().format('DD MMM')}`;
                        } else {
                            var medfit_status = `No`;
                        }

                        $('#' + camis_patient_id + '_medfit').html(medfit_status);

                        CloseOffcanvas('camis_patient_ward_summary_boardround_reason_to_reside');


                    } else {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModalsMedfit()
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        CloseOffcanvas('camis_patient_ward_summary_boardround_reason_to_reside');
                    }
                },
                error: function(textStatus, errorThrown) {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModalsMedfit()
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                    CloseOffcanvas('camis_patient_ward_summary_boardround_reason_to_reside');
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
            CloseOffcanvas('camis_patient_ward_summary_boardround_reason_to_reside');
        }
    });
</script>
