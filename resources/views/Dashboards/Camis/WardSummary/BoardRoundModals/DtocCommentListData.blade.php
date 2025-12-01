@if(count($comment_list) > 0)
    <div class="card-table-listing">
        <table class="responsiveTable table-listing">
            <thead>
                <tr class="position-relative">
                    <th>Sl No</th>
                    <th>Comment</th>
                    <th>Priority</th>
                    <th>Created By</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comment_list as $comment)
                    <tr  @if($comment->priority == 1) class="bg-priority-task" @endif>
                        <td class="pivoted">
                            <div class="tdBefore">Sl No</div>
                            {{ $loop->iteration }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Comment</div>
                            {{ $comment->comments }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Priority</div>
                            @if($comment->priority == 1) Yes @else No @endif
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Created By</div>
                            {{ Sentinel::findById($comment->updated_by)->username ?? '' }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Created At</div>
                            {{ PredefinedDateFormatFor24Hour($comment->created_at) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@else

    <div class="No_record_css">
                {{ NotFoundMessage() }}
        </div>
    </div>

@endif
