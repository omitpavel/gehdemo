@if(count($comments_list) > 0)
<table class="responsiveTable table-other-notes">
    <thead>
        <tr>
            <th>Other Notes</th>
            <th>User</th>
            <th>Date &amp; Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comments_list as $comment)
        <tr>
            <td class="pivoted">
                <div class="tdBefore">Other Notes</div>
                {{ $comment['discharge_comment'] }} - {{ $history_status[$comment['history_status']] ?? '--' }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">User</div>
                {{ $users[$comment['updated_by']]  }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Date &amp; Time</div>
                {{ PredefinedDateFormatFor24Hour($comment['updated_at']) }}
            </td>
        </tr>
        @endforeach



    </tbody>
</table>
@else
<div class=" No_record_css bg-assigned-details">

        {{  NotFoundMessage() }}

</div>
@endif
