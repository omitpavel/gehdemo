<div class="rectangle-block-1">
    <div class="row mb-2">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between rectangle-block-2">
                <p class="mb-0">History</p>
            </div>
        </div>
    </div>
    <div class="data-area">
        <div class="row mb-2">
            <div class="col-12 discharge-comments-section">
                <div class="rectangle-block-1">
                    <div class="discharge-comments">
                        @if(count($comments_list) > 0)
                            <table class="responsiveTable table-discharge-comments">
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
                                <div class="work-plan mb-2">
                                    <h6>{{  NotFoundMessage() }}</h6>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
