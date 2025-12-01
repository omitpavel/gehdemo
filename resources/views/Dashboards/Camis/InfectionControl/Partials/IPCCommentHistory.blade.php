<div class="ipc-history-card">
    <div class="rectangle-block-1">
        <div class="row mb-2">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between rectangle-block-2">
                    <p class="mb-0">History</p>
                </div>
            </div>
        </div>
        <div class="data-area">
            <div class="row mb-lg-2">
                <div class="col-12 ipc-comments-section">

                        <div class="ipc-comments">
                            <table class="responsiveTable table-ipc-comments">
                                <thead>
                                    <tr>
                                        <th>Comments</th>
                                        <th>User</th>
                                        <th>Date &amp; Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ipc_comment_history as $comment)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Comments</div>
                                                [{{ $updated_status[$comment['history_status']] }}] {{ !empty($comment['comment']) ? $comment['comment'] : 'Comment Deleted' }}
                                            </td>

                                            <td class="pivoted">
                                                <div class="tdBefore">User</div>
                                                {{ $users[$comment['updated_by']] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Date &amp; Time</div>
                                                {{ PredefinedDateFormatFor24Hour($comment['updated_at']) }}
                                            </td>

                                        </tr>
                                    @empty
                                    <tr class="no-records-row">
                                        <td colspan="3" class="no-records-cell">
                                            No records found
                                        </td>
                                    </tr>

                                    @endforelse


                                </tbody>
                            </table>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
