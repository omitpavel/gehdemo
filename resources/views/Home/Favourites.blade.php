@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Set Favourites')
@section('page-top-title', 'Set Favourites')
@section('page-top-title-sub', date('jS F H:i'))
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/SetFavourites.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/Favourites.css') }}" crossorigin="anonymous" />
@endpush
@section('content')

    <div class="container-fluid favourite-content">

    </div>
@endsection
@section('footer')
<script>

        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        // Scroll To Top

        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#scroll-up').fadeIn();
            } else {
                $('#scroll-up').fadeOut();
            }
        });
        $('#scroll-up').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        function DataPageLoad(tab) {
            $('.page-data-loader').show();
            $.ajax({
                url: "{{ route('favourites') }}",
                type: 'GET',
                data: {
                    "tab": tab
                },
                success: function(result) {

                    $('.favourite-content').html(result);
                    $('.form-select').selectric('refresh');
                    $('.page-data-loader').hide();
                },
                error: function(textStatus, errorThrown) {
                    toastr.warning('Something Went Wrong');
                    $('.page-data-loader').hide();
                }
            });
        }


        $(document).ready(function() {
            $('.page-loader').hide();
            DataPageLoad('regular');
        });
        $(document).on("click", ".save_table", function(e) {
            var token = "{{ csrf_token() }}";
            let favourites = [];
            var current_tab = $('#current_tab').val();
            DisableButtonClickForPreventFurtherEvent('save_table');

            $('#sortableTable tbody tr[data-id]').each(function(index) {
                favourites.push({
                    id: $(this).data('id'),
                    position: index + 1
                });
            });
            var url = '{{ route('save.favourites') }}';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "favourites": favourites,
                    "tab": current_tab
                },
                success: function(result) {
                    if(current_tab == 'regular'){
                        $('#sidebar').remove();
                        $('.page-body-wrapper').prepend(result.desktop);
                        $('.sidenav-link').remove();
                        $('#mySidenav').append(result.mobile);
                    }
                    toastr.success('Menus Record Saves');
                }
            });
        });
        function DisableButtonClickForPreventFurtherEvent(class_name_to_disable) {
            $("." + class_name_to_disable).addClass("button-event-trigger-disabled");
            clear_patient_name_show = setTimeout(function() {
                $("." + class_name_to_disable).removeClass(
                    "button-event-trigger-disabled"
                );
            }, 2000);
        }
</script>
<script>
    // Dynamically Space Managing - Marquee, Topbar and Side bar

    if ((document.querySelector("#sidebar")) || (document.querySelector("#content"))) {
        if (document.getElementById("sidebar")) {
            // document.getElementById("content").style.width = "calc(100% - 100px)";
        } else {
            document.getElementById("content").style.width = "100%";
            document.getElementById("content").style.paddingLeft = "0"
        }
    }

    if ((document.querySelector("#marquee-content")) && (document.querySelector("#content")) &&
        (document.querySelector("#page-wrapper")) || (document.querySelector("#topbar"))) {
        if ((document.getElementById("marquee-content")) && (document.getElementById("topbar"))) {
            document.getElementById("page-wrapper").style.marginTop = "95px";
        } else {
            document.getElementById("page-wrapper").style.marginTop = "70px";
            document.getElementById("topbar").style.marginTop = "0px";

        }
    }



    if (document.getElementById("topbar")) {
        // document.getElementById("page-wrapper").style.marginTop = "105px";
    } else {
        document.getElementById("page-wrapper").style.marginTop = "20px";

    }
</script>

@endsection
