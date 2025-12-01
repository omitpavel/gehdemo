
<th  class="th_scub_bed_{{ $patient['scub_ward_id'] }} @if(isset($patient['camis_patient_id']) && !empty($patient['camis_patient_id'])) cursor_pointer click_open_infection_offcanvas reverse_barrier_bed_name_class_{{ $patient['camis_patient_id'] }} @if($patient['reverse_barrier_status'] == 1) bg-reverse-barrier is_reverse_barrier @endif @if($patient['is_infected_bg'] == 1) is_infected @endif" data-patient-id="{{ $patient['camis_patient_id'] }}" @endif data-patient-flag-stored-name="ibox_patient_flag_infection_risk"  data-patient-flag-show-name="Infection Risk">
    <div class="spl-th">
        <div>{{ $patient['ibox_actual_bed_full_name'] }}</div>
        @if(isset($patient['camis_patient_id']) && !empty($patient['camis_patient_id']))
            <i class="bi bi-hand-index-thumb"></i>
        @endif
    </div>

</th>

