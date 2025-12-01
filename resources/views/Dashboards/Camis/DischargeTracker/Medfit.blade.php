@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Med Fit')
@section('page-top-title', 'Med Fit')
@section('header')
    @parent
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" crossorigin="anonymous" />
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" />
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesPatientDetails.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Medfit.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesTimeline.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesCommentHistory.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/Medfit.css') }}" crossorigin="anonymous">
     <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('modal')
    @include('Dashboards.Camis.DischargeTracker.Modals')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2') }}/Generic/Js/toastr.min.js"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    @include('Dashboards.Camis.DischargeTracker.ViewAllcommentScript')


    <script>
        function DataPageLoad(tab){
                var token               = "{{ csrf_token() }}";
                if (!$('#patientDetails').hasClass('show')) {
                    $('.page-data-loader').show();
                }else{
                    $('.page-data-loader').hide();
                }
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.medfit.data.load') }}",
                        type: 'POST',
                        data: { "_token": token, "tab": tab},
                        success: function (response)
                        {
                            if(response != "" && response != "{{ PermissionDenied() }}"){

                                $('#contentSection_data').html(response);
                                $('.page-data-loader').hide();
                            } else {
                                $('.page-data-loader').hide();
                                PermissionDeniedAlert();
                            }
                        },
                        error: function(status, err){
                            $('.page-data-loader').hide();
                        }
                    });
                },2000)
        }



        @if(CheckSpecificPermission('discharge_tracker_medfit_yes_view'))
            $(document).ready(function() {
                DataPageLoad('yes');
            });
        @elseif(CheckSpecificPermission('discharge_tracker_medfit_no_view'))

            $(document).ready(function() {
            DataPageLoad('no');
            });
        @else

            PermissionDeniedAlert();
        @endif






        $(document).on("change", "#care_requirements_pdna_sent", function (e) {
            if ($("#care_requirements_pdna_sent").is(":checked")) {
                var currentTime = moment().format("ddd DD MMM YYYY, HH:mm");
                $(".care_requirements_pdna_sent_date").html(currentTime);
            } else {
                $(".care_requirements_pdna_sent_date").html("");
            }
        });

        function GetMedfitList(service, pathway_type){
            var token               = "{{ csrf_token() }}";
            $('.page-data-loader').show();
            setTimeout(function() {
                $.ajax({
                    _token: token,
                    url: "{{ route('discharged.medfit.yes.contentload') }}",
                    type: 'POST',
                    data: { "_token": token, "service": service, "pathway_type": pathway_type},
                    success: function (response)
                    {
                        if(response != ""){

                            $('#summary_table_data_print').html(response);
                            $('.page-data-loader').hide();
                        }
                    },
                    error: function(status, err){
                        $('.page-data-loader').hide();
                    }
                });
            },2000)
        }


        $(document).on('click', '.medfit_button', function() {
            var token = "{{ csrf_token() }}";
            var tab_content = $(this).data('button-content');
            DataPageLoad(tab_content);
        });

        $(document).on("click", ".discharge_tracker_medfit_yes_print", function (e){
            var w = window.open();
            var html_to_print = $(".medfit_yes_print_content").html();
            var title = 'Discharge Tracker Medfit Yes';
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
            $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/Medfit.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });

        $(document).on("click", ".discharge_tracker_medfit_no_print", function (e){
            var w = window.open();
            var html_to_print = $(".print_medfit_no").html();
            var title = 'Discharge Tracker Medfit No';
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
            $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/Medfit.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });

        $(document).on("click", ".print_patient_list", function (e){
            var w = window.open();
            var html_to_print = $(".medfit_data_print").html();
            var title = $('#medfit_print_title').val();
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
            $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/DischargeTracker.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });
        $(document).on("click", ".export_medfit_no", function (e){
            let csv = [];
                $('.responsiveTable tr').each(function () {
                    let row = [];
                    $(this).find('th, td').each(function () {

                        let cellContent = $(this).clone()
                            .children('.tdBefore')
                            .remove()
                            .end()
                            .text()
                            .trim();
                        row.push(cellContent);
                    });
                    csv.push(row.join(","));
                });

                let csvContent = csv.join("\n");
                let blob = new Blob([csvContent], { type: 'text/csv' });
                let url = URL.createObjectURL(blob);

                let a = document.createElement('a');
                a.href = url;
                a.download = 'Medfit No - Live.csv';
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
        });


        $(document).on("click", ".export_medfit_yes", function (e){
            let csv = [];
                $('.responsiveTable tr').each(function () {
                    let row = [];
                    $(this).find('th, td').each(function () {

                        let cellContent = $(this).clone()
                            .children('.tdBefore')
                            .remove()
                            .end()
                            .text()
                            .trim();
                        row.push(cellContent);
                    });
                    csv.push(row.join(","));
                });

                let csvContent = csv.join("\n");
                let blob = new Blob([csvContent], { type: 'text/csv' });
                let url = URL.createObjectURL(blob);

                let a = document.createElement('a');
                a.href = url;
                a.download = 'Medfit Yes - Live.csv';
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
        });



        $(document).on("click", ".discharge_patient_modal", function (e)
        {
            var camis_patient_id         = $(this).data('camis-patient-id');
            DtocModal(camis_patient_id);
        });



        $(document).on("click", ".dtoc_prev_patient", function (e)
        {
            var camis_patient_id         = $(this).data('camis-prev-patient');
            if(camis_patient_id != ''){
                DtocModal(camis_patient_id);
            }
        });

        $(document).on("click", ".dtoc_next_patient", function (e)
        {

            var camis_patient_id         = $(this).data('camis-next-patient');
            if(camis_patient_id != ''){
                DtocModal(camis_patient_id);
            }
        });


        $(document).on("change", "#dtoc_current_status", function (e)
        {
            var reason_code_value = $('#dtoc_reason_code').val();
            var pathway_value = $('#dtoc_pathway').val();
            var dtoc_current_status = $('#dtoc_current_status').val();
            var dtoc_service = $('#dtoc_service').val();
            var service_id = $(this).children('option:selected').data('service_id');

            EnableSaveButtonForModals();
            if(pathway_value != ''){
                EnableSaveButtonForModals();
            }
        });


        $(document).on("change", "#dtoc_pathway,#dtoc_reason_code,#dtoc_service,#care_requirements_pdna_not_required,#care_requirements_pdna_nurse,#care_requirements_pdna_idt,#care_requirements_pdna_sent,#discharge_pathway", function (e)
        {
            var reason_code_value = $('#dtoc_reason_code').val();
            var pathway_value = $('#dtoc_pathway').val();
            var dtoc_current_status = $('#dtoc_current_status').val();
            var dtoc_service = $('#dtoc_service').val();
            EnableSaveButtonForModals();
            if(pathway_value != ''){
                EnableSaveButtonForModals();
            }
        });

        $(document).on("change", "#care_requirements_pdna_not_required", function (e) {
            if (this.checked) {
                $("#care_requirements_pdna_nurse").prop("disabled", true);
                $("#care_requirements_pdna_idt").prop("disabled", true);
            } else {
                $("#care_requirements_pdna_nurse").prop("disabled", false);
                $("#care_requirements_pdna_idt").prop("disabled", false);
            }
        });

        $(document).on("click", ".comment_history_modal", function (e){
            var camis_patient_id = $('.add_comment').data('camis-patient-id');
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
                                backdrop: false
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





        $(document).on("click", ".comment_initials", function (e)
        {
            var initials_id             = $(this).data('initial-value');
            $(".initial_comment_icon").css("display", "none");
            $("#initial_comment_" + initials_id).css("display", "inline");
            $("#initial_type").val(initials_id);
        });


        $(document).on("click", ".session_comment_initial", function (e)
        {
            var tu_modal_confirmation = new bootstrap.Modal(document.getElementById('set_tu_for_default'), {
                backdrop: 'static'
            });
            tu_modal_confirmation.show();
        });


        $(document).on("click", ".dtoc_tu_set_default_patient", function (e)
        {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('discharged.save.tu.default') }}",
                type: 'POST',
                data: {
                    "_token": token,
                },
                success: function(result) {
                    if (result != '') {
                        $(".initial_comment_icon").css("display", "none");
                        $("#initial_comment_TU").css("display", "inline");
                        $("#initial_type").val('TU');
                        $('.session_comment_initial').addClass('comment_initials');
                        $('.session_comment_initial').removeClass('session_comment_initial');
                        $('#set_tu_for_default').modal('hide');
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
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
        function RemoveBackdrop() {
            $('.modal').modal('hide');

            $('.modal-backdrop').remove();

        }
    </script>

@endsection
