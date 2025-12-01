@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Notifications')
@section('page-top-title', 'Notifications')
@section('page-top-title-sub', 'autotimer')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" >
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" >
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
@endpush

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
    <script>
        function DataPageLoad() {
            $('.page-data-loader').show();
            var date = $('#start_date_day_summary_val').val();
            var type = $('#type').val();
            var search_text = $('#search_text').val();
            $.ajax({
                _token: tok,
                url: "{{ route('notification.refresh') }}",
                type: 'POST',
                data: {
                    _token: tok,
                    "date": date,
                    "type": type,
                    "search_text":search_text
                },
                success: function(result) {
                    $('.refresh-content').html(result);
                    $('.page-data-loader').hide();
                }
            });
        }
        $(document).ready(function() {
            DataPageLoad();
        });
        $(document).on('change', '#type', function(e) {
            DataPageLoad();
        });
        $(document).on('click', '.submit_button', function(e) {
            DataPageLoad();
        });
    </script>




    <script src="{{ asset('asset_v2') }}/Ibox/Js/custom.js"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

@endsection
