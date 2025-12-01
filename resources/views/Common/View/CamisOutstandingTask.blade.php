<link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/OutstandingTask.css') }}">

@if (count($task_list) > 0)
    @foreach ($task_list as $task)
        <div class="row gx-1 align-items-center">
            <div class="col-comment edit_task_{{ $task['id'] }}">
                <span class="">
                    @if ($task['task_priority'] == 1)
                        !
                        @endif
                            @if ($task['task_category'] != 0)
                            #{{ @$task['patient_task_category']['task_category_name'] }} -
                            @endif

                            @if ($task['task_category'] == 6)
                                {{ $task['task_dp_status_order_value'] }}
                            @endif {{ $task['task_description'] }} @if ($task['task_daily'] != 0)
                                - Daily
                            @endif  -
                            {{ PredefinedDateFormatFor24Hour($task['task_estimated_date_for_completion']) }} -
                            {{ @$task['patient_task_group']['task_group_name'] }}
                </span>
            </div>
            @if ($edit_category != 9)
                @if ($task['task_category'] != 0 && $task['task_category'] == $edit_category)
                    <div class="col-icons  {{ PermissionDeniedDiv($permision) }}">
                        <span class="{{ DisabledButtonOnRolePermission($permision) }} cursor_pointer"  data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Edit"
                            @if (PermitedStatus($permision)) onclick="PatientTaskEdit({{ $task['id'] }},this);" style="cursor: pointer" @endif><i
                                class="bi bi-pencil-square "></i></span>
                        <span class="{{ DisabledButtonOnRolePermission($permision) }} cursor_pointer"  data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Complete"
                            @if (PermitedStatus($permision)) patient-task-id="{{ $task['id'] }}" patient-id="{{ $task['patient_id'] }}"
                            style="cursor: pointer" id="ibox_boardround_task_complete" @endif ><i class="bi bi-check-circle"></i></span>
                        <span
                            class="{{ DisabledButtonOnRolePermission($permision) }} notapplicable task_not_applicable ibox_buttons ibox_boardround_task_delete cursor_pointer"  data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Not Applicable"
                            @if (PermitedStatus($permision))  patient-task-id="{{ $task['id'] }}" patient-id="{{ $task['patient_id'] }}" style="cursor: pointer;" @endif><i
                                class="bi bi-trash3"></i></span>
                    </div>
                @endif
            @endif

        </div>
    @endforeach
@else
    <div class="row gx-1 align-items-center" style="height: 100%; background-color: #ffffff;">
        <div class="text-center">
            <div class="d-inline-block align-middle">
                {{ NotFoundMessage() }}
            </div>
        </div>
    </div>
@endif
