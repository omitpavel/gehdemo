@extends('Layouts.Common.MasterLayout')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/clockpicker.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardFrailtyAssesment.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PotentialDischargeList.css') }}" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/Sdec.css') }}" crossorigin="anonymous" />

@endpush
@section('page-title', 'Ward Summary')
@section('page-top-title')
{{ stripos($title = $success_array['ward_details']['ward_page_title'] ?? '', 'sdec') !== false ? 'SDEC' : ucwords($title) }} @if(isset($success_array['ward_details']['primary_ward_type']['ward_type']) && !empty($success_array['ward_details']['primary_ward_type']['ward_type'])) ({{ ucfirst($success_array['ward_details']['primary_ward_type']['ward_type']) }}) @endif
@endsection
@section('boardround-menus')



    <li class="nav-item  me-2 timer_countdown d-none" id="timer_container">
        <button class="btn btn-add-attendance " id="countdown">00:00:00 </button>
    </li>

    <li class="nav-item  me-2 add_attendance d-none {{ PermissionDeniedDiv('camis_boardround_start_update') }}"  >
        <button class="btn btn-add-attendance addAttBtn {{ DisabledButtonOnRolePermission('camis_boardround_start_update') }}">Add Attendance </button>
    </li>

    <li class="nav-item me-2 bg-values ane_opel_div d-none">
        <div class="ane_opel_class">A&E OPEL</div>
    </li>



    <li class="nav-item me-2 bg-values d-none ">
        <div class="in_ed_now bg-opel-1">IN ED NOW <span class="ms-3 in_ed_now_count"></span></div>
    </li>
    <li class="nav-item me-2 bg-values d-none ">
        <div class="in_ed_now_with_dta bg-opel-1">WITH DTA <span class="ms-3 in_dta_count"></span></div>
    </li>


    <li class="nav-item me-2 bg-values ward_opel_div d-none">
        <div class="ward_opel_class">WARD OPEL </div>
    </li>

    @if(in_array($success_array['ward_details']['ward_infection_close_status'], [1, 2,3,4,5]))
        <li class="nav-item me-2 bg-values">
            <div class="{{ key(GetWardInfectionBadge($success_array['ward_details']['ward_infection_close_status'])) }}">{{ current(GetWardInfectionBadge($success_array['ward_details']['ward_infection_close_status'])) }}</div>
        </li>
    @endif
