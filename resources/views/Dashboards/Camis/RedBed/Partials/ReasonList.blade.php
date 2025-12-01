
<div class="header-comment">
    <p class="flex-grow-1">Red Reasons</p>
    @if(isset($patient['red_green_bed']['updated_at']))
        <p class="red-reason-time">{{ PredefinedDateFormatFor24Hour($patient['red_green_bed']['updated_at']) }}</p>
    @endif
</div>
@php

    $reason_list = json_decode($patient['red_green_bed']['patient_red_green_status_reason_code'], true);
    uasort($reason_list, function ($a, $b) {
        if (!isset($a['created_time'])) return -1;
        if (!isset($b['created_time'])) return 1;

        $timeA = strtotime($a['created_time']);
        $timeB = strtotime($b['created_time']);

        return $timeA <=> $timeB;
    });
    $pending_task = ArrayFilter($reason_list, function($value) {
        return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0));
    });

    $complete = ArrayFilter($reason_list, function($value) {
        return ((!isset($value['is_complete']) && $value == 1) || (isset($value['is_complete']) && $value['is_complete'] == 1));
    });

@endphp
<div class="card-col-grp">
    @foreach($pending_task as $reason => $reason_data)
        <div class="row gx-1 align-items-center">
            <div class="col-comment">
                <span class="">{{ $success_array['red_bed_reason_list'][$reason] ?? '--' }}
                    @if(isset($reason_data['created_time']) && !empty($reason_data['created_time']))
                        <span class="red-reason-created-time">Created At {{ PredefinedDateFormatFor24Hour($reason_data['created_time']) }}  ({{ TimeDefferInFormat($reason_data['created_time'], CurrentDateOnFormat()) }})</span>
                    @elseif(isset($patient['red_green_bed']['updated_at']))
                        <span class="red-reason-created-time">Created At {{ PredefinedDateFormatFor24Hour($patient['red_green_bed']['updated_at']) }}   ({{ TimeDefferInFormat($patient['red_green_bed']['updated_at'], CurrentDateOnFormat()) }}) </span>
                    @endif
                    @if(isset($reason_data['completed_time']) && !empty($reason_data['completed_time']))
                        <span class="red-reason-completed-time">Completed At {{ PredefinedDateFormatFor24Hour($reason_data['completed_time']) }} @if(isset($reason_data['created_time'])) ({{ TimeDefferInFormat($reason_data['created_time'], $reason_data['completed_time']) }}) @elseif(isset($patient['red_green_bed']['updated_at'])) ({{ TimeDefferInFormat($patient['red_green_bed']['updated_at'], $reason_data['completed_time']) }}) @endif</span>
                    @elseif(!isset($reason_data['completed_time']) && $reason_data == 1 && isset($patient['red_green_bed']['updated_at']))
                        <span class="red-reason-completed-time">Completed At {{ PredefinedDateFormatFor24Hour($patient['red_green_bed']['updated_at']) }} @if(isset($reason_data['completed_time'])) ({{ TimeDefferInFormat($patient['red_green_bed']['updated_at'], $reason_data['completed_time']) }}) @elseif(isset($patient['red_green_bed']['updated_at'])) ({{ TimeDefferInFormat($patient['red_green_bed']['created'], $patient['red_green_bed']['updated_at']) }}) @endif</span>
                    @endif
                </span>
            </div>
            <div class="col-icons red_bed_tooltip @if($reason_data == 0 || (isset($reason_data['is_complete']) && $reason_data['is_complete'] == 0)) approve_red_task @else active @endif  {{ PermissionDeniedDiv('flow_dashboard_red_bed_approve_update') }}" @if($reason_data == 1 || (isset($reason_data['is_complete']) && $reason_data['is_complete'] == 1))  data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="Reason Already Completed" @else  data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="Click Here To Complete The Task" @endif data-reason-id="{{ $reason }}" data-patient-id="{{ $patient['camis_patient_id'] }}" data-ward-id="{{ str_replace(' ', '_', $ward) }}">
                <i
                    class="bi bi-check-circle {{ DisabledButtonOnRolePermission('flow_dashboard_red_bed_approve_update') }}"></i>
            </div>
        </div>
    @endforeach
    @foreach($complete as $reason => $reason_data)
        <div class="row gx-1 align-items-center">
            <div class="col-comment">
                <span class="">{{ $success_array['red_bed_reason_list'][$reason] ?? '--' }}
                    @if(isset($reason_data['created_time']) && !empty($reason_data['created_time']))
                        <span class="red-reason-created-time">Created At {{ PredefinedDateFormatFor24Hour($reason_data['created_time']) }}</span>
                    @elseif(isset($patient['red_green_bed']['updated_at']))
                        <span class="red-reason-created-time">Created At {{ PredefinedDateFormatFor24Hour($patient['red_green_bed']['updated_at']) }} </span>
                    @endif
                    @if(isset($reason_data['completed_time']) && !empty($reason_data['completed_time']))
                        <span class="red-reason-completed-time">Completed At {{ PredefinedDateFormatFor24Hour($reason_data['completed_time']) }} @if(isset($reason_data['created_time'])) ({{ TimeDefferInFormat($reason_data['created_time'], $reason_data['completed_time']) }}) @elseif(isset($patient['red_green_bed']['updated_at'])) ({{ TimeDefferInFormat($patient['red_green_bed']['updated_at'], $reason_data['completed_time']) }}) @endif</span>
                    @elseif(!isset($reason_data['completed_time']) && $reason_data == 1 && isset($patient['red_green_bed']['updated_at']))
                        <span class="red-reason-completed-time">Completed At {{ PredefinedDateFormatFor24Hour($patient['red_green_bed']['updated_at']) }} @if(isset($reason_data['completed_time'])) ({{ TimeDefferInFormat($patient['red_green_bed']['updated_at'], $reason_data['completed_time']) }}) @elseif(isset($patient['red_green_bed']['updated_at'])) ({{ TimeDefferInFormat($patient['red_green_bed']['created'], $patient['red_green_bed']['updated_at']) }}) @endif</span>
                    @endif
                </span>
            </div>
            <div class="col-icons red_bed_tooltip @if($reason_data == 0 || (isset($reason_data['is_complete']) && $reason_data['is_complete'] == 0)) approve_red_task @else active @endif  {{ PermissionDeniedDiv('flow_dashboard_red_bed_approve_update') }}" @if($reason_data == 1 || (isset($reason_data['is_complete']) && $reason_data['is_complete'] == 1))  data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="Reason Already Completed" @else  data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="Click Here To Complete The Task" @endif data-reason-id="{{ $reason }}" data-patient-id="{{ $patient['camis_patient_id'] }}" data-ward-id="{{ str_replace(' ', '_', $ward) }}">
                <i
                    class="bi bi-check-circle {{ DisabledButtonOnRolePermission('flow_dashboard_red_bed_approve_update') }}"></i>
            </div>
        </div>
    @endforeach
</div>
