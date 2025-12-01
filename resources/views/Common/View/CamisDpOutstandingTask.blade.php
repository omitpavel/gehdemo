<p class="fs-14 mb-0">Outstanding Tasks</p>
<div class="card-tasks">
    <div class="row align-items-center">
        @if(count($task_list) > 0)
                @foreach ($task_list as $task)

                <div class="col-12 edit_task_{{ $task['id'] }}">
                    <span class="">
                        @if ($task['task_priority'] == 1)
                            !
                            @endif @if ($task['task_category'] != 0)

                                #{{ @$task['patient_task_category']['task_category_name'] }}@if ($task['task_category'] == 6)
                                {{ $task['task_dp_status_order_value'] }}
                            @endif  -
                                @endif {{ $task['task_description'] }} -
                                {{ PredefinedDateFormatFor24Hour($task['task_estimated_date_for_completion']) }} -
                                {{ @$task['patient_task_group']['task_group_name'] }}
                    </span>

                </div>


                    @endforeach

        @endif


    </div>
</div>
