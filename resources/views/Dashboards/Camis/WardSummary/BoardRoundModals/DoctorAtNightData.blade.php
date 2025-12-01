@if($doctor_at_night_task->count() > 0)
    <div class="row mb-3">
        <div class="col-12 ">
            <div class="reasons-list-block">
                @foreach($doctor_at_night_task as $key=> $task)
                <ul class="reason-list">
                    <li> <input class="form-check-input p-2 task_assigned_doctors_night" type="checkbox" @if($task->task_category == 9 && $task->task_doctor_at_night == 1) checked="checked" @endif name="task_assigned_doctors_night[]"  value="{{$task->id}}" id="doctor_at_night_{{ $key }}">
                    </li>
                    <li >
                        @if ($task->task_priority == 1)
                            !
                        @endif
                        @isset($task->PatientTaskCategory) {{$task->PatientTaskCategory->task_category_name}} - @endisset {{$task->task_description}} - {{PredefinedDateFormatBoardRoundTaskToBeCompleted($task->task_estimated_date_for_completion)}} - {{$task->PatientTaskGroup->task_group_name}}
                    </li>
                </ul>
                @endforeach
            </div>
        </div>
    </div>

@else
    <div class="row mb-2">
        <div class="col-12">
            <div class="content-assigned-speciality">
                <div class="work-plan-wrapper No_record_css bg-assigned-details">
                    <div class="work-plan mb-2">
                        <h6>No Records Found!</h6>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endif

