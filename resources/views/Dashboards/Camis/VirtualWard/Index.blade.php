@extends('Layouts.Common.MasterLayout')
@section('page-title', ucwords(strtolower($success_array['vw_n'])).' Virtual Ward')
@section('page-top-title', ucwords(strtolower($success_array['vw_n'])))
@section('page-top-title-sub', 'autotimer')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BoardRoundPopup.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/VirtualWards.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/VirtualWardCustom.css') }}" crossorigin="anonymous">

@endpush

@section('modal')
    @include('Common.Modals.BoardRoundInfoModal')
    @include('Dashboards.Camis.VirtualWard.VirtualWardModal.Modal')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
<input type="hidden" id="task_category" value="4">
<input type="hidden" id="filtered_task_id" value="">
<input type="hidden" id="virtual-ward-name" value="{{ $success_array['ward'] }}">


    <div class="container-fluid refresh-content">

    </div>
@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var ajax_refresh_url = "";

    </script>
    <script>
        $(document).on("change", "#ward_id", function (e) {
            $('.page-data-loader').show();
            var ward_id = $("#ward_id").val();
            var token = "{{ csrf_token() }}";
            var virtual_ward_name = $("#virtual-ward-name").val();

            $.ajax({
                url: '{{route('virtual.ward.filter')}}',
                type: 'POST',
                data: {"ward_id": ward_id, "_token": token, "virtual_ward_name": virtual_ward_name},
                success: function (data) {
                    EnableToolTipForAjax();
                    $('.refresh-content').html(data);
                    MultiSelectJs('ward_id', 'Ward');
                    $('.page-data-loader').hide();
                }
            });
        });

        $(document).ready(function () {
            $('.page-data-loader').show();
            var token = "{{ csrf_token() }}";
            var virtual_ward_name = $("#virtual-ward-name").val();

            $.ajax({
                url: '{{route('virtual.ward.filter')}}',
                type: 'POST',
                data: {"_token": token, "virtual_ward_name": virtual_ward_name},
                success: function (data) {
                    EnableToolTipForAjax();
                    $('.refresh-content').html(data);
                    MultiSelectJs('ward_id', 'Ward');
                    $('.page-data-loader').hide();
                }
            });
        });
    </script>
    <script src="{{ url('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    @include('Common.Scripts.BoardRoundInfoModalScript')
    @include('Common.Scripts.Task')
@endsection
