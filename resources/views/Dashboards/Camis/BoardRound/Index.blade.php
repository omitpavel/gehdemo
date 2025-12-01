@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Board Round Report')
@section('page-top-title', 'Board Round Report')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRound.css') }}" crossorigin="anonymous">

    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
@endpush
@section('modal')
    @include('Dashboards.Camis.BoardRound.Modal')
@endsection
@section('content')
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
        var ajax_refresh_url = "{{ route('board_round.content') }}";
    </script>
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>

    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>

<script>
        let interval;

    	@if(CheckSpecificPermission('board_round_dashboard_current_week_view'))
            $(document).ready(function() {
                TabType('current');
            });

        @elseif(CheckSpecificPermission('board_round_dashboard_month_summary_view'))

            $(document).ready(function() {
                MonthSummary(1);
            });
        @elseif(CheckSpecificPermission('board_round_dashboard_week_summary_view'))

            $(document).ready(function() {
                TabType('week');
            });
        @elseif(CheckSpecificPermission('board_round_dashboard_attendance_view'))

            $(document).ready(function() {
                TabType('attendence');
            });
        @elseif(CheckSpecificPermission('board_round_dashboard_today_view'))

            $(document).ready(function() {
                TabType('today');
            });
        @elseif(CheckSpecificPermission('board_round_dashboard_all_view'))

            $(document).ready(function() {
                TabType('all');
            });

        @endif




</script>

<script>
    $(document).on("change", "#ward_id,#tab_type,#discharge_type", function (e)
    {
        clearInterval(interval);
        var ward_id                 = $('#ward_id').val();
        var tab_type               = $('#tab_type').val();
        var discharge_type          = $('#discharge_type').val();
        var discharge_day           = $('#discharge_day').val();
        var task_start_date = '';
        var task_end_date = '';
        task_start_date = $('#start_date').val();
        task_end_date = $('#end_date').val();
        if (typeof task_start_date === 'undefined' &&  typeof task_end_date === 'undefined') {
            task_start_date = "{{ date('Y-m-01') }}";
            task_end_date = "{{ date('Y-m-t') }}";
        }
        var url = "{{ route('board_round.content') }}";
        $('.page-data-loader').show();
        $.ajax({
            url: url,
            type: 'GET',
            data: { "ward_id": ward_id,tab_type:tab_type,start_date:task_start_date,end_date:task_end_date},
            success: function (result)
            {
                if(result != '{{PermissionDenied()}}'){
                    startCycle();
                    $('#contentSection_data').html(result);
                    if(tab_type === 'all'){
                        DateRangeOnDailySummary();
                    }
                    if(tab_type == 'today' || tab_type == 'all'){
                        MultiSelectJs('ward_id', 'Ward');
                    }
                    $('.page-data-loader').hide();
                } else {
                    $('.page-data-loader').hide();
                    toastr.error('Permission Restricted.');
                }

            }
        });
    });
