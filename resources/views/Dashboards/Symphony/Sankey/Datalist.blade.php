
<table class="breachReasonTable responsiveTable table-ae-sankey">
    <thead>
    <tr>
        <th>Arrival Mode</th>
        <th>Triage</th>
        <th>Location</th>
        <th>Time </th>
        <th>Breach </th>
        <th>Admitted/Discharge </th>
        <th>Speciality</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="pivoted">
            <div class="tdBefore">Arrival Mode</div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'arrival_walk_in');">
                <span>Walk In</span>
                <span class="fw-header-500">{{ $success_array['arrival']['walk_in'] }}</span>
            </div>
            <div class="cell-data" data-bs-toggle="offcanvas"
                 data-bs-target="#sankeyPatientsDetails" aria-controls="offcanvasRight"
                 onclick="ViewDetails('{{ $success_array['source'] }}', 'arrival_ambulance');">
                <span>Ambulance</span>
                <span class="fw-header-500">{{ $success_array['arrival']['ambulance'] }}</span>
            </div>
        </td>


        <td class="pivoted">
            <div class="tdBefore">Triage</div>

            @foreach ($success_array['triage'] as $key => $triage)
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'triage_{{ $key }}');" >
                <span> {{ str_replace('_', ' ', $key) }}</span>
                <span class="fw-header-500">{{ $triage }}</span>
            </div>
            @endforeach



        </td>
        <td class="pivoted">
            <div class="tdBefore">Location</div>
            @foreach ($success_array['location'] as $key => $location)
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'location_{{ $key }}');" >
                <span> {{ str_replace('_', ' ', $key) }}</span>
                <span class="fw-header-500">{{ $location }}</span>
            </div>
            @endforeach
        </td>
        <td class="pivoted">
            <div class="tdBefore">Time</div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'time_0_to_1_hr');" >
                <span> 0 To 1 Hours</span>
                <span class="fw-header-500">{{ $success_array['time']['0_to_1_hr'] }}</span>
            </div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'time_1_to_2_hr');" >
                <span>1 To 2 Hours</span>
                <span class="fw-header-500">{{ $success_array['time']['1_to_2_hr'] }}</span>
            </div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'time_2_to_4_hr');" >
                <span>2 To 4 Hours</span>
                <span class="fw-header-500">{{ $success_array['time']['2_to_4_hr'] }}</span>
            </div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'time_4_to_8_hr');" >
                <span>4 To 8 Hours</span>
                <span class="fw-header-500">{{ $success_array['time']['4_to_8_hr'] }}</span>
            </div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'time_8_to_12_hr');" >
                <span>8 To 12 Hours</span>
                <span class="fw-header-500">{{ $success_array['time']['8_to_12_hr'] }}</span>
            </div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'time_12_+_hr');" >
                <span>12+</span>
                <span class="fw-header-500">{{ $success_array['time']['12_+_hr'] }}</span>
            </div>
        </td>
        <td class="pivoted">
            <div class="tdBefore">Breach</div>
            @foreach ($success_array['breach'] as $key => $breach)
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'breach_{{ $key }}');" >
                <span> {{ str_replace('_', ' ', $key) }}</span>
                <span class="fw-header-500">{{ $breach }}</span>
            </div>
            @endforeach
        </td>
        <td class="pivoted">
            <div class="tdBefore">Admitted/Discharge</div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'outcome_admitted');">
                <span>Admitted</span>
                <span class="fw-header-500">{{ $success_array['outcome']['admitted'] }}</span>
            </div>
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'outcome_non_admitted');">
                <span> Not Admitted</span>
                <span class="fw-header-500">{{ $success_array['outcome']['non_admitted'] }}</span>
            </div>
        </td>
        <td class="pivoted">
            <div class="tdBefore">Speciality</div>

            @foreach ($success_array['speciality'] as $key => $speciality)
            <div class="cell-data" onclick="ViewDetails('{{ $success_array['source'] }}', 'sp_{{ $key }}');" >
                <span> {{ str_replace('_', ' ', $key) }}</span>
                <span class="fw-header-500">{{ $speciality }}</span>
            </div>
            @endforeach
        </td>
    </tr>
    </tbody>
</table>

