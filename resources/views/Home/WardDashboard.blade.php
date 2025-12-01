@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Wards Home')
@section('page-top-title', 'Wards')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardHome.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/HandoverDetails.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PotentialDischargeList.css') }}" />
    <style>
        .btn-custom-discharges .btn-primary-grey {
            min-height: 37px;
            max-height: 37px;
            padding: .5rem 1.5rem;
            font-size: 14px;
            min-width: 350px;
        }
    </style>
@endpush
@section('modal')
    <div class="potential-discharge-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        id="definite_patient_modal" aria-labelledby="offcanvasRightLabel" data-bs-backdrop="static">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">DEFINITE DISCHARGE PATIENT LISTS</h6>
                </div>
                <div class="d-flex align-items-center">
                    <div class="btn-custom-discharges {{ PermissionDeniedDiv('pd_dashboard') }}"
                        onclick="window.location.href = '{{ route('site.pd_discharge') }}'">
                        <button class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('pd_dashboard') }}"><span>Definite/Potential
                                Discharges</span>
                        </button>
                    </div>
                    <button type="button" class="btn-grey text-end w-100"
                        onclick="CloseOffcanvas('definite_patient_modal');" aria-label="Close"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body">
            <div class="potential-dsicharge-list" id="definite_patient_list_data">

            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('definite_patient_modal');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal"
                            width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="potential-discharge-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
        id="potential_patient_modal" aria-labelledby="offcanvasRightLabel" data-bs-backdrop="static">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">POTENTIAL DISCHARGE PATIENT LISTS</h6>
                </div>
                <div class="d-flex align-items-center">
                    <div class="btn-custom-discharges {{ PermissionDeniedDiv('pd_dashboard') }}"
                        onclick="window.location.href = '{{ route('site.pd_discharge') }}'">
                        <button class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('pd_dashboard') }}"><span>Definite/Potential
                                Discharges</span>
                        </button>
                    </div>
                    <button type="button" class="btn-grey text-end w-100"
                        onclick="CloseOffcanvas('potential_patient_modal');" aria-label="Close"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body">
            <div class="potential-dsicharge-list" id="potential_patient_list_data">

            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('potential_patient_modal');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal"
                            width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="count-details-row">
                <div class="count-details-col">
                    <div class="">
                        <div class="blue-tile-top">
                            <h6>TOTAL BEDS</h6>
                        </div>
                        <div class="tile-count-bottom">
                            <div class="row gx-2">
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Total</p>
                                        <h6 class="value-data-details">{{ $success_array['total_occupied']['total'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Rstr.</p>
                                        <h6 class="value-data-details">{{ $success_array['total_occupied']['restrict'] }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Empty</p>
                                        <h6 class="value-data-details">{{ $success_array['total_occupied']['available'] }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="data-details">
                                        <p class="header-data-details">Occ</p>
                                        <h6 class="value-data-details">{{ $success_array['total_occupied']['occupied'] }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="count-details-col">
                    <div class="">
                        <div class="blue-tile-top">
                            <h6>MALE BEDS</h6>
                        </div>
                        <div class="tile-count-bottom">
                            <div class="row gx-2">
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Total</p>
                                        <h6 class="value-data-details">{{ $success_array['male_empty']['total'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Rstr.</p>
                                        <h6 class="value-data-details">{{ $success_array['male_empty']['restrict'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Empty</p>
                                        <h6 class="value-data-details">{{ $success_array['male_empty']['available'] }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="data-details">
                                        <p class="header-data-details">Occ</p>
                                        <h6 class="value-data-details">{{ $success_array['male_empty']['occupied'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="count-details-col">
                    <div class="">
                        <div class="blue-tile-top">
                            <h6>FEMALE BEDS</h6>
                        </div>
                        <div class="tile-count-bottom">
                            <div class="row gx-2">
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Total</p>
                                        <h6 class="value-data-details">{{ $success_array['female_empty']['total'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Rstr.</p>
                                        <h6 class="value-data-details">{{ $success_array['female_empty']['restrict'] }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Empty</p>
                                        <h6 class="value-data-details">{{ $success_array['female_empty']['available'] }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="data-details">
                                        <p class="header-data-details">Occ</p>
                                        <h6 class="value-data-details">{{ $success_array['female_empty']['occupied'] }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="count-details-col">
                    <div class="">
                        <div class="blue-tile-top">
                            <h6>SIDEROOM BEDS</h6>
                        </div>
                        <div class="tile-count-bottom">
                            <div class="row gx-2">
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Total</p>
                                        <h6 class="value-data-details">{{ $success_array['sr_empty']['total'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Rstr.</p>
                                        <h6 class="value-data-details">{{ $success_array['sr_empty']['restrict'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Empty</p>
                                        <h6 class="value-data-details">{{ $success_array['sr_empty']['available'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="data-details">
                                        <p class="header-data-details">Occ</p>
                                        <h6 class="value-data-details">{{ $success_array['sr_empty']['occupied'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="count-details-col">
                    <div class="">
                        <div class="blue-tile-top">
                            <h6>ESCALATION BEDS</h6>
                        </div>
                        <div class="tile-count-bottom">
                            <div class="row gx-2">
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Total</p>
                                        <h6 class="value-data-details">{{ $success_array['escalation']['total'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Rstr.</p>
                                        <h6 class="value-data-details">{{ $success_array['escalation']['restrict'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-3 border-end">
                                    <div class="data-details">
                                        <p class="header-data-details">Empty</p>
                                        <h6 class="value-data-details">{{ $success_array['escalation']['available'] }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="data-details">
                                        <p class="header-data-details">Occ</p>
                                        <h6 class="value-data-details">{{ $success_array['escalation']['occupied'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="count-details-col-2">
                    <div class="grey-rectangle-1">
                        <div class="row gx-2 align-items-center  click_open_definite_discharges cursor_pointer">
                            <div class="col-md-8 col-8">
                                <h6 class="mb-0">DEFINITE <br class="d-none d-md-block">DISCHARGES TODAY</h6>
                            </div>
                            <div class="col-md-4 col-4 text-center border-start">
                                <h5 class="mb-0 text-cyan">{{ $success_array['total_definite'] }}</h5>
                            </div>
                        </div>
                        <div class="separation"></div>
                        <div class="row gx-2 align-items-center  click_open_potential_discharges cursor_pointer">
                            <div class="col-md-8 col-8">
                                <h6 class="mb-0">POTENTIALS DISCHARGES TODAY</h6>
                            </div>
                            <div class="col-md-4 col-4 text-center border-start">
                                <h5 class="mb-0 text-cyan">{{ $success_array['total_poteintial'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="honeyCombWrap">
        <div class="container-fluid">
            <div class="row gx-2">
                <div class="col-xl-5 col-xxl-5">
                    <div class="dbviewInnerRow row">
                        <div class="honey_col mwcol">
                            <h3 class="header-medical-wards">Medical wards</h3>
                            <ul class="container medicalward_container">
                                @foreach ($success_array['medical_ward'] as $medical)
                                    <li
                                        class="item {{ GetWardInfectionBoxBorder(@$medical['ward_infection_close_status'], $medical['ward_type_primary']) }} {{ PermissionDeniedDiv('camis_classic_view') }}">


                                        @if ($medical['ward_short_name'] == 'RLTDISCHARGE')
                                            <a data-toggle="tooltip" href="{{ route('ward.discharge.lounge') }}"
                                                class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}"><span>{{ $medical['ward_name'] }}</span>
                                                {!! GetWardInfectionStatus(@$medical['ward_infection_close_status']) !!}
                                            </a>
                                        @else
                                            <a data-toggle="tooltip"
                                                href="{{ route('ward.ward-details', $medical['ward_url_name']) }}"
                                                class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}"><span>{{ $medical['ward_name'] }}</span>
                                                {!! GetWardInfectionStatus(@$medical['ward_infection_close_status']) !!}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-5 col-xl-3 col-xxl-3">
                    <div class="dbviewInnerRow row position-relative">
                        <div class="NYE_box">
                            <div class="item nye">
                                <div class="txt">EMERGENCY <br> WARDS</div>
                                @foreach ($success_array['emergency_ward'] as $emergency)
                                    <div class="subitem itm{{ $loop->iteration }}">
                                        <div
                                            class="item {{ GetWardInfectionBoxBorder(@$emergency['ward_infection_close_status'], $emergency['ward_type_primary']) }} {{ PermissionDeniedDiv('camis_classic_view') }}">

                                            @if (stripos($emergency['ward_name'], 'sdec') !== false)
                                                <a href="{{ route('ward.sdec') }}"
                                                    class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}">
                                                @elseif(stripos($emergency['ward_name'], 'frailty') !== false)
                                                    <a href="{{ route('ward.frailty') }}"
                                                        class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}">
                                                    @else
                                                        <a href="{{ stripos($emergency['ward_name'], 'sdec') !== false ? route('ward.sdec') : route('ward.ward-details', $emergency['ward_url_name']) }}"
                                                            class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}">
                                            @endif

                                            <div class="txt">
                                                {{ stripos($emergency['ward_name'], 'sdec') !== false ? 'SDEC' : $emergency['ward_name'] }}
                                            </div>
                                            {!! GetWardInfectionStatus(@$emergency['ward_infection_close_status']) !!}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-7 col-xl-4 col-xxl-4">
                    <div class="dbviewInnerRow row">
                        <div class="honey_col swcol">
                            <h3 class="header-surgical-wards">Surgical wards</h3>
                            <ul class="container surgicalward_container">


                                @foreach ($success_array['surgical_ward'] as $surgical)
                                    <li
                                        class="item {{ GetWardInfectionBoxBorder(@$surgical['ward_infection_close_status'], $surgical['ward_type_primary']) }} {{ PermissionDeniedDiv('camis_classic_view') }}">


                                        @if ($surgical['ward_short_name'] == 'RLTDISCHARGE')
                                            <a data-toggle="tooltip" href="{{ route('ward.discharge.lounge') }}"
                                                class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}"><span>{{ $surgical['ward_name'] }}</span>
                                                {!! GetWardInfectionStatus(@$surgical['ward_infection_close_status']) !!}
                                            </a>
                                        @else
                                            <a data-toggle="tooltip"
                                                href="{{ route('ward.ward-details', $surgical['ward_url_name']) }}"
                                                class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}"><span>{{ $surgical['ward_name'] }}</span>
                                                {!! GetWardInfectionStatus(@$surgical['ward_infection_close_status']) !!}
                                            </a>
                                        @endif

                                    </li>
                                @endforeach



                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-2 ">
                <div class="col-lg-6 order-md-0 order-1 other-wards-col">
                    <h3 class="header-other-wards">Other Wards</h3>
                    <div class="dbviewInnerRow bottomlftPad row">
                        <div class="honey_col">

                            <ul class="container otherwards_container">


                                @foreach ($success_array['other_ward'] as $other)
                                    @if ($other['id'] != '16049')
                                        <li
                                            class="item {{ GetWardInfectionBoxBorder(@$other['ward_infection_close_status'], $other['ward_type_primary']) }} {{ PermissionDeniedDiv('camis_classic_view') }}">
                                            @if ($other['ward_short_name'] == 'RLTDISCHARGE')
                                                <a data-toggle="tooltip" href="{{ route('ward.discharge.lounge') }}"
                                                    class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}"><span>{{ $other['ward_name'] }}</span>
                                                    {!! GetWardInfectionStatus(@$other['ward_infection_close_status']) !!}
                                                </a>
                                            @else
                                                <a data-toggle="tooltip"
                                                    href="{{ route('ward.ward-details', $other['ward_url_name']) }}"
                                                    class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}"><span>{{ $other['ward_name'] }}</span>
                                                    {!! GetWardInfectionStatus(@$other['ward_infection_close_status']) !!}
                                                </a>
                                            @endif


                                        </li>
                                    @else
                                        <li
                                            class="item {{ GetWardInfectionBoxBorder(@$other['ward_infection_close_status'], $other['ward_type_primary']) }} {{ PermissionDeniedDiv('camis_classic_view') }}">
                                            <a data-toggle="tooltip" href="{{ route('ward.frailty') }}"
                                                class="{{ DisabledButtonOnRolePermission('camis_classic_view') }}"><span>{{ $other['ward_name'] }}</span>
                                                {!! GetWardInfectionStatus(@$other['ward_infection_close_status']) !!}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach


                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 order-md-1 order-0 virtual-ward-col">
                    <h3 class="">Specialist Team</h3>
                    <div class="honey_col ">

                        <ul class="container virtual_container">
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip" title="One One Care"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'one-to-one-care') }}"><span>One To One
                                        Care</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip" title="Frailty"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'frailty') }}"><span>Frailty</span></a>
                            </li>

                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip" title="AMHAT"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'amhat') }}"><span>AMHAT</span></a>
                            </li>


                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'diabetics-status') }}"><span>Diabetics +
                                        Diabetic
                                        Foot</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'dementia-delirium') }}"><span>Dementia +
                                        Delirium</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'risk-of-falls') }}"><span>Falls</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'nutrition-risk') }}"><span>Nutrition
                                        Risk</span></a>
                            </li>

                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'pressure-ulcer') }}"><span>Pressure
                                        Ulcer</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'amber-care-eol') }}"><span>Amber Care + End of
                                        Life</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'sova-dols-ld') }}"><span>SOVA + DOLS +
                                        LD</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('virtual_ward_dashboard_view') }}"
                                    href="{{ route('virtual.ward.summary', 'palliative-care') }}"><span>Palliative
                                        Care</span></a>
                            </li>
                            <li class="item color-grey {{ PermissionDeniedDiv('bed_flag_dashboard_view') }}">
                                <a data-toggle="tooltip"
                                    class="{{ DisabledButtonOnRolePermission('bed_flag_dashboard_view') }}"
                                    href="{{ route('bed.status.flag') }}"><span>Bed Flag
                                        Dashboard</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('custom-script')
        <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
        <script>
            $(document).on("click", ".click_open_definite_discharges", function(e) {
                var token = "{{ csrf_token() }}";
                $('#definite_patient_list_data').html('');

                var history_modal = new bootstrap.Offcanvas(document.getElementById('definite_patient_modal'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                history_modal.show();
                CommonDisableEnableOnOpen();
                var url = "{{ route('bed.matrix.pd_modal') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "type": '2'
                    },
                    success: function(result) {
                        if (typeof result != '') {

                            $('#definite_patient_list_data').html(result);
                            DisableLoaderAndMakeVisibleInnerBody();
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });

            });

            $(document).on("click", ".click_open_potential_discharges", function(e) {
                var token = "{{ csrf_token() }}";
                $('#definite_patient_list_data').html('');

                var history_modal = new bootstrap.Offcanvas(document.getElementById('potential_patient_modal'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                history_modal.show();
                CommonDisableEnableOnOpen();
                var url = "{{ route('bed.matrix.pd_modal') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "type": '1'
                    },
                    success: function(result) {
                        if (typeof result != '') {

                            $('#potential_patient_list_data').html(result);
                            DisableLoaderAndMakeVisibleInnerBody();
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });

            });
        </script>
    @endpush
