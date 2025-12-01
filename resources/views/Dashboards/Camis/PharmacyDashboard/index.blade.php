@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Pharmacy Dashboard')
@section('page-top-title', 'Pharmacy Dashboard')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PharmacyDashboard.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesCommentHistory.css') }}" crossorigin="anonymous">

@endpush
@section('modal')
    @include('Common.Modals.BoardRoundInfoModal')
    @include('Dashboards.Camis.WardSummary.BoardRoundModals.Pharmacy')
    @include('Dashboards.Camis.PharmacyDashboard.Modal.AllComments')
    @include('Dashboards.Camis.PharmacyDashboard.Modal.PharmacyHistory')
    @include('Dashboards.Camis.PharmacyDashboard.Modal.AllScreenedHistory')
    @include('Dashboards.Camis.WardSummary.BoardRoundModals.AssignTask')
    @include('Dashboards.Camis.PharmacyDashboard.Modal.AllTask')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <input type="hidden" id="boardround_patient_task_group" value="">
    <input type="hidden" id="task_category" value="0">
    <input type="hidden" id="filtered_task_id" value="">
    <input type="hidden" id="pharmacy_update_patient_id" value="">
    <input type="hidden" id="ward_summary_boardround_modal_popup_camis_patient_id" value="">
    <input type="hidden" id="pharmacy_id" value="1">
    <div class="container-fluid" id="contentSection_data">

    </div>
@endsection
@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";
        var ajax_refresh_url = "";
    </script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script>
    @if(CheckSpecificPermission('pharmacy_dashboard_view'))
    $(document).ready(function() {
        TabType('pharmacy_list');
    });
    @elseif(CheckSpecificPermission('pharmacy_dashboard_screened_view'))

    $(document).ready(function() {
        TabType('pharmacy_screened');
    });

    @endif
