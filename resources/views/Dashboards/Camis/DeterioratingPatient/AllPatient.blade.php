@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Patient With DP Tasks')
@section('page-top-title', 'Patient With DP Tasks')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DeterioratingNewPatients.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous" />
@endpush

@section('modal')
    @include('Dashboards.Camis.DeterioratingPatient.Modals')
    @include('Common.Modals.BoardRoundInfoModal')
    @include('Common.Modals.CommonModals')
    @include('Dashboards.Camis.WardSummary.BoardRoundModals.AssignTask')
@endsection
@section('content')

    <div class="container-fluid refresh-content">

    </div>
@endsection
@section('footer')
    @parent

    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    @include('Dashboards.Camis.DischargeTracker.ViewAllcommentScript')
    <script>
        var ajax_refresh_url = "{{ route('all.patient.dataload') }}";
        function DataPageLoad(ward_id, sort_by){
            @if(CheckSpecificPermission('dp_dashboard_new_patients_view'))
                var token               = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('all.patient.dataload') }}",
                        type: 'GET',
                        data: { "_token": token, "ward_id": ward_id, "sort_by": sort_by},
                        success: function (response)
                        {
                            if(response != ""){

                                $('.refresh-content').html(response);
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err){
                            toastr.warning('Something Went Wrong');
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
            var ward_id         = $('#ward_id').val();
            var sort_by          = $('#sort_by').val();
            DataPageLoad(ward_id, sort_by);
        });
        $(document).on("change", "#ward_id, #sort_by", function(e) {
            var ward_id         = $('#ward_id').val();
            var sort_by          = $('#sort_by').val();
            DataPageLoad(ward_id, sort_by);
        });



    </script>
    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Dashboards.Camis.DeterioratingPatient.DpCommentScript')
    <script src="{{ asset('asset_v2/Generic/clockpicker/clockpicker.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

    @include('Dashboards.Camis.DeterioratingPatient.DPTaskScript')
@endsection
