@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Reason To Reside')
@section('page-top-title', 'Reason To Reside')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/Reasontoreside.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ReasonToReside.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/billboard.min.css') }}" crossorigin="anonymous">
    <script src="{{ asset('asset_v2/Generic/Js/d3.v7.min.js') }}"></script>

@endpush
@section('modal')
    @include('Common.Modals.BoardRoundInfoModal')
    @include('Dashboards.Camis.WardSummary.BoardRoundModals.AssignTask')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')

    <input type="hidden" id="boardround_patient_task_group" value="">
    <input type="hidden" id="task_category" value="2">
    <input type="hidden" id="filtered_task_id" value="">
    <input type="hidden" id="ward_summary_boardround_modal_popup_camis_patient_id" value="">
    <input type="hidden" id="boardround_patient_task_id_update" value="">
    <input type="hidden" id="permission" value="r_to_r_task_management_view">
    <div class="refresh-content" id="contentSection_data">

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
        var ajax_refresh_url = "";
    </script>



    <script>
        @if(CheckSpecificPermission('r_to_r_view_summery_dashboard_view'))
            $(document).ready(function() {
                ReasonToResideTab('summery');
            });
        @elseif(CheckSpecificPermission('r_to_r_view_summery_dashboard_view'))

            $(document).ready(function() {
                ReasonToResideTab('patient_list');
            });

        @endif


    </script>

    <script>
        function ReasonToResideTab(tab) {
            var ward_id              = $('#ward_id').val();
            var tab_type             = tab;
            var reason_id            = $('#reason_id').val();


            $('.page-data-loader').show();
            var url = "{{ route('reason_to_reside.content') }}";
            $.ajax({
                _token:tok,
                url: url,
                type: 'GET',
                data: { "ward_id": ward_id, "tab_type":tab_type, "reason_id":reason_id},
                success: function (result)
                {
                    if(result != '{{PermissionDenied()}}'){
                        $('#contentSection_data').html(result);
                        if(tab_type == 'patient_list') {

                            MultiSelectJs('ward_id', 'Ward');
                        }
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                }
            });
        }
    </script>

    <script>
        $(document).on("change", "#ward_id, #reason_id", function (e)
        {
            var ward_id                 = $('#ward_id').val();
            var tab_type                 = $('#tab_type').val();
            var reason_id                 = $('#reason_id').val();
            $('.page-data-loader').show();
            var url = "{{ route('reason_to_reside.content') }}";
            $.ajax({
                _token:tok,
                url: url,
                type: 'GET',
                data: { "ward_id": ward_id, "tab_type":tab_type, "reason_id":reason_id},
                success: function (result)
                {
                    $('#contentSection_data').html(result);
                    MultiSelectJs('ward_id', 'Ward');
                    $('.page-data-loader').hide();
                }
            });
        });
    </script>

    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Common.Scripts.Task')
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>

    <script src="{{ asset('asset_v2/Template/js/ReasonToResidescript.js') }}"></script>

@endsection
