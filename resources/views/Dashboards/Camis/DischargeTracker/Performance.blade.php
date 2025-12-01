@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Discharge Tracker Performance')
@section('page-top-title', 'Discharge Tracker Performance')
@section('page-top-title-sub', 'autotimer')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/CdtPerformance.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" />
    <style>
        #pathway-patients .apexcharts-series path {
            cursor: pointer;
        }
    </style>
    <script src="{{ asset('asset_v2/Template/js/ApexCharts.js') }}"></script>
@endsection

@section('modal')
    <!-- Discharge Patients Details Offcanvas -->

    <div class="discharge-patient-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        id="cdt_performance_inpatient_offcanvas">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Patient List</h6>
                </div>
                <div class="d-flex align-items-center">
                    <div class="btn-custom-print">
                        <button class="btn btn-primary-grey click_export_performance_inpatient"><img
                                src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt=""
                                class="btn-icon-modal" width="16" height="16"><span
                                class="d-none d-md-block ">EXPORT</span>
                        </button>
                    </div>
                    <div class="btn-custom-print click_print_performance_inpatient">
                        <button class="btn btn-primary-grey"><img src="{{ asset('asset_v2/Template/icons/print.svg') }}"
                                alt="" class="btn-icon-modal" width="16" height="16"><span
                                class="d-none d-md-block">PRINT</span>
                        </button>
                    </div>
                    <button type="button" class="btn-grey text-end w-100"
                        onclick="CloseOffcanvas('cdt_performance_inpatient_offcanvas');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body cdt_performance_inpatient_offcanvas_data ward_summary_sub_modal_inner_body">

        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2 ">
                <div class="col-lg-2 col-md-4 offset-lg-3">
                    <button class="btn btn-primary-grey mb-2 mb-md-0 click_export_performance_inpatient"><img
                            src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" class="btn-icon-modal"
                            width="16" height="16"><span>EXPORT</span>
                    </button>
                </div>
                <div class="col-lg-2 col-md-4 click_print_performance_inpatient">
                    <button class="btn btn-primary-grey mb-2 mb-md-0"><img
                            src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal"
                            width="16" height="16"><span>PRINT</span>
                    </button>
                </div>
                <div class="col-lg-2 col-md-4">
                    <button class="btn btn-primary-grey mb-2 mb-md-0"
                        onclick="CloseOffcanvas('cdt_performance_inpatient_offcanvas');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal"
                            width="14" height="14"><span>CANCEL</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="today-discharge-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        id="cdt_performance_discharged_today" >
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Discharges Today</h6>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('cdt_performance_discharged_today');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                            class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body" id="">
            <div class="card-table-listing cdt_performance_discharge_today_offcanvas_data">

            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('cdt_performance_discharged_today');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                            height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Discharge Patients Details Offcanvas End -->

    <!-- Pending CDT Details Offcanvas -->

    <div class="pending-cdt-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" id="pending_cdt_offcanvas">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Pending CDT Details</h6>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('pending_cdt_offcanvas');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                            class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body" id="">
            <div class="card-table-listing cdt_performance_pending_cdt_offcanvas_data">

            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('pending_cdt_offcanvas');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                            height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid refresh-content">
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
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
        function DischargeDashboard(ward_id, medfit_status, reason_code_id) {
            var url = "{{ route('discharged.performance.data.load') }}";

            $('.page-data-loader').show();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    ward_id: ward_id,
                    medfit_status: medfit_status,
                    reason_code_id: reason_code_id,
                },
                success: function(result) {
                    if (result != '{{ PermissionDenied() }}') {
                        $('.refresh-content').html(result);
                        MultiSelectJs('ward_id', 'Ward');
                        $('.page-data-loader').hide();
                    } else {
                        $('.page-data-loader').hide();
                        CommonLoginModalPopupOpenOnRequest();
                    }

                }
            });
        }

        $(document).ready(function() {
            var ward_id = '';
            var medfit_status = '';
            var reason_code_id = '';


            DischargeDashboard(ward_id, medfit_status, reason_code_id);

        });
        $(document).on("change", "#ward_id,#medfit_status,#reason_code_id", function(e) {
            var ward_id = $('#ward_id').val();
            var medfit_status = $('#medfit_status').val();
            var reason_code_id = $('#reason_code_id').val();
            DischargeDashboard(ward_id, medfit_status, reason_code_id);
        });

        $(document).on("click", ".click_open_cdt_pending_coount", function(e) {

            var ward_id = $('#ward_id').val();
            var medfit_status = $('#medfit_status').val();
            var reason_code_id = $('#reason_code_id').val();

            var pending_cdt_offcanvas = new bootstrap.Offcanvas(document.getElementById(
                'pending_cdt_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            pending_cdt_offcanvas.show();
            EnableLoaderAndMakeHiddenInnerBody();
            $('.cdt_performance_pending_cdt_offcanvas_data').html('');

            var token = "{{ csrf_token() }}";
            var url = "{{ route('discharged.performance.offcanvas.cdtpending') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    'ward_id': ward_id,
                    'medfit_status': medfit_status,
                    'reason_code_id': reason_code_id
                },
                success: function(result) {
                    $('.cdt_performance_pending_cdt_offcanvas_data').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    CloseOffcanvas('pending_cdt_offcanvas');
                }
            });
        });
        $(document).on("click", ".click_open_discharge_today_count", function(e) {

            var ward_id = $('#ward_id').val();
            var medfit_status = $('#medfit_status').val();
            var reason_code_id = $('#reason_code_id').val();

            var discharge_today_offcanvas = new bootstrap.Offcanvas(document.getElementById(
                'cdt_performance_discharged_today'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            discharge_today_offcanvas.show();
            EnableLoaderAndMakeHiddenInnerBody();
            $('.cdt_performance_discharge_today_offcanvas_data').html('');

            var token = "{{ csrf_token() }}";
            var url = "{{ route('discharged.performance.offcanvas.dischargetoday') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    'ward_id': ward_id,
                    'medfit_status': medfit_status,
                    'reason_code_id': reason_code_id
                },
                success: function(result) {
                    $('.cdt_performance_discharge_today_offcanvas_data').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    CloseOffcanvas('cdt_performance_discharged_today');
                }
            });
        });
        function PatientByPathway(pathway, authority, reason, cdt_status) {
            var ward_id = $('#ward_id').val();
            var medfit_status = $('#medfit_status').val();
            var reason_code_id = $('#reason_code_id').val();

            var patient_offcanvas = new bootstrap.Offcanvas(document.getElementById(
                'cdt_performance_inpatient_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            patient_offcanvas.show();
            EnableLoaderAndMakeHiddenInnerBody();
            $('.cdt_performance_inpatient_offcanvas_data').html('');

            var token = "{{ csrf_token() }}";
            var url = "{{ route('discharged.performance.offcanvas.inpatient') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    'ward_id': ward_id,
                    'medfit_status': medfit_status,
                    'reason_code_id': reason_code_id,
                    'pathway': pathway,
                    'authority': authority,
                    'reason': reason,
                    'cdt_status': cdt_status
                },
                success: function(result) {
                    $('.cdt_performance_inpatient_offcanvas_data').html(result);
                    DisableLoaderAndMakeVisibleInnerBody();
                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                    CloseOffcanvas('cdt_performance_inpatient_offcanvas');
                }
            });


        }
        $(document).on('click', '.click_export_performance_inpatient', function(e) {

            let csv = [];
            $('.cdt_in_patient_offcanvas_export tr').each(function() {
                let row = [];
                $(this).find('th, td').each(function() {

                    let cellContent = $(this).clone()
                        .children('.tdBefore')
                        .remove()
                        .end()
                        .text()
                        .trim();
                    row.push(cellContent);
                });
                csv.push(row.join(","));
            });

            let csvContent = csv.join("\n");
            let blob = new Blob([csvContent], {
                type: 'text/csv'
            });
            let url = URL.createObjectURL(blob);

            let a = document.createElement('a');
            a.href = url;
            a.download = 'cdt_performance_patients.csv';
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });


        $(document).on('click', '.click_print_performance_inpatient', function(e) {
            var w = window.open();
            var html = $(".cdt_performance_inpatient_offcanvas_data").html();
            $(w.document.body).html(html);
            $(w.document.head).append(
                '<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">'
                );
            $(w.document.head).append(
                '<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">'
                );
            $(w.document.head).append(
                '<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}">'
                );
            $(w.document.head).append(
                '<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">'
                );
            setTimeout(function() {
                w.onafterprint = w.close;
                w.print();
            }, 1000);
        });
    </script>


@endsection
