<script>
    jQuery(document).ready(function($) {


        function CleanString(string) {
            string = string.replace(/ /g, '-');
            string = string.replace(/[^A-Za-z0-9\-]/g, '');
            return string.replace(/-+/g, '-');
        }

        $(document).on("click", ".print_doctor_task_wo", function (e){
            var w = window.open();
            var html_to_print = $(".doctor_task_list").html();
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

        $(document).on("click", ".print_definte_today", function (e){
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

        $(document).on("click", ".print_dp_timeline", function (e){
            var w = window.open();
            var html_to_print = $(".dp_print_section").html();
            var title = 'DETERIORATING PATIENT TIMELINE';
            var print_title =
            '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

            var html = print_title +
            '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
            html_to_print + '</div>';

            $(w.document.body).html(html);

            var dp_comments = `
                <div class="col-md-12 padding-zero" style="padding: 10px; border: 1px solid black; height: 100px; width: 100%; margin-top: 15px;">
                    <div class="col-md-12 padding-zero" style="padding: 2px;">Comments:</div>
                </div>
                <div class="col-md-12 padding-zero" style="padding: 10px; width: 95%; margin-top: 60px;">
                    <div class="col-md-8 padding-zero" style="padding: 10px; border-top: 1px solid black; height: 50px; width: 150px; float: right; text-align: center;">
                        Signature
                    </div>
                </div>`;
            $(w.document.body).append(dp_comments);
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/Timeline.css') }}">');
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

        $(document).on("click", ".print_ane_discharge_summary", function (e){
            var w = window.open();
            var html_to_print = $(".print_ane_summary").html();
            var title = 'A&E DISCHARGE SUMMARY';
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
            $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });

        $(document).on("click", ".print_patient_task_list", function (e){
            var w = window.open();
            var html_to_print = $("#printTask").html();
            var title = $('#patient_task_title').text();
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
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Ibox/Css/CustomPrint.css') }}">');

            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });

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

        $(document).on('click', '.ward_summary_patient_boardround_modal_popup_click', function() {
            var camis_patient_id = $(this).data('board-round-camis-patient-id');

                @php
                    $ward_url_name = isset($success_array['ward_details']['ward_url_name']) ? $success_array['ward_details']['ward_url_name'] : '';
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

        $(document).on("click", ".close_board_round", function(e) {
            var token = "{{ csrf_token() }}";
            var unlock_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            let browser_id = localStorage.getItem('browser_id');
            if (!browser_id) {
                browser_id = GenerateBrowserID();
                localStorage.setItem('browser_id', browser_id);
            }
            var url = '{{ route('board_round_save_unlocked_status') }}';

            $.ajax({
            url: url,
            type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": unlock_patient_id,
                    "browser_id": browser_id
                },
                success: function(result) {
                    $('#is_next_popup_need_to_open').val(0);
                    $("#camis_patient_ward_summary_boardround_modal").modal('hide');
                }
            });
        });




        $(document).on("click", ".button_ward_summary_boardround_prev_patient", function(e) {

            var token = "{{ csrf_token() }}";
            var unlock_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            let browser_id = localStorage.getItem('browser_id');
            if (!browser_id) {
                browser_id = GenerateBrowserID();
                localStorage.setItem('browser_id', browser_id);
            }
            var url = '{{ route('board_round_save_unlocked_status') }}';

            $.ajax({
                url: url,
            type: 'POST',
            data: {
                "_token": token,
                "camis_patient_id": unlock_patient_id,
                "browser_id": browser_id
            },
                success: function(result) {

                }
            });

            if (unlock_patient_id != '') {
                var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id_prev').val();
                if (camis_patient_id != '') {
                    BoardRoundData(camis_patient_id);
                }

            } else {
                CommonErrorModalPopupOpenOnRequest();
            }


        });

        $(document).on("click", ".button_ward_summary_boardround_next_patient", function(e) {
            var token = "{{ csrf_token() }}";
            var unlock_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            let browser_id = localStorage.getItem('browser_id');
            if (!browser_id) {
                browser_id = GenerateBrowserID();
                localStorage.setItem('browser_id', browser_id);
            }
            var url = '{{ route('board_round_save_unlocked_status') }}';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "camis_patient_id": unlock_patient_id,
                    "browser_id": browser_id
                },
                success: function(result) {

                }
            });


            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id_next').val();
            let  check_board_round= localStorage.getItem('run_board_round');
            if(!check_board_round){
                if(camis_patient_id != ''){
                    BoardRoundData(camis_patient_id);
                } else {
                    toastr.warning('No More Patients Available');
                    return;
                }
            } else {
                $('#click_next_patient_offcanvas').val(1);
            }
            if (unlock_patient_id != '') {
                var check_reason_to_reside = $('#is_next_popup_need_to_open').val();




                if (check_reason_to_reside == 0) {
                    if(camis_patient_id == '' && !$('.button_ward_summary_boardround_next_patient').is('#start_boardround')){
                        return;
                    } else if(camis_patient_id == '' && !$('.button_ward_summary_boardround_next_patient').is('#start_boardround')){
                        return;
                    } else {
                        BoardRoundData(camis_patient_id);

                    }



                } else {
                    var check_reason_to_reside = localStorage.getItem('this_is_last_patient');



                    if(!check_reason_to_reside){
                        var url = "{{ route('GetReasonToReside') }}";
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                "_token": token,
                                "camis_patient_id": unlock_patient_id
                            },
                            success: function(result) {
                                $('#click_next_patient_offcanvas').val(1);
                                $('.ibox_board_round_content_patient_reason_to_reside').prop('checked', false);
                                $('.reason_to_reside_modal_title').html('Reason To Reside');
                                if(!$('.reason_to_reside_close_area').hasClass('d-none')){
                                    $('.reason_to_reside_close_area').addClass('d-none');
                                }
                                if($('.reason_to_reside_save_area').hasClass('d-none')){
                                    $('.reason_to_reside_save_area').removeClass('d-none');
                                }

                                if(!$('.redbed_save_area').hasClass('d-none')){
                                    $('.redbed_save_area').addClass('d-none');
                                }
                                var reason_to_reaside = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_reason_to_reside'), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: false
                                });

                                reason_to_reaside.show();
                                $('#r2r_button_text').html('SAVE & NEXT');
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();

                                $('#ibox_board_round_content_med_fit_set_as_no').val(result.patient_medically_fit_status);
                                if(!$('.camis_patient_ward_summary_boardround_save_red_green_bed').hasClass('camis_patient_ward_summary_boardround_save_reason_to_reside')){
                                    $('.camis_patient_ward_summary_boardround_save_red_green_bed').addClass('camis_patient_ward_summary_boardround_save_reason_to_reside');
                                }
                                if($('.camis_patient_ward_summary_boardround_save_reason_to_reside').hasClass('camis_patient_ward_summary_boardround_save_red_green_bed')){
                                    $('.camis_patient_ward_summary_boardround_save_reason_to_reside').removeClass('camis_patient_ward_summary_boardround_save_red_green_bed');
                                }


                                if(result.patient_medically_fit_status == 1){
                                    if($('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')){
                                        $('.click_popup_open_ibox_board_round_medfit_no_modal').removeClass('active');
                                    }
                                    if(!$('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')){
                                        $('.click_popup_open_ibox_board_round_medfit_yes_modal').addClass('active');
                                    }
                                    $('#ibox_board_round_content_med_fit_set_as_no').val(1);
                                    $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("checked", true);
                                    $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("disabled", false);
                                    $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]").prop("disabled", true);


                                    if($('.medfit-card').hasClass('d-none')){
                                        $('.medfit-card').removeClass('d-none');
                                    }
                                    $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show').html());
                                    if(!$('.r2r_checkbox_section').hasClass('d-none')){
                                        $('.r2r_checkbox_section').addClass('d-none');
                                    }
                                    $('#ibox_board_round_content_patient_medically_fit_status_comment').val(result.patient_medically_fit_status_comment);
                                    EnableSaveButtonForModals();
                                } else {
                                    if($('.click_popup_open_ibox_board_round_medfit_yes_modal').hasClass('active')){
                                        $('.click_popup_open_ibox_board_round_medfit_yes_modal').removeClass('active');
                                    }
                                    if(!$('.click_popup_open_ibox_board_round_medfit_no_modal').hasClass('active')){
                                        $('.click_popup_open_ibox_board_round_medfit_no_modal').addClass('active');
                                    }
                                    $('#ibox_board_round_content_med_fit_set_as_no').val(1);

                                    $('#ibox_board_round_content_patient_medically_fit_status_comment').val('');
                                    $('input[name="ibox_board_round_content_patient_reason_to_reside"]').prop('checked', false);
                                    if (result.patient_reason_to_reside_status != '') {
                                        $('input[name="ibox_board_round_content_patient_reason_to_reside"][value="' + result.patient_reason_to_reside_status + '"]').prop('checked', true);
                                        EnableSaveButtonForModals();
                                    }
                                    $("input[name=ibox_board_round_content_patient_reason_to_reside][value!=0]").prop("disabled", false);
                                    $("input[name=ibox_board_round_content_patient_reason_to_reside][value=0]").prop("disabled", true);
                                    if(!$('.medfit-card').hasClass('d-none')){
                                        $('.medfit-card').addClass('d-none');
                                    }
                                    $('.medfit_yes_consultant_head_doctor_name').html($('.boardround_patient_consultant_full_name_show').html());
                                    if($('.r2r_checkbox_section').hasClass('d-none')){
                                        $('.r2r_checkbox_section').removeClass('d-none');
                                    }
                                }

                            },
                            error: function(textStatus, errorThrown) {
                                CommonErrorModalPopupOpenOnRequest();
                            }
                        });
                    } else {

                        let board_round_run = localStorage.getItem('run_board_round');



                        if (board_round_run) {
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
                            toastr.warning('No More Patients Available');
                        }
                        return;

                    }


                }


            } else {
                CommonErrorModalPopupOpenOnRequest();
            }

        });


        $(document).on('click', '#definite_task_top_row', function(e) {
            e.stopPropagation();
            $('#definitePop').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.potential_task_top_row', function(e) {
            e.stopPropagation();
            $('#potential_document_details_insert').html($('#potential_list_inner_html_plug_data').html());
            $('#potentialPop').modal({
                backdrop: 'static'
            });
        });

    });

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
                    $('#click_next_patient_offcanvas').val(1);
                    $('.add_attendance').css('display', 'block');
                    $('.board_round_text').html('Resume Board Round');
                    $('.board_round_button_text').html('Resume');
                    $(".boardround_cancel_button").addClass('d-none');
                    $(".finish_boardround").removeClass('d-none');
                    $(".camis_ward_action_boardround").removeClass('board_round_start');
                    $(".camis_ward_action_boardround").addClass('board_round_resume');

                    $("#" + $.escapeSelector("config_type_" + result.boardround_selected_checkbox)).css("display", "inline");

                    $('#board_round_selected_config_current').val(result.boardround_selected_checkbox);
                    $('#board_round_selected_config').val(result.boardround_selected_checkbox);
                    $('#is_next_popup_need_to_open').val(1);
                        @if(!in_array(request()->route()->getName(), ['ward.ward-details', 'site.stranded_patients']))
                            $('#homepage_id').attr('href', '#');
                            $('#homepage_id').attr('onclick', "CloseBoardRound('{{ $success_array['ward_details']['ward_url_name'] }}')");

                        @endif

                }

            },
            error: function(textStatus, errorThrown) {
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    }
    GetWardStatus();


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

    function GenerateBrowserID() {
        return Math.random().toString(36).substring(2) + Date.now().toString(36);
    }
    function WardSummaryPatientBoardRound(camis_patient_id) {
        var token = "{{ csrf_token() }}";
        $(".camis_patient_ward_summary_boardround_modal_content").html($(".ward_summary_dummy_modal_for_loader_content").html());
        $('#camis_patient_ward_summary_boardround_modal').modal({
            backdrop: 'static'
        });

        var url_summery = '{{ route('GetPatientDetailsInformationSummary') }}';
        $.ajax({
            url: url_summery,
            type: 'POST',
            data: {
                "_token": token,
                "camis_patient_id": camis_patient_id
            },
            success: function(result) {

                let browser_id = localStorage.getItem('browser_id');
                if (!browser_id) {
                    browser_id = GenerateBrowserID();
                    localStorage.setItem('browser_id', browser_id);
                }

                var url = "{{ route('CheckedLockedStatus') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "camis_patient_id": camis_patient_id,
                        "browser_id": browser_id
                    },
                    success: function(result) {
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
                            $('#allowed_to_be_moved').removeClass('click_popup_open_ibox_board_round_allowed_to_move');
                            $(".wardboxPopupModalHead").css("background-color", "red");
                            function executeWardSummaryPatientBoardRound() {
                                $(".wardboxPopupModalHead").css("background-color", "#13bec1");
                                $("#lock_all_image").addClass("content_display_none");
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
                            $('#allowed_to_be_moved').addClass('click_popup_open_ibox_board_round_allowed_to_move');
                        }
                    }
                });


                $(".camis_patient_ward_summary_boardround_modal_content").html(result);
                $('.button_ward_summary_boardround_next_patient').removeClass('bottom-next-button');
                $('.button_ward_summary_boardround_next_patient').addClass('bottom-next-button-disabled');
                $('.button_ward_summary_boardround_prev_patient').removeClass('bottom-prev-button');
                $('.button_ward_summary_boardround_prev_patient').addClass('bottom-prev-button-disabled');
                var next_patient = $('#ward_summary_boardround_modal_popup_camis_patient_id_next').val();
                var prev_patient = $('#ward_summary_boardround_modal_popup_camis_patient_id_prev').val();

                $('#ward_summary_boardround_modal_popup_camis_patient_id').val(camis_patient_id);
                $(document).on('click', '.careRequermentWrap', function(event) {
                    console.log('s');
                    $('.careRequermentWrap *').prop('disabled', true);
                    toastr.error('This Option Can Only Be Modified From Discharge Tracker.', 'Opps!');
                });


                if (next_patient != '') {
                    $('.button_ward_summary_boardround_next_patient').removeClass('bottom-next-button-disabled');
                    $('.button_ward_summary_boardround_next_patient').addClass('bottom-next-button');
                }
                if (prev_patient != '') {
                    $('.button_ward_summary_boardround_prev_patient').removeClass('bottom-prev-button-disabled');
                    $('.button_ward_summary_boardround_prev_patient').addClass('bottom-prev-button');
                }
            }
        });
    }



    function GetFlagImageBySlug(flag_name) {
        var flag = flag_name.replace('ibox_patient_flag_', '', flag_name);

        return flag;
    }



    function checkbox_pain_analgesia() {
        if ($("#handover_pain_analgesia").is(":checked")) {
            $("#handover_pain_analgesia").val(1);
            $('#refer-to-epma').css('display','block');
        } else {
            $("#handover_pain_analgesia").val(0);
            $('#refer-to-epma').css('display','none');
        }
    }




</script>
<script>
    $(document).ready(function() {
        let intervalId;
        let timerRunning = false;
        function formatTime(seconds) {
            let hours = Math.floor(seconds / 3600);
            let minutes = Math.floor((seconds % 3600) / 60);
            let secs = seconds % 60;

            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }

        function timerExpired() {
            $('#timer_container').addClass('d-none');
            timerRunning = false;
        }

        function startTimer(durationInSeconds) {
            let timer = durationInSeconds;

            let intervalId = setInterval(function () {
                $('#countdown').text(formatTime(timer));

                if (--timer < 0) {
                    clearInterval(intervalId);
                    timerExpired();
                    intervalId = null;
                    timerRunning = false;
                }
            }, 1000);
            timerRunning = true;
        }

        $('#start_timer').on('click', function() {
            if($('.timer_countdown').hasClass('d-none')){
                $('#timer_container').removeClass('d-none');

                let duration = 10 * 60;

                startTimer(duration);
            } else {
                toastr.warning('Refresh Is Already Freeze');
            }


        });
    });
</script>




