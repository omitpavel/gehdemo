@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Ward Directorate')
@section('page-top-title')
WARD DIRECTORATE
@endsection
@section('boardround-menus')
<li class="nav-item me-2 {{ PermissionDeniedDiv('camis_classic_view') }}" @if(CheckSpecificPermission('camis_classic_view')) onclick="window.open('{{ route('ward.dashboard') }}','_self');" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
    <button class="btn back-btn {{ DisabledButtonOnRolePermission('camis_classic_view') }}">BACK</button>
</li>
@endsection
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardPerformance.css') }}" crossorigin="anonymous">

@endpush
@section('modal')
    @include('Common.Modals.CommonModals')
    <div class="directorate-boardround-report offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1"
    id="board_round_report" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
      <div class="d-flex align-items-center justify-content-between w-100">
        <div class="">
          <h6 class="mb-0" id="offcanvasRightLabel">Board Round Report</h6>
        </div>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('board_round_report');" ><img
                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
            CLOSE</button>
        </div>
      </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
      <div class="directorate-boardround-wrapper board_round_report_result">

      </div>
    </div>
    <div class="offcanvas-footer">
      <div class="row gx-2">
        <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
          <button class="btn btn-primary-grey" onclick="CloseOffcanvas('board_round_report');"><img
              src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('content')
<div class="container-fluid refresh-content">
</div>
<input type="hidden" id="ward_type" value="">
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
        var ajax_refresh_url = "{{ route('wardtype.ward-performance.load', ':id') }}";


    </script>

<script>
    function DataPageLoad(ward_type){
        $('.page-data-loader').show();

        var ajax_url = "{{ route('wardtype.ward-performance.load', ':id') }}";
        ajax_url = ajax_url.replace(':id', ward_type);


        $.ajax({
            _token:tok,
            url: ajax_url,
            type: 'GET',
            success: function (result)
            {
                $('#ward_type').val(ward_type);
                $('.refresh-content').html(result);
                ajax_refresh_url = ajax_refresh_url.replace(':id', ward_type);
                $('.page-data-loader').hide();
            }
        });
    }


    $( document ).ready(function()
    {
        DataPageLoad('amu');
    });

    function GetBoardRoundReport(week, day, ward_type){
        var board_round_report_offcanvas = new bootstrap.Offcanvas(document.getElementById('board_round_report'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        board_round_report_offcanvas.show();
        EnableLoaderAndMakeHiddenInnerBody();
        $('.board_round_report_result').html('');
        var token = "{{ csrf_token() }}";
        var url = "{{ route('wardtype.ward-boardround') }}";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                'week': week,
                'day': day,
                'ward_type': ward_type
            },
            success: function(result) {
                $('.board_round_report_result').html(result);
                DisableLoaderAndMakeVisibleInnerBody();
            },
            error: function(textStatus, errorThrown) {
                CommonErrorModalPopupOpenOnRequest();
                CloseOffcanvas('board_round_report');
            }
        });
    }
</script>



    <script src="{{ asset('asset_v2/Generic/Js/ApexCharts.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxCommonScript.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/IboxCommonScript.js') }}"></script>




@endsection
