<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Login.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/JqueryUi.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCommonStyles.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/css/bootstrap5.0.2.min.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/icons/font/bootstrap-icons.css') }}" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Style.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/Selectric.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/toastr.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Sidebar.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/clockpicker.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCustomStyles.css') }}" crossorigin="anonymous" />
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryUi.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryMigrate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JquerySelectric.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/bootstrap/js/bootstrap5.0.2.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/clockpicker/clockpicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/Popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/toastr.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargeSummary.css') }}" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Discharges.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargedPatients.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/CustomBootstrapPrint.css') }}" crossorigin="anonymous">

    <script>
        var divToPrint = document.querySelector('.section');

        if (divToPrint) {
            var divHeight = divToPrint.offsetHeight;

            if (divHeight < window.innerHeight) {
                divToPrint.classList.add('fit-in-one-page');
            } else {
                divToPrint.classList.add('needs-new-page');
            }
        }
    </script>
    <style>
        @media print   {

            .btn{
                font-size: 10px;
            }
        }
    </style>


    <title>{{ @$patient_array->camis_patient_name }}</title>
</head>
<body>
<div class="row ">
    <div class="col-lg-12 ">
        <div class="card-ed">
            <div class="card-header fw-bold d-flex align-items-center justify-content-between ">
                DISCHARGE SUMMARY
            </div>
            <div class="card-body card-dischage-summary summery_data" id="summery_data">
                <div class="row">
                    <div class="col-lg-4 col-md-4 pe-md-1">
                        <div class="mb-2">
                            <label  class="form-label">Hospital
                                Number</label>
                            <input type="text" readonly value="{{ @$patient_array->camis_patient_pas_number }} " class="form-control" id="hos_number" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 pe-md-1 ps-md-1">
                        <div class="mb-2">
                            <label  class="form-label">NHS
                                Number</label>
                            <input type="text" readonly value="{{ @$patient_array->camis_patient_nhs_number }}" class="form-control" id="nhs_number" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 ps-md-1">
                        <div class="mb-2">
                            <label  class="form-label">Name</label>
                            <input type="text" readonly value="{{ @$patient_array->camis_patient_name }}" class="form-control" id="name" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 pe-md-1">
                        <div class="mb-2">
                            <label  class="form-label">Admitted
                                Date</label>
                            <input type="text" class="form-control" readonly @if(isset($patient_array->camis_patient_admission_date_time)) value="{{ PredefinedYearFormat($patient_array->camis_patient_admission_date_time) }}" @endif id="admission_date_time" placeholder="1st Jul 2023 22:48">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 pe-md-1 ps-md-1">
                        <div class="mb-2">
                            <label  class="form-label">Discharge
                                Date</label>
                            <input type="text" readonly @if(isset($patient_array->camis_patient_discharge_date_time)) value="{{ PredefinedYearFormat($patient_array->camis_patient_discharge_date_time) }}" @endif class="form-control" id="disharge_date_time" placeholder="2nd Jul 2023 01:25">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 ps-md-1">
                        <div class="mb-2">
                            <label  class="form-label">LOS</label>
                            <input type="text" readonly @if(isset($patient_array->camis_patient_admission_date_time) && isset($patient_array->camis_patient_discharge_date_time)) value="{{ NumberOfDays($patient_array->camis_patient_admission_date_time, $patient_array->camis_patient_discharge_date_time) }} {{ NumberOfDays($patient_array->camis_patient_admission_date_time, $patient_array->camis_patient_discharge_date_time) > 1 ? 'Days' : 'Day' }}" @endif class="form-control" id="num_days" placeholder="1">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label">Admitted
                                Reason</label>
                            <p class="comment-area">
                                {{ @$patient_array->BoardRoundAdmittingReason->patient_admitting_reason }}
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label">Past Medical History</label>
                            <p class="comment-area">
                                {{ @$patient_array->BoardRoundPastMedicalHistory->patient_past_medical_history }}
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label">Social History</label>
                            <p class="comment-area">
                                {{ @$patient_array->BoardRoundSocialHistory->patient_social_history }}
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label">Patient Goal</label>
                            <p class="comment-area">{{ @$patient_array->BoardRoundPatientGoal->patient_patient_goal }}</p>
                        </div>
                    </div>





                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">TASK COMPLETED</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-completed-tasks">
                                    <thead>
                                    <tr class="position-relative">
                                        <th class="text-center">#</th>
                                        <th>Tasks</th>
                                        <th>Created Date</th>
                                        <th>Completed Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($patient_array->BoardRoundPatientTasks))
                                        @forelse($patient_array->BoardRoundPatientTasks as $task)
                                            <tr>
                                                <td class="pivoted text-center">
                                                    <div class="tdBefore">#</div>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Tasks</div>
                                                    {{ $task->task_description }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Created Date</div>
                                                    {{ PredefinedYearFormat($task->created_at) }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Completed Date</div>
                                                    {{ PredefinedYearFormat($task->updated_at) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="no-records-row">
                                                <td class="pivoted no-records-cell w-100" colspan="4" >
                                                    <div class="tdBefore"></div>
                                                    {{ NotFoundMessage() }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr class="no-records-row">
                                            <td class="pivoted no-records-cell w-100" colspan="4" >
                                                <div class="tdBefore"></div>
                                                {{ NotFoundMessage() }}
                                            </td>
                                        </tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">FLAG</h6>
                            </div>
                            <div class="row p-3">
                                <div class="col-lg-12 text-center">
                                    <div class="flags-section">
                                        @if(isset($patient_array->PatientWiseFlags))
                                            @forelse($patient_array->PatientWiseFlags as $flag)
                                                <div class="flag-group">
                                                    {!! GetBedFlagImages($flag->patient_flag_name,100) !!}
                                                    <span> {{ GetFlagName($flag->patient_flag_name) }}</span>
                                                </div>
                                            @empty
                                                <div class="w-100">
                                                    <div class="custom_not_found">
                                                        No Flag Found!
                                                    </div>
                                                </div>


                                            @endforelse
                                        @else
                                            <div class="w-100">
                                                <div class="custom_not_found">
                                                    No Flag Found!
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">PHARMACY</h6>
                            </div>
                            <div class="row g-2 p-2">
                                <div class="col-lg-4 col-md-4 ">
                                    <button class="btn btn-discharge-grey mb-1 w-100">
                                        @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_drug_history == 1)
                                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                                 width="20">
                                        @endif
                                        DRUG HISTORY
                                        PARTIAL</button>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <button class="btn btn-discharge-grey mb-1 w-100">
                                        @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_drug_history == 2)
                                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                                 width="20">
                                        @endif
                                        DRUG HISTORY
                                        FULL</button>
                                </div>
                                <div class="col-lg-4 col-md-4 ">
                                    <button class="btn btn-discharge-grey mb-1 w-100">
                                        @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_drug_history == 3)
                                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                                 width="20">
                                        @endif
                                        MEDICATION IN DRAFT TO BE REVIEWED</button>
                                </div>
                                <div
                                    class="col-xl-4 col-lg-5 col-md-5 text-center offset-md-1 offset-lg-1
                                            offset-xl-2">
                                    <button class="btn btn-discharge-grey mb-1 w-100 mt-md-1">
                                        @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_iv_status == 1)
                                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                                 width="20">
                                        @endif
                                        ANTIBIOTICS  IV
                                        <span class="ms-3">
                              {{ PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_iv_date)  }}
                             </span>
                                    </button>
                                </div>

                                <div class="col-xl-4 col-lg-5 col-md-5  text-center">
                                    <button
                                        class="btn btn-discharge-grey mb-1 w-100 mt-md-1">
                                        @if(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_oral_status == 1)
                                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt="" class="me-3"
                                                 width="20">
                                        @endif
                                        ANTIBIOTICS
                                        ORAL<span class="ms-3"> {{ PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundPharmacyData)->pharmacy_antibiotic_oral_date)  }}
                        </span>
                                    </button>
                                </div>


                                <div class="col-12 order-md-5 order-5">
                                    <div class="">
                                        <label class="form-label">Pharmacy Comment</label>
                                        <p class="comment-area">
                                            {{ optional($patient_array->BoardRoundPharmacyData)->pharmacy_latest_comment }}
                                        </p>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">ACUITY</h6>
                            </div>
                            <div class="">

                                <div class="row g-2 row-cols-1 row-cols-sm-2 row-cols-md-5 row-cols-lg-5 p-2">
                                    <div class="col">
                                        <div class="white-box">
                                            <h6 class="mb-0">00</h6>
                                        </div>
                                        <div class="bottom-card">
                                            <div class="inner-textbox">
                                                <input class="form-control" readonly value="{{ optional(optional($patient_array->BoardRoundAcuity))->patient_acuity_option == '0'? PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundAcuity)->updated_at) : '' }}" type="text" placeholder="" aria-label="default input example">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col ">
                                        <div class="white-box">
                                            <h6 class="mb-0">1A</h6>
                                        </div>
                                        <div class="bottom-card">
                                            <div class="inner-textbox">
                                                <input class="form-control" readonly value="{{ optional($patient_array->BoardRoundAcuity)->patient_acuity_option == '1A'? PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundAcuity)->updated_at) : '' }}" type="text" placeholder="" aria-label="default input example">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="white-box">
                                            <h6 class="mb-0">1B</h6>
                                        </div>
                                        <div class="bottom-card">
                                            <div class="inner-textbox">
                                                <input class="form-control" readonly value="{{ optional($patient_array->BoardRoundAcuity)->patient_acuity_option == '1B'? PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundAcuity)->updated_at) : '' }}" type="text" placeholder="" aria-label="default input example">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="white-box">
                                            <h6 class="mb-0">1C</h6>
                                        </div>
                                        <div class="bottom-card">
                                            <div class="inner-textbox">
                                                <input class="form-control" readonly value="{{ optional($patient_array->BoardRoundAcuity)->patient_acuity_option == '1C'? PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundAcuity)->updated_at) : '' }}" type="text" placeholder="" aria-label="default input example">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="white-box">
                                            <h6 class="mb-0">02</h6>
                                        </div>
                                        <div class="bottom-card">
                                            <div class="inner-textbox">
                                                <input class="form-control" readonly value="{{ optional($patient_array->BoardRoundAcuity)->patient_acuity_option == '2'? PredefinedDateFormatFor24Hour(optional($patient_array->BoardRoundAcuity)->updated_at) : '' }}" type="text" placeholder="" aria-label="default input example">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">CARE REQUIREMENTS</h6>
                            </div>
                            <div class="row p-2 gx-2">

                                <div class="col-xl-6 col-md-6">
                                    <div class="care-block">
                                        <div class="rectangle-block-1 mb-1">
                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                        <label class="form-label mb-0 me-5">TOC</label>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input "  style="opacity: 1" disabled {{ optional($patient_array->BoardRoundCareRequirement)->care_requirements_pdna_not_required == 0 ? '':'checked' }} type="checkbox" value="" id="">
                                                            <label class="form-check-label ms-2"  style="opacity: 1">
                                                                Not Required
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="checkbox-card">
                                                        <div class="row gx-2">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="form-check mb-0">
                                                                    <input class="form-check-input" style="opacity: 1" disabled {{ optional($patient_array->BoardRoundCareRequirement)->care_requirements_pdna_nurse == 0? '' : 'checked' }} type="checkbox" value="" id="">
                                                                    <label class="form-check-label"  style="opacity: 1">
                                                                        TOC NMF for tracking
                                                                        only </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="form-check mb-0">
                                                                    <input class="form-check-input"   style="opacity: 1" disabled {{ optional($patient_array->BoardRoundCareRequirement)->care_requirements_pdna_idt == 0? '' : 'checked' }} type="checkbox" value="" id="">
                                                                    <label class="form-check-label"  style="opacity: 1">
                                                                        TOC sent to HUB IDT
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="care-block">
                                        <div class="rectangle-block-1 mb-1">
                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                        <label class="form-label mb-0">
                                                            Sent to Hub</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="checkbox-card">
                                                        <div class="row gx-2">
                                                            <div class="col-12">
                                                                <div class="form-check mb-0">
                                                                    <input class="form-check-input"  style="opacity: 1" disabled {{ optional($patient_array->BoardRoundCareRequirement)->care_requirements_pdna_sent == 0? '': 'checked' }} type="checkbox" value="" id="">
                                                                    <label class="form-check-label"  style="opacity: 1">
                                                                        Allocated to Partner</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="care-block">
                                        <div class="rectangle-block-1 mb-1">
                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                        <label for="" class="form-label mb-0">Service </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="checkbox-card">
                                                        <div class="row gx-2">
                                                            <div class="col-12">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{ @optional($patient_array->BoardRoundPathwayRequirement)->dtoc_service_text }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="care-block">
                                        <div class="rectangle-block-1 mb-1">
                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                        <label class="form-label mb-0">Pathway
                                                            Agreed</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="checkbox-card">
                                                        <div class="row gx-2">
                                                            <div class="col-12">
                                                                <label class="form-check-label">
                                                                    {{ @optional($patient_array->BoardRoundPathwayRequirement)->dtoc_pathway_text }}</label>
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
                    <div class="col-12">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">HANDOVER</h6>
                            </div>
                            <div class="row gx-2 p-2">
                                <div class="col-lg-4 col-md-4">
                                    <div class="mb-2">
                                        <input class="form-control" type="text" readonly placeholder="Consultant : Dr Aleksandar Aleksic" value="Consultant : {{ $patient_array->camis_consultant_name }}" aria-label="default input example">
                                    </div>
                                    <div class="mb-2">
                                        <input class="form-control" type="text" readonly value="EDD: {{ $patient_array->camis_consultant_name }}" placeholder="EDD:" aria-label="default input example">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 pe-md-1">
                                            <div class="mb-2">
                                                <input class="form-control" type="text" readonly value="Medfit: {{ $patient_array->BoardRoundMedicallyFitData ? ( $patient_array->BoardRoundMedicallyFitData->patient_medically_fit_status == 1? "yes" : 'No'): '' }}" placeholder="Medfit: No" aria-label="default input example">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 ps-md-1">
                                            <div class="mb-2">
                                                <input class="form-control" type="text" readonly value="OBS : {{ $patient_array->PatientHandOver ?$patient_array->PatientHandOver->ibox_handover_obs_varience: '' }}" placeholder="OBS :" aria-label="default input example">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <input class="form-control" type="text" readonly value="Variances : {{ $patient_array->PatientHandOver ?$patient_array->PatientHandOver->ibox_handover_varience_store: '' }}" placeholder="Variances :" aria-label="default input example">
                                    </div>
                                    <div class="d-flex justify-content-start mb-2">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input p-2 " disabled style="opacity: 1;" {{ @$patient_array->PatientHandOver->ibox_handover_pain_analgesia == 0 ? '':'checked' }} type="checkbox" value="" id="">
                                            <label class="form-check-label ms-2 pt-1" style="opacity: 1;">Pain / Analgesia</label>
                                        </div>
                                        <div class=' padding-zero  ' style='padding: 2px 0 0 35px;'>
                                            @if(@$patient_array->PatientHandOver->ibox_handover_pain_analgesia == 1)
                                                Please refer to EPMA
                                            @endif</div>
                                    </div>
                                    <div class="rectangle-block-1 mb-1 keep-moving">
                                        <div class="row ">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                    <label for="" class="form-label mb-0">
                                                        K - KEEP MOVING</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                                <div class="checkbox-card p-2">
                                                    <div class="mb-2">
                                                        <label for="exampleFormControlInput1" class="form-label">Mobility</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_mobility:'' }}" placeholder="">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="exampleFormControlInput1" class="form-label">Equipment</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_equipment:'' }}" placeholder="">
                                                    </div>
                                                    <div class="mb-2 mb-md-0">
                                                        <label for="exampleFormControlInput1" class="form-label">Assistance
                                                            Needed</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_assistance_needed:'' }}" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                @php

                                    $s_surface_varience_array = [];
                                    $s_surface_varience_array = explode(',', $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_s_surface:'');

                                @endphp

                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-ash">
                                        <div class="rectangle-block-1 mb-1">
                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                        <label for="" class="form-label mb-0">
                                                            S - SURFACE</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="checkbox-card p-2">

                                                        @for ($x = 0; $x < 5; $x++)
                                                            <div @if($x < 4) class="mb-2" @endif>
                                                                <input class="form-control" readonly value="@if(isset($s_surface_varience_array[$x])){{ $s_surface_varience_array[$x] }}@endif" type="text" placeholder="" aria-label="default input example">
                                                            </div>
                                                        @endfor

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rectangle-block-1 mb-1 continence">
                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                        <label for="" class="form-label mb-0">
                                                            I - CONTINENCE</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="checkbox-card p-2">
                                                        <div class="">
                                                            <input class="form-control" type="text" readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_i_continence : "" }}" placeholder="" aria-label="default input example">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="rectangle-block-1 mb-1">
                                        <div class="row ">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                    <label for="" class="form-label mb-0">
                                                        S - SKIN</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                                <div class="checkbox-card p-2">
                                                    <div class="mb-2">
                                                        <label for="exampleFormControlInput1" class="form-label">Repositioning
                                                            Routine</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1"  readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_repositioning_routine:'' }}" placeholder="">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="exampleFormControlInput1" class="form-label">Skin
                                                            Conditioning</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1" readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_skin_conditioning :'' }}" placeholder="">
                                                    </div>
                                                    <div class="">
                                                        <label for="exampleFormControlInput1" class="form-label">Dressings</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1" readonly value="{{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_dressings:'' }}" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rectangle-block-1 mb-1 nutrition">
                                        <div class="row ">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-start align-items-center rectangle-block-2">
                                                    <label for="" class="form-label mb-0">
                                                        N - NUTRITION</label>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $s_surface_varience_array = [];
                                            $s_surface_varience_array = explode(',', $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_n_nutrition : "");

                                        @endphp
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                                <div class="checkbox-card p-2">
                                                    <div class="row">
                                                        @for ($x = 0; $x < 9; $x++)
                                                            <div class="col-lg-6 col-md-6 pe-md-1">
                                                                <div class="mb-2">
                                                                    <input class="form-control" readonly value="@if(isset($s_surface_varience_array[$x])){{ $s_surface_varience_array[$x] }}@endif" type="text" placeholder="" aria-label="default input example">
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="">
                                        <label class="form-label">N - Nutrition Special Diet Comment</label>
                                        <p class="comment-area"> {{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_special_diet_comment : "" }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="">
                                        <label class="form-label">Comment</label>
                                        <p class="comment-area">
                                            {{ $patient_array->PatientHandOver?$patient_array->PatientHandOver->ibox_handover_comment : "" }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">DISCHARGE TRACKER</h6>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-4 col-md-4 pe-md-1">
                                    <div class="mb-2">
                                        <label  class="form-label">Pathway</label>
                                        <input type="text" class="form-control" readonly  value=" {{ $patient_array->BoardRoundPathwayRequirement?$patient_array->BoardRoundPathwayRequirement->DtocPathway->dtoc_pathway_text : '' }} " placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 pe-md-1 ps-md-1">
                                    <div class="mb-2">
                                        <label  class="form-label">Coded to</label>
                                        <input type="text" class="form-control" readonly @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->dtoc_current_status_coded) ) value="{{ $patient_array->BoardRoundPathwayRequirement->dtoc_current_status_coded  }}" @endif placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 ps-md-1">
                                    <div class="mb-2">
                                        <label  class="form-label">Current Status</label>
                                        <input type="text" class="form-control" readonly @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->DtocStatus->dtoc_current_status_text)) value="{{ $patient_array->BoardRoundPathwayRequirement->DtocStatus->dtoc_current_status_text }}" @endif placeholder="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label  class="form-label">Authority</label>
                                        <input type="text" class="form-control" readonly  @if(isset($patient_array->BoardRoundPathwayRequirement) && isset($patient_array->BoardRoundPathwayRequirement->dtoc_authority_text))  value="{{ $patient_array->BoardRoundPathwayRequirement->dtoc_authority_text  }}" @endif placeholder="">
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="mb-2">
                                        <label  class="form-label">Comments</label>
                                        <div class="card-col-grp">
                                            <div class="row gx-1">
                                                @forelse($patient_array->BoardRoundDtocComments as $comments)
                                                    <div class="col-12">
                                                        <span class="comment">{{ $comments->join_comments  }}</span>
                                                    </div>
                                                @empty
                                                    <div class="col-12 text-center">
                                                        <span class="comment">No Records Found</span>
                                                    </div>
                                                @endforelse
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
</div>
</body>


<script>
    window.print();
    window.onafterprint = function () {
        window.close();
    };
</script>
</html>
