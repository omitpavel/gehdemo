@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Removed Patients')
@section('page-top-title', 'Removed Patients')
@section('header')
    @parent
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" crossorigin="anonymous" />
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/CdtRemovedPatients.css') }}" crossorigin="anonymous">

@endsection

@section('modal')
    @include('Dashboards.Camis.DischargeTracker.Modals')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent


    <script>
        function DataPageLoad( ward_id){
            @if(CheckSpecificPermission('discharge_tracker_referral_view'))
                if(ward_id == undefined){
                    var ward_id = '';
                }

                var token               = "{{ csrf_token() }}";
                $('.page-data-loader').show();

                $.ajax({
                    _token: token,
                    url: "{{ route('discharged.removed_patients.dataLoad') }}",
                    type: 'GET',
                    data: { "_token": token, "ward_id": ward_id},
                    success: function (response)
                    {
                        if(response != "" && response != "{{ PermissionDenied() }}"){

                            $('#contentSection_data').html(response);
                            MultiSelectJs('ward_id', 'Ward');
                            $('.page-data-loader').hide();
                        } else {
                            $('.page-data-loader').hide();
                            PermissionDeniedAlert();
                        }
                    },
                    error: function(status, err){
                        $('.page-data-loader').hide();
                        toastr.warning('Something Went Wrong');
                    }
                });
            @else
                PermissionDeniedAlert();
            @endif
        }



        $(document).on("change", "#ward_id", function (e)
        {
            var ward_id = $('#ward_id').val();

            DataPageLoad( ward_id);
        });

        @if(CheckSpecificPermission('discharge_tracker_referral_view'))
            $(document).ready(function() {
                DataPageLoad();
            });
        @else

            PermissionDeniedAlert();
        @endif



    </script>


@endsection
