@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Covid Sitrep')
@section('page-top-title', 'Covid Sitrep')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Covid19Sitrep.css') }}" crossorigin="anonymous">
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
    function DataPageLoad(ward_id){
        @if(CheckSpecificPermission('infection_control_covid_siterep_view'))
            var token               = "{{ csrf_token() }}";
            $('.page-data-loader').show();
            setTimeout(function() {
                $.ajax({
                    _token: token,
                    url: "{{ route('infection.covid.dataload') }}",
                    type: 'POST',
                    data: { "_token": token, "ward_id": ward_id},
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
        @else
            CommonLoginModalPopupOpenOnRequest();
        @endif
    }

    $( document ).ready(function()
    {
        var ward_id   = $('#ward_name').val();
        DataPageLoad(ward_id);
    });

    $(document).on("change", "#ward_name", function (e)
    {
        var ward_id   = $('#ward_name').val();
        DataPageLoad(ward_id);
    });
  </script>
@endsection
