<script>
    function BoardRoundTaskAssignSetMorningBoardRoundOnOpen() {
        $('.ibox_board_round_patient_task_assign_morning_evening_inner').html('Morning Board Round');
        $('#boardround_patient_task_estimated_time_for_completion').val('13:00');
    }

    $(document).on("click", ".ibox_board_round_patient_task_assign_morning_evening_inner", function(e) {
        var morning_evening_boardround = $('.ibox_board_round_patient_task_assign_morning_evening_inner')
    .html();
        if (morning_evening_boardround == 'Afternoon Board Round') {
            $('.ibox_board_round_patient_task_assign_morning_evening_inner').html('Morning Board Round');
            $('#boardround_patient_task_estimated_time_for_completion').val('13:00');
        } else {
            $('.ibox_board_round_patient_task_assign_morning_evening_inner').html('Afternoon Board Round');
            $('#boardround_patient_task_estimated_time_for_completion').val('09:00');
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
    $(document).on("input", "#boardround_patient_task_description", function(e) {
        var task_group = $('#boardround_patient_task_group').val();
        if (task_group != "") {
            EnableSaveButtonForModals();
        } else {
            DisableSaveButtonForModals();
        }
    });



    $(document).on("click", ".ibox_board_round_patient_task_assign_priority_inner", function(e) {
        $(".ibox_board_round_patient_task_assign_priority_inner").toggleClass("active");

    });

    $(document).on("click", ".ibox_board_round_patient_task_assign_daily_inner", function(e) {
        $(".ibox_board_round_patient_task_assign_daily_inner").toggleClass("active");

    });

    @php
        $success_array = [];
        $process_array = [];
        $common_camis_controller                                        = new \App\Http\Controllers\Common\CommonCamisController;
        $common_camis_controller->AllTaskList($process_array, $success_array);
    @endphp
    @isset($success_array['all_tasks_list'])
        var all_task_array = @json($success_array['all_tasks_list']);
    @endif
    $("#boardround_patient_task_description").autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(all_task_array, request.term);
            response(results.slice(0, 5));
        },
        appendTo: $('#camis_patient_ward_summary_boardround_assign_task')
    });

    function TaskAssignFunction(camis_patient_id) {

        var task_view_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_assign_task'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        task_view_modal.show();

        var token = "{{ csrf_token() }}";
        var board_round_patient_task_description = $('#ibox_board_round_patient_task_description_open').val();
        $('#ward_summary_boardround_modal_popup_camis_patient_id').val(camis_patient_id);
        DisableButtonClickForPreventFurtherEvent('click_open_board_round_patient_task_assign');
        $('#boardround_patient_task_description').val('');
        $('#boardround_patient_task_id_update').val('');
        $('#boardround_patient_task_estimated_date_for_completion').val('');
        $('#boardround_patient_task_estimated_time_for_completion').val('');
        $('#boardround_patient_task_comment').val('');
        BoardRoundTaskAssignSetMorningBoardRoundOnOpen();
        $(".ibox_board_round_patient_task_assign_priority_inner").removeClass("active");
        $(".ibox_board_round_patient_task_assign_daily_inner").removeClass("active");
        $('#boardround_patient_task_estimated_date_for_completion').val($(
            '#boardround_patient_task_estimated_date_for_completion').data('estimated-date-for-completion'));
        $('#boardround_patient_task_estimated_time_for_completion').val($(
            '#boardround_patient_task_estimated_time_for_completion').data('estimated-time-for-completion'));
        $('#boardround_patient_task_description').val(board_round_patient_task_description);
        if ($('.ibox_board_round_patient_task_assign_priority_open').hasClass("active")) {
            $(".ibox_board_round_patient_task_assign_priority_inner").addClass("active");
        }

        if ($('.ibox_board_round_patient_task_assign_daily_open').hasClass("active")) {
            $(".ibox_board_round_patient_task_assign_daily_inner").addClass("active");
        }
        if (camis_patient_id != '') {
            CommonDisableEnableOnOpen();
            DisableLoaderAndMakeVisibleInnerBody();
            DisableSaveButtonForModals();
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
    }

    function PatientTaskEdit(task_id, button) {

        if (typeof task_id !== 'undefined' && task_id != '') {

            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('ibox_boardround_popup_patient_task_edit');
            $.ajax({
                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/fetch-patient-task-boadround') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id
                },
                success: function(result) {
                    if (result.id != '') {
                        if (result.status != 1) {

                            var common_modal = new bootstrap.Modal(document.getElementById(
                                'common_message_for_modal_show'), {
                                backdrop: 'static'
                            });

                            common_modal.show();

                            $(".common_message_for_modal_show_title").html('Task Removal');
                            $(".common_message_for_modal_show_content").html(
                                '<div class="alert alert-danger" style="text-align: center;">' + result
                                .message + '!</div>');

                        } else {
                            DisableSaveButtonForModals();
                            $('#boardround_patient_task_id_update').val(result.id);
                            $('#ward_summary_boardround_modal_popup_camis_patient_id').val(result
                                .patient_id);
                                $('#task_category').val(result.task_category);
                            $('#boardround_patient_task_description').val(result.task_description);
                            $('#boardround_patient_task_group').val(result.task_group_name).selectric(
                                'refresh');
                            $('#boardround_patient_task_estimated_date_for_completion').val(result
                                .task_estimated_date_for_completion);
                            $('#boardround_patient_task_estimated_time_for_completion').val(result
                                .task_estimated_time_for_completion);
                            $('#boardround_patient_task_comment').val(result.task_comment);
                            BoardRoundTaskAssignSetMorningBoardRoundOnOpen();
                            $(".ibox_board_round_patient_task_assign_site_task").removeClass(
                                "active");
                            if (result.task_priority == 1) {
                                $(".ibox_board_round_patient_task_assign_priority_inner").addClass(
                                    "active");
                            }

                            if (result.task_daily == 1) {
                                $(".ibox_board_round_patient_task_assign_daily_inner").addClass(
                                    "active");
                            }
                            if(result.task_estimated_time_for_completion =='09:00'){
                                $(".ibox_board_round_patient_task_assign_morning_evening_inner").html("Afternoon Board Round");

                            } else {
                                $(".ibox_board_round_patient_task_assign_morning_evening_inner").html("Morning Board Round");
                            }
                            $(".boardround_patient_task_estimated_time_for_completion").val(result.task_estimated_time_for_completion);
                            $(".boardround_patient_task_estimated_date_for_completion").val(result.task_estimated_date_for_completion);


                            var task_assign_modal = new bootstrap.Offcanvas(document.getElementById(
                                'camis_patient_ward_summary_boardround_assign_task'), {
                                ariaControls: 'offcanvasRight',
                                backdrop: 'static'
                            });


                            task_assign_modal.show();
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
            button.setAttribute("data-target", "#common_message_for_modal_show");
            $("#common_message_for_modal_show").modal('show');
            $(".common_message_for_modal_show_title").html('Assign Tasks');
            $(".common_message_for_modal_show_content").html(
                '<div class="alert alert-danger" style="text-align: center;">Please Select Any One Of The Task To Edit!</div>'
                );
        }

    }

    $(document).on("click", "#ibox_boardround_task_complete", function(e) {
        var task_id = $(this).attr('patient-task-id');
        var camis_patient_id = $(this).attr('patient-id');
        const listItem = '.edit_task' + task_id;
        if (task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/complete-patient-task-boadround') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {


                        if(result.status == 1){
                            var outstanding_task_amount = result.task_to_be_completed.length;
                            $('.rm_task_' + task_id).remove();
                            if (outstanding_task_amount < 1) {
                                var outstanding_tasks = 'No';
                                $('#all_task_body').html('<tr><td class="custom_table_data_not_found">{{ NotFoundMessage() }}</td></tr>');

                            } else {
                                var outstanding_tasks = outstanding_task_amount;
                            }
                            $('#count_outstanding_task_' + camis_patient_id).html(outstanding_tasks);
                            toastr.success('Task Completed Successfully');
                            $('.tooltip').tooltip('hide');

                        } else {
                            toastr.error(result.message);
                        }


                        var task_category = $('#task_category').val();
                        var filter_category = $('#filtered_task_id').val();
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

                            $('#ibox_board_round_patient_task_description_open').val('');
                            $('.ibox_board_round_patient_task_assign_priority_open').removeClass(
                                "active");
                            $('.ibox_board_round_patient_task_assign_daily_open').removeClass(
                                "active");
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('#common_message_for_modal_show').modal({
                backdrop: 'static'
            });
            $(".common_message_for_modal_show_title").html('Assign Tasks');
            $(".common_message_for_modal_show_content").html(
                '<div class="alert alert-danger" style="text-align: center;">Please Select Any One Of The Task To Complete!</div>'
                );
        }

    });


    $(document).on("click", ".ibox_boardround_task_delete", function(e) {
        e.preventDefault();
        var task_id = $(this).attr('patient-task-id');
        var camis_patient_id = $(this).attr('patient-id');
        if (typeof task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('ibox_boardround_popup_patient_task_delete');
            $.ajax({
                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/not-applicable-patient-task-boadround') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id,

                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {


                        if(result.status == 1){
                            var outstanding_task_amount = result.task_to_be_completed.length;
                            $('.rm_task_' + task_id).remove();
                            if (outstanding_task_amount < 1) {
                                var outstanding_tasks = 'No';
                                $('#all_task_body').html('<tr><td class="custom_table_data_not_found">{{ NotFoundMessage() }}</td></tr>');
                            } else {
                                var outstanding_tasks = outstanding_task_amount;
                            }
                            $('#count_outstanding_task_' + camis_patient_id).html(outstanding_tasks);
                            toastr.success(result.message);
                            $('.tooltip').tooltip('hide');

                        } else {
                            toastr.error(result.message);
                        }


                        var task_category = $('#task_category').val();
                        var filter_category = $('#filtered_task_id').val();
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

                            $('#ibox_board_round_patient_task_description_open').val('');
                            $('.ibox_board_round_patient_task_assign_priority_open').removeClass(
                                "active");
                            $('.ibox_board_round_patient_task_assign_daily_open').removeClass(
                                "active");

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('#common_message_for_modal_show').modal({
                backdrop: 'static'
            });
            $(".common_message_for_modal_show_title").html('Assign Tasks');
            $(".common_message_for_modal_show_content").html(
                '<div class="alert alert-danger" style="text-align: center;">Please Select Any One Of The Task To Complete!</div>'
                );
        }
    });

    function TaskActive(id) {
        if (id == 'ibox_board_round_patient_task_assign_site_inner') {
            $('.ibox_board_round_patient_task_assign_bedmeeting_inner').removeClass('btn-success');
            $('.ibox_board_round_patient_task_assign_site_inner').addClass('btn-success');
            $('#task_category').val(11);
        } else {
            $('.ibox_board_round_patient_task_assign_bedmeeting_inner').addClass('btn-success');
            $('.ibox_board_round_patient_task_assign_site_inner').removeClass('btn-success');
            $('#task_category').val(11);
        }
    }



    $(document).on("click", ".camis_patient_ward_summary_boardround_save_task_create_or_update", function(e) {

        var token = "{{ csrf_token() }}";
        var task_description = $('#boardround_patient_task_description').val();
        if(task_description == ''){
            toastr.warning('Please Enter Task Description');
            return;
        }
        CommonDisableEnableOnSave();
        CommonToHideSubInnerPopupBoardround();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
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





    function GetPatientTaskShowString(jsonData, taskId) {

      var task = jsonData.task_to_be_completed.find(function (outstand_task) {

         return outstand_task.id == taskId;
      });
      return task ? task.patient_task_show_string : null;
    }

    function OutStandingTask(camis_patient_id, task_edit_category, has_permission, doctor_at_night) {

        $('.page-data-loader_two').show();
        if (camis_patient_id != '') {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('show.outstanding.task') }}',
                type: 'POST',
                data: {
                    "_token": token,
                    "patient_id": camis_patient_id,
                    "task_category": task_edit_category,
                    "permission": has_permission,
                    "type": doctor_at_night,
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {

                        var all_outstanding_task = new bootstrap.Offcanvas(document.getElementById('camis_patient_outstanding_task'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: 'true',

                        });

                        all_outstanding_task.show();

                        $('#show_patient_outstanding_task').html(result);
                        $('.page-data-loader_two').hide();

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
    }

</script>
