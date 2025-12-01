@extends('Layouts.Common.MasterLayout')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/clockpicker.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PathwayHistory.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/Sdec.css') }}" crossorigin="anonymous" />



@endpush
@section('page-title', 'Ward Summary')
@section('page-top-title', 'Board Round')

@section('boardround-menus')



    <li class="nav-item  me-2 timer_countdown d-none" id="timer_container">
        <button class="btn btn-add-attendance " id="countdown">00:00:00 </button>
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

@section('modal')
<div class="offcanvas-overlay" id="overlay">
    @include('Dashboards.Camis.WardSummary.Modal')
    @include('Common.Modals.CommonModals')
</div>
@endsection
@section('content')
    <input type="hidden" value="" id="patient_id_board_round_all_selected_consultant_rand">
    <input type="hidden" value="" id="consultant_board_round_all_selected_consultant_rand">
    <input type="hidden" value="" id="board_round_all_selected_consultant_rand_type">
    <input type="hidden" value="" id="board_round_selected_config">
    <input type="hidden" value="" id="board_round_selected_config_current">
    <div>
        <button class="btn bg-lock mb-2 w-100 modal-locked content_display_none" id="lock_all_image"><img src="{{ asset('asset_v2/Template/icons/lock.svg') }}" alt="" width="20" class="me-3">
            <span class="locked_user_name_to_show">Locked By
            <span class="locked_by_name"></span></span></button>
    </div>
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="ajax-content" ></div>


        </div>
    </div>
    <input type="hidden" id="click_boardround_close_offcanvas" value="0">
    <input type="hidden" id="click_next_patient_offcanvas" value="0">
    <input type="hidden" id="ward_summary_boardround_modal_popup_camis_patient_id">
@endsection


