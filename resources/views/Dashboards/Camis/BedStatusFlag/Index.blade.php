@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Bed Status Flags Dashboard')
@section('page-top-title', 'BED STATUS FLAGS DASHBOARD')
@section('page-top-title-sub', 'autotimer')


@section('header')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BedFlagDashboard.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/BedFlagDashboardCustom.css') }}" crossorigin="anonymous">

@endsection



@section('modal')

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
        var ajax_refresh_url = "";
    </script>




    <script type="text/javascript">


        $(document).on('click', '.search_flag_data', function() {
            $('.page-loader').show();
            var selected = $("#flags_selected_data_val option:selected");

            var flag_sel = "";

            selected.each(function() {
                if (flag_sel != "") {
                    flag_sel += ",";
                }
                flag_sel += $(this).val();
            });

            var ward_option_tab2 = $("#ward_option_tab2").val()
            var selected_tab2 = $("#flags_selected_data_val_tab2 option:selected");
            var flag_sel_tab2 = "";
            selected_tab2.each(function() {
                if (flag_sel_tab2 != "") {
                    flag_sel_tab2 += ",";
                }
                flag_sel_tab2 += $(this).val();
            });

            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('bed.status.flag.filter') }}',
                type: 'POST',
                data: {
                    "flag_sel": flag_sel,
                    "ward_option_tab2": ward_option_tab2,
                    "flag_sel_tab2": flag_sel_tab2,
                    "_token": token
                },
                success: function(result) {
                    $(".refresh-content").html(result);
                    MultiSelectJs('ward_option_tab2', 'Ward');
                    $('#flags_selected_data_val_tab2').multiselect({
                        columns: 1,
                        placeholder: 'Select ',
                        search: true,
                        searchOptions: {
                            'default': 'Search'
                        },
                        selectAll: true
                    });

                    $(".refresh-content").css("display", "inline-block");
                    $(".page-loader").hide();
                }
            });

        });

        $(document).ready(function () {
            $('.page-loader').show();

            var selected = $("#flags_selected_data_val option:selected");

            var flag_sel = "";

            selected.each(function() {
                if (flag_sel != "") {
                    flag_sel += ",";
                }
                flag_sel += $(this).val();
            });

            var ward_option_tab2 = $("#ward_option_tab2").val()
            var selected_tab2 = $("#flags_selected_data_val_tab2 option:selected");
            var flag_sel_tab2 = "";
            selected_tab2.each(function() {
                if (flag_sel_tab2 != "") {
                    flag_sel_tab2 += ",";
                }
                flag_sel_tab2 += $(this).val();
            });

            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('bed.status.flag.filter') }}',
                type: 'POST',
                data: {
                    "flag_sel": flag_sel,
                    "ward_option_tab2": ward_option_tab2,
                    "flag_sel_tab2": flag_sel_tab2,
                    "_token": token
                },
                success: function(result) {
                    $(".refresh-content").html(result);
                    MultiSelectJs('ward_option_tab2', 'Ward');
                    $('#flags_selected_data_val_tab2').multiselect({
                        columns: 1,
                        placeholder: 'Select ',
                        search: true,
                        searchOptions: {
                            'default': 'Search'
                        },
                        selectAll: true
                    });

                    $(".refresh-content").css("display", "inline-block");
                    $(".page-loader").hide();
                }
            });

        });



    </script>
    <script>
        function printBedStatusFlag() {
            var w = window.open();
            var html_to_print = $("#dataBedStatusFlag").html();
            var title = 'Bed Status Flags Patients List';
            var print_title =
                '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

            var html = print_title +
                '<div class="col-md-12">' +
                html_to_print + '</div>';
            $(w.document.body).html(html);
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/BedFlagDashboard.css') }}">');
            $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');

            setTimeout(function () {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        }
    </script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

@endsection
