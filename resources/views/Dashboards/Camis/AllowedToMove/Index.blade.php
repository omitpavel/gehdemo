@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Allowed To Move')
@section('page-top-title', 'Allowed To Move')
@section('page-top-title-sub', 'autotimer')

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/AllowToMove.css') }}" crossorigin="anonymous">
@endpush

@section('content')
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
        var tok = "{{ csrf_token() }}";

        var ajax_refresh_url = "";
    </script>

    <script>
        function DataPageLoad(ward, type, move_to) {
            $('.page-data-loader').show();
            $.ajax({
                _token: tok,
                url: "{{ route('allowed_to_move.dataload') }}",
                type: 'POST',
                data: {
                    "ward_id": ward,
                    "type": type,
                    "move_to": move_to,
                    _token: tok
                },
                success: function(result) {
                    $('.refresh-content').html(result);
                    MultiSelectJs('ward_id', 'Ward');
                    MultiSelectJs('move_to', 'Move To Ward');
                    $('.page-data-loader').hide();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    $('.page-data-loader').hide();
                }
            });
        }


        $(document).ready(function() {
            var ward_id = $('#ward_id').val();
            var type = $('#type').val();
            DataPageLoad(ward_id, type);
        });
        $(document).on("change", "#ward_id, #type, #move_to", function(e) {
            var ward_id = $('#ward_id').val();
            var type = $('#type').val();
            var move_to = $('#move_to').val();
            DataPageLoad(ward_id, type, move_to);
        });
    </script>


    <script src="{{ asset('asset_v2') }}/Ibox/Js/custom.js"></script>


@endsection
