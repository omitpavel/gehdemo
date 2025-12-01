<div class="col-lg-12">
    <div class="row">
        <div class="col-xxl-6 pe-xxl-1">
            <div class="row mb-2">
                <div class="col-lg-6 col-md-7 pe-md-1 mb-2 mb-md-0">
                    <div class="rectangle-block-3 " id="">
                        <div class="col-lg-12 ">
                            <div class="row align-items-center ae-container">
                                <h1 class="header-ae">A&amp;E</h1>
                                <div class="col-xxl-6 col-lg-5 col-md-4 col-4">

                                    <p class="mb-0">Attendance Since </p>

                                    <p class="mb-0"> Midnight </p>
                                </div>
                                <div class="col-xxl-3 col-lg-3 col-md-4 col-4 text-center">
                                    <h6 class="fs-5 mb-0 fw-bold">{{ $success_array['attendance']['type_1_2_3'] }}</h6>
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-4">
                                    <div class="{{ $success_array["attendance_class"] }}">
                                        @if($success_array['attendance_color'] == '#0066FF')

                                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 109 93">
                                                <path id="Union_56" data-name="Union 56" d="M24.77,93a8,8,0,0,1-8-8V48.434a8.045,8.045,0,0,1,.146-1.53H0L54.5,0,109,46.9H92.085a8.043,8.043,0,0,1,.146,1.53V85a8,8,0,0,1-8,8Z" fill="{{ $success_array['attendance_color'] }}"></path>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 109 93.001">
                                                <path id="Union_57" data-name="Union 57" d="M0,46.1H16.916a8.038,8.038,0,0,1-.146-1.531V8a8,8,0,0,1,8-8H84.231a8,8,0,0,1,8,8V44.565a8.036,8.036,0,0,1-.146,1.531H109L54.5,93Z" fill="{{ $success_array["attendance_color"] }}"></path>
                                            </svg>
                                        @endif

                                        <span class="">{{ $success_array['attendance_difference'] > 0 ? '+' . $success_array['attendance_difference'] : $success_array['attendance_difference'] }}
                                        </span>
                                    </div>
                                </div>



                            </div>
                            <div class="rectangle-block-4">
                                <div class="row align-items-center">
                                    <div class="col-lg-8 col-md-8 col-6">
                                        <p class="mb-0">Average for Past 4 Weeks</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-6 text-center">
                                        <h6 class="mb-0 fs-5 fw-bold">{{ $success_array['symphony_average_attendance'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="waiting-time-wrapper">
                        <table class="table-waiting-time">
                            <tbody>
                                <tr class="cursor_pointer click_open_ane_details" data-type="ed" data-key="in_ed">
                                    <td>In ED </td>
                                    <td>{{ $success_array["still_in_ae_patients_list"] }}</td>
                                </tr>
                                <tr class="cursor_pointer click_open_ane_details" data-type="ed" data-key="in_ed_corridor">
                                    <td>In ED Corridor</td>
                                    <td>{{ $success_array['in_ed_corridor'] }}</td>
                                </tr>
                                <tr class="cursor_pointer click_open_ane_details" data-type="ed" data-key="in_ambulance_bay">
                                    <td>In Ambulance Bay</td>
                                    <td>{{ $success_array['in_ambulance_bay'] }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div><svg xmlns="http://www.w3.org/2000/svg" width="35.97" height="18.4" viewBox="0 0 35.97 18.4" class="me-3">
                                                <g id="Group_2602" data-name="Group 2602" transform="translate(1 1)">
                                                    <path id="Path_21765" data-name="Path 21765" d="M4,4v6.994a4,4,0,0,0,4,4h28.4" transform="translate(-4 -4)" fill="none" stroke="#06f" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                    <path id="Path_21766" data-name="Path 21766" d="M4,10l5,5-5,5" transform="translate(24.974 -4.005)" fill="none" stroke="#06f" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                </g>
                                            </svg>
                                            Longest Wait</div>
                                    </td>
                                    <td>{{ $success_array['longest_wait_ambulance_bay'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 ps-md-1 text-center">

                    <div class="rectangle-box-guage p-0">
                        <div class="gauge-head">
                            <p class="mb-0">PERFORMANCE</p>
                        </div>
                        <div class="row gx-2 align-items-center">
                            <div class="col-8">
                                <div class="performance-chart">
                                    <div class="progress-bg">
                                        <div class="bar-progress">
                                            <div class="bars-green " style="width: {{ round($success_array['top_matrix']['performance_value']) }}%">
                                            </div>
                                            <div class="bars-ash" style="width: {{ round(100 - $success_array['top_matrix']['performance_value']) }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <h4 class="performance-value">{{ $success_array['top_matrix']['performance_value'] }}%</h4>
                            </div>
                        </div>

                    </div>


                    <div class="gauge-bottom-box">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Admitted</h6>
                            <h6 class="fw-bold mb-0">{{ $success_array['top_matrix']['performance']['admitted_value'] }}%</h6>
                        </div>
                        <hr class="hr-line">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Non-Admitted</h6>
                            <h6 class="fw-bold mb-0">{{ $success_array['top_matrix']['performance']['nonadmitted_value'] }}%</h6>
                        </div>
                    </div>
                    <div class="dta-wrapper">
                        <div class="rectangle-block-3">
                            <div>
                                <table class="table-admitted">
                                    <thead>
                                        <tr><th class="border-bottom" colspan="4">DTA's in ED</th>
                                    </tr></thead>
                                    <tbody>
                                        @foreach ($success_array['dta_in_ed'] as $dta_ed)
                                        <tr class="{{ ($loop->even) ? 'bg-grey' : 'bg-white' }} cursor_pointer click_open_ane_details"  data-type="dta" data-key="{{ $dta_ed['keyvalue'] }}">
                                            <td>{{ strtoupper($dta_ed['keyvalue']) }}</td>
                                            <td>{{ $dta_ed['val'] }}</td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="admission-discharge-details">
                <div class="header">
                    EMERGENCY ADMISSION &amp; DISCHARGES PER WARD
                </div>
                <div>
                    <div class="row gx-0">
                        <div class="col-lg-6">
                            <div class="ward-title">MEDICAL</div>
                            <table class="table-admission-discharge-details">
                                <thead>
                                    <tr>
                                        <th>Admissions</th>
                                        <th>Wards</th>
                                        <th>Discharges</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($success_array['medical_patient_admission_discharge_count'] as $ward_key => $admission_discharge_value)
                                        @php($ward_name = $success_array['ward_shown_array'][$ward_key] ?? '')
                                        <tr>
                                            <td class="click_open_all_bed cursor_pointer" data-type="overall_inpatient_{{ $ward_key }}">{{ $admission_discharge_value['admission'] }}</td>
                                            <td>{{ stripos($title = $ward_name ?? '', 'sdec') !== false ? 'SDEC' : ucwords($title) }}</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="overall_outpatient_{{ $ward_key }}">{{ $admission_discharge_value['discharge'] }}</td>
                                        </tr>
                                    @endforeach
                                    @if($success_array['row_def_admission_discharge'] < 0)
                                    @for ($i = 0; $i < abs($success_array['row_def_admission_discharge']); $i++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    @endfor
                                @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <div class="ward-title">SURGICAL & OTHERS</div>
                            <table class="table-admission-discharge-details">
                                <thead>
                                    <tr>
                                        <th>Admissions</th>
                                        <th>Wards</th>
                                        <th>Discharges</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($success_array['surgical_patient_admission_discharge_count'] as $ward_key => $admission_discharge_value)
                                        <tr>

                                            @php($ward_name = $success_array['ward_shown_array'][$ward_key] ?? '')

                                            <td class="click_open_all_bed cursor_pointer" data-type="overall_inpatient_{{ $ward_key }}">{{ $admission_discharge_value['admission'] }}</td>
                                            <td>{{ucwords($ward_name)}} {{-- stripos($title = $ward_name ?? '', 'sdec') !== false ? 'SDEC' : ucwords($title) --}}</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="overall_outpatient_{{ $ward_key }}">{{ $admission_discharge_value['discharge'] }}</td>
                                        </tr>
                                    @endforeach
                                    @if($success_array['row_def_admission_discharge'] > 0)
                                        @for ($i = 0; $i < $success_array['row_def_admission_discharge']; $i++)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        @endfor
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 ps-xxl-1">
            <div class="row mt-2 mt-xxl-0">
                <div class="col-lg-5 pe-lg-1">
                    <div class="ems-block">
                        <div class="row gx-2">
                            <div class="col-6">


                                @if($success_array['ane_opel_status']['status'] == 0)
                                    <div class="bg-ems bg-ems-primary">
                                        <span>ED</span>
                                        <div class="line"></div>
                                        <span>EMS</span>
                                    </div>
                                @else
                                    <div class="bg-ems bg-ems-{{ $success_array['ane_opel_status']['opel'] }}">
                                        <span>ED</span>
                                        <div class="line"></div>
                                        <span>EMS {{ $success_array['ane_opel_status']['opel'] }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                @if($success_array['ward_opel_status']['status'] == 0)
                                    <div class="bg-ems bg-ems-primary">
                                        <span>GEH</span>
                                        <div class="line"></div>
                                        <span>EMS {{ $success_array['ane_opel_status']['opel'] }}</span>
                                    </div>
                                @else
                                    <div class="bg-ems @if(in_array($success_array['ward_opel_status']['opel'], [1,2,3,4])) bg-ems-{{ $success_array['ward_opel_status']['opel'] }} @else bg-ems-internal-4 @endif">
                                        <span>GEH</span>
                                        <div class="line"></div>
                                        <span>EMS @if(in_array($success_array['ward_opel_status']['opel'], [1,2,3,4])) {{ $success_array['ward_opel_status']['opel'] }} @else Internal 04 @endif</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bed-count-wrapper">
                        <div class="title-wrapper">Bed</div>
                        <div class="rectangle-block-1">
                            <div class="card-countbox mb-2 click_open_all_bed cursor_pointer" data-type="all">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <span>Total</span>
                                    </div>
                                    <div class="col-6">
                                        <h6>{{ $success_array['bed']['total'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <div class="card-countbox click_open_all_bed cursor_pointer" data-type="empty">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <span>Empty</span>
                                            </div>
                                            <div class="col-6">
                                                <h6>{{ $success_array['bed']['available'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card-countbox click_open_all_bed cursor_pointer" data-type="occupied">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <span>Occupied</span>
                                            </div>
                                            <div class="col-6">
                                                <h6>{{ $success_array['bed']['occupied'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="card-countbox click_open_all_bed cursor_pointer"  data-type="escalation">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <span>Escalation</span>
                                            </div>
                                            <div class="col-6">
                                                <h6>{{ $success_array['bed']['escalation'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card-countbox click_open_all_bed cursor_pointer" data-type="restricted">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <span>Restricted</span>
                                            </div>
                                            <div class="col-6">
                                                <h6>{{ $success_array['bed']['restrict'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dp-wrapper">
                        <div class="title-wrapper">DISCHARGES</div>
                        <div class="rectangle-block-1">
                            <div class="row g-2">
                                <div class="col-6 click_open_all_bed cursor_pointer"  data-type="definite">
                                    <div class="card-countbox">
                                        <span>Definite</span>
                                        <h6>{{ $success_array['discharges']['total_definite'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-6 click_open_all_bed cursor_pointer" data-type="potential">
                                    <div class="card-countbox">
                                        <span>Potential</span>
                                        <h6>{{ $success_array['discharges']['total_poteintial'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="itu-wrapper">
                        <div class="title-wrapper">ITU LEVELS</div>
                        <div class="rectangle-block-1">
                            <div class="row g-2">
                                <div class="col-4  click_open_all_bed cursor_pointer"  data-type="itu_1">
                                    <div class="card-countbox">
                                        <span>Level 1</span>
                                        <h6>{{ $success_array['it_level']['level_1'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-4  click_open_all_bed cursor_pointer" data-type="itu_2">
                                    <div class="card-countbox">
                                        <span>Level 2</span>
                                        <h6>{{ $success_array['it_level']['level_2'] }}</h6>
                                    </div>
                                </div>
                                <div class="col-4  click_open_all_bed cursor_pointer" data-type="itu_3">
                                    <div class="card-countbox">
                                        <span>Level 3</span>
                                        <h6>{{ $success_array['it_level']['level_3'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pending-medfit-wrapper">
                        <div class="rectangle-block-1">
                            <div class="total-count-row">
                                <span>MEDICALLY FIT YES & CDT (INC PENDING)</span>
                                <span>{{ $success_array['medfit_cdt_patient'] }}</span>
                            </div>
                            <div class="details-count">
                                <div class="row g-2 mb-2">
                                    <div class="col-6 click_open_all_bed cursor_pointer" data-type="pathway_0">
                                        <div class="pending-countbox">
                                            <h6>P0</h6>
                                            <h6>{{ $success_array['medfit']['p0'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-6 click_open_all_bed cursor_pointer"  data-type="pathway_1">
                                        <div class="pending-countbox">
                                            <h6>P1</h6>
                                            <h6>{{ $success_array['medfit']['p1'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6 click_open_all_bed cursor_pointer" data-type="pathway_2">
                                        <div class="pending-countbox">
                                            <h6>P2</h6>
                                            <h6>{{ $success_array['medfit']['p2'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-6 click_open_all_bed cursor_pointer" data-type="pathway_3">
                                        <div class="pending-countbox">
                                            <h6>P3</h6>
                                            <h6>{{ $success_array['medfit']['p3'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="medically-fit-wrapper">
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <div class="medically-fit-box  click_open_medfit_patient" data-medfit="1" data-type="cdt_yes">
                                    <div class="cell-1">
                                        <span>Medically Fit</span>
                                        <div class="bg-medically-fit-yes">
                                            yes
                                        </div>
                                    </div>
                                    <div class="cell-2">
                                        <h6>{{ $success_array['medfit']['medfit_yes'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="medically-fit-box   click_open_medfit_patient" data-medfit="0" data-type="cdt_yes">
                                    <div class="cell-1">
                                        <span>Medically Fit</span>
                                        <div class="bg-medically-fit-no">
                                            NO
                                        </div>
                                    </div>
                                    <div class="cell-2">
                                        <h6>{{ $success_array['medfit']['medfit_no'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="therapy-fit-wrapper">
                        <div class="row g-2 mb-2">
                            <div class="col-6   click_open_therapy_patient" data-therapy="1" data-type="cdt_yes">
                                <div class="therapy-fit-box">
                                    <div class="cell-1">
                                        <span>Therapy Fit</span>
                                        <div class="bg-therapy-fit-yes">
                                            yes
                                        </div>
                                    </div>
                                    <div class="cell-2">
                                        <h6>{{ $success_array['therapy']['therapy_yes'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="therapy-fit-box  click_open_therapy_patient" data-therapy="0" data-type="cdt_yes" >
                                    <div class="cell-1">
                                        <span>Therapy Fit</span>
                                        <div class="bg-therapy-fit-no">
                                            NO
                                        </div>
                                    </div>
                                    <div class="cell-2">
                                        <h6>{{ $success_array['therapy']['therapy_no'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 ps-lg-1">
                    <div class="rtl-table rtl-los-table">
                        <div class="header-table">LOS</div>
                        <div class="rectangle-block-1">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <div class="row">
                                        <div class="los-details" style="overflow-x:auto;">
                                            <table class="table-overview">
                                                <thead>
                                                    <tr class="position-relative">
                                                        <th></th>
                                                        <th class="text-center">Medical</th>
                                                        <th class="text-center">Surgical</th>
                                                        <th class="text-center">Overall</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="bg-white">
                                                        <td class="">0 to 6 days</td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer"  data-type="los_0_6_medical">{{ $success_array['patient_los']['medical']['los_0_to_6'] }} </td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_0_6_surgical">{{ $success_array['patient_los']['surgical']['los_0_to_6'] }} </td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_0_6_all">{{ $success_array['patient_los']['overall']['los_0_to_6'] }} </td>
                                                    </tr>
                                                    <tr class="bg-grey">
                                                        <td class="">7 to 13 days</td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_7_13_medical">{{ $success_array['patient_los']['medical']['los_7_to_13'] }} </td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_7_13_surgical">{{ $success_array['patient_los']['surgical']['los_7_to_13'] }} </td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_7_13_all">{{ $success_array['patient_los']['overall']['los_7_to_13'] }} </td>
                                                    </tr>
                                                    <tr class="bg-white">
                                                        <td class="">14 to 20 days</td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_14_20_medical">{{ $success_array['patient_los']['medical']['los_14_to_20'] }}  </td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_14_20_surgical">{{ $success_array['patient_los']['surgical']['los_14_to_20'] }} </td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_14_20_all">{{ $success_array['patient_los']['overall']['los_14_to_20'] }} </td>
                                                    </tr>
                                                    <tr class="bg-grey">
                                                        <td class="">21+ days</td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer"  data-type="los_21_plus_medical">{{ $success_array['patient_los']['medical']['los_21_more'] }} </td>
                                                        <td class="text-center   click_open_all_bed cursor_pointer" data-type="los_21_plus_surgical">{{ $success_array['patient_los']['surgical']['los_21_more'] }} </td>
                                                        <td class="text-center  click_open_all_bed cursor_pointer" data-type="los_21_plus_all">{{ $success_array['patient_los']['overall']['los_21_more'] }} </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rtl-table">
                        <div class="header-table">BOARD ROUND</div>
                        <div class="rectangle-block-1">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <div class="row">
                                        <div class="boardround-details" style="overflow-x:auto;">
                                            <table class="table-overview">
                                                <thead>
                                                    <tr class="position-relative">
                                                        <th></th>
                                                        <th class="text-center">
                                                            Medical
                                                        </th>
                                                        <th class="text-center">
                                                            Surgical
                                                        </th>
                                                        <th class="text-center">
                                                            Overall
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="bg-white">
                                                        <td class="">
                                                            Completed
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('medical', 1);">
                                                            {{ $success_array['boardround']['medical']['ward_complete_board_round'] }}
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('surgical', 1);">
                                                            {{ $success_array['boardround']['surgical']['ward_complete_board_round'] }}
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('all', 1);">
                                                            {{ $success_array['boardround']['overall']['ward_complete_board_round'] }}
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-grey">
                                                        <td class="">
                                                            Partial
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('medical', 2);">
                                                            {{ $success_array['boardround']['medical']['ward_partial_complete_board_round'] }}
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('surgical', 2);">
                                                            {{ $success_array['boardround']['surgical']['ward_partial_complete_board_round'] }}
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('all', 2);">
                                                            {{ $success_array['boardround']['overall']['ward_partial_complete_board_round'] }}
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-white">
                                                        <td class="">
                                                            Not Started
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('medical', 0);">
                                                            {{ $success_array['boardround']['medical']['ward_not_complete_board_round'] }}
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('surgical', 0);">
                                                            {{ $success_array['boardround']['surgical']['ward_not_complete_board_round'] }}
                                                        </td>
                                                        <td class="text-center cursor_pointer" onclick="GetBoardRoundReport('all', 0);">
                                                            {{ $success_array['boardround']['overall']['ward_not_complete_board_round'] }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="emergency-admission-wrapper">
                        <div class="rectangle-block-1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between rectangle-block-2">
                                        <h6 class="mb-0">EMERGENCY ADMISSIONS &amp; DISCHARGES BY TIME
                                            OF DAY</h6>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <table class="table-admission">
                                    <thead>
                                        <tr>
                                            <th></th>

                                            <th>Medical</th>
                                            <th>Surgical</th>
                                            <th>Overall</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-row-1">
                                            <td colspan="4">00:00 to 11:59</td>
                                        </tr>
                                        <tr>
                                            <td>Admissions</td>

                                            <td class="click_open_all_bed cursor_pointer"  data-type="admit_00_11_medical">{{ $success_array['admit_discharge_by_hour']['medical']['00_11']['admission'] }}</td>
                                            <td class="click_open_all_bed cursor_pointer" data-type="admit_00_11_surgical">{{ $success_array['admit_discharge_by_hour']['surgical']['00_11']['admission'] }}</td>
                                            <td class="click_open_all_bed cursor_pointer" data-type="admit_00_11_all">{{ ($success_array['admit_discharge_by_hour']['medical']['00_11']['admission']+$success_array['admit_discharge_by_hour']['surgical']['00_11']['admission']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discharges</td>

                                            <td class="click_open_discharge_bed cursor_pointer"  data-type="discharge_00_11_medical">{{ $success_array['admit_discharge_by_hour']['medical']['00_11']['discharge'] }}</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_00_11_surgical">{{ $success_array['admit_discharge_by_hour']['surgical']['00_11']['discharge'] }}</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_00_11_all">{{ ($success_array['admit_discharge_by_hour']['medical']['00_11']['discharge']+$success_array['admit_discharge_by_hour']['surgical']['00_11']['discharge']) }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr class="bg-row-2">
                                            <td colspan="4">12:00 to 15:59</td>
                                        </tr>
                                        <tr>
                                            <td>Admissions</td>
                                            <td class="click_open_all_bed cursor_pointer" data-type="admit_12_15_medical">{{ $success_array['admit_discharge_by_hour']['medical']['12_15']['admission'] }}</td>
                                            <td class="click_open_all_bed cursor_pointer" data-type="admit_12_15_surgical">{{ $success_array['admit_discharge_by_hour']['surgical']['12_15']['admission'] }}</td>
                                            <td class="click_open_all_bed cursor_pointer" data-type="admit_12_15_all">{{ ($success_array['admit_discharge_by_hour']['medical']['12_15']['admission']+$success_array['admit_discharge_by_hour']['surgical']['12_15']['admission']) }}</td>

                                        </tr>
                                        <tr>
                                            <td>Discharges</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_12_15_medical">{{ $success_array['admit_discharge_by_hour']['medical']['12_15']['discharge'] }}</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_12_15_surgical">{{ $success_array['admit_discharge_by_hour']['surgical']['12_15']['discharge'] }} </td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_12_15_all">{{ ($success_array['admit_discharge_by_hour']['medical']['12_15']['discharge']+$success_array['admit_discharge_by_hour']['surgical']['12_15']['discharge']) }}</td>

                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr class="bg-row-3">
                                            <td colspan="4">16:00 to 23:59</td>
                                        </tr>
                                        <tr>
                                            <td>Admissions</td>
                                            <td class="click_open_all_bed cursor_pointer" data-type="admit_16_23_medical">{{ $success_array['admit_discharge_by_hour']['medical']['16_24']['admission'] }}</td>
                                            <td class="click_open_all_bed cursor_pointer" data-type="admit_16_23_surgical">{{ $success_array['admit_discharge_by_hour']['surgical']['16_24']['admission'] }}</td>
                                            <td class="click_open_all_bed cursor_pointer"  data-type="admit_16_23_all">{{ ($success_array['admit_discharge_by_hour']['medical']['16_24']['admission']+$success_array['admit_discharge_by_hour']['surgical']['16_24']['admission']) }}</td>

                                        </tr>
                                        <tr>
                                            <td>Discharges</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_16_23_medical">{{ $success_array['admit_discharge_by_hour']['medical']['16_24']['discharge'] }}</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_16_23_surgical">{{ $success_array['admit_discharge_by_hour']['surgical']['16_24']['discharge'] }}</td>
                                            <td class="click_open_discharge_bed cursor_pointer" data-type="discharge_16_23_all">{{ ($success_array['admit_discharge_by_hour']['medical']['16_24']['discharge']+$success_array['admit_discharge_by_hour']['surgical']['16_24']['discharge']) }}</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>











            </div>
        </div>
    </div>
</div>




