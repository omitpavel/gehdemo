<div class="col-lg-12">
    <div class="row g-2">
        <div class="col-xl-3 col-lg-4 col-md-3">
            <div class="card-date">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="cyan-circle text-center me-2">
                            <i class="bi bi-calendar3 "></i>
                        </div>
                        <div class="date-box w-90">
                            <input type="text" name="datepicker" id="daterangepicker"
                                placeholder="{{ date('D d M Y', strtotime($date)) }}" class="hasDatepicker">
                                <input type="hidden" id="date" value="{{ $date }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-9 ">
            <div class="ed-ems-tab">
                <ul class="nav nav-tabs" id="edEmsTab" role="tablist">

                    @if (count($all_times) > 0)
                        @foreach ($all_times as $row)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($loop->iteration == 1) active @endif" id="ople-slot-{{ str_replace(':', '_', $row) }}-tab" data-bs-toggle="tab" data-bs-target="#opel-slot-{{ str_replace(':', '_', $row) }}" type="button" role="tab" aria-controls="opel-slot-{{ str_replace(':', '_', $row) }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $row }}</button>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content" id="edEmsTabContent">
        @if(count($time_wise_date) > 0)
            @foreach ($time_wise_date as $key => $row)

                @php($opel = $time_wise_date[$key])

                <div class="tab-pane fade  @if ($loop->iteration == 1) show active @endif" id="opel-slot-{{ str_replace(':', '_', $key) }}" role="tabpanel" aria-labelledby="opel-slot-{{ str_replace(':', '_', $key) }}-tab">
                    <div class="ems-data-details">
                        <div class="text-end">
                            <button type="button" class="btn btn-export print_opel_data">
                                <img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="me-2" width="16">Print
                            </button>
                        </div>
                        <div id="dataEmsHistory">
                            <div class="ems-top-section">
                                <div class="row g-2 mb-2">
                                    <div class="col-sm-4">
                                        <div class="">
                                            <label for="" class="form-label mb-1">Completed by :</label>
                                            <input class="form-control" type="text" value="{{ $row['ed_thermo_meter_completed_by'] ?? '' }}"
                                                aria-label="default input example" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="">
                                            <label for="" class="form-label mb-1">No. Patients in ED :</label>
                                            <input class="form-control" type="text" placeholder="" value="{{ $row['ed_thermo_meter_patient_in_ed'] ?? '' }}"
                                                aria-label="default input example" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="">
                                            <label for="" class="form-label mb-1">No. Patients Waiting for a Bed :</label>
                                            <input class="form-control" type="text" placeholder="" value="{{ $row['ed_thermo_meter_patient_awaiting_bed'] ?? '' }}"
                                                aria-label="default input example" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ems-details">
                                <div class="card-sitrep ems-time-row mb-2">
                                    <div class="card-sitrep-modal">
                                        <div class="d-none d-md-block">
                                            <div class="row g-2 mb-2">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4 ps-3">Number Of Patients</div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2">
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">Triage</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['triage_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">First Assessment
                                                                Resus</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['first_assesment_resus_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">First Assessment
                                                                Majors</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['first_assesment_majors_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">First Assessment
                                                                Paeds</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['first_assesment_peads_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">Medical Review</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['medical_review_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">Surgical
                                                                Review</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['surgical_review_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">Orthopaedic
                                                                Review</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['orthopaedic_review_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0">Other Speciality
                                                                Review</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['other_speciality_review_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">
                                                            <label for="" class="form-label mb-0"> UTC</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" placeholder="" aria-label="default input example"  value="{{ $row['gp_review_patient'] ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="card-sitrep staffing-absent mb-2">
                                    <div class="safety-content-wrapper">
                                        <div class="card-sitrep-modal mb-2">
                                            <div class="category-header">
                                                <label for="" class="form-label mb-0">INDICATORS</label>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-4"></div>
                                                                    <div class="col-md-2"></div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center">
                                                                            <div class="opel-amber-circle">
                                                                            </div>
                                                                            <div>
                                                                                <span>EMS 2</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center">
                                                                            <div class="opel-red-circle"></div>
                                                                            <div>
                                                                                <span>EMS 3</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center">
                                                                            <div class="opel-black-circle">
                                                                            </div>
                                                                            <div>
                                                                                <span>EMS 4</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="safety-content-wrapper">
                                        <div class="card-sitrep-modal">
                                            <div class="category-header">
                                                <label for="" class="form-label mb-0">Staffing Absent</label>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-6"></div>
                                                                    <div
                                                                        class="col-lg-2 col-md-2 col-4 text-center">
                                                                        <label for="" class="form-label">1
                                                                        </label>
                                                                    </div>
                                                                    <div
                                                                        class="col-lg-2 col-md-2 col-4 text-center">
                                                                        <label for="" class="form-label">2
                                                                        </label>
                                                                    </div>
                                                                    <div
                                                                        class="col-lg-2 col-md-2 col-4 text-center">
                                                                        <label for=""
                                                                            class="form-label">3+</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="FY1">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">FYI</label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_FYU'] ?? null) == 1 ? 'active' : '' !!}" >
                                                                                {!! ($row['staff_absent_FYU'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}

                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-na">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-na">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                disabled="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="FY2">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">FY2</label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber ">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_FY2'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_FY2'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}

                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_FY2'] ?? null) == 2 ? 'active' : '' !!}">{!! ($row['staff_absent_FY2'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_FY2'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_FY2'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="CT1">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">CT1-3
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber ">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_CT1_3'] ?? null) == 1 ? 'active' : '' !!}">{!! ($row['staff_absent_CT1_3'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red ">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_CT1_3'] ?? null) == 2 ? 'active' : '' !!}">{!! ($row['staff_absent_CT1_3'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_CT1_3'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_CT1_3'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="CT4">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">CT4+
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red ">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_CT4+'] ?? null) == 1 ? 'active' : '' !!}">{!! ($row['staff_absent_CT4+'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black ">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_CT4+'] ?? null) == 2 ? 'active' : '' !!}">{!! ($row['staff_absent_CT4+'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black ">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_CT4+'] ?? null) == 3 ? 'active' : '' !!}">{!! ($row['staff_absent_CT4+'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center"
                                                                    id="Consultant">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Consultant
                                                                            Cover
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black ">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Consultant_Cover'] ?? null) == 1 ? 'active' : '' !!}">{!! ($row['staff_absent_Consultant_Cover'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-na">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-na">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                disabled="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="HCSW">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">HCSW
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_HCSW'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_HCSW'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_HCSW'] ?? null) == 2 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_HCSW'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_HCSW'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_HCSW'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="Band5">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Band
                                                                            5
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_5'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_5'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_5'] ?? null) == 2 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_5'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_5'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_5'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="Band6">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Band
                                                                            6
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_6'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_6'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_6'] ?? null) == 2 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_6'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_6'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_6'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="Band7">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Band
                                                                            7
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_7'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_7'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_7'] ?? null) == 2 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_7'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Band_7'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Band_7'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="ECP">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">ECP
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_ECP'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_ECP'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_ECP'] ?? null) == 2 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_ECP'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_ECP'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_ECP'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center" id="ACP">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">ACP
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_ACP'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_ACP'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_ACP'] ?? null) == 2 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_ACP'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_ACP'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_ACP'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center"
                                                                    id="Receptionist">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Receptionist
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-amber">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Receptionist'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Receptionist'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Receptionist'] ?? null) == 2 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Receptionist'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-black">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Receptionist'] ?? null) == 3 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Receptionist'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center"
                                                                    id="Progress">
                                                                    <div class="col-md-6">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Progress
                                                                            Chaser
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-time-red">
                                                                            <button class="btn btn-ems {!! ($row['staff_absent_Progress_Chaser'] ?? null) == 1 ? 'active' : '' !!}">
                                                                                {!! ($row['staff_absent_Progress_Chaser'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-na">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-4">
                                                                        <div class="opel-na">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                disabled="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-sitrep mb-2">
                                    <div class="safety-content-wrapper mb-2">
                                        <div class="card-sitrep-modal mb-2">
                                            <div class="category-header">
                                                <label for="" class="form-label mb-0">INDICATORS</label>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2"></div>
                                                                    <div class="col-lg-2"></div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center">
                                                                            <div class="opel-green-circle">
                                                                            </div>
                                                                            <div>
                                                                                <span>EMS 1</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center">
                                                                            <div class="opel-amber-circle">
                                                                            </div>
                                                                            <div>
                                                                                <span>EMS 2</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center">
                                                                            <div class="opel-red-circle"></div>
                                                                            <div>
                                                                                <span>EMS 3</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center">
                                                                            <div class="opel-black-circle">
                                                                            </div>
                                                                            <div>
                                                                                <span>EMS 4</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="safety-content-wrapper mb-2">
                                        <div class="card-sitrep-modal">
                                            <div class="category-header">
                                                <label for="" class="form-label mb-0">Inflow</label>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">RATT
                                                                            bays
                                                                            <br
                                                                                class="d-none d-lg-block">free</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['ratt_bays_free_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for=""
                                                                            class="form-label">>3</label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"  value="{{ $row['ratt_bays_free_green'] ?? 0 }}" readonly
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for=""
                                                                            class="form-label">2-3</label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example"  value="{{ $row['ratt_bays_free_amber'] ?? 0 }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">1
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['ratt_bays_free_red'] ?? 0 }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">0
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example"  value="{{ $row['ratt_bays_free_black'] ?? 0 }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">No
                                                                            patients
                                                                            <br class="d-none d-lg-block"> in
                                                                            resus
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['no_patients_in_resus_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">0
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example" value="{{ $row['no_patients_in_resus_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">2
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example" value="{{ $row['no_patients_in_resus_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">3
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example" value="{{ $row['no_patients_in_resus_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>3
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['no_patients_in_resus_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">No.
                                                                            patients
                                                                            arriving/hr
                                                                            <br class="d-none d-lg-block">over
                                                                            past
                                                                            2
                                                                            hours
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['patients_arriving_per_hour_last_2_hours_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">&lt;10
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example"  value="{{ $row['patients_arriving_per_hour_last_2_hours_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">15 - 19
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example"  value="{{ $row['patients_arriving_per_hour_last_2_hours_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">20 - 25
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['patients_arriving_per_hour_last_2_hours_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>25
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example"  value="{{ $row['patients_arriving_per_hour_last_2_hours_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Majors
                                                                            cubicles
                                                                            available
                                                                            <br class="d-none d-lg-block">for
                                                                            patient
                                                                            assessment
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['majors_cubicles_available_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">&lt;4
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example"  value="{{ $row['majors_cubicles_available_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">2 - 3
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example"  value="{{ $row['majors_cubicles_available_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">1
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['majors_cubicles_available_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">0
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example"  value="{{ $row['majors_cubicles_available_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Ambulances
                                                                            <br
                                                                                class="d-none d-lg-block">en-route</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['ambulances_en_route_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">&lt;3
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_en_route_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">3 - 4
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_en_route_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">5
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_en_route_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>6
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_en_route_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Ambulance
                                                                            <br class="d-none d-lg-block">
                                                                            handover
                                                                            delay
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['ambulance_handover_delay_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">0
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example"  value="{{ $row['ambulance_handover_delay_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">15 - 29
                                                                            Min</label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example"  value="{{ $row['ambulance_handover_delay_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">30 - 59
                                                                            Min
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['ambulance_handover_delay_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>60
                                                                            Min</label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example"  value="{{ $row['ambulance_handover_delay_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Ambulances
                                                                            <br class="d-none d-lg-block">held
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['ambulances_held_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">0
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_held_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">1 - 3
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_held_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">4
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_held_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>4
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example"  value="{{ $row['ambulances_held_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Patients in
                                                                            <br class="d-none d-lg-block">Temporary Escalation Space
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['patients_in_temporary_escalation_space_opel']] ?? null }}" readonly>

                                                                    </div>


                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class=" opel-time-green w-100">
                                                                            <input class="form-control" type="text"  value="{{ $custom_drop_down[$row['patients_in_temporary_escalation_space_green']] ?? null }}" aria-label="default input example" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class=" opel-time-amber w-100">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['patients_in_temporary_escalation_space_amber'] ?? '' }}" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red">


                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['patients_in_temporary_escalation_space_red'] ?? '' }}" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example" value="{{ $row['patients_in_temporary_escalation_space_black'] ?? '' }}" readonly>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="safety-content-wrapper mb-2">
                                        <div class="card-sitrep-modal">
                                            <div class="category-header">
                                                <label for="" class="form-label mb-0">Acuity</label>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">No.
                                                                            critically ill/injured
                                                                            <br class="d-none d-lg-block">
                                                                            req. cardiac arrest/ trauma
                                                                            team</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['critically_ill_injured_cardiactrauma_opel']] ?? null }}" readonly>

                                                                    </div>

                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">1
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder=""
                                                                                aria-label="default input example" value="{{ $row['critically_ill_injured_cardiactrauma_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">2
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder=""
                                                                                aria-label="default input example" value="{{ $row['critically_ill_injured_cardiactrauma_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for=""
                                                                            class="form-label">3</label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder=""
                                                                                aria-label="default input example" value="{{ $row['critically_ill_injured_cardiactrauma_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>3
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder=""
                                                                                aria-label="default input example" value="{{ $row['critically_ill_injured_cardiactrauma_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Special
                                                                            care
                                                                            patients
                                                                            <br
                                                                                class="d-none d-lg-block">requiring
                                                                            extensive
                                                                            staff input</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['special_care_patients_extensive_staff_input_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">&nbsp;
                                                                        </label>
                                                                        <div class="opel-time-green w-100">
                                                                            <input class="form-control" type="text"  value="{{ $custom_drop_down[$row['special_care_patients_extensive_staff_input_green']] ?? null }}" aria-label="default input example" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">&nbsp;
                                                                        </label>
                                                                        <div class=" opel-time-amber w-100">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['special_care_patients_extensive_staff_input_amber'] ?? '' }}" readonly>

                                                                        </div>


                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">1
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder=""
                                                                                aria-label="default input example" value="{{ $row['special_care_patients_extensive_staff_input_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>1
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder=""
                                                                                aria-label="default input example"  value="{{ $row['special_care_patients_extensive_staff_input_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Patient
                                                                            safety
                                                                            round
                                                                            <br
                                                                                class="d-none d-lg-block">identifies
                                                                            safety
                                                                            concerns
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">

                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['safety_round_identifies_concerns_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class=" opel-time-green w-100">
                                                                            <input class="form-control" type="text"  value="{{ $custom_drop_down[$row['safety_round_identifies_concerns_green']] ?? null }}" aria-label="default input example" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class=" opel-time-amber w-100">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['safety_round_identifies_concerns_amber'] ?? '' }}" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class=" opel-time-red w-100">
                                                                            <input class="form-control" type="text"  value="{{ $custom_drop_down[$row['safety_round_identifies_concerns_red']] ?? null }}" aria-label="default input example" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class="opel-time-black w-100">
                                                                            <input class="form-control" type="text"  value="{{ $custom_drop_down[$row['safety_round_identifies_concerns_black']] ?? null }}" aria-label="default input example" readonly>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="safety-content-wrapper mb-2">
                                        <div class="card-sitrep-modal">
                                            <div class="category-header">
                                                <label for="" class="form-label mb-0">Outflow</label>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="row-border-bottom">
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">No.
                                                                            patients
                                                                            waiting
                                                                            <br class="d-none d-lg-block">for a
                                                                            bed</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['patients_waiting_for_bed_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">
                                                                        </label>
                                                                        <div class=" opel-time-green w-100">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['patients_waiting_for_bed_green'] ?? '' }}" readonly>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">1 - 4
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example" value="{{ $row['patients_waiting_for_bed_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">5 - 8
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example" value="{{ $row['patients_waiting_for_bed_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>8
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['patients_waiting_for_bed_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Patients
                                                                            in
                                                                            department
                                                                            <br class="d-none d-lg-block">>12
                                                                            hours
                                                                            from arrival</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">
                                                                        <label for=""
                                                                            class="d-none d-sm-block form-label">&nbsp;
                                                                        </label>
                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['patients_in_department_over_12_hours_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">0
                                                                        </label>
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example" value="{{ $row['patients_in_department_over_12_hours_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">
                                                                        </label>
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['patients_in_department_over_12_hours_amber'] ?? '' }}" readonly>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">4
                                                                        </label>
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example" value="{{ $row['patients_in_department_over_12_hours_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <label for="" class="form-label">>4
                                                                        </label>
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['patients_in_department_over_12_hours_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <label for=""
                                                                            class="form-label mb-lg-0">Closure
                                                                            of
                                                                            <br class="d-none d-lg-block">
                                                                            internal
                                                                            ED
                                                                            area</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-4">

                                                                        <input class="form-control" type="text" value="{{ $opel_drop_down[$row['closure_of_internal_ed_area_opel']] ?? null }}" readonly>

                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class=" opel-time-green w-100">
                                                                            <input class="form-control" type="text"  value="{{ $custom_drop_down[$row['closure_of_internal_ed_area_green']] ?? null }}" aria-label="default input example" readonly>


                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['closure_of_internal_ed_area_amber'] ?? '' }}" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="N/A"
                                                                                aria-label="default input example"
                                                                                value="{{ $row['closure_of_internal_ed_area_red'] ?? '' }}" readonly>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 mb-2 mb-sm-0">
                                                                        <div class=" opel-time-black w-100">
                                                                            <input class="form-control" type="text"  value="{{ $custom_drop_down[$row['closure_of_internal_ed_area_black']] ?? null }}" aria-label="default input example" readonly>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-sitrep">
                                    <div class="safety-content-wrapper">
                                        <div class="card-sitrep-modal mb-2">
                                            <div class="category-header">
                                                <label for="" class="form-label mb-0">THERMOMETER</label>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4">
                                                                        <div class="">
                                                                            <label for=""
                                                                                class="form-label mb-lg-0">Staffing
                                                                                <br
                                                                                    class="d-none d-lg-block"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example"  value="{{ $row['total_staffing_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example"  value="{{ $row['total_staffing_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['total_staffing_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['total_staffing_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4">
                                                                        <div class="">
                                                                            <label for=""
                                                                                class="form-label mb-lg-0">Inflow
                                                                                <br
                                                                                    class="d-none d-lg-block"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example" value="{{ $row['total_inflow_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example" value="{{ $row['total_inflow_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example" value="{{ $row['total_inflow_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['total_inflow_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4">
                                                                        <div class="">
                                                                            <label for=""
                                                                                class="form-label mb-lg-0">Acuity
                                                                                <br
                                                                                    class="d-none d-lg-block"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example" value="{{ $row['total_acuity_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example" value="{{ $row['total_acuity_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example" value="{{ $row['total_acuity_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['total_acuity_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-border-bottom">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4">
                                                                        <div class="">
                                                                            <label for=""
                                                                                class="form-label mb-lg-0">Outflow
                                                                                <br class="d-none d-lg-block">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example" value="{{ $row['total_outflow_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example" value="{{ $row['total_outflow_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example" value="{{ $row['total_outflow_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['total_outflow_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="safety-content-wrapper">
                                        <div class="card-sitrep-modal mb-2">
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="ed-total-row">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <div class="">
                                                                            <div class="total-header">
                                                                                <label for=""
                                                                                    class="form-label mb-lg-0">TOTALS
                                                                                    <br
                                                                                        class="d-none d-lg-block">
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2"></div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-green">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="5"
                                                                                aria-label="default input example" value="{{ $row['total_green'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-amber">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="7"
                                                                                aria-label="default input example" value="{{ $row['total_amber'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="9"
                                                                                aria-label="default input example"  value="{{ $row['total_red'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-black">
                                                                            <input class="form-control"
                                                                                type="text" placeholder="12"
                                                                                aria-label="default input example" value="{{ $row['total_black'] ?? '' }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="safety-content-wrapper">
                                        <div class="card-sitrep-modal mb-2">
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-12 gx-2">
                                                        <div class="right-side-area">
                                                            <div class="ed-status-row">
                                                                <div class="row align-items-center"
                                                                    id="edStatusSection">
                                                                    <div class="col-lg-2">
                                                                        <div class="">
                                                                            <div class="total-header">
                                                                                <label for=""
                                                                                    class="form-label mb-lg-0">ED
                                                                                    STATUS
                                                                                    IS
                                                                                    <br
                                                                                        class="d-none d-lg-block">
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2"></div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div
                                                                            class="opel-time-green bg-opel-green">
                                                                            <button class="btn btn-ems {!! ($row['current_opel_status'] ?? null) == 1 ? 'active' : '' !!}"
                                                                                id="statusGreen">
                                                                                EMS 1 {!! ($row['current_opel_status'] ?? null) == 1 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div
                                                                            class="opel-time-amber bg-opel-amber">
                                                                            <button class="btn btn-ems {!! ($row['current_opel_status'] ?? null) == 2 ? 'active' : '' !!}"
                                                                                id="statusAmber">
                                                                                EMS 2 {!! ($row['current_opel_status'] ?? null) == 2 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div class="opel-time-red bg-opel-red">
                                                                            <button class="btn btn-ems {!! ($row['current_opel_status'] ?? null) == 3 ? 'active' : '' !!}"
                                                                                id="statusRed">
                                                                                EMS 3 {!! ($row['current_opel_status'] ?? null) == 3 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-3 mb-2 mb-sm-0">
                                                                        <div
                                                                            class="opel-time-black bg-opel-black">
                                                                            <button class="btn btn-ems {!! ($row['current_opel_status'] ?? null) == 4 ? 'active' : '' !!}"
                                                                                id="statusBlack">
                                                                                EMS 4 {!! ($row['current_opel_status'] ?? null) == 4 ? '<img src="' . asset('asset_v2/Template/icons/tick-circle.svg') . '">' : '' !!}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="safety-content-wrapper">
                                        <div class="card-sitrep-modal">
                                            <div class="content-wrapper">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-sm-6 mb-2">
                                                        <label for="" class="form-label">CURRENT NO.
                                                            BREACHES
                                                        </label>
                                                        <div class="">
                                                            <input class="form-control" type="text"
                                                                placeholder="5"
                                                                aria-label="default input example" value="{{ $row['current_number_of_breaches'] ?? '' }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label for="" class="form-label">RETROSPECTIVE
                                                            4-HOUR
                                                            PERFORMANCE FOR DAY
                                                        </label>
                                                        <div class="">
                                                            <input class="form-control" type="text"
                                                                placeholder="5"
                                                                aria-label="default input example" value="{{ $row['four_hour_performance_of_the_day'] ?? '' }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="" class="form-label">NOTES</label>
                                                        <textarea class="form-control" id=""
                                                            rows="3" readonly>{{ $row['ed_thermometer_notes'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="custom_not_found">{{ NotFoundMessage() }}</div>
        @endif
    </div>
</div>
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    $(function() {

            @if(!empty(request()->get('date')))
                var start = moment('{{request()->get('date')}}', 'YYYY-MM-DD');
            @else
                var start = moment().endOf('day');
            @endif

        function cb(start) {
            $('#daterangepicker').val(start.format('MMMM D, YYYY'));
            $('#date').val(start.format('YYYY-MM-DD'));
            DataPageLoad(start.format('YYYY-MM-DD'))
        }

        $('#daterangepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            startDate: start,
            minDate: moment().subtract(365, 'days').endOf('day'),
            maxDate: moment().endOf('day'),
            locale: {
                format: 'ddd MMMM D, YYYY'
            }
        }, cb);



    });
</script>
