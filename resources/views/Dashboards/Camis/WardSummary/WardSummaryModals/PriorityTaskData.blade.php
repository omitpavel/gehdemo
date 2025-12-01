
<div class="priority-tasks">
    <div class="work-plan-wrapper">
        @if(count($task_list) > 0)


            @foreach ($task_list as $patient_tasks)
                <div class="work-plan mb-2">
                    <div class="name-header">
                        <h6>{{ $patient_tasks['bed'] }}</h6>
                    </div>
                    <div class="task-details">
                        <table>
                            <tbody>
                                @foreach ($patient_tasks['tasks'] as $task)
                                    <tr>
                                        <td width="50" class="text-center">{{ $loop->iteration }}</td>
                                        <td> @if ($task['task_priority'] == 1)
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
                                                {{ @$task['patient_task_group']['task_group_name'] }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else

            <div class="No_record_css">
                {{ NotFoundMessage() }}
            </div>
        @endif
    </div>
</div>
