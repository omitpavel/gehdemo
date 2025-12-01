

<div class="col-md-12 row">
    @forelse($doctor_at_night_task as $task)
        <div class="col-md-12 row"><div class="col-md-1 row" style="width: 25px;"> <input class="task_assigned_doctors_night" @if($task->task_category == 9 && $task->task_doctor_at_night == 1) checked="checked" @endif name="task_assigned_doctors_night[]" type="checkbox" value="{{$task->id}}"></div><div class="col-md-11 row">   @if ($task->task_priority == 1)
            !
        @endif @isset($task->PatientTaskCategory) {{$task->PatientTaskCategory->task_category_name}} - @endisset {{$task->task_description}} - {{PredefinedDateFormatBoardRoundTaskToBeCompleted($task->task_estimated_date_for_completion)}} - {{$task->PatientTaskGroup->task_group_name}}</div></div>
    @empty
        <div class="col-md-12 center">No Task Found</div>
    @endforelse
</div>
