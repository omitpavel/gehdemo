<div class="col-lg-6">
    <div class="row gx-2 priority-group">
        <div class="col-lg-4 col-md-4 col-6 mb-1">
            <button class="btn btn-allebone w-100 task_priority ibox_board_round_patient_task_assign_priority_open"  data-title="Task Priority" ><img
                    src="{{ asset('asset_v2/Template') }}/icons/exclamation-mark.svg" alt="" class="btn-icon"
                    width="15" height="15">
                <span class="text-button">Priority</span>
            </button>

        </div>
        <div class="col-lg-4 col-md-4 col-6 mb-1">
            <button class="btn btn-allebone w-100 ibox_board_round_patient_task_assign_daily_open"  data-title="Task Daily"><img src="{{ asset('asset_v2/Template') }}/icons/clock.svg"
                                                                                                                                 alt="" class="btn-icon" width="15">
                Daily</button>
        </div>
        <div class="col-lg-4 col-md-4 mb-1 {{ PermissionDeniedDiv('camis_task_management_add') }}">
            <button
                class="btn btn-allebone  w-100 click_open_board_round_patient_task_assign  {{ DisabledButtonOnRolePermission('camis_task_management_add') }}"><img
                    src="{{ asset('asset_v2/Template') }}/icons/list.svg" alt="" class="btn-icon" width="14"> <span class="text-button">Assign Task</span></button>
        </div>
    </div>
    <div class="row gx-2">
        <div class="col-lg-3 col-md-3 col-3 mb-1 {{ PermissionDeniedDiv('camis_task_management_add') }}">
            <div  data-task-group='Doctor' class="square-btn cyan-border  ibox_board_round_patient_task_assign_group_common_open ibox_board_round_patient_task_assign_doctor_open cursor_pointer {{ DisabledButtonOnRolePermission('camis_task_management_add') }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Assign Task To Doctor">
                <span>Dr</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-3 mb-1 {{ PermissionDeniedDiv('camis_task_management_add') }}">
            <div data-task-group='Nurse' class="{{ DisabledButtonOnRolePermission('camis_task_management_add') }} nurse square-btn maroon-border title-tip ibox_board_round_patient_task_assign_group_common_open ibox_board_round_patient_task_assign_nurse_open cursor_pointer"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Assign Task To Nurse">
                <span>Rn</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-3 mb-1 {{ PermissionDeniedDiv('camis_task_management_add') }}">
            <div data-task-group='Therapies' class="{{ DisabledButtonOnRolePermission('camis_task_management_add') }} therapies square-btn green-border ibox_board_round_patient_task_assign_group_common_open ibox_board_round_patient_task_assign_therapies_open cursor_pointer"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Assign Task To Therapies">
                <span>Th</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-3 mb-1 {{ PermissionDeniedDiv('camis_task_management_add') }}">
            <div data-task-group='Pharmacy' class="{{ DisabledButtonOnRolePermission('camis_task_management_add') }} pharmacy square-btn cyan-border  title-tip ibox_board_round_patient_task_assign_group_common_open ibox_board_round_patient_task_assign_pharmacy_open cursor_pointer"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Assign Task To Pharmacy" >
                <span>Ph</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-assign-task mb-1">
            <div class="bg-task">
                <label class="form-label mb-0">Task to be Completed</label>
            </div>
            <div class="card-task">
                <div class="list-group">
                    @if (count($success_array['task_to_be_completed']) > 0)
                        @foreach ($success_array['task_to_be_completed'] as $row)
                            <li data-patient-task-id="{{ $row['id'] }}" class="list-group-item list-group-item-action cursor_pointer  @if(isset($row['patient_task_show_string_class']) && !empty($row['patient_task_show_string_class'])) {{ ltrim($row['patient_task_show_string_class'], '#') }}_task  @else {{ $loop->index % 2 === 0 ? '' : 'bg-silver' }} @endif ibox_boardround_popup_patient_task_to_be_completed_show_list ibox_boardround_popup_patient_task_show">
                                @if ($row['task_priority'] == 1) ! @endif {{ $row['patient_task_show_string'] }}
                            </li>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="btn-grp">
                <div class="row gx-1 p-1">
                    <div class="col-lg-3 col-md-3 col-6 mb-1 mb-md-0 {{ PermissionDeniedDiv('camis_task_management_update') }}">
                        <button class="btn bg-dark ibox_boardround_popup_patient_task_edit {{ DisabledButtonOnRolePermission('camis_task_management_update') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Task"><img src="{{ asset('asset_v2/Template') }}/icons/edit.svg" alt=""
                                                                                                                                                                                                                                            width="13" class="me-2" >Edit
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 mb-1 mb-md-0 {{ PermissionDeniedDiv('camis_task_management_update') }}">
                        <button class="btn bg-primary ibox_boardround_popup_patient_task_complete {{ DisabledButtonOnRolePermission('camis_task_management_update') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mark Task As Complete"><img src="{{ asset('asset_v2/Template') }}/icons/tick-white.svg"
                                                                                                                                                                                                                                                               alt="" width="13" class="me-2"  >Complete
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 {{ PermissionDeniedDiv('camis_task_management_delete') }}">
                        <button class="btn bg-gradient-red notapplicable task_not_applicable ibox_boardround_popup_patient_task_delete {{ DisabledButtonOnRolePermission('camis_task_management_delete') }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mark Task As Not Applicable">N/A</button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 {{ PermissionDeniedDiv('camis_task_management_print') }}">
                        <button class="btn  bg-dark print_patient_task_list {{ DisabledButtonOnRolePermission('camis_task_management_print') }}" ><img src="{{ asset('asset_v2/Template') }}/icons/print-white.svg"
                                                                                                                                                                  alt="" class="me-2" width="13">Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 task-row-align">
    <div class="bg-task">
        <label class="form-label mb-0">Completed Task</label>
    </div>
    <div class="card-task mb-1">
        <div class="list-group">


            @if (count($success_array['task_completed']) > 0)
                @foreach ($success_array['task_completed'] as $row)
                    <li class="list-group-item list-group-item-action ibox_boardround_popup_patient_task_completed_show_list cursor_pointer task_comment_id {{ $loop->index % 2 === 0 ? '' : 'bg-silver' }}"  data-task-id="{{ $row['id'] }}">
                        {{ isset($row['patient_task_show_string']) ? $row['patient_task_show_string'] : $row['task_description'] }} <div class="comment-icon task_comment_id" data-task-id="{{ $row['id'] }}">
                        </div>
                    </li>
                @endforeach
            @endif


        </div>
    </div>
