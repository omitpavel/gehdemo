@extends('Layouts.Common.MasterLayout')
@section('page-title', 'ED EMS History')
@section('page-top-title', 'ED EMS History')
@section('page-top-title-sub', 'autotimer')
@section('header')
    @parent
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/EdThermometerPopup.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/EmsDataHistory.css') }}" crossorigin="anonymous">
    <link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />
    <style>

        input:not(#daterangepicker),
        select,
        textarea {
            pointer-events: none;
            background-color: #f5f5f5;
        }


    </style>
@endsection

@section('content')
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        function DataPageLoad(date){
            @if(CheckSpecificPermission('opel_data_history_page_view'))
                var token               = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('ed.opel.dataload') }}",
                        type: 'POST',
                        data: { "_token": token, "date": date},
                        success: function (response)
                        {
                            if(response != ""){

                                $('#contentSection_data').html(response);
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err){
                            $('.page-data-loader').hide();
                        }
                    });
                },2000)
            @else
                PermissionDeniedAlert();
            @endif
        }


        $( document ).ready(function()
        {
            DataPageLoad('{{ date('Y-m-d') }}');
        });

        $(document).on("click", ".print_opel_data", function (e){
            var w = window.open();
            var html_to_print = $("#dataEmsHistory").html();

            var title = 'ED Opel History';


            var print_title =
            '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

            var html = print_title +
            '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
            html_to_print + '</div>';

            $(w.document.body).html(html);


            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Selectric.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/EdThermometerPopup.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/EmsDataHistory.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
            $(w.document.head).append('<style>@media print {.no-page-break { page-break-inside: avoid; break-inside: avoid; }}</style>');
            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });


    </script>


@endsection
