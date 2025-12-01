@if(count($all_screenedHistory) > 0)
    <div class="row">
        <div class="col-12 ">
            <div class="card-comment-history">
                <table class="breachReasonTable responsiveTable table-comments-history">
                    <thead>
                    <tr class="position-relative">
                        <th>Date &amp; Time</th>
                        <th>Ward</th>
                        <th class="text-start">Screened By</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($all_screenedHistory as $history)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Date &amp; Time</div>
                            {{ PredefinedDateFormatFor24Hour($history['date_time']) }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Ward</div>
                            {{ $history['ward']['ward_name'] }}
                        </td>

                        <td class="pivoted">
                            <div class="tdBefore">Screened By</div>
                            {{ Sentinel::findById($history['updated_by'])->username?? '--'  }}

                        </td>
                    </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
@endif
