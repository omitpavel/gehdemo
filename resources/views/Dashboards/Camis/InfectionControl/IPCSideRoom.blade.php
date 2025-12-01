@extends('Layouts.Common.MasterLayout')
@section('page-title', 'IPC Side Room Tools')
@section('page-top-title', 'IPC Side Room Tools')
@section('page-top-title-sub', 'autotimer')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/SideRoomTool.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/IpcSideroom.css') }}" crossorigin="anonymous">
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
    <style>
        .is_infected {
            background-color: rgb(255 50 50) !important;
        }
    </style>
@endpush
@section('modal')
    @include('Dashboards.Camis.InfectionControl.InfectionModal')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
    </div>
@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
    <script>
        $(function() {
            $('#scub_admitting_date').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: false,
                showDropdowns: true,
                autoUpdateInput: true,
                autoApply: true,
                maxDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD HH:mm',
                    cancelLabel: 'Clear'
                }
            });

            $('#scub_admitting_date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm'));
                EnableSaveButtonForModals();
            });

            $('#scub_admitting_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                EnableSaveButtonForModals();
            });
            $('#scub_admitting_date').data('daterangepicker').container
                .on('change', 'select, input', function() {
                    EnableSaveButtonForModals();
                });
            $('#scub_admitting_date').on('change', function() {
                EnableSaveButtonForModals();
            });

            $(document).on('click', '.available', function(e) {
                EnableSaveButtonForModals();
            });
            $(document).on('change', '.hourselect, .minuteselect', function() {
                EnableSaveButtonForModals();
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";

        var ajax_refresh_url = "";
    </script>

    <script>
        function CloseICOffcanvas(offcanvas_id) {

            var $offcanvasElement = $('#' + offcanvas_id);

            if ($offcanvasElement.hasClass('show')) {
                $offcanvasElement.offcanvas('hide');
                $offcanvasElement.removeClass('show');

                // Check if there are any other offcanvas elements still open
                var anyOtherOffcanvasOpen = $('.offcanvas.show').length > 0;

                if (!anyOtherOffcanvasOpen) {
                    $('.offcanvas-backdrop').remove();
                    $('body').css({
                        'overflow': '',
                        'padding': ''
                    });
                }

                if ($('.offcanvas-overlay').css('display') === 'block') {
                    $('.offcanvas-overlay').css('display', 'none');
                }

                setTimeout(function() {
                    $('body').css('overflow', '').css('padding-right', '');
                }, 1000);
            }
            setHeight();
        }

        function setHeight() {

            const cloneCount = $('.infection_list_class .clone-me').length;
            const windowWidth = window.innerWidth;

            // Default threshold
            let threshold = 3;

            // Adjust threshold based on window width
            if (windowWidth > 1800) {
                threshold = 3;
            } else if (windowWidth > 1400) {
                threshold = 2;
            } else if (windowWidth < 1400) {
                threshold = 1;
            }

            // Apply styles if threshold is met
            if (cloneCount >= threshold) {
                $('.infection-ipc-wrapper').css('height', 'auto');
                $('.ipc-module').css('position', 'unset');
            } else {
                // Reset styles when condition not met
                $('.infection-ipc-wrapper').css('height', '');
                $('.ipc-module').css('position', '');
            }

        }


        function CheckPatientFlag(patient_id) {
            var token = "{{ csrf_token() }}";


            $.ajax({
                _token: token,
                url: "{{ route('infection.ipc.sideroom.patients.flag') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "patient_id": patient_id
                },
                success: function(response) {
                    if (response != "") {

                        $('.patient_infection_icon_' + patient_id).html(response.html);

                        if (response.is_infected == 0) {
                            if (!$('.infectied_div_red_' + patient_id).hasClass('d-none')) {
                                $('.infectied_div_red_' + patient_id).addClass('d-none');
                            }
                            if ($('.infectied_div_green_' + patient_id).hasClass('d-none')) {
                                $('.infectied_div_green_' + patient_id).removeClass('d-none');
                            }
                        } else {
                            if ($('.infectied_div_red_' + patient_id).hasClass('d-none')) {
                                $('.infectied_div_red_' + patient_id).removeClass('d-none');
                            }
                            if (!$('.infectied_div_green_' + patient_id).hasClass('d-none')) {
                                $('.infectied_div_green_' + patient_id).addClass('d-none');
                            }
                        }


                        if (response.is_infected_bg == 1) {
                            if (!$('.reverse_barrier_bed_name_class_' + patient_id).hasClass(
                                    'is_infected')) {
                                $('.reverse_barrier_bed_name_class_' + patient_id).addClass(
                                    'is_infected');
                            }



                        } else {
                            if ($('.reverse_barrier_bed_name_class_' + patient_id).hasClass(
                                    'is_infected')) {
                                $('.reverse_barrier_bed_name_class_' + patient_id).removeClass(
                                    'is_infected');
                            }
                        }
                    }
                },
                error: function(status, err) {

                }
            });

        }

        function initSingleDatePicker($context) {
            $context.find('.ic_date').each(function() {
                var $input = $(this);

                if ($input.data('daterangepicker')) {
                    $input.data('daterangepicker').remove();
                    $input.off('.daterangepicker');
                }

                $input.daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    autoApply: true,
                    minDate: moment(),
                    locale: {
                        format: 'YYYY-MM-DD',
                        applyLabel: 'Apply',
                        cancelLabel: 'Clear'
                    }
                });

                $input.on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD'));
                    EnableSaveButtonForModals();
                });

                $input.on('cancel.daterangepicker', function() {
                    $(this).val('');
                });
            });
        }

        function DataPageLoad(ward, can_be_move, can_not_be_move) {
            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: "{{ route('infection.ipc.sideroom.patients.dataload') }}",
                type: 'POST',
                data: {
                    "ward_id": ward,
                    "can_be_move": can_be_move,
                    "can_not_be_move": can_not_be_move,
                    _token: tok
                },
                success: function(result) {
                    $('.refresh-content').html(result);
                    MultiSelectJs('ward_id', 'All Wards');
                    $('.page-data-loader').hide();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    $('.page-data-loader').hide();
                }
            });
        }


        $(document).ready(function() {
            var ward_id = $('#ward_id').val();
            var can_be_move = 1;
            var can_not_be_move = 1;
            DataPageLoad(ward_id, can_be_move, can_not_be_move);
        });
        $(document).on("change", "#ward_id", function(e) {
            var ward_id = $('#ward_id').val();
            var can_be_move = $('.btn-ipc-green').hasClass('active') ? 1 : 0;
            var can_not_be_move = $('.btn-ipc-red').hasClass('active') ? 1 : 0;
            DataPageLoad(ward_id, can_be_move, can_not_be_move);
        });

        $(document).on("click", ".btn-ipc-green,.btn-ipc-red", function(e) {
            $(this).toggleClass('active');
            var ward_id = $('#ward_id').val();
            var can_be_move = $('.btn-ipc-green').hasClass('active') ? 1 : 0;
            var can_not_be_move = $('.btn-ipc-red').hasClass('active') ? 1 : 0;
            DataPageLoad(ward_id, can_be_move, can_not_be_move);
        });
    </script>
    <script>
        $(document).on('click', '.delete_comment_button', function(e) {
            $('#ipc_comment_value').val('');
            EnableSaveButtonForModals();
        });
        $(document).on('keyup', '#ipc_comment_value', function(e) {
            var textarea_value = $('#ipc_comment_value').val();
            EnableSaveButtonForModals();
        });
        $(document).on('click', '.camis_patient_save_ipc_patient', function(e) {
            var token = "{{ csrf_token() }}";
            var comment = $('#ipc_comment_value').val();
            var camis_patient_id = $('#ipc_edit_patient_comment_id').val();

            if (camis_patient_id == '') {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                return;
            }
            CommonDisableEnableOnSave();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            var url = "{{ route('infection.ipc.comment.save') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id,
                    'comment': comment
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {
                        $('.camis_ipc_patient_comment_' + camis_patient_id).val(comment);
                        CloseOffcanvas('ipcComment');
                        toastr.success(result.message);
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                    }


                },
                error: function(textStatus, errorThrown) {
                    CloseOffcanvas('ipcComment');
                    CommonErrorModalPopupOpenOnRequest();
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                }
            });
        });

        $(document).on('click', '.click_open_infection_offcanvas,.click_open_comment_box', function(e) {



            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('patient-id');
            $('#ipc_edit_patient_id').val(camis_patient_id);
            var boardround_flag_name = $(this).data('patient-flag-stored-name');
            var boardround_flag_show_name = $(this).data('patient-flag-show-name');



            DisableButtonClickForPreventFurtherEvent("click_open_infection_offcanvas");

            if (camis_patient_id != '' && boardround_flag_name != '') {

                var $matchingElement = $('.click_open_infection_offcanvas[data-patient-id="' + camis_patient_id +
                    '"]');

                if ($matchingElement.length) {
                    if ($matchingElement.hasClass('is_reverse_barrier')) {
                        if (!$('.click_assign_reverse_barrier').hasClass("active")) {
                            $('.click_assign_reverse_barrier').addClass("active");
                        }
                    } else {
                        if ($('.click_assign_reverse_barrier').hasClass("active")) {
                            $('.click_assign_reverse_barrier').removeClass("active");
                        }
                    }
                }


                var url = "{{ route('GetPatientFlagDetails') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        'camis_patient_id': camis_patient_id,
                        'boardround_flag_name': boardround_flag_name
                    },
                    success: function(result) {
                        $('#ipc_comment_value').val('');
                        if (result.patient_flag_name != '') {
                            if (result.patient_flag_name == 'ibox_patient_flag_infection_risk') {

                                var infection_risk_patient_modal = new bootstrap.Offcanvas(document
                                    .getElementById(
                                        'camis_patient_ward_summary_boardround_patient_flag_infection_risk'
                                    ), {
                                        relatedTarget: 'offcanvasRight',
                                        backdrop: false
                                    });
                                infection_risk_patient_modal.show();
                                CommonDisableEnableOnOpen();
                                $('.ibox_board_round_popup_opened_patient_flag_name').val(result
                                    .patient_flag_name);
                                $('.infection_list_class').html(result.sections);
                                $('#past_infection_history').html(result.old_infection_history);
                                initSingleDatePicker($('.infection_list_class'));
                                $('.offcanvas-body').animate({
                                    scrollTop: 0
                                }, 'slow');

                                setHeight();
                                if (result.patient_flag_status_value == 1) {
                                    EnableDeleteButtonForModals();
                                }
                            }

                        }

                        $('#ipc_comment_value').val(result.ipc_comment);
                    },
                    error: function(textStatus, errorThrown) {

                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {

                CommonErrorModalPopupOpenOnRequest();
            }
        });

        $(document).on("click", ".clone_infection_div", function(e) {
            $('.ic_id').selectric('destroy');
            var ic_div = $('.infection_risk_master_div_for_repeat').html();
            $('.infection_list_class').append(ic_div);
            initSingleDatePicker($('.infection_list_class'));
            $('.ic_id').selectric('refresh');
            setHeight();
        });

        $(document).on("click", ".infection_risk_button", function() {
            $(this).closest('.row').find('.infection_risk_button').removeClass('active');
            $(this).addClass('active');
            EnableSaveButtonForModals();
        });


        $(document).on("click", ".make_primary_infection", function() {
            $('.make_primary_infection').removeClass('active');
            $(this).addClass('active');


            EnableSaveButtonForModals();

        });

        $(document).on("change", ".ic_id", function() {

            EnableSaveButtonForModals();
        });

        $(document).on("click", ".infection_risk_delete", function() {
            var $card = $(this).closest('.card-infection-data');
            $card.addClass('infection_risk_disabled').find('.infection_risk_button').removeClass('active');

            if ($card.find('.make_primary_infection').hasClass('active')) {
                $card.find('.make_primary_infection').removeClass('active');
                var $nearestCard = $card.siblings('.card-infection-data:not(.infection_risk_disabled)').first();

                if ($nearestCard.length === 0) {
                    $nearestCard = $card.prevAll('.card-infection-data:not(.infection_risk_disabled)').first();
                }

                $nearestCard.find('.make_primary_infection').first().addClass('active');
            }
            EnableSaveButtonForModals();
            $('.ic_id').selectric('refresh');
            setHeight();
        });
        $(document).on("click", ".click_open_ipc_infection_history", function() {
            $('.infection_history_data').html('');
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#ipc_edit_patient_id').val();
            var url = "{{ route('infection.ipc.infection.history') }}";
            $('#infectionHistory').modal('show');
            EnableLoaderAndMakeHiddenInnerBody();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    $('.infection_history_data').html(result.history);
                    DisableLoaderAndMakeVisibleInnerBody();

                },
                error: function(textStatus, errorThrown) {
                    $('#infectionHistory').modal('hide');
                }
            });
        });
        $(document).on("click", ".click_open_ipc_comment_history", function() {
            $('.comment_history_data').html('');
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#ipc_edit_patient_id').val();
            var url = "{{ route('infection.ipc.comment.history') }}";
            $('#ipcComment').modal('show');
            EnableLoaderAndMakeHiddenInnerBody();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': token,
                    'camis_patient_id': camis_patient_id
                },
                success: function(result) {
                    $('.comment_history_data').html(result.history);
                    DisableLoaderAndMakeVisibleInnerBody();

                },
                error: function(textStatus, errorThrown) {
                    $('#ipcComment').modal('hide');
                }
            });
        });
        $(document).on('change', '#scub_patient_gender', function(e) {
            var patient_gender = $('#scub_patient_gender').val();
            if (patient_gender != '') {
                EnableSaveButtonForModals();
            } else {
                DisableSaveButtonForModals();
            }
        });

        $(document).on('keyup',
            '#scub_camis_patient_id, #scub_pas_number, #scub_patient_name, #scub_consultant_name, #scub_speciality',
            function(e) {
                EnableSaveButtonForModals();
            });


        $(document).on("click", ".click_update_scub_ward", function() {
            DisableButtonClickForPreventFurtherEvent('click_update_scub_ward');
            var token = "{{ csrf_token() }}";
            var camis_bed_id = $(this).data('scub_ward_id');
            if (camis_bed_id != 0) {
                $('#scub_bed_id').val(camis_bed_id);
                var url = "{{ route('infection.ipc.scub.patients') }}";

                var scub_patient_modal = new bootstrap.Offcanvas(document.getElementById('add_scub_patient'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: false
                });

                scub_patient_modal.show();

                CommonDisableEnableOnOpen();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        'camis_bed_id': camis_bed_id
                    },
                    success: function(result) {
                        $('#scub_camis_patient_id').val(result.camis_patient_id);
                        $('#scub_pas_number').val(result.pas_number);
                        $('#scub_patient_name').val(result.patient_name);
                        $('#scub_consultant_name').val(result.consultant_name);
                        $('#scub_speciality').val(result.speciality);
                        $('#scub_patient_gender').val(result.patient_gender).change().selectric(
                            'refresh');
                        if (result.admitting_date) {
                            var m = moment(result.admitting_date, 'YYYY-MM-DD HH:mm:ss');
                            if (!m.isValid()) {
                                m = moment(result.admitting_date);
                            }
                            $('#scub_admitting_date').data('daterangepicker').setStartDate(m);
                            $('#scub_admitting_date').val(m.format('YYYY-MM-DD HH:mm'));
                        } else {
                            $('#scub_admitting_date').val('');
                        }
                        if (result.camis_patient_id != '') {
                            EnableDeleteButtonForModals();
                        }
                        DisableSaveButtonForModals();
                        DisableLoaderAndMakeVisibleInnerBody();

                    },
                    error: function(textStatus, errorThrown) {
                        CloseOffcanvas('add_scub_patient');
                    }
                });
            } else {
                toastr.warning('Something Went Wrong');
            }

        });
        $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_scub_patient_data", function() {
            DisableButtonClickForPreventFurtherEvent(
                'camis_patient_ward_summary_boardround_save_patient_scub_patient_data');
            var token = "{{ csrf_token() }}";
            var camis_bed_id = $('#scub_bed_id').val();
            if (camis_bed_id != 0) {
                var url = "{{ route('infection.ipc.scub.save') }}";
                var camis_patient_id = $('#scub_camis_patient_id').val();
                var pas_number = $('#scub_pas_number').val();
                var patient_name = $('#scub_patient_name').val();
                var consultant_name = $('#scub_consultant_name').val();
                var speciality = $('#scub_speciality').val();
                var patient_gender = $('#scub_patient_gender').val();
                var date_range = $('#scub_admitting_date').data('daterangepicker');
                var admitting_date = '';

                if (patient_gender && $('#scub_admitting_date').val()) {
                    admitting_date = date_range.startDate.format('YYYY-MM-DD HH:mm');
                } else {
                    admitting_date = '';
                }
                if (camis_patient_id == '') {
                    toastr.warning('Please Enter RTL ID');
                    return;
                } else if (pas_number == '') {
                    toastr.warning('Please Enter Hospital Number');
                    return;
                } else if (patient_name == '') {
                    toastr.warning('Please Enter Patient Name');
                    return;
                } else if (patient_gender == '') {
                    toastr.warning('Please Select Patient Gender');
                    return;
                } else if (consultant_name == '') {
                    toastr.warning('Please Enter Consultant Name');
                    return;
                } else if (speciality == '') {
                    toastr.warning('Please Enter Consultant Speciality');
                    return;
                } else if (admitting_date == '') {
                    toastr.warning('Please Enter Admission Date');
                    return;
                }
                EnableSaveButtonLoadImageForModals();
                EnableLoaderAndMakeHiddenInnerBody();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        "bed_id": camis_bed_id,
                        'camis_patient_id': camis_patient_id,
                        'pas_number': pas_number,
                        'patient_name': patient_name,
                        'consultant_name': consultant_name,
                        'speciality': speciality,
                        'admitting_date': admitting_date,
                        'patient_gender': patient_gender
                    },
                    success: function(result) {
                        DisableLoaderAndMakeVisibleInnerBody();
                        DisableSaveButtonLoadImageForModals();
                        if (result.scub_bed == 1) {
                            $('.ipc_scub_ward_bed_id_' + camis_bed_id).html(result.scub_bed_html);
                            $('.th_scub_bed_' + camis_bed_id).replaceWith(result.scub_bed_header);
                        } else {
                            $('.th_scub_bed_' + camis_bed_id).replaceWith(result.scub_bed_header);
                            $('.ipc_scub_ward_bed_id_' + camis_bed_id).html(result.scub_bed_html);
                        }

                        toastr.success('Patient Data Updated Successfully');
                        CloseOffcanvas('add_scub_patient');

                    },
                    error: function(textStatus, errorThrown) {
                        DisableLoaderAndMakeVisibleInnerBody();
                        DisableSaveButtonLoadImageForModals();
                        toastr.warning('Something Went Wrong');
                        CloseOffcanvas('add_scub_patient');
                    }
                });
            } else {
                DisableLoaderAndMakeVisibleInnerBody();
                DisableSaveButtonLoadImageForModals();
                CloseOffcanvas('add_scub_patient');
            }

        });


        $(document).on("click", ".camis_patient_ward_summary_boardround_remove_scub_patient_data", function() {
            DisableButtonClickForPreventFurtherEvent(
                'camis_patient_ward_summary_boardround_remove_scub_patient_data');
            var token = "{{ csrf_token() }}";
            var camis_bed_id = $('#scub_bed_id').val();
            if (camis_bed_id != 0) {
                var url = "{{ route('infection.ipc.scub.remove') }}";

                EnableSaveButtonLoadImageForModals();
                EnableLoaderAndMakeHiddenInnerBody();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token': token,
                        "bed_id": camis_bed_id
                    },
                    success: function(result) {
                        DisableLoaderAndMakeVisibleInnerBody();
                        DisableSaveButtonLoadImageForModals();
                        if (result.scub_bed == 1) {
                            $('.ipc_scub_ward_bed_id_' + camis_bed_id).html(result.scub_bed_html);
                            $('.th_scub_bed_' + camis_bed_id).replaceWith(result.scub_bed_header);
                        } else {
                            $('.ipc_scub_ward_bed_id_' + camis_bed_id).html(result.scub_bed_html);
                            $('.th_scub_bed_' + camis_bed_id).replaceWith(result.scub_bed_header);
                        }

                        toastr.success('Patient Data Updated Successfully');
                        CloseOffcanvas('add_scub_patient');

                    },
                    error: function(textStatus, errorThrown) {
                        DisableLoaderAndMakeVisibleInnerBody();
                        DisableSaveButtonLoadImageForModals();
                        toastr.warning('Something Went Wrong');
                        CloseOffcanvas('add_scub_patient');
                    }
                });
            } else {
                DisableLoaderAndMakeVisibleInnerBody();
                DisableSaveButtonLoadImageForModals();
                CloseOffcanvas('add_scub_patient');
            }

        });

        $(document).on("click", ".camis_patient_ward_summary_boardround_save_patient_flag_infection_risk", function() {
            let infection_data = [];
            let valid = true;
            let has_primary = false;
            var reverse_barrier = $('.click_assign_reverse_barrier').hasClass("active") ? 1 : 0;
            $(".infection_list_class .card-infection-data").each(function() {
                let $this = $(this);
                let infection_item = {};
                let selected_option = $this.find("select.ic_id option:selected");

                // Prefer a stored existing-id (set on server when rendering the card)
                // e.g. <div class="card-infection-data" data-existing-id="22">...
                infection_item.infection_id = $this.data('existing-id') || $this.find(
                    'input.hidden_existing_id').val() || (selected_option.length ? selected_option
                    .val() : '');

                infection_item.infection_text = selected_option.data('infection-name') || $this.find(
                    '.selectric .label').text() || '';
                infection_item.infection_type = $this.find(".infection_risk_button.active").text() || '';
                infection_item.next_review_date = $this.find(".ic_date").val() || null;
                infection_item.is_primary = $this.find(".make_primary_infection").hasClass("active") ?
                    1 : 0;
                infection_item.action_type = $this.hasClass("infection_risk_disabled") ? "delete" :
                    "update";

                // validations only for updates
                if (infection_item.action_type === "update") {
                    if (infection_item.is_primary) {
                        has_primary = true;
                        if (infection_item.infection_id !== '' && !infection_item.next_review_date) {
                            toastr.warning("Primary infection must have a next review date.");
                            valid = false;
                            return false; // break .each()
                        }
                    }

                    if (infection_item.infection_id !== '' && infection_item.infection_type === '') {
                        toastr.warning(
                            "Some Of The Infection Risk Data Missed. Please Either Select Reason Details Or Delete That"
                        );
                        valid = false;
                        return false; // break .each()
                    }
                }

                // push single time: send when has an id OR it's a delete action (delete must carry an id to remove server-side)
                if ((infection_item.infection_id !== '' && infection_item.infection_id != null) ||
                    infection_item.action_type === 'delete') {
                    infection_data.push(infection_item);
                }
            });



            if (!valid) return;

            let update_flag = 0;

            if (infection_data.length === 0) {
                update_flag = 0;
            } else {
                update_flag = 1;
            }

            console.log(infection_data);

            var token = "{{ csrf_token() }}";
            var patient_flag_name = 'ibox_patient_flag_infection_risk';
            var camis_patient_id = $('#ipc_edit_patient_id').val();
            if ($(".ibox_board_round_patient_flag_active_" + patient_flag_name).hasClass('flag_inactive')) {
                $(".ibox_board_round_patient_flag_active_" + patient_flag_name).removeClass('flag_inactive');
            }
            DisableButtonClickForPreventFurtherEvent(
                'camis_patient_ward_summary_boardround_save_patient_flag_infection_risk');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            if (camis_patient_id != '') {
                var url = "{{ route('infection.UpdatePatientFlagDetails') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "patient_flag_name": patient_flag_name,
                        "patient_flag_infection_data": infection_data,
                        "patient_flag_status_value": 1,
                        "reverse_barrier": reverse_barrier,
                        "update_flag": update_flag,
                        "ipc_comment": $('#ipc_comment_value').val()
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            CheckPatientFlag(camis_patient_id);
                            if (reverse_barrier == 1) {
                                if (!$('.reverse_barrier_bed_name_class_' + camis_patient_id).hasClass(
                                        'bg-reverse-barrier')) {
                                    $('.reverse_barrier_bed_name_class_' + camis_patient_id).addClass(
                                        'bg-reverse-barrier');
                                }
                                if (!$('.reverse_barrier_bed_name_class_' + camis_patient_id).hasClass(
                                        'is_reverse_barrier')) {
                                    $('.reverse_barrier_bed_name_class_' + camis_patient_id).addClass(
                                        'is_reverse_barrier');
                                }


                                if ($('.reverse_barrier_bed_list_class_' + camis_patient_id).hasClass(
                                        'd-none')) {
                                    $('.reverse_barrier_bed_list_class_' + camis_patient_id)
                                        .removeClass(
                                            'd-none');
                                }
                            } else {
                                if ($('.reverse_barrier_bed_name_class_' + camis_patient_id).hasClass(
                                        'bg-reverse-barrier')) {
                                    $('.reverse_barrier_bed_name_class_' + camis_patient_id)
                                        .removeClass(
                                            'bg-reverse-barrier');
                                }
                                if ($('.reverse_barrier_bed_name_class_' + camis_patient_id).hasClass(
                                        'is_reverse_barrier')) {
                                    $('.reverse_barrier_bed_name_class_' + camis_patient_id)
                                        .removeClass(
                                            'is_reverse_barrier');
                                }
                                if (!$('.reverse_barrier_bed_list_class_' + camis_patient_id).hasClass(
                                        'd-none')) {
                                    $('.reverse_barrier_bed_list_class_' + camis_patient_id).addClass(
                                        'd-none');
                                }
                            }
                            $('.camis_ipc_patient_comment_' + camis_patient_id).val(result.ipc_comment);
                            CloseOffcanvas(
                                'camis_patient_ward_summary_boardround_patient_flag_infection_risk');





                            toastr.success(result.message);
                        } else {
                            $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                                'flag_inactive');
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }

                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                    },
                    error: function(textStatus, errorThrown) {
                        $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass(
                            'flag_inactive');
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                $(".ibox_board_round_patient_flag_active_" + patient_flag_name).toggleClass('flag_inactive');
                DisableSaveButtonLoadImageForModals();
                EnableSaveButtonForModals();
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });

        $(document).on("click", ".click_assign_reverse_barrier", function(e) {

            $(this).toggleClass("active");
            EnableSaveButtonForModals();


        });


        $(document).on("click", ".camis_patient_ward_summary_boardround_remove_patient_flag", function(e) {
            var token = "{{ csrf_token() }}";
            var patient_flag_name = 'ibox_patient_flag_infection_risk';
            var camis_patient_id = $('#ipc_edit_patient_id').val();
            if (patient_flag_name == 'ibox_patient_flag_infection_risk') {
                $(".ibox_boardround_patient_flag_infection_risk_button").removeClass("active");
                $('#patient_flag_infection_risk_reason').val('').selectric('refresh');
            }

            DisableButtonClickForPreventFurtherEvent('camis_patient_ward_summary_boardround_remove_patient_flag');
            EnableDeleteButtonForModals();
            EnableDeleteButtonLoadImageForModals();
            if (camis_patient_id != '') {
                var url = "{{ route('RemovePatientFlagDetails') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "patient_flag_name": patient_flag_name
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {

                            if (patient_flag_name == 'ibox_patient_flag_infection_risk') {

                                CheckPatientFlag(camis_patient_id);
                                if ($('.reverse_barrier_bed_name_class_' + camis_patient_id).hasClass(
                                        'bg-reverse-barrier')) {
                                    $('.reverse_barrier_bed_name_class_' + camis_patient_id)
                                        .removeClass(
                                            'bg-reverse-barrier');
                                }
                                if ($('.reverse_barrier_bed_name_class_' + camis_patient_id).hasClass(
                                        'is_reverse_barrier')) {
                                    $('.reverse_barrier_bed_name_class_' + camis_patient_id)
                                        .removeClass(
                                            'is_reverse_barrier');
                                }
                                if (!$('.reverse_barrier_bed_list_class_' + camis_patient_id).hasClass(
                                        'd-none')) {
                                    $('.reverse_barrier_bed_list_class_' + camis_patient_id).addClass(
                                        'd-none');
                                }
                                if (!$('.infectied_div_red_' + camis_patient_id).hasClass('d-none')) {
                                    $('.infectied_div_red_' + camis_patient_id).addClass('d-none');
                                }
                                if ($('.infectied_div_green_' + camis_patient_id).hasClass('d-none')) {
                                    $('.infectied_div_green_' + camis_patient_id).removeClass('d-none');
                                }


                                CloseOffcanvas(
                                    'camis_patient_ward_summary_boardround_patient_flag_infection_risk'
                                );





                            }
                            toastr.success('{{ DataRemovalMessage() }}');
                        } else {
                            DisableDeleteButtonForModals();
                            EnableDeleteButtonLoadImageForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {

                        DisableDeleteButtonForModals();
                        EnableDeleteButtonLoadImageForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                DisableDeleteButtonForModals();
                EnableDeleteButtonLoadImageForModals();
                CommonErrorModalPopupOpenOnRequest();
            }
        });

        $(window).on('resize', function() {
            setHeight();
        });
    </script>

    <script src="{{ asset('asset_v2') }}/Ibox/Js/custom.js"></script>


@endsection
