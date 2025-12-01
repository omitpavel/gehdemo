
@if (count($comment_list) > 0)
    @foreach ($comment_list as $comment)
        <tr class="updated_inner_comment_{{ $comment->id }}">
            <td class="pivoted">
                <div class="tdBefore"></div>
               {{ $comment->comment_text }}, {{ Sentinel::findById($comment->updated_by)->username?? '--' }} - {{ PredefinedDateFormatFor24Hour($comment->updated_at) }}
            </td>
            <td class="pivoted">
                <div class="tdBefore"></div>
                <div class="d-flex justify-content-end ">
                    <a class="comment_upadate_delete_check_status cursor_pointer" data-comment-create-status="edit" data-comment-id="{{$comment->id}}" data-comment-text="{{$comment->comment_text}}" data-comment-patient-id="{{$camis_patient_id}}" data-comment-delete-type="off_canvas" ><i class="bi bi-pencil-square"></i></a>
                    <a class="comment_upadate_delete_check_status cursor_pointer" data-comment-id="{{$comment->id}}" data-comment-text="{{$comment->comment_text}}" data-comment-patient-id="{{$camis_patient_id}}"  data-comment-create-status="delete" data-comment-id="{{$comment->id}}" data-comment-text="{{$comment->comment_text}}" data-comment-patient-id="{{$camis_patient_id}}" data-comment-delete-type="off_canvas"><i class="bi bi-trash3"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td class="custom_table_data_not_found">
            {{ NotFoundMessage()  }}
        </td>
    </tr>

@endif


