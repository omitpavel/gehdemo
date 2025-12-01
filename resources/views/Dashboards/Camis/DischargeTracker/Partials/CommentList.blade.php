@if(count($comment_list) > 0)
    @foreach($comment_list as $comment)
        <div class="row gx-1 align-items-center dtoc_comment_removal_{{ $comment->id }} @if(isset($comment->priority) && $comment->priority == 1 ) bg-priority-task @endif">
            <div class="col-comment">
                <span class="">{{ $comment->comments }} - {{ PredefinedDateFormatFor24Hour($comment->updated_at) }}</span>
            </div>
            <div class="col-icons">
                <a  class="add_comment cursor_pointer"  data-comment-id="{{ $comment->id }}"  data-camis-patient-id="{{ $camis_patient_id }}"  data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="EDIT"><i class="bi bi-pencil-square "></i></a>
                <a  class="comment_na_action cursor_pointer"  data-comment-id="{{ $comment->id }}"  data-camis-patient-id="{{ $camis_patient_id }}"  data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="Not Applicable">N/A</a>
            </div>
        </div>
    @endforeach



@endif
