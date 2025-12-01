<input type="hidden" id="cdt_comment_patient_id" value="{{ $camis_patient_id }}">

<div class="row ">
    <div class="">
        <textarea class="form-control" id="cdt_latest_comment" rows="6"></textarea>
    </div>
</div>

<div class="modal-dummy-content-loader"></div>
<div class="history-card" id="patient_comment_history">
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
                <div class="col-12 title-comments-section">
                    <div class="rectangle-block-1">
                        <div class="title-comments">
                            @if (count($comments_list) > 0)
                                <table class="responsiveTable table-discharge-comments">
                                    <thead>
                                        <tr>
                                            <th>Comments</th>
                                            <th>User</th>
                                            <th>Date &amp; Time</th>
                                            @if ($cdt_details->cdt_status == 2)
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments_list as $comment)
                                            <tr class="comment_list_id_{{ $comment['history_id'] }}">
                                                <td class="pivoted">
                                                    <div class="tdBefore">Comments</div>
                                                    {{ $comment['cdt_comment'] }} (@if($comment['history_status'] == 1) Created @elseif($comment['history_status'] == 2) Updated @elseif($comment['history_status'] == 3) Deleted @endif)
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">User</div>
                                                    {{ $users[$comment['updated_by']] }}
                                                </td>
                                                <td class="pivoted">
                                                    <div class="tdBefore">Date &amp; Time</div>
                                                    {{ PredefinedDateFormatFor24Hour($comment['updated_at']) }}
                                                </td>

                                                <td class="pivoted">
                                                    <div class="tdBefore">Action</div>
                                                    @if($cdt_details->cdt_status == 2 && !$loop->first)
                                                    <button class="btn btn-delete click_delete_comment_history"
                                                    data-comment-id="{{ $comment['history_id'] }}">Delete</button>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <div class=" No_record_css bg-assigned-details">
                                    <div class="work-plan mb-2">
                                        <h6>{{ NotFoundMessage() }}</h6>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
