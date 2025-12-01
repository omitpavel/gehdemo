@foreach($success_array['task_group'] as $task_group)
    <div class="col-lg-6 col-md-6 ">
        <button type="button" class="btn btn-primary-grey  attendance_user_list" data-attendance_user_id="{{ $task_group->board_group_name }}" @if(in_array($task_group->board_group_name, $success_array['ward_round_user'])) active @endif>{{ $task_group->board_group_name }}</button>
    </div>

@endforeach
