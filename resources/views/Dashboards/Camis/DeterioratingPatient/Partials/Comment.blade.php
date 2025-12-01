
    @if (count($comment_list) > 0)
        @foreach ($comment_list as $key=>$comment)

        <div class="row gx-1 align-items-center">
            <div class="col-comment">
                <span class="">{{ $comment->additional_comment }} - {{ PredefinedDateFormatFor24Hour($comment->updated_at) }}</span>
            </div>
            <div class="col-icons">
                <a href="#" class="comment_upadate_delete_check_status  {{ DisabledButtonOnRolePermission('dp_dashboard_dashboard_comment_update') }}"  data-comment-create-status="edit" data-comment-id="{{$comment->id}}" data-comment-text="{{$comment->additional_comment}}" data-comment-patient-id="{{$camis_patient_id}}"  data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="EDIT"><i class="bi bi-pencil-square "></i></a>
                <a href="#" class="comment_upadate_delete_check_status {{ DisabledButtonOnRolePermission('dp_dashboard_dashboard_comment_delete') }}" data-comment-create-status="delete" data-comment-id="{{$comment->id}}" data-comment-text="{{$comment->additional_comment}}" data-comment-patient-id="{{$camis_patient_id}}"  data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="DELETE"><i class="bi bi-trash3"></i></a>
            </div>
        </div>
        @endforeach
    @endif

