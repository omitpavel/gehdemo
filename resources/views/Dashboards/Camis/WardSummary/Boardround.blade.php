@extends('Layouts.Common.MasterLayout')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Sidebar.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/clockpicker.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Timeline.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PathwayHistory.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/BoardRound.css') }}" crossorigin="anonymous" />
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />

@endsection
@section('page-title', 'Board Round')
@section('page-top-title', 'Board Round')

@section('modal')
    <div class="offcanvas-overlay" id="overlay">
        @include('Dashboards.Camis.WardSummary.Modal')
        @include('Common.Modals.CommonModals')
    </div>
@endsection
@section('boardround-menus')
    <li class="nav-item  me-2 timer_countdown d-none" id="timer_container">
        <button class="btn btn-add-attendance addAttBtn" id="countdown">00:00:00 </button>
    </li>
    <li class="nav-item  me-2 add_attendance {{ PermissionDeniedDiv('camis_boardround_start_update') }}"
        @if (CheckSpecificPermission('camis_boardround_start_update')) id="add_attendance" @endif style="display:none">
        <button
            class="btn btn-add-attendance addAttBtn {{ DisabledButtonOnRolePermission('camis_boardround_start_update') }}">Add
            Attendance </button>
    </li>
@endsection
@section('top-menus')

    <li class="nav-item shape-btn me-2 {{ PermissionDeniedDiv('camis_boardround_start_update') }}"
        @if (CheckSpecificPermission('camis_boardround_start_update')) id="start_boardround" @endif>
        <a class=" text-center {{ DisabledButtonOnRolePermission('camis_boardround_start_update') }}" href="#"
            role="button">
            <img src="{{ asset('asset_v2/Ibox/icons/red-button.png') }}" height="18">
        </a>
    </li>

@endsection


