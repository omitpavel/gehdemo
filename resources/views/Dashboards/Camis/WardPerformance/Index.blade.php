@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Ward Performance')
@section('page-top-title')
WARD PERFORMANCE - {{ $ward_details->ward_name }}
@endsection
@section('boardround-menus')
<li class="nav-item me-2 {{ PermissionDeniedDiv('camis_classic_view') }}" @if(CheckSpecificPermission('camis_classic_view')) onclick="window.open('{{ route('ward.ward-details',$ward_details->ward_url_name ) }}','_self');" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
    <button class="btn back-btn {{ DisabledButtonOnRolePermission('camis_classic_view') }}">BACK</button>
</li>
@endsection
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardPerformance.css') }}" crossorigin="anonymous">

@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
<div class="container-fluid refresh-content">
</div>
@endsection
@section('footer')

    @parent
    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var tok = "{{ csrf_token() }}";

        var ajax_refresh_url = "{{ route('ward.ward-performance.refresh') }}?ward_id={{$ward_details->ward_url_name }}";


    </script>

<script>
    function DataPageLoad(ward_id){
        $('.page-data-loader').show();
        $.ajax({
            _token:tok,
            url: "{{ route('ward.ward-performance.refresh') }}",
            type: 'GET',
            data: { "ward_id": ward_id, _token: tok},
            success: function (result)
            {
                $('#consulant_id').selectric('refresh');
                $('.refresh-content').html(result);
                $('.page-data-loader').hide();
            }
        });
    }


    $( document ).ready(function()
    {
        var ward_id              = "{{ $ward_details->ward_url_name }}";
        DataPageLoad(ward_id);
    });
</script>



    <script src="{{ asset('asset_v2/Generic/Js/ApexCharts.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxCommonScript.js') }}"></script>




@endsection
