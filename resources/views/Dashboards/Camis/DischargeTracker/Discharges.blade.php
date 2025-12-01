@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Discharge Tracker Discharges')
@section('page-top-title', 'Discharge Tracker Discharges')
@section('page-top-title-sub', 'autotimer')
@section('header')
    @parent
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}" crossorigin="anonymous" />
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeSummary.css') }}" crossorigin="anonymous" />
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Discharges.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargedPatients.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/DischargeTrackerDischarges.css') }}" crossorigin="anonymous">
     <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('modal')
    @include('Dashboards.Camis.DischargeTracker.Modals')
    @include('Common.Modals.CommonModals')
    @include('Common.Modals.CommonDischargeSummary')
@endsection
@section('content')
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    @include('Common.Scripts.CommonDichargeSumamryScript')
    <script>
        function DataPageLoad(date, time, search_text, ward_id){
            @if(CheckSpecificPermission('discharge_tracker_discharge_view'))
                var token               = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.discharges.dataload') }}",
                        type: 'POST',
                        data: { "_token": token, "date": date, "time": time, "ward_id": ward_id, "search_text": search_text},
                        success: function (response)
                        {
                            if(response != ""){
                                $('.today_discharges_value_class').html($('#today_discharges_value').val());

                                $('#contentSection_data').html(response);
                                MultiSelectJs('ward_id', 'Ward');
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err){
                            $('.page-data-loader').hide();
                        }
                    });
                },2000)
            @else
                PermissionDeniedAlert();
            @endif
        }


        $( document ).ready(function()
        {
            var date         = $('#date').val();
            var time          = $('#time').val();
            var search_text     = $('#search_text').val();
            var ward_id     = $('#ward_id').val();
            DataPageLoad(date, time, search_text, ward_id);
        });

    </script>
    <script>

        $(document).on("change", "#date,#time,#ward_id", function (e)
        {
            var date          = $('#date').val();
            var time          = $('#time').val();
            var search_text   = $('#search_text').val();
            var ward_id     = $('#ward_id').val();
            DataPageLoad(date, time, search_text, ward_id);
        });
        $('.discharges_custom_search').keypress(function (e) {
            if (e.which == 13) {
                var date         = $('#date').val();
                var time          = $('#time').val();
                var search_text     = $('#search_text').val();
                var ward_id     = $('#ward_id').val();
                if(search_text != ''){
                    DataPageLoad(date, time, search_text, ward_id);
                }
            }
        });
        $(document).on("click", "#submit_search_text", function (e)
        {
            var date         = $('#date').val();
            var time          = $('#time').val();
            var search_text     = $('#search_text').val();
            var ward_id     = $('#ward_id').val();
            DataPageLoad(date, time, search_text, ward_id);
        });



        $(document).on("change", ".patient_dt_select_drop", function(e) {
            var camis_patient_id = $(this).data('camis-patient-id');
            var admit_time = $(this).data('admit-time');
            var discharge_time = $(this).data('discharge-time');
            var date         = $('#date').val();
            var time          = $('#time').val();
            var search_text     = $('#search_text').val();
            $('.page-data-loader').show();
            if(camis_patient_id != '')
            {

                var dt_drop_id = $('.patient_dt_select_drop_'+camis_patient_id).val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ route('discharged.discharges.datasave') }}",
                    type: 'POST',
                    data: {
                    "camis_patient_id": camis_patient_id,
                    "dt_drop_id": dt_drop_id,
                    "admit_time":admit_time,
                    "discharge_time":discharge_time,
                    "date":date,
                    "time": time,
                    "search_text": search_text,
                    "_token": token
                    },
                    success: function(data) {
                        if(dt_drop_id != '' && dt_drop_id != 0)
                        {
                            $("#discharge_data_"+camis_patient_id).removeClass('class_show_red');
                            $("#discharge_data_"+camis_patient_id).addClass('class_show_green');
                        }
                        else
                        {
                            $("#discharge_data_"+camis_patient_id).removeClass('class_show_green');
                            $("#discharge_data_"+camis_patient_id).addClass('class_show_red');
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
            var other_notes_modal = new bootstrap.Offcanvas(document.getElementById('camis_discharge_comment_offcanvas'), {
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
                            if(result.current_comment != ''){
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
            var camis_patient_id =$("#other_notes_patient_id").val();
            var comment = $('#other_notes_input').val();

            if(comment == ''){
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
                    url:url,
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
                            $('#insert_comment_id_'+camis_patient_id).val(comment);
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
                    url:url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "comment": ''
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {

                            $('#insert_comment_id_'+camis_patient_id).val('');
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

@endsection
