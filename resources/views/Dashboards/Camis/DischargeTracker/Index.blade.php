@extends('Layouts.Common.MasterLayout')
@section('page-title', 'CDT Patient List')
@section('page-top-title', 'CDT Patient List')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Discharges.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeSummary.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeTracker.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesPatientDetails.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesTimeline.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesCommentHistory.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/DischargeTrackerPatientDetails.css') }}"
        crossorigin="anonymous">
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/jquery.multiselect.css') }}" />
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
@endpush

@section('modal')
    @include('Dashboards.Camis.DischargeTracker.Modals')
    @include('Common.Modals.CommonDischargeSummary')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')

    <div class="container-fluid" id="contentSection_data">
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Template/js/jquery.multiselect.js') }}"></script>
    @include('Dashboards.Camis.DischargeTracker.ViewAllcommentScript')


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



        function DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id) {
            @if (CheckSpecificPermission('discharge_tracker_complex_discharge_view'))
                var token = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                var sort_by = $('#sort_by').val();
                var date = $('#start_date_day_summary_val').val();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.complex.data.load') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "ward_id": ward_id,
                            "medfit": medfit,
                            "search_text": search_text,
                            "pathway_id": pathway_id,
                            "service_id": service_id,
                            "authority_id": authority_id,
                            "sort_by": sort_by,
                            "date": date
                        },
                        success: function(response) {
                            if (response != "") {

                                $('#contentSection_data').html(response);
                                $('.SelectBoxWrap select').selectric('refresh');
                                $('.page-data-loader').hide();

                                $('.today_discharges_value_class').html($('#today_discharges_value')
                                    .val());
                                MultiSelectJs('ward_id', 'Ward');
                                MultiSelectJs('medfit_value', 'MedFit');
                                MultiSelectJs('pathway_id', 'Pathway');
                                MultiSelectJs('authority_id', 'Authority');
                                MultiSelectJs('service_id', 'Service');
                                UpdatePathwayCount();
                            }
                        },
                        error: function(status, err) {
                            $('.page-data-loader').hide();
                        }
                    });
                }, 2000)
            @else
                PermissionDeniedAlert();
            @endif
        }

        $(document).on("change", "#sort_by", function(event) {
            var ward_id = $('#ward_id').val();
            var medfit = $('#medfit_value').val();
            var search_text = '';
            var pathway_id = $('#pathway_id').val();
            var service_id = $('#service_id').val();
            var authority_id = $('#authority_id').val();


            DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);
        });

        $(document).on("click", ".click_dtoc_search_reset", function(event) {

            @if (CheckSpecificPermission('discharge_tracker_complex_discharge_view'))
                $('.page-data-loader').show();
                var token = "{{ csrf_token() }}";
                var sort_by = '';
                var date = '';
                var ward_id = '';
                var medfit = '';
                var search_text = '';
                var pathway_id = '';
                var service_id = '';
                var authority_id = '';
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.complex.data.load') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "ward_id": ward_id,
                            "medfit": medfit,
                            "search_text": search_text,
                            "pathway_id": pathway_id,
                            "service_id": service_id,
                            "authority_id": authority_id,
                            "sort_by": sort_by,
                            "date": date
                        },
                        success: function(response) {
                            if (response != "") {

                                $('#contentSection_data').html(response);
                                $('.SelectBoxWrap select').selectric('refresh');
                                $('.page-data-loader').hide();
                                MultiSelectJs('ward_id', 'Ward');
                                MultiSelectJs('medfit_value', 'MedFit');
                                MultiSelectJs('pathway_id', 'Pathway');
                                MultiSelectJs('authority_id', 'Authority');
                                MultiSelectJs('service_id', 'Service');
                                UpdatePathwayCount();
                            }
                        },
                        error: function(status, err) {
                            $('.page-data-loader').hide();
                        }
                    });
                }, 2000)
            @else
                PermissionDeniedAlert();
            @endif
        });
        $(document).ready(function() {
            var ward_id = $('#ward_id').val();
            var medfit = $('#medfit_value').val();
            var search_text = $('#search_text').val();
            var pathway_id = $('#pathway_id').val();
            var service_id = $('#service_id').val();
            var authority_id = $('#authority_id').val();


            DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);


        });

        $(document).on("keypress", "#search_text", function(event) {
            if (event.which === 13) {
                var ward_id = $('#ward_id').val();
                var medfit = $('#medfit_value').val();
                var search_text = $('#search_text').val();
                var pathway_id = $('#pathway_id').val();
                var service_id = $('#service_id').val();
                var authority_id = $('#authority_id').val();


                DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);
            }
        });





        $(document).on("click", ".discharge_tracker_medfit_yes", function(e) {
            var ward_id = '';
            if (!$(this).hasClass('active')) {
                var medfit = 'Yes';
            } else {
                var medfit = '';
            }
            var search_text = '';
            var pathway_id = '';

            var service_id = $('#service_id').val();
            var authority_id = $('#authority_id').val();


            DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);
        });

        $(document).on("click", ".discharge_tracker_medfit_no", function(e) {
            var ward_id = '';
            if (!$(this).hasClass('active')) {
                var medfit = 'No';
            } else {
                var medfit = '';
            }
            var search_text = '';
            var pathway_id = '';
            var service_id = $('#service_id').val();
            var authority_id = $('#authority_id').val();


            DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);
        });


        $(document).on("click", ".discharge_tracker_cdt_yes", function(e) {
            var ward_id = $('#ward_id').val();
            var medfit = $('#medfit_value').val();
            var search_text = $('#search_text').val();
            var pathway_id = $('#pathway_id').val();
            if ($('.discharge_tracker_cdt_yes').hasClass('active')) {
                var cdt = '';
            } else {
                var cdt = 1;
            }
            DataPageLoad(ward_id, medfit, search_text, pathway_id, cdt);
        });



        $(document).on('click', '.export_column_selection', function() {
            var $btn = $(this);
            var $checkboxes = $('#exportColumns .export-col');

            if ($btn.hasClass('export_all_active')) {

                $checkboxes.prop('checked', false);
                $btn.removeClass('export_all_active').text('Select All');
            } else {
                $checkboxes.prop('checked', true);
                $btn.addClass('export_all_active').text('Deselect All');
            }
        });
        $(document).on('change', '#exportColumns .export-col', function() {
            var $btn = $('.export_column_selection');
            var $checkboxes = $('#exportColumns .export-col');
            var total = $checkboxes.length;
            var checked = $checkboxes.filter(':checked').length;

            if (checked === total) {
                $btn.addClass('export_all_active').text('Deselect All');
            } else {
                $btn.removeClass('export_all_active').text('Select All');
            }
        });

        $(document).on('click', '.export_discharge_tracker', function(e) {
            @if (CheckSpecificPermission('discharge_tracker_complex_discharge_export_view'))
                var export_column_modal = new bootstrap.Offcanvas(document.getElementById('exportColumns'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: false
                });

                $('#exportColumns .export-col').prop('checked', true);

                $('.export_column_selection')
                    .addClass('export_all_active')
                    .text('Deselect All');

                export_column_modal.show();
            @else
                toastr.error('Permission Denied');
            @endif
        });

        $(document).on("click", ".export_discharge_tracker_confirm", function(e) {
            @if (CheckSpecificPermission('discharge_tracker_complex_discharge_export_view'))
                function safeVal(id) {
                    return $('#' + id).length ? $('#' + id).val() : '';
                }

                var ward_id = safeVal('ward_id');
                var medfit = safeVal('medfit_value');
                var search_text = safeVal('search_text');
                var pathway_id = safeVal('pathway_id');
                var service_id = safeVal('service_id');
                var authority_id = safeVal('authority_id');
                var sort_by = safeVal('sort_by');
                var date = safeVal('start_date_day_summary_val');

                var columns = $('.export-col:checked').map(function() {
                    return this.value;
                }).get().join(',');

                var url = "{{ route('discharged.export') }}" +
                    "?pathway_id=" + (pathway_id ?? 'null') +
                    "&ward_id=" + (ward_id ?? 'null') +
                    "&medfit=" + (medfit ?? 'null') +
                    "&search_text=" + (search_text ?? 'null') +
                    "&service_id=" + (service_id ?? 'null') +
                    "&authority_id=" + (authority_id ?? 'null') +
                    "&sort_by=" + (sort_by ?? 'null') +
                    "&date=" + (date ?? 'null') +
                    "&columns=" + encodeURIComponent(columns || ''); // <- NEW

                window.open(url, '_blank');
                setTimeout(function() {
                    CloseOffcanvas('exportColumns');
                }, 1000);
            @else
                toastr.error('Permission Denied');
            @endif
        });

        function PrintHtmlDischargeTracker(innerHtml, titleText = 'Complex Discharges') {
            var w = window.open('', '_blank');

            var print_title =
                '<div class="print_title_star_styling_head" ' +
                'style="border-radius:8px; justify-content:center; display:flex; ' +
                'padding-top:16px; padding-bottom:40px; font-size:15px; font-weight:600;">' +
                titleText + '</div>';

            var html =
                print_title +
                '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
                innerHtml +
                '</div>';

            w.document.open();
            w.document.write('<!doctype html><html><head></head><body>' + html + '</body></html>');
            w.document.close();

            var head = w.document.head;
            head.insertAdjacentHTML('beforeend',
                '<link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
            head.insertAdjacentHTML('beforeend',
                '<link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
            head.insertAdjacentHTML('beforeend',
                '<link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeTracker.css') }}">');
            head.insertAdjacentHTML('beforeend',
                '<link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');

            var buttons = w.document.getElementsByTagName('button');
            for (var i = 0; i < buttons.length; i++) {
                if (!buttons[i].classList.contains('allowed')) {
                    buttons[i].style.display = 'none';
                }
            }

            setTimeout(function() {
                w.onafterprint = function() {
                    w.close();
                };
                w.focus();
                w.print();
            }, 300);
        }

        function FetchDischargeHtml(params) {
            var token = "{{ csrf_token() }}";
            return $.ajax({
                url: "{{ route('discharged.complex.data.print') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: Object.assign({
                    "_token": token
                }, params || {})
            });
        }

        function DataPageLoadPrint() {
            var params = {
                ward_id: '',
                medfit: '',
                search_text: '',
                pathway_id: '',
                service_id: '',
                authority_id: '',
                sort_by: '',
                date: ''
            };

            FetchDischargeHtml(params)
                .done(function(response) {

                })
                .fail(function() {
                    toastr.warning('Something Went Wrong');
                });
        }


        $(document).on("click", ".print_complex_discharge", function(e) {
            e.preventDefault();

            var $content = $(".discharge-tracker-contents");
            var existingHtml = $content.length ? $.trim($content.html()) : '';

            if (existingHtml) {
                PrintHtmlDischargeTracker(existingHtml, 'Complex Discharges');
            } else {
                var params = {
                    ward_id: '',
                    medfit: '',
                    search_text: '',
                    pathway_id: '',
                    service_id: '',
                    authority_id: '',
                    sort_by: '',
                    date: ''
                };

                FetchDischargeHtml(params)
                    .done(function(response) {

                        var htmlFromServer = (typeof response === 'object' && response.html) ?
                            response.html :
                            response;

                        if ($.trim(htmlFromServer)) {
                            PrintHtmlDischargeTracker(htmlFromServer, 'Complex Discharges');
                        } else {
                            toastr.info('No printable content found.');
                        }
                    })
                    .fail(function() {
                        toastr.warning('Something Went Wrong');
                    });
            }
        });
    </script>
    <script>
        $(document).on("change", "#ward_id,#medfit_value,#pathway_id,#service_id,#authority_id", function(e) {
            var ward_id = $('#ward_id').val();
            var medfit = $('#medfit_value').val();
            var search_text = $('#search_text').val();
            var pathway_id = $('#pathway_id').val();
            var service_id = $('#service_id').val();
            var authority_id = $('#authority_id').val();


            DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);
        });


        $('.form-control').keypress(function(e) {
            if (e.which == 13) {
                var ward_id = $('#ward_id').val();
                var medfit = $('#medfit_value').val();
                var search_text = $('#search_text').val();
                var pathway_id = $('#pathway_id').val();
                var service_id = $('#service_id').val();
                var authority_id = $('#authority_id').val();


                DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);
            }
        });


        $(document).on("click", "#submit_search_text", function(e) {
            var ward_id = $('#ward_id').val();
            var medfit = $('#medfit_value').val();
            var search_text = $('#search_text').val();
            var pathway_id = $('#pathway_id').val();
            var service_id = $('#service_id').val();
            var authority_id = $('#authority_id').val();


            DataPageLoad(ward_id, medfit, search_text, pathway_id, service_id, authority_id);
        });


        $(document).on("change", "#care_requirements_pdna_sent", function(e) {
            if ($("#care_requirements_pdna_sent").is(":checked")) {
                var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
                $(".care_requirements_pdna_sent_date").html(currentTime);
            } else {
                $(".care_requirements_pdna_sent_date").html("");
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







        $(document).on("change", "#care_requirements_pdna_nurse,#care_requirements_pdna_nurse", function(e) {
            if ($('#care_requirements_pdna_nurse').is(':checked') || $('#care_requirements_pdna_nurse').is(
                    ':checked')) {
                $('#care_requirements_pdna_not_required').attr('checked', false);
            }
        });

        $(document).on("change", "#care_requirements_pdna_not_required", function(e) {
            if (this.checked) {
                $('#care_requirements_pdna_nurse').prop('checked', false);
                $('#care_requirements_pdna_idt').prop('checked', false);
                $('#care_requirements_pdna_nurse').prop('checked', false);
                $('#care_requirements_pdna_idt').prop('checked', false);

                $("#care_requirements_pdna_nurse").prop("disabled", true);
                $("#care_requirements_pdna_idt").prop("disabled", true);
                $('#care_requirements_pdna_nurse').attr('checked', false);
                $('#care_requirements_pdna_idt').attr('checked', false);
            } else {
                $("#care_requirements_pdna_nurse").prop("disabled", false);
                $("#care_requirements_pdna_idt").prop("disabled", false);
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

        function ComplexDischargeDataPageLoad(date, time, search_text, ward_id_cdt) {
            @if (CheckSpecificPermission('discharge_tracker_complex_discharge_view'))
                var token = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.discharges.from.cdt') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "complex_date": date,
                            "complex_time": time,
                            "ward_id_cdt": ward_id_cdt,
                            "complex_search_text": search_text
                        },
                        success: function(response) {
                            if (response != "") {
                                $('.today_discharges_value_class').html($('#today_discharges_value')
                                    .val());

                                $('#contentSection_data').html(response);
                                MultiSelectJs('ward_id_cdt', 'Ward');
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err) {
                            $('.page-data-loader').hide();
                        }
                    });
                }, 2000)
            @else
                PermissionDeniedAlert();
            @endif
        }



        $('.discharges_custom_search').keypress(function(e) {
            if (e.which == 13) {
                var date = $('#complex_date').val();
                var time = $('#complex_time').val();
                var time = $('#complex_time').val();
                var ward_id_cdt = $('#ward_id_cdt').val();
                var search_text = $('#complex_search_text').val();
                if (search_text != '') {
                    ComplexDischargeDataPageLoad(date, time, search_text, ward_id_cdt);
                }
            }
        });
        $(document).on("click", "#complex_submit_search_text", function(e) {
            var date = $('#complex_date').val();
            var time = $('#complex_time').val();
            var search_text = $('#complex_search_text').val();
            var ward_id_cdt = $('#ward_id_cdt').val();
            ComplexDischargeDataPageLoad(date, time, search_text, ward_id_cdt);
        });

        $(document).on("change", "#complex_date,#complex_time,#ward_id_cdt", function(e) {
            var date = $('#complex_date').val();
            var time = $('#complex_time').val();
            var search_text = $('#complex_search_text').val();
            var ward_id_cdt = $('#ward_id_cdt').val();
            ComplexDischargeDataPageLoad(date, time, search_text, ward_id_cdt);
        });

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
            a.download = "discharges_from_cdt_patients.csv";
            a.style.display = "none";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });


        $(document).on("click", ".click_discharges_from_cdt", function(event) {

            @if (CheckSpecificPermission('discharge_tracker_complex_discharge_view'))
                $('.page-data-loader').show();
                var token = "{{ csrf_token() }}";
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.discharges.from.cdt') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "complex_date": '',
                            "complex_time": '',
                            "complex_search_text": '',
                            "ward_id_cdt": ''
                        },
                        success: function(response) {
                            if (response != "") {

                                $('#contentSection_data').html(response);
                                MultiSelectJs('ward_id_cdt', 'Ward');
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err) {
                            $('.page-data-loader').hide();
                        }
                    });
                }, 2000)
            @else
                PermissionDeniedAlert();
            @endif
        });

        $(document).on("click", ".click_discharges_from_ed_referral", function(event) {

            @if (CheckSpecificPermission('discharge_tracker_complex_discharge_view'))
                EDReferralDataLoad();
            @else
                PermissionDeniedAlert();
            @endif
        });

        function EDReferralDataLoad() {
            $('.page-data-loader').show();
            var token = "{{ csrf_token() }}";
            var search_query = $('#referral_page_search_query').length ? $('#referral_page_search_query').val() : null;

            setTimeout(function() {
                $.ajax({
                    _token: token,
                    url: "{{ route('discharged.ed_referral') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "search_query": search_query
                    },
                    success: function(response) {
                        if (response != "") {

                            $('#contentSection_data').html(response);
                            $('.SelectBoxWrap select').selectric('refresh');
                            $('.page-data-loader').hide();
                        }
                    },
                    error: function(status, err) {
                        $('.page-data-loader').hide();
                    }
                });
            }, 2000);

        }

        $(document).on("click", ".click_open_ed_referral_page_offcanvas", function(event) {
            var patient_search_offcanvas = new bootstrap.Offcanvas(document.getElementById(
                'ed_referral_patient_search_modal'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            patient_search_offcanvas.show();
            CommonDisableEnableOnOpen();

            $('.ed_referral_patient_search').html('');
            var token = "{{ csrf_token() }}";
            var url = "{{ route('discharged.search.ed.patient') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token
                },
                success: function(result) {
                    $('#search_ed_referral_patient_field').val('');
                    $('.ed_referral_patient_search').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        });
        $(document).on("click", ".search_ed_referral_patient", function(event) {
            EnableLoaderAndMakeHiddenInnerBody();
            CommonDisableEnableOnOpen();
            var search_field = $('#search_ed_referral_patient_field').val();
            $('.ed_referral_patient_search').html('');
            var token = "{{ csrf_token() }}";
            var url = "{{ route('discharged.search.ed.patient') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'search_query': search_field
                },
                success: function(result) {
                    $('.ed_referral_patient_search').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        });
        $(document).on("click", ".click_search_referral_list", function(event) {
            var search_query = $('#referral_page_search_query').val();
            var token = "{{ csrf_token() }}";
            if (search_query == '') {
                toastr.warning('Please Type Something');
                return;
            }
            $('.page-data-loader').show();
            if (search_query != '') {

                $.ajax({
                    url: '{{ route('discharged.ed_referral.listsearch') }}',
                    type: 'POST',
                    data: {
                        '_token': token,
                        'search_query': search_query
                    },
                    success: function(result) {
                        $('#ed_referral_patient_list').html(result);
                        $('.page-data-loader').hide();
                    },
                    error: function(textStatus, errorThrown) {
                        $('.page-data-loader').hide();
                    }
                });
            } else {

                toastr.warning('{{ ErrorOccuredMessage() }}');
                $('.page-data-loader').hide();
            }


        });
        $(document).on("click", ".click_add_ed_referral", function(event) {
            $(this).toggleClass('active');
            var active_buttons = $('.click_add_ed_referral.active');

            var active_count = active_buttons.length;
            if (active_count > 0) {
                EnableSaveButtonForModals();
            } else {
                DisableSaveButtonForModals();
            }
        });
        $(document).on("click", ".click_add_patient_ed_referral", function(event) {
            DisableButtonClickForPreventFurtherEvent('click_add_patient_ed_referral');
            var active_buttons = $('.click_add_ed_referral.active');

            var active_count = active_buttons.length;
            if (active_count < 1) {
                toastr.warning('Select A Patient For The Actions');
            }
            var patient_ids = active_buttons.map(function() {
                return $(this).data('patient-id');
            }).get();

            CommonDisableEnableOnSave();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('discharged.save.ed.patient') }}',
                type: 'POST',
                data: {
                    '_token': token,
                    'patient_ids': patient_ids
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('#ed_referral_patient_list').html(result.html);
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CloseOffcanvas('ed_referral_patient_search_modal');
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


        });
        $(document).on("click", ".click_remove_ed_referral_patient", function(event) {
            DisableSaveButtonLoadImageForModals();
            EnableSaveButtonForModals();
            var patient_remove_offcanvas = new bootstrap.Offcanvas(document.getElementById('remove_ed_patients'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            patient_remove_offcanvas.show();
            $('#cdt_remove_patient_id').val($(this).data('patient-id'));
        });
        $(document).on("click", ".click_remove_patient_ed_referral", function(event) {
            DisableButtonClickForPreventFurtherEvent('click_remove_patient_ed_referral');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var token = "{{ csrf_token() }}";
            var patient_id = $('#cdt_remove_patient_id').val();

            if (patient_id != '') {

                $.ajax({
                    url: '{{ route('discharged.remove.ed.patient') }}',
                    type: 'POST',
                    data: {
                        '_token': token,
                        'patient_id': patient_id
                    },
                    success: function(result) {
                        $('.ed_referral_patient_id_' + patient_id).remove();
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CloseOffcanvas('remove_ed_patients');
                        toastr.success(result.message);
                        $('#cdt_remove_patient_id').val('');
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        CloseOffcanvas('remove_ed_patients');
                        $('#cdt_remove_patient_id').val('');
                    }
                });
            } else {
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModals();
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
                CloseOffcanvas('remove_ed_patients');
                $('#cdt_remove_patient_id').val('');
            }

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
    @include('Common.Scripts.CommonDichargeSumamryScript')
@endsection
