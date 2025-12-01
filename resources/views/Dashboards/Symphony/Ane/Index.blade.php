@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Accident & Emergency')
@section('page-top-title', 'Accident & Emergency')
@section('page-top-title-sub', 'autotimer')
@section('ane-css')
<link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Normalise.css') }}" crossorigin="anonymous">
@endsection
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/ANESankey.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/SwitchSelection.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Ane.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/EdThermometerPopup.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/AneCustom.css') }}" crossorigin="anonymous">
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/d3.v7.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/Moment.js') }}"></script>
    <style>
     .bars-black {
        background: url({{ asset('asset_v2') }}/Ibox/Images/icons/black-bars.svg);
        height: 1.34rem;
    }


    </style>
@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Symphony.Ane.Modals')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
        @include('Dashboards.Symphony.Ane.IndexDataLoad')
    </div>
    @include('Dashboards.Symphony.Ane.EDSafetyThermoMeter')
@endsection
@push('custom-script')
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        function radioupdate(val) {
            $("#ane_ed_opel_status_radio").val(val);
        }
        $('.opel .opeldata').click(function() {
            $(this).parent().find('.opeldata').removeClass('selected');
            $(this).parent().find('i').addClass('d-none');
            $(this).addClass('selected');
            var val = $(this).attr('data-value');
            $('#ane_ed_opel_status_data').val(val);
            $(this).find('i').removeClass('d-none');
        });
        var ajax_refresh_url = "{{ url('/ane/dashboards/accident-and-emergency/content-data-load') }}";
        $(window).resize(function() {
            setTimeout(function() {
                SetDTASectionScrollWidthHeight();
            }, 2000);
        });

        function CommonJsFunctionCallAfterContentRefersh() {
            SetDTASectionScrollWidthHeight();
        }


        $(document).on('click', '.click_open_sau_offcanvas', function(e) {
            var token = "{{ csrf_token() }}";
            CommonDisableEnableOnOpen();
            DisableButtonClickForPreventFurtherEvent('click_open_sau_offcanvas');
            $('#sau_attendence_details').html('');
            var title = $(this).data('title');
            var type = $(this).data('type');
            $('#patient_to_ward_title').html(title);
            var sau_patients_list_modal = new bootstrap.Offcanvas(document.getElementById('symphony_sau_attendance_id_patient_details'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });

            sau_patients_list_modal.show();
            if(type != ''){
                var url = "{{ route('GetSauPatient') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "type": type,
                    },
                    success: function(result) {
                        if (typeof result != '') {

                            $('#sau_attendence_details').html(result);
                            DisableLoaderAndMakeVisibleInnerBody();
                        } else {
                            CloseOffcanvas('symphony_sau_attendance_id_patient_details');
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                    error: function(textStatus, errorThrown) {
                        CloseOffcanvas('symphony_sau_attendance_id_patient_details');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CloseOffcanvas('symphony_sau_attendance_id_patient_details');
            }
        });

        function SetDTASectionScrollWidthHeight() {
            var displayWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            var bar_graph_height_total = $("#ImagePosition").height();

           var total = bar_graph_height_total -3;

            var barGraphTop = 5;

            if (displayWidth < 1400) {
                total = 552;
            }

            $('#BarGraphWrap').css({

                'top': barGraphTop + 'px'
            });

            $(".ane-content").height(total - 27);

            if (displayWidth <= 1550) {
                $(".ane-content").height(total - 27);
            }

            if (displayWidth <= 1400) {
                $(".ane-content").height(total - 19);
            }

            if (displayWidth <= 992) {
                $(".ane-content").height('auto');
            }

            var avail_inner_window_width = window.innerWidth;
            var bar_height_total_for_main = total + 17;
            var bar_max_height_total_for_main = total + 27;

            if (avail_inner_window_width < 992) {
                bar_height_total_for_main = 'auto';
            } else {
                bar_height_total_for_main = total + 'px';
            }
            $("#ane_graph_height").height(bar_height_total_for_main);



            if (bar_graph_height_total < 150) {
                setTimeout(function() {
                    SetDTASectionScrollWidthHeight();
                }, 100);
            }
        }

        /********************** ANE Dashboard Functions ***************************/
        $(document).ready(function() {
            setInterval(function() {
                var time_to_update = moment().format("dddd Do MMMM HH:mm");
                $(".page-sub-head-ibox-margin-interver-insert").html(time_to_update);
            }, 30000);
            $(document).on('click', '.ane_dta_comments_modal', function(e) {
                var ane_dta_attendance_id = $(this).data('ane-dta-attendance-id');
                $('.hide-on-first-load').css("display", "table");
                $("#ane_dta_comments_attendance_id").val("");
                $("#ane_dta_user_comments").val("");
                $('#ane_dta_comments_delete_button').addClass("bottom-delete-button-disabled");
                $("#ane_dta_comments_delete_button").removeClass("bottom-delete-button");

                DisableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                DisableDeleteButtonForModals();
                DisableDeleteButtonLoadImageForModals();
                ShowModalFooterButtonForClick();

                if (ane_dta_attendance_id != "") {
                    var token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ url('/ane/dashboards/accident-and-emergency/ane-dta-comment-details') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "ane_dta_attendance_id": ane_dta_attendance_id
                        },
                        success: function(result) {
                            if(result != '{{PermissionDenied()}}'){
                                $("#ane_dta_comments_attendance_id").val(ane_dta_attendance_id);
                                if (result.return_status_check != "empty") {
                                    $("#ane_dta_user_comments").val(result.ane_dta_user_comments);
                                    EnableDeleteButtonForModals();
                                } else {
                                    DisableDeleteButtonForModals();
                                }
                                EnableSaveButtonForModals();
                                $('.hide-on-first-load').css("display", "none");

                                $("#ane_dta_comments").modal({
                                    show: false,
                                    backdrop: 'static'
                                });
                                $("#ane_dta_comments").modal("show");
                            } else {
                                $('.hide-on-first-load').css("display", "none");
                                $("#permission_modal").modal("show");
                            }
                        },
                        error: function(textStatus, errorThrown) {
                            $('.hide-on-first-load').css("display", "none");
                            $("#common_error_modal_show").modal("show");
                        }
                    });
                }
            });


            $(document).on('click', '.ane_dta_comments_save', function(e) {
                var ane_dta_attendance_id = $("#ane_dta_comments_attendance_id").val();
                var ane_dta_user_comments = $("#ane_dta_user_comments").val();

                EnableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                HideModalFooterButtonForClick();

                if (ane_dta_attendance_id != "") {
                    if (ane_dta_user_comments != "") {
                        DisableDeleteButtonForModals();
                        var token = "{{ csrf_token() }}";
                        $.ajax({
                            url: "{{ url('/ane/dashboards/accident-and-emergency/ane-dta-comment-save') }}",
                            type: 'POST',
                            data: {
                                "_token": token,
                                "ane_dta_attendance_id": ane_dta_attendance_id,
                                "ane_dta_user_comments": ane_dta_user_comments
                            },
                            success: function(result) {
                                if(result != '{{PermissionDenied()}}'){
                                    if (typeof result.message !== 'undefined') {
                                        $(".popup_alert_response_show_div").html(
                                            '<div class="alert alert-success ibox_alert_styles" role="alert">' +
                                            result.message + '</div>');
                                        $(".popup_alert_response_show_div").fadeTo(1000, 500)
                                            .slideUp(500, function() {
                                                $(".popup_alert_response_show_div").slideUp(
                                                500);
                                                $(".popup_alert_response_show_div").html('');
                                                $("#ane_dta_comments").modal('hide');
                                                $("#ane_dta_comments_attendance_id").val("");
                                                $("#ane_dta_user_comments").val("");
                                                $('#add_button_' + ane_dta_attendance_id).text(
                                                    'Edit');
                                                if (typeof result.ane_dta_user_comments !==
                                                    'undefined') {
                                                    $(".ane_dta_comment_show_section_text_description_" +
                                                        ane_dta_attendance_id).html(result
                                                        .ane_dta_user_comments);
                                                }
                                                $('.ane_dta_comment_show_section_' +
                                                    ane_dta_attendance_id).css("display",
                                                    "flex");
                                                $('.ane_dta_comments_insert_add_button_' +
                                                    ane_dta_attendance_id).css("display",
                                                    "none");

                                            });
                                        DisableSaveButtonLoadImageForModals();
                                        DisableSaveButtonForModals();
                                        DisableDeleteButtonForModals();
                                        ShowModalFooterButtonForClick();
                                    } else {
                                        $(".popup_alert_response_show_div").html(
                                            '<div class="alert alert-danger ibox_alert_styles" role="alert">' +
                                            script_error_message + '</div>');
                                        $(".popup_alert_response_show_div").fadeTo(2000, 500)
                                            .slideUp(500, function() {
                                                $(".popup_alert_response_show_div").slideUp(
                                                500);
                                                $(".popup_alert_response_show_div").html('');

                                                DisableSaveButtonLoadImageForModals();
                                                EnableSaveButtonForModals();
                                                EnableDeleteButtonForModals();
                                                ShowModalFooterButtonForClick();
                                            });
                                    }
                                } else {
                                    CommonLoginModalPopupOpenOnRequest();
                                }
                            },
                            error: function(textStatus, errorThrown) {
                                $(".popup_alert_response_show_div").html(
                                    '<div class="alert alert-danger ibox_alert_styles" role="alert">' +
                                    script_error_message + '</div>');
                                $(".popup_alert_response_show_div").fadeTo(2000, 500).slideUp(
                                    500,
                                    function() {
                                        $(".popup_alert_response_show_div").slideUp(500);
                                        $(".popup_alert_response_show_div").html('');

                                        DisableSaveButtonLoadImageForModals();
                                        EnableSaveButtonForModals();
                                        EnableDeleteButtonForModals();
                                        ShowModalFooterButtonForClick();
                                    });
                            }
                        });
                    } else {

                        $(".popup_alert_response_show_div").html(
                            '<div class="alert alert-danger ibox_alert_styles" role="alert">Please Enter Valid Comment</div>'
                            );
                        $(".popup_alert_response_show_div").fadeTo(2000, 500).slideUp(500, function() {
                            $(".popup_alert_response_show_div").slideUp(500);
                            $(".popup_alert_response_show_div").html('');

                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            ShowModalFooterButtonForClick();
                        });
                    }
                } else {
                    $(".popup_alert_response_show_div").html(
                        '<div class="alert alert-danger ibox_alert_styles" role="alert">' +
                        script_error_message + '</div>');
                    $(".popup_alert_response_show_div").fadeTo(2000, 500).slideUp(500, function() {
                        $(".popup_alert_response_show_div").slideUp(500);
                        $(".popup_alert_response_show_div").html('');

                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        EnableDeleteButtonForModals();
                        ShowModalFooterButtonForClick();
                    });
                }
            });



            $(document).on('click', '.ane_dta_comments_delete', function(e) {
                DisableSaveButtonForModals();
                DisableDeleteButtonForModals();
                EnableDeleteButtonLoadImageForModals();
                HideModalFooterButtonForClick();
                var ane_dta_attendance_id = $("#ane_dta_comments_attendance_id").val();
                $("#ane_dta_comments_delete_attendance_id").val("");
                $("#ane_dta_user_comments_delete").val("");

                if (ane_dta_attendance_id != "") {
                    var token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ url('/ane/dashboards/accident-and-emergency/ane-dta-comment-details') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "ane_dta_attendance_id": ane_dta_attendance_id
                        },
                        success: function(result) {
                            @if(CheckSpecificPermission('dta_comment_delete'))
                                $("#ane_dta_comments_delete_attendance_id").val($(
                                    "#ane_dta_comments_attendance_id").val());
                                if (result.return_status_check != "empty") {
                                    $("#ane_dta_user_comments_delete").val(result
                                        .ane_dta_user_comments);
                                    $("#ane_dta_comments_delete").modal({
                                        show: false,
                                        backdrop: 'static'
                                    });
                                    $("#ane_dta_comments_delete").modal("show");
                                    setTimeout(function() {

                                        $("#ane_dta_comments").modal("hide");

                                    }, 500);
                                    EnableDeleteButtonForModals();
                                    DisableSaveButtonLoadImageForModals();
                                    DisableDeleteButtonLoadImageForModals();
                                    ShowModalFooterButtonForClick();
                                } else {
                                    DisableDeleteButtonForModals();
                                    DisableSaveButtonLoadImageForModals();
                                    DisableDeleteButtonLoadImageForModals();
                                    ShowModalFooterButtonForClick();
                                }
                            @else
                                CommonLoginModalPopupOpenOnRequest();
                            @endif
                        },
                        error: function(textStatus, errorThrown) {
                            $("#common_error_modal_show").modal("show");
                            EnableDeleteButtonForModals();
                            DisableSaveButtonLoadImageForModals();
                            DisableDeleteButtonLoadImageForModals();
                            ShowModalFooterButtonForClick();
                        }
                    });
                } else {
                    $(".popup_alert_response_show_div").html(
                        '<div class="alert alert-danger ibox_alert_styles" role="alert">' +
                        script_error_message + '</div>');
                    $(".popup_alert_response_show_div").fadeTo(2000, 500).slideUp(500, function() {
                        $(".popup_alert_response_show_div").slideUp(500);
                        $(".popup_alert_response_show_div").html('');

                        DisableSaveButtonLoadImageForModals();
                        DisableDeleteButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        EnableDeleteButtonForModals();
                        ShowModalFooterButtonForClick();
                    });
                }
            });


            $(document).on('click', '.ane_dta_comments_delete_confirm', function(e) {
                EnableDeleteButtonLoadImageForModals();
                DisableDeleteButtonForModals();
                HideModalFooterButtonForClick();
                var ane_dta_attendance_id = $("#ane_dta_comments_delete_attendance_id").val();
                if (ane_dta_attendance_id != "") {
                    var token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ url('/ane/dashboards/accident-and-emergency/ane-dta-comment-delete') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "ane_dta_attendance_id": ane_dta_attendance_id
                        },
                        success: function(result) {
                            @if(CheckSpecificPermission('dta_comment_delete'))
                                if (typeof result.message !== 'undefined') {
                                    DisableDeleteButtonLoadImageForModals();
                                    $(".popup_alert_response_show_div").html(
                                        '<div class="alert alert-success ibox_alert_styles" role="alert">' +
                                        result.message + '</div>');

                                    $(".popup_alert_response_show_div").fadeTo(1000, 500).slideUp(
                                        500,
                                        function() {
                                            $(".popup_alert_response_show_div").slideUp(500);
                                            $(".popup_alert_response_show_div").html('');

                                            $("#ane_dta_comments_delete").modal('hide');

                                            $("#ane_dta_comments_delete_attendance_id").val("");
                                            $("#ane_dta_user_comments_delete").val("");
                                            $('#add_button_' + ane_dta_attendance_id).text(
                                                'ADD');
                                            $(".ane_dta_comment_show_section_text_description_" +
                                                ane_dta_attendance_id).html("Add Comment");
                                            $('.ane_dta_comment_show_section_' +
                                                ane_dta_attendance_id).css("display",
                                                "none");
                                            $('.ane_dta_comments_insert_add_button_' +
                                                ane_dta_attendance_id).css("display",
                                                "block");
                                            DisableDeleteButtonLoadImageForModals();
                                            ShowModalFooterButtonForClick();
                                        });
                                } else {
                                    DisableDeleteButtonLoadImageForModals();
                                    EnableDeleteButtonForModals();
                                    ShowModalFooterButtonForClick();
                                    $(".popup_alert_response_show_div").html(
                                        '<div class="alert alert-danger ibox_alert_styles" role="alert">' +
                                        script_error_message + '</div>');
                                    $(".popup_alert_response_show_div").fadeTo(2000, 500).slideUp(
                                        500,
                                        function() {
                                            $(".popup_alert_response_show_div").slideUp(500);
                                            $(".popup_alert_response_show_div").html('');
                                        });
                                }
                            @else
                                CommonLoginModalPopupOpenOnRequest();
                            @endif
                        },
                        error: function(textStatus, errorThrown) {
                            DisableDeleteButtonLoadImageForModals();
                            EnableDeleteButtonForModals();
                            ShowModalFooterButtonForClick();
                            $(".popup_alert_response_show_div").html(
                                '<div class="alert alert-danger ibox_alert_styles" role="alert">' +
                                script_error_message + '</div>');
                            $(".popup_alert_response_show_div").fadeTo(2000, 500).slideUp(500,
                                function() {
                                    $(".popup_alert_response_show_div").slideUp(500);
                                    $(".popup_alert_response_show_div").html('');
                                });
                        }
                    });
                }
            });

            $(document).on('click', '.ane_status_opel_modal', function(e) {
                $('.hide-on-first-load').css("display", "table");
                $("#ane_ed_opel_status_data").val(1);
                $("#ane_ed_opel_status_comment").val("");
                $(".ane_ed_opel_button").removeClass("active");
                $("#ane_ed_opel_status_0").prop("checked", true);
                $("#ane_ed_opel_status_data").val(0);
                $(".ane_ed_opel_status_updated_date_time").html("");
                $("#ane_ward_opel_status_data").val(1);
                $("#ane_ward_opel_status_comment").val("");
                $(".ane_ward_opel_button").removeClass("active");
                $("#ane_ward_opel_status_0").prop("checked", true);
                $("#ane_ward_opel_status_data").val(0);
                $(".ane_ward_opel_status_updated_date_time").html("");

                $(".ane_opel_status_data_tab_class").removeClass("active");
                $(".ane_opel_status_data_tab_class").removeClass("show");
                $(".ane_opel_status_data_tab_details_class").removeClass("active");
                $(".ane_opel_status_data_tab_details_class").removeClass("show");

                $(".ane_opel_ed_status_data_tab").addClass("active");
                $(".ane_opel_ed_status_data_tab").addClass("show");

                $(".ane_opel_ed_status_data").addClass("active");
                $(".ane_opel_ed_status_data").addClass("show");

                DisableSaveButtonLoadImageForModals();
                DisableDeleteButtonLoadImageForModals();
                EnableSaveButtonForModals();
                EnableDeleteButtonForModals();
                ShowModalFooterButtonForClick();
                DisableButtonClickForPreventFurtherEvent('ane_status_opel_modal');
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ url('/ane/dashboards/accident-and-emergency/ane-opel-data-details') }}",
                    type: 'POST',
                    data: {
                        "_token": token
                    },
                    success: function(result) {
                        if(result != '{{PermissionDenied()}}'){
                            if (result.return_status_check != "empty") {
                                /* if (typeof result.ane_ed_opel_status_data_type !== 'undefined') {
                                    if (result.ane_ed_opel_status_data_type == 1) {
                                        $("#ane_ed_opel_status_data").val(result
                                            .ane_ed_opel_status_data);
                                        $("#ane_ed_opel_status_comment").val(result
                                            .ane_ed_opel_status_data_comment);


                                        $(".opel_tick_" + result.ane_ed_opel_status_data).removeClass("content_display_none");
                                        $("#ane_ed_opel_show_status_1").removeClass("active");
                                        $("#ane_ed_opel_show_status_0").removeClass("active");
                                        $(".ane_ed_opel_show_status_val_" + result
                                            .ane_ed_opel_status_data_show_status).addClass("active");
                                        $(".ane_ed_opel_status_updated_date_time").html(result
                                            .ane_ed_opel_status_data_updated_date_time_update_show
                                        );
                                    }
                                } */
                                if (typeof result.ane_ward_opel_status_data_type !== 'undefined') {
                                    if (result.ane_ward_opel_status_data_type == 2) {
                                        $("#ane_ward_opel_status_data").val(result.ane_ward_opel_status_data);
                                        $("#ane_ward_opel_status_comment").val(result.ane_ward_opel_status_data_comment);
                                        $(".ane_ward_opel_button").removeClass("active");
                                        $(".opel_ward_tick_" + result.ane_ward_opel_status_data).removeClass("content_display_none");

                                        $("#ane_ward_opel_show_status_1").removeClass("active");
                                        $("#ane_ward_opel_show_status_0").removeClass("active");
                                        $(".ane_ward_opel_show_status_val_" + result
                                            .ane_ward_opel_status_data_show_status).addClass("active");

                                        $(".ane_ward_opel_button_" + result.ane_ward_opel_status_data).addClass("active");
                                        $(".ane_ward_opel_status_updated_date_time").html(result
                                            .ane_ward_opel_status_data_updated_date_time_update_show
                                        );
                                    }
                                }
                            }
                            $('.hide-on-first-load').css("display", "none");

                        } else {
                            CommonLoginModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        $('.hide-on-first-load').css("display", "none");
                        $("#common_error_modal_show").modal("show");

                    }
                });
            });

            $(document).on('click', '.ane_ed_opel_button', function(e) {
                var opel_value = $(this).data('ane-ed-opel-button-value');

                if (opel_value != "") {
                    $(".opel_checkbox").addClass("content_display_none");
                    $(".opel_tick_" + opel_value).removeClass("content_display_none");
                    $("#ane_ed_opel_status_data").val(opel_value);
                }
            });

            $(document).on('click', '.ane_ward_opel_button', function(e) {
                var opel_value = $(this).data('ane-ward-opel-button-value');
                if (opel_value != "") {
                    $(".opel_ward_checkbox").addClass("content_display_none");
                    $(".opel_ward_tick_" + opel_value).removeClass("content_display_none");
                    $("#ane_ward_opel_status_data").val(opel_value);
                }
            });

            $(document).on('click', '#ane_ed_opel_show_status_0', function(e) {

                $("#ane_ed_opel_show_status_1").removeClass("active");
                $("#ane_ed_opel_show_status_0").removeClass("active");
                $(".ane_ed_opel_show_status_val_0").addClass("active");

            });

            $(document).on('click', '#ane_ed_opel_show_status_1', function(e) {

                $("#ane_ed_opel_show_status_1").removeClass("active");
                $("#ane_ed_opel_show_status_0").removeClass("active");
                $(".ane_ed_opel_show_status_val_1").addClass("active");

            });


            $(document).on('click', '#ane_ward_opel_show_status_0', function(e) {

                $("#ane_ward_opel_show_status_1").removeClass("active");
                $("#ane_ward_opel_show_status_0").removeClass("active");
                $(".ane_ward_opel_show_status_val_0").addClass("active");

            });

            $(document).on('click', '#ane_ward_opel_show_status_1', function(e) {

                $("#ane_ward_opel_show_status_1").removeClass("active");
                $("#ane_ward_opel_show_status_0").removeClass("active");
                $(".ane_ward_opel_show_status_val_1").addClass("active");

            });

            $(document).on('click', '.ane_opel_status_data_save', function(e) {
                EnableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                HideModalFooterButtonForClick();


                var ane_ward_opel_status_data = $("#ane_ward_opel_status_data").val();
                var ane_ward_opel_status_comment = $("#ane_ward_opel_status_comment").val();
                var ane_ward_opel_status_data_show_status = 0;

                if ($("#ane_ward_opel_show_status_0").hasClass("active")) {
                    ane_ward_opel_status_data_show_status = 0;
                }
                if ($("#ane_ward_opel_show_status_1").hasClass("active")) {
                    ane_ward_opel_status_data_show_status = 1;
                }

                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ url('/ane/dashboards/accident-and-emergency/ane-opel-data-details-save') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "ane_ward_opel_status_data": ane_ward_opel_status_data,
                        "ane_ward_opel_status_comment": ane_ward_opel_status_comment,
                        "ane_ward_opel_status_data_show_status": ane_ward_opel_status_data_show_status
                    },
                    success: function(result) {
                        if(result != '{{PermissionDenied()}}'){
                            if (typeof result.message !== 'undefined') {
                                $(".popup_alert_response_show_div").html(
                                    '<div class="alert alert-success ibox_alert_styles" role="alert">' +
                                    result.message + '</div>');
                            }
                            $(".popup_alert_response_show_div").fadeTo(1000, 500).slideUp(500,
                                function() {
                                    $(".popup_alert_response_show_div").slideUp(500);
                                    $(".popup_alert_response_show_div").html('');
                                    /* if (ane_ed_opel_status_data_show_status == 1) {
                                        $("#opel_current").html(ane_ed_opel_status_data);
                                        document.getElementById('theImage').src =
                                            "/asset_v2/Template/images/opel_" +
                                            ane_ed_opel_status_data + ".png";
                                    } else {
                                        $("#opel_current").html('&nbsp;');
                                        document.getElementById('theImage').src =
                                            "/asset_v2/Template/images/opel_0.png";
                                    } */
                                    $('.hide-on-first-load').css("display", "none");
                                    $("#ane_status_opel_modal").modal('hide');

                                    ShowModalFooterButtonForClick();
                                });
                        } else {
                            CommonLoginModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        $('.hide-on-first-load').css("display", "none");
                        $("#common_error_modal_show").modal("show");
                        $(".popup_alert_response_show_div").html(
                            '<div class="alert alert-danger ibox_alert_styles" role="alert">' +
                            script_error_message + '</div>');
                        $(".popup_alert_response_show_div").fadeTo(2000, 500).slideUp(500,
                            function() {
                                $(".popup_alert_response_show_div").slideUp(500);
                                $(".popup_alert_response_show_div").html('');
                            });
                        ShowModalFooterButtonForClick();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).on('click', '.click_open_ane_new_opel', function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_ane_new_opel');
            $('#requestStageOne').modal('show');
            if ($.trim($('#content_opel_modal_one').html()) === '') {
                EnableLoaderAndMakeHiddenInnerBody();
                setTimeout(function () {
                    var url = "{{ route('ane.opel.data.load.stage.one') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': token
                        },
                        success: function(result) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            $('#content_opel_modal_one').html(result);
                        },
                        error: function(textStatus, errorThrown) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();
                            CommonErrorModalPopupOpenOnRequest();
                            $('#navigationModal').modal('show');
                            $('#requestStageOne').modal('hide');
                        }
                    });
                }, 500);
            }
        });

        $(document).on('click', '.click_open_ane_new_opel_second', function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_ane_new_opel_second');
            var completed_by = $('#ane_opel_stage_one_completed_by').val();
            var patient_in_ed = $('#ane_opel_stage_one_no_patients_in_ed').val();
            var patient_awaiting_bed = $('#ane_opel_stage_one_no_patients_awaiting_bed').val();

            if(completed_by == '' || patient_in_ed =='' || patient_awaiting_bed == ''){
                if(completed_by == ''){
                    $('#ane_opel_stage_one_completed_by').addClass('is-invalid');
                }
                if(patient_in_ed == ''){
                    $('#ane_opel_stage_one_no_patients_in_ed').addClass('is-invalid');
                }
                if(patient_awaiting_bed == ''){
                    $('#ane_opel_stage_one_no_patients_awaiting_bed').addClass('is-invalid');
                }

                toastr.warning('Some Field Is Missing');
                return;
            }

            $('#requestStageOne').modal('hide');
            $('#requestStageTwo').modal('show');
            if ($.trim($('#content_opel_modal_two').html()) === '') {
                EnableLoaderAndMakeHiddenInnerBody();
                CommonDisableEnableOnOpen();
                setTimeout(function () {
                    var url = "{{ route('ane.opel.data.load.stage.two') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': token
                        },
                        success: function(result) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();
                            $('#content_opel_modal_two').html(result);
                            $('.patient_input:not([readonly])').val(0);

                        },
                        error: function(textStatus, errorThrown) {
                            $('#requestStageOne').modal('show');
                            $('#requestStageTwo').modal('hide');
                            DisableLoaderAndMakeVisibleInnerBody();
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                }, 500);
            }
        });

        $(document).on('click', '.click_open_ane_new_opel_three', function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_ane_new_opel_three');
            $('#requestStageTwo').modal('hide');
            $('#requestStageThree').modal('show');
            if ($.trim($('#content_opel_modal_three').html()) === '') {
                $('.ed_thermometer_selected_date').html($('#ed_opel_date').html());
                EnableLoaderAndMakeHiddenInnerBody();
                CommonDisableEnableOnOpen();
                setTimeout(function () {
                    var url = "{{ route('ane.opel.data.load.stage.three') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': token
                        },
                        success: function(result) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();

                            $('#content_opel_modal_three').html(result);
                        },
                        error: function(textStatus, errorThrown) {
                            $('#requestStageTwo').modal('show');
                            $('#requestStageThree').modal('hide');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                }, 500);
            }

        });


        $(document).on('click', '.click_open_ane_new_opel_four', function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_ane_new_opel_four');
            $('#requestStageThree').modal('hide');
            $('#requestStageFour').modal('show');
            if ($.trim($('#content_opel_modal_four').html()) === '') {
                $('.ed_thermometer_selected_date').html($('#ed_opel_date').html());
                EnableLoaderAndMakeHiddenInnerBody();
                CommonDisableEnableOnOpen();
                setTimeout(function () {
                    var url = "{{ route('ane.opel.data.load.stage.four') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': token
                        },
                        success: function(result) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();

                            $('#content_opel_modal_four').html(result);
                        },
                        error: function(textStatus, errorThrown) {
                            $('#requestStageThree').modal('show');
                            $('#requestStageFour').modal('hide');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                }, 500);
            }

        });

        $(document).on('click', '.click_open_ane_new_opel_five', function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_ane_new_opel_five');
            $('#requestStageFour').modal('hide');
            $('#requestStageFive').modal('show');
            if ($.trim($('#content_opel_modal_five').html()) === '') {
                $('.ed_thermometer_selected_date').html($('#ed_opel_date').html());
                EnableLoaderAndMakeHiddenInnerBody();
                CommonDisableEnableOnOpen();
                setTimeout(function () {
                    var url = "{{ route('ane.opel.data.load.stage.five') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': token
                        },
                        success: function(result) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();

                            $('#content_opel_modal_five').html(result);
                        },
                        error: function(textStatus, errorThrown) {
                            $('#requestStageFive').modal('show');
                            $('#requestStageFour').modal('hide');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                }, 500);
            }

        });


        $(document).on('click', '.click_open_ane_new_opel_six', function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_ane_new_opel_six');
            $('#requestStageFive').modal('hide');
            $('#requestStageSix').modal('show');
            if ($.trim($('#content_opel_modal_six').html()) === '') {
                $('.ed_thermometer_selected_date').html($('#ed_opel_date').html());
                EnableLoaderAndMakeHiddenInnerBody();
                CommonDisableEnableOnOpen();
                setTimeout(function () {
                    var url = "{{ route('ane.opel.data.load.stage.six') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': token
                        },
                        success: function(result) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();

                            $('#content_opel_modal_six').html(result);
                        },
                        error: function(textStatus, errorThrown) {
                            $('#requestStageFive').modal('show');
                            $('#requestStageSix').modal('hide');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                }, 500);
            }

        });

        $(document).on('click', '.click_open_ane_new_opel_seven', function(e) {
            var token = "{{ csrf_token() }}";
            DisableButtonClickForPreventFurtherEvent('click_open_ane_new_opel_seven');
            $('#requestStageSix').modal('hide');
            $('#requestStageSeven').modal('show');

            DisableSaveButtonLoadImageForModals();
            if ($.trim($('#content_opel_modal_seven').html()) === '') {
                $('.ed_thermometer_selected_date').html($('#ed_opel_date').html());
                EnableLoaderAndMakeHiddenInnerBody();
                CommonDisableEnableOnOpen();
                setTimeout(function () {
                    var url = "{{ route('ane.opel.data.load.stage.seven') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': token
                        },
                        success: function(result) {
                            DisableLoaderAndMakeVisibleInnerBody();
                            EnableSaveButtonForModals();

                            $('#content_opel_modal_seven').html(result);
                            let overall_perform_without_perc = parseFloat($('#overall_performance').html().replace('%', '').trim());
                            let overall_perform = $('#overall_performance').html();
                            $('#current_number_of_breaches').val($('#number_of_breach').html());
                            $('#four_hour_performance_of_the_day').val(overall_perform);
                            let inflow_data = {};
                            let acuity_data = {};
                            let outflow_data = {};

                            $('[name^="inflow["]').filter(':input').each(function () {
                                let inflow_name = $(this).attr('name');
                                let inflow_match = inflow_name.match(/^inflow\[(.*?)\]\[(.*?)\]$/);

                                if (inflow_match && inflow_match[1] && inflow_match[2]) {
                                    let inflow_category = inflow_match[1].trim();
                                    let inflow_key = inflow_match[2].trim();

                                    if (!inflow_data[inflow_category]) inflow_data[inflow_category] = {};
                                    inflow_data[inflow_category][inflow_key] = $(this).val();
                                }
                            });

                            $('[name^="acuity["]').filter(':input').each(function () {
                                let acuity_name = $(this).attr('name');
                                let acuity_match = acuity_name.match(/^acuity\[(.*?)\]\[(.*?)\]$/);

                                if (acuity_match && acuity_match[1] && acuity_match[2]) {
                                    let acuity_category = acuity_match[1].trim();
                                    let acuity_key = acuity_match[2].trim();

                                    if (!acuity_data[acuity_category]) acuity_data[acuity_category] = {};
                                    acuity_data[acuity_category][acuity_key] = $(this).val();
                                }
                            });

                            $('[name^="outflow["]').filter(':input').each(function () {
                                let outflow_name = $(this).attr('name');
                                let outflow_match = outflow_name.match(/^outflow\[(.*?)\]\[(.*?)\]$/);

                                if (outflow_match && outflow_match[1] && outflow_match[2]) {
                                    let outflow_category = outflow_match[1].trim();
                                    let outflow_key = outflow_match[2].trim();

                                    if (!outflow_data[outflow_category]) outflow_data[outflow_category] = {};
                                    outflow_data[outflow_category][outflow_key] = $(this).val();
                                }
                            });

                            let inflow_color_counts = {
                                green: 0,
                                amber: 0,
                                red: 0,
                                black: 0
                            };

                            const inflow_opel_group = {
                                "1": "green",
                                "2": "amber",
                                "3": "red",
                                "4": "black"
                            };

                            let acuity_color_counts = {
                                green: 0,
                                amber: 0,
                                red: 0,
                                black: 0
                            };

                            const acuity_opel_group = {
                                "1": "green",
                                "2": "amber",
                                "3": "red",
                                "4": "black"
                            };

                            let outflow_color_counts = {
                                green: 0,
                                amber: 0,
                                red: 0,
                                black: 0
                            };

                            const outflow_opel_group = {
                                "1": "green",
                                "2": "amber",
                                "3": "red",
                                "4": "black"
                            };

                            for (let inflow_category in inflow_data) {
                                if (inflow_data[inflow_category].hasOwnProperty("opel")) {
                                    let inflow_opel_value = inflow_data[inflow_category]["opel"];
                                    let inflow_mapped_color = inflow_opel_group[inflow_opel_value];

                                    if (inflow_mapped_color && inflow_color_counts.hasOwnProperty(inflow_mapped_color)) {
                                        inflow_color_counts[inflow_mapped_color]++;
                                    }
                                }
                            }

                            for (let acuity_category in acuity_data) {
                                if (acuity_data[acuity_category].hasOwnProperty("opel")) {
                                    let acuity_opel_value = acuity_data[acuity_category]["opel"];
                                    let acuity_mapped_color = acuity_opel_group[acuity_opel_value];

                                    if (acuity_mapped_color && acuity_color_counts.hasOwnProperty(acuity_mapped_color)) {
                                        acuity_color_counts[acuity_mapped_color]++;
                                    }
                                }
                            }

                            for (let outflow_category in outflow_data) {
                                if (outflow_data[outflow_category].hasOwnProperty("opel")) {
                                    let outflow_opel_value = outflow_data[outflow_category]["opel"];
                                    let outflow_mapped_color = outflow_opel_group[outflow_opel_value];

                                    if (outflow_mapped_color && outflow_color_counts.hasOwnProperty(outflow_mapped_color)) {
                                        outflow_color_counts[outflow_mapped_color]++;
                                    }
                                }
                            }


                            $('.inflow_green').val(inflow_color_counts.green);
                            $('.inflow_amber').val(inflow_color_counts.amber);
                            $('.inflow_red').val(inflow_color_counts.red);
                            $('.inflow_black').val(inflow_color_counts.black);

                            $('.acuity_green').val(acuity_color_counts.green);
                            $('.acuity_amber').val(acuity_color_counts.amber);
                            $('.acuity_red').val(acuity_color_counts.red);
                            $('.acuity_black').val(acuity_color_counts.black);


                            $('.outflow_green').val(outflow_color_counts.green);
                            $('.outflow_amber').val(outflow_color_counts.amber);
                            $('.outflow_red').val(outflow_color_counts.red);
                            $('.outflow_black').val(outflow_color_counts.black);

                            $('.toal_staffing_green').val($('.staffing_green.active').length);
                            $('.toal_staffing_amber').val($('.staffing_amber.active').length);
                            $('.toal_staffing_red').val($('.staffing_red.active').length);
                            $('.toal_staffing_black').val($('.staffing_black.active').length);

                            var total_green = (inflow_color_counts.green+acuity_color_counts.green+outflow_color_counts.green+$('.staffing_green.active').length);
                            var total_amber = (inflow_color_counts.amber+acuity_color_counts.amber+outflow_color_counts.amber+$('.staffing_amber.active').length);
                            var total_red = (inflow_color_counts.red+acuity_color_counts.red+outflow_color_counts.red+$('.staffing_red.active').length);
                            var total_black = (inflow_color_counts.black+acuity_color_counts.black+outflow_color_counts.black+$('.staffing_black.active').length);

                            $('.total_green').val(total_green);
                            $('.total_amber').val(total_amber);
                            $('.total_red').val(total_red);
                            $('.total_black').val(total_black);


                            var detect_max_ems = {
                                1: total_green,
                                2: total_amber,
                                3: total_red,
                                4: total_black
                            };
                            var detect_max_ems_value = Math.max(...Object.values(detect_max_ems));
                            var detect_max_ems_key = Object.keys(detect_max_ems).find(key => detect_max_ems[key] === detect_max_ems_value);

                            $('.ane_overall_ems').removeClass('active');

                            $('.ane_overall_ems[data-id="' + detect_max_ems_key + '"]').addClass('active');

                        },
                        error: function(textStatus, errorThrown) {
                            $('#requestStageSix').modal('show');
                            $('#requestStageSeven').modal('hide');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                }, 500);
            } else {
                let overall_perform_without_perc = parseFloat($('#overall_performance').html().replace('%', '').trim());
                let overall_perform = $('#overall_performance').html();
                $('#current_number_of_breaches').val($('#number_of_breach').html());
                $('#four_hour_performance_of_the_day').val(overall_perform);
                let inflow_data = {};
                let acuity_data = {};
                let outflow_data = {};

                $('[name^="inflow["]').filter(':input').each(function () {
                    let inflow_name = $(this).attr('name');
                    let inflow_match = inflow_name.match(/^inflow\[(.*?)\]\[(.*?)\]$/);

                    if (inflow_match && inflow_match[1] && inflow_match[2]) {
                        let inflow_category = inflow_match[1].trim();
                        let inflow_key = inflow_match[2].trim();

                        if (!inflow_data[inflow_category]) inflow_data[inflow_category] = {};
                        inflow_data[inflow_category][inflow_key] = $(this).val();
                    }
                });

                $('[name^="acuity["]').filter(':input').each(function () {
                    let acuity_name = $(this).attr('name');
                    let acuity_match = acuity_name.match(/^acuity\[(.*?)\]\[(.*?)\]$/);

                    if (acuity_match && acuity_match[1] && acuity_match[2]) {
                        let acuity_category = acuity_match[1].trim();
                        let acuity_key = acuity_match[2].trim();

                        if (!acuity_data[acuity_category]) acuity_data[acuity_category] = {};
                        acuity_data[acuity_category][acuity_key] = $(this).val();
                    }
                });

                $('[name^="outflow["]').filter(':input').each(function () {
                    let outflow_name = $(this).attr('name');
                    let outflow_match = outflow_name.match(/^outflow\[(.*?)\]\[(.*?)\]$/);

                    if (outflow_match && outflow_match[1] && outflow_match[2]) {
                        let outflow_category = outflow_match[1].trim();
                        let outflow_key = outflow_match[2].trim();

                        if (!outflow_data[outflow_category]) outflow_data[outflow_category] = {};
                        outflow_data[outflow_category][outflow_key] = $(this).val();
                    }
                });

                let inflow_color_counts = {
                    green: 0,
                    amber: 0,
                    red: 0,
                    black: 0
                };

                const inflow_opel_group = {
                    "1": "green",
                    "2": "amber",
                    "3": "red",
                    "4": "black"
                };

                let acuity_color_counts = {
                    green: 0,
                    amber: 0,
                    red: 0,
                    black: 0
                };

                const acuity_opel_group = {
                    "1": "green",
                    "2": "amber",
                    "3": "red",
                    "4": "black"
                };

                let outflow_color_counts = {
                    green: 0,
                    amber: 0,
                    red: 0,
                    black: 0
                };

                const outflow_opel_group = {
                    "1": "green",
                    "2": "amber",
                    "3": "red",
                    "4": "black"
                };

                for (let inflow_category in inflow_data) {
                    if (inflow_data[inflow_category].hasOwnProperty("opel")) {
                        let inflow_opel_value = inflow_data[inflow_category]["opel"];
                        let inflow_mapped_color = inflow_opel_group[inflow_opel_value];

                        if (inflow_mapped_color && inflow_color_counts.hasOwnProperty(inflow_mapped_color)) {
                            inflow_color_counts[inflow_mapped_color]++;
                        }
                    }
                }

                for (let acuity_category in acuity_data) {
                    if (acuity_data[acuity_category].hasOwnProperty("opel")) {
                        let acuity_opel_value = acuity_data[acuity_category]["opel"];
                        let acuity_mapped_color = acuity_opel_group[acuity_opel_value];

                        if (acuity_mapped_color && acuity_color_counts.hasOwnProperty(acuity_mapped_color)) {
                            acuity_color_counts[acuity_mapped_color]++;
                        }
                    }
                }

                for (let outflow_category in outflow_data) {
                    if (outflow_data[outflow_category].hasOwnProperty("opel")) {
                        let outflow_opel_value = outflow_data[outflow_category]["opel"];
                        let outflow_mapped_color = outflow_opel_group[outflow_opel_value];

                        if (outflow_mapped_color && outflow_color_counts.hasOwnProperty(outflow_mapped_color)) {
                            outflow_color_counts[outflow_mapped_color]++;
                        }
                    }
                }


                $('.inflow_green').val(inflow_color_counts.green);
                $('.inflow_amber').val(inflow_color_counts.amber);
                $('.inflow_red').val(inflow_color_counts.red);
                $('.inflow_black').val(inflow_color_counts.black);

                $('.acuity_green').val(acuity_color_counts.green);
                $('.acuity_amber').val(acuity_color_counts.amber);
                $('.acuity_red').val(acuity_color_counts.red);
                $('.acuity_black').val(acuity_color_counts.black);


                $('.outflow_green').val(outflow_color_counts.green);
                $('.outflow_amber').val(outflow_color_counts.amber);
                $('.outflow_red').val(outflow_color_counts.red);
                $('.outflow_black').val(outflow_color_counts.black);

                $('.toal_staffing_green').val($('.staffing_green.active').length);
                $('.toal_staffing_amber').val($('.staffing_amber.active').length);
                $('.toal_staffing_red').val($('.staffing_red.active').length);
                $('.toal_staffing_black').val($('.staffing_black.active').length);

                var total_green = (inflow_color_counts.green+acuity_color_counts.green+outflow_color_counts.green+$('.staffing_green.active').length);
                var total_amber = (inflow_color_counts.amber+acuity_color_counts.amber+outflow_color_counts.amber+$('.staffing_amber.active').length);
                var total_red = (inflow_color_counts.red+acuity_color_counts.red+outflow_color_counts.red+$('.staffing_red.active').length);
                var total_black = (inflow_color_counts.black+acuity_color_counts.black+outflow_color_counts.black+$('.staffing_black.active').length);

                $('.total_green').val(total_green);
                $('.total_amber').val(total_amber);
                $('.total_red').val(total_red);
                $('.total_black').val(total_black);
                var detect_max_ems = {
                    1: total_green,
                    2: total_amber,
                    3: total_red,
                    4: total_black
                };
                var detect_max_ems_value = Math.max(...Object.values(detect_max_ems));
                var detect_max_ems_key = Object.keys(detect_max_ems).find(key => detect_max_ems[key] === detect_max_ems_value);

                $('.ane_overall_ems').removeClass('active');

                $('.ane_overall_ems[data-id="' + detect_max_ems_key + '"]').addClass('active');
            }

        });

        function ClearEDThermoMeter(){
            $('#content_opel_modal_one').html('');
            $('#content_opel_modal_two').html('');
            $('#content_opel_modal_three').html('');
            $('#content_opel_modal_four').html('');
            $('#content_opel_modal_five').html('');
            $('#content_opel_modal_six').html('');
            $('#content_opel_modal_seven').html('');
        }
        $(document).on('click', '.staffing_absent', function () {
            var $this = $(this);
            var name = $this.data('name');
            var id = $this.data('id');

            var isActive = $this.hasClass('active');

            $('.staffing_absent').each(function () {
                //if ($(this).data('name') === name && $(this).data('id') === id) {
                if ($(this).data('name') === name) {
                    $(this).removeClass('active');
                }
            });

            if (!isActive) {
                $this.addClass('active');
            }
        });



        $(document).on('click', '.ane_overall_ems', function () {
            $('.ane_overall_ems').removeClass('active');
            $(this).addClass('active');
        });

        $(document).on('click', '.click_save_ed_thermometer', function () {

            var current_opel_status_check = $('.ane_overall_ems.active').length;

            if(current_opel_status_check < 1){
                toastr.warning('Please Choose ED STATUS');
                return;
            }
            var current_opel_status = $('.ane_overall_ems.active').attr('data-id');
            let staff_absent = {};
            $('.staffing_absent.active').each(function () {
                const key = 'staff_absent_' + $(this).data('name');
                staff_absent[key] = $(this).data('id');
            });

            let inflow_data = {};
            let acuity_data = {};
            let outflow_data = {};
            let total_data = {};
            let staff_absent_data = {};
            $.each(staff_absent, function (key, value) {
                staff_absent_data[key] = value;
            });
            $('[name^="inflow["]').filter(':input').each(function () {
                let inflow_name = $(this).attr('name');
                let inflow_match = inflow_name.match(/^inflow\[(.*?)\]\[(.*?)\]$/);

                if (inflow_match && inflow_match[1] && inflow_match[2]) {
                    let inflow_category = inflow_match[1].trim();
                    let inflow_key = inflow_match[2].trim();

                    if (!inflow_data[inflow_category]) inflow_data[inflow_category] = {};
                    inflow_data[inflow_category][inflow_key] = $(this).val();
                }
            });

            $('[name^="acuity["]').filter(':input').each(function () {
                let acuity_name = $(this).attr('name');
                let acuity_match = acuity_name.match(/^acuity\[(.*?)\]\[(.*?)\]$/);

                if (acuity_match && acuity_match[1] && acuity_match[2]) {
                    let acuity_category = acuity_match[1].trim();
                    let acuity_key = acuity_match[2].trim();

                    if (!acuity_data[acuity_category]) acuity_data[acuity_category] = {};
                    acuity_data[acuity_category][acuity_key] = $(this).val();
                }
            });
            $('[name^="outflow["]').filter(':input').each(function () {
                let outflow_name = $(this).attr('name');
                let outflow_match = outflow_name.match(/^outflow\[(.*?)\]\[(.*?)\]$/);

                if (outflow_match && outflow_match[1] && outflow_match[2]) {
                    let outflow_category = outflow_match[1].trim();
                    let outflow_key = outflow_match[2].trim();

                    if (!outflow_data[outflow_category]) outflow_data[outflow_category] = {};
                    outflow_data[outflow_category][outflow_key] = $(this).val();
                }
            });

            $('[name^="total["]').filter(':input').each(function () {
                let total_name = $(this).attr('name');
                let total_match = total_name.match(/^total\[(.*?)\]\[(.*?)\]$/);

                if (total_match && total_match[1] && total_match[2]) {
                    let total_category = total_match[1].trim();
                    let total_key = total_match[2].trim();

                    if (!total_data[total_category]) total_data[total_category] = {};
                    total_data[total_category][total_key] = $(this).val();
                }
            });


            var final_inflow_data = {};
            var final_acuity_data = {};
            var final_outflow_data = {};
            var final_total_data = {};
            $.each(inflow_data, function(final_inflow_parent_key, final_inflow_inner_object) {
                $.each(final_inflow_inner_object, function(final_inflow_child_key, final_inflow_value) {
                    var final_inflow_new_key = final_inflow_parent_key + "_" + final_inflow_child_key;
                    final_inflow_data[final_inflow_new_key] = final_inflow_value || "0";
                });
            });
            $.each(acuity_data, function(final_acuity_parent_key, final_acuity_inner_object) {
                $.each(final_acuity_inner_object, function(final_acuity_child_key, final_acuity_value) {
                    var final_acuity_new_key = final_acuity_parent_key + "_" + final_acuity_child_key;
                    final_acuity_data[final_acuity_new_key] = final_acuity_value || "0";
                });
            });
            $.each(outflow_data, function(final_outflow_parent_key, final_outflow_inner_object) {
                $.each(final_outflow_inner_object, function(final_outflow_child_key, final_outflow_value) {
                    var final_outflow_new_key = final_outflow_parent_key + "_" + final_outflow_child_key;
                    final_outflow_data[final_outflow_new_key] = final_outflow_value || "0";
                });
            });
            $.each(total_data, function(final_total_parent_key, final_total_inner_object) {
                $.each(final_total_inner_object, function(final_total_child_key, final_total_value) {
                    var final_total_new_key = final_total_parent_key + "_" + final_total_child_key;
                    final_total_data[final_total_new_key] = final_total_value || "0";
                });
            });
            let ed_thermo_meter = {};



            $('.patient_input').each(function () {
                let id = $(this).attr('id');
                let value = $(this).val();
                ed_thermo_meter[id] = value;
            });
            var ed_thermo_meter_completed_by = $('#ane_opel_stage_one_completed_by').val();
            var ed_thermo_meter_patient_in_ed = $('#ane_opel_stage_one_no_patients_in_ed').val();
            var ed_thermo_meter_patient_awaiting_bed = $('#ane_opel_stage_one_no_patients_awaiting_bed').val();
            var ed_thermo_meter_hour = $('#ane_opel_stage_one_hour_selected').val();
            var ed_thermo_meter_date = $('#ane_opel_stage_one_date_selected').val();
            var current_number_of_breaches = $('#current_number_of_breaches').val();
            var four_hour_performance_of_the_day = $('#four_hour_performance_of_the_day').val();
            var ed_thermometer_notes = $('#ed_thermometer_notes').val();
            var token = "{{ csrf_token() }}";
            DisableSaveButtonForModals();
            EnableSaveButtonLoadImageForModals();
            setTimeout(function () {
                var url = "{{ route('ane.opel.modal.save.ed.thermometer') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        'date': ed_thermo_meter_date,
                        'hour': ed_thermo_meter_hour,
                        'ed_thermo_meter_patient_awaiting_bed': ed_thermo_meter_patient_awaiting_bed,
                        'ed_thermo_meter_patient_in_ed': ed_thermo_meter_patient_in_ed,
                        'ed_thermo_meter_completed_by' : ed_thermo_meter_completed_by,
                        'final_inflow_data' : final_inflow_data,
                        'final_acuity_data' : final_acuity_data,
                        'final_outflow_data' : final_outflow_data,
                        'final_total_data' : final_total_data,
                        'ed_thermo_meter_patients': ed_thermo_meter,
                        'staff_absent' : staff_absent_data,
                        'current_opel_status': current_opel_status,
                        'current_number_of_breaches': current_number_of_breaches,
                        'four_hour_performance_of_the_day': four_hour_performance_of_the_day,
                        'ed_thermometer_notes': ed_thermometer_notes
                    },
                    success: function(result) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        $("#opel_current").html(result.opel_status);
                        document.getElementById('theImage').src =
                            "/asset_v2/Template/images/opel_" +
                            result.opel_status + ".png";


                        $('#requestStageSeven').modal('hide');
                        toastr.success('ED Thermometer Saved');
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        $('#requestStageSeven').modal('hide');
                        toastr.warning('Something Went Wrong');
                    }
                });
            }, 500);

        });

    </script>
    <script>
            $(document).on("change", "#patients_in_temporary_escalation_space_green", function(e) {
                const greenVal = $(this).val();

                if (greenVal === '1') { // YES
                    $('#patients_in_temporary_escalation_space_opel')
                        .val('1')
                        .selectric('refresh');

                    $('#patients_in_temporary_escalation_space_black')
                        .val('2')
                        .selectric('refresh');
                }
            });
            $(document).on("change", "#patients_in_temporary_escalation_space_black", function(e) {
                const blackVal = $(this).val();

                if (blackVal === '1') { // YES
                    $('#patients_in_temporary_escalation_space_green')
                        .val('2')
                        .selectric('refresh');

                    $('#patients_in_temporary_escalation_space_opel')
                        .val('4')
                        .selectric('refresh');
                }
            });

            $(document).on("change", "#special_care_patients_extensive_staff_input_green", function(e) {
                const greenVal = $(this).val();
                const redVal = $('#special_care_patients_extensive_staff_input_red').val();
                const blackVal = $('#special_care_patients_extensive_staff_input_black').val();
                if (greenVal === '1') { // YES
                    $('#special_care_patients_extensive_staff_input_opel')
                        .val('1')
                        .selectric('refresh');

                } else {
                    if(redVal == '1'){
                        $('#special_care_patients_extensive_staff_input_opel')
                        .val('3')
                        .selectric('refresh');
                    } else if(blackVal > 1){
                        $('#special_care_patients_extensive_staff_input_opel')
                        .val('4')
                        .selectric('refresh');
                    }
                }
            });


            $(document).on("input change", "#special_care_patients_extensive_staff_input_red, #special_care_patients_extensive_staff_input_black", function() {
                const greenVal = $('#special_care_patients_extensive_staff_input_green').val();
                const redVal = $('#special_care_patients_extensive_staff_input_red').val();
                const blackVal = $('#special_care_patients_extensive_staff_input_black').val();

                    if(redVal == '1' && blackVal < 2){
                        $('#special_care_patients_extensive_staff_input_opel')
                        .val('3')
                        .selectric('refresh');
                    } else if(blackVal > 1){
                        $('#special_care_patients_extensive_staff_input_opel')
                        .val('4')
                        .selectric('refresh');
                    }

            });



            $(document).on("change", "#closure_of_internal_ed_area_green", function(e) {
                const greenVal = $(this).val();

                if (greenVal == '1') { // YES
                    $('#closure_of_internal_ed_area_opel')
                        .val('1')
                        .selectric('refresh');

                    $('#closure_of_internal_ed_area_black')
                        .val('2')
                        .selectric('refresh');
                }
            });
            $(document).on("change", "#closure_of_internal_ed_area_black", function(e) {
                const blackVal = $(this).val();

                if (blackVal == '1') { // YES
                    $('#closure_of_internal_ed_area_green')
                        .val('2')
                        .selectric('refresh');

                    $('#closure_of_internal_ed_area_opel')
                        .val('4')
                        .selectric('refresh');
                }
            });



            $(document).on("change", "#safety_round_identifies_concerns_green", function(e) {
                const greenVal = $(this).val();

                if (greenVal == '1') { // YES
                    $('#safety_round_identifies_concerns_opel')
                        .val('1')
                        .selectric('refresh');
                    $('#safety_round_identifies_concerns_red')
                        .val('2')
                        .selectric('refresh');
                    $('#safety_round_identifies_concerns_black')
                        .val('2')
                        .selectric('refresh');
                }
            });
            $(document).on("change", "#safety_round_identifies_concerns_red", function(e) {
                const greenVal = $(this).val();

                if (greenVal == '1') { // YES
                    $('#safety_round_identifies_concerns_opel')
                        .val('3')
                        .selectric('refresh');
                    $('#safety_round_identifies_concerns_green')
                        .val('2')
                        .selectric('refresh');
                    $('#safety_round_identifies_concerns_black')
                        .val('2')
                        .selectric('refresh');
                }
            });

            $(document).on("change", "#safety_round_identifies_concerns_black", function(e) {
                const greenVal = $(this).val();

                if (greenVal == '1') { // YES
                    $('#safety_round_identifies_concerns_opel')
                        .val('4')
                        .selectric('refresh');
                    $('#safety_round_identifies_concerns_red')
                        .val('2')
                        .selectric('refresh');
                    $('#safety_round_identifies_concerns_green')
                        .val('2')
                        .selectric('refresh');
                }
            });

    </script>

    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
@endpush
