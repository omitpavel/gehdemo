@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Contact Tracing')
@section('page-top-title', 'Contact Tracing')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ContactTracing.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/jquery.multiselect.css') }}" />
    <style>
        .ms-options-wrap>.ms-options>ul>li.optgroup .label {
            display: inline;
            padding-right: 7px;
        }

        .optgroup-all {
            position: unset !important;
        }

        .ms-options-wrap>.ms-options>ul input {
            height: unset !important;
        }
    </style>
@endsection

@section('modal')
    <div class="patients-trace offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        data-bs-backdrop="static" tabindex="-1" id="tracePatients" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Trace Patients</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('tracePatients');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body infection_trace_data">

        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('tracePatients');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal"
                            width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="other-notes-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        data-bs-backdrop="static" tabindex="-1" id="camis_contact_tracing_notes_offcanvas"
        aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true" role="dialog">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Other Notes</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100"
                        onclick="CloseOtherNotesOffcanvas();"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body patient_discharge_comment_data">

            <div class="row ">
                <div class="">
                    <textarea class="form-control" id="other_notes_input" rows="6"></textarea>
                </div>
            </div>
            <div class="history-card">
                <div class="rectangle-block-1">
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between rectangle-block-2">
                                <p class="mb-0">History</p>
                            </div>
                        </div>
                    </div>
                    <div class="data-area">
                        <div class="row mb-2">
                            <div class="col-12 other-notes-section">
                                <div class="rectangle-block-1">
                                    <div class="other-notes other_notes_hisotry">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row ibox_modal_footer_button_class">
                <div class="col-lg-10 offset-lg-1">
                    <div class="row g-2">
                        <div class="col-lg-4 col-md-4">
                            <button
                                class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_save_discharge_comment ">
                                <img class='loading-save-svg-to-show-on-save'
                                    src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                                <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                    class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                    height="18"><span>SAVE</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <button
                                class="btn btn-primary-grey me-2 all_modal_delete_button_for_js bottom-delete-button camis_patient_ward_summary_boardround_remove_comment flag_button">
                                <img class='loading-delete-svg-to-show-on-delete'
                                    src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}" alt="" />
                                <img src="{{ asset('asset_v2/Template/icons/deselect.svg') }}" alt=""
                                    class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="16"
                                    height="16"><span>REMOVE COMMENT</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <button class="btn btn-primary-grey"
                                onclick="CloseOtherNotesOffcanvas();"><img
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
    <input type="hidden" id="contact_tracing_notes_patient_id" value="">
    <input type="hidden" id="trace_patient_id" value="">
    <input type="hidden" id="current_tab" value="only_infected">
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Template/js/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('asset_v2') }}/Generic/Js/toastr.min.js"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>

    <script>
        function MultiSelectJs(elementId, label) {
            $('#' + elementId).multiselect({
                columns: 1,
                placeholder: '' + label,
                search: true,
                searchOptions: {
                    'default': 'Search'
                },
                selectAll: true,
                onOptionClick: function(element, option) {
                    updatePlaceholder(elementId, label);
                },
                onControlClose: function(element) {
                    updatePlaceholder(elementId, label);
                }
            });

            updateGroupCheckboxStates(elementId);
            updatePlaceholder(elementId, label);
            setTimeout(() => {
                const wrapper = $('#' + elementId).next('.ms-options-wrap');

                wrapper.find('.optgroup-all').off('change').on('change', function() {
                    const $group = $(this).closest('.optgroup');
                    const isChecked = $(this).is(':checked');
                    const $childCheckboxes = $group.find('ul li input[type="checkbox"]').not(
                        '.optgroup-all');
                    const $select = $('#' + elementId);

                    $childCheckboxes.prop('checked', isChecked).trigger('change');

                    $childCheckboxes.each(function() {
                        const val = $(this).val();
                        $select.find(`option[value="${val}"]`).prop('selected', isChecked);
                    });

                    $select.multiselect('reload');

                    $select.trigger('change');

                    updateGroupCheckboxStates(elementId);
                    updatePlaceholder(elementId, label);
                });
            }, 200);

        }

        function updateGroupCheckboxStates(elementId) {
            $('#' + elementId).next('.ms-options-wrap').find('.optgroup').each(function() {
                const $group = $(this);
                const $options = $group.find('ul li input[type="checkbox"]').not('.optgroup-all');
                const $groupCheckbox = $group.find('.optgroup-all');

                if ($options.length === 0) return;

                const allChecked = $options.length === $options.filter(':checked').length;

                $groupCheckbox.prop('checked', allChecked);
            });
        }

        function updatePlaceholder(elementId, label) {
            let selectedCount = $('#' + elementId + ' option:selected').length;
            let placeholderText = '';

            if (selectedCount === 0) {
                placeholderText = '' + label;
            } else if (selectedCount === 1) {
                placeholderText = '1 ' + label + ' Selected';
            } else {
                placeholderText = selectedCount + ' ' + label + 's Selected';
            }

            $('#' + elementId).next('.ms-options-wrap').find('button').html('<span>' + placeholderText + '</span>');
        }

        function DataPageLoad(search_text, infection, ward_id, tab = 'only_infected') {
            @if (CheckSpecificPermission('infection_control_covid_contact_tracing_view'))
                var token = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('infection.contact.tracing.dataload') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "search_text": search_text,
                            "infection": infection,
                            "ward_id": ward_id,
                            "tab": tab
                        },
                        success: function(response) {
                            if (response != "") {

                                $('#contentSection_data').html(response);
                                $('#current_tab').val(tab);
                                $('.SelectBoxWrap select').selectric('refresh');
                                MultiSelectJs('infection', 'Infection');
                                MultiSelectJs('ward_id', 'Wards');
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err) {
                            $('.page-data-loader').hide();
                        }
                    });
                }, 2000)
            @else
                CommonLoginModalPopupOpenOnRequest();
            @endif
        }


        function TabSwitcher(tab = 'only_infected') {
            @if (CheckSpecificPermission('infection_control_covid_contact_tracing_view'))
                var token = "{{ csrf_token() }}";
                var pas_number = '';
                var name = '';
                var infection = '';
                var ward_id = '';
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('infection.contact.tracing.dataload') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "pas_number": pas_number,
                            "name": name,
                            "infection": infection,
                            "ward_id": ward_id,
                            "tab": tab
                        },
                        success: function(response) {
                            if (response != "") {

                                $('#contentSection_data').html(response);
                                $('#current_tab').val(tab);
                                MultiSelectJs('infection', 'Infection');
                                MultiSelectJs('ward_id', 'Wards');
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err) {
                            $('.page-data-loader').hide();
                        }
                    });
                }, 2000)
            @else
                CommonLoginModalPopupOpenOnRequest();
            @endif
        }

        $(document).ready(function() {
            var search_text = $('#search_text').val();
            var infection = $('#infection').val();
            var ward_id = $('#ward_id').val();
            var tab = $('#current_tab').val();
            DataPageLoad(search_text, infection, ward_id, tab);
        });

        $(document).on("click", ".search_data", function(e) {
            var search_text = $('#search_text').val();
            var infection = $('#infection').val();
            var ward_id = $('#ward_id').val();
            var tab = $('#current_tab').val();
            DataPageLoad(search_text, infection, ward_id, tab);
        });



        $(document).on("click", ".click_open_inpatient_trace", function() {
            $('.infection_trace_data').html('');
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('patient-id');
            var tab = $('#current_tab').val();
            var url = "{{ route('infection.contact.tracing.patient') }}";

            var trace_modal = new bootstrap.Offcanvas(document
                .getElementById(
                    'tracePatients'
                ), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: false
                });
            trace_modal.show();
            EnableLoaderAndMakeHiddenInnerBody();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id,
                    'tab': tab
                },
                success: function(result) {
                    $("#trace_patient_id").val(camis_patient_id);
                    $('.infection_trace_data').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();

                },
                error: function(textStatus, errorThrown) {
                    CloseOffcanvas('tracePatients');
                }
            });
        });
    </script>
    <script>
        function CloseOtherNotesOffcanvas() {
            CloseOffcanvas('camis_contact_tracing_notes_offcanvas');
            setTimeout(function() {
                $('.infection_trace_data').html('');
                var token = "{{ csrf_token() }}";
                var camis_patient_id = $("#trace_patient_id").val();
                var url = "{{ route('infection.contact.tracing.patient') }}";

                var trace_modal = new bootstrap.Offcanvas(document
                    .getElementById(
                        'tracePatients'
                    ), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: false
                    });
                trace_modal.show();
                EnableLoaderAndMakeHiddenInnerBody();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        'camis_patient_id': camis_patient_id
                    },
                    success: function(result) {
                        $('.infection_trace_data').html(result);
                        DisableLoaderAndMakeVisibleInnerBody();

                    },
                    error: function(textStatus, errorThrown) {
                        CloseOffcanvas('tracePatients');
                    }
                });
            }, 1000);
        }



        $(document).on("click", ".contact_traced_patient_notes", function(event) {
            DisableButtonClickForPreventFurtherEvent('contact_traced_patient_notes');
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('patient-id');
            $("#contact_tracing_notes_patient_id").val(camis_patient_id);


            if (camis_patient_id == '') {
                toastr.error('Something Went Wrong.');
                return false;
            }
            CloseOffcanvas('tracePatients');
            setTimeout(function() {
                var other_notes_modal = new bootstrap.Offcanvas(document.getElementById(
                    'camis_contact_tracing_notes_offcanvas'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: false
                });
                other_notes_modal.show();
            }, 1000);



            CommonDisableEnableOnOpen();
            EnableLoaderAndMakeHiddenInnerBody();
            if (camis_patient_id != '') {
                var url = "{{ route('infection.contact.tracing.other.notes') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id
                    },
                    success: function(result) {

                        if (result != '') {

                            $(".other_notes_hisotry").html(result.sections);
                            $("#other_notes_input").val(result.current_comment);


                            $("#other_notes_input").focus();

                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            DisableSaveButtonForModals();
                            if (result.current_comment != '') {
                                EnableDeleteButtonForModals();
                            } else {
                                DisableDeleteButtonForModals();
                            }
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        CloseOtherNotesOffcanvas();
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CloseOtherNotesOffcanvas();
                CommonErrorModalPopupOpenOnRequest();
            }
        });
        $(document).on("keyup", "#other_notes_input", function(e) {
            var comment = $('#other_notes_input').val();
            if (comment != '') {
                EnableSaveButtonForModals();
            } else {
                DisableSaveButtonForModals();
            }
        });

        $(document).on("click", ".camis_patient_ward_save_discharge_comment", function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $("#contact_tracing_notes_patient_id").val();
            var comment = $('#other_notes_input').val();

            if (comment == '') {
                toastr.warning('Please enter comment to save.');
                return false;
            }
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            $('.modal-dummy-content-loader').show();
            $('.other_notes_hisotry').html('');
            if (camis_patient_id != '') {
                console.log('success');
                var url = "{{ route('infection.contact.tracing.save.other.notes') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "comment": comment
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {


                            DisableSaveButtonLoadImageForModals();

                            EnableDeleteButtonForModals();
                            DisableSaveButtonForModals();
                            toastr.success('{{ DataUpdatedMessage() }}');
                            $('.other_notes_hisotry').html(result.sections);
                            $('#insert_comment_id_' + camis_patient_id).val(comment);
                            $('#contact_traced_patient_' + camis_patient_id).val(comment);
                            CloseOtherNotesOffcanvas();
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOtherNotesOffcanvas();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                            $('.modal-dummy-content-loader').hide();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        $('.modal-dummy-content-loader').hide();
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });

        $(document).on("click", ".camis_patient_ward_summary_boardround_remove_comment", function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $("#contact_tracing_notes_patient_id").val();
            var comment = $('#discharges_latest_comment').val();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            $('.modal-dummy-content-loader').show();

            if (camis_patient_id != '') {
                console.log('success');
                var url = "{{ route('infection.contact.tracing.save.other.notes') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "comment": ''
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {

                            $('#insert_comment_id_' + camis_patient_id).val('');
                            $('#contact_traced_patient_' + camis_patient_id).val('');
                            CloseOtherNotesOffcanvas();
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOtherNotesOffcanvas();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                            $('.modal-dummy-content-loader').hide();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        CloseOtherNotesOffcanvas();
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    </script>
@endsection
