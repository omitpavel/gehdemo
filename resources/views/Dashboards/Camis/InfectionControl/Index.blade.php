@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Infection Control')
@section('page-top-title', 'Infection Control')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/IcPatients.css') }}" crossorigin="anonymous">
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




    function DataPageLoad(infection_reason_id, room_type){
        var token               = "{{ csrf_token() }}";
        var reverse_barrier     = $(".reverse_barrier_filter").hasClass("active") ? 1 : 0;

        $('.page-data-loader').show();
        setTimeout(function() {
            $.ajax({
                _token: token,
                url: "{{ route('infection.indexdataload') }}",
                type: 'POST',
                data: { "_token": token, "infection_reason_id": infection_reason_id, "room_type": room_type, "reverse_barrier": reverse_barrier},
                success: function (response)
                {
                    if(response != ""){

                        $('#contentSection_data').html(response);
                        $('.SelectBoxWrap select').selectric('refresh');
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
  </script>
  <script>

    $(document).on("change", "#room_type,#infection_reason", function (e)
    {
        var isFilter              = 0;
        var infection_reason_id   = $('#infection_reason').val();
        var room_type             = $('#room_type').val();
        var ic_ward_short_name    = '';
        var query_type_show       = '';
        DataPageLoad(infection_reason_id, room_type);
    });

    $(document).on("click", ".reverse_barrier_filter", function (e)
    {
        var isFilter              = 0;
        var infection_reason_id   = $('#infection_reason').val();
        var room_type             = $('#room_type').val();
        var ic_ward_short_name    = '';
        var query_type_show       = '';
        $(this).toggleClass("active");
        DataPageLoad(infection_reason_id, room_type);
    });
    $(document).on("click", ".click_assign_reverse_barrier", function (e)
    {

        $(this).toggleClass("active");
        var reverse_barrier = $(this).hasClass("active") ? 1 : 0;
        var token               = "{{ csrf_token() }}";
        var patient_id        = $(this).data("patient-id");
        if(patient_id == '' || typeof patient_id === "undefined"){
            toastr.error('Patient id is missing');
            return false;
        }
        $.ajax({
            _token: token,
            url: "{{ route('infection.assignreversebarrier') }}",
            type: 'POST',
            data: { "_token": token, "patient_id": patient_id, "reverse_barrier": reverse_barrier},
            success: function (response)
            {
                if(response.status == 1){
                    toastr.success(response.message);
                }else{
                    toastr.error(response.message);
                }
            },
            error: function(status, err){
                toastr.error('Something went wrong');
            }
        });

    });

  </script>

@endsection
