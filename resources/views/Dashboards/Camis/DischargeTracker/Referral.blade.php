@extends('Layouts.Common.MasterLayout')
@section('page-title', 'CDT Referral')
@section('page-top-title', 'CDT Referral')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/CustomizedTable.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/CdtReferral.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesPatientDetails.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesTimeline.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesCommentHistory.css') }}" crossorigin="anonymous">
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
    <style>
        .ms-options-wrap>.ms-options>ul>li.optgroup .label {
            display: inline;
            padding-right: 7px;
        }

        .optgroup-all {
            position: unset !important;
        }


    </style>
@endsection

@section('modal')
    @include('Dashboards.Camis.DischargeTracker.Modals')
    @include('Common.Modals.CommonModals')
    <div class="title-comment-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        data-bs-backdrop="static" tabindex="-1" id="camis_cdt_comment_offcanvas">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Update Review Reason</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100"
                        onclick="CloseOffcanvas('camis_cdt_comment_offcanvas');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <input type="hidden" id="cdt_current_comment_id" val="">
        <div class="offcanvas-body ward_summary_sub_modal_inner_body patient_cdt_comment_data">

        </div>
        <div class="offcanvas-footer">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="row g-2 ibox_modal_footer_button_class">
                        <div class="col-lg-4 col-md-4 ">
                            <button
                                class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_save_cdt_comment ">
                                <img class='loading-save-svg-to-show-on-save'
                                    src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                                <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                    class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                    height="18"><span>Update</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4 ">
                            <button
                                class="btn btn-primary-grey all_modal_delete_button_for_js camis_patient_ward_summary_boardround_remove_cdt_comment ">

                                <img class="loading-delete-svg-to-show-on-delete"
                                    src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}" alt=""
                                    style="display: none;">
                                <img src="{{ asset('asset_v2/Template/icons/deselect.svg') }}" alt=""
                                    class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="18" height="18"
                                    style="display: inline-block;"><span>DELETE</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4 ">
                            <button class="btn btn-primary-grey"
                                onclick="CloseOffcanvas('camis_cdt_comment_offcanvas');"><img
                                    src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                    class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>

    <script>
        function DataPageLoad(tab, ward_id, search_text) {
            @if (CheckSpecificPermission('discharge_tracker_referral_view'))
                if (ward_id == undefined) {
                    var ward_id = '';
                }

                var token = "{{ csrf_token() }}";
                $('.page-data-loader').show();

                $.ajax({
                    _token: token,
                    url: "{{ route('discharged.referral.data.load') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "tab": tab,
                        "ward_id": ward_id,
                        "search_text": search_text
                    },
                    success: function(response) {
                        if (response != "" && response != "{{ PermissionDenied() }}") {

                            $('#contentSection_data').html(response);
                            MultiSelectJs('ward_id', 'Ward');
                            $('.page-data-loader').hide();
                        } else {
                            $('.page-data-loader').hide();
                            PermissionDeniedAlert();
                        }
                    },
                    error: function(status, err) {
                        $('.page-data-loader').hide();
                        toastr.warning('Something Went Wrong');
                    }
                });
            @else
                PermissionDeniedAlert();
            @endif
        }


        function ActionButton(patient_id, status) {
            @if (CheckSpecificPermission('discharge_tracker_referral_update'))


                $('#patient_id').val(patient_id);
                $('.cdt_comments').val('');
                var token = "{{ csrf_token() }}";
                var offcanvas_id = 'offcanvas_cdt_status_' + status;
                var cdt_offcanvs = new bootstrap.Offcanvas(document.getElementById(offcanvas_id), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                cdt_offcanvs.show();

                CommonDisableEnableOnOpen();
                DisableLoaderAndMakeVisibleInnerBody();
                EnableSaveButtonForModals();
            @else
                PermissionDeniedAlert();
            @endif
        }


        function CDTComments(camis_patient_id) {
            var token = "{{ csrf_token() }}";
            $(".patient_cdt_comment_data").html('');
            var cdt_comments_modal = new bootstrap.Offcanvas(document.getElementById('camis_cdt_comment_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });
            cdt_comments_modal.show();
            $('#cdt_current_comment_id').val('');
            $('#cdt_latest_comment').val('');
            var current_comment_id = $('.review_reason_' + camis_patient_id).val();
            var comment_id = $('.review_reason_' + camis_patient_id).data('id');
            var history_id = $('.review_reason_' + camis_patient_id).data('history-id');
            $('#cdt_current_comment_id').val(comment_id);
            if (camis_patient_id != '') {
                var url = "{{ route('discharged.get.cdtcomments') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id,
                        "comment_id": comment_id,
                        "history_id":history_id
                    },
                    success: function(result) {

                        if (result != '') {

                            $(".patient_cdt_comment_data").html(result);


                            $("#cdt_latest_comment").val(current_comment_id);

                            $("#cdt_latest_comment").focus();
                            $('.modal-dummy-content-loader').hide();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            DisableSaveButtonForModals();
                            if (current_comment_id == '') {
                                DisableDeleteButtonForModals();
                            } else {
                                EnableDeleteButtonForModals();
                            }
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        CloseOffcanvas('camis_cdt_comment_offcanvas');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CloseOffcanvas('camis_cdt_comment_offcanvas');
                CommonErrorModalPopupOpenOnRequest();
            }
        }
        $(document).on("keypress", "#cdt_latest_comment", function(event) {
            var latest_comment = $('#cdt_latest_comment').val();
            if (latest_comment == '') {
                DisableSaveButtonForModals();
            } else {
                EnableSaveButtonForModals();
            }
        });
        $(document).on("click", ".camis_patient_ward_summary_boardround_remove_cdt_comment", function(e) {
            var token = "{{ csrf_token() }}";


            var camis_patient_id = $('#cdt_comment_patient_id').val();
            var comment = $('#cdt_latest_comment').val();
            var comment_id = $('.review_reason_' + camis_patient_id).data('id');


            DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_remove_cdt_comment');

            if (comment_id != '') {
                DisableSaveButtonForModals();
                DisableDeleteButtonForModals();
                EnableDeleteButtonLoadImageForModals();
                HideModalFooterButtonForClick();
                $('.modal-dummy-content-loader').show();
                var url = "{{ route('discharged.save.cdtcomments') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "comment": '',
                        "comment_id": comment_id
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            EnableDeleteButtonForModals();
                            DisableSaveButtonLoadImageForModals();
                            DisableDeleteButtonLoadImageForModals();
                            ShowModalFooterButtonForClick();
                            $('.review_reason_' + camis_patient_id).val('');
                            $('#cdt_latest_comment').val('');
                            $(".patient_cdt_comment_data").html(result.html);
                            $('.modal-dummy-content-loader').hide();

                            toastr.success('{{ DataUpdatedMessage() }}');
                            $('.modal-dummy-content-loader').hide();
                            CloseOffcanvas('camis_cdt_comment_offcanvas');
                        } else {
                            $('.modal-dummy-content-loader').hide();
                            EnableDeleteButtonForModals();
                            DisableSaveButtonLoadImageForModals();
                            DisableDeleteButtonLoadImageForModals();
                            ShowModalFooterButtonForClick();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CloseOffcanvas('camis_cdt_comment_offcanvas');
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        $('.modal-dummy-content-loader').hide();
                        EnableDeleteButtonForModals();
                        DisableSaveButtonLoadImageForModals();
                        DisableDeleteButtonLoadImageForModals();
                        ShowModalFooterButtonForClick();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CloseOffcanvas('camis_cdt_comment_offcanvas');
                    }
                });
            } else {
                $('.modal-dummy-content-loader').hide();
                EnableDeleteButtonForModals();
                DisableSaveButtonLoadImageForModals();
                DisableDeleteButtonLoadImageForModals();
                ShowModalFooterButtonForClick();
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CloseOffcanvas('camis_cdt_comment_offcanvas');
            }
        });



        $(document).on("click", ".click_delete_comment_history", function(e) {
            var token = "{{ csrf_token() }}";
            var comment_id = $(this).data('comment-id');
            DisableButtonClickForPreventFurtherEvent('click_delete_comment_history');

            if (comment_id != '') {
                var url = "{{ route('discharged.remove.cdtcomments.history') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "comment_id": comment_id
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {

                            $('.comment_list_id_' + comment_id).remove();
                            toastr.success('{{ DataUpdatedMessage() }}');

                        } else {
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                        }
                    },
                    error: function(textStatus, errorThrown) {

                        toastr.warning('{{ ErrorOccuredMessage() }}');
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
            }
        });


        $(document).on("click", ".camis_patient_ward_save_cdt_comment", function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#cdt_comment_patient_id').val();
            var comment = $('#cdt_latest_comment').val();

            if (comment == '') {
                toastr.warning('Please Insert Comment');
                return;
            }

            DisableButtonClickForPreventFurtherEvent('camis_patient_ward_save_cdt_comment');

            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var comment_id = $('.review_reason_' + camis_patient_id).data('id');


            $('.modal-dummy-content-loader').show();
            if (camis_patient_id != '') {
                console.log('success');
                var url = "{{ route('discharged.save.cdtcomments') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "comment": comment,
                        "comment_id": comment_id
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {

                            $('.review_reason_' + camis_patient_id).val(comment);
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.success('{{ DataUpdatedMessage() }}');
                            $('.modal-dummy-content-loader').hide();

                            CloseOffcanvas('camis_cdt_comment_offcanvas');
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                            $('.modal-dummy-content-loader').hide();

                            CloseOffcanvas('camis_cdt_comment_offcanvas');
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        $('.modal-dummy-content-loader').hide();

                        CloseOffcanvas('camis_cdt_comment_offcanvas');
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
                $('.modal-dummy-content-loader').hide();

                CloseOffcanvas('camis_cdt_comment_offcanvas');
            }
        });
        $(document).on("change", "#ward_id", function(e) {
            var ward_id = $('#ward_id').val();
            var tab = $('#tab').val();
            var search_text = $('#referral_search_text').val();
            DataPageLoad(tab, ward_id, search_text);
        });
        $(document).on("click", "#referral_search_button", function(e) {
            var ward_id = $('#ward_id').val();
            var tab = $('#tab').val();
            var search_text = $('#referral_search_text').val();
            DataPageLoad(tab, ward_id, search_text);
        });

        @if (CheckSpecificPermission('discharge_tracker_referral_view'))
            $(document).ready(function() {
                DataPageLoad('pending');
            });
        @else

            PermissionDeniedAlert();
        @endif
        function removeEmptyWardWrappers() {
            $('.ward-patients-wrapper').each(function() {
                var $wrapper = $(this);


                if ($wrapper.find('.table-patient-tbody').length === 0) {

                    $wrapper.remove();


                }
            });

            let count = $(".card-custom-table .ward-patients-wrapper").length;

            if (count < 1) {
                $(".card-custom-table").html(`
            <div class="patients-details">
                <div class="custom_not_found">{{ NotFoundMessage() }}</div>
            </div>
        `);
            }


        }
        $(document).on('click', '.cdt_approval_button', function(e) {
            @if (CheckSpecificPermission('discharge_tracker_referral_update'))
                var token = "{{ csrf_token() }}";

                if ($('#patient_id').val() != '') {
                    var patient_id = $('#patient_id').val();
                } else {
                    var patient_id = $(this).data('patient_id');
                }
                var status = $(this).data('status');
                var cdt_comments = $('#cdt_comments_' + status).val();
                var tab = $('#tab').val();
                var ward_id = $('#ward_id').val();



                if (status != 1 && cdt_comments == '') {
                    toastr.warning('Please Insert Comment');
                    return;
                }
                var offcanvas_id = '#offcanvas_cdt_status_' + status;
                var offcanvas_id_text = 'offcanvas_cdt_status_' + status;
                CommonDisableEnableOnSave();
                EnableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                var url = "{{ route('discharged.referral.save.status') }}";
                if (patient_id != '' && status != '') {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': tok,
                            'camis_patient_id': patient_id,
                            'cdt_comments': cdt_comments,
                            "status": status,
                            "tab": tab,
                            "ward_id": ward_id
                        },
                        success: function(result) {
                            if (typeof result.message !== 'undefined') {
                                $('.tbody_id_' + patient_id).remove();
                                removeEmptyWardWrappers();
                                DisableSaveButtonLoadImageForModals();
                                EnableSaveButtonForModals();

                                console.log(offcanvas_id_text);

                                if (status == 1) {
                                    DtocModal(patient_id);
                                } else if (status == 2) {
                                    CloseOffcanvas('offcanvas_cdt_status_3');
                                } else if (status == 3) {
                                    CloseOffcanvas('offcanvas_cdt_status_2');
                                }
                                MultiSelectJs('ward_id', 'Ward');
                                toastr.success(result.message);

                            } else {
                                $(".camis_ward_summary_boardround_sub_inner_popup_common_class [data-bs-dismiss='offcanvas']")
                                    .click();
                                DisableSaveButtonLoadImageForModals();
                                EnableSaveButtonForModals();
                                toastr.warning('{{ ErrorOccuredMessage() }}');
                                CommonErrorModalPopupOpenOnRequest();
                            }
                            $('#patient_id').val('');
                        },
                        error: function(textStatus, errorThrown) {
                            $(".camis_ward_summary_boardround_sub_inner_popup_common_class [data-bs-dismiss='offcanvas']")
                                .click();
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
            @else

                PermissionDeniedAlert();
            @endif
        });


        function DtocModal(camis_patient_id) {
            @if (CheckSpecificPermission('discharge_tracker_referral_update'))
                var token = "{{ csrf_token() }}";

                $(".modal-popup-loader-content").show();
                if (camis_patient_id != '') {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.fetch.dtoc.info.referral') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "camis_patient_id": camis_patient_id,
                            "from_cdt_page": 1
                        },
                        success: function(response) {
                            $('.dtoc_data').html(response);
                            var patientDetails = document.getElementById('patientDetails');
                            var dtoc_offcanvas = new bootstrap.Offcanvas(patientDetails);
                            if (!$('#patientDetails').hasClass('show')) {
                                dtoc_offcanvas.toggle();
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
        $(document).on("change", "#dtoc_service_by_pathway", function(e) {
            EnableSaveButtonForModals();
        });

        $('.date-icon').on('click', function() {
            $('#planned_date_show_calendar_div').focus();
        });

        $(document).on("change", "#dtoc_pathway", function(e) {
            var token = "{{ csrf_token() }}";
            var pathway_value = $('#dtoc_pathway').val();
            $.ajax({
                _token: token,
                url: "{{ route('discharged.fetch.current.service') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "pathway_value": pathway_value
                },
                success: function(result) {

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

        $(document).on("change", "#dtoc_current_status", function(e) {
            var reason_code_value = $('#dtoc_reason_code').val();
            var pathway_value = $('#dtoc_pathway').val();
            var dtoc_current_status = $('#dtoc_current_status').val();

            var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
            var selected_authority = $('#selected_authority').val();

            if (pathway_value != '' && dtoc_current_status != '') {
                if (dtoc_service.toLowerCase() == 'others' && selected_authority != '') {
                    EnableSaveButtonForModals();
                } else if (dtoc_service.toLowerCase() != 'others') {
                    EnableSaveButtonForModals();
                }
            }
        });
        $(document).on("change", "#care_requirements_pdna_sent", function(e) {
            if ($("#care_requirements_pdna_sent").is(":checked")) {
                var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
                $(".care_requirements_pdna_sent_date").html(currentTime);
            } else {
                $(".care_requirements_pdna_sent_date").html("");
            }
        });


        $(document).on("change",
            "#dtoc_pathway,#dtoc_reason_code,#dtoc_service,#care_requirements_pdna_not_required,#care_requirements_pdna_nurse,#care_requirements_pdna_idt,#care_requirements_pdna_sent,#patient_discharge_for_today, #patient_is_equipment, #patient_cdt_action, #discharge_pathway",
            function(e) {
                var reason_code_value = $('#dtoc_reason_code').val();
                var pathway_value = $('#dtoc_pathway').val();
                var dtoc_current_status = $('#dtoc_current_status').val();

                var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
                var selected_authority = $('#selected_authority').val();

                if (dtoc_service.toLowerCase() == 'ooa' && selected_authority != '') {
                    EnableSaveButtonForModals();
                } else if (dtoc_service.toLowerCase() != 'ooa') {
                    EnableSaveButtonForModals();
                }
            });
        $(document).on("keypress", "#selected_authority", function(e) {
            var reason_code_value = $('#dtoc_reason_code').val();
            var pathway_value = $('#dtoc_pathway').val();
            var dtoc_current_status = $('#dtoc_current_status').val();

            var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
            var selected_authority = $('#selected_authority').val();

            if (pathway_value != '' && dtoc_current_status != '') {
                if (dtoc_service.toLowerCase() == 'others') {
                    EnableSaveButtonForModals();
                } else if (dtoc_service.toLowerCase() != 'others') {
                    EnableSaveButtonForModals();
                }
            }
        });



        $(document).on("change", "#dtoc_service", function(e) {
            var dtoc_service = $(this).find(':selected').text().trim();

            if (dtoc_service.toLowerCase() === 'others') {
                if ($('#show_other_authority_box').hasClass('d-none')) {
                    $('#show_other_authority_box').removeClass('d-none');
                }
            } else {
                if (!$('#show_other_authority_box').hasClass('d-none')) {
                    $('#show_other_authority_box').addClass('d-none');
                }
            }
        });


        $(document).on("click", ".save_dtoc_next_patient", function(e) {
            @if (CheckSpecificPermission('discharge_tracker_referral_update'))

                var pathway_value = $('#dtoc_pathway').val();
                var dtoc_current_status = $('#dtoc_current_status').val();



                DisableButtonClickForPreventFurtherEvent('save_dtoc_next_patient');
                EnableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                var token = "{{ csrf_token() }}";
                var reason_code_value = $('#dtoc_reason_code').val();
                var planned_discharge_date = $("#planned_discharge_date").val();

                var pathway_value = $('#dtoc_pathway').val();
                var dtoc_current_status = $('#dtoc_current_status').val();
                var dtoc_service = $('#dtoc_service').val();
                var dtoc_service_by_pathway = $('#dtoc_service_by_pathway').val();
                var next_patient_id_data = $(this).data('camis-next-patient');
                var camis_patient_id = $('#dtoc_patient_id').val();
                if (next_patient_id_data != '') {
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
                var next_patient_id_data = $(this).data('camis-next-patient');
                var next_patient_go = $(this).data('next_patient_go');

                if (next_patient_id_data != '') {
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
                var tab = $('#tab').val();
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
                        "dt_drop_id": discharge_pathway,
                        "is_referral": 1,
                        "tab": tab
                    },
                    success: function(result) {

                        if (typeof result.message !== 'undefined') {

                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();


                            CloseOffcanvas('patientDetails');
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();


                            CloseOffcanvas('patientDetails');
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




        $(document).on('click', '.add_comment', function() {
            @if (CheckSpecificPermission('discharge_tracker_discharge_info_comment_add') ||
                    CheckSpecificPermission('discharge_tracker_discharge_info_comment_update'))
                var token = "{{ csrf_token() }}";
                var camis_patient_id = $(this).data('camis-patient-id');
                var comment_id = $(this).data('comment-id');
                var comment_type = $(this).data('comment-type');
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
                                var add_commrnt_modal = new bootstrap.Modal(document.getElementById(
                                    'modal_add_comment_popup'), {
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
        $(document).on("change", "#patient_cdt_action", function(e) {
            var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
            if ($('#patient_cdt_action').is(':checked')) {
                $('.patient_cdt_action_user').html('{{ session()->get('LOGGED_USER_NAME') }}');
                $('.patient_cdt_action_datetime').html(currentTime);
            } else {
                $('.patient_cdt_action_user').html('');
                $('.patient_cdt_action_datetime').html('');
            }
        });

        $(document).on("change", "#patient_is_equipment", function(e) {
            var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
            if ($('#patient_is_equipment').is(':checked')) {
                $('.patient_is_equipment_user').html('{{ session()->get('LOGGED_USER_NAME') }}');
                $('.patient_is_equipment_datetime').html(currentTime);
            } else {
                $('.patient_is_equipment_user').html('');
                $('.patient_is_equipment_datetime').html('');
            }
        });


        $(document).on("change", "#patient_discharge_for_today", function(e) {
            var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
            if ($('#patient_discharge_for_today').is(':checked')) {
                $('.patient_discharge_for_today_user').html('{{ session()->get('LOGGED_USER_NAME') }}');
                $('.patient_discharge_for_today_datetime').html(currentTime);
            } else {
                $('.patient_discharge_for_today_user').html('');
                $('.patient_discharge_for_today_datetime').html('');
            }
        });
        $(document).on('input', '#comment_data', function() {
            $(".camis_save_discharge_comment").removeClass("bottom-save-button-disabled");
        });
        $(document).on('click', '#is_a_priority_comment', function() {
            var comment = $("#comment_data").val();

            if (comment !== '') {
                $(".camis_save_discharge_comment").removeClass("bottom-save-button-disabled");
            }

        });

        $(document).on("click", ".camis_save_discharge_comment", function(e) {
            @if (CheckSpecificPermission('discharge_tracker_discharge_info_comment_add') ||
                    CheckSpecificPermission('discharge_tracker_discharge_info_comment_update'))





                var token = "{{ csrf_token() }}";
                var comment_id = $('#data_comment_id').val();
                var initials = $('#initial_type').val();
                var text = $('#comment_data').val();
                var comment_type = $('#comment_type').val();
                var camis_patient_id = $('#comment_patient_id').val();

                if (text == '') {
                    toastr.warning('Add Some Comment To Continue');
                    return;
                }
                var priority = $('#is_a_priority_comment').is(':checked') ? 1 : 0;

                if (comment_id != '') {
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
                    success: function(result) {
                        if (result != null) {
                            if (comment_type != '') {
                                $('#viewAllCommentsBody').html(result.offcanvas);
                                $('#comment_list_' + camis_patient_id).html(result.page);
                                $('#comment_list_' + camis_patient_id).removeAttr('style');
                                $('#modal_add_comment_popup').modal('hide');

                                toastr.success('{{ DataUpdatedMessage() }}');
                            } else {


                                $('#comment_list_' + camis_patient_id).html(result.page);
                                $('#comment_list_modal_' + camis_patient_id).html(result.page);
                                $('#comment_list_' + camis_patient_id).removeAttr('style');
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


        $(document).on('click', '.delete_comment', function() {
            @if (CheckSpecificPermission('discharge_tracker_discharge_info_comment_delete'))
                var token = "{{ csrf_token() }}";
                var camis_patient_id = $(this).data('camis-patient-id');
                var comment_id = $(this).data('comment-id');
                var comment_type = $(this).data('comment-type');
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
                                if (comment_type !== 'page') {
                                    $('#viewAllCommentsBody').html(result.offcanvas);
                                    $('#comment_list_' + camis_patient_id).html(result.page);
                                    $('#modal_add_comment_popup').modal('hide');
                                    $('.delete_comment').tooltip('dispose');
                                    toastr.success('{{ DataRemovalMessage() }}');
                                } else {
                                    $('.delete_comment').tooltip('dispose');
                                    $('#comment_list_' + camis_patient_id).html(result.page);
                                    $('#comment_list_modal_' + camis_patient_id).html(result.page);
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
            var comment_id = $(this).data('comment-id');
            var comment_type = $(this).data('comment-type');
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

                            if (comment_type !== 'page') {
                                $('#viewAllCommentsBody').html(result.offcanvas);
                                $('#comment_list_' + camis_patient_id).html(result.page);
                                $('#modal_add_comment_popup').modal('hide');
                                $('.delete_comment').tooltip('dispose');
                                toastr.success('{{ DataRemovalMessage() }}');
                            } else {
                                $('.delete_comment').tooltip('dispose');
                                $('#comment_list_' + camis_patient_id).html(result.page);
                                $('#comment_list_modal_' + camis_patient_id).html(result.page);
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

        $(document).on("click", ".comment_history_modal", function(e) {
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

                            var tu_modal_confirmation = new bootstrap.Modal(document.getElementById(
                                'modal_comment_history'), {
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

        $(document).on("click", ".medfit_timeline", function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('patient-id');
            DisableButtonClickForPreventFurtherEvent("medfit_timeline");
            var timeline_modal = new bootstrap.Modal(document.getElementById('timeline'), {
                backdrop: 'static',
            });
            timeline_modal.show();
            CommonDisableEnableOnOpen();

            $("#medfit_timeline_data").html('');
            if (camis_patient_id != '') {

                var url = "{{ route('discharged.medfittimeline') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        'camis_patient_id': camis_patient_id
                    },
                    success: function(result) {
                        $("#medfit_timeline_data").html(result);
                        DisableLoaderAndMakeVisibleInnerBody();

                    },
                    error: function(textStatus, errorThrown) {
                        toastr.warning('Something Went Wrong');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });



            } else {
                toastr.warning('Something Went Wrong');
            }
        });
    </script>
    <script>
        $(document).on("change", "#dtoc_current_status", function(e) {
            var reason_code_value = $('#dtoc_reason_code').val();
            var pathway_value = $('#dtoc_pathway').val();
            var dtoc_current_status = $('#dtoc_current_status').val();

            var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
            var selected_authority = $('#selected_authority').val();

            if (pathway_value != '' && dtoc_current_status != '') {
                if (dtoc_service.toLowerCase() == 'ooa' && selected_authority != '') {
                    EnableSaveButtonForModals();
                } else if (dtoc_service.toLowerCase() != 'ooa') {
                    EnableSaveButtonForModals();
                }
            }
        });
        $(document).on("change",
            "#dtoc_pathway,#dtoc_reason_code,#dtoc_service,#care_requirements_pdna_not_required,#care_requirements_pdna_nurse,#care_requirements_pdna_idt,#care_requirements_pdna_sent",
            function(e) {
                var reason_code_value = $('#dtoc_reason_code').val();
                var pathway_value = $('#dtoc_pathway').val();
                var dtoc_current_status = $('#dtoc_current_status').val();

                var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
                var selected_authority = $('#selected_authority').val();

                if (pathway_value != '') {
                    if (dtoc_service.toLowerCase() == 'ooa' && selected_authority != '') {
                        EnableSaveButtonForModals();
                    } else if (dtoc_service.toLowerCase() != 'ooa') {
                        EnableSaveButtonForModals();
                    }
                }
            });
        $(document).on("keypress", "#selected_authority", function(e) {
            var reason_code_value = $('#dtoc_reason_code').val();
            var pathway_value = $('#dtoc_pathway').val();
            var dtoc_current_status = $('#dtoc_current_status').val();

            var dtoc_service = $('#dtoc_service').find(':selected').text().trim();
            var selected_authority = $('#selected_authority').val();

            if (pathway_value != '') {
                if (dtoc_service.toLowerCase() == 'ooa' && selected_authority != '') {
                    EnableSaveButtonForModals();
                } else if (dtoc_service.toLowerCase() != 'ooa') {
                    EnableSaveButtonForModals();
                }
            }
        });
        $(document).on("change", "#dtoc_service", function(e) {
            var dtoc_service = $(this).find(':selected').text().trim();
            if (dtoc_service.toLowerCase() === 'ooa') {
                if ($('#show_other_authority_box').hasClass('d-none')) {
                    $('#show_other_authority_box').removeClass('d-none');
                }
            } else {
                if (!$('#show_other_authority_box').hasClass('d-none')) {
                    $('#show_other_authority_box').addClass('d-none');
                }
            }
        });
        $(document).on("change", "#patient_important_tick", function(e) {
            var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
            var logged_username = '{{ session()->get('LOGGED_USER_NAME') }}' + ' ' + currentTime;
            if ($('#patient_important_tick').is(':checked')) {
                $('.patient_highlighted_datetime').html(logged_username);
            } else {
                $('.patient_highlighted_datetime').html('');
            }
        });
    </script>
    @include('Dashboards.Camis.DischargeTracker.MedfitJs')

@endsection
