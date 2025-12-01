
<div class="row g-2">
    <div class="col-12">
        <label class="form-label">Task Name</label>
        <p class="task-list">
            {{ $success_array['patient_task']->task_description }}
        </p>
    </div>
    <div class="col-12">
        <label for="" class="form-label">Task Status</label>
        <input type="text" readonly value="{{ $success_array['patient_task']->task_completed_status == 1 ? 'Completed' : 'Not Applicable' }}" class="form-control" id="" aria-describedby="" placeholder="Testing">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Assigned Group</label>
        <input type="text" readonly class="form-control" id="" aria-describedby="" value="{{ $success_array['patient_task']->PatientTaskGroup->task_group_name }}" placeholder="Nurse/Dr">
    </div>
    <div class="col-md-6">
        <label for="" class="form-label">Task Date & Time</label>
        <input type="text" readonly value="{{ PredefinedDateFormatFor24Hour($success_array['patient_task']->task_created_at) }}" class="form-control" id="" aria-describedby=""
               placeholder="{{ PredefinedDateFormatFor24Hour($success_array['patient_task']->task_created_at) }}">
    </div>
    @if($success_array['patient_task']->task_completed_status == 1)
    <div class="col-md-6">
        <label for="" class="form-label">Completion Date & Time</label>
        <input readonly type="text" value="{{ PredefinedDateFormatFor24Hour($success_array['patient_task']->task_completed_at) }}" class="form-control" id="" aria-describedby=""
               placeholder="{{ PredefinedDateFormatFor24Hour($success_array['patient_task']->task_completed_at) }}">
    </div>
    @else
    <div class="col-md-6">
        <label for="" class="form-label">Not Applicable Set Date & Time</label>
        <input readonly type="text" value="{{ PredefinedDateFormatFor24Hour($success_array['patient_task']->task_not_applicable_at) }}" class="form-control" id="" aria-describedby=""
               placeholder="{{ PredefinedDateFormatFor24Hour($success_array['patient_task']->task_not_applicable_at) }}">
    </div>

    @endif
    @if($success_array['patient_task']->task_completed_status == 1)
    <div class="col-md-6">
        <label for="" class="form-label">Completed By</label>
        <input type="text" readonly class="form-control" value="{{ Sentinel::findById($success_array['patient_task']->task_completed_by)->username?? '--'  }}" id="" aria-describedby="" placeholder="Admin">
    </div>
    @else
    <div class="col-md-6">
        <label for="" class="form-label">Not Applicable Set By</label>
        <input type="text" readonly class="form-control" value="{{ Sentinel::findById($success_array['patient_task']->task_not_applicable_by)->username?? '--'  }}" id="" aria-describedby="" placeholder="Admin">
    </div>
    @endif
    @if($success_array['patient_task']->task_category  == 6 && $success_array['patient_task']->task_not_applicable_status == 1)
        <div class="col-12">
            <label for="" class="form-label">Start Diabetic Pathway If Indicated</label>
            <input readonly type="text" value="Not Applicable" class="form-control" id="" aria-describedby="" placeholder="Yes">
        </div>
    @endif
    @if(!empty($success_array['patient_task']->task_extra_data) && is_array(json_decode($success_array['patient_task']->task_extra_data, true)) )
        @foreach(json_decode($success_array['patient_task']->task_extra_data) as $key => $value)
        <div class="col-12">
            <label for="" class="form-label">{{ str_replace('_', ' ', ucwords($key)) }}</label>
            <input readonly type="text" class="form-control" id="" value="{{ $value }}" aria-describedby="" placeholder="Yes">
        </div>
        @endforeach
    @endif


    @if(!empty($success_array['patient_task']->task_comment))
        <div class="col-12">
            <label class="form-label">Comments</label>
            <p class="task-list">
                {{ $success_array['patient_task']->task_comment }}
            </p>
        </div>

    @endif

</div>
