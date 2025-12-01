
@if(count($comment_list) > 0)
<table class="table-comments">
    <thead>
    <tr class="position-relative">
        <th>Comments</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

        @foreach($comment_list as $comment)

        <tr @if($comment->priority == 1) class="bg-priority-task" @endif>
            <td class="pivoted">
                <div class="tdBefore"></div>
               {{ $comment->comments }} - {{ PredefinedDateFormatFor24Hour($comment->created_at) }}
            </td>
            <td class="pivoted">
                <div class="tdBefore"></div>
                <div class="d-flex justify-content-end ">
                    <a class="add_comment"  data-comment-id="{{ $comment->id }}"  data-comment-type="offcanvas"  data-camis-patient-id="{{ $camis_patient_id }}"  data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="EDIT"><i class="bi bi-pencil-square "></i></a>
                    <a  class="comment_na_action cursor_pointer"  data-comment-id="{{ $comment->id }}"  data-camis-patient-id="{{ $camis_patient_id }}"  data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Not Applicable">N/A</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else

    <div class="No_record_css">
                {{ NotFoundMessage() }}
        </div>
    </div>

@endif