@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";


        $( document ).ready(function()
        {



            var ajax_refresh_url = "{{ route('ward.discharge.lounge.boardround.data', request()->patient_id) }}";
            BoardRoundData('{{ request()->patient_id }}');

        });

        $( document ).ready(function()
        {

            $("#ibox_board_round_content_admitting_reason").on("keyup", function() {
                $('.camis_patient_ward_summary_boardround_save_admitting_reason').removeClass("disabled");
            });
            $("#ibox_board_round_content_past_medical_history").on("keyup", function() {
                $('.camis_patient_ward_summary_boardround_save_past_medical_history').removeClass("disabled");
            });
            $("#ibox_board_round_content_patient_goal").on("keyup", function() {
                $('.camis_patient_ward_summary_boardround_save_patient_goal').removeClass("disabled");
            });
            $("#ibox_board_round_content_social_history").on("keyup", function() {
                $('.camis_patient_ward_summary_boardround_save_social_history').removeClass("disabled");
            });
            $("#ibox_board_round_content_working_diagnosis").on("keyup", function() {
                $('.camis_patient_ward_summary_boardround_save_working_diagnosis').removeClass("disabled");
            });

            $('#pharmacy_latest_comment').on('input', function(){
                $('.camis_patient_ward_summary_boardround_save_pharmacy_info').prop('disabled', false);
            });




        });




        function BoardRoundData(camis_patient_id) {
            @if(CheckSpecificPermission('camis_boardround_view'))
            $('.page-data-loader').hide();
            $('.page-data-loader').show();

            let board_round_missed = localStorage.getItem('board_round_missed');
            if (board_round_missed) {
                var board_round_order = 1;
            } else {
                var board_round_order = 0;
            }

            var current_url = window.location.href;
            var updated_url = current_url.replace(/discharge-lounge-board-round\/\w+/, 'discharge-lounge-board-round/' + camis_patient_id);
            window.history.pushState({}, '', updated_url);


            var token = "{{ csrf_token() }}";
            localStorage.setItem('reason_to_review_pending', camis_patient_id);
            var check_reason_to_reside = localStorage.getItem('reason_to_review_pending');
            if (localStorage.getItem('run_board_round')) {
                var is_boardround = 1;
            } else {
                var is_boardround = 0;
            }
            $.ajax({
                url: "{{ route('ward.discharge.lounge.boardround.data', request()->patient_id) }}",
                type: 'GET',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id,
                    "is_boardround": is_boardround,
                    "board_round_order": board_round_order
                },
                success: function(result) {
                    let browser_id = localStorage.getItem('browser_id');
                    if (!browser_id) {
                        browser_id = GenerateBrowserID();
                        localStorage.setItem('browser_id', browser_id);
                    }

                    $.ajax({
                        url: "{{ url('/inpatients/dashboards/ward-summary/board-round/checked-locked-status') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "camis_patient_id": camis_patient_id,
                            "browser_id": browser_id
                        },
                        success: function(result) {
                            localStorage.removeItem('this_is_last_patient');
                            localStorage.removeItem('reason_to_review_pending');
                            $(window).scrollTop(0);

                            $('#click_boardround_close_offcanvas').val(0);
                            $('#click_next_patient_offcanvas').val(0);
                            var check_reason_to_reside = localStorage.getItem('reason_to_review_pending');
                            if (result.locked == 1) {


                                function disableEvents(event) {

                                    $('.locked_area').css('pointer-events', 'none');
                                    $('#board_round_cancel').addClass('locked');
                                    $('#board_round_close').addClass('locked');
                                    event.preventDefault();
                                    event.stopPropagation();
                                    $('#board_round_cancel').css('pointer-events', 'auto');
                                    $('#board_round_close').css('pointer-events', 'auto');
                                    $('.button_ward_summary_boardround_prev_patient').css('pointer-events', 'auto');
                                    $('.button_ward_summary_boardround_next_patient').css('pointer-events', 'auto');
                                    $('.button_ward_summary_boardround_show_history').css('pointer-events', 'auto');
                                }

                                var modal = document.getElementById('camis_patient_boardroundbody_modal');

                                modal.addEventListener('click', disableEvents);
                                modal.addEventListener('keydown', disableEvents);


                                var remaining_seconds = result.unlocked_after;
                                $(".locked_by_name").html(result.locked_by);
                                $("#lock_all_image").removeClass("content_display_none");
                                $('#los_value').addClass('bg-lock');
                                $('#allowed_to_be_moved').removeClass('click_popup_open_ibox_board_round_allowed_to_move');
                                $(".wardboxPopupModalHead").css("background-color", "red");
                                $('.locked_area').css('pointer-events', 'none');
                                $('#board_round_cancel').addClass('locked');
                                $('#board_round_close').addClass('locked');
                                function executeWardSummaryPatientBoardRound() {
                                    $(".wardboxPopupModalHead").css("background-color", "#13bec1");
                                    $("#lock_all_image").addClass("content_display_none");
                                    $('#los_value').removeClass('bg-lock');
                                    $('.ajax-content').css('pointer-events', 'auto');
                                    $('.locked_area').css('pointer-events', 'auto');
                                    $('#allowed_to_be_moved').addClass('click_popup_open_ibox_board_round_allowed_to_move');
                                    modal.removeEventListener('click', disableEvents);
                                    modal.removeEventListener('keydown', disableEvents);
                                }
                                if (remaining_seconds > 0) {
                                    setTimeout(executeWardSummaryPatientBoardRound, remaining_seconds * 1000);
                                } else {
                                    executeWardSummaryPatientBoardRound();
                                }
                            } else {
                                $("#lock_all_image").addClass("content_display_none");
                                $('.locked_area').css('pointer-events', 'auto');
                                $('#allowed_to_be_moved').addClass('click_popup_open_ibox_board_round_allowed_to_move');

                            }
                        }
                    });


                    $('.ajax-content').html(result);
                    $('.page-data-loader').hide();
                    $('.button_ward_summary_boardround_next_patient').removeClass('bottom-next-button');

                    $('.button_ward_summary_boardround_next_patient').addClass('inactive');

                    $('.button_ward_summary_boardround_prev_patient').removeClass('bottom-prev-button');
                    $('.button_ward_summary_boardround_prev_patient').addClass('inactive');
                    var next_patient = $('#ward_summary_boardround_modal_popup_camis_patient_id_next').val();
                    var prev_patient = $('#ward_summary_boardround_modal_popup_camis_patient_id_prev').val();

                    $('#ward_summary_boardround_modal_popup_camis_patient_id').val('{{ request()->patient_id }}');



                    if (localStorage.getItem('run_board_round')) {
                        $('.add_attendance').css('display', 'block');
                        $('#is_next_popup_need_to_open').val(1);
                    } else {
                        $('.add_attendance').css('display', 'none');
                    }
                    if (next_patient != '') {
                        $('.button_ward_summary_boardround_next_patient').removeClass('inactive');
                        $('.button_ward_summary_boardround_next_patient').addClass('bottom-next-button');
                    } else {
                        var add_attendance_div = document.getElementById("add_attendance");
                        if (localStorage.getItem('run_board_round')) {

                                $('.button_ward_summary_boardround_next_patient').attr('id', '');

                            $('.add_attendance').css('display', 'block');
                            $('.button_ward_summary_boardround_next_patient').removeClass('inactive');
                            $('.button_ward_summary_boardround_next_patient').addClass('bottom-next-button');
                            var token = "{{ csrf_token() }}";
                            var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
                            var url = "{{ route('KeepCacheBoardRoundConfig') }}";
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    "_token": token,
                                    "camis_ward_id": ward_id
                                },
                                success: function(result) {



                                }
                            });
                        } else {
                            $('.add_attendance').css('display', 'none');
                            $('.button_ward_summary_boardround_next_patient').removeClass('bottom-next-button');

                            $('.button_ward_summary_boardround_next_patient').addClass('inactive');
                        }
                    }
                    if (prev_patient != '') {
                        $('.button_ward_summary_boardround_prev_patient').removeClass('inactive');
                        $('.button_ward_summary_boardround_prev_patient').addClass('bottom-prev-button');
                    }
                }
            });
            @else
            CommonLoginModalPopupOpenOnRequest();
            @endif
        }

        $(document).on('click', '.cdt_alert', function(event) {

            $('.cdt_alert *').prop('disabled', true);
            toastr.error('This Option Can Odified From Discharge Tracker.', 'Opps!');
        });
        $(document).on('click', '.careRequermentWrap', function(event) {

            $('.careRequermentWrap *').prop('disabled', true);
            toastr.error('This Option Can Only Be Modified From Discharge Tracker.', 'Opps!');
        });

    </script>

    @include('Dashboards.Camis.WardSummary.WardSummaryScript')
    @include('Dashboards.Camis.WardSummary.WardSummaryBoardRoundDataAssignScript')
    @include('Dashboards.Camis.WardSummary.WardSummaryBoardRoundTaskAssignScript')
    @include('Dashboards.Camis.WardSummary.WardSummaryBoardRoundPatientFlagDataAssignScript')

    <script>
        var offcanvasElements = document.querySelectorAll('.offcanvas');

        var overlay = document.getElementById('overlay');

        function showOverlay() {
            overlay.style.display = 'block';
        }

        function hideOverlay() {
            overlay.style.display = 'none';
        }

        offcanvasElements.forEach(function (element) {
            element.addEventListener('show.bs.offcanvas', showOverlay);

            element.addEventListener('hidden.bs.offcanvas', hideOverlay);
        });

        var firstOffcanvas = new bootstrap.Offcanvas(offcanvasElements[0]);



        const noop = function() {};
        console.error = noop;
    </script>
    <script src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
@endsection


