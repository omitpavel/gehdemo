<script>
    $(document).on("click", ".add_comment_dp", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $(this).attr("data-id");

        $('#camis_comment_user_id').val(camis_patient_id);
        $("#ibox_surgical_wards_comments").val('');

        var comment_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_dp_add_comment'), {
            ariaControls: 'offcanvasRight',
            backdrop: 'static'
        });
        comment_modal.show();
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    });

    $(document).on("click", ".camis_patient_dp_ward_save_comments", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $("#camis_comment_user_id").val();
        var comments = $("#ibox_surgical_wards_save_comments").val();
        DisableButtonClickForPreventFurtherEvent('camis_patient_dp_ward_save_comments');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        if (camis_patient_id != '') {
            $.ajax({
                url: '{{ route('dp.save.comment') }}',
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id,
                    "comments": comments,
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {
                        $('.updated_comment_list_' + camis_patient_id).html(result);
                        CloseOffcanvas('camis_patient_dp_add_comment');
                        $('#ibox_surgical_wards_save_comments').val('');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.success('{{ DataAddedMessage() }}');

                        $.ajax({
                            url: "{{ route('dp.all.comments') }}",
                            type: 'POST',
                            data: {
                                "_token": token,
                                "camis_patient_id": camis_patient_id
                            },
                            success: function(result) {
                                if (typeof result !== 'undefined') {
                                    $('.all_comment_list').html(result);
                                }

                            }
                        });



                    } else {
                        setTimeout(function() {
                            CloseOffcanvas('camis_patient_dp_add_comment');
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');

                            CommonDisableEnableAfterSave();
                        }, 1000);
                    }

                },
                error: function(textStatus, errorThrown) {
                    setTimeout(function() {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CloseOffcanvas('camis_patient_dp_add_comment');
                        CommonDisableEnableAfterSave();
                    }, 1000);
                }
            });
        } else {
            setTimeout(function() {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModals();
                CloseOffcanvas('camis_patient_dp_add_comment');
                CommonDisableEnableAfterSave();
            }, 1000);
        }

    });

    $(document).on("click", ".camis_patient_dp_ward_update_comments", function(e) {
        DisableButtonClickForPreventFurtherEvent('camis_patient_dp_ward_update_comments');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $("#camis_comment_user_id").val();
        var comments = $("#ibox_surgical_wards_comments").val();
        var comment_id = $("#surgical_comment_id").val();

        if (camis_patient_id != '') {
            $.ajax({
                url: '{{ route('dp.update.comment') }}',
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id,
                    "comment_id": comment_id,
                    "comments": comments,
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {
                        $('.updated_comment_list_' + camis_patient_id).html(result);
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.success('{{ DataUpdatedMessage() }}');
                        $.ajax({
                            url: "{{ route('dp.all.comments') }}",
                            type: 'POST',
                            data: {
                                "_token": token,
                                "camis_patient_id": camis_patient_id
                            },
                            success: function(result) {
                                if (typeof result !== 'undefined') {
                                    $('.all_comment_list').html(result);
                                }

                            }
                        });
                        CloseOffcanvas('camis_patient_dp_update_comment');

                    } else {
                        setTimeout(function() {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CloseOffcanvas('camis_patient_dp_update_comment');
                            CommonDisableEnableAfterSave();
                        }, 1000);
                    }

                },
                error: function(textStatus, errorThrown) {
                    setTimeout(function() {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CloseOffcanvas('camis_patient_dp_update_comment');
                        $("#common_error_modal_show").modal({
                            backdrop: "static"
                        });
                        CommonDisableEnableAfterSave();
                    }, 1000);
                }
            });
        }

    });

    $(document).on('click', '.comment_upadate_delete_check_status', function(e) {
        e.preventDefault();
        DisableButtonClickForPreventFurtherEvent('comment_upadate_delete_check_status');
        var comment_patient_id = $(this).data('comment-patient-id');
        var comment_id = $(this).data('comment-id');
        var comment_process_status = $(this).data('comment-create-status');
        var comment_text = $(this).data('comment-text');

        if (comment_process_status == 'edit') {

            dp_comment_update(comment_patient_id, comment_id, comment_text);
        } else {

            var token = "{{ csrf_token() }}";

            if (comment_patient_id != '') {
                $.ajax({
                    url: '{{ route('dp.delete.comment') }}',
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": comment_patient_id,
                        "comment_id": comment_id,
                        "comments": comment_text,
                    },
                    success: function(result) {
                        if (typeof result !== 'undefined') {
                            toastr.success('Data Deleted Succesfully.');
                            $('.updated_comment_list_' + comment_patient_id).html(result);
                            $('.surgical_comments_' + comment_id).remove();
                            $.ajax({
                                url: "{{ route('dp.all.comments') }}",
                                type: 'POST',
                                data: {
                                    "_token": token,
                                    "camis_patient_id": comment_patient_id
                                },
                                success: function(result) {
                                    if (typeof result !== 'undefined') {
                                        $('.all_comment_list').html(result);
                                    }

                                }
                            });
                        } else {
                            setTimeout(function() {
                                toastr.warning('Something Went Wrong');
                            }, 1000);
                        }

                    },
                    error: function(textStatus, errorThrown) {
                        setTimeout(function() {
                            $("#camis_patient_surgical_add_comment").modal(
                                "hide"
                            );
                            $("#common_error_modal_show").modal({
                                backdrop: "static"
                            });
                            CommonDisableEnableAfterSave();
                        }, 1000);
                    }
                });
            }

        }

    });

    function dp_comment_update(comment_patient_id, comment_id, comment_text) {

        $("#camis_comment_user_id").val("");
        $("#surgical_comment_id").val("");
        $("#ibox_surgical_wards_comments").val('');
        $("#camis_comment_user_id").val(comment_patient_id);
        $("#surgical_comment_id").val(comment_id);
        $("#ibox_surgical_wards_comments").val(comment_text);

        var comment_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_dp_update_comment'), {
            ariaControls: 'offcanvasRight',
            backdrop: 'static'
        });
        comment_modal.show();
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    }


    $(document).on("click", ".board_round_hitory_show_all", function(e) {
        var patient_id = $(this).data('patient-id');
        var patient_ward = $(this).data('patient-ward');
        var token = "{{ csrf_token() }}";

        if (patient_id != '') {
            $.ajax({
                url: '{{ route('daily.plan.history') }}',
                type: 'POST',
                data: {
                    "_token": token,
                    "patient_id": patient_id,
                    "patient_ward": patient_ward,
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {

                        $('.show_boardround_history').html(result);

                        var history_modal = new bootstrap.Offcanvas(document.getElementById(
                            'camis_patient_ward_boardround_show_history'), {
                            ariaControls: 'offcanvasRight',
                            backdrop: 'static'
                        });

                        history_modal.show();
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


    $(document).on("click", ".view_all_comments", function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $(this).data('camis-patient-id');
        var all_comment_modal = new bootstrap.Offcanvas(document.getElementById(
                            'viewAllComments'), {
                            ariaControls: 'offcanvasRight',
                            backdrop: 'static'
                        });

        all_comment_modal.show();
        CommonDisableEnableOnOpen();
        if (camis_patient_id != '') {
            $.ajax({
                url: "{{ route('dp.all.comments') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {
                        var all_comment_modal = new bootstrap.Offcanvas(document.getElementById(
                            'viewAllComments'), {
                            ariaControls: 'offcanvasRight',
                            backdrop: 'static'
                        });

                        all_comment_modal.show();
                        $('.all_comment_list').html(result);

                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        setTimeout(function() {
                            $("#viewAllComments [data-bs-dismiss='offcanvas']").click();

                            toastr.warning('Something Went Wrong');
                            CommonDisableEnableAfterSave();
                        }, 1000);
                    }

                },
                error: function(textStatus, errorThrown) {
                    setTimeout(function() {
                        $("#viewAllComments [data-bs-dismiss='offcanvas']").click();
                        toastr.warning('Something Went Wrong');
                        CommonDisableEnableAfterSave();
                    }, 1000);
                }
            });
        } else {
            toastr.warning('Oops! Something Went Wrong.');
        }

    });

    $(document).on('click', '.click_open_patient_task', function(e) {

        @if(CheckSpecificPermission('dp_dashboard_task_management_view'))

            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('camis-patient-id');
            DisableButtonClickForPreventFurtherEvent('click_open_patient_task');

            if (camis_patient_id != '') {
                $('.ibox_board_round_patient_task_content_show').html('');
                var task_management_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_dp_task_management'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                task_management_modal.show();
                CommonDisableEnableOnOpen();
                var url = "{{ route('FetchDPTaskList') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        'camis_patient_id': camis_patient_id
                    },
                    success: function(result) {
                        DisableLoaderAndMakeVisibleInnerBody();
                        $('.ibox_board_round_patient_task_content_show').html(result);
                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CommonErrorModalPopupOpenOnRequest();
            }
        @else
            toastr.warning('Permission Denied');
        @endif
    });

</script>
