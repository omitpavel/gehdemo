@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Red Reason Dashboard')
@section('page-top-title', 'Red Reason Dashboard')
@section('page-top-title-sub', 'autotimer')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/RedToGreen.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/RedToGreenPerformance.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/RedBedDashboard.css') }}" />

    <script src="{{ asset('asset_v2/Ibox/Js/apexcharts_redbed.js') }}"></script>
@endpush
@section('modal')
    @include('Dashboards.Camis.WardSummary.BoardRoundModals.AssignTask')
    @include('Common.Modals.BoardRoundInfoModal')
    @include('Common.Modals.CommonComments')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <input type="hidden" id="ward_summary_boardround_modal_popup_camis_patient_id" value="">
    <input type="hidden" id="permission" value="flow_dashboard_red_bed_task_management_view">
    <div class="container-fluid refresh-content">
    </div>
@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";

        var ajax_refresh_url = "";
    </script>


    <script>
        function ReasonListLoad() {
            @if(CheckSpecificPermission('flow_dashboard_red_bed_view'))
                var ward_id = $('#ward_id').val();
                var reason_id = $('#reason_id').val();

                $('.page-data-loader').show();
                $.ajax({
                    _token: tok,
                    url: "{{ route('red.bed.reasonlist') }}",
                    type: 'POST',
                    data: {
                        "ward_id": ward_id,
                        "reason_id": reason_id,
                        _token: tok
                    },
                    success: function(result) {
                        $('#reason_id').selectric('refresh');
                        $('.refresh-content').html(result);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.page-data-loader').hide();
                        console.log = function () {};
                        console.clear();
                    }
                });
            @else
                PermissionDeniedAlert();
            @endif
        }
        function MultiSelectJsCustom(elementId, label) {
            $('#' + elementId).multiselect({
                columns: 1,
                placeholder: '' + label,
                search: true,
                searchOptions: {
                    'default': 'Search'
                },
                selectAll: true,
                onOptionClick: function(element, option) {
                    updatePlaceholderCustom(elementId, label);
                },
                onControlClose: function(element) {
                    updatePlaceholderCustom(elementId, label);
                }
            });

            updateGroupCheckboxStatesCustom(elementId);
            updatePlaceholderCustom(elementId, label);
            setTimeout(() => {
                const wrapper = $('#' + elementId).next('.ms-options-wrap');

                wrapper.find('.optgroup-all').off('change').on('change', function () {
                    const $group = $(this).closest('.optgroup');
                    const isChecked = $(this).is(':checked');
                    const $childCheckboxes = $group.find('ul li input[type="checkbox"]').not('.optgroup-all');
                    const $select = $('#' + elementId);

                    $childCheckboxes.prop('checked', isChecked).trigger('change');

                    $childCheckboxes.each(function () {
                        const val = $(this).val();
                        $select.find(`option[value="${val}"]`).prop('selected', isChecked);
                    });

                    $select.multiselect('reload');

                    $select.trigger('change');

                    updateGroupCheckboxStatesCustom(elementId);
                    updatePlaceholderCustom(elementId, label);
                });
            }, 200);

        }
        function updateGroupCheckboxStatesCustom(elementId) {
            $('#' + elementId).next('.ms-options-wrap').find('.optgroup').each(function () {
                const $group = $(this);
                const $options = $group.find('ul li input[type="checkbox"]').not('.optgroup-all');
                const $groupCheckbox = $group.find('.optgroup-all');

                if ($options.length === 0) return;

                const allChecked = $options.length === $options.filter(':checked').length;

                $groupCheckbox.prop('checked', allChecked);
            });
        }

        function updatePlaceholderCustom(elementId, label) {
            let selectedCount = $('#' + elementId + ' option:selected').length;
            let placeholderText = '';

            if (selectedCount === 0) {
                placeholderText = 'Select ' + label;
            } else if (selectedCount === 1) {
                placeholderText = '1 ' + label + ' Selected';
            } else {
                placeholderText = selectedCount + ' ' + label + 's Selected';
            }

            $('#' + elementId).next('.ms-options-wrap').find('button').html('<span>' + placeholderText + '</span>');
        }

        function PerformanceTabReset(){
            @if(CheckSpecificPermission('flow_dashboard_redbed_performance_view'))
            var ward_id = '';
            var reason_id = '';

            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: "{{ route('red.bed.performance') }}",
                type: 'POST',
                data: {
                    "ward_id": ward_id,
                    "reason_id": reason_id,
                    _token: tok
                },
                success: function(result) {
                    $('#reason_id').selectric('refresh');
                    $('.refresh-content').html(result);
                    $('.page-data-loader').hide();
                    MultiSelectJsCustom('ward_id_performance', 'Ward');
                    MultiSelectJsCustom('reason_id_performance', 'Reason');
                    DisableLoaderAndMakeVisibleInnerBody();
                    console.log = function () {};
                    console.clear();
                }
            });
            @else
                PermissionDeniedAlert();
            @endif
        }

        function PerformanceTabLoad(){
            @if(CheckSpecificPermission('flow_dashboard_redbed_performance_view'))
            var ward_id = $('#ward_id_performance').val();
            var reason_id = $('#reason_id_performance').val();

            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: "{{ route('red.bed.performance') }}",
                type: 'POST',
                data: {
                    "ward_id": ward_id,
                    "reason_id": reason_id,
                    _token: tok
                },
                success: function(result) {
                    $('#reason_id').selectric('refresh');
                    $('.refresh-content').html(result);
                    $('.page-data-loader').hide();
                    MultiSelectJsCustom('ward_id_performance', 'Ward');
                    MultiSelectJsCustom('reason_id_performance', 'Reason');
                    DisableLoaderAndMakeVisibleInnerBody();
                    console.log = function () {};
                    console.clear();
                }
            });
            @else
                PermissionDeniedAlert();
            @endif
        }
        $(document).ready(function() {
            var ward_id = $('#ward_id').val();
            var reason_id = $('#reason_id').val();
            @if(CheckSpecificPermission('flow_dashboard_red_bed_view'))
                ReasonListLoad();
            @elseif(CheckSpecificPermission('flow_dashboard_redbed_performance_view'))
                PerformanceTabReset()
            @else
                PermissionDeniedAlert();
            @endif
        });
    </script>

    <script>
        $(document).on("change", "#reason_id", function(e) {
            var ward_id = $('#ward_id').val();
            var reason_id = $('#reason_id').val();
            ReasonListLoad();
        });



        $(document).on("change", "#ward_id", function(e) {
            var ward_id = $('#ward_id').val();
            var reason_id = $('#reason_id').val();
            ReasonListLoad();
        });

        @if(CheckSpecificPermission('flow_dashboard_red_bed_approve_update'))
            $(document).on("click", ".approve_red_task", function(e) {
                var patient_id =  $(this).data('patient-id');
                var reason_id =  $(this).data('reason-id');
                var ward_id =  $(this).data('ward-id');
                if(patient_id != '' && reason_id != ''){
                    $.ajax({
                        _token: tok,
                        url: "{{ route('red.bed.updatereason') }}",
                        type: 'POST',
                        data: {
                            "patient_id": patient_id,
                            "reason_id": reason_id,
                            "ward_id": ward_id,
                            _token: tok
                        },
                        success: function(result) {
                            if (typeof result.message !== 'undefined') {
                                if(result.pending_task == 0){
                                    $('.remove_patient_id_' + patient_id).remove();
                                    toastr.success('Patient Marked As Green Bed');
                                    var count_content = $('.other-dashboard-contents');
                                    var pending_patient_count = $('.patient_list_' + ward_id);

                                    if (pending_patient_count.text().trim().length === 0) {
                                        $('.ward_id_' + ward_id).remove();
                                    }


                                    if (count_content.text().trim().length === 0) {
                                        count_content.html('<div class="custom_not_found">{{ NotFoundMessage() }}</div>');
                                    }
                                    var patients_count_element = $('.bg-patients-count h5');
                                    var current_count = parseInt(patients_count_element.text());
                                    var new_count = current_count - 1;
                                    patients_count_element.text(new_count);
                                    $('.tooltip').remove();
                                } else {
                                    $('.red_bed_tooltip').tooltip('dispose');
                                    $('#updated_reason_list_' + patient_id).html(result.html);
                                    toastr.success('Red Reason Status Updated');
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
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        @endif


            $(document).on('click', '#red_patient_export_filter', function(e) {

                let csv = [];
                $('.responsiveTable tr').each(function () {
                    let row = [];
                    $(this).find('th, td').each(function () {

                        let cellContent = $(this).clone()
                            .children('.tdBefore')
                            .remove()
                            .end()
                            .text()
                            .trim();
                        row.push(cellContent);
                    });
                    csv.push(row.join(","));
                });

                let csvContent = csv.join("\n");
                let blob = new Blob([csvContent], { type: 'text/csv' });
                let url = URL.createObjectURL(blob);

                let a = document.createElement('a');
                a.href = url;
                a.download = 'red_bed_patient.csv';
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });


    </script>




    <script src="{{ asset('asset_v2') }}/Ibox/Js/custom.js"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Common.Scripts.Task')

@endsection
