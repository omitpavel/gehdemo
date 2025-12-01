<div class="isolation-reason-symbol">

    @php
        $flag_list_show_array = PatientWiseFlagsUrlForWardSummaryGetAllFlags(
            $patient['patient_wise_flags'],
            $show_on_ward_summary_status_check,
            12,
        );
    @endphp
    @if (count($flag_list_show_array) > 0)

        @foreach ($flag_list_show_array as $key => $flag)
            {!! GetWardSummaryBedFlagImagesIPC($flag) !!}
        @endforeach

    @endif
</div>

<div class="primary-reason">
    @if (!empty($patient['primary_infection']))
        <span class="sub-title">Primary:</span>
        <span>{{ $patient['primary_infection'] }} @if(isset($patient['primary_next_review_date']) && !empty($patient['primary_next_review_date']))(Next Review :
            {{ $patient['primary_next_review_date'] ?? '' }})@endif</span>
    @endif
</div>


<div class="secondary-reason">
    @if (!empty($patient['others_infection']))
        <span class="sub-title">Secondary:</span>
        <span>{{ $patient['others_infection'] }}</span>
    @endif
</div>

<div class="comment-block click_open_comment_box cursor_pointer"  data-patient-id="{{ $patient['camis_patient_id'] }}" data-patient-flag-stored-name="ibox_patient_flag_infection_risk"  data-patient-flag-show-name="Infection Risk">
    <span class="sub-title">Comment:</span>
    <textarea class="form-control camis_ipc_patient_comment_{{ $patient['camis_patient_id'] }} op-4" readonly>{{ $patient['camis_patient_ipc_comment'] ?? '' }}</textarea>
</div>
