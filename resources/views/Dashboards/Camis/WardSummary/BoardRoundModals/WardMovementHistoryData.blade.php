
                @if(count($history_list) > 0)
                    <table class="breachReasonTable responsiveTable table-ward-movement">
                        <thead>
                            <tr class="position-relative">
                                <th>#</th>
                                <th>Ward Name</th>
                                <th>Bed</th>
                                <th>Status</th>
                                <th>Moved In Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history_list as $history)
                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore d-lg-block d-xl-none">#</div>
                                    {{ $loop->iteration }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore d-lg-block d-xl-none">Ward Name</div>
                                    {{ $history->actual_ward ?? '' }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore d-lg-block d-xl-none">Bed Name</div>
                                    {{ $history->bed_name ?? '' }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore d-lg-block d-xl-none">Status</div>
                                    {{ $history->ward_status ?? '' }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore d-lg-block d-xl-none">Moved In Date</div>
                                    {{ PredefinedDateFormatFor24Hour($history->bed_startdate) }}
                                </td>
                            </tr>
                            @empty
                                <tr><td class="text-center custom_not_found" colspan="6">{{ NotFoundMessage() }}</td></tr>
                            @endforelse

                        </tbody>
                    </table>
                @else
                    <div class="work-plan-wrapper No_record_css bg-assigned-details">
                        <div class="work-plan mb-2">
                            <h6>{{  NotFoundMessage() }}</h6>

                        </div>
                    </div>
                @endif

