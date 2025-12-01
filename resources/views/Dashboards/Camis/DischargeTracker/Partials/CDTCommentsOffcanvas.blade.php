<div class="cdt-history-card">
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
          <div class="col-12 cdt-comments-section">
            <div class="rectangle-block-1">

                @if(count($comment_list) > 0)
                    <div class="cdt-comments">
                        <table class="responsiveTable table-cdt-comments">
                        <thead>
                            <tr>
                            <th>Comments</th>
                            <th>User</th>
                            <th>Date &amp; Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comment_list as $comment)
                            <tr>
                                <td class="pivoted">
                                <div class="tdBefore">Comments</div>
                                {{ $comment['cdt_comment'] }}
                                </td>
                                <td class="pivoted">
                                <div class="tdBefore">User</div>
                                {{ Sentinel::findById($comment['updated_by'])->username ?? '' }}
                                </td>
                                <td class="pivoted">
                                <div class="tdBefore">Date &amp; Time</div>
                                {{ PredefinedDateFormatFor24Hour($comment['updated_at']) }}
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                        </table>
                    </div>
                @else
                    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
