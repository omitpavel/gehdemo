<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
        }
    });
    var tok = "{{ csrf_token() }}";
    @if(!in_array(Route::currentRouteName(), ['ward.sdec', 'ward.frailty', 'ward.discharge.lounge']))
    var ajax_refresh_url =
        "/inpatients/dashboards/ward-summary/data-refresh/{{ $success_array["ward"] }}";

    @endif
        $(document).on("click", ".get_board_round_user_list", function(e) {


        $("#modal_start_boardround").offcanvas('hide');
        if ($('#get_board_round_user_list_with_warning').hasClass('show')) {
            $('#get_board_round_user_list_with_warning').modal('hide');
        }
        setTimeout(function() {
            var attendance_modal = new bootstrap.Offcanvas(document.getElementById('camis_boardround_attendance'), {
                relatedTarget: 'offcanvasRight',
                backdrop: true
            });
            attendance_modal.show();
        }, 1000);

        DisableDeleteButtonForModals();
        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
        var url = "{{ route('GetWardRoundUser') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {

                    $('#attendance_user_list').html(result.sections);

                    setTimeout(function() {
                        DisableLoaderAndMakeVisibleInnerBody();
                    }, 1000);

                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }

            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });



        });


        $(document).on("click", ".get_board_round_user_list_with_warning", function(e) {
        var missed_patient = $('#missed_boardround_patients').val();
        $('.show_missing_number').html(missed_patient);
        var finished_boardround_modal = new bootstrap.Modal(document.getElementById('get_board_round_user_list_with_warning'), {
                                backdrop: false
                            });

        finished_boardround_modal.show();
    });
    @if(!in_array(Route::currentRouteName(), ['ward.sdec']))
        $(document).ready(function() {
            $('.page-data-loader').hide();
            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: ajax_refresh_url,
                type: 'GET',
                data: {
                    "_token": tok
                },
                success: function(result) {
                    GetWardStatus();
                    EnableToolTipForAjax();
                    $('.refresh-content').html(result.html_sections);
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
    @endif

    function GetWardStatus(){
        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;

        var url = '{{ route('ward_summery.status_data') }}';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {
                    if(result.boardround_resume == 1){
                        $('.add_attendance').css('display', 'block');

                        $('.board_round_text').html('Resume Board Round');
                        $('.board_round_button_text').html('Resume');
                        $(".boardround_cancel_button").addClass('d-none');
                        $(".finish_boardround").removeClass('d-none');
                        $(".camis_ward_action_boardround").removeClass('board_round_start');
                        $(".camis_ward_action_boardround").addClass('board_round_resume');
                         $("#" + $.escapeSelector("config_type_" + result.boardround_selected_checkbox)).css("display", "inline");

                        $('#board_round_selected_config').val(result.boardround_selected_checkbox);
                        @if(request()->route()->getName() != 'ward.ward-details')
                            var linkElement = document.getElementById("homepage_id");
                            linkElement.onclick = function() {
                                linkElement.href = "";
                                CloseBoardRound('{{ $success_array["ward"] }}');
                            };
                        @endif

                    }

                },
            error: function(textStatus, errorThrown) {
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    }


    $(document).on("click", ".board_round_restart", function(e) {
            var boardround_config = $('#board_round_selected_config').val();
            var type              = "";
            var doctor_id         = "";

                if(boardround_config == 'stranded'){
                    var type = "stranded";
                } else if(boardround_config == "bed_order"){
                    var type = "bed_order";
                } else{
                    var type = "doctor";
                    var doctor_id = boardround_config;
                }

                var token = "{{ csrf_token() }}";
                var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
                var url = "{{ route('CamisStartBoardRound') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_ward_id": ward_id,
                        "type": "bed_order",
                        "restart_bed_order": 1
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {

                            $('.show_boardround_history').html(result.sections);
                            $('#board_round_selected_config_current').val(boardround_config);
                            $('#board_round_selected_config').val(boardround_config);
                            $(".boardround_tick").css("display", "none");

                            $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display", "inline");
                            $('.board_round_button_text').html('Resume');
                            $(".boardround_cancel_button").addClass('d-none');
                            $(".finish_boardround").removeClass('d-none');
                            $(".camis_ward_action_boardround").addClass('board_round_resume');
                            $(".camis_ward_action_boardround").removeClass('board_round_start');
                            $("#modal_start_boardround").offcanvas('hide');
                            $(".add_attendance").css("display", "block");
                            $('#is_next_popup_need_to_open').val(1);
                            let board_round_run = localStorage.getItem('run_board_round');
                            if (!board_round_run) {
                                localStorage.setItem('run_board_round', 1);
                            }


                            @if (!in_array(request()->route()->getName(), ['ward.ward-details', 'CcuItuWard.ward-details']))
                                $('#homepage_id').attr('href', '#');
                                $('#homepage_id').attr('onclick', "CloseBoardRound('{{ $success_array['ward_details']['ward_url_name'] }}')");

                            @endif
                                @if (in_array(request()->route()->getName(), ['ward.ward-details', 'CcuItuWard.ward-details']))
                                @php
                                    $ward_url_name = isset($success_array['ward_details']['ward_url_name']) ? $success_array['ward_details']['ward_url_name'] : '';
                                @endphp
                            var url = "{{ route('ward.boardround', ['ward' => $ward_url_name, 'patient_id' => ':id']) }}";
                            url = url.replace(':id', result.boardround_resume_last_patient);
                            var board_round = window.open(url, '_self');
                            if (result.boardround_resume_last_patient != "") {
                                board_round.focus();
                            }
                            @else
                            $("#modal_start_boardround").offcanvas('hide');
                            CloseOffcanvas('modal_start_boardround');
                            BoardRoundData(result.boardround_resume_last_patient);
                            @endif
                            toastr.success('Board Round Started');
                            DisableLoaderAndMakeVisibleInnerBody();
                        } else {
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                    error: function(textStatus, errorThrown) {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });


        });



        $(document).on("click", "#start_boardround", function(e) {
        $('.boardround_config_type').removeClass('active');
        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById('modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: true
        });

        start_boardround_modal.show();
        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);

                var is_board_round_done = $('#is_board_round_done').val();
                if(is_board_round_done == 1){
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                } else {
                    $('.camis_ward_action_boardround').removeClass('board_round_done');
                }
                if ($('.boardround_config_type.bg-complete.active').length > 0) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }

                var all_have_bg_complete = true;
                $('.boardround_type_other').each(function() {
                    if (!$(this).hasClass('bg-complete')) {
                        all_have_bg_complete = false;
                        return false;
                    }
                });

                if (all_have_bg_complete) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                    $('.config_type_bed_order').addClass('bg-complete');
                    $('.time_bed_order').html(function(index, old_html) {

                       var time_string = '({{ CurrentDateOnFormat() }})';

                       return 'Completed' + time_string;
                   });

                }
                if (!$('.boardround_config_type').hasClass('active')) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var board_round_selected_config =  $('#board_round_selected_config').val();
                if(board_round_selected_config == ''){
                    $('.boardround_config_type').removeClass('active');
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }

                $('.boardround_config_type').each(function() {
                    if ($(this).hasClass('bg-complete') && $(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                var missed_patient = $('#missed_boardround_patients').val();

                if(missed_patient > 0){
                    if($('.finish_boardround').hasClass('get_board_round_user_list')){
                        $('.finish_boardround').removeClass('get_board_round_user_list');
                    }

                    if(!$('.finish_boardround').hasClass('get_board_round_user_list_with_warning')){
                        $('.finish_boardround').addClass('get_board_round_user_list_with_warning');
                    }
                } else {
                    if($('.finish_boardround').hasClass('get_board_round_user_list')){
                        $('.finish_boardround').addClass('get_board_round_user_list');
                    }

                    if(!$('.finish_boardround').hasClass('get_board_round_user_list_with_warning')){
                        $('.finish_boardround').removeClass('get_board_round_user_list_with_warning');
                    }
                }
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    });

    $(document).on("click", "#end_boardround", function(e) {



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


        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById('modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        start_boardround_modal.show();
        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);

                var is_board_round_done = $('#is_board_round_done').val();
                if(is_board_round_done == 1){
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                } else {
                    $('.camis_ward_action_boardround').removeClass('board_round_done');
                }
                if ($('.boardround_config_type.bg-complete.active').length > 0) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var all_have_bg_complete = true;
                $('.boardround_type_other').each(function() {
                    if (!$(this).hasClass('bg-complete')) {
                        all_have_bg_complete = false;
                        return false;
                    }
                });

                if (all_have_bg_complete) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                    $('.config_type_bed_order').addClass('bg-complete');
                    $('.time_bed_order').html(function(index, old_html) {

                    var time_string = '({{ CurrentDateOnFormat() }})';

                    return 'Completed' + time_string;
                });

                }
                if (!$('.boardround_config_type').hasClass('active')) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var board_round_selected_config =  $('#board_round_selected_config').val();
                if(board_round_selected_config == ''){
                    $('.boardround_config_type').removeClass('active');
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                $('.boardround_config_type').each(function() {
                    if ($(this).hasClass('bg-complete') && $(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    });


    $(document).on("click", ".confirm_boardround", function(e) {

        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById('modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        start_boardround_modal.show();
        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);

                var is_board_round_done = $('#is_board_round_done').val();
                if(is_board_round_done == 1){
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                } else {
                    $('.camis_ward_action_boardround').removeClass('board_round_done');
                }
                if ($('.boardround_config_type.bg-complete.active').length > 0) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                var all_have_bg_complete = true;
                $('.boardround_type_other').each(function() {
                    if (!$(this).hasClass('bg-complete')) {
                        all_have_bg_complete = false;
                        return false;
                    }
                });

                if (all_have_bg_complete) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                    $('.config_type_bed_order').addClass('bg-complete');
                    $('.time_bed_order').html(function(index, old_html) {

                    var time_string = '({{ CurrentDateOnFormat() }})';

                    return 'Completed' + time_string;
                });

                }
                if (!$('.boardround_config_type').hasClass('active')) {
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                $('.boardround_config_type').each(function() {
                    if ($(this).hasClass('bg-complete') && $(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                var board_round_selected_config =  $('#board_round_selected_config').val();
                if(board_round_selected_config == ''){
                    $('.boardround_config_type').removeClass('active');
                    $('.camis_ward_action_boardround').addClass('board_round_done');
                }
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });
        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();

    });

    $(document).on("click", ".boardround_config_type", function(e) {


            $('.missing-patients-card').html('');
            $('.boardround_config_type').removeClass('active');
            $(".boardround_tick").css("display", "none");
            var boardround_config = $(this).data('boardround-config');

            $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display", "inline");
            $("." + $.escapeSelector("config_type_" + boardround_config)).addClass('active');

            $('.board_round_button_text').html('Start');
            $(".camis_ward_action_boardround").removeClass('board_round_resume');
            $(".camis_ward_action_boardround").addClass('board_round_start');
            $('#board_round_selected_config').val(boardround_config);

            $('.camis_ward_action_boardround').removeClass('board_round_done');
            if($(this).hasClass('bg-complete')){
                $('.board_round_button_text').html('Start Again');
            }
            var boardround_config_current = $('#board_round_selected_config_current').val();
            if(boardround_config == boardround_config_current && !$(this).hasClass('bg-complete')){
                $('.board_round_button_text').html('Resume');
                $(".camis_ward_action_boardround").addClass('board_round_resume');
                $(".camis_ward_action_boardround").removeClass('board_round_start');
            }

            EnableSaveButtonForModals();


    });

    $(document).on("click", ".board_round_start", function(e) {
        var boardround_config = $('#board_round_selected_config').val();
        var type              = "";
        var doctor_id         = "";
        if (boardround_config) {

            if(boardround_config == 'stranded'){
                var type = "stranded";
            } else if(boardround_config == "bed_order"){
                var type = "bed_order";
            } else{
                var type = "doctor";
                var doctor_id = boardround_config;
            }

            var token = "{{ csrf_token() }}";
            var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
            var url = "{{ route('CamisStartBoardRound') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_ward_id": ward_id,
                    "type": type,
                    "doctor_id": doctor_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {

                        $('.show_boardround_history').html(result.sections);
                        $('#board_round_selected_config_current').val(boardround_config);
                        $('#board_round_selected_config').val(boardround_config);
                        $(".boardround_tick").css("display", "none");
                        $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display", "inline");

                        $('.board_round_button_text').html('Resume');
                        $(".boardround_cancel_button").addClass('d-none');
                        $(".finish_boardround").removeClass('d-none');
                        $(".camis_ward_action_boardround").addClass('board_round_resume');
                        $(".camis_ward_action_boardround").removeClass('board_round_start');
                        $("#modal_start_boardround").offcanvas('hide');
                        $(".add_attendance").css("display", "block");

                        let board_round_run = localStorage.getItem('run_board_round');
                        if (!board_round_run) {
                            localStorage.setItem('run_board_round', 1);
                        }


                        @if (!in_array(request()->route()->getName(), ['ward.ward-details', 'CcuItuWard.ward-details']))
                        var linkElement = document.getElementById("homepage_id");
                        linkElement.onclick = function() {
                            linkElement.href = "";
                            CloseBoardRound('{{ $success_array["ward"] }}');
                        };
                            @endif
                            @if (in_array(request()->route()->getName(), ['ward.ward-details', 'CcuItuWard.ward-details']))
                            @php
                                $ward_url_name = isset($success_array["ward"]) ? $success_array["ward"] : '';
                            @endphp
                        var url = "{{ route('ward.boardround', ['ward' => $ward_url_name, 'patient_id' => ':id']) }}";
                        url = url.replace(':id', result.boardround_resume_last_patient);
                        var board_round = window.open(url, '_self');
                        if (result.boardround_resume_last_patient != "") {
                            board_round.focus();
                        }
                        @else
                        $("#modal_start_boardround").offcanvas('hide');
                        BoardRoundData(result.boardround_resume_last_patient);
                        @endif
                        toastr.success('Board Round Started');
                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        } else {
            toastr.error('Please Select Any Options To Run Board Round');
        }
    });


    $(document).on("click", ".board_round_resume", function(e) {
        $('.boardround_config_type').removeClass('active');
        var boardround_config = $('#board_round_selected_config').val();
        var type              = "";
        var doctor_id         = "";
        if (boardround_config) {

            if(boardround_config == 'stranded'){
                var type = "stranded";
            } else if(boardround_config == "bed_order"){
                var type = "bed_order";
            } else{
                var type = "doctor";
                var doctor_id = boardround_config;
            }

            var token = "{{ csrf_token() }}";
            var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
            var url = "{{ route('CamisResumeBoardRound') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_ward_id": ward_id,
                    "type": type,
                    "doctor_id": doctor_id
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {

                        $('.show_boardround_history').html(result.sections);
                        var checkdata = "Option 2";
                        $('#board_round_selected_config_current').val(boardround_config);
                        $('#board_round_selected_config').val(boardround_config);
                        $(".boardround_tick").css("display", "none");

                        $("#" + $.escapeSelector("config_type_" + boardround_config)).css("display", "inline");



                        $("#camis_patients_start_boardround").modal('hide');
                        $(".add_attendance").css("display", "block");
                        let board_round_run = localStorage.getItem('run_board_round');
                        if (!board_round_run) {
                            localStorage.setItem('run_board_round', 1);
                        }
                        $("#modal_start_boardround").offcanvas('hide');
                        @if (in_array(request()->route()->getName(), ['ward.ward-details', 'CcuItuWard.ward-details']))
                            @php
                                $ward_url_name = isset($success_array["ward"]) ? $success_array["ward"] : '';
                            @endphp
                        var url = "{{ route('ward.boardround', ['ward' => $ward_url_name, 'patient_id' => ':id']) }}";
                        url = url.replace(':id',result.boardround_resume_last_patient);
                        var board_round = window.open(url, '_self');
                        if (result.boardround_resume_last_patient != "") {
                            board_round.focus();
                        }
                        @else
                        BoardRoundData(result.boardround_resume_last_patient);
                        @endif
                        DisableLoaderAndMakeVisibleInnerBody();
                        toastr.success('Board Round Started');
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        } else {
            toastr.error('Please Select Any Options To Run Board Round');
        }
    });

    $(document).on("click", ".get_board_round_user_list", function(e) {


        $("#modal_start_boardround").offcanvas('hide');
        CommonDisableEnableOnOpen();
        DisableLoaderAndMakeVisibleInnerBody();

        setTimeout(function() {
            var attendance_modal = new bootstrap.Offcanvas(document.getElementById('camis_boardround_attendance'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });
            attendance_modal.show();
        }, 1000);
        DisableSaveButtonForModals();

        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
        var url = "{{ route('GetWardRoundUser') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {

                    $('#attendance_user_list').html(result.sections);

                    setTimeout(function() {
                        DisableLoaderAndMakeVisibleInnerBody();
                    }, 1000);

                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }

            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });



    });




    $(document).on("click", ".addAttBtn", function(e) {



        $('.boardround_config_type').removeClass('active');
        var start_boardround_modal = new bootstrap.Offcanvas(document.getElementById('modal_start_boardround'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        start_boardround_modal.show();


        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
        var url = "{{ route('BoardRoundConfig') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id
            },
            success: function(result) {

                $('.boardround_config_data').html(result);
                var missed_patient = $('#missed_boardround_patients').val();

                if(missed_patient > 0){
                    if($('.finish_boardround').hasClass('get_board_round_user_list')){
                        $('.finish_boardround').removeClass('get_board_round_user_list');
                    }

                    if(!$('.finish_boardround').hasClass('get_board_round_user_list_with_warning')){
                        $('.finish_boardround').addClass('get_board_round_user_list_with_warning');
                    }
                } else {
                    if($('.finish_boardround').hasClass('get_board_round_user_list')){
                        $('.finish_boardround').addClass('get_board_round_user_list');
                    }

                    if(!$('.finish_boardround').hasClass('get_board_round_user_list_with_warning')){
                        $('.finish_boardround').removeClass('get_board_round_user_list_with_warning');
                    }
                }
                setTimeout(function() {
                    DisableLoaderAndMakeVisibleInnerBody();
                    EnableSaveButtonForModals();
                }, 1000);



            },
            error: function(textStatus, errorThrown) {

                CommonErrorModalPopupOpenOnRequest();
            }
        });


        CommonDisableEnableOnOpen();
        EnableSaveButtonForModals();
        DisableLoaderAndMakeVisibleInnerBody();



    });



    $(document).on("click", ".attendance_user_list", function(e) {
        $(this).toggleClass("active");

        EnableSaveButtonForModals();
    });



    $(document).on("click", ".save_attendance_ward", function(e) {


        var selected_user = $('.attendance_user_list.active').map(function() {
            return $(this).data('attendance_user_id');
        }).get().join(',');

        var token = "{{ csrf_token() }}";
        var ward_id = @if(isset($success_array['ward_details']['id'])) {{ $success_array['ward_details']['id'] }} @else null @endif;
        var url = "{{ route('SaveWardRoundUser') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_ward_id": ward_id,
                "boardround_user": selected_user
            },
            success: function(result) {
                if (typeof result.message !== 'undefined') {


                    $(".add_attendance").css("display", "none");
                    $('.board_round_text').html('Start Board Round');
                    $('.board_round_button_text').html('Start');
                    $(".boardround_cancel_button").addClass('d-none');
                    $(".stop_boardround").removeClass('d-none');
                    $(".camis_ward_action_boardround").removeClass('board_round_resume');
                    $(".boardround_config_type ").removeClass('active');
                    $(".camis_ward_action_boardround").addClass('board_round_start');
                    $("#modal_start_boardround").offcanvas('hide');
                    $("#camis_boardround_attendance").offcanvas('hide');
                    $('.button_ward_summary_boardround_next_patient').removeAttr('id');

                    toastr.success('Board Round Completed');
                    var url = "{{ route('ward.ward-details', $success_array["ward"])}}"
                    setTimeout(function() {
                        window.location.href = url;
                    }, 1000);
                } else {
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }

            },
            error: function(textStatus, errorThrown) {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });


    });


    function Modal_open_of_dr_task(value,id)
    {

        var ward_id = $('#ward_id').val();

        var filter_value = 'all_doc';

        DoctorTasks(ward_id,filter_value,value,id);
    }

    $(document).on('change', '#doctortask_filter', function(e) {
        var clickedIds = [];
        var ward_id = $('#ward_id').val();
        var type = $('.type_of_modal').val();
        var type_id = $('.type_id').val();
        var filter_value = $('#doctortask_filter').val();
        if(type === 'others'){
            if(filter_value != ''){
                DoctorTasks(ward_id,filter_value,type,filter_value);
            }else{
                DoctorTasks(ward_id,filter_value,type,type_id);
            }

        }else{
            DoctorTasks(ward_id,filter_value,type,type_id);
        }

    });

    var clickedIds = [];
    function StoreId(elementId) {

        var button = document.getElementById(elementId);
        var value = button.getAttribute('data-value');
        if (!clickedIds.includes(value)) {
            clickedIds.push(value);
            button.innerHTML = 'Completed';
            $(button).addClass('active')
        }else{
            var index =  clickedIds.indexOf(value);
            if (index !== -1) {
                clickedIds.splice(index, 1);
            }
            button.innerHTML = 'Click to Complete';
            $(button).removeClass('active')
        }
        var myArray = clickedIds;

     if(myArray.length > 0){
         var ward_id = $('#ward_id').val();
        $('#save_button_dr').addClass('save_doctor_task')
        $('#save_button_dr').removeAttr('disabled');
        $('#selected_task_id').val(myArray);
         $('#save_button_dr').attr("onclick", "SaveDoctorStatus()");
     }else{
        $('#save_button_dr').removeClass('save_doctor_task')
         $('#save_button_dr').attr('disabled',true);
     }

    }

    function SaveDoctorStatus() {
        var ward_id = $('#ward_id').val();
        var task_ids = $('#selected_task_id').val();
        var type = $('.type_of_modal').val();
        var type_id = $('.type_id').val();
        var filter_value = $('#doctortask_filter').val();
        var token = "{{ csrf_token() }}";
        EnableLoaderAndMakeHiddenInnerBody();
        var url = '{{ route('GetDoctorTasks') }}';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "ward_id": ward_id,
                "type": type,
                "type_id": type_id,
                "task_ids": task_ids,
                "filter_value": filter_value
            },
            success: function(result) {

                $('.doctor_modal_plan_html').html(result.views);
                $('#priority_task_count').html(result.priority_task);
                if(result.task_type ==='nurse'){
                    $('#total_nurse_task').text(result.total_task);
                }else if(result.task_type ==='doctor')
                {
                    $('#total_doctor_task').text(result.total_task);
                }

                DisableLoaderAndMakeVisibleInnerBody();

            }
        });
    }


    function DoctorTasks(ward_id,filter_value,type,type_id) {
        $('.doctor_modal_plan_html').html('');

        if(!$('#drworkplanPop').hasClass('show')){
            var dr_task_modal = new bootstrap.Offcanvas(document.getElementById('drworkplanPop'), {
                                    backdrop: 'static'
                                });

            dr_task_modal.show();
        }



        var token = "{{ csrf_token() }}";
        var url = '{{ route('GetDoctorTasks') }}';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "ward_id": ward_id,
                "type_id": type_id,
                "filter_value": filter_value,
                "type": type,
            },
            success: function(result) {


                $('.doctor_modal_plan_html').html(result.views);
                DisableLoaderAndMakeVisibleInnerBody();
            }
        });

    }

    $(document).on("click", "#patient_name_show", function(e) {
        $("#patient_name_show").addClass("content_display_none");
        $("#patient_name_hide").removeClass("content_display_none");

        $(".patient_name_hide_on_request").addClass("content_display_none");
        $(".patient_name_show_on_request").removeClass("content_display_none");

        clear_patient_name_show = setTimeout(function() {
            $("#patient_name_hide").addClass("content_display_none");
            $("#patient_name_show").removeClass("content_display_none");

            $(".patient_name_show_on_request").addClass("content_display_none");
            $(".patient_name_hide_on_request").removeClass("content_display_none");
        }, 60000);
    });

    $(document).on("click", "#patient_name_hide", function(e) {
        $("#patient_name_hide").addClass("content_display_none");
        $("#patient_name_show").removeClass("content_display_none");

        $(".patient_name_show_on_request").addClass("content_display_none");
        $(".patient_name_hide_on_request").removeClass("content_display_none");
    });

    $(document).on("click", ".print_doctor_task_wo", function (e){
        var w = window.open();
        var html_to_print = $(".doctors-plan-modal").html();
        var modal_type = $('.type_of_modal').val();

        var title = $('#drworkplanPopLabel').text();


        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/WardTemplate.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        $(w.document.head).append('<style>@media print {.no-page-break { page-break-inside: avoid; break-inside: avoid; }}</style>');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });
    $(document).on("click", ".print_doctor_task", function (e){
        var w = window.open();
        var html_to_print = $(".doctors-plan-modal").html();
        var modal_type = $('.type_of_modal').val();

        var title = $('#drworkplanPopLabel').text();


        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/WardTemplate.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });


    $(document).on("click", ".print_potential_discharges", function (e){
        var w = window.open();
        var html_to_print = $(".potential_discharge_list").html();
        var title = 'POTENTIAL DISCHARGE PATIENT LISTS';
        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/HandoverDetails.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href ="{{ asset('asset_v2/Template/Css/PotentialDischargeList.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });

    $(document).on("click", ".print_definite_discharges", function (e){
        var w = window.open();
        var html_to_print = $(".definite-dsicharge-list").html();
        var title = 'DEFINITE DISCHARGE PATIENT LISTS';
        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/HandoverDetails.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href ="{{ asset('asset_v2/Template/Css/PotentialDischargeList.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });

    $(document).on("click", ".print_allowed_to_move_in", function (e){
        var w = window.open();
        var html_to_print = $(".allowed_to_move_in_details_insert").html();
        var title = 'To Move IN';
        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });


    $(document).on("click", ".print_priority_task", function (e){
        var w = window.open();
        var html_to_print = $(".priority_task_list").html();
        var title = 'Priority Task';
        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });

    $(document).on("click", ".print_allowed_to_move_out", function (e){
        var w = window.open();
        var html_to_print = $(".allowed_to_move_out_details_insert").html();
        var title = 'To Move Out';
        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });
    $(document).on('click', '.ward_summary_patient_boardround_modal_popup_click', function() {
        var camis_patient_id = $(this).data('board-round-camis-patient-id');

        @php
        $ward_url_name = isset($success_array["ward"]) ? $success_array["ward"] : '';
        @endphp
        var url = "{{ route('ward.boardround', ['ward' => $ward_url_name, 'patient_id' => ':id']) }}";
        url = url.replace(':id',camis_patient_id);

        if (camis_patient_id != "") {
            window.location.href = url;
        }
        let board_round_run = localStorage.getItem('run_board_round');
        if (board_round_run) {
            localStorage.removeItem('run_board_round');
        }
    });

    $(document).on("click", ".click_open_camis_ward_priority_task", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('click_open_camis_ward_priority_task');
        var ward_priority_task_modal = new bootstrap.Offcanvas(document.getElementById('ward_priority_task'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });
        ward_priority_task_modal.show();
        var url = "{{ route('FetchPatientPriorityTask') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "ward_id": '{{ $success_array["ward_details"]["id"] }}'
            },
            success: function(result) {

                    if (typeof result !== '') {


                        $('.priority_task_list').html(result);

                        DisableLoaderAndMakeVisibleInnerBody();

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
            error: function(textStatus, errorThrown) {
                CloseOffcanvas('ward_priority_task');

                CommonErrorModalPopupOpenOnRequest();
            }
        });
    });

    $(document).on("click", ".click_open_camis_definite_today", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('click_open_camis_definite_today');

        var type = $(this).data('type');
        if(type == 'definite'){
            $('.definite-dsicharge-list').html('');
        } else {
            $('.potential_discharge_list').html('');
        }
        if(type == 'definite'){
            var definite_patient_modal = new bootstrap.Offcanvas(document.getElementById('DefiniteDischargeList'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

        } else {
            var definite_patient_modal = new bootstrap.Offcanvas(document.getElementById('potentialDischargeList'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });


        }
        definite_patient_modal.show();


        if (type != '') {
            var url = "{{ route('FetchPDPatients') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "type": type,
                    "ward_id": '{{ $success_array["ward_details"]["id"] }}'
                },
                success: function(result) {

                        if (typeof result !== '') {

                            if(type == 'definite'){
                                $('.definite-dsicharge-list').html(result.html_sections);
                            } else {
                                $('.potential_discharge_list').html(result.html_sections);
                            }
                            DisableLoaderAndMakeVisibleInnerBody();

                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                error: function(textStatus, errorThrown) {
                    if(type == 'definite'){
                        CloseOffcanvas('DefiniteDischargeList');
                    } else {
                        CloseOffcanvas('potentialDischargeList');
                    }
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            if(type == 'definite'){
                CloseOffcanvas('DefiniteDischargeList');
            } else {
                CloseOffcanvas('potentialDischargeList');
            }
            CommonErrorModalPopupOpenOnRequest();
        }
    });
    $(document).on("click", ".click_open_camis_allowed_to_move_in", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('click_open_camis_allowed_to_move_in');

        $('.allowed_to_move_in_details_insert').html('');
        var allowed_to_move_in = new bootstrap.Offcanvas(document.getElementById('patient_allowed_to_move_in_offcanvas'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });


        allowed_to_move_in.show();

        var url = "{{ route('FetchAllowedToMoveIn') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "ward_id": '{{ $success_array["ward_details"]["id"] }}'
            },
            success: function(result) {

                    if (typeof result !== '') {


                        $('.allowed_to_move_in_details_insert').html(result.html_sections);

                        DisableLoaderAndMakeVisibleInnerBody();

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
            error: function(textStatus, errorThrown) {

                CloseOffcanvas('patient_allowed_to_move_in_offcanvas');

                CommonErrorModalPopupOpenOnRequest();
            }
        });

    });

    $(document).on("click", ".click_open_camis_allowed_to_move_out", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('click_open_camis_allowed_to_move_out');

        $('.allowed_to_move_out_details_insert').html('');
        var allowed_to_move_in = new bootstrap.Offcanvas(document.getElementById('patient_allowed_to_move_out_offcanvas'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });


        allowed_to_move_in.show();

        var url = "{{ route('FetchAllowedToMoveOut') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "ward_id": '{{ $success_array["ward_details"]["id"] }}'
            },
            success: function(result) {

                    if (typeof result !== '') {


                        $('.allowed_to_move_out_details_insert').html(result.html_sections);

                        DisableLoaderAndMakeVisibleInnerBody();

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
            error: function(textStatus, errorThrown) {

                CloseOffcanvas('patient_allowed_to_move_out_offcanvas');

                CommonErrorModalPopupOpenOnRequest();
            }
        });

    });

    $(document).on("click", ".sdec_patient_view_offcanvas", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('sdec_patient_view_offcanvas');
        $('.sdec_modal_title').html('Patient To SDEC');
        $('.sdec_patient_offcanvas_data').html('');
        var sau_patient_data = new bootstrap.Offcanvas(document.getElementById('sdec_patient_offcanvas'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });


        sau_patient_data.show();

        var url = "{{ route('Ward.GetSauPatient') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "type": 'sdec'
            },
            success: function(result) {

                    if (typeof result !== '') {


                        $('.sdec_patient_offcanvas_data').html(result);

                        DisableLoaderAndMakeVisibleInnerBody();

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
            error: function(textStatus, errorThrown) {

                CloseOffcanvas('sdec_patient_offcanvas');

                CommonErrorModalPopupOpenOnRequest();
            }
        });

    });


    $(document).on("click", ".sau_patient_view_offcanvas", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('sau_patient_view_offcanvas');
        $('.sdec_modal_title').html('Patient To SAU');
        $('.sau_patient_offcanvas_data').html('');
        var sau_patient_data = new bootstrap.Offcanvas(document.getElementById('sau_patient_offcanvas'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });


        sau_patient_data.show();

        var url = "{{ route('Ward.GetSauPatient') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "type": 'sau'
            },
            success: function(result) {

                    if (typeof result !== '') {


                        $('.sau_patient_offcanvas_data').html(result);

                        DisableLoaderAndMakeVisibleInnerBody();

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
            error: function(textStatus, errorThrown) {

                CloseOffcanvas('sau_patient_offcanvas');

                CommonErrorModalPopupOpenOnRequest();
            }
        });

    });



    $(document).on("click", ".click_view_in_ed_now_patients", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('click_view_in_ed_now_patients');

        $('.ane_patient_offcanvas_data').html('');
        var ane_patient_data = new bootstrap.Offcanvas(document.getElementById('ane_patient_offcanvas'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });


        ane_patient_data.show();

        var ward = $(this).data('ward');
        var type = $(this).data('type');

        if(type == 'with_dta'){
            $('.ane_patient_offcanvas_title').html('With DTA');
        } else if(type == 'en_ed_now'){
            $('.ane_patient_offcanvas_title').html('In ED Now');
        }
         else {
            $('.ane_patient_offcanvas_title').html('Awaiting for Bed Allocation');
        }
        var url = "{{ route('Ward.GetAnePatientData') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "_token": token,
                "ward": ward,
                "type": type
            },
            success: function(result) {

                    if (typeof result !== '') {


                        $('.ane_patient_offcanvas_data').html(result);

                        DisableLoaderAndMakeVisibleInnerBody();

                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
            error: function(textStatus, errorThrown) {

                CloseOffcanvas('ane_patient_offcanvas');

                CommonErrorModalPopupOpenOnRequest();
            }
        });

    });



    $( document ).ready(function() {
        var interval;
            function startCycle() {
            interval = setInterval(function() {
                PageDataLoadOnRefreshes();
            }, 180000);
        }

        function PageDataLoadOnRefreshes() {



            if (ajax_refresh_url != '') {
                $.ajax({
                    url: ajax_refresh_url,
                    type: 'GET',
                    success: function(result) {
                        $('.page-data-loader').show();
                        GetWardStatus();
                        EnableToolTipForAjax();
                        $('.refresh-content').html(result.html_sections);
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
                        $('.in_ed_now_count').html(result.in_ed_now);
                        $('.in_dta_count').html(result.total_dta_patients);
                        if(result.ward_opel_status != 1 && result.ward_opel_status != 0){
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

                        setTimeout(function() {
                            $('.page-data-loader').hide();
                        }, 500);
                    }
                });
            }

        }
        startCycle();
    });
</script>
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
@include('Dashboards.Camis.WardSummary.HandOverDetailsScript')
