@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Site Overview')
@section('page-top-title', 'Site Overview')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/clockpicker.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/SiteOverview.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous">
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />

@endpush
@section('modal')
@include('Dashboards.Camis.SiteOverview.Modal')
@endsection
@section('content')
    <div class="container-fluid refresh-content">
    </div>
    <input type="hidden" id="selected_date">
    <input type="hidden" id="medfit_modal_type" value="0">
    <input type="hidden" id="therapy_modal_type" value="0">
@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";
        var ajax_refresh_url = "{{ route('inpatients.siteoverview.dataload') }}";
    </script>

    <script>
        function DataPageLoad() {
            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: "{{ route('inpatients.siteoverview.dataload') }}",
                type: 'GET',
                data: {
                    _token: tok
                },
                success: function(result) {
                    $('.refresh-content').html(result);
                    $('.page-data-loader').hide();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    $('.page-data-loader').hide();
                }
            });
        }


        $(document).ready(function() {
            DataPageLoad();
        });


        $(document).on("click", ".click_open_ane_details", function(e) {
            var type = $(this).data('type');
            var key = $(this).data('key');
            if(type != '' && key != ''){
                $('.ane_patient_list').html('');
                var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('ane_patient_details_offcanvas'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                board_round_report_offcanvas.show();
                EnableLoaderAndMakeHiddenInnerBody();

                $.ajax({
                    _token: tok,
                    url: "{{ route('inpatients.siteoverview.ane') }}",
                    type: 'GET',
                    data: {
                        _token: tok,
                        'type': type,
                        'key' : key
                    },
                    success: function(result) {
                        DisableLoaderAndMakeVisibleInnerBody();

                        $('.ane_patient_list').html(result);


                    },
                    error: function(textStatus, errorThrown) {

                        CloseOffcanvas('bedDetails');

                    }
                });
            } else {
                toastr.warning('Something Went Wrong');
            }
        });

        $(document).on("click", ".click_open_all_bed", function(e) {
            var type = $(this).data('type');

            if(type == 'restricted' || type == 'empty'){
                var data_type = 'bed_only';
                $('.patient_bed_empty').html('');
                var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('emptyBedDetails'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                board_round_report_offcanvas.show();
                EnableLoaderAndMakeHiddenInnerBody();
            } else {
                var data_type = 'all';
                $('.patient_bed_list').html('');
                var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('bedDetails'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                board_round_report_offcanvas.show();
                EnableLoaderAndMakeHiddenInnerBody();
            }
            $.ajax({
                _token: tok,
                url: "{{ route('inpatients.siteoverview.bedwisepatient') }}",
                type: 'GET',
                data: {
                    _token: tok,
                    'type': type,
                    'data_type': data_type
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();
                    if(type == 'restricted' || type == 'empty'){
                        $('.patient_bed_empty').html(result);
                    } else {
                        $('.patient_bed_list').html(result);
                    }

                },
                error: function(textStatus, errorThrown) {
                    if(type == 'restricted' || type == 'empty'){
                        CloseOffcanvas('emptyBedDetails');
                    } else {
                        CloseOffcanvas('bedDetails');
                    }
                }
            });
        });

        $(document).on("change", "#cdt_status_medfit, #therapy_status_medfit", function(e) {

            var medfit = $('#medfit_modal_type').val();
            $('.cdt_medfit_patient_list').html('');
            if(medfit == 1){
                $('.medfit_patient_modal_title').html('Medically Fit Yes');
            } else {
                $('.medfit_patient_modal_title').html('Medically Fit No');
            }
            var cdt_status = $('#cdt_status_medfit').val();
            var therapy_status = $('#therapy_status_medfit').val();

            EnableLoaderAndMakeHiddenInnerBody();

            $.ajax({
                _token: tok,
                url: "{{ route('inpatients.siteoverview.medfit_patient') }}",
                type: 'GET',
                data: {
                    _token: tok,
                    'cdt_status': cdt_status,
                    'therapy_status': therapy_status,
                    'medfit': medfit
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();

                    $('.cdt_medfit_patient_list').html(result);


                },
                error: function(textStatus, errorThrown) {

                        CloseOffcanvas('MedfitDetails');

                }
            });
        });
        $(document).on("click", ".click_open_medfit_patient", function(e) {

            var medfit = $(this).data('medfit');

            $('#medfit_modal_type').val(medfit);

            var data_type = 'all';
            $('.cdt_medfit_patient_list').html('');
            if(medfit == 1){
                $('.medfit_patient_modal_title').html('Medically Fit Yes');
            } else {
                $('.medfit_patient_modal_title').html('Medically Fit No');
            }
            $('#cdt_status_medfit').val('').selectric('refresh');
            $('#therapy_status_medfit').val('').selectric('refresh');

            var cdt_status = $('#cdt_status_medfit').val();
            var therapy_status = $('#therapy_status_medfit').val();

            var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('MedfitDetails'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            board_round_report_offcanvas.show();
            EnableLoaderAndMakeHiddenInnerBody();

            $.ajax({
                _token: tok,
                url: "{{ route('inpatients.siteoverview.medfit_patient') }}",
                type: 'GET',
                data: {
                    _token: tok,
                    'cdt_status': cdt_status,
                    'therapy_status': therapy_status,
                    'medfit': medfit
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();

                    $('.cdt_medfit_patient_list').html(result);


                },
                error: function(textStatus, errorThrown) {

                        CloseOffcanvas('MedfitDetails');

                }
            });
        });


        $(document).on("change", "#cdt_status_therapy, #medfit_status_therapy", function(e) {

            var therapy = $('#therapy_modal_type').val();

            var data_type = 'all';
            $('.cdt_therapy_patient_list').html('');
            if(therapy == 1){
                $('.therapy_patient_modal_title').html('Therapy Fit Yes');
            } else {
                $('.therapy_patient_modal_title').html('Therapy Fit No');
            }
            var cdt_status = $('#cdt_status_therapy').val();
            var medfit_status = $('#medfit_status_therapy').val();


            EnableLoaderAndMakeHiddenInnerBody();

            $.ajax({
                _token: tok,
                url: "{{ route('inpatients.siteoverview.therapy_patient') }}",
                type: 'GET',
                data: {
                    _token: tok,
                    'cdt_status': cdt_status,
                    'medfit_status': medfit_status,
                    'therapy': therapy
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();

                    $('.cdt_therapy_patient_list').html(result);


                },
                error: function(textStatus, errorThrown) {

                        CloseOffcanvas('therapyDetails');

                }
            });
        });

        $(document).on("click", ".click_open_therapy_patient", function(e) {

            var therapy = $(this).data('therapy');
            $('#therapy_modal_type').val(therapy);


            var data_type = 'all';
            $('.cdt_therapy_patient_list').html('');
            if(therapy == 1){
                $('.therapy_patient_modal_title').html('Therapy Fit Yes');
            } else {
                $('.therapy_patient_modal_title').html('Therapy Fit No');
            }
            $('#cdt_status_therapy').val('').selectric('refresh');
            $('#medfit_status_therapy').val('').selectric('refresh');

            var cdt_status = $('#cdt_status_therapy').val();
            var medfit_status = $('#medfit_status_therapy').val();



            var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('therapyDetails'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            board_round_report_offcanvas.show();
            EnableLoaderAndMakeHiddenInnerBody();

            $.ajax({
                _token: tok,
                url: "{{ route('inpatients.siteoverview.therapy_patient') }}",
                type: 'GET',
                data: {
                    _token: tok,
                    'cdt_status': cdt_status,
                    'medfit_status': medfit_status,
                    'therapy': therapy
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();

                    $('.cdt_therapy_patient_list').html(result);


                },
                error: function(textStatus, errorThrown) {

                        CloseOffcanvas('therapyDetails');

                }
            });
        });





        $(document).on("click", ".click_open_discharge_bed", function(e) {
            var type = $(this).data('type');


            $('.patient_bed_list').html('');
            var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('bedDetails'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            board_round_report_offcanvas.show();
            EnableLoaderAndMakeHiddenInnerBody();

            $.ajax({
                _token: tok,
                url: "{{ route('inpatients.siteoverview.discharge') }}",
                type: 'GET',
                data: {
                    _token: tok,
                    'type': type
                },
                success: function(result) {
                    DisableLoaderAndMakeVisibleInnerBody();

                    $('.patient_bed_list').html(result);


                },
                error: function(textStatus, errorThrown) {

                    CloseOffcanvas('bedDetails');

                }
            });
        });

        function GetBoardRoundReport(ward_type, board_round_type){
            var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('directorateBoardroundReport'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            board_round_report_offcanvas.show();
            EnableLoaderAndMakeHiddenInnerBody();
            $('.board_round_report_result').html('');
            var token = "{{ csrf_token() }}";
            var url = "{{ route('inpatients.siteoverview.boardroundreport') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    'ward_type': ward_type,
                    'board_round_type': board_round_type
                },
                success: function(result) {
                    $('.board_round_report_result').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    CloseOffcanvas('directorateBoardroundReport');
                }
            });
        }

    </script>






    <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

@endsection
