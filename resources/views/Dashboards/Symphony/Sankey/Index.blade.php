@extends('Layouts.Common.MasterLayout')
@section('page-title', 'A&E Sankey')
@section('page-top-title', 'A&E Sankey')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/C3.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/AeSankey.css') }}" />
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />

@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Symphony.Sankey.DataOffcanvas')
@endsection
@section('content')
    <div class="container-fluid refresh-content ">

    </div>

@endsection
@push('custom-script')
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/d3.v7.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/Sankey.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JquerySelectric.js') }}"></script>

    <script>



        $(function() {
            SankeyChartDataLoad('{{ date('Y-m-d') }}', '{{ date('Y-m-d') }}');
        });
        function CommonJsFunctionCallAfterContentRefersh() {
           // SankeyChartDataLoad('');
        }
        $(document).on('click', '.sankeychart_list_search', function() {

            var filter_value_start_date = $('#date_picker_start_date').val();
            var filter_value_end_date = $('#date_picker_end_date').val();
            if (filter_value_start_date == '') {
                $('#date_picker_start_date').datepicker('show');
            } else if (filter_value_end_date == '') {
                $('#date_picker_end_date').datepicker('show');
            } else {
               SankeyChartDataLoad(filter_value_start_date, filter_value_end_date);
            }
        });

        function SankeyChartDataLoad(start_date, end_date) {
            $('.page-data-loader').show();
            $('.site_overview_content_data_load').html('');
            $.ajax({
                url: "{{ route('sankey-chart.dataload') }}",
                type: 'POST',
                data: {
                    "_token": tok,
                    "start_date": start_date,
                    "end_date": end_date,
                },
                success: function(page_load_data) {
                    $('.site_overview_content_data_load').show();
                    setTimeout(function() {
                        $('.refresh-content').html(page_load_data);
                        $('.refresh-content').show();
                        $('.page-data-loader').hide();
                        if ($("#date_picker_end_date").length > 0) {
                        $("#date_picker_end_date").datepicker({
                            format: "dd/mm/yyyy",
                            maxDate: new Date
                        });
                        } else {
                            $("#date_picker_end_date").datepicker();
                        }

                        if ($("#date_picker_start_date").length > 0) {
                            $("#date_picker_start_date").datepicker({
                                format: "dd/mm/yyyy",
                                maxDate: new Date
                            });
                        } else {
                            $("#date_picker_start_date").datepicker();
                        }

                    }, 100);
                    console.log = function () {};
                    console.clear();
                },
                error: function(textStatus, errorThrown) {
                    $('.page-data-loader').hide();
                    $('.site_overview_content_data_load').html('');
                    CommonErrorModalPopupOpen();
                }
            });
        }
        console.error = function() {};
    </script>


@endpush
