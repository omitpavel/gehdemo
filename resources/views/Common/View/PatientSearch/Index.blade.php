@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Patient Search')
@section('page-top-title', 'Patient Search')
@section('page-top-title-sub', 'autotimer')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" >
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/SearchPatients.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeSummary.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}" />

@endpush
@section('modal')
    @include('Common.Modals.BoardRoundInfoModal')
    @include('Common.Modals.CommonModals')
    @include('Common.View.PatientSearch.Modal')
    @include('Common.Modals.CommonDischargeSummary')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
    </div>
@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";

        var ajax_refresh_url = "";
    </script>
    @include('Common.Scripts.CommonDichargeSumamryScript')
    <script>
        function DataPageLoad(search_term) {
            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: "{{ route('global.patient.search.dataload') }}",
                type: 'POST',
                data: {
                    "search_term": search_term,
                    _token: tok
                },
                success: function(result) {
                    $('.refresh-content').html(result);
                    $('.page-data-loader').hide();
                }
            });
        }

        function RemoveUrlParamater(parameter) {
            var url = window.location.href;
            var base_url = url.split('?')[0];
            var query_params = url.split('?')[1] ? url.split('?')[1].split('&') : [];

            var filtered_params = query_params.filter(function(param) {
                return !param.startsWith(parameter + '=');
            });

            var new_url = base_url + (filtered_params.length > 0 ? '?' + filtered_params.join('&') : '');

            history.pushState(null, null, new_url);
        }





        function ANEPatientInfo(id, symphony_atd_num){
            var camis_patient_id = $('#ward_summary_boardround_modal_popup_camis_patient_id').val();
            var token = "{{ csrf_token() }}";
            var pass_number = $('#ward_summary_boardround_modal_popup_camis_patient_pass_number').val();
            $("#symphony_search_prev_attendance_note").html('');
            $("#symphony_search_next_attendance_note").html('');
            $("#symphony_search_curr_attendance_note").html('');
            $("#symphony_data_search_show_data_sec_body").html('');
            $('#modal_patient_list_popup').modal('toggle');

            var ane_discharge_modal = new bootstrap.Offcanvas(document.getElementById('ane_patient_history_all_symphony_data'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'true'
            });

            ane_discharge_modal.show();
            var url = "{{ route('FetchAneDischargeSummary') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "check_pas_id": id,
                    "symphony_atd_num": symphony_atd_num
                },
                success: function(result) {
                    data_ret_html = JSON.parse(result);
                    var current_att_number = data_ret_html.current_attendence_number;
                    var next_att_number = data_ret_html.next_attendence_number;
                    var prev_att_number = data_ret_html.previous_attendence_number;

                    if (prev_att_number != '') {
                        $("#symphony_search_prev_attendance_note").html(' - ' + prev_att_number);
                        $("#symphony_search_patient_popup_back").attr("disabled", false);
                        $('#symphony_search_patient_popup_back').removeClass('inactive');

                    } else {
                        $("#symphony_search_patient_popup_back").attr("disabled", true);
                        $('#symphony_search_patient_popup_back').addClass('inactive');
                    }
                    if (next_att_number != '') {
                        $("#symphony_search_next_attendance_note").html(' - ' + next_att_number);
                        $("#symphony_search_patient_popup_next").attr("disabled", false);
                        $('#symphony_search_patient_popup_next').removeClass('inactive');
                    } else {
                        $("#symphony_search_patient_popup_next").attr("disabled", true);
                        $('#symphony_search_patient_popup_next').addClass('inactive');
                    }
                    if (current_att_number != '') {
                        $(".symphony_search_patient_popup_print").attr("disabled", false);
                        $('.symphony_search_patient_popup_print').removeClass('inactive');
                        $("#symphony_search_curr_attendance_note").html(' ( ' + current_att_number +
                            ' )');
                    }
                    $("#symphony_data_search_show_data_sec_body").html(data_ret_html.returnHTML);
                    DisableLoaderAndMakeVisibleInnerBody();
                },
                error: function(textStatus, errorThrown) {
                    CloseOffcanvas('ane_patient_history_all_symphony_data');
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        }




        @if(request()->has('data') && request()->filled('data'))
            $(document).ready(function() {
                DataPageLoad('{{ request()->data }}');
                RemoveUrlParamater('data');
            });
        @else
            $(document).ready(function() {
                var search_term = $('#search_term').val();
                DataPageLoad(search_term);
            });
        @endif
    </script>

    <script>
        $(document).on("click", ".patient_seacrh_button", function(e) {
            var search_term = $('#search_term').val();
            DataPageLoad(search_term);
        });

        $(document).on("keypress", "#search_term", function(e) {
            var key = e.which;
            if(key == 13)
            {
                var search_term = $('#search_term').val();
                DataPageLoad(search_term);
            }
        });
        function DischargeModalPrint() {
            var id = $('#discharged_patients_print_id').val();
            var url = "{{ route('global.patient.search.inpatients.modal-print',':patientId') }}";
            url = url.replace(':patientId', id);
            var newWindow = window.open(url, '_blank');

        }
        $(document).on("click", ".symphony_search_patient_popup_print", function (e){
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
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/A&EDischargeSummary.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });

    </script>




    <script src="{{ asset('asset_v2') }}/Ibox/Js/custom.js"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Common.Scripts.Task')

@endsection
