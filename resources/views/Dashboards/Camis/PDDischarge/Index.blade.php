@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Definite/Potential Discharges')
@section('page-top-title', 'Definite/Potential Discharges')
@section('page-top-title-sub', 'autotimer')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/clockpicker.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <script src="{{ asset('asset_v2/Template/js/ApexCharts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PDDischarges.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/FailedDischargesPerformance.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/PDDischarge.css') }}" crossorigin="anonymous" />

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

    @include('Common.Modals.BoardRoundInfoModal')
    @include('Dashboards.Camis.WardSummary.BoardRoundModals.AssignTask')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Camis.PDDischarge.Modal')
@endsection
@section('content')
    <input type="hidden" id="boardround_patient_task_group" value="">
    <input type="hidden" id="task_category" value="2">
    <input type="hidden" id="filtered_task_id" value="">
    <input type="hidden" id="ward_summary_boardround_modal_popup_camis_patient_id" value="">
    <input type="hidden" id="boardround_patient_task_id_update" value="">
    <input type="hidden" id="permission" value="pd_dashboard_task_management_view">
    <div class="contentSection" id="contentSection_data">

    </div>
    </div>
@endsection
@section('footer')

    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";
        var ajax_refresh_url = "";
    </script>
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
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
        @if (CheckSpecificPermission('pd_dashboard_today_dashboard_view'))
            $(document).ready(function() {
                DischargeDay('today');
            });
        @elseif (CheckSpecificPermission('pd_dashboard_tomorrow_dashboard_view'))

            $(document).ready(function() {
                DischargeDay('tomorrow');
            });
        @elseif (CheckSpecificPermission('pd_dashboard_day_after_tomorrow_dashboard_view'))

            $(document).ready(function() {
                DischargeDay('day_after_tomorrow');
            });
        @elseif (CheckSpecificPermission('pd_dashboard_missed_discharged_view'))

            $(document).ready(function() {
                initDatePicker();
                MissedDischarged('1', '0');
            });
        @elseif (CheckSpecificPermission('pd_dashboard_missed_discharges_performance_view'))

            $(document).ready(function() {

                FailedDischargesPerformance('{{ date('Y-m-d', strtotime('-1 day')) }}', '{{ date('Y-m-d', strtotime('-1 day')) }}', 1, 1);
            });
        @endif
    </script>

    <script>
        $(document).on("change", "#ward_id,#task_type,#medfit_type", function(e) {
            var ward_id = $('#ward_id').val();
            var task_type = $('#task_type').val();
            var medfit_type = $('#medfit_type').val();

            if ($('.discharge_type_definite').hasClass('active')) {
                var discharge_type = 'definite';
            } else if ($('.discharge_type_potential').hasClass('active')) {
                var discharge_type = 'potential';
            } else {
                var discharge_type = 'all';
            }

            var discharge_day = $('#discharge_day').val();
            var url = "{{ route('pd.content') }}";
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "ward_id": ward_id,
                    "task_type": task_type,
                    "discharge_type": discharge_type,
                    "discharge_day": discharge_day,
                    "medfit_type": medfit_type
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        MultiSelectJs('ward_id', 'Ward');

                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }


                }
            });
        });



        $(document).on("click", ".discharge_type_definite", function(e) {
            $('.discharge_type_potential').removeClass("active");
            $(this).toggleClass("active");
            var ward_id = $('#ward_id').val();
            var task_type = $('#task_type').val();
            var medfit_type = $('#medfit_type').val();

            if ($('.discharge_type_definite').hasClass('active')) {
                var discharge_type = 'definite';
            } else if ($('.discharge_type_potential').hasClass('active')) {
                var discharge_type = 'potential';
            } else {
                var discharge_type = 'all';
            }

            var discharge_day = $('#discharge_day').val();
            var url = "{{ route('pd.content') }}";
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "ward_id": ward_id,
                    "task_type": task_type,
                    "discharge_type": discharge_type,
                    "discharge_day": discharge_day,
                    "medfit_type": medfit_type
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        MultiSelectJs('ward_id', 'Ward');

                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }


                }
            });
        });


        $(document).on("click", ".discharge_type_potential", function(e) {

            $('.discharge_type_definite').removeClass("active");


            $(this).toggleClass("active");
            var ward_id = $('#ward_id').val();
            var task_type = $('#task_type').val();
            var medfit_type = $('#medfit_type').val();

            if ($('.discharge_type_definite').hasClass('active')) {
                var discharge_type = 'definite';
            } else if ($('.discharge_type_potential').hasClass('active')) {
                var discharge_type = 'potential';
            } else {
                var discharge_type = 'all';
            }

            var discharge_day = $('#discharge_day').val();
            var url = "{{ route('pd.content') }}";
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "ward_id": ward_id,
                    "task_type": task_type,
                    "discharge_type": discharge_type,
                    "discharge_day": discharge_day,
                    "medfit_type": medfit_type
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        MultiSelectJs('ward_id', 'Ward');

                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }


                }
            });
        });
    </script>
    <script>
        function DischargeDay(day) {
            var url = "{{ route('pd.content') }}";
            $('#discharge_day').val(day);
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    discharge_day: day,
                    "medfit_type": 'all'
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        $('#contentSection_data').show();
                        MultiSelectJs('ward_id', 'Ward');

                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                }
            });
        }
        $(document).on("change", "#ward_id_missed, #medfit_type_missed", function(e) {
            var definite_type = $('.discharge_type_definite_button').hasClass('active') ? 1 : 0;
            var potential_type = $('.discharge_type_potential_button').hasClass('active') ? 1 : 0;
            MissedDischarged(definite_type, potential_type);
        });

        $(document).on("click", ".discharge_type_potential_button", function(e) {


            $(this).toggleClass("active");


            var definite_type = $('.discharge_type_definite_button').hasClass('active') ? 1 : 0;
            var potential_type = $('.discharge_type_potential_button').hasClass('active') ? 1 : 0;


            MissedDischarged(definite_type, potential_type);
        });
        $(document).on("click", ".discharge_type_definite_button", function(e) {


            $(this).toggleClass("active");


            var definite_type = $('.discharge_type_definite_button').hasClass('active') ? 1 : 0;
            var potential_type = $('.discharge_type_potential_button').hasClass('active') ? 1 : 0;


            MissedDischarged(definite_type, potential_type);
        });

        function initFailedDateRangePicker(defaultStart, defaultEnd) {
            var $input = $('#failed_date_range_picker');
            if (!$input.length) return;

            var existing = $input.data('daterangepicker');
            if (existing) {
                existing.remove();
                $input.off('.daterangepicker');
            }

            var yesterday = moment().subtract(1, 'day');

            var start = defaultStart ? moment(defaultStart, 'YYYY-MM-DD') :
                tryParseStartFromInput($input.val()) || yesterday.startOf('day');

            var end = defaultEnd ? moment(defaultEnd, 'YYYY-MM-DD') :
                tryParseEndFromInput($input.val()) || yesterday.endOf('day');

            $input.daterangepicker({
                startDate: start,
                endDate: end,
                autoUpdateInput: true,
                maxDate: moment(),
                autoApply: true,
                locale: {
                    format: 'Do MMM YYYY',
                    applyLabel: 'Apply',
                    cancelLabel: 'Clear'
                },
                opens: 'left',
                ranges: {
                    'This Week': [moment().startOf('week'), moment()],
                    'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf(
                        'week')],
                    'This Month': [moment().startOf('month'), moment()],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ],
                    'Last 3 Months': [moment().subtract(3, 'month').startOf('month'), moment()]
                }
            });

            $input.on('apply.daterangepicker', function(ev, picker) {
                $(this).val(
                    picker.startDate.format('Do MMM YYYY') + ' - ' + picker.endDate.format('Do MMM YYYY')
                );
                var definite_status = $('.performance_pd_count_definite').hasClass('active') ? 1 : 0;
                var potential_status = $('.performance_pd_count_potential').hasClass('active') ? 1 : 0;

                FailedDischargesPerformance(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD'), definite_status, potential_status
                );
            });

            $input.on('cancel.daterangepicker', function() {
                $(this).val('');
            });
        }

        function tryParseStartFromInput(val) {
            if (!val || val.indexOf('-') === -1) return null;
            var left = val.split('-')[0].trim();
            var m = moment(left, 'Do MMM YYYY', true);
            return m.isValid() ? m : null;
        }

        function tryParseEndFromInput(val) {
            if (!val || val.indexOf('-') === -1) return null;
            var right = val.split('-').slice(1).join('-').trim();
            var m = moment(right, 'Do MMM YYYY', true);
            return m.isValid() ? m : null;
        }
        $(document).on("click", ".performance_pd_count_definite", function(e) {


            $(this).toggleClass("active");

            var definite_status = $('.performance_pd_count_definite').hasClass('active') ? 1 : 0;
            var potential_status = $('.performance_pd_count_potential').hasClass('active') ? 1 : 0;
            var drp = $('#failed_date_range_picker').data('daterangepicker');
            var start_date = drp.startDate.format('YYYY-MM-DD');
            var end_date = drp.endDate.format('YYYY-MM-DD');
            FailedDischargesPerformance(start_date, end_date, definite_status, potential_status);
        });
        $(document).on("click", ".performance_pd_count_potential", function(e) {


            $(this).toggleClass("active");

            var definite_status = $('.performance_pd_count_definite').hasClass('active') ? 1 : 0;
            var potential_status = $('.performance_pd_count_potential').hasClass('active') ? 1 : 0;
            var drp = $('#failed_date_range_picker').data('daterangepicker');
            var start_date = drp.startDate.format('YYYY-MM-DD');
            var end_date = drp.endDate.format('YYYY-MM-DD');
            FailedDischargesPerformance(start_date, end_date, definite_status, potential_status);
        });

        function FailedDischargesPerformance(start_date, end_date, definite_status = 1, potential_status = 1) {
            var url = "{{ route('pd.missed.performance') }}";
            $('.page-data-loader').show();

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "start_date": start_date,
                    "end_date": end_date,
                    "definite_status": definite_status,
                    "potential_status": potential_status
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        $('#contentSection_data').show();
                        MultiSelectJs('ward_id_missed', 'Ward');
                        initFailedDateRangePicker(start_date, end_date);
                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                }
            });
        }

        function MissedDischarged(definite = 1, potential = 0) {
            var url = "{{ route('pd.missed') }}";
            $('.page-data-loader').show();
            var ward_id_missed = $('#ward_id_missed').val();

            var date = $('#start_date_day_summary_val').val() || '{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}';
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "ward_id_missed": ward_id_missed,
                    "definite": definite,
                    "potential": potential,
                    "date": date
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        $('#contentSection_data').show();
                        MultiSelectJs('ward_id_missed', 'Ward');
                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                }
            });
        }

        $(document).on("click", ".click_add_reason", function(e) {
            var patient_id = $(this).data("patient-id");
            if (patient_id == '') {
                toastr.error("Patient id not found", "Error");
                return false;
            } else {
                $('#review_patient_id').val(patient_id);

                DisableSaveButtonForModals();


                $.ajax({
                    url: '{{ route('pd.missed.ajax') }}',
                    type: 'POST',
                    data: {
                        '_token': tok,
                        'camis_patient_id': patient_id
                    },
                    success: function(result) {
                        var $wrapper = $('.failed-reasons-wrapper');
                        $wrapper.empty();

                        var selectedId = (result.selected_reason === 0 || result.selected_reason) ?
                            String(result.selected_reason) :
                            null;

                        $.each(result.missed_discharge_reasons, function(rawCategory, reasonsObj) {
                            var category = String(rawCategory || '').replace(/\s+/g, ' ')
                                .trim();

                            var $block = $('<div>', {
                                class: 'reason-content-block'
                            });

                            var $header = $('<div>', {
                                    class: 'header-primary'
                                })
                                .append($('<h6>').text(category));
                            $block.append($header);

                            $.each(reasonsObj, function(reasonId, reasonText) {
                                var idStr = String(reasonId);
                                var txt = String(reasonText || '').trim();
                                var isChecked = selectedId !== null && idStr ===
                                    selectedId;

                                var idSafe =
                                    'reason_' +
                                    category.replace(/\s+/g, '_').replace(/[^\w\-]/g,
                                        '') +
                                    '_' + idStr;

                                var $reasonBlock = $('<div>', {
                                    class: 'reasons-list-block'
                                });
                                var $ul = $('<ul>', {
                                    class: 'reason-list'
                                });

                                var $liRadio = $('<li>').append(
                                    $('<input>', {
                                        class: 'form-check-input',
                                        type: 'radio',
                                        name: 'missed_reason',
                                        id: idSafe,
                                        value: idStr,
                                        'data-reason-text': txt,
                                        checked: isChecked
                                    })
                                );

                                var $liText = $('<li>').text(txt);

                                $ul.append($liRadio, $liText);
                                $reasonBlock.append($ul);
                                $block.append($reasonBlock);
                            });

                            $wrapper.append($block);
                        });

                        $(document)
                            .off('change.reasonSync')
                            .on('change.reasonSync',
                                '.form-check-input[type=radio][name=missed_reason]',
                                function() {
                                    var idVal = $(this).val();
                                    var txtVal = $(this).data('reason-text') || '';
                                    $('#review_reason_id').val(idVal);
                                    $('#review_reason').val(txtVal);
                                });

                        if (selectedId !== null) {
                            var $checked = $(
                                '.form-check-input[type=radio][name=missed_reason][value="' +
                                selectedId + '"]');
                            if ($checked.length) {
                                $('#review_reason_id').val(selectedId);
                                $('#review_reason').val($checked.data('reason-text') || '');
                            }
                        } else {
                            $('#review_reason_id').val('');
                            $('#review_reason').val('');
                        }

                        var offcanvas_id = 'addMissedReason';
                        var review_offcanvs = new bootstrap.Offcanvas(document.getElementById(
                            offcanvas_id), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: 'static'
                        });
                        review_offcanvs.show();
                        CommonDisableEnableOnOpen();
                        DisableLoaderAndMakeVisibleInnerBody();
                    },
                    error: function(textStatus, errorThrown) {

                    }
                });



                var offcanvas_id = 'addMissedReason';
                var review_offcanvs = new bootstrap.Offcanvas(document.getElementById(offcanvas_id), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                review_offcanvs.show();
                CommonDisableEnableOnOpen();
                DisableLoaderAndMakeVisibleInnerBody();
                $('#review_reason').focus();
            }

        });
        $(document).on("change", "input[name=missed_reason]", function(e) {


            if ($("input[name=missed_reason]:checked").length > 0) {
                EnableSaveButtonForModals();
            } else {
                DisableSaveButtonForModals();
            }

        });

        $(document).on('click', '.add_review_reason', function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#review_patient_id').val();
            var patient_review_reason = $("input[name=missed_reason]:checked").val();
            CommonDisableEnableOnSave();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url = "{{ route('pd.save.missed.reason') }}";
            $(this).text('Saving...');
            if (camis_patient_id != '') {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': tok,
                        'camis_patient_id': camis_patient_id,
                        'patient_review_reason': patient_review_reason
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            $('.missed_reason_' + camis_patient_id).html(result.patient_review_reason);


                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            $(this).text('Edit Reason');
                            CloseOffcanvas('addMissedReason');
                            toastr.success(result.message);

                        } else {
                            $(this).text('Add Reason');
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOffcanvas('addMissedReason');
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        $(this).text('Add Reason');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        CloseOffcanvas('addMissedReason');
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                $(this).text('Add Reason');
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModals();
                CommonErrorModalPopupOpenOnRequest();
                CloseOffcanvas('addMissedReason');
            }
        });
    </script>

    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Common.Scripts.Task')
@endsection
