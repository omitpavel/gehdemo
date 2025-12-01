@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Site Office Text Reports')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/summernote/summernote.min.css') }}" crossorigin="anonymous" />
@endpush

@section('page-top-title', 'Site Office Text Reports')
@section('page-top-title-sub', 'autotimer')

@section('content')
    <div class="container-fluid" id="ajax_data">
    </div>

@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/summernote/summernote.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>


    <script>
        function DataPageLoad() {
                $('.page-data-loader').show();
                $.ajax({
                    _token: "{{ csrf_token() }}",
                    url: '{{ route('site.office.dataload') }}',
                    type: 'GET',
                    success: function(result) {
                        $('.page-data-loader').hide();

                        $('#ajax_data').html(result);
                    }
                });

        }
        $( document ).ready(function()
        {

            DataPageLoad();
        });

        $(document).on('click', '#click_show', function () {
            $("#click_show").css("display", "none");
            $("#click_hide").css("display", "block");
            $("#office_text_duplicate_div").css("display", "block");
        });
        $(document).on('click', '#click_hide', function () {
            $("#click_hide").css("display", "none");
            $("#click_show").css("display", "block");
            $("#office_text_duplicate_div").css("display", "none");
        });
        $(document).on('click', '.show_hide_last_message', function () {
            $(".last_message_textarea").toggle();
        });

        $(document).on('click', '.save_office_reports', function () {
            @if(CheckDashboardPermission('site_office_report_update'))
                var text_office_reports = $("#current_text").val();
                if (text_office_reports != "") {

                    var token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ route('site.office.report.save') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "text_office_reports": text_office_reports
                        },
                        success: function(result) {
                                if (typeof result.message !== 'undefined') {
                                    toastr.success(result.message);
                                    $('#previous_text').summernote('code', result.previous_text);
                                } else {
                                    toastr.warning(script_error_message);

                                }

                        },
                        error: function(textStatus, errorThrown) {
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                        }
                    });

                } else {
                    toastr.warning('Please Enter Reports');
                }
            @else
                toastr.error('Permission Denied');
            @endif
        });


        $(document).on("click", ".print_office_reports", function (e){
            @if(CheckDashboardPermission('site_office_report_print'))
                var print_title =
                '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">Site Office Text Reports </div>';
                var html_to_print = $("#current_text").val();
                var printContents = print_title +
                '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
                html_to_print + '</div>';
                var newWin = window.open('', 'Print-Window');
                newWin.document.open();
                newWin.document.write('<html><style>' +
                    '@import url("{{ asset('asset_v2/Template/Css/Style.css') }}");' +
                    '</style><body onload="window.print()"><div class="ae-summary-offcanvas">' + printContents +'</div></body></html>');

                var buttons = newWin.document.getElementsByTagName('button');
                for (var i = 0; i < buttons.length; i++) {
                buttons[i].style.display = 'none';
                }
                setTimeout(function () {
                    newWin.print();
                    newWin.close();
                }, 1000);
            @else
                toastr.error('Permission Denied');
            @endif
        });
    </script>

@endsection
