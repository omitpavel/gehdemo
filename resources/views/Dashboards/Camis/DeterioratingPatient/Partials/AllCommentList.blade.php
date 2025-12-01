@if (count($comment_list) > 0)
<table class="table-comments">
    <thead>
        <tr class="position-relative">
            <th>Comments</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comment_list as $key=>$comment)
            <tr>
                <td class="pivoted">
                    <div class="tdBefore"></div>
                    {{ $comment->additional_comment }} - {{ PredefinedDateFormatFor24Hour($comment->updated_at) }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore"></div>
                    <div class="d-flex justify-content-end ">
                        <a href="#" class="comment_upadate_delete_check_status  {{ DisabledButtonOnRolePermission('dp_dashboard_dashboard_comment_update') }}"  data-comment-create-status="edit" data-comment-id="{{$comment->id}}" data-comment-text="{{$comment->additional_comment}}" data-comment-patient-id="{{$camis_patient_id}}"  data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="EDIT"><i class="bi bi-pencil-square "></i></a>
                <a href="#" class="comment_upadate_delete_check_status {{ DisabledButtonOnRolePermission('dp_dashboard_dashboard_comment_delete') }}" data-comment-create-status="delete" data-comment-id="{{$comment->id}}" data-comment-text="{{$comment->additional_comment}}" data-comment-patient-id="{{$camis_patient_id}}"  data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="DELETE"><i class="bi bi-trash3"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else

    <div class="No_record_css bg-assigned-details">
        <div class="work-plan mb-2">
            <h6>{{  NotFoundMessage() }}</h6>

        </div>
    </div>
@endif
