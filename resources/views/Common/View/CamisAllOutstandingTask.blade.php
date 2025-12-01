<thead>
<tr class="position-relative">
    <th>Task</th>
    <th></th>
</tr>
</thead>
<tbody id="all_task_body">
@if(count($task_list) > 0)
    @foreach ($task_list as $task)
        <tr class="rm_task_{{ $task['id'] }}">
            <td class="pivoted edit_task_{{ $task['id'] }}">
                <div class="tdBefore"></div>
                <span class="updated_task_{{ $task['id'] }}" style="font-weight: normal !important;">
                @if ($task['task_priority'] == 1)
                    !
                @endif
                @if ($task['task_category'] != 0)
                    #{{ @$task['patient_task_category']['task_category_name'] }} -

                @endif @if ($task['task_category'] == 6)
                    {{ $task['task_dp_status_order_value'] }}
                @endif {{ $task['task_description'] }} -
                {{ PredefinedDateFormatFor24Hour($task['task_estimated_date_for_completion']) }} -
                {{ @$task['patient_task_group']['task_group_name'] }}
                </span>
            </td>


                    <td class="pivoted">
                        <div class="tdBefore"></div>
                        @if($edit_category != 9)
                            @if($task['task_category'] != 0 && $task['task_category'] == $edit_category)
                            <div class="d-flex justify-content-end  {{ PermissionDeniedDiv($permision) }}">
                                <button class="btn btn-edit me-1 {{ DisabledButtonOnRolePermission($permision) }}" @if(PermitedStatus($permision)) onclick="PatientTaskEdit({{ $task['id'] }},this);" @endif>Edit</button>
                                <button class="btn btn-confirm me-1 {{ DisabledButtonOnRolePermission($permision) }}" patient-task-id="{{ $task['id'] }}" patient-id="{{ $task['patient_id'] }}" id="ibox_boardround_task_complete">Confirm</button>
                                <button class="btn btn-orange me-1 {{ DisabledButtonOnRolePermission($permision) }} notapplicable task_not_applicable ibox_buttons ibox_boardround_task_delete" patient-task-id="{{ $task['id'] }}" patient-id="{{ $task['patient_id'] }}">N/A</button>
                            </div>
                            @endif
                        @endif
                    </td>


        </tr>

    @endforeach
@else


    <tr class="no-records-row">
        <td class="pivoted no-records-cell" colspan="2">
            <div class="tdBefore"></div>
            {{ NotFoundMessage() }}
        </td>
    </tr>

@endif



</tbody>