@endsection
@section('top-menus')


    <li class="nav-item shape-btn me-2 {{ PermissionDeniedDiv('camis_ward_view_name_show_hide_view') }}"  @if (CheckSpecificPermission('camis_ward_view_name_show_hide_view')) id="patient_name_show" @endif>
        <a class="{{ DisabledButtonOnRolePermission('camis_ward_view_name_show_hide_view') }} text-center" href="#" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" id="eye-svgrepo-com_1_" data-name="eye-svgrepo-com (1)" width="18"
                height="13.502" viewBox="0 0 22.319 13.502">
                <g id="Group_208" data-name="Group 208" transform="translate(0 0)">
                    <g id="Group_207" data-name="Group 207" transform="translate(0 0)">
                        <path id="Path_145" data-name="Path 145"
                            d="M22.168,103.978a.786.786,0,0,0-.023-.957c-3.376-4.15-7.02-6.255-10.838-6.255-6.473,0-10.97,6.031-11.156,6.287a.786.786,0,0,0,.023.957c3.371,4.155,7.015,6.259,10.833,6.259C17.48,110.269,21.976,104.238,22.168,103.978Zm-11.161,4.729c-3.18,0-6.277-1.749-9.22-5.193,1.153-1.362,4.815-5.184,9.521-5.184,3.18,0,6.277,1.749,9.22,5.193C19.375,104.885,15.712,108.707,11.007,108.707Z"
                            transform="translate(0 -96.767)"></path>
                        <path id="Path_146" data-name="Path 146"
                            d="M161.785,157.867a3.968,3.968,0,1,0,3.968,3.968A3.974,3.974,0,0,0,161.785,157.867Zm0,6.373a2.405,2.405,0,1,1,2.405-2.405A2.409,2.409,0,0,1,161.785,164.24Z"
                            transform="translate(-150.628 -155.084)"></path>
                    </g>
                </g>
            </svg>
        </a>
    </li>
    <li class="nav-item shape-btn me-2 content_display_none {{ PermissionDeniedDiv('camis_ward_view_name_show_hide_view') }}"  @if (CheckSpecificPermission('camis_ward_view_name_show_hide_view')) id="patient_name_hide" @endif>
        <a class="{{ DisabledButtonOnRolePermission('camis_ward_view_name_show_hide_view') }} text-center" href="#" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" id="eye-svgrepo-com_1_" data-name="eye-svgrepo-com (1)" width="18"
                height="13.502" viewBox="0 0 22.319 13.502">
                <g id="Group_208" data-name="Group 208" transform="translate(0 0)">
                    <g id="Group_207" data-name="Group 207" transform="translate(0 0)">
                        <path id="Path_145" data-name="Path 145"
                            d="M22.168,103.978a.786.786,0,0,0-.023-.957c-3.376-4.15-7.02-6.255-10.838-6.255-6.473,0-10.97,6.031-11.156,6.287a.786.786,0,0,0,.023.957c3.371,4.155,7.015,6.259,10.833,6.259C17.48,110.269,21.976,104.238,22.168,103.978Zm-11.161,4.729c-3.18,0-6.277-1.749-9.22-5.193,1.153-1.362,4.815-5.184,9.521-5.184,3.18,0,6.277,1.749,9.22,5.193C19.375,104.885,15.712,108.707,11.007,108.707Z"
                            transform="translate(0 -96.767)"></path>
                        <path id="Path_146" data-name="Path 146"
                            d="M161.785,157.867a3.968,3.968,0,1,0,3.968,3.968A3.974,3.974,0,0,0,161.785,157.867Zm0,6.373a2.405,2.405,0,1,1,2.405-2.405A2.409,2.409,0,0,1,161.785,164.24Z"
                            transform="translate(-150.628 -155.084)"></path>
                    </g>
                </g>
            </svg>
        </a>
    </li>


    <li class="nav-item shape-btn me-2 ">
        <a class="text-center" data-bs-toggle="offcanvas" data-bs-target="#camisHelp" aria-controls="offcanvasRight"
            role="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" viewBox="0 0 24 24" fill="none">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 19.5C16.1421 19.5 19.5 16.1421 19.5 12C19.5 7.85786 16.1421 4.5 12 4.5C7.85786 4.5 4.5 7.85786 4.5 12C4.5 16.1421 7.85786 19.5 12 19.5ZM12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM12.75 15V16.5H11.25V15H12.75ZM10.5 10.4318C10.5 9.66263 11.1497 9 12 9C12.8503 9 13.5 9.66263 13.5 10.4318C13.5 10.739 13.3151 11.1031 12.9076 11.5159C12.5126 11.9161 12.0104 12.2593 11.5928 12.5292L11.25 12.7509V14.25H12.75V13.5623C13.1312 13.303 13.5828 12.9671 13.9752 12.5696C14.4818 12.0564 15 11.3296 15 10.4318C15 8.79103 13.6349 7.5 12 7.5C10.3651 7.5 9 8.79103 9 10.4318H10.5Z" fill="#000000"/> </g>

            </svg>
        </a>
    </li>

@endsection
@section('header')
    @parent
    <link rel="stylesheet" href="{{ url('asset_v2/Ibox/Css/HandoverCustomStyle.css') }}" />
    <script src="{{ asset('asset_v2/Generic/clockpicker/clockpicker.js') }}"></script>

@endsection
@section('modal')

    @include('Dashboards.Camis.WardSummary.WardSummaryModals.WardPriorityTask')
    @include('Dashboards.Camis.WardSummary.Modals.AllowedToMovePatientIn')
    @include('Dashboards.Camis.WardSummary.Modals.AllowedToMovePatientOut')
    @include('Dashboards.Camis.WardSummary.WardSummaryModals.HandOverDetailsModal')
    @include('Dashboards.Camis.WardSummary.WardSummaryModals.HandOverDetailsPrintPop')
    @include('Dashboards.Camis.WardSummary.Modals.DefiniteToday')
    @include('Dashboards.Camis.WardSummary.Modals.PotentialToday')
    @include('Dashboards.Camis.WardSummary.Modals.BoardRound')
    @include('Dashboards.Camis.WardSummary.Modals.Attendance')
    @include('Dashboards.Camis.WardSummary.Modals.Help')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Camis.WardSummary.Modals.DoctorNurseTask')
    @include('Dashboards.Camis.WardSummary.Modals.FinishedBoardRoundOffcanvas')
    @include('Dashboards.Camis.WardSummary.Modals.PatientsToSDEC')
    @include('Dashboards.Camis.WardSummary.Modals.AnePatientListOffcanvas')
    @include('Dashboards.Camis.WardSummary.Modals.SDECPatientMovementHistory')
