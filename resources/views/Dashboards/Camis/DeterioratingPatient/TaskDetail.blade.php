@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Deteriorating Patient Virtual Ward')
@section('page-top-title', 'DETERIORATING PATIENT')
@section('page-top-title-sub', 'autotimer')

@section('header')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TaskDetails.css') }}" crossorigin="anonymous">
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('modal')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row date-range">
                <div class="col-lg-3 col-md-4 pe-md-1 mb-2">
                    <div>
                        <select class="form-select w-100" aria-label="Default select example" id="ward_filter_id">
                            <option value="">All Wards</option>
                            @foreach ($all_wards as $id => $ward)
                                <option value="{{ $id }}">{{ $ward }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-xl-4 col-lg-6 col-md-8 ps-md-1 mb-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Select Date</span>
                        <input type="text" class="form-control" aria-describedby="basic-addon1"
                            id="daterangepicker">
                    </div>
                </div>
                <input type="hidden" name="start_date" id="start_date" value="{{request()->start_date}}">
                <input type="hidden" name="end_date" id="end_date" value="{{request()->end_date}}">

            </div>
            <div class="row mb-3">
                <div class="container-fluid refresh-content">

                </div>
            </div>
        </div>

    </div>
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

        var ward_id = $('#ward_filter_id').val();
        var from_date = $('#start_date').val();
        var to_date = $('#end_date').val();
        var ajax_refresh_url = '{{ route('task_details.filter') }}?ward_id='+ward_id+'&from_date='+from_date+'&to_date='+to_date;
    </script>


    <script>




        function FilterTaskSummary(){
            @if(CheckSpecificPermission('dp_dashboard_task_details_view'))
                var ward_id = $('#ward_filter_id').val();
                var from_date = $('#start_date').val();
                var to_date = $('#end_date').val();
                $('.page-data-loader').show();
                $.ajax({
                    _token: tok,
                    url: '{{ route('task_details.filter') }}',
                    type: 'GET',
                    data: {
                        "ward_id": ward_id,
                        "from_date": from_date,
                        "to_date": to_date,
                    },
                    success: function(result) {
                        $('.refresh-content').html(result);
                        $('.page-data-loader').hide();
                    }
                });
            @else
                PermissionDeniedAlert();
            @endif
        }
        $(document).on("change", "#ward_filter_id", function(e) {
            FilterTaskSummary();
        });


        @if(request()->filled('start_date') && request()->filled('end_date'))
            var start = moment('{{request()->start_date}}', 'YYYY-MM-DD');
            var end = moment('{{request()->end_date}}', 'YYYY-MM-DD');
        @else
            var start = moment().startOf('month');
            var end = moment();
        @endif
        function cb(start, end) {
            $('#daterangepicker').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            FilterTaskSummary();
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

        cb(start, end);
    </script>


    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

@endsection
