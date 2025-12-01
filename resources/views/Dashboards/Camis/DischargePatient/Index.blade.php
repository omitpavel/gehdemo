@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Discharged Patients')
@section('page-top-title', 'Discharged Patients Summary')
@section('header')
    @parent

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeSummary.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Discharges.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargedPatients.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/DischargedPatients.css') }}" crossorigin="anonymous">
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />



@endsection
@section('modal')
    @include('Common.Modals.CommonDischargeSummary')
    <div class="other-notes-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        data-bs-backdrop="static" tabindex="-1" id="camis_discharge_comment_offcanvas"
        aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true" role="dialog">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Other Notes</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100"
                        onclick="CloseOffcanvas('camis_discharge_comment_offcanvas');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body patient_discharge_comment_data">
            <input type="hidden" id="other_notes_patient_id">
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
                                    height="16"><span>REMOVE OTHER NOTES</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <button class="btn btn-primary-grey"
                                onclick="CloseOffcanvas('camis_discharge_comment_offcanvas');"><img
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
    <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";
        var ajax_refresh_url = "";
    </script>
    @include('Common.Scripts.CommonDichargeSumamryScript')
    <script>
        $(document).on("change keyup", "#camis_patient_potential_definitte_assign_task", function(e) {
            var task_group_val = $('#boardround_patient_task_group').val();
            var description = $('#boardround_patient_task_description').val();

            if (task_group_val && description != null) {
                $('.camis_patient_boardround_save_task_create_or_update').removeClass(
                    'bottom-save-button-disabled');
            } else {
                $('.camis_patient_boardround_save_task_create_or_update').addClass('bottom-save-button-disabled');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            loadContent();
        });

        function initSingleDatePicker() {
            var $dp = $('#contentSection_data').find('#date_picker');
            if (!$dp.length) return;

            if ($dp.data('daterangepicker')) {
                $dp.data('daterangepicker').remove();
            }

            var fmt = 'YYYY-MM-DD';
            var raw = ($dp.val() || '').trim();
            var hasValidPrefill = moment(raw, fmt, true).isValid();

            $dp.daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                autoUpdateInput: false,
                maxDate: moment(),
                startDate: hasValidPrefill ? moment(raw, fmt) : moment(),
                locale: {
                    format: fmt
                }
            });

            if (hasValidPrefill) {
                $dp.val(raw);
                var drp = $dp.data('daterangepicker');
                drp.setStartDate(raw);
                drp.setEndDate(raw);
            } else {
                $dp.val('');
                var drp = $dp.data('daterangepicker');
                drp.setStartDate(moment());
                drp.setEndDate(moment());
                $dp.val('');
            }

            $dp.on('apply.daterangepicker', function(ev, picker) {
                $('#search_input').val('');
                $(this).val(picker.startDate.format(fmt)).trigger('change');
            });

            $dp.on('cancel.daterangepicker', function() {
                $(this).val('').trigger('change');
            });
        }



        function safeGetDate() {
            var v = ($('#date_picker').val() || '').trim();
            return moment(v, 'YYYY-MM-DD', true).isValid() ? v : '';
        }

        function loadContent(params = {}) {
            var ward_id = params.ward_id ?? $('#ward_id').val() ?? '';
            var search_input = params.search_input ?? $('#search_input').val() ?? '';

            $('.page-data-loader').show();

            $.ajax({
                url: "{{ route('discharges_patient.content') }}",
                type: 'GET',
                data: {
                    ward_id: ward_id,
                    date: safeGetDate(),
                    search_input: search_input
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);

                        if (typeof MultiSelectJs === 'function') {
                            MultiSelectJs('ward_id', 'Ward');
                        }

                        initSingleDatePicker();

                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }
                }
            });
        }

        $(document).on('change', '#ward_id, #date_picker', function() {
            $('#search_input').val('');
            loadContent({
                ward_id: $('#ward_id').val() || '',
                date: safeGetDate()
            });
        });

        function ResetData() {
            loadContent({
                ward_id: '',
                date: '',
                search_input: ''
            });
        }

        function SearchFunction() {
            $('#date_picker').val('');
            loadContent({
                search_input: $('#search_input').val() || '',
                date: safeGetDate(),
                ward_id: '',
            });
        }
    </script>
    <script>
        function CommonJsFunctionCallAfterContentRefersh() {
            MultiSelectJs('ward_id', 'Ward');
        }
    </script>




    <script></script>


    <script>
        $(document).on("change", ".patient_dt_select_drop", function(e) {
            var camis_patient_id = $(this).data('camis-patient-id');
            var admit_time = $(this).data('admit-time');
            var discharge_time = $(this).data('discharge-time');
            var date = $('#date').val();
            var time = $('#time').val();
            var search_text = $('#search_text').val();
            $('.page-data-loader').show();
            if (camis_patient_id != '') {

                var dt_drop_id = $('.patient_dt_select_drop_' + camis_patient_id).val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ route('discharged.discharges.datasave') }}",
                    type: 'POST',
                    data: {
                        "camis_patient_id": camis_patient_id,
                        "dt_drop_id": dt_drop_id,
                        "admit_time": admit_time,
                        "discharge_time": discharge_time,
                        "date": date,
                        "time": time,
                        "search_text": search_text,
                        "_token": token
                    },
                    success: function(data) {
                        if (dt_drop_id != '' && dt_drop_id != 0) {
                            $("#discharge_data_" + camis_patient_id).removeClass('class_show_red');
                            $("#discharge_data_" + camis_patient_id).addClass('class_show_green');
                        } else {
                            $("#discharge_data_" + camis_patient_id).removeClass('class_show_green');
                            $("#discharge_data_" + camis_patient_id).addClass('class_show_red');
                        }
                        $('.page-data-loader').hide();
                        toastr.success('Data Updated');

                    }
                });
            }
        });

        $(document).on("click", ".export_patient_list", function(e) {
            e.preventDefault();

            const csvEscape = (s) => {
                const str = (s == null ? "" : String(s)).replace(/"/g, '""').trim();
                return `"${str}"`;
            };

            const csv = [];
            const $blocks = $(".responsiveTable .table-patient-tbody");

            if ($blocks.length === 0) return;

            (function buildHeader() {
                const $first = $blocks.first();
                const headers = [];

                $first.find(".table-patient-row-1 td").each(function() {
                    const $td = $(this).clone();
                    const label = $td.find(".tdBefore").first().text().trim();
                    headers.push(label || "");
                });

                headers.push("Discharge Pathway");
                headers.push("Other Notes");

                csv.push(headers.map(csvEscape).join(","));
            })();

            $blocks.each(function() {
                const $block = $(this);
                const row = [];

                $block.find(".table-patient-row-1 td").each(function() {
                    const $td = $(this).clone();
                    $td.find(".tdBefore, .patient-gender").remove();
                    const cellText = $td.text().replace(/\s+/g, " ").trim();
                    row.push(csvEscape(cellText));
                });

                let pathwayText = "";
                const $select = $block.find(".table-patient-row-2 select.patient_dt_select_drop").first();
                if ($select.length) {
                    const val = ($select.val() || "").trim();
                    if (val !== "") {
                        pathwayText = $select.find("option:selected").text().replace(/\s+/g, " ").trim();
                    }
                }
                row.push(csvEscape(pathwayText));

                let notesVal = "";
                const $notes = $block.find(".table-patient-row-2 textarea").first();
                if ($notes.length) {
                    notesVal = $notes.val();
                }
                row.push(csvEscape(notesVal));

                csv.push(row.join(","));
            });

            const csvContent = csv.join("\n");
            const blob = new Blob([csvContent], {
                type: "text/csv;charset=utf-8;"
            });
            const url = URL.createObjectURL(blob);

            const a = document.createElement("a");
            a.href = url;
            a.download = "discharges_patients.csv";
            a.style.display = "none";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
        $(document).on("click", ".click_open_other_comment_offcanvas", function(event) {
            DisableButtonClickForPreventFurtherEvent('click_open_other_comment_offcanvas');
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('patient-id');
            $("#other_notes_patient_id").val(camis_patient_id);
            var other_notes_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_discharge_comment_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });
            other_notes_modal.show();


            CommonDisableEnableOnOpen();
            EnableLoaderAndMakeHiddenInnerBody();
            if (camis_patient_id != '') {
                var url = "{{ route('discharged.other.notes') }}";
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
                        CloseOffcanvas('camis_discharge_comment_offcanvas');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CloseOffcanvas('camis_discharge_comment_offcanvas');
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
            var camis_patient_id = $("#other_notes_patient_id").val();
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
                var url = "{{ route('discharged.save.other.notes') }}";
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
                            CloseOffcanvas('camis_discharge_comment_offcanvas');
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOffcanvas('camis_discharge_comment_offcanvas');
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
            var camis_patient_id = $("#other_notes_patient_id").val();
            var comment = $('#discharges_latest_comment').val();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            $('.modal-dummy-content-loader').show();

            if (camis_patient_id != '') {
                console.log('success');
                var url = "{{ route('site.discharges_patient.savecomments') }}";
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
                            CloseOffcanvas('camis_discharge_comment_offcanvas');
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOffcanvas('camis_discharge_comment_offcanvas');
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
                        CloseOffcanvas('camis_discharge_comment_offcanvas');
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    </script>

    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/ResponsiveTabViewCustom.js') }}"></script>

    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

@endsection