</script>

    <script>
        $(document).on("change", "#attendence_week_data", function (e)
        {
            clearInterval(interval);
            var tab_type               = $('#tab_type').val();
            var attendence_week_data          = $('#attendence_week_data').val();
            var url = "{{ route('board_round.content') }}";
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: { "attendence_week_data": attendence_week_data,tab_type:tab_type },
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        startCycle();
                        $('#contentSection_data').html(result);
                        if(tab_type == 'today' || tab_type == 'all'){
                            MultiSelectJs('ward_id', 'Ward');
                        }
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }

                }
            });
        });
    </script>

    <script>
        $(document).on("change", "#attendence_week_date", function (e)
        {
            clearInterval(interval);
            var tab_type               = $('#tab_type').val();
            var attendence_week_date          = $('#attendence_week_date').val();
            var url = "{{ route('board_round.content') }}";
            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: { "attendence_week_date": attendence_week_date,tab_type:tab_type },
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        startCycle();
                        $('#contentSection_data').html(result);
                        if(tab_type == 'today' || tab_type == 'all'){
                            MultiSelectJs('ward_id', 'Ward');
                        }
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }

                }
            });
        });
    </script>


    <script>

        $(document).on("click", ".include_weekend", function (e)
        {
            $('.include_weekend').removeClass('active');
            $(this).addClass('active');
            var include_weekend = $(".btn-group .include_weekend.active").data("include_type");
            MonthSummary(include_weekend);

        });
        $(document).on("change", "#selected_date", function (e)
        {

            var include_weekend = $(".btn-group .include_weekend.active").data("include_type");
            MonthSummary(include_weekend);

        });
        function MonthSummaryTabClick(include_weekend) {
            var url = "{{ route('board_round.content') }}";
            var type = 'month';

            var selected_date = $('#selected_date option:first').val();

            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {tab_type:type,selected_date:selected_date,include_weekend:include_weekend},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){

                        $('#contentSection_data').html(result);
                        if(type == 'today' || type == 'all'){
                            MultiSelectJs('ward_id', 'Ward');
                        }

                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }
                }
            });
        }


        function MonthSummary(include_weekend) {
            var url = "{{ route('board_round.content') }}";
            var type = 'month';

            var selected_date = $('#selected_date').val();

            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {tab_type:type,selected_date:selected_date,include_weekend:include_weekend},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('#contentSection_data').html(result);
                        if(type == 'today' || type == 'all'){
                            MultiSelectJs('ward_id', 'Ward');
                        }
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
        function TabType(type) {
            clearInterval(interval);
            var url = "{{ route('board_round.content') }}";
            $('#tab_type').val(type);
            var ward_id                 = '';

            var task_start_date = "{{ date('Y-m-01') }}";
            var task_end_date = "{{ date('Y-m-t') }}";

            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {ward_id:ward_id,tab_type:type,start_date:task_start_date,end_date:task_end_date},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        startCycle();
                        $('#contentSection_data').html(result);
                        if(type === 'all'){
                            DateRangeOnDailySummary('reload_now');
                        }
                        if(type == 'today' || type == 'all'){
                            MultiSelectJs('ward_id', 'Ward');
                        }
                        console.log(tab_type);
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
            clearInterval(interval);
           var url = "{{ route('board_round.content') }}";
           var tab_type               = $('#tab_type').val();
           var ward_id                 = $('#ward_id').val();
           var task_start_date = '';
           var task_end_date = '';
           task_start_date = $('#start_date').val();
           task_end_date = $('#end_date').val();
           if (typeof task_start_date === 'undefined' &&  typeof task_end_date === 'undefined') {
               task_start_date = "{{ date('Y-m-01') }}";
               task_end_date = "{{ date('Y-m-t') }}";
           }
           $('.page-data-loader').show();
           $.ajax({
               url: url,
               type: 'GET',
               data: {ward_id:ward_id,tab_type:tab_type,start_date:task_start_date,end_date:task_end_date},
               success: function (result)
               {
                   if(result != '{{PermissionDenied()}}'){
                        startCycle();
                       $('#contentSection_data').html(result);
                       if(tab_type == 'today' || tab_type == 'all'){
                            MultiSelectJs('ward_id', 'Ward');
                        }
                       if(tab_type === 'all'){
                           DateRangeOnDailySummary();
                       }
                       $('.page-data-loader').hide();
                   } else {
                       $('.page-data-loader').hide();
                       toastr.error('Permission Restricted.');
                   }
               }
           });
       }

       function startCycle() {
            clearInterval(interval);
            interval = setInterval(function() {
                AutoLoad();
            }, 180000);
        }


    </script>
    <script>
        function TabType_Date(type) {
            clearInterval(interval);
            var url = "{{ route('board_round.content') }}";
            $('#tab_type').val(type);
            var ward_id                 = '';

            var task_start_date = $('#start_date').val();
            var task_end_date = $('#end_date').val();

            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {ward_id:ward_id,tab_type:type,start_date:task_start_date,end_date:task_end_date},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        startCycle();
                        $('#contentSection_data').html(result);
                        if (type === 'all' || type === undefined) {
                            DateRangeOnDailySummary();
                        }
                        if(type == 'today' || type == 'all'){
                            MultiSelectJs('ward_id', 'Ward');
                        }
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }
                }
            });
        }
        function DateRangeOnDailySummary(reload_page){
            var task_start_date = $('#start_date').val();
            var task_end_date = $('#end_date').val();
            if(task_start_date != '' && task_end_date != ''){
                var start = moment(task_start_date, 'YYYY-MM-DD');
                var end = moment(task_end_date, 'YYYY-MM-DD');
            } else {
                var start = moment().startOf('month');
                var end = moment();
            }

            function cb(start, end) {
                $('#daterangepicker').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#start_date').val(start.format('YYYY-MM-DD'));
                $('#end_date').val(end.format('YYYY-MM-DD'));
                TabType_Date('all');
            }

            $('#daterangepicker').daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: 'MMMM D, YYYY'},
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

        }

    $(document).on("click", ".click_view_parital_data", function(e) {
        var token = "{{ csrf_token() }}";
        DisableButtonClickForPreventFurtherEvent('click_view_parital_data');

        $('.missing_board_round_patient_list').html('');
        var missung_board_round_offcanvas = new bootstrap.Offcanvas(document.getElementById('missung_board_round_offcanvas'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });


        missung_board_round_offcanvas.show();
        var ward_id = $(this).data('ward-id');
        var session = $(this).data('session-id');
        var date = $(this).data('date');
        var time = $(this).data('time');
        var url = "{{ route('FetchPatialPatientList') }}";
        if(session == ''){
            toastr.warning('No Data Available');
            CloseOffcanvas('missing_board_round_patient_list');

        } else {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "ward_id": ward_id,
                    "session": session,
                    "date": date,
                    "time": time,
                },
                success: function(result) {

                        if (typeof result !== '') {


                            $('.missing_board_round_patient_list').html(result.html_sections);

                            DisableLoaderAndMakeVisibleInnerBody();

                        } else {
                            CloseOffcanvas('missing_board_round_patient_list');
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                error: function(textStatus, errorThrown) {

                    CloseOffcanvas('missing_board_round_patient_list');

                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        }


    });
    </script>

@endsection
