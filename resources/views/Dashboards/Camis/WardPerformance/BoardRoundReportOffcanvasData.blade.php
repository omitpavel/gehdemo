<div class="card-table-listing">

    @if(count($board_round_chart_results) > 0)
        <table class="responsiveTable table-listing">
            <thead>
                <tr class="position-relative">
                    <th>Date</th>
                    <th>Ward Name</th>
                    <th>Morning Board Round Status</th>
                    <th>Afternoon Board Round Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($board_round_chart_results as $result)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Date</div>
                            {{ PredefinedYearFormat($date) }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Ward Name</div>
                            {{ $result['ward_name'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Morning Board Round Status</div>
                            <div class="column-1">
                                @if($result['am_status'] == 0)
                                    <span class="dot-red"></span>
                                    <span>None</span>
                                @elseif($result['am_status'] == 2)
                                    <span class="dot-amber"></span>
                                    <span>{{ $result['am'] }}</span>
                                @elseif($result['am_status'] == 1)
                                    <span class="dot-green"></span>
                                    <span>{{ $result['am'] }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Afternoon Board Round Status</div>
                            <div class="column-1">
                                @if($result['pm_status'] == 0)
                                    <span class="dot-red"></span>
                                    <span>None</span>
                                @elseif($result['pm_status'] == 2)
                                    <span class="dot-amber"></span>
                                    <span>{{ $result['pm'] }}</span>
                                @elseif($result['pm_status'] == 1)
                                    <span class="dot-green"></span>
                                    <span>{{ $result['pm'] }}</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="custom_not_found">{{ NotFoundMessage() }}</div>
    @endif
</div>