@endsection
@section('content')
    <input type="hidden" name="boardround_patient_allowed_to_be_moved_from" id="boardround_patient_allowed_to_be_moved_from" value="{{ $success_array['ward_details']['ward_short_name'] }}" />
    <input type="hidden" value="" id="patient_id_board_round_all_selected_consultant_rand">
    <input type="hidden" value="" id="consultant_board_round_all_selected_consultant_rand">
    <input type="hidden" value="" id="board_round_all_selected_consultant_rand_type">
    <input type="hidden" value="" id="board_round_selected_config">
    <input type="hidden" value="" id="board_round_selected_config_current">
    <div class="container-fluid refresh-content">

    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Generic/Js/Sortable.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/jquery.ui.touch-punch.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";
        var ajax_refresh_url =
        "{{ route('ward.frailty.dataload') }}";

        $(document).ready(function() {
            $('.page-data-loader').hide();
            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: '{{ route('ward.frailty.dataload') }}',
                type: 'GET',
                data: {
                    "_token": tok
                },
                success: function(result) {
                    GetWardStatus();
                    EnableToolTipForAjax();
                    $('.refresh-content').html(result.html);
                    $('.last_board_round_class_name').html(result.ward_last_boardround);
                    if(result.ane_opel_status != 0){
                        if($('.ane_opel_div').hasClass('d-none')){
                            $('.ane_opel_div').removeClass('d-none');
                            $('.ane_opel_class').html(result.ane_opel_text);
                            $('.ane_opel_class').addClass(result.ane_opel_class);
                        }
                    } else {
                        if(!$('.ane_opel_div').hasClass('d-none')){
                            $('.ane_opel_div').addClass('d-none');
                        }
                    }
                    if(result.ward_opel_status != 0){
                        if($('.ward_opel_div ').hasClass('d-none')){
                            $('.ward_opel_div ').removeClass('d-none');
                            $('.ward_opel_class').html(result.ward_opel_text);
                            $('.ward_opel_class').addClass(result.ward_opel_class);
                        }
                    } else {
                        if(!$('.ward_opel_div ').hasClass('d-none')){
                            $('.ward_opel_div ').addClass('d-none');
                        }
                    }
                    $('.elective_web').html(result.elective_count);
                    $('.non_elective_web').html(result.non_elective_count);
                    $('.elective_mobile').html(result.elective_count);
                    $('.non_elective_mobile').html(result.non_elective_count);
                    let board_round_missed = localStorage.getItem('board_round_missed');
                    if (board_round_missed) {
                        localStorage.removeItem('board_round_missed');
                    }
                    $('.in_ed_now_count').html(result.in_ed_now);
                    $('.in_dta_count').html(result.total_dta_patients);
                    if(result.ward_opel_status != 1 && result.ane_opel_status != 0){

                        if($('.in_ed_now').hasClass('bg-opel-1')){
                            $('.in_ed_now').removeClass('bg-opel-1');
                            $('.in_ed_now').addClass(result.ane_opel_class);
                        }
                        if($('.in_ed_now_with_dta').hasClass('bg-opel-1')){
                            $('.in_ed_now_with_dta').removeClass('bg-opel-1');
                            $('.in_ed_now_with_dta').addClass(result.ane_opel_class);
                        }
                    } else {
                        if(!$('.in_ed_now').hasClass('bg-opel-1')){
                            $('.in_ed_now').addClass('bg-opel-1');
                        }

                        if(!$('.in_ed_now_with_dta').hasClass('bg-opel-1')){
                            $('.in_ed_now_with_dta').addClass('bg-opel-1');
                        }
                    }




                    $('.page-data-loader').hide();
                },
                error: function(xhr, status, error) {
                }
            });
        });


        $(document).on("click", ".click_open_movement_history", function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_movement_history');

            $('.patient_movement_offcanvas_data').html('');
            var sau_patient_data = new bootstrap.Offcanvas(document.getElementById('frailty_patient_movement_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });


            sau_patient_data.show();
            var camis_patient_id = $(this).attr('data-history-patient-id');
            var camis_patient_name = $(this).attr('data-history-patient-name');
            var url = "{{ route('ward.frailty.movement.history') }}";
            if(camis_patient_id != ''){

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id,
                        "patient_name": camis_patient_name
                    },
                    success: function(result) {

                            if (typeof result !== '') {


                                $('.patient_movement_offcanvas_data').html(result);

                                DisableLoaderAndMakeVisibleInnerBody();

                            } else {
                                CommonErrorModalPopupOpenOnRequest();
                            }

                        },
                    error: function(textStatus, errorThrown) {

                        CloseOffcanvas('frailty_patient_movement_offcanvas');

                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CloseOffcanvas('frailty_patient_movement_offcanvas');
                CommonErrorModalPopupOpenOnRequest();
            }

        });


    </script>
    @include('Dashboards.Camis.WardSummary.WardSummaryJs')

@endsection
