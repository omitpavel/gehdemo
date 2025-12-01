@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Side Room Tools')
@section('page-top-title', 'Side Room Tools')
@section('header')
    @parent
        <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/SideRoomTool.css') }}" crossorigin="anonymous">
    @endsection


@section('content')
    <div class="contentSection" id="contentSection_data">

    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2') }}/Generic/Js/toastr.min.js"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script>
       </script>

  <script>
  </script>
  <script>
    function DataPageLoad(ward_short_name, query_type_show){
        var token               = "{{ csrf_token() }}";
        $('.page-data-loader').show();
        setTimeout(function() {
            $.ajax({
                _token: token,
                url: "{{ route('infection.sideroom.patients.dataload') }}",
                type: 'POST',
                data: { "_token": token, "ward_id": ward_short_name, "query_type_show": query_type_show},
                success: function (response)
                {
                    if(response != ""){

                        $('#contentSection_data').html(response);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.SelectBoxWrap select').selectric('refresh');



                        let can_be_moved_count = 0;
                        let not_to_be_moved_count = 0;

                        $(".alert").each(function () {



                            if ($(this).hasClass("bg-green")) {
                                can_be_moved_count++;
                            } else {
                                not_to_be_moved_count++;
                            }
                        });
                        let total_patients = (can_be_moved_count+not_to_be_moved_count);
                        $(".bg-patients-count").eq(0).find("h5").text(total_patients);
                        $(".bg-patients-count").eq(1).find("h5").text(can_be_moved_count);
                        $(".bg-patients-count").eq(2).find("h5").text(not_to_be_moved_count);


                        $('.page-data-loader').hide();
                    }
                },
                error: function(status, err){
                    $('.page-data-loader').hide();
                }
            });
        },2000)
    }

    $(document).ready(function()
    {
         var ward_short_name   = $('#ward_id').val();
         var query_type_show   = $('#query_type_show').val();
        DataPageLoad(ward_short_name, query_type_show);
    });
  </script>
  <script>

    $(document).on("change", "#ward_id,#query_type_show", function (e)
    {
        var ward_short_name   = $('#ward_id').val();
        var query_type_show   = $('#query_type_show').val();
        DataPageLoad(ward_short_name, query_type_show);
    });

  </script>

@endsection