@section('content')
    <input type="hidden" value="" id="patient_id_board_round_all_selected_consultant_rand">
    <input type="hidden" value="" id="consultant_board_round_all_selected_consultant_rand">
    <input type="hidden" value="" id="board_round_all_selected_consultant_rand_type">
    <input type="hidden" value="" id="board_round_selected_config">
    <input type="hidden" value="" id="board_round_selected_config_current">
    <div>
        <button class="btn bg-lock mb-2 w-100 modal-locked content_display_none" id="lock_all_image"><img
                src="{{ asset('asset_v2/Template/icons/lock.svg') }}" alt="" width="20" class="me-3">
            <span class="locked_user_name_to_show">Locked By
                <span class="locked_by_name"></span></span></button>
    </div>
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="ajax-content"></div>


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


        $(document).ready(function() {


            var current_url = window.location.href;
            var parts = current_url.split('/');
            var camis_patient_id = parts[parts.length - 1];
            var ajax_refresh_url = "/inpatients/dashboards/board-round/patient-info";
            if (camis_patient_id != '') {
                BoardRoundData(camis_patient_id);
            }

        });

        $(document).ready(function() {

            $("#ibox_board_round_content_admitting_reason").on("keyup", function() {
                $('.camis_patient_ward_summary_boardround_save_admitting_reason').removeClass("disabled");
            });
            $("#ibox_board_round_content_past_medical_history").on("keyup", function() {
                $('.camis_patient_ward_summary_boardround_save_past_medical_history').removeClass(
                    "disabled");
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

            $('#pharmacy_latest_comment').on('input', function() {
                $('.camis_patient_ward_summary_boardround_save_pharmacy_info').prop('disabled', false);
            });




        });


        function FreshString(string) {
            string = string.replace(/ /g, '-');
            string = string.replace(/[^A-Za-z0-9\-]/g, '');
            return string.replace(/-+/g, '-');
        }

        function BoardRoundData(camis_patient_id) {
            @if (CheckSpecificPermission('camis_boardround_view'))
                $('.page-data-loader').hide();
                $('.page-data-loader').show();

                let board_round_missed = localStorage.getItem('board_round_missed');
                if (board_round_missed) {
                    var board_round_order = 1;
                } else {
                    var board_round_order = 0;
                }



                var current_url = window.location.href;
                var updated_url = current_url.replace(/patient_id\/\w+/, 'patient_id/' + camis_patient_id);
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
                    url: "{{ url('/inpatients/dashboards/patient-details-summary') }}",
                    type: 'POST',
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
                                var check_reason_to_reside = localStorage.getItem(
                                    'reason_to_review_pending');
                                if (result.locked == 1) {


                                    function disableEvents(event) {

                                        $('.locked_area').css('pointer-events', 'none');
                                        $('#board_round_cancel').addClass('locked');
                                        $('#board_round_close').addClass('locked');
                                        event.preventDefault();
                                        event.stopPropagation();
                                        $('#board_round_cancel').css('pointer-events', 'auto');
                                        $('#board_round_close').css('pointer-events', 'auto');
                                        $('.button_ward_summary_boardround_prev_patient').css(
                                            'pointer-events', 'auto');
                                        $('.button_ward_summary_boardround_next_patient').css(
                                            'pointer-events', 'auto');
                                        $('.button_ward_summary_boardround_show_history').css(
                                            'pointer-events', 'auto');
                                    }

                                    var modal = document.getElementById(
                                        'camis_patient_boardroundbody_modal');

                                    modal.addEventListener('click', disableEvents);
                                    modal.addEventListener('keydown', disableEvents);


                                    var remaining_seconds = result.unlocked_after;
                                    $(".locked_by_name").html(result.locked_by);
                                    $("#lock_all_image").removeClass("content_display_none");
                                    $('#los_value').addClass('bg-lock');
                                    $('#allowed_to_be_moved').removeClass(
                                        'click_popup_open_ibox_board_round_allowed_to_move');
                                    $(".wardboxPopupModalHead").css("background-color", "red");
                                    $('.locked_area').css('pointer-events', 'none');
                                    $('#board_round_cancel').addClass('locked');
                                    $('#board_round_close').addClass('locked');

                                    function executeWardSummaryPatientBoardRound() {
                                        $(".wardboxPopupModalHead").css("background-color",
                                            "#13bec1");
                                        $("#lock_all_image").addClass("content_display_none");
                                        $('#los_value').removeClass('bg-lock');
                                        $('.ajax-content').css('pointer-events', 'auto');
                                        $('.locked_area').css('pointer-events', 'auto');
                                        $('#allowed_to_be_moved').addClass(
                                            'click_popup_open_ibox_board_round_allowed_to_move');
                                        modal.removeEventListener('click', disableEvents);
                                        modal.removeEventListener('keydown', disableEvents);
                                    }
                                    if (remaining_seconds > 0) {
                                        setTimeout(executeWardSummaryPatientBoardRound,
                                            remaining_seconds * 1000);
                                    } else {
                                        executeWardSummaryPatientBoardRound();
                                    }
                                } else {
                                    $("#lock_all_image").addClass("content_display_none");
                                    $('.locked_area').css('pointer-events', 'auto');
                                    $('#allowed_to_be_moved').addClass(
                                        'click_popup_open_ibox_board_round_allowed_to_move');

                                }
                            }
                        });


                        $('.ajax-content').html(result);
                        $('.page-data-loader').hide();
                        $('.button_ward_summary_boardround_next_patient').removeClass('bottom-next-button');

                        $('.button_ward_summary_boardround_next_patient').addClass('inactive');

                        $('.button_ward_summary_boardround_prev_patient').removeClass('bottom-prev-button');
                        $('.button_ward_summary_boardround_prev_patient').addClass('inactive');
                        var next_patient = $('#ward_summary_boardround_modal_popup_camis_patient_id_next')
                    .val();
                        var prev_patient = $('#ward_summary_boardround_modal_popup_camis_patient_id_prev')
                    .val();

                        $('#ward_summary_boardround_modal_popup_camis_patient_id').val(FreshString(
                            camis_patient_id));



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
                                $('.button_ward_summary_boardround_next_patient').addClass(
                                'bottom-next-button');
                                var token = "{{ csrf_token() }}";
                                var ward_id =
                                    @if (isset($success_array['ward_details']['id']))
                                        {{ $success_array['ward_details']['id'] }}
                                    @else
                                        null
                                    @endif ;
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
                                $('.button_ward_summary_boardround_next_patient').removeClass(
                                    'bottom-next-button');

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
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
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

        offcanvasElements.forEach(function(element) {
            element.addEventListener('show.bs.offcanvas', showOverlay);

            element.addEventListener('hidden.bs.offcanvas', hideOverlay);
        });

        var firstOffcanvas = new bootstrap.Offcanvas(offcanvasElements[0]);



        const noop = function() {};
        console.error = noop;
    </script>
    <script src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
@endsection
