<div class="row">
    <div class="col-12 ">
        <div class="iv-history">
            <div class="row gx-2">
                <div class="col-md-6">
                    <div class="iv-header">
                        <h6>Antibiotic IV</h6>
                    </div>
                    <div class="card-history">
                        <table class="breachReasonTable responsiveTable table-history">
                            <thead>
                            <tr class="position-relative">
                                <th>#</th>
                                <th>Start</th>
                                <th>End</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($iv_history_list as $data)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">#</div>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Start</div>
                                        @if(isset($data['start_date']) && !empty($data['start_date']))
                                            {{ PredefinedDateFormatFor24Hour($data['start_date']) }}
                                        @endif
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">End</div>
                                        @if(isset($data['end_date']) && !empty($data['end_date']))
                                            {{ PredefinedDateFormatFor24Hour($data['end_date']) }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="pivoted text-center" colspan="3">{{ NotFoundMessage() }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="iv-header">
                        <h6>Antibiotic ORAL</h6>
                    </div>
                    <div class="card-history">
                        <table class="breachReasonTable responsiveTable table-history">
                            <thead>
                            <tr class="position-relative">
                                <th>#</th>
                                <th>Start</th>
                                <th>End</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($oral_history_list as $data)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">#</div>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Start</div>
                                        @if(isset($data['start_date']) && !empty($data['start_date']))
                                            {{ PredefinedDateFormatFor24Hour($data['start_date']) }}
                                        @endif
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">End</div>
                                        @if(isset($data['end_date']) && !empty($data['end_date']))
                                            {{ PredefinedDateFormatFor24Hour($data['end_date']) }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="pivoted text-center" colspan="3">{{ NotFoundMessage() }}</td>
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
