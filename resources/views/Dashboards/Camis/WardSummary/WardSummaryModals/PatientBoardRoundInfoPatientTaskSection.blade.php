
<div class="taskLeftWrap taskWrapinner">
    <div class="taskhead">
        <span>Task to be compleated</span><button class="printBtn" onclick="print_pd_doc('printTask')">Print</button>
    </div>
    <div class="tasklistwrap" id="">
         <ul class="taskList">
            @if (count($success_array['task_to_be_completed']) > 0)
                @foreach ($success_array['task_to_be_completed'] as $row)
                    <li data-patient-task-id="{{ $row['id'] }}" class="ibox_boardround_popup_patient_task_to_be_completed_show_list ibox_boardround_popup_patient_task_show {{ $row['patient_task_show_string_class'] }} ">
                        @if ($row['task_priority'] == 1)
                            <span class='patient_task_show_important'>!</span>
                        @endif
                        {{ $row['patient_task_show_string'] }}
                    </li>
                @endforeach
            @endif
        </ul>
    </div>



    <div id="printTask" style="display: none">
        <div style="width: 100%; font-size: 22px; padding: 15px 0; text-align: center;"> {{ isset($success_array['patient_details'])  ? $success_array['patient_details']['each_patient'] : '' }}</div>
        <table style="width: 100%; font-size: 10px">
            <tr style="background: #00aacb;color: white; padding-top: 10px; -webkit-print-color-adjust: exact;">
                <th style="text-align: left; width: 5%; padding: 5px 5px;">No</th>
                <th style="text-align: center; width: 5%; padding: 5px 5px;">Priority</th>
                <th style="text-align: left; width: 50%; padding: 5px 5px;">Task</th>
                <th style="text-align: center;  width: 15%; padding: 5px 5px;">Date</th>
                <th style="text-align: center;width:10%; padding: 5px 5px;">Time</th>
                <th style="text-align: left;width: 15%; padding: 5px 5px;">Group</th>
            </tr>

            @foreach($success_array['task_to_be_completed'] as $row)
            <tr style="-webkit-print-color-adjust: exact; @if($loop->iteration %2 == 0) background-color: #f5f5f5; @else background-color: #ffffff; @endif ">
                <td style="text-align: left; padding: 5px 5px; vertical-align: top;">{{ $loop->iteration }}</td>
                <td style="text-align: left; padding: 5px 5px; vertical-align: top;">{{ $row['task_priority'] == 1 ? 'Yes' : 'No' }}</td>
                <td style="text-align: left; padding: 5px 5px; vertical-align: top;">
                    @if ($row['task_priority'] == 1)
                        <span class='patient_task_show_important'>!</span>
                    @endif
                    {{ $row['patient_task_show_string'] }}
                <td style="text-align: left; padding: 5px 5px; vertical-align: top;">{{ PredefinedDateFormatOnTask($row['task_estimated_date_for_completion'] )}}</td>
                <td style="text-align: left; padding: 5px 5px; vertical-align: top;">{{ date('H:i', strtotime($row['task_estimated_date_for_completion'])) }}</td>
                <td style="text-align: left; padding: 5px 5px; vertical-align: top;"> {{ isset($row['task_grp']) ? $row['task_grp'] : $row['task_group'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div id="print_task" style="display: none;">IP00084761,IP00073524,IP00082732,IP00079924</div>

</div>
<div class="taskwrapmiddle">
    <button class="edit ibox_buttons ibox_boardround_popup_patient_task_edit">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
        </svg>
    </button>
    <button class="tick ibox_buttons ibox_boardround_popup_patient_task_complete">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
            <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
            <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
        </svg>
    </button>
    <button class="notapplicable task_not_applicable ibox_buttons ibox_boardround_popup_patient_task_delete">
        <span>NA</span>
    </button>
</div>

<div class="taskRightWrap taskWrapinner">
    <div class="taskhead"><span>Compleated Task</span></div>
    <div class="tasklistwrap">
        <ul class="taskList">
            @if (count($success_array['task_completed']) > 0)
                @foreach ($success_array['task_completed'] as $row)
                    <li class="ibox_boardround_popup_patient_task_completed_show_list ibox_boardround_popup_patient_task_show {{ isset($row['patient_task_show_string_class']) ? $row['patient_task_show_string_class'] : '' }}">
                        {{ isset($row['patient_task_show_string']) ? $row['patient_task_show_string'] : $row['task_description'] }}
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
