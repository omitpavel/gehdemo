@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Outbreak Wards')
@section('page-top-title', 'Outbreak Wards')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Covid19Wards.css') }}" crossorigin="anonymous">
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
    function DataPageLoad(infection_reason_id, room_type){
        var token               = "{{ csrf_token() }}";
        $('.page-data-loader').show();
        setTimeout(function() {
            $.ajax({
                _token: token,
                url: "{{ route('infection.covidward.dataload') }}",
                type: 'POST',
                data: { "_token": token, "infection_reason_id": infection_reason_id, "room_type": room_type},
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
    }

    $( document ).ready(function()
    {
        var isFilter              = 0;
        var infection_reason_id   = $('#infection_reason').val();
        var room_type             = $('#room_type').val();
        var ic_ward_short_name    = '';
        var ic_ward_short_name    = '';
        var query_type_show       = '';
        DataPageLoad(infection_reason_id, room_type);
    });


    function SaveInfectionCloseStatus(ward_id)
    {
        var token                       = "{{ csrf_token() }}";
        var infection_close_status_id   = "infection_close_status_"+ward_id;
        var infection_close_status      = $('#'+infection_close_status_id).val();
        $.ajax({
                url: "{{ route('infection.close.status') }}",
                type: 'POST',
                data: {
                    "_token": token,
                    "ward_id":ward_id,
                    "infection_close_status": infection_close_status
                },
                success: function(response) {
                    toastr.success(response.message, "Success");
                },
                error: function(status, err){
                    toastr.error(err, "");
                }
            });
    }
  </script>

@endsection
