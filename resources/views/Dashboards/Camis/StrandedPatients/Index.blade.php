@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Patients By Los')
@section('page-top-title', 'Patients By LOS')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesPatientDetails.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesCommentHistory.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesTimeline.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/StrandedPatients.css') }}" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PathwayHistory.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/StrandedPatients.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}" />
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('modal')

    @include('Common.Modals.BoardRoundInfoModal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Camis.StrandedPatients.Modal')
    <div class="offcanvas-overlay" id="overlay">
        @include('Dashboards.Camis.WardSummary.Modal')
        @include('Common.Modals.CommonModals')
    </div>
@endsection
@section('content')
    <input type="hidden" id="boardround_patient_task_group" value="">
    <input type="hidden" id="task_category" value="2">
    <input type="hidden" id="filtered_task_id" value="">
    <input type="hidden" id="ward_summary_boardround_modal_popup_camis_patient_id" value="">
    <input type="hidden" id="boardround_patient_task_id_update" value="">
    <input type="hidden" id="permission" value="stranded_dashboard_super_stranded_view">

    <div class="contentSection container-fluid" id="contentSection_data">

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

    <script>
        @if(CheckSpecificPermission('stranded_dashboard_0_to_6_days_view'))
        $(document).ready(function() {
            LosType('0-6');
        });
        @elseif(CheckSpecificPermission('stranded_dashboard_7_to_13_days_view'))
        $(document).ready(function() {
            LosType('7-13');
        });
        @elseif(CheckSpecificPermission('stranded_dashboard_14_to_20_days_view'))

        $(document).ready(function() {
            LosType('14-20');
        });

        @elseif(CheckSpecificPermission('stranded_dashboard_super_stranded_view'))

        $(document).ready(function() {
            LosType('21+');
        });

        @endif


    </script>
    <script>
        function LosType(type) {
            var url = "{{ route('site.stranded_patients.content') }}";
            $('#los_type').val(type);
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    los_type: type,
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }

                }
            });
        }
        function DtocModal(camis_patient_id){
            @if(CheckSpecificPermission('discharge_tracker_discharge_info_popup_view'))
                var token           = "{{ csrf_token() }}";

                $(".modal-popup-loader-content").show();
                if(camis_patient_id != ''){
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.fetch.dtoc.info.global') }}",
                        type: 'POST',
                        data: { "_token": token, "camis_patient_id": camis_patient_id},
                        success: function (response)
                        {
                            $('.dtoc_data').html(response);
                            var patientDetails = document.getElementById('patientDetails');
                            var dtoc_offcanvas = new bootstrap.Offcanvas(patientDetails);
                            if (!$('#patientDetails').hasClass('show')) {
                                dtoc_offcanvas.toggle();
                            }


                            DisableLoaderAndMakeVisibleInnerBody();
                            CommonDisableEnableOnSave();
                            $(".modal-popup-loader-content").hide();
                        },
                        error: function(textStatus, errorThrown) {
                            CommonErrorModalPopupOpenOnRequest();
                            $(".modal-popup-loader-content").hide();
                        }
                    });
                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }
            @else
                PermissionDeniedAlert();
            @endif
        }
    </script>

    <script>
        $(document).on("change", "#ward_id, #task_type, #medfit_type", function(e) {
            var ward_id = $('#ward_id').val();
            var task_type = $('#task_type').val();
            var los_type = $('#los_type').val();
            var medfit_type  = $('#medfit_type').val();
            var url = "{{ route('site.stranded_patients.content') }}";
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "ward_id": ward_id,
                    "task_type": task_type,
                    "los_type": los_type,
                    "medfit_type": medfit_type
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('#contentSection_data').html(result);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.page-data-loader').hide();

                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }

                },
                error: function(){
                    $('.page-data-loader').hide();
                }
            });
        });

        $(document).on("click", ".comment_history_modal", function (e){
            var camis_patient_id = $('.comment_history_modal').data('camis-patient-id');
            var token = "{{ csrf_token() }}";
            $(".modal-popup-loader-content").show();
            if (camis_patient_id != '') {
                $.ajax({
                    url: "{{ route('discharged.comment.history') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id
                    },
                    success: function(result) {
                        if (result != '') {
                            $(".camis_patient_ward_summary_dtoc_comment_history").html(result);

                            var tu_modal_confirmation = new bootstrap.Modal(document.getElementById('modal_comment_history'), {
                                backdrop: 'static'
                            });
                            tu_modal_confirmation.show();

                            DisableLoaderAndMakeVisibleInnerBody();
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

        $(document).on("click", ".medfit_timeline", function (e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('patient-id');
            DisableButtonClickForPreventFurtherEvent("medfit_timeline");
            var timeline_modal = new bootstrap.Modal(document.getElementById('timeline'), {
                backdrop: 'static'
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
    </script>
    <script>
        function Backdropremove() {
            $('.modal-backdrop').css('z-index', 1040);
            $('.modal-backdrop').remove();
        }

    </script>
    @include('Common.Scripts.BoardRoundInfoModalScript')
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


        function FreshString(string) {
            string = string.replace(/ /g, '-');
            string = string.replace(/[^A-Za-z0-9\-]/g, '');
            return string.replace(/-+/g, '-');
        }

        function BoardRoundData(camis_patient_id, ward_name) {
            @if(CheckSpecificPermission('strand_dashboard_patient_info_view'))


            let board_round_missed = localStorage.getItem('board_round_missed');
            if (board_round_missed) {
                var board_round_order = 1;
            } else {
                var board_round_order = 0;
            }
            if(ward_name == 'rltsauip'){
                if(!$('#boardRound').hasClass('sau-board-round')){
                    $('#boardRound').addClass('sau-board-round');
                }
                if($('#boardRound').hasClass('board-round-offcanvas')){
                    $('#boardRound').removeClass('board-round-offcanvas');
                }
                if(!$('#boardRound').hasClass('boardround_width')){
                    $('#boardRound').addClass('boardround_width');
                }

            } else {
                if($('#boardRound').hasClass('sau-board-round')){
                    $('#boardRound').removeClass('sau-board-round');
                }
                if($('#boardRound').hasClass('boardround_width')){
                    $('#boardRound').removeClass('boardround_width');
                }
                if(!$('#boardRound').hasClass('board-round-offcanvas')){
                    $('#boardRound').addClass('board-round-offcanvas');
                }

            }
            var board_round = new bootstrap.Offcanvas(document.getElementById('boardRound'), {
                relatedTarget: 'offcanvasRight',

            });
            board_round.show();
            $('.append_to_content').html('');
            $('#modal-data-loader').show();
            var current_url = window.location.href;
            var updated_url = current_url.replace(/patient_id\/\w+/, 'patient_id/' + camis_patient_id);
            window.history.pushState({}, '', updated_url);
            var token = "{{ csrf_token() }}";
            localStorage.setItem('reason_to_review_pending', camis_patient_id);
            var check_reason_to_reside = localStorage.getItem('reason_to_review_pending');

            var is_boardround = 0;

            $.ajax({
                url: "{{ url('/inpatients/dashboards/patient-details-summary') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": camis_patient_id,
                    "is_boardround": is_boardround,
                    "board_round_order": board_round_order,
                    "stranded_patient" : 1
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


                    $('.append_to_content').html(result);
                    $('#modal-data-loader').hide();
                         $('#ward_summary_boardround_modal_popup_camis_patient_id').val(FreshString(camis_patient_id));



                    if (localStorage.getItem('run_board_round')) {
                        $('.add_attendance').css('display', 'block');
                        $('#is_next_popup_need_to_open').val(1);
                    } else {
                        $('.add_attendance').css('display', 'none');
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
        $(document).on('click', '.close_board_round_offcanvas', function(event) {
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            let browser_id = localStorage.getItem('browser_id');
            var unlock_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            var url = '{{ route('board_round_save_unlocked_status') }}';
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": unlock_patient_id,
                    "browser_id": browser_id
                },
                success: function(result) {
                    CloseOffcanvas('boardRound');
                }
            });
        });

        function TaskAssignFunction(camis_patient_id) {

            var task_view_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_assign_task'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            task_view_modal.show();

            var token = "{{ csrf_token() }}";
            var board_round_patient_task_description = $('#ibox_board_round_patient_task_description_open').val();
            $('#ward_summary_boardround_modal_popup_camis_patient_id').val(camis_patient_id);
            DisableButtonClickForPreventFurtherEvent('click_open_board_round_patient_task_assign');
            $('#boardround_patient_task_description').val('');
            $('#boardround_patient_task_id_update').val('');
            $('#boardround_patient_task_estimated_date_for_completion').val('');
            $('#boardround_patient_task_estimated_time_for_completion').val('');
            $('#boardround_patient_task_comment').val('');
            BoardRoundTaskAssignSetMorningBoardRoundOnOpen();
            $(".ibox_board_round_patient_task_assign_priority_inner").removeClass("active");
            $(".ibox_board_round_patient_task_assign_daily_inner").removeClass("active");
            $('#boardround_patient_task_estimated_date_for_completion').val($(
                '#boardround_patient_task_estimated_date_for_completion').data('estimated-date-for-completion'));
            $('#boardround_patient_task_estimated_time_for_completion').val($(
                '#boardround_patient_task_estimated_time_for_completion').data('estimated-time-for-completion'));
            $('#boardround_patient_task_description').val(board_round_patient_task_description);
            if ($('.ibox_board_round_patient_task_assign_priority_open').hasClass("active")) {
                $(".ibox_board_round_patient_task_assign_priority_inner").addClass("active");
            }

            if ($('.ibox_board_round_patient_task_assign_daily_open').hasClass("active")) {
                $(".ibox_board_round_patient_task_assign_daily_inner").addClass("active");
            }
            if (camis_patient_id != '') {
                CommonDisableEnableOnOpen();
                DisableLoaderAndMakeVisibleInnerBody();
                DisableSaveButtonForModals();
                $('#boardround_patient_task_estimated_date_for_completion').datepicker({
                    dateFormat: 'yy-mm-dd'
                });

                $('.clockpicker_2').clockpicker({
                    'default': 'now',
                    vibrate: true,
                    autoclose: true
                });
            } else {
                CommonErrorModalPopupOpenOnRequest();
            }
        }


    function PatientTaskEdit(task_id, button) {

        if (typeof task_id !== 'undefined' && task_id != '') {

            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('ibox_boardround_popup_patient_task_edit');
            $.ajax({
                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/fetch-patient-task-boadround') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id
                },
                success: function(result) {
                    if (result.id != '') {
                        if (result.status != 1) {

                            var common_modal = new bootstrap.Modal(document.getElementById(
                                'common_message_for_modal_show'), {
                                backdrop: 'static'
                            });

                            common_modal.show();

                            $(".common_message_for_modal_show_title").html('Task Removal');
                            $(".common_message_for_modal_show_content").html(
                                '<div class="alert alert-danger" style="text-align: center;">' + result
                                .message + '!</div>');

                        } else {
                            DisableSaveButtonForModals();
                            $('#boardround_patient_task_id_update').val(result.id);
                            $('#ward_summary_boardround_modal_popup_camis_patient_id').val(result
                                .patient_id);
                                $('#task_category').val(result.task_category);
                            $('#boardround_patient_task_description').val(result.task_description);
                            $('#boardround_patient_task_group').val(result.task_group_name).selectric(
                                'refresh');
                            $('#boardround_patient_task_estimated_date_for_completion').val(result
                                .task_estimated_date_for_completion);
                            $('#boardround_patient_task_estimated_time_for_completion').val(result
                                .task_estimated_time_for_completion);
                            $('#boardround_patient_task_comment').val(result.task_comment);
                            BoardRoundTaskAssignSetMorningBoardRoundOnOpen();
                            $(".ibox_board_round_patient_task_assign_site_task").removeClass(
                                "active");
                            if (result.task_priority == 1) {
                                $(".ibox_board_round_patient_task_assign_priority_inner").addClass(
                                    "active");
                            }

                            if (result.task_daily == 1) {
                                $(".ibox_board_round_patient_task_assign_daily_inner").addClass(
                                    "active");
                            }
                            if(result.task_estimated_time_for_completion =='09:00'){
                                $(".ibox_board_round_patient_task_assign_morning_evening_inner").html("Afternoon Board Round");

                            } else {
                                $(".ibox_board_round_patient_task_assign_morning_evening_inner").html("Morning Board Round");
                            }
                            $(".boardround_patient_task_estimated_time_for_completion").val(result.task_estimated_time_for_completion);
                            $(".boardround_patient_task_estimated_date_for_completion").val(result.task_estimated_date_for_completion);


                            var task_assign_modal = new bootstrap.Offcanvas(document.getElementById(
                                'camis_patient_ward_summary_boardround_assign_task'), {
                                ariaControls: 'offcanvasRight',
                                backdrop: 'static'
                            });


                            task_assign_modal.show();
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            $('#boardround_patient_task_estimated_date_for_completion').datepicker({
                                dateFormat: 'yy-mm-dd'
                            });
                            $('.clockpicker_2').clockpicker({
                                'default': 'now',
                                vibrate: true,
                                autoclose: true
                            });
                            EnableSaveButtonForModals();
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
            button.setAttribute("data-target", "#common_message_for_modal_show");
            $("#common_message_for_modal_show").modal('show');
            $(".common_message_for_modal_show_title").html('Assign Tasks');
            $(".common_message_for_modal_show_content").html(
                '<div class="alert alert-danger" style="text-align: center;">Please Select Any One Of The Task To Edit!</div>'
                );
        }

    }

    $(document).on("click", "#ibox_boardround_task_complete", function(e) {
        var task_id = $(this).attr('patient-task-id');
        var camis_patient_id = $(this).attr('patient-id');
        const listItem = '.edit_task' + task_id;
        if (task_id !== 'undefined' && task_id != '') {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/complete-patient-task-boadround') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "task_id": task_id,
                    "camis_patient_id": camis_patient_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {


                        if(result.status == 1){
                            var outstanding_task_amount = result.task_to_be_completed.length;
                            $('.rm_task_' + task_id).remove();
                            if (outstanding_task_amount < 1) {
                                var outstanding_tasks = 'No';
                                $('#all_task_body').html('<tr><td class="custom_table_data_not_found">{{ NotFoundMessage() }}</td></tr>');

                            } else {
                                var outstanding_tasks = outstanding_task_amount;
                            }
                            $('#count_outstanding_task_' + camis_patient_id).html(outstanding_tasks);
                            toastr.success('Task Completed Successfully');
                            $('.tooltip').tooltip('hide');

                        } else {
                            toastr.error(result.message);
                        }


                        var task_category = $('#task_category').val();
                        var filter_category = $('#filtered_task_id').val();
                        var permission = $('#permission').val();
                        $.ajax({
                                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/fetch-outstanding-task') }}",
                                type: 'POST',
                                data: {
                                    "_token": tok,
                                    "camis_patient_id": camis_patient_id,
                                    "edit_category": task_category,
                                    "filter_category": filter_category,
                                    "permission": permission,
                                },
                                success: function(result) {
                                    $('#updated_task_list_' + camis_patient_id).html(
                                        result);
                                    $('#boardround_patient_task_group').val('')
                                        .selectric('refresh');
                                    $('#camis_patient_ward_summary_boardround_assign_task')
                                        .offcanvas('hide');
                                }

                            });

                            $('#ibox_board_round_patient_task_description_open').val('');
                            $('.ibox_board_round_patient_task_assign_priority_open').removeClass(
                                "active");
                            $('.ibox_board_round_patient_task_assign_daily_open').removeClass(
                                "active");
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            $('#common_message_for_modal_show').modal({
                backdrop: 'static'
            });
            $(".common_message_for_modal_show_title").html('Assign Tasks');
            $(".common_message_for_modal_show_content").html(
                '<div class="alert alert-danger" style="text-align: center;">Please Select Any One Of The Task To Complete!</div>'
                );
        }

    });


    $(document).on("click", ".ibox_boardround_task_delete", function(e) {
            e.preventDefault();
            var task_id = $(this).attr('patient-task-id');
            var camis_patient_id = $(this).attr('patient-id');
            if (typeof task_id !== 'undefined' && task_id != '') {
                var token = "{{ csrf_token() }}";
                DisableButtonClickForPreventFurtherEvent('ibox_boardround_popup_patient_task_delete');
                $.ajax({
                    url: "{{ url('/inpatients/dashboards/ward-summary/board-round/not-applicable-patient-task-boadround') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "task_id": task_id,
                        "camis_patient_id": camis_patient_id,

                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {


                            if(result.status == 1){
                                var outstanding_task_amount = result.task_to_be_completed.length;
                                $('.rm_task_' + task_id).remove();
                                if (outstanding_task_amount < 1) {
                                    var outstanding_tasks = 'No';
                                    $('#all_task_body').html('<tr><td class="custom_table_data_not_found">{{ NotFoundMessage() }}</td></tr>');
                                } else {
                                    var outstanding_tasks = outstanding_task_amount;
                                }
                                $('#count_outstanding_task_' + camis_patient_id).html(outstanding_tasks);
                                toastr.success(result.message);
                                $('.tooltip').tooltip('hide');

                            } else {
                                toastr.error(result.message);
                            }


                            var task_category = $('#task_category').val();
                            var filter_category = $('#filtered_task_id').val();
                            var permission = $('#permission').val();
                            $.ajax({
                                    url: "{{ url('/inpatients/dashboards/ward-summary/board-round/fetch-outstanding-task') }}",
                                    type: 'POST',
                                    data: {
                                        "_token": tok,
                                        "camis_patient_id": camis_patient_id,
                                        "edit_category": task_category,
                                        "filter_category": filter_category,
                                        "permission": permission,
                                    },
                                    success: function(result) {
                                        $('#updated_task_list_' + camis_patient_id).html(
                                            result);
                                        $('#boardround_patient_task_group').val('')
                                            .selectric('refresh');
                                        $('#camis_patient_ward_summary_boardround_assign_task')
                                            .offcanvas('hide');
                                    }

                                });

                                $('#ibox_board_round_patient_task_description_open').val('');
                                $('.ibox_board_round_patient_task_assign_priority_open').removeClass(
                                    "active");
                                $('.ibox_board_round_patient_task_assign_daily_open').removeClass(
                                    "active");

                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                $('#common_message_for_modal_show').modal({
                    backdrop: 'static'
                });
                $(".common_message_for_modal_show_title").html('Assign Tasks');
                $(".common_message_for_modal_show_content").html(
                    '<div class="alert alert-danger" style="text-align: center;">Please Select Any One Of The Task To Complete!</div>'
                    );
            }
    });

    function TaskActive(id) {
        if (id == 'ibox_board_round_patient_task_assign_site_inner') {
            $('.ibox_board_round_patient_task_assign_bedmeeting_inner').removeClass('btn-success');
            $('.ibox_board_round_patient_task_assign_site_inner').addClass('btn-success');
            $('#task_category').val(11);
        } else {
            $('.ibox_board_round_patient_task_assign_bedmeeting_inner').addClass('btn-success');
            $('.ibox_board_round_patient_task_assign_site_inner').removeClass('btn-success');
            $('#task_category').val(11);
        }
    }
    function GetPatientTaskShowString(jsonData, taskId) {

        var task = jsonData.task_to_be_completed.find(function (outstand_task) {

        return outstand_task.id == taskId;
        });
        return task ? task.patient_task_show_string : null;
    }
    function OutStandingTask(camis_patient_id, task_edit_category, has_permission, doctor_at_night) {

    $('.page-data-loader_two').show();
        if (camis_patient_id != '') {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('show.outstanding.task') }}',
                type: 'POST',
                data: {
                    "_token": token,
                    "patient_id": camis_patient_id,
                    "task_category": task_edit_category,
                    "permission": has_permission,
                    "type": doctor_at_night,
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {

                        var all_outstanding_task = new bootstrap.Offcanvas(document.getElementById('camis_patient_outstanding_task'), {
                            relatedTarget: 'offcanvasRight',
                            backdrop: 'true',

                        });

                        all_outstanding_task.show();

                        $('#show_patient_outstanding_task').html(result);
                        $('.page-data-loader_two').hide();

                        DisableLoaderAndMakeVisibleInnerBody();
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
    }
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