</script>

    <script>
        $(document).ready(function(){

            $('.page-data-loader').show();
            var url = "{{ route('pharmacy.content') }}";
            $.ajax({
                url: url,
                type: 'GET',
                // data: { "search_date": date_value, "search_data_type":2, "_token": tok  },
                success: function (result)
                {
                    $('#contentSection_data').html(result);
                    MultiSelectJs('ward_id', 'Ward');
                    $('.page-data-loader').hide();

                }
            });
        });
    </script>

    <script>
        $(document).on("change", "#drug_history_type, #antibiotic_type, #ward_id, #screened_status", function (e)
        {
            var drug_history_type              = $('#drug_history_type').val();
            var antibiotic_type              = $('#antibiotic_type').val();
            var ward_id                        = $('#ward_id').val();
            var screened_status                        = $('#screened_status').val();
            var tab_type                  = $('#tab_type').val();
            $('.page-data-loader').show();
            var url = "{{ route('pharmacy.content') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: { "drug_history_type": drug_history_type, "ward_id":ward_id, "antibiotic_type":antibiotic_type,"tab_type":tab_type, "screened_status":screened_status  },
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('#contentSection_data').html(result);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        window.location.href = '{{ route('home') }}';

                    }
                }
            });
        });
    </script>

    <script>

        function ViewallPharmacyComment(patient_id){
            $('.page-data-loader').show();
            var url = "{{ route('pharmacy.AllComment') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: { "patient_id": patient_id,   },
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('#all_comments_body').html(result);
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        window.location.href = '{{ route('home') }}';

                    }
                }
            });
        }


    </script>



    <script>

        function ViewPharmacyHistory(patient_id){
            $('.page-data-loader').show();
            var url = "{{ route('pharmacy.PharmacyHistory') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: { "patient_id": patient_id,   },
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('#pharmacy_history_body').html(result);
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        window.location.href = '{{ route('home') }}';

                    }
                }
            });
        }


    </script>

    <script>
        function TabType(type) {

            var url = "{{ route('pharmacy.content') }}";
            $('#tab_type').val(type);
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {tab_type:type},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        startCycle();
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
    </script>
    <script>
        function AutoLoad() {
            var url = "{{ route('pharmacy.content') }}";
            var tab_type               = $('#tab_type').val();
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {tab_type:tab_type},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
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

        function startCycle() {
            interval = setInterval(function() {
                AutoLoad();
            }, 180000);
        }

    </script>

    <script>
        $(document).on('click', '.click_open_pharmacy_task', function() {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('camis-patient-id');
            var task_modal = new bootstrap.Offcanvas(document.getElementById('task_list_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });
            task_modal.show();
            var task_group = $('.change_task_filter').val();
            var url = "{{ route('pharmacy.TaskByGroup') }}";
            $('#task_patient_id').val(camis_patient_id);
            DisableButtonClickForPreventFurtherEvent('click_open_pharmacy_task');
            $.ajax({
                url: url,
                type: 'GET',
                data: {task_type:task_group,patient_id:camis_patient_id},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('.offcanvas_data').html(result);
                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        DisableLoaderAndMakeVisibleInnerBody();
                        toastr.error('Permission Restricted.');
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        });
    </script>
    <script>
        $(document).on('change', '.change_task_filter', function() {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#task_patient_id').val();
            CommonDisableEnableOnOpen();
            var task_group = $('.change_task_filter').val();
            var url = "{{ route('pharmacy.TaskByGroup') }}";
            DisableButtonClickForPreventFurtherEvent('click_open_pharmacy_task');
            $.ajax({
                url: url,
                type: 'GET',
                data: {task_type:task_group,patient_id:camis_patient_id},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('.offcanvas_data').html(result);
                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        DisableLoaderAndMakeVisibleInnerBody();
                        toastr.error('Permission Restricted.');
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        });

    </script>
    <script>
        $(document).on('click', '.click_popup_open_ibox_board_round_pharmacy', function() {

            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('camis-patient-id');
            var pharmacy_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_pharmacy'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });
            pharmacy_modal.show();
            DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_pharmacy');
            $(".camis_patient_ward_summary_boardround_pharmacy_inner").html('');
            if (camis_patient_id != '') {
                var url = "{{ route('GetPharmacyStatus') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id
                    },
                    success: function(result) {

                        if (result != '') {
                            $(".patient_drug_history_tick_icon").css("display", "none");
                            $(".camis_patient_ward_summary_boardround_pharmacy_inner").html(result);


                            $("#pharmacy_latest_comment").focus();
                            $('#pharmacy_update_patient_id').val(camis_patient_id);
                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            DisableSaveButtonForModals();
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
    </script>

    <script>
        $(document).on('click', '.patient_pharmacy_drug_history', function() {
            var pharmacy_data_history_value = $(this).data('pharmacy-drug-history-value');
            $('.pharmacy_update_time').html('');
            $(".patient_drug_history_tick_icon").css("display", "none");
            $(".patient_drug_history_tick_icon_" + pharmacy_data_history_value).css("display", "inline");
            $('.drug_history_updated_time').html('');
            var current_time = moment();

            $(".patient_drug_history_updated_date_" + pharmacy_data_history_value).html(current_time.format('ddd DD MMM  YYYY, HH:mm'));
            $("#ibox_board_round_patient_pharmacy_drug_history_date").val(current_time.format('YYYY-MM-DD HH:mm:ss'));
            if ($(".patient_pharmacy_drug_history_" + pharmacy_data_history_value).hasClass("active")) {

                $(".patient_pharmacy_drug_history").removeClass("active");
                $('#ibox_board_round_patient_pharmacy_drug_history').val('');
                EnableSaveButtonForModals();
            } else {

                $(".patient_pharmacy_drug_history").removeClass("active");
                $(".patient_pharmacy_drug_history_" + pharmacy_data_history_value).addClass("active");
                $('#ibox_board_round_patient_pharmacy_drug_history').val(pharmacy_data_history_value);
                EnableSaveButtonForModals();
            }
            checkInputs();



        });

        function checkInputs() {
            var pharmacy_data_history_value = $('#ibox_board_round_patient_pharmacy_drug_history').val();
            var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();
            var patient_screened_val = $('#patient_screened_val').val();
            var content = $('.patient_drug_history_updated_date_partial').text();


            if (pharmacy_data_history_value !== '' || pharmacy_latest_comment !== '' || patient_screened_val !== '' || content !== '') {
                EnableSaveButtonForModals();
            } else {

                EnableSaveButtonForModals();
            }
        }

        $(document).on('click', '.patient_screened', function() {

            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $('#patient_screened_val').val('');
                $('.patient_drug_history_updated_date_partial_pharmasict_screen').html($('.last_pharmacy_screened_time').text());

            }else{
                $(this).addClass('active');
                var patient_screened_date_val = $('#patient_screened_date_val').val();
                var patient_screened_val = $(this).data('patient_screened');
                $('#patient_screened_val').val(patient_screened_val);
                $('.patient_drug_history_updated_date_partial_pharmasict_screen').html(patient_screened_date_val);

            }
            checkInputs();

        });
        $(document).on("input", "#pharmacy_latest_comment", function(e) {
            checkInputs();
            var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();
            if (pharmacy_latest_comment != "") {
                EnableSaveButtonForModals();
            } else {
                DisableSaveButtonForModals();
            }
        });
        $(document).on('click', '.boardround_pharmacy_patient_comment_text_copy', function() {
            var pharmacy_data_copy_id = $(this).data('comment-text-show-id');
            var pharmacy_copy_text = $('.boardround_pharmacy_patient_comment_text_show_' + pharmacy_data_copy_id).html();
            if (pharmacy_copy_text != '') {
                $('#pharmacy_latest_comment').val(pharmacy_copy_text);
            }

        });

        $(document).on('click', '.patient_pharmacy_antibiotic_iv', function() {

            var old_iv_date = $(this).attr('data-old_antibiotic_iv_time');

            var camis_patient_id = $(this).attr('data-camis-patient-id');
            var pharmacy_antibiotic_iv_status = $('.patient_pharmacy_antibiotic_iv_id_'+camis_patient_id).attr('data-antibiotic-iv');

            var now = moment();
            var var_current_time_update = now.format("Do MMM YYYY, HH:mm");
            if(pharmacy_antibiotic_iv_status == 0){
                var iv_status = 1;
                $('.patient_antibiotic_iv_updated_date_'+camis_patient_id).html(var_current_time_update);
            } else {
                $('.patient_antibiotic_iv_updated_date_'+camis_patient_id).html('');
                var iv_status = 0;
            }
            var url = "{{ route('UpdateAntibioticIV') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "camis_patient_id": camis_patient_id,
                    "pharmacy_antibiotic_iv_status": iv_status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {


                        if(iv_status == 1){
                            $('.patient_pharmacy_antibiotic_iv_id_'+camis_patient_id).attr('data-antibiotic-iv', 1);
                        } else {
                            $('.patient_pharmacy_antibiotic_iv_id_'+camis_patient_id).attr('data-antibiotic-iv', 0);
                        }
                        $('.patient_pharmacy_antibiotic_iv_id_'+camis_patient_id).attr('data-data-old_antibiotic_iv_time', var_current_time_update);
                        toastr.success(result.message);
                    } else {
                        $(".patient_antibiotic_iv_updated_date").html(old_iv_date);



                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $(".patient_antibiotic_iv_updated_date").html(old_iv_date);


                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        });



        $(document).on('click', '.patient_pharmacy_antibiotic_oral', function() {

            var old_oral_date = $(this).attr('data-old_antibiotic_oral_time');


            var now = moment();
            var var_current_time_update = now.format("Do MMM YYYY, HH:mm");
            var camis_patient_id = $(this).data('camis-patient-id');
            var pharmacy_antibiotic_oral_status = $('.patient_pharmacy_antibiotic_oral_id_'+camis_patient_id).attr('data-antibiotic-oral');
            if(pharmacy_antibiotic_oral_status == 0){
                var oral_status = 1;
                $('.patient_antibiotic_oral_updated_date_'+camis_patient_id).html(var_current_time_update);

            } else {
                $('.patient_antibiotic_oral_updated_date_'+camis_patient_id).html('');
                var oral_status = 0;
            }
            var url = "{{ route('UpdateAntibioticOral') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "camis_patient_id": camis_patient_id,
                    "pharmacy_antibiotic_oral_status": oral_status
                },
                success: function(result) {
                    if (typeof result.message !== 'undefined') {


                        if(oral_status == 1){
                            $('.patient_pharmacy_antibiotic_oral_id_'+camis_patient_id).attr('data-antibiotic-oral', 1);

                        } else {
                            $('.patient_pharmacy_antibiotic_oral_id_'+camis_patient_id).attr('data-antibiotic-oral', 0);
                        }
                        $('.patient_pharmacy_antibiotic_oral_id_'+camis_patient_id).attr('data-old_antibiotic_oral_time', var_current_time_update);
                        toastr.success(result.message);
                    } else {
                        $(".patient_antibiotic_oral_updated_date").html(old_oral_date);
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $(".patient_antibiotic_oral_updated_date").html(old_oral_date);
                    toastr.warning('{{ ErrorOccuredMessage() }}');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        });
        $(document).ready(function() {
            $(document).on("keydown", ".pharmacy_content_textarea", function(e) {
                var pharmacy_drug_history = $('#ibox_board_round_patient_pharmacy_drug_history').val();
                var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();

                if (pharmacy_drug_history > 0 && pharmacy_latest_comment != '') {
                    EnableSaveButtonForModals();
                }
            });
        });


        $(document).on("click", ".camis_patient_ward_summary_boardround_save_pharmacy_info", function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $('#pharmacy_update_patient_id').val();
            var pharmacy_drug_history = $('#ibox_board_round_patient_pharmacy_drug_history').val();
            var pharmacy_drug_history_date = $('#ibox_board_round_patient_pharmacy_drug_history_date').val();
            var pharmacy_latest_comment = $('#pharmacy_latest_comment').val();
            var patient_screened_val = $('#patient_screened_val').val();
            var patient_screened_date_val = $('#patient_screened_date_val').val();
            $(".ibox_board_round_discharge_planning_tto_updated_date").html('');
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();


            if (camis_patient_id != '') {
                console.log('success');
                var url = "{{ route('UpdatePharmacyStatus') }}";
                $.ajax({
                    url:url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "pharmacy_drug_history": pharmacy_drug_history,
                        "pharmacy_drug_history_date": pharmacy_drug_history_date,
                        "pharmacy_latest_comment": pharmacy_latest_comment,
                        "patient_screened_val": patient_screened_val,
                        "patient_screened_date_val": patient_screened_date_val,
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {
                            CloseOffcanvas('camis_patient_ward_summary_boardround_pharmacy');

                            $('.ibox_board_round_pharmacy_updated_comment_show_'+camis_patient_id).val(result.pharmacy_latest_comment);
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.success(result.message);
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });

        $(document).on("click", ".pharmacy_history_close", function(e) {
            CommonDisableEnableOnSave();

            CommonToHideSubInnerPopupBoardround();
            CloseOffcanvas('camis_patient_ward_summary_boardround_pharmacy_history_modal');


            setTimeout(function() {
                var token = "{{ csrf_token() }}";
                var camis_patient_id = $(this).data('camis-patient-id');

                DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_pharmacy');
                $(".camis_patient_ward_summary_boardround_pharmacy_inner").html('');
                if (camis_patient_id != '') {
                    var url = "{{ route('GetPharmacyStatus') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            "camis_patient_id": camis_patient_id
                        },
                        success: function(result) {

                            if (result != '') {
                                $(".patient_drug_history_tick_icon").css("display", "none");
                                $(".camis_patient_ward_summary_boardround_pharmacy_inner").html(result);
                                var pharmacy_modal = new bootstrap.Offcanvas(document.getElementById('camis_patient_ward_summary_boardround_pharmacy'), {
                                    relatedTarget: 'offcanvasRight',
                                    backdrop: 'static'
                                });
                                pharmacy_modal.show();


                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                DisableSaveButtonForModals();
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
            }, 1000);

        });
    </script>
    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Common.Scripts.Task')
@endsection
