<script>
    function ViewAllComment(id) {
        $('.modal-popup-loader-content').show();
        var url = "{{ route('discharged.DtocWardAllCommentList',':patientId') }}";
        url = url.replace(':patientId', id);
        $.ajax({
            url: url,
            type: 'GET',
            success: function (result)
            {
                if(result != '{{PermissionDenied()}}'){
                    $('#viewAllCommentsBody').html(result);
                    $('.modal-popup-loader-content').hide();
                } else {
                    $('.modal-popup-loader-content').hide();
                    toastr.error('Permission Restricted.');
                }
            }
        });
    }

</script>
<script>
    function Backdropremove() {

        $('.modal-backdrop').css('z-index', 1040);
        $('.modal-backdrop').remove();
    }

</script>
<script>
    $(document).on("click", ".camis_save_discharge_comment", function (e)
    {
        @if(CheckSpecificPermission('discharge_tracker_discharge_info_comment_add') || CheckSpecificPermission('discharge_tracker_discharge_info_comment_update'))



        var token               = "{{ csrf_token() }}";
        var comment_id          = $('#data_comment_id').val();
        var initials            = $('#initial_type').val();
        var text                = $('#comment_data').val();
        var comment_type        = $('#comment_type').val();
        var camis_patient_id = $('#comment_patient_id').val();

        if(text == ''){
            toastr.warning('Add Some Comment To Continue');
            return;
        }
        var priority = $('#is_a_priority_comment').is(':checked') ? 1 : 0;

        if(comment_id != ''){
            var url = "{{ route('discharged.update.comment') }}";
        } else {
            var url = "{{ route('discharged.save.comment') }}";
        }
        $.ajax({
            _token: token,
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "initials": initials,
                "text": text,
                "comment_id": comment_id,
                "comment_type": comment_type,
                "camis_patient_id": camis_patient_id,
                "priority": priority
            },
            success: function (result)
            {
                if (result != null) {
                    if(comment_type != ''){
                        $('#viewAllCommentsBody').html(result.offcanvas);
                        $('#comment_list_'+camis_patient_id).html(result.page);
                        $('#comment_list_'+camis_patient_id).removeAttr('style');
                        $('#modal_add_comment_popup').modal('hide');

                        toastr.success('{{ DataUpdatedMessage() }}');
                    }else{


                        $('#comment_list_'+camis_patient_id).html(result.page);
                        $('#comment_list_modal_'+camis_patient_id).html(result.page);
                        $('#comment_list_'+camis_patient_id).removeAttr('style');
                        $('#modal_add_comment_popup').modal('hide');
                        toastr.success('{{ DataUpdatedMessage() }}');
                    }

                    $('.modal-backdrop').css('z-index', 1040);


                } else {

                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    CommonErrorModalPopupOpenOnRequest();
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                }
            },
            error: function(textStatus, errorThrown) {
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModals();
                CommonErrorModalPopupOpenOnRequest();
                toastr.warning('{{ ErrorOccuredMessage() }}');
            }
        });

        @else
        PermissionDeniedAlert();
        @endif

    });
</script>

