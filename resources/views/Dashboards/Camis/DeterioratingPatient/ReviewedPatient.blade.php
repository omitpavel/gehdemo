@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Deteriorating Patients Reviewed')
@section('page-top-title', 'Deteriorating Patients Reviewed')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ManageTask.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DeterioratingNewPatients.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/DeterioratingPatientsCustom.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous" />
@endpush

@section('modal')
    @include('Dashboards.Camis.DeterioratingPatient.Modals')
    @include('Common.Modals.BoardRoundInfoModal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Camis.WardSummary.BoardRoundModals.AssignTask')
@endsection
@section('content')
    <div class="container-fluid refresh-content">

    </div>
@endsection
@section('footer')
    @parent

    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    @include('Dashboards.Camis.DischargeTracker.ViewAllcommentScript')
    <script>
        var ajax_refresh_url = "{{ route('reviewed.patient.dataload') }}";
        function CommonJsFunctionCallAfterContentRefersh(){
            MultiSelectJs('ward_id', 'Ward');
        }
        function DataPageLoad(ward_id, sort_by){
            @if(CheckSpecificPermission('dp_dashboard_reviewed_patients_view'))
                var token               = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('reviewed.patient.dataload') }}",
                        type: 'GET',
                        data: { "_token": token, "ward_id": ward_id, "sort_by": sort_by},
                        success: function (response)
                        {
                            if(response != ""){

                                $('.refresh-content').html(response);
                                MultiSelectJs('ward_id', 'Ward');
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err){
                            toastr.warning('Something Went Wrong');
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
            var ward_id         = $('#ward_id').val();
            var sort_by          = $('#sort_by').val();
            DataPageLoad(ward_id, sort_by);
        });
        $(document).on("change", "#ward_id, #sort_by", function(e) {
            var ward_id         = $('#ward_id').val();
            var sort_by          = $('#sort_by').val();
            DataPageLoad(ward_id, sort_by);
        });

        $(document).on("click", ".discharge_to_ward", function(e) {
            @if(CheckSpecificPermission('dp_dashboard_patient_discharge_action_update'))
                var token = "{{ csrf_token() }}";
                var camis_patient_id = $(this).data('patient-id');
                DisableButtonClickForPreventFurtherEvent("discharge_ward_" + camis_patient_id);
                if (camis_patient_id != '') {
                    var url = "{{ route('dp.action.discharge_to_ward') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            "camis_patient_id": camis_patient_id
                        },
                        success: function(result) {
                            if(result.status == 1){
                                toastr.success(result.message);
                                $('#remove_row_'+camis_patient_id).remove();
                                $('#new_count').html(result.new_patients);
                                $('#sd_count').html(result.step_down_count);
                                $('#group_count').html(result.total_patients);
                                $('#seen_count').html(result.seen_patients);
                                $('#discharged_to_count').html(result.discharge_dp);
                                $('#not_for_dp_count').html(result.not_for_dp);
                                $('#this_month_count').html(result.this_month);
                                var count_content = $('#count_content');

                                if (count_content.text().trim().length === 0) {
                                    count_content.append('<div class="custom_not_found">{{ NotFoundMessage() }}</div>');
                                }
                            } else {
                                toastr.warning(result.message);
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


        $(document).on("click", ".action_reviewed_patient", function(e) {
            @if(CheckSpecificPermission('dp_dashboard_patient_review_action_update'))
                var token = "{{ csrf_token() }}";
                var camis_patient_id = $(this).data('patient-id');
                DisableButtonClickForPreventFurtherEvent("action_reviewed_" + camis_patient_id);
                if (camis_patient_id != '') {
                    var url = "{{ route('dp.action.reviewedpatient') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            "camis_patient_id": camis_patient_id
                        },
                        success: function(result) {
                            if(result.status == 1){
                                toastr.success(result.message);
                                $('#remove_row_'+camis_patient_id).remove();
                                $('#new_count').html(result.new_patients);
                                $('#sd_count').html(result.step_down_count);
                                $('#group_count').html(result.total_patients);
                                $('#seen_count').html(result.seen_patients);
                                $('#discharged_to_count').html(result.discharge_dp);
                                $('#not_for_dp_count').html(result.not_for_dp);
                                $('#this_month_count').html(result.this_month);
                                var count_content = $('#count_content');

                                if (count_content.text().trim().length === 0) {
                                    count_content.append('<div class="custom_not_found">{{ NotFoundMessage() }}</div>');
                                }
                            } else {
                                toastr.warning(result.message);
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

        $(document).on("click", ".action_remove_patient", function(e) {
            @if(CheckSpecificPermission('dp_dashboard_patient_remove_action_update'))
                var token = "{{ csrf_token() }}";
                var camis_patient_id = $(this).data('patient-id');
                DisableButtonClickForPreventFurtherEvent("action_remove_" + camis_patient_id);
                if (camis_patient_id != '') {
                    var url = "{{ route('dp.action.removedpatient') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            "camis_patient_id": camis_patient_id
                        },
                        success: function(result) {
                            if(result.status == 1){
                                toastr.success(result.message);
                                $('#remove_row_'+camis_patient_id).remove();
                                $('#new_count').html(result.new_patients);
                                $('#sd_count').html(result.step_down_count);
                                $('#group_count').html(result.total_patients);
                                $('#seen_count').html(result.seen_patients);
                                $('#discharged_to_count').html(result.discharge_dp);
                                $('#not_for_dp_count').html(result.not_for_dp);
                                $('#this_month_count').html(result.this_month);
                                var count_content = $('#count_content');

                                if (count_content.text().trim().length === 0) {
                                    count_content.append('<div class="custom_not_found">{{ NotFoundMessage() }}</div>');
                                }
                            } else {
                                toastr.warning(result.message);
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
    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Dashboards.Camis.DeterioratingPatient.DpCommentScript')
    <script src="{{ asset('asset_v2/Generic/clockpicker/clockpicker.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

    @include('Dashboards.Camis.DeterioratingPatient.DPTaskScript')
@endsection
