<div class="infection-history-section">

    <table class="responsiveTable table-infection-history">
        <thead>
            <tr>
                <th>Infection Name</th>
                <th>Status</th>
                <th>User</th>
                <th>Date &amp; Time</th>
            </tr>
        </thead>
        <tbody>
            @php
                $compareCols = [
                    'id',
                    'patient_id',
                    'infection_id',
                    'infection_name',
                    'infection_type',
                    'is_primary',
                ];

                $norm = function ($v, $k = null) {
                    if (is_null($v)) {
                        return '__NULL__';
                    }
                    $s = is_string($v) ? trim($v) : (string) $v;
                    if (in_array($k, ['infection_name', 'infection_type'], true)) {
                        $s = mb_strtolower($s);
                    }
                    return $s;
                };

                $makeSig = function (array $row) use ($compareCols, $norm) {
                    $vals = [];
                    foreach ($compareCols as $col) {
                        $vals[] = $norm($row[$col] ?? null, $col);
                    }
                    return implode('|', $vals);
                };

                $pairKey = function (array $row) {
                    $id = is_null($row['id']) ? '__NULL__' : (string) $row['id'];
                    $ts = (string) $row['updated_at'];
                    return $id . '#' . $ts;
                };

                $status1ByPair = collect($ipc_infection_history)
                    ->where('history_status', 1)
                    ->mapWithKeys(fn($r) => [$pairKey($r) => $makeSig($r)]);
            @endphp

            @forelse ($ipc_infection_history as $ic)
                @php
                    $isStatus2 = (int) $ic['history_status'] === 2;
                    $key = $pairKey($ic);
                    $sig2 = $makeSig($ic);

                    $isExactPairDuplicate = $isStatus2 && isset($status1ByPair[$key]) && $status1ByPair[$key] === $sig2;
                @endphp

                @if (!$isExactPairDuplicate)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Infection Name</div>
                            [{{ $updated_status[$ic['history_status']] }}] {{ $ic['infection_name'] }} @if ($ic['is_primary'] == 1)
                            <span class="badge bg-success ms-1">Primary</span>
                        @endif
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Status</div>
                            @if ($ic['infection_type'] == 'CANSTAYINBAY')
                                    Can Stay In Bay
                            @else
                                {{ $ic['infection_type'] }}
                            @endif
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">User</div>
                            {{ $users[$ic['updated_by']] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Date &amp; Time</div>
                            {{ PredefinedDateFormatFor24Hour($ic['updated_at']) }}
                        </td>
                    </tr>
                @endif
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