<script>

    $(document).on('click', '.patient_cdt_timeline', function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $(this).data('patient-id');
        DisableButtonClickForPreventFurtherEvent('patient_cdt_timeline');
        $('.cdt_timeline_data').html('');
        $('.modal-dummy-content-loader').show();
        if (camis_patient_id != '') {
            $('.patient_cdt_comment').val('');
            $('#cdt_patient_id').val(camis_patient_id);
            var cdt_comments_modal = new bootstrap.Offcanvas(document.getElementById('camis_cdt_timeline'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            cdt_comments_modal.show();

            var url = "{{ route('discharged.GetCDTTimeline') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {

                    $('.cdt_timeline_data').html(result);
                    $('.modal-dummy-content-loader').hide();
                },
                error: function(textStatus, errorThrown) {
                    $('.modal-dummy-content-loader').hide();
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });



    $(document).on('click', '.view_cdt_comment', function(e) {
        var token = "{{ csrf_token() }}";
        DisableSaveButtonForModals();
        var camis_patient_id = $(this).data('camis-patient-id');
        DisableButtonClickForPreventFurtherEvent('view_cdt_comment');
        if (camis_patient_id != '') {
            $('.patient_cdt_comment').val('');
            $('#cdt_patient_id').val(camis_patient_id);
            var cdt_comments_modal = new bootstrap.Offcanvas(document.getElementById('camid_dtoc_cdt_comment'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            cdt_comments_modal.show();

            CommonDisableEnableOnOpen();
            var url = "{{ route('discharged.fetch.cdt.comment') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    $('.cdt_comment_history').html(result);
                    $('.cdt_comment_history').focus();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }
    });


    $(document).on("keydown", ".patient_cdt_comment", function(e) {
        var cdt_comments = $('.patient_cdt_comment').val();

        if (cdt_comments != '') {
            EnableSaveButtonForModals();
        } else {
            DisableSaveButtonForModals();
        }
    });


    $(document).on('click', '.camis_dtoc_update_cdt', function(e) {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $('#cdt_patient_id').val();
        var patient_cdt_comments = $('.patient_cdt_comment').val();
        CommonDisableEnableOnSave();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var url = "{{ route('discharged.save.cdt.comment') }}";
        if (camis_patient_id != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': tok,
                    'camis_patient_id': camis_patient_id,
                    'patient_cdt_comments': patient_cdt_comments
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        if (result.status == 2) {
                            DisableSaveButtonLoadImageForModals();
                            toastr.warning(result.message);
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();

                            CloseOffcanvas('camid_dtoc_cdt_comment');
                            toastr.success(result.message);
                        }


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



    $(document).on('click', '.add_comment', function() {
        @if(CheckSpecificPermission('discharge_tracker_discharge_info_comment_add') || CheckSpecificPermission('discharge_tracker_discharge_info_comment_update'))
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('camis-patient-id');
            var comment_id       = $(this).data('comment-id');
            var comment_type       = $(this).data('comment-type');
            $(".camis_patient_ward_summary_boardround_pharmacy_inner").html('');
            var priority = $('#is_a_priority_comment').is(':checked') ? 1 : 0;
            if (camis_patient_id != '') {
                $.ajax({
                    url: "{{ route('discharged.fetch.dtoc.comment') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id,
                        "comment_id": comment_id,
                        "comment_type": comment_type,
                        "priority": priority
                    },
                    success: function(result) {
                        if (result != '') {
                            $(".patient_drug_history_tick_icon").css("display", "none");
                            $(".camis_patient_ward_summary_dtoc_comment_inner").html(result);
                            $("#comment_patient_id").val(camis_patient_id);
                            $("#comment_type").val(comment_type);
                            var add_commrnt_modal = new bootstrap.Modal(document.getElementById('modal_add_comment_popup'), {
                                "backdrop": true,
                                "aria-hidden": false,
                                "aria-modal": true,
                            });
                            add_commrnt_modal.show();

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
        @else
        PermissionDeniedAlert();
        @endif
    });
</script>
<script >
    $(document).on('input', '#comment_data', function() {
        $(".camis_save_discharge_comment").removeClass( "bottom-save-button-disabled");
    });
    $(document).on('click', '#is_a_priority_comment', function() {
      var comment =   $("#comment_data").val();

      if(comment !== ''){
          $(".camis_save_discharge_comment").removeClass( "bottom-save-button-disabled");
      }

    });

</script>
<script>

    $(document).on('click', '.delete_comment', function() {
        @if(CheckSpecificPermission('discharge_tracker_discharge_info_comment_delete'))
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('camis-patient-id');
            var comment_id       = $(this).data('comment-id');
            var comment_type       = $(this).data('comment-type');
            if (camis_patient_id != '') {
                $.ajax({
                    url: "{{ route('discharged.remove.comment') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id,
                        "comment_id": comment_id
                    },
                    success: function(result) {
                        if (result != '') {
                            if(comment_type !== 'page'){
                                $('#viewAllCommentsBody').html(result.offcanvas);
                                $('#comment_list_'+camis_patient_id).html(result.page);
                                $('#modal_add_comment_popup').modal('hide');
                                $('.delete_comment').tooltip('dispose');
                                toastr.success('{{ DataRemovalMessage() }}');
                            }else{
                                $('.delete_comment').tooltip('dispose');
                                $('#comment_list_'+camis_patient_id).html(result.page);
                                $('#comment_list_modal_'+camis_patient_id).html(result.page);
                                $('#modal_add_comment_popup').modal('hide');
                                toastr.success('{{ DataRemovalMessage() }}');
                            }
                            $('.modal-backdrop').css('z-index', 1040);
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
        @else
            PermissionDeniedAlert();
        @endif
    });
    $(document).on('click', '.comment_na_action', function() {
        var token = "{{ csrf_token() }}";
        var camis_patient_id = $(this).data('camis-patient-id');
        var comment_id       = $(this).data('comment-id');
        var comment_type       = $(this).data('comment-type');
        if (camis_patient_id != '') {
            $.ajax({
                url: "{{ route('discharged.na.comment') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id,
                    "comment_id": comment_id
                },
                success: function(result) {
                    if (result != '') {

                        if ($('.dtoc_comment_removal_' + comment_id).length) {
                            $('.dtoc_comment_removal_' + comment_id).remove();
                            $('.delete_comment').tooltip('dispose');
                        }

                        if(comment_type !== 'page'){
                            $('#viewAllCommentsBody').html(result.offcanvas);
                            $('#comment_list_'+camis_patient_id).html(result.page);
                            $('#modal_add_comment_popup').modal('hide');
                            $('.delete_comment').tooltip('dispose');
                            toastr.success('{{ DataRemovalMessage() }}');
                        }else{
                            $('.delete_comment').tooltip('dispose');
                            $('#comment_list_'+camis_patient_id).html(result.page);
                            $('#comment_list_modal_'+camis_patient_id).html(result.page);
                            $('#modal_add_comment_popup').modal('hide');
                            toastr.success('{{ DataRemovalMessage() }}');
                        }
                        $('.modal-backdrop').css('z-index', 1040);
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
</script>

<script>

    $(document).on("click", ".comment_initials", function (e)
    {
        var initials_id             = $(this).data('initial-value');
        $(".comment_initials").removeClass("active");
        $(".comment_initial_type_" + initials_id).addClass("active");
        $("#initial_type").val(initials_id);
    });


    $(document).on("click", ".session_comment_initial", function (e)
    {
        var tu_modal_confirmation = new bootstrap.Modal(document.getElementById('set_tu_for_default'), {
            "backdrop": false,
            "aria-hidden": false,
            "aria-modal": true,
        });
        tu_modal_confirmation.show();
    });


    $(document).on("click", ".dtoc_tu_set_default_patient", function (e)
    {
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('discharged.save.tu.default') }}",
            type: 'POST',
            data: {
                "_token": token,
            },
            success: function(result) {
                if (result != '') {
                    $(".comment_initial_type_AAA").removeClass("active");
                    $("#initial_type").val('TU');
                    $('.session_comment_initial').addClass('comment_initials');
                    $(".comment_initial_type_TU").addClass("active");
                    $('.session_comment_initial').removeClass('session_comment_initial');
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.success('{{ DataUpdatedMessage() }}');
                    $('#set_tu_for_default').modal('hide');
                } else {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    EnableSaveButtonLoadImageForModals();
                    DisableSaveButtonForModals();
                    CommonErrorModalPopupOpenOnRequest();
                }
            },
            error: function(textStatus, errorThrown) {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                EnableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    });


    $(document).on("change", "#dtoc_pathway", function (e)
    {
        var token               = "{{ csrf_token() }}";
        var pathway_value = $('#dtoc_pathway').val();
        $.ajax({
            _token: token,
            url: "{{ route('discharged.fetch.current.service') }}",
            type: 'POST',
            data: {
                "_token": token,
                "pathway_value": pathway_value
            },
            success: function (result)
            {

                var $select = $('#dtoc_service_by_pathway');

                $select.empty();

                $.each(result, function(key, value) {
                    var $option = $('<option></option>').attr('value', key).text(value);
                    $select.append($option);
                });
            },
            error: function(textStatus, errorThrown) {
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModals();
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    });

    function RemovePatients(patient_id, status){
{{--        @if(CheckSpecificPermission('discharge_tracker_referral_update'))--}}

        $('#patient_id').val(patient_id);
        $('.cdt_comments').val('');
        var token               = "{{ csrf_token() }}";
        var offcanvas_id        = 'removeFromList';
        var cdt_offcanvs = new bootstrap.Offcanvas(document.getElementById(offcanvas_id), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        cdt_offcanvs.show();

        CommonDisableEnableOnOpen();
        DisableLoaderAndMakeVisibleInnerBody();
        EnableSaveButtonForModals();
{{--        @else--}}
{{--        PermissionDeniedAlert();--}}
{{--        @endif--}}
    }



    $(document).on('click', '.cdt_removed_button', function(e) {
{{--            @if(CheckSpecificPermission('discharge_tracker_referral_update'))--}}
        var token = "{{ csrf_token() }}";
        var patient_id = $('#patient_id').val();
        var status = $(this).data('status');
        var cdt_comments = $('#cdt_comments_'+status).val();

        var ward_id = $('#ward_id').val();
        if(status != 1 && cdt_comments == ''){
            toastr.warning('Please Insert Comment');
            return;
        }

        var offcanvas_id_text        = 'offcanvas_cdt_status_'+status;
        CommonDisableEnableOnSave();
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var url = "{{ route('discharged.RemovedPatientFormCDT') }}";
        if (patient_id != '' && status != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': tok,

                    'cdt_comments': cdt_comments,
                    "status": status,
                    'camis_patient_id': patient_id,
                    "ward_id":ward_id
                },
                success: function(result) {
                    console.log(result);
                    if (typeof result.message !== 'undefined') {

                        if(result.status == 1){
                            toastr.success(result.message);
                            $('#patient_list_with_'+patient_id).remove();
                            CloseOffcanvas('removeFromList');

                        }



                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();



                    } else {
                        $(".camis_ward_summary_boardround_sub_inner_popup_common_class [data-bs-dismiss='offcanvas']").click();
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $(".camis_ward_summary_boardround_sub_inner_popup_common_class [data-bs-dismiss='offcanvas']").click();
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
{{--        @else--}}

{{--        PermissionDeniedAlert();--}}
{{--        @endif--}}
    });


    $(document).on("click", ".save_dtoc_next_patient", function (e)
    {
        @if(CheckSpecificPermission('discharge_tracker_discharge_info_popup_update'))

        var pathway_value = $('#dtoc_pathway').val();
        var dtoc_current_status = $('#dtoc_current_status').val();



        DisableButtonClickForPreventFurtherEvent('save_dtoc_next_patient');
        EnableSaveButtonLoadImageForModals();
        DisableSaveButtonForModals();
        var token               = "{{ csrf_token() }}";
        var reason_code_value = $('#dtoc_reason_code').val();
        var planned_discharge_date = $("#planned_discharge_date").val();

        var pathway_value = $('#dtoc_pathway').val();
        var dtoc_current_status = $('#dtoc_current_status').val();
        var dtoc_service = $('#dtoc_service').val();
        var dtoc_service_by_pathway = $('#dtoc_service_by_pathway').val();
        var next_patient_id_data         = $(this).data('camis-next-patient');
        var camis_patient_id = $('#dtoc_patient_id').val();
        if(next_patient_id_data != ''){
            var next_patient_id = next_patient_id_data;
        } else {
            var next_patient_id = camis_patient_id;
        }
        if ($('#care_requirements_pdna_not_required').is(':checked')) {
            var care_pdna_not_required = 1;
        } else {
            var care_pdna_not_required = 0;
        }

        if ($('#care_requirements_pdna_nurse').is(':checked')) {
            var care_pdna_nurse = 1;
        } else {
            var care_pdna_nurse = 0;
        }

        if ($('#care_requirements_pdna_idt').is(':checked')) {
            var care_pdna_idt = 1;
        } else {
            var care_pdna_idt = 0;
        }

        if ($('#care_requirements_pdna_sent').is(':checked')) {
            var care_pdna_sent = 1;
        } else {
            var care_pdna_sent = 0;
        }
        var others_authority_text = $('.selected_authority').val();
        var next_patient_id_data         = $(this).data('camis-next-patient');
        var next_patient_go     = $(this).data('next_patient_go');

        if(next_patient_id_data != ''){
            var next_patient_id = next_patient_id_data;
        } else {
            var next_patient_id = camis_patient_id;
        }
        if ($('#patient_cdt_action').is(':checked')) {
            var cdt_action = 1;
        } else {
            var cdt_action = 0;
        }
        if ($('#patient_is_equipment').is(':checked')) {
            var is_equipment = 1;
        } else {
            var is_equipment = 0;
        }
        if ($('#patient_discharge_for_today').is(':checked')) {
            var discharge_for_today = 1;
        } else {
            var discharge_for_today = 0;
        }
        var discharge_pathway = $('#discharge_pathway').val();
        $(".modal-popup-loader-content").show();
        $.ajax({
            _token: token,
            url: "{{ route('discharged.save.dtoc.info') }}",
            type: 'POST',
            data: {
                "_token": token,
                "reason_code_value": reason_code_value,
                "pathway_value": pathway_value,
                "dtoc_current_status": dtoc_current_status,
                "planned_discharge_date": planned_discharge_date,
                "dtoc_service": dtoc_service,
                "dtoc_service_by_pathway": dtoc_service_by_pathway,
                "camis_patient_id": camis_patient_id,
                "care_pdna_not_required": care_pdna_not_required,
                "care_pdna_nurse": care_pdna_nurse,
                "care_pdna_idt": care_pdna_idt,
                "care_pdna_sent": care_pdna_sent,
                "others_authority_text": others_authority_text,
                "cdt_action": cdt_action,
                "is_equipment": is_equipment,
                "discharge_for_today": discharge_for_today,
                "next_patient_go": next_patient_go,
                "dt_drop_id": discharge_pathway
            },
            success: function (result)
            {

                if (result.status == 1) {



                    $('#dtoc_authority_text_'+camis_patient_id).html(result.dtoc_service_text);
                    $('#dtoc_current_status_text_'+camis_patient_id).html(result.dtoc_current_status);
                    $('#dtoc_services_text_'+camis_patient_id).html(result.service_by_pathway_text);
                    $('#dtoc_pathway_text_'+camis_patient_id).html(result.dtoc_pathway_text);
                    $('#dtoc_reason_text_'+camis_patient_id).html(result.dtoc_authority_text);
                    $('#planned_discharged_date_'+camis_patient_id).html(result.planned_discharge_date);
                    if(result.cdt_title !== null){
                        $('#cdt_text_'+camis_patient_id).html(result.cdt_title);
                    }
                    if(result.cdt_updated_time !== null){
                        $('#cdt_username_date_'+camis_patient_id).html(result.cdt_updated_time);
                    }
                    if(result.cdt_status !== 2){
                        $('#cdt_username_date_'+camis_patient_id).removeClass('cdt-reviewed');
                        $('#cdt_username_date_'+camis_patient_id).addClass('cdt-requested');
                    }else{
                        $('#cdt_username_date_'+camis_patient_id).addClass('cdt-reviewed');
                        $('#cdt_username_date_'+camis_patient_id).removeClass('cdt-requested');
                    }

                    if($('.update_patient_date_'+camis_patient_id).hasClass('border-discharge-today')){
                        $('.update_patient_date_'+camis_patient_id).removeClass('border-discharge-today');
                    }
                    if($('.update_patient_date_'+camis_patient_id).hasClass('border-equipment')){
                        $('.update_patient_date_'+camis_patient_id).removeClass('border-equipment');
                    }
                    if($('.update_patient_date_'+camis_patient_id).hasClass('border-cdt-actions')){
                        $('.update_patient_date_'+camis_patient_id).removeClass('border-cdt-actions');
                    }
                    if(result.cdt_status.type != ''){
                        $('.update_patient_date_'+camis_patient_id).addClass(result.cdt_status.type);
                    }

                    var trCount = $('tbody.update_patient_date_' + camis_patient_id + ' tr').length;

                    if(trCount > 2){
                        $('tbody.update_patient_date_' + camis_patient_id + ' tr').first().remove();

                    }

                    var window_width = window.innerWidth;

                        if(result.cdt_status.html != ''){
                            if (windowWidth > 1400) {
                                $('tbody.update_patient_date_' + camis_patient_id + ' .table-patient-row-1').css("width", "58%");
                                $('tbody.update_patient_date_' + camis_patient_id + ' .table-patient-row-2').css("width", "40%");
                            }
                            $('tbody.update_patient_date_' + camis_patient_id).prepend(result.cdt_status.html);

                        } else {
                            $('tbody.update_patient_date_' + camis_patient_id + ' .table-patient-row-1').css("width", "");
                                $('tbody.update_patient_date_' + camis_patient_id + ' .table-patient-row-2').css("width", "");
                        }
                    // if(patient_important_tick == 1){
                    //     if ($('#patient_list_with_'+camis_patient_id).length) {
                    //         if(!$('#patient_list_with_'+camis_patient_id).hasClass('bg-highlight')){
                    //             $('#patient_list_with_'+camis_patient_id).addClass('bg-highlight');
                    //         }
                    //     }
                    // } else {
                    //     if ($('#patient_list_with_'+camis_patient_id).length) {
                    //         if($('#patient_list_with_'+camis_patient_id).hasClass('bg-highlight')){
                    //             $('#patient_list_with_'+camis_patient_id).removeClass('bg-highlight');
                    //         }
                    //     }
                    // }


                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    toastr.success('{{ DataUpdatedMessage() }}');
                    @if(request()->route()->getName() == 'discharged.index')
                        if(next_patient_id_data != 'current'){
                            DtocModal(next_patient_id);
                        } else {
                            DisableSaveButtonForModals();
                        }
                        UpdatePathwayCount();
                    @elseif(request()->route()->getName() == 'discharged.medfit')
                        DisableSaveButtonForModals();
                        DataPageLoad('yes');
                        if (!$('#patientDetails').hasClass('show')) {

                            $('#patientDetails').modal('hide');
                        }
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();

                    @else
                        if (!$('#patientDetails').hasClass('show')) {
                            $('#patientDetails').modal('hide');
                        }
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    $('body').removeAttr('style');
                    @endif
                    $(".modal-popup-loader-content").hide();
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
                $(".modal-popup-loader-content").hide();
            }
        });
        @else
        PermissionDeniedAlert();
        @endif
    });
</script>
<script>
    $(document).on("change", "#dtoc_service_by_pathway", function (e)
    {
        EnableSaveButtonForModals();
    });
    $('.date-icon').on('click', function() {

        $('#planned_date_show_calendar_div').focus();
    });

</script>
<script>


    function DtocModal(camis_patient_id){
        @if(CheckSpecificPermission('discharge_tracker_discharge_info_popup_view'))
            var token           = "{{ csrf_token() }}";
            var ward_id         = $('#ward_id').val();
            var medfit          = $('#medfit_value').val();
            var search_text     = $('#search_text').val();
            var pathway_id     = $('#pathway_id').val();
            var service_id     = $('#service_id').val();
            var authority_id     = $('#authority_id').val();
            var sort_by = $('#sort_by').length ? $('#sort_by').val() : '';

            CommonDisableEnableOnOpen();
            if(camis_patient_id != ''){
                $.ajax({
                    _token: token,
                    url: "{{ route('discharged.fetch.dtoc.info') }}",
                    type: 'POST',
                    data: { "_token": token, "camis_patient_id": camis_patient_id, "ward_id": ward_id, "medfit": medfit, "search_text": search_text, "pathway_id": pathway_id, "service_id":service_id, "authority_id":authority_id, "sort_by":sort_by},
                    success: function (response)
                    {
                        $('body').css({
                            'overflow': '',
                            'padding-right': ''
                        });
                        $('.dtoc_data').html(response);


                        var offcanvasElement = document.getElementById('patientDetails');
                        var dtoc_offcanvas = new bootstrap.Offcanvas(offcanvasElement, {
                            relatedTarget: 'offcanvasRight',
                            backdrop: 'static'
                        });

                        if (!offcanvasElement.classList.contains('show')) {

                            dtoc_offcanvas.show();

                        }

                        DisableLoaderAndMakeVisibleInnerBody();
                        CommonDisableEnableOnSave();
                        $(".modal-popup-loader-content").hide();
                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                        $(".modal-popup-loader-content").hide();
                    }
                });
            } else {
                CommonErrorModalPopupOpenOnRequest();
            }
        @else
            PermissionDeniedAlert();
        @endif
    }

    $(document).on("click", ".discharge_patient_modal", function (e)
    {
        var camis_patient_id         = $(this).data('camis-patient-id');
        DtocModal(camis_patient_id);
    });

    $(document).on("click", ".dtoc_prev_patient", function (e)
    {
        var camis_patient_id         = $(this).data('camis-prev-patient');
        if(camis_patient_id != ''){
            DtocModal(camis_patient_id);
        }
    });

    $(document).on("click", ".dtoc_next_patient", function (e)
    {

        var camis_patient_id         = $(this).data('camis-next-patient');
        if(camis_patient_id != ''){
            DtocModal(camis_patient_id);
        }
    });

</script>
<script>
    $(document).on("change", "#dtoc_current_status", function (e)
    {
        var reason_code_value = $('#dtoc_reason_code').val();
        var pathway_value = $('#dtoc_pathway').val();
        var dtoc_current_status = $('#dtoc_current_status').val();

        var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
        var selected_authority = $('#selected_authority').val();

        if(pathway_value != '' && dtoc_current_status != ''){
            if (dtoc_service.toLowerCase() == 'ooa' && selected_authority != '') {
                EnableSaveButtonForModals();
            } else if (dtoc_service.toLowerCase() != 'ooa'){
                EnableSaveButtonForModals();
            }
        }
    });
    $(document).on("change", "#dtoc_pathway,#dtoc_reason_code,#dtoc_service,#care_requirements_pdna_not_required,#care_requirements_pdna_nurse,#care_requirements_pdna_idt,#care_requirements_pdna_sent,#patient_discharge_for_today, #patient_is_equipment, #patient_cdt_action, #discharge_pathway", function (e)
    {
        var reason_code_value = $('#dtoc_reason_code').val();
        var pathway_value = $('#dtoc_pathway').val();
        var dtoc_current_status = $('#dtoc_current_status').val();

        var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
        var selected_authority = $('#selected_authority').val();

            if (dtoc_service.toLowerCase() == 'ooa' && selected_authority != '') {
                EnableSaveButtonForModals();
            } else if (dtoc_service.toLowerCase() != 'ooa'){
                EnableSaveButtonForModals();
            }
    });
    $(document).on("keypress", "#selected_authority", function (e)
    {
        var reason_code_value = $('#dtoc_reason_code').val();
        var pathway_value = $('#dtoc_pathway').val();
        var dtoc_current_status = $('#dtoc_current_status').val();

        var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
        var selected_authority = $('#selected_authority').val();

        if(pathway_value != ''){
            if (dtoc_service.toLowerCase() == 'ooa' && selected_authority != '') {
                EnableSaveButtonForModals();
            } else if (dtoc_service.toLowerCase() != 'ooa'){
                EnableSaveButtonForModals();
            }
        }
    });
    $(document).on("change", "#dtoc_service", function (e)
    {
        var dtoc_service = $(this).find(':selected').text().trim();

        if (dtoc_service.toLowerCase() === 'ooa') {
            if($('#show_other_authority_box').hasClass('d-none')){
                $('#show_other_authority_box').removeClass('d-none');
            }
        } else {
            if(!$('#show_other_authority_box').hasClass('d-none')){
                $('#show_other_authority_box').addClass('d-none');
            }
        }
    });
    $(document).on("change", "#patient_cdt_action", function (e)
    {
        var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
        if ($('#patient_cdt_action').is(':checked')) {
            $('.patient_cdt_action_user').html('{{ session()->get('LOGGED_USER_NAME') }}');
            $('.patient_cdt_action_datetime').html(currentTime);
        } else {
            $('.patient_cdt_action_user').html('');
            $('.patient_cdt_action_datetime').html('');
        }
    });

    $(document).on("change", "#patient_is_equipment", function (e)
    {
        var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
        if ($('#patient_is_equipment').is(':checked')) {
            $('.patient_is_equipment_user').html('{{ session()->get('LOGGED_USER_NAME') }}');
            $('.patient_is_equipment_datetime').html(currentTime);
        } else {
            $('.patient_is_equipment_user').html('');
            $('.patient_is_equipment_datetime').html('');
        }
    });


    $(document).on("change", "#patient_discharge_for_today", function (e)
    {
        var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
        if ($('#patient_discharge_for_today').is(':checked')) {
            $('.patient_discharge_for_today_user').html('{{ session()->get('LOGGED_USER_NAME') }}');
            $('.patient_discharge_for_today_datetime').html(currentTime);
        } else {
            $('.patient_discharge_for_today_user').html('');
            $('.patient_discharge_for_today_datetime').html('');
        }
    });
</script>
<script>

    $(document).on("click", ".comment_history_modal", function (e){
        var camis_patient_id = $('.add_comment').data('camis-patient-id');
        var token = "{{ csrf_token() }}";
        $(".modal-popup-loader-content").show();
        if (camis_patient_id != '') {
            $.ajax({
                url: "{{ route('discharged.comment.history') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (result != '') {
                        $(".camis_patient_ward_summary_dtoc_comment_history").html(result);

                        var tu_modal_confirmation = new bootstrap.Modal(document.getElementById('modal_comment_history'), {
                            "backdrop": 'static',
                            "aria-hidden": false,
                            "aria-modal": true,
                        });
                        tu_modal_confirmation.show();

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
    function UpdatePathwayCount() {
        var patient_count = $('span.count_patient').length;
        var pathway_1 = $('span.total_p1').length;
        var pathway_2 = $('span.total_p2').length;
        var pathway_3 = $('span.total_p3').length;
        $('.complex_total_patient').html(patient_count);
        $('.complex_total_p1').html(pathway_1);
        $('.complex_total_p2').html(pathway_2);
        $('.complex_total_p3').html(pathway_3);
    }
</script>
@include('Dashboards.Camis.DischargeTracker.MedfitJs')
