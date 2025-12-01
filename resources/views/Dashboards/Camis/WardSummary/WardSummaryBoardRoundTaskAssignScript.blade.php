<script>

    $(document).on("click", ".ibox_board_round_patient_task_assign_priority_open", function(e) {
        var board_round_patient_task_description = $('#ibox_board_round_patient_task_description_open').val();
        if (board_round_patient_task_description != '') {
            $(".ibox_board_round_patient_task_assign_priority_open").toggleClass("active");
        } else {
            $('#ibox_board_round_patient_task_description_open').focus();
        }
    });

    $(document).on("click", ".ibox_board_round_patient_task_assign_daily_open", function(e) {
        var board_round_patient_task_description = $('#ibox_board_round_patient_task_description_open').val();
        if (board_round_patient_task_description != '') {
            $(".ibox_board_round_patient_task_assign_daily_open").toggleClass("active");
        } else {
            $('#ibox_board_round_patient_task_description_open').focus();
        }
    });

    $(document).on("click", ".task_comment_id", function(e) {
        var completed_task_id = $(this).data('task-id');
        if (completed_task_id != '') {
            var token = "{{ csrf_token() }}";

            var url = "{{ route('GetBoardRoundPatientTaskDetails') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "completed_task_id": completed_task_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('#task_details').html(result.sections);

                        var task_details_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_task_details'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: 'static'
                        });
                        task_details_modal.show();
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


    $(document).on("click", ".ibox_board_round_patient_task_assign_group_common_open", function(e) {
        var board_round_patient_task_description = $('#ibox_board_round_patient_task_description_open').val();
        if (board_round_patient_task_description == '') {
            $('#ibox_board_round_patient_task_description_open').focus();
        } else {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            var task_group = $(this).data('task-group');
            var task_priority = 0;
            if ($('.ibox_board_round_patient_task_assign_priority_open').hasClass("active")) {
                task_priority = 1;
            }
            if ($('.ibox_board_round_patient_task_assign_daily_open').hasClass("active")) {
                task_daily = 1;
            } else {
                task_daily = 0;
            }
            if (camis_patient_id != '' || task_group != '') {
                $('#ibox_board_round_patient_task_description_open').val('');
                $(".ibox_board_round_patient_task_assign_priority_open").removeClass("active");
                $(".ibox_board_round_patient_task_assign_daily_open").removeClass("active");
                var url = "{{ route('UpdatePatientTaskBoardRound') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "task_description": board_round_patient_task_description,
                        "task_group": task_group,
                        "task_priority": task_priority,
                        "task_daily": task_daily
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);
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
        }
    });
    $(document).on("click", ".ibox_board_round_patient_task_assign_morning_evening_inner", function(e) {
        var morning_evening_boardround = $('.ibox_board_round_patient_task_assign_morning_evening_inner').html();
        if (morning_evening_boardround == 'Afternoon Board Round') {
            $('.ibox_board_round_patient_task_assign_morning_evening_inner').html('Morning Board Round');
            $('#boardround_patient_task_estimated_time_for_completion').val('13:00');
        } else {
            $('.ibox_board_round_patient_task_assign_morning_evening_inner').html('Afternoon Board Round');
            $('#boardround_patient_task_estimated_time_for_completion').val('09:00');
        }
    });
    $(document).on("click", ".ibox_board_round_patient_task_assign_priority_inner", function(e) {
        $(".ibox_board_round_patient_task_assign_priority_inner").toggleClass("active");

    });
    $(document).on("click", ".ibox_board_round_patient_task_assign_daily_inner", function(e) {
        $(".ibox_board_round_patient_task_assign_daily_inner").toggleClass("active");

    });
    $(document).on('click', '.click_open_board_round_patient_task_assign', function() {
        var token = "{{ csrf_token() }}";
        var board_round_patient_task_description = $('#ibox_board_round_patient_task_description_open').val();
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        DisableButtonClickForPreventFurtherEvent('click_open_board_round_patient_task_assign');
        $('#boardround_patient_task_description').val('');
        $('#boardround_patient_task_id_update').val('');
        $('#boardround_patient_task_group').val('').selectric('refresh');
        $('#boardround_patient_task_estimated_date_for_completion').val('');
        $('#boardround_patient_task_estimated_time_for_completion').val('');
        $('#boardround_patient_task_comment').val('');
        BoardRoundTaskAssignSetMorningBoardRoundOnOpen();
        $(".ibox_board_round_patient_task_assign_priority_inner").removeClass("active");
        $(".ibox_board_round_patient_task_assign_daily_inner").removeClass("active");
        $('#boardround_patient_task_estimated_date_for_completion').val($('#boardround_patient_task_estimated_date_for_completion').data('estimated-date-for-completion'));
        $('#boardround_patient_task_estimated_time_for_completion').val($('#boardround_patient_task_estimated_time_for_completion').data('estimated-time-for-completion'));
        $('#boardround_patient_task_description').val(board_round_patient_task_description);
        if ($('.ibox_board_round_patient_task_assign_priority_open').hasClass("active")) {
            $(".ibox_board_round_patient_task_assign_priority_inner").addClass("active");
        }
        if ($('.ibox_board_round_patient_task_assign_daily_open').hasClass("active")) {
            $(".ibox_board_round_patient_task_assign_daily_inner").addClass("active");
        }
        if (camis_patient_id != '') {
            var task_assign_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_assign_task'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            task_assign_modal.show();
            @isset($success_array['all_tasks_list'])
                var all_task_array = @json($success_array['all_tasks_list']);
            @else
                var all_task_array = [];
            @endif
            $(".boardround_patient_task_description").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(all_task_array, request.term);
                    response(results.slice(0, 5));

                },
                appendTo: "#camis_patient_ward_summary_boardround_assign_task"
            });
            CommonDisableEnableOnOpen();
            DisableLoaderAndMakeVisibleInnerBody();
            $('#boardround_patient_task_estimated_date_for_completion').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('.clockpicker_2').clockpicker({
                'default': 'now',
                vibrate: true,
                autoclose: true
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });



    $(document).on("change", "#boardround_patient_task_group", function(e) {
        var task_group = $('#boardround_patient_task_group').val();
        if (task_group != "") {
            EnableSaveButtonForModals();
        } else {
            DisableSaveButtonForModals();
        }
    });


    $(document).on("click", ".ibox_boardround_popup_patient_task_to_be_completed_show_list", function(e) {
        $('.ibox_boardround_popup_patient_task_to_be_completed_show_list').removeClass('patient_task_to_be_completed_selected');
        $(this).addClass('patient_task_to_be_completed_selected');
    });

    $(document).on("click", ".camis_patient_ward_summary_boardround_cancel_task_create_or_update", function(e) {
        $('#ibox_board_round_patient_task_description_open').val('');
        $('.ibox_board_round_patient_task_assign_priority_open').removeClass("active");
        $('.ibox_board_round_patient_task_assign_daily_open').removeClass("active");
    });


    $(document).on("click", ".ibox_boardround_popup_patient_task_edit", function(e) {
        $('.ibox_boardround_popup_patient_task_edit').tooltip('dispose');
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('ibox_boardround_popup_patient_task_edit');

            var url = "{{ route('GetBoardRoundPatientTask') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id
                },
                success: function(result) {
                    if (result.id != '') {
                        if(result.status != 1){
                            toastr.warning(result.message);

                        } else {
                            $('#boardround_patient_task_id_update').val(result.id);
                            $('#boardround_patient_task_description').val(result.task_description);
                            $('#boardround_patient_task_category').val(result.task_category);
                            $('#boardround_patient_task_group').val(result.task_group_name).selectric('refresh');
                            $('#boardround_patient_task_estimated_date_for_completion').val(result.task_estimated_date_for_completion);
                            $('#boardround_patient_task_estimated_time_for_completion').val(result.task_estimated_time_for_completion);
                            $('#boardround_patient_task_comment').val(result.task_comment);
                            BoardRoundTaskAssignSetMorningBoardRoundOnOpen();
                            $(".ibox_board_round_patient_task_assign_priority_inner").removeClass("active");
                            $(".ibox_board_round_patient_task_assign_daily_inner").removeClass("active");
                            if (result.task_priority == 1) {
                                $(".ibox_board_round_patient_task_assign_priority_inner").addClass("active");
                            }
                            if (result.task_daily == 1) {
                                $(".ibox_board_round_patient_task_assign_daily_inner").addClass("active");
                            }
                            if(result.task_estimated_time_for_completion =='09:00'){
                                $(".ibox_board_round_patient_task_assign_morning_evening_inner").html("Afternoon Board Round");

                            } else {
                                $(".ibox_board_round_patient_task_assign_morning_evening_inner").html("Morning Board Round");
                            }
                            $(".boardround_patient_task_estimated_time_for_completion").val(result.task_estimated_time_for_completion);
                            $(".boardround_patient_task_estimated_date_for_completion").val(result.task_estimated_date_for_completion);


                            var task_assign_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_assign_task'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_assign_modal.show();
                            @isset($success_array['all_tasks_list'])
                                var all_task_array = @json($success_array['all_tasks_list']);
                            @else
                                var all_task_array = [];
                            @endif
                            $(".boardround_patient_task_description").autocomplete({
                                source: function(request, response) {
                                    var results = $.ui.autocomplete.filter(all_task_array, request.term);
                                    response(results.slice(0, 5));
                                },
                                appendTo: "#camis_patient_ward_summary_boardround_assign_task"
                            });
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            $('#boardround_patient_task_estimated_date_for_completion').datepicker({
                                dateFormat: 'yy-mm-dd'
                            });

                            $('.clockpicker_2').clockpicker({
                                'default': 'now',
                                vibrate: true,
                                autoclose: true
                            });
                            EnableSaveButtonForModals();
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
            toastr.warning('Please Select Any One Of The Task To Edit');
        }
    });


    $(document).on("click", ".dp_task_resuscitation_status_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            var status = $(this).data('status');
            DisableButtonClickForPreventFurtherEvent('dp_task_resuscitation_status_yes');
            if(status == 'Yes'){
                EnableSaveButtonLoadImageForModals();
            } else {
                EnableDeleteButtonLoadImageForModals();
            }
            DisableSaveButtonForModals();
            var url = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id,
                    "resuscitation": status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_resuscitation_popup');
                        if ($('#camis_task_dp_task_review').hasClass('show')) {
                            CloseOffcanvas('camis_task_dp_task_review');
                        }
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
        }
    });

    $(document).on("click", ".dp_task_diabetinc_status_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            var status = $(this).data('status');
            DisableButtonClickForPreventFurtherEvent('dp_task_diabetinc_status_yes');
            if(status == 'Yes'){
                EnableSaveButtonLoadImageForModals();
            } else {
                EnableDeleteButtonLoadImageForModals();
            }
            DisableSaveButtonForModals();
            var url = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id,
                    "diabetic": status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_diabetic_status');

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
        }
    });

    $(document).on("click", ".dp_task_reasonable_adjustment_required_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            var status = $(this).data('status');
            DisableButtonClickForPreventFurtherEvent('dp_task_reasonable_adjustment_required_yes');
            if(status == 'Yes'){
                EnableSaveButtonLoadImageForModals();
            } else {
                EnableDeleteButtonLoadImageForModals();
            }
            DisableSaveButtonForModals();
            var url = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id,
                    "reasonable_required": status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_reasonable_adjustment_required_popup');

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
        }
    });

    $(document).on("click", ".dp_task_reasonable_adjustment_consider_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            var status = $(this).data('status');
            DisableButtonClickForPreventFurtherEvent('dp_task_reasonable_adjustment_consider_yes');
            if(status == 'Yes'){
                EnableSaveButtonLoadImageForModals();
            } else {
                EnableDeleteButtonLoadImageForModals();
            }
            DisableSaveButtonForModals();
            var url = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id,
                    "reasonable_consider": status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_reasonable_adjustment_consider_popup');
                        if ($('#camis_task_dp_task_review').hasClass('show')) {
                            CloseOffcanvas('camis_task_dp_task_review');
                        }
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
        }
    });


    $(document).on("click", ".dp_task_tep_status_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            var status = $(this).data('status');
            DisableButtonClickForPreventFurtherEvent('dp_task_tep_status_yes');
            if(status == 'Yes'){
                EnableSaveButtonLoadImageForModals();
            } else {
                EnableDeleteButtonLoadImageForModals();
            }
            DisableSaveButtonForModals();
            var url = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id,
                    "tep": status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_tep_popup');
                        if ($('#camis_task_dp_task_review').hasClass('show')) {
                            CloseOffcanvas('camis_task_dp_task_review');
                        }
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
        }
    });


    $(document).on("click", ".sepsis_assesment_no", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            var status = $(this).data('status');
            DisableButtonClickForPreventFurtherEvent('dp_task_tep_status_yes');
            if(status == 'Yes'){
                EnableSaveButtonLoadImageForModals();
            } else {
                EnableDeleteButtonLoadImageForModals();
            }
            DisableSaveButtonForModals();
            var url = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id,
                    "sepsis_status": status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_sepsis_assessment');
                        if ($('#camis_task_dp_task_review').hasClass('show')) {
                            CloseOffcanvas('camis_task_dp_task_review');
                        }
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
        }
    });


    $(document).on("click", ".dp_task_common_status_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();

        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('dp_task_common_status_yes');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url = "{{ route('CompletePatientTaskBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_common_popup');
                        if ($('#camis_task_dp_task_review').hasClass('show')) {
                            CloseOffcanvas('camis_task_dp_task_review');
                        }
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
        }
    });;




    $(document).on("click", ".ibox_boardround_popup_patient_task_complete", function(e) {
        $('.ibox_boardround_popup_patient_task_complete').tooltip('dispose');
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";

            var url = "{{ route('CheckBoardRoundPatientTask') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id
                },
                success: function(passed) {
                    if(passed.status != 1){
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                        EnableSaveButtonForModals();
                        if(passed.type == 6 && lower_case(passed.name) == lower_case('Escalation Status')){

                            var escalation_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_escalation_status'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            escalation_modal.show();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Resuscitation status known'))){
                            $(".common_message_for_dp_modal_show_title").html('Resuscitation status known?');

                            var task_dp_common_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_resuscitation_popup'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_common_modal.show();

                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('TEP In Place'))){
                            $(".common_message_for_dp_modal_show_title").html('TEP');

                            var common_task_dp_message_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_tep_popup'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });
                            common_task_dp_message_modal.show();

                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Reasonable Adjustments Required'))){
                            $(".common_message_for_dp_modal_show_title").html('Reasonable Adjustments Required?');

                            var task_dp_common_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_reasonable_adjustment_required_popup'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_common_modal.show();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Reasonable Adjustments Considered'))){
                            $(".common_message_for_dp_modal_show_title").html('Reasonable Adjustments Considered');
                            var task_dp_common_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_reasonable_adjustment_consider_popup'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_common_modal.show();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Review Diabetic Status'))){
                            var escalation_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_diabetic_status'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            escalation_modal.show();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();

                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('medical plan documented and shared with nursing staff'))){
                            $(".common_message_for_dp_modal_show_title").html('Medical Plan Documented And Shared With Nursing Staff?');
                            var task_dp_common_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_common_popup'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_common_modal.show();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Review Latest Investigations'))){
                            $(".common_message_for_dp_modal_show_title").html('Review Latest Investigations');
                            var task_dp_common_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_review_popup'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_common_modal.show();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Capillary Blood Glucose'))){
                            $('#cbg_result').val('');
                            var task_dp_glucose_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_capillary_blood_glucose'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_glucose_modal.show();
                            $(".common_message_for_dp_modal_show_title").html('Capillary Blood Glucose');

                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('To Check Resus Status / Limitation Plan?'))){
                            $('#cbg_result').val('');
                            var task_dp_glucose_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_resus_status'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_glucose_modal.show();
                            $(".common_message_for_dp_modal_show_title").html('To Check resus status / Limitation plan?');

                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Escalation PLAN'))){
                            $('#cbg_result').val('');
                            var task_dp_glucose_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_escalation_plan_modal'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_glucose_modal.show();
                            $(".common_message_for_dp_modal_show_title").html('To Check resus status / Limitation plan?');

                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Working Diagnosis Update On Ibox'))){
                            $(".common_message_for_dp_modal_show_title").html('Working Diagnosis Update On Ibox');
                            $('#ibox_board_round_working_diagnonsis_update_text').val($('.camis_popup_ibox_board_round_working_diagnosis_data_show').text());

                            var working_diagnosis_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_working_diagnosis_update'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            working_diagnosis_modal.show();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Commence Fluid Balance Monitoring'))){
                            $(".common_message_for_dp_modal_show_title").html('Commence Fluid Balance Monitoring');


                            var task_dp_common_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_common_popup'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            task_dp_common_modal.show();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('Sepsis Assessment'))){
                            $(".common_message_for_dp_modal_show_title").html('Sepsis Assessment');

                            var sepsis_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_sepsis_assessment'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });

                            sepsis_modal.show();
                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('AKI Assessment'))){
                            $(".common_message_for_dp_modal_show_title").html('Sepsis Assessment');
                            EnableSaveButtonForModals();
                            var url = "{{ route('GetVitalPacAKIData') }}";
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    "_token": token,
                                    "task_id": task_id,
                                    "camis_patient_id": camis_patient_id
                                },
                                success: function(result) {
                                    if (typeof result !== 'undefined') {
                                        $('#aki_value_popup').text(result);
                                        var aki_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_aki_assessment'), {
                                            relatedTarget: 'offcanvasRight',
                                            backdrop: 'static'
                                        });

                                        aki_modal.show();
                                    }
                                },
                                error: function(textStatus, errorThrown) {
                                    DisableSaveButtonLoadImageForModals();
                                    EnableSaveButtonForModals();
                                    toastr.warning('{{ ErrorOccuredMessage() }}');
                                    CommonErrorModalPopupOpenOnRequest();
                                }
                            });

                        } else if(passed.type == 6 && (lower_case(passed.name) == lower_case('confirm latest investigations have been reviewed and acted upon'))){

                            if(passed.dp_exists == 0){

                                $(".common_message_for_dp_modal_show_title").html('Confirm Latest Investigations Have Been Reviewed And Acted Upon');
                                var task_dp_common_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_common_popup'), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: 'static'
                                });

                                task_dp_common_modal.show();

                            } else {
                                toastr.error('You Need To Complete All The Pending DP Tasks First!');

                            }

                        }


                    } else {
                        DisableButtonClickForPreventFurtherEvent('ibox_boardround_popup_patient_task_complete');
                        EnableSaveButtonLoadImageForModals();
                        DisableSaveButtonForModals();
                        var url = "{{ route('CompletePatientTaskBoardRound') }}";
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                "_token": token,
                                "task_id": task_id,
                                "camis_patient_id": camis_patient_id
                            },
                            success: function(result) {
                                if (typeof result.message !== 'undefined') {
                                    $('.ibox_board_round_patient_task_content_show').html(result.sections);
                                    if(result.complete_dp_task == 1){
                                            $(".ibox_board_round_patient_flag_active_ibox_patient_flag_covid_dp").addClass("flag_inactive");

                                    }
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
                    }
                }
            });
        } else {
            toastr.warning('Please Select Any One Of The Task To Complete');
        }
    });




    $(document).on("click", ".sepsis_new_episode", function(e) {


        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();

        setTimeout(function() {
            $("#sepsis_input_1").prop("checked", false);
            $("#sepsis_input_2").prop("checked", false);
            $("#sepsis_input_3").prop("checked", false);
            $("#sepsis_input_4").prop("checked", false);
            var camis_task_dp_sepsis_assessment_checkbox = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_sepsis_assessment_checkbox'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });
            camis_task_dp_sepsis_assessment_checkbox.show();
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
        }, 1000);
    });

    $(document).on("click", ".camis_patient_ward_summary_boardround_save_aki_assessment", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var aki_value = $('#aki_value_popup').text();
        var token = "{{ csrf_token() }}";

        if (lower_case(aki_value) != "nil" && aki_value != null && aki_value != "" && aki_value != 0 &&
        aki_value != "0" && lower_case(aki_value) != lower_case('No Status Documented')) {
            var status_aki = aki_value;
        } else {
            var status_aki = "nill";
        }

        if (typeof task_id !== 'undefined' && task_id != '') {
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url = "{{ route('AssignAkiTask') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "task_id": task_id,
                        "camis_patient_id": camis_patient_id,
                        "aki_value": status_aki
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);
                            $('#aki_assigned_task').empty();
                            var assigned_tasks = JSON.parse(result.assigned_task);
                            var targetDiv = document.getElementById("aki_assigned_task");
                            assigned_tasks.forEach(function(task) {
                            var li = document.createElement("li");
                            li.textContent = task.auto_populate_task_name + " - " + task.task_user_group.task_group_name;
                            targetDiv.appendChild(li);
                            });
                            CloseOffcanvas('camis_task_dp_aki_assessment');

                            setTimeout(function() {
                                var camis_patient_ward_summary_boardround_confirm_aki_task = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_confirm_aki_task'), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: 'static'
                                });
                                camis_patient_ward_summary_boardround_confirm_aki_task.show();
                            }, 1000);


                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
        } else {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            CommonErrorModalPopupOpenOnRequest();
        }
        CommonDisableEnableOnOpen();
        DisableLoaderAndMakeVisibleInnerBody();
        EnableSaveButtonForModals();







    });



    $(document).on("click", ".camis_patient_ward_summary_boardround_save_sepsis_task", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var token = "{{ csrf_token() }}";
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();


        if (typeof task_id !== 'undefined' && task_id != '') {
            DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_save_sepsis_task');

            var url = "{{ route('AssignSepsisTask') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "task_id": task_id,
                        "camis_patient_id": camis_patient_id,
                        "sepsis": 'Yes'
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);

                            CloseOffcanvas('camis_task_dp_sepsis_assessment');

                            setTimeout(function() {




                                    var camis_patient_ward_summary_boardround_confirm_sepsis_task = new bootstrap.Offcanvas(document.getElementById('sepsis_task_list'), {
                                        relatedTarget: 'offcanvasRight',
                                        backdrop: 'static'
                                    });
                                    camis_patient_ward_summary_boardround_confirm_sepsis_task.show();
                                }, 1000);

                            toastr.success(result.message);
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                        } else {
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                    }
                });
        } else {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            CommonErrorModalPopupOpenOnRequest();
        }
        CommonDisableEnableOnOpen();
        DisableLoaderAndMakeVisibleInnerBody();
        EnableSaveButtonForModals();

    });



    $(document).on("click", ".ibox_boardround_popup_patient_task_delete", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('ibox_boardround_popup_patient_task_delete');

            var url = "{{ route('NotApplicablePatientTaskBoardRound') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        if(result.status != 1){
                            toastr.warning(result.message);
                        } else {
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

            toastr.warning('Please Select Any One Of The Task To Complete');
        }
    });

    function GetTaskById(id,dataArray)
    {

        var foundData = null;

        var foundData = dataArray.findIndex(function(item) {
            if(item.id == id){
                return item;
            }else{
                return 0;
            }

        });

        return foundData;
    }

    @if(!in_array(request()->route()->getName(), ['site.stranded_patients']))
        $(document).on("click", ".camis_patient_ward_summary_boardround_save_task_create_or_update", function(e) {

            var token = "{{ csrf_token() }}";
            var task_description = $('#boardround_patient_task_description').val();

            if(task_description == ''){
                toastr.warning('Please Enter Task Description');
                return;
            }
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var task_id = $('#boardround_patient_task_id_update').val();
            var task_group = $('#boardround_patient_task_group').val();
            var task_category = $('#boardround_patient_task_category').val();

            var task_estimated_date_for_completion = $('#boardround_patient_task_estimated_date_for_completion').val();
            var task_estimated_time_for_completion = $('#boardround_patient_task_estimated_time_for_completion').val();
            var task_comment = $('#boardround_patient_task_comment').val();
            var task_priority = 0;
            if ($('.ibox_board_round_patient_task_assign_priority_inner').hasClass("active")) {
                task_priority = 1;
            }

            var task_daily = 0;
            if ($('.ibox_board_round_patient_task_assign_daily_inner').hasClass("active")) {
                task_daily = 1;
            }
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            if (task_description == '' || task_group == '') {
                if (task_description == '') {
                    $('#boardround_patient_task_description').focus();
                }
                if (task_group == '') {
                    $('#boardround_patient_task_group').focus();
                }
            } else {
                if (camis_patient_id != '') {

                    var url = "{{ route('UpdatePatientTaskBoardRound') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": tok,
                            "camis_patient_id": camis_patient_id,
                            "task_id": task_id,
                            "task_description": task_description,
                            "task_group": task_group,
                            "task_priority": task_priority,
                            "task_daily": task_daily,
                            "task_category": task_category,
                            "task_comment": task_comment,
                            "task_estimated_date_for_completion": task_estimated_date_for_completion,
                            "task_estimated_time_for_completion": task_estimated_time_for_completion
                        },
                        success: function(result) {
                            if (typeof result.message !== 'undefined') {
                                var dataArray = result.task_to_be_completed;
                                if (GetTaskById(task_id,dataArray) !== -1) {
                                    const lastElement = dataArray[GetTaskById(task_id,dataArray)];
                                    var li = document.createElement("li");
                                    li.textContent = lastElement.patient_task_show_string;
                                    $('.edit_task'+task_id).html(li);

                                } else {
                                    const keys = Object.keys(dataArray);
                                    const lastKey = keys[keys.length - 1];
                                    const lastElement = dataArray[lastKey];
                                    var li = document.createElement("li");
                                    li.textContent = lastElement.patient_task_show_string;
                                    $('.'+camis_patient_id).append(li);
                                }
                                $('.ibox_board_round_patient_task_content_show').html(result.sections);
                                $('#ibox_board_round_patient_task_description_open').val('');
                                $('.ibox_board_round_patient_task_assign_priority_open').removeClass("active");
                                $('.ibox_board_round_patient_task_assign_daily_open').removeClass("active");
                                CloseOffcanvas('camis_patient_ward_summary_boardround_assign_task');
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
            }
        });
    @else
    $(document).on("click", ".camis_patient_ward_summary_boardround_save_task_create_or_update", function(e) {
        var task_description = $('#boardround_patient_task_description').val();
        if(task_description == ''){
            toastr.warning('Please Enter Task Description');
            return;
        }

        CommonDisableEnableOnSave();
        CommonToHideSubInnerPopupBoardround();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var token = "{{ csrf_token() }}";

        var task_id = $('#boardround_patient_task_id_update').val();
        var task_group = $('#boardround_patient_task_group').val();
        var task_category = $('#task_category').val();
        var filter_category = $('#filtered_task_id').val();
        var task_estimated_date_for_completion = $('#boardround_patient_task_estimated_date_for_completion')
            .val();
        var task_estimated_time_for_completion = $('#boardround_patient_task_estimated_time_for_completion')
            .val();
        var task_comment = $('#boardround_patient_task_comment').val();
        var task_priority = 0;
        if ($('.ibox_board_round_patient_task_assign_priority_inner').hasClass("active")) {
            task_priority = 1;
        }
        var task_daily = 0;
        if ($('.ibox_board_round_patient_task_assign_daily_inner').hasClass("active")) {
            task_daily = 1;
        }
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        if (task_description == '' || task_group == '') {
            if (task_description == '') {
                $('#boardround_patient_task_description').focus();
            }
            if (task_group == '') {
                $('#boardround_patient_task_group').focus();
            }
        } else {
            if (camis_patient_id != '') {
                $.ajax({
                    url: "{{ url('/inpatients/dashboards/ward-summary/board-round/update-patient-task-boadround') }}",
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "task_id": task_id,
                        "task_description": task_description,
                        "task_group": task_group,
                        "task_priority": task_priority,
                        "task_daily": task_daily,
                        "task_category": task_category,
                        "task_comment": task_comment,
                        "task_estimated_date_for_completion": task_estimated_date_for_completion,
                        "task_estimated_time_for_completion": task_estimated_time_for_completion
                    },
                    success: function(result) {
                        console.log(result);
                        if (typeof result.message !== 'undefined') {


                            if(task_id != ''){
                                var PatientTaskShowString = GetPatientTaskShowString(result, task_id);
                                if (PatientTaskShowString) {
                                    $('.updated_task_' + task_id).html(PatientTaskShowString);
                                }
                            }
                            $('.ibox_board_round_patient_task_content_show').html(result.sections);
                            var outstanding_task_amount = result.task_to_be_completed.length;

                            if (outstanding_task_amount < 1) {
                                var outstanding_tasks = 'No';
                            } else {
                                var outstanding_tasks = outstanding_task_amount;
                            }
                            $('#count_outstanding_task_' + camis_patient_id).html(outstanding_tasks);

                            var permission = $('#permission').val();
                            $.ajax({
                                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/fetch-outstanding-task') }}",
                                type: 'POST',
                                data: {
                                    "_token": tok,
                                    "camis_patient_id": camis_patient_id,
                                    "edit_category": task_category,
                                    "filter_category": filter_category,
                                    "permission": permission,
                                },
                                success: function(result) {
                                    $('#updated_task_list_' + camis_patient_id).html(
                                        result);
                                    $('#boardround_patient_task_group').val('')
                                        .selectric('refresh');
                                    $('#camis_patient_ward_summary_boardround_assign_task')
                                        .offcanvas('hide');
                                }

                            });
                            CloseOffcanvas('camis_patient_ward_summary_boardround_assign_task');

                            $('#ibox_board_round_patient_task_description_open').val('');
                            $('.ibox_board_round_patient_task_assign_priority_open').removeClass(
                                "active");
                            $('.ibox_board_round_patient_task_assign_daily_open').removeClass(
                                "active");
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
        }
    });


    @endif



    $(document).on("click", ".dp_task_escalation_status_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('dp_task_escalation_status_yes');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var url = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": tok,
                "task_id": task_id,
                "camis_patient_id": camis_patient_id,
                "type": 'escalation',
                "escalation": 'Yes'
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {
                    $('.ibox_board_round_patient_task_content_show').html(result.sections);
                    toastr.success(result.message);
                    CloseOffcanvas('camis_task_dp_escalation_status');
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

    });


    $(document).on("click", ".camis_patient_ward_summary_boardround_save_escalation_cancel", function(e) {
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_save_escalation_cancel');
        if ($('#eol_checkbox').is(':checked')) {
        var eol_data = "Yes";
        } else {
        var eol_data = "No";
        }

        if ($('#others_checkbox').is(':checked')) {
        var others_data = "Yes";
        } else {
        var others_data = "No";
        }
        var escalation_cancel_text = $('#ibox_board_round_escalation_text').val();

        var url  = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": tok,
                "camis_patient_id": camis_patient_id,
                "task_id": task_id,
                "type": 'escalation',
                "escalation": 'No',
                "eol_data": eol_data,
                "others_data": others_data,
                "escalation_text": escalation_cancel_text
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {
                    $('.ibox_board_round_patient_task_content_show').html(result.sections);
                    CloseOffcanvas('camis_task_dp_escalation_status_cancel');
                    if(result.complete_dp_task == 1){
                            $(".ibox_board_round_patient_flag_active_ibox_patient_flag_covid_dp").addClass("flag_inactive");

                    }
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

    });



    $(document).on("click", ".dp_task_escalation_status_no", function(e) {
        DisableButtonClickForPreventFurtherEvent('dp_task_escalation_status_no');
        EnableDeleteButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var checkbox = $('#checkboxId');
        var data;

        if (checkbox.is(':checked')) {
        data = "Yes";
        } else {
        data = "No";
        }
        var token = "{{ csrf_token() }}";
        CloseOffcanvas('camis_task_dp_escalation_status');

        setTimeout(function() {
            $("#eol_checkbox").prop("checked", false);
            $("#others_checkbox").prop("checked", false);
            $('#ibox_board_round_escalation_text').val('');
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            var escalation_cancel_modal = new bootstrap.Offcanvas(document.getElementById('camis_task_dp_escalation_status_cancel'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            escalation_cancel_modal.show();
        }, 1000);



    });

    $(document).on("click", ".dp_task_capillary_glucose_status_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var cbg_result = $('#cbg_result').val();
        var token = "{{ csrf_token() }}";
        if (cbg_result != "") {
            DisableButtonClickForPreventFurtherEvent('dp_task_escalation_status_yes');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
          var url  = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";
             $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "task_id": task_id,
                    "type": 'capullary_blood_glucose',
                    "capullary_blood_glucose": ''+cbg_result+' mmols'
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        toastr.success(result.message);
                        $('#cbg_result').val('');
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_capillary_blood_glucose');
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                }
            });
        } else {
            toastr.warning('Please Insert Value');
        }

    });

    $(document).on("click", ".dp_task_resus_status_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var dp_resus_status = $('#dp_resus_status').val();
        var token = "{{ csrf_token() }}";

            DisableButtonClickForPreventFurtherEvent('dp_task_resus_status_yes');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url  = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";
             $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "task_id": task_id,
                    "type": 'resus_status_limitation_plan',
                    "to_check_resus_status_limitation_plan": dp_resus_status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        toastr.success(result.message);
                        $('#dp_resus_status').val('');
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_resus_status');
                    } else {
                        CloseOffcanvas('camis_task_dp_resus_status');
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                }
            });


    });

    $(document).on("click", ".dp_task_escalation_plan_yes", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var dp_escalation_plan_status = $('#dp_escalation_plan_textbox').val();
        var token = "{{ csrf_token() }}";

            DisableButtonClickForPreventFurtherEvent('dp_task_escalation_plan_yes');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url  = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";
             $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "task_id": task_id,
                    "type": 'dp_escalation_plan_status',
                    "dp_escalation_plan": dp_escalation_plan_status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        toastr.success(result.message);
                        $('#dp_escalation_plan_textbox').val('');
                        $('.ibox_board_round_patient_task_content_show').html(result.sections);
                        CloseOffcanvas('camis_task_dp_escalation_plan_modal');
                    } else {
                        CloseOffcanvas('camis_task_dp_escalation_plan_modal');
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                }
            });


    });



    $(document).on("click", ".camis_patient_ward_summary_boardround_save_working_diagnosis_update", function(e) {
        var task_id = $('.patient_task_to_be_completed_selected').data('patient-task-id');
        var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
        var working_diagnosis_update = $('#ibox_board_round_working_diagnonsis_update_text').val();
        var token = "{{ csrf_token() }}";

        if($.trim(working_diagnosis_update) === ''){
            toastr.warning('Please Enter Comment');
            return;
        }

        DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_save_working_diagnosis_update');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
       var url  = "{{ route('CompletePatientTaskWithCategoryBoardRound') }}";
         $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": tok,
                "camis_patient_id": camis_patient_id,
                "task_id": task_id,
                "type": 'working_diagnosis_update',
                "working_diagnosis_update": working_diagnosis_update
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {
                    toastr.success(result.message);
                    $('#ibox_board_round_working_diagnonsis_update_text').val('');
                    $('.ibox_board_round_patient_task_content_show').html(result.sections);
                    $('.camis_popup_ibox_board_round_working_diagnosis_data_show').html(working_diagnosis_update);
                    $('.camis_popup_ibox_board_round_working_diagnosis_date_show').html(result.updated_date);
                    CloseOffcanvas('camis_task_dp_working_diagnosis_update');
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

    });

    $(document).on("keyup", "#ibox_board_round_patient_task_description_open", function(e) {

        var filterValue = $(this).val().toLowerCase();
        $('.list-group li').each(function() {
            var text = $(this).text().toLowerCase();
            if(text.indexOf(filterValue) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });




function BoardRoundTaskAssignSetMorningBoardRoundOnOpen() {
    $('.ibox_board_round_patient_task_assign_morning_evening_inner').html('Morning Board Round');
    $('#boardround_patient_task_estimated_time_for_completion').val('13:00');
}
</script>