</div>



<div id="patient_task_title" style="display: none">Patient Task {{ isset($success_array['patient_details'])  ? $success_array['patient_details']['each_patient'] : '' }}</div>
<div id="printTask" style="display: none">

    <div class="card-table-listing allowed_to_move_out_details_insert" >
        <table class="breachReasonTable responsiveTable table-listing">
            <thead>
                <tr class="position-relative">
                    <th>No</th>

                    <th>Task</th>

                    <th>Priority</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Group</th>
                </tr>
            </thead>
            <tbody>
                @foreach($success_array['task_to_be_completed'] as $row)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">No</div>
                            {{ $loop->iteration }}
                        </td>

                        <td class="pivoted">
                            <div class="tdBefore">Task</div>
                            @if ($row['task_priority'] == 1)
                                <span class='patient_task_show_important'>!</span>
                            @endif
                            {{ $row['patient_task_show_string'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Priority</div>
                            {{ $row['task_priority'] == 1 ? 'Yes' : 'No' }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Date</div>
                            {{ PredefinedDateFormatOnTask($row['task_estimated_date_for_completion'] )}}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Time</div>
                            {{ date('H:i', strtotime($row['task_estimated_date_for_completion'])) }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Group</div>
                            {{ isset($row['task_grp']) ? $row['task_grp'] : $row['task_group'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
