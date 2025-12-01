@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Deteriorating Patients Search')
@section('page-top-title', 'Deteriorating Patients Search')
@section('page-top-title-sub', 'autotimer')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PatientsSearch.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Timeline.css') }}" crossorigin="anonymous">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row date-range">
                <div class="col-lg-3 col-md-4 pe-md-1 mb-2">
                    <div>
                        <input class="form-control" type="text" placeholder="Search by Hospital Number" aria-label="default input example"
                            id="patient_search_all">
                    </div>

                </div>
                <div class="col-lg-1 col-md-2 ps-md-1 mb-2">
                    <div>
                        <button class="btn btn-search" id="btn_patient_search">Search</button>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="container-fluid" id="patientSearchData">
                    <div class="pt-4 custom_not_found">{{ NotFoundMessage() }}</div>
                </div>
            </div>
        </div>
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

    <script>



        $(document).on('click', '.dp_no_task', function() {
            toastr.warning('No Records Found');
        });

        $(document).on('click', '#btn_patient_search', function() {
            $('.loader-bg').show();
            var search_data = $('#patient_search_all').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('get.patient.search.data') }}',
                data: {
                    '_token': token,
                    'search_data': search_data
                },
                success(result) {
                    $('#patientSearchData').html(result);
                    $('.loader-bg').hide();
                }
            });
        });

        function dp_patient_timeline(camis_patient_id, date_value){
            $('.loader-bg').show();

            DisableLoaderAndMakeVisibleInnerBody();

            var deteriorating_patient_modal = new bootstrap.Modal(document.getElementById('timeline'), {
                backdrop: 'static'
            });


            deteriorating_patient_modal.show();


            var token = "{{ csrf_token() }}";
            if (typeof date_value !== 'undefined') {
                var date = date_value;
            } else {
                var date = '';
            }
            $.ajax({
                url: "{{ url('/inpatients/dashboards/ward-summary/board-round/fetch-deteriorating_patient_timeline') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "camis_patient_id": camis_patient_id,
                    "date": date
                },
                success: function(result) {

                    if (typeof result.message !== 'undefined') {
                        if(result.data_count !== 1){
                            $('#print_dp_timeline').removeClass('print_dp_timeline');
                            $('#print_dp_timeline').addClass('disabled');
                        }else{
                            $('#print_dp_timeline').addClass('print_dp_timeline');
                            $('#print_dp_timeline').removeClass('disabled');
                        }

                        $("#dp_task").html(result.data);
                            $.getScript('/asset_v2/Ibox/Js/timeline.js', function() {
                        });
                        $('.loader-bg').hide();
                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        $('.loader-bg').hide();
                        CommonErrorModalPopupOpenOnRequest();
                    }
                },
                error: function(textStatus, errorThrown) {
                    $('.loader-bg').hide();
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        }
        $(document).on("click", ".print_dp_timeline", function (e){
            var w = window.open();
            var html_to_print = $(".dp_print_section").html();
            var formatted_current_time = $("#dp_select_date").val();
            var title = 'DETERIORATING PATIENT TIMELINE';
            var print_title = `
                <div style="position: relative; padding-top: 16px; padding-bottom: 20px; text-align: center;">
                    <div class="print_title_star_styling_head"
                        style="font-size: 15px; font-weight: 600;">
                        ${title}
                    </div>
                    <div class="formatted_time"
                        style="font-size: 12px; font-weight: 400;">
                        ${formatted_current_time}
                    </div>
                </div>
            `;


            var html = print_title +
            '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
            html_to_print + '</div>';

            $(w.document.body).html(html);
            $(w.document.body).find('.timeline').remove();

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


    </script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
@endsection
