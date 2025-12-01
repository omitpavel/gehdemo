@if ($patient['camis_patient_id'] != '')
    <div class="sm-sideroom-wrapper @if (isset($patient['camis_patient_id']) && !empty($patient['camis_patient_id'])) cursor_pointer click_open_infection_offcanvas reverse_barrier_bed_name_class_{{ $patient['camis_patient_id'] }} @if ($patient['reverse_barrier_status'] == 1) bg-reverse-barrier is_reverse_barrier @endif @if ($patient['is_infected_bg'] == 1) is_infected @endif"
        data-patient-id="{{ $patient['camis_patient_id'] }}" @endif
        data-patient-flag-stored-name="ibox_patient_flag_infection_risk" data-patient-flag-show-name="Infection Risk">
        <div class="spl-th">
            <div class="tdBefore">{{ $patient['ibox_actual_bed_full_name'] }} </div>
            <i class="bi bi-hand-index-thumb"></i>
        </div>
    </div>
    <div class="ipc-patient-details">

        <div>
            <div class="patient-gender">
                @if (strtolower($patient['camis_patient_sex']) == 'male')
                    <img src="{{ asset('asset_v2/Template/icons/gender-male.svg') }}" alt=""
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Male">
                @elseif(strtolower($patient['camis_patient_sex']) == 'female')
                    <img src="{{ asset('asset_v2/Template/icons/gender-female.svg') }}" alt=""
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Female">
                @endif


            </div>
            <span class="name-span">{{ $patient['camis_patient_name'] }}</span>
        </div>
        <div>
            <span class="sub-title">Hospital Number:</span>
            <span>{{ $patient['camis_patient_pas_number'] }}</span>
        </div>
        <div>
            <span class="sub-title">Con:</span>
            <span>{{ $patient['camis_consultant_name'] }}</span>
        </div>
        <div>
            <span class="sub-title">LOS:</span>
            <span>{{ $patient['los'] }}</span>
        </div>
        <div>
            <span class="sub-title">Admission:</span>
            <span>{{ $patient['camis_patient_admission_date_time'] }}</span>
        </div>
    </div>
    <div class="infection-details">
        <div class="isolation-reason-symbol">
            <div class="alert  bg-green infectied_div_green_{{ $patient['camis_patient_id'] }} @if($patient['is_infected'] != 0) d-none @endif" role="alert">Can be moved
            </div>
            <div class="alert  bg-red infectied_div_red_{{ $patient['camis_patient_id'] }} @if($patient['is_infected'] != 1) d-none @endif" role="alert">Not to be moved
            </div>
        </div>
        <div class="reverse-barrier-section ">
            <div class="alert  bg-red reverse_barrier_bed_list_class_{{ $patient['camis_patient_id'] }} @if ($patient['reverse_barrier_status'] != 1) d-none @endif"
                role="alert">Reverse Barrier
            </div>
        </div>
        @if (isset($patient['camis_patient_ward']) && $patient['camis_patient_ward'] == 'SCUB')
            <div class="update-details-section click_update_scub_ward"
                data-scub_ward_id="{{ $patient['scub_ward_id'] }}">
                <button class="btn btn-update-details ">Update Details</button>
            </div>
        @endif
        <div class="patient_infection_icon_{{ $patient['camis_patient_id'] }}">
            @include('Dashboards.Camis.InfectionControl.Partials.IPCPatientInfectionIcon')
        </div>
    </div>
@else
    <div class="sm-sideroom-wrapper">
        <div class="tdBefore">{{ $patient['ibox_actual_bed_full_name'] }}</div>
    </div>
    <div class="ipc-empty-bed">
        @if (isset($patient['camis_patient_ward']) && $patient['camis_patient_ward'] == 'SCUB')
            <div class="add-btn-wrap click_update_scub_ward" data-scub_ward_id="{{ $patient['scub_ward_id'] }}">
                <button class="btn btn-primary-grey">Add Patient</button>
            </div>


        @endif


        @if (isset($patient['ibox_bed_status']['status']))
            @if ($patient['ibox_bed_status']['status'] == 0)
                <h6>Bed Open</h6>
                <h6 class="mb-0">Empty</h6>
            @elseif($patient['ibox_bed_status']['status'] == 1)
                <h6>Bed Closed</h6>
            @elseif($patient['ibox_bed_status']['status'] == 2)
                <h6>Bed Restricted</h6>
            @elseif($patient['ibox_bed_status']['status'] == 3)
                <h6>Bed Out Of Service</h6>
            @elseif($patient['ibox_bed_status']['status'] == 4)
                <h6>Bed Reserved</h6>
                @if (!empty($patient['ibox_bed_status']['reserved_for']))
                    <h6 class="mb-0">For {{ $patient['ibox_bed_status']['reserved_for'] }}</h6>
                    <h6 class="mb-0">({{ $patient['ibox_bed_status']['patient_name'] }})</h6>
                @endif
            @endif
        @else
            @if ($patient['ibox_bed_status_camis'] == 'open')
                <h6>Bed Open</h6>
                <h6 class="mb-0">Empty</h6>
            @else
                <h6>Bed Closed</h6>
                <h6 class="mb-0">{{ ucfirst(strtolower($patient['ibox_bed_status_camis'])) }}</h6>
            @endif

        @endif

    </div>
@endif
