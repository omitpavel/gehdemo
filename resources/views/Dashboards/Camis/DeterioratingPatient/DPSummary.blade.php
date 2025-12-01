@extends('Layouts.Common.MasterLayout')
@section('page-title', 'DP Task Summary')
@section('page-top-title', 'DP Task Summary')
@section('page-top-title-sub', 'autotimer')
@section('header')
    @parent
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">

    <script src="{{ asset('asset_v2/Template/js/ApexCharts.js') }}"></script>
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TaskDetails.css') }}" crossorigin="anonymous">
@endsection

@section('modal')

    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            DailySummaryData('{{ date('Y-m-01') }}', '{{ date('Y-m-d') }}');
        });

        $(document).on("change", "#month", function(e) {
            var month          = $('#month').val();
            WardSummaryData(month);
        });
        function CommonJsFunctionCallAfterContentRefersh(){
            MultiSelectJs('ward_id', 'Ward');
        }

        function WardSummaryData(selected_date) {
            var url = "{{ route('DPSummaryMenu.data.load') }}";
            $('#tab_type').val(type);
            $('.page-data-loader').show();
            var type          = 'ward_summary';
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {"_token": token, tab_type:type, selected_date: selected_date},
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
        $(document).on("change", "#ward_id", function(e) {
            console.log('ward_id changed');

            var task_start_date = $('#start_date').val();
            var task_end_date = $('#end_date').val();

            var start, end;

            if(task_start_date != '' && task_end_date != '') {
                start = moment(task_start_date, 'YYYY-MM-DD');
                end = moment(task_end_date, 'YYYY-MM-DD');
            } else {
                start = moment().startOf('month');
                end = moment();
            }

            WardWiseFilter(start, end);
        });

        function WardWiseFilter(start, end) {

            $('#daterangepicker').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            DailySummaryData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }


        function DailySummaryData(start_date, end_date) {
            var url = "{{ route('DPSummaryMenu.data.load') }}";
            $('#tab_type').val(type);
            var ward_id = $('#ward_id').val();
            console.log(ward_id);
            $('.page-data-loader').show();
            var type          = 'daily_summary';
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {"_token": token,"ward_id":ward_id, tab_type:type, start_date: start_date, end_date: end_date},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('#contentSection_data').html(result);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.page-data-loader').hide();
                        DateRangeOnDailySummary();
                    } else {
                        $('.page-data-loader').hide();
                        toastr.error('Permission Restricted.');
                    }
                }
            });
        }
        function DateRangeOnDailySummary(){
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
                DailySummaryData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    </script>

@endsection
