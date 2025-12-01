



@if (count($task_list) > 0)

        <table class="responsiveTable table-tasks">
        <thead>
            <tr class="position-relative">
            <th>Tasks</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($task_list as $task)
                <tr class="rm_task_{{ $task['id'] }}">
                    <td class="pivoted edit_task_{{ $task['id'] }}">
                        <div class="tdBefore"></div> <span  style="font-weight: normal !important;" class="updated_task_{{ $task['id'] }}">@if ($task['task_priority'] == 1)
                        !
                        @endif
                            @if ($task['task_category'] != 0)
                            #{{ @$task['patient_task_category']['task_category_name'] }} @if ($task['task_category'] == 6)
                                {{ $task['task_dp_status_order_value'] }}
                            @endif -
                            @endif

                            {{ $task['task_description'] }} @if ($task['task_daily'] != 0)
                                - Daily
                            @endif  -
                            {{ PredefinedDateFormatFor24Hour($task['task_estimated_date_for_completion']) }} -
                            {{ @$task['patient_task_group']['task_group_name'] }}</span>
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore"></div>
                        <div class="d-flex justify-content-end">
                            @if(isset($task['patient_task_group']['task_group_name']) && strtolower($task['patient_task_group']['task_group_name']) == 'pharmacy')
                            <button class="btn btn-edit me-1 {{ DisabledButtonOnRolePermission('pharmacy_dashboard_task_filter_view') }}" @if(PermitedStatus('pharmacy_dashboard_task_filter_view')) onclick="PatientTaskEdit({{ $task['id'] }},this);" @endif>Edit</button>
                            <button class="btn btn-confirm me-1 {{ DisabledButtonOnRolePermission('pharmacy_dashboard_task_filter_view') }}" patient-task-id="{{ $task['id'] }}" patient-id="{{ $task['patient_id'] }}" id="ibox_boardround_task_complete">Confirm</button>
                            <button class="btn btn-orange me-1 {{ DisabledButtonOnRolePermission('pharmacy_dashboard_task_filter_view') }} notapplicable task_not_applicable ibox_buttons ibox_boardround_task_delete" patient-task-id="{{ $task['id'] }}" patient-id="{{ $task['patient_id'] }}">N/A</button>

                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>

        @else
        <div class="No_record_css">{{NotFoundMessage()}}</div>
        </div>
    @endif
