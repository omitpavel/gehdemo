<div class="missed-reason-history-card">
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
                <div class="col-12 missed-comments-section">
                    <div class="rectangle-block-1">
                        @if($history_data->count() > 0)
                            <div class="missed-comments">
                                <table class="responsiveTable table-missed-comments">
                                    <thead>
                                        <tr>
                                            <th>Comments</th>
                                            <th>User</th>
                                            <th>Date &amp; Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($history_data as $data)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Comments</div>
                                                {{ $data->missed_reason }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">User</div>
                                                {{ $users[$data->updated_by] ?? 'Unknown User' }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Date &amp; Time</div>
                                                {{ PredefinedDateFormatFor24Hour($data->updated_at) }}
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
