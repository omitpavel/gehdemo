@if(count($patients)>0)
<div class="row gx-2 mb-2">
    <div class="col-lg-3 col-md-4 offset-lg-9 offset-md-8">
        <div class="bg-patients-count">
            <h6>Total Patients</h6>
            <h5>{{ count($patients) }}</h5>
        </div>
    </div>
</div>
@endif
<div class="card-patients-sankey mb-2">
    @if(count($patients) > 0)
        <table class="breachReasonTable responsiveTable table-patients-sankey">
            <thead>
            <tr class="position-relative">
                <th>Attendance ID</th>
                <th>Name</th>
                <th width="100">Arrival Mode</th>
                <th>Triage</th>
                <th>Location</th>
                <th>Time</th>
                <th>Breach</th>
                <th>Admitted/Discharge</th>
                <th>Speciality</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Attendance ID</div>
                            {{ $patient['symphony_attendance_id'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Name</div>
                            {!! SymphonyPatientGender($patient['symphony_patient_sex'], $patient['symphony_patient_name']) !!}

                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Arrival Mode</div>
                            @if(strpos($patient['symphony_arrival_mode'], 'ambulance') !== false)
                                Ambulance
                            @else
                                Walk-In
                            @endif
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Triage</div>
                            {{ $patient['symphony_triage_category'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Location</div>
                            {{ $patient['symphony_final_location'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Time</div>
                            {{ $patient['time_difference_hours'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Breach</div>
                            @if(empty($patient['breach_reason_name']) || strtolower($patient['breach_reason_name']) == 'not set')
                                Breach Not Set
                            @else
                                {{ $patient['breach_reason_name'] }}
                            @endif
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Admitted/Discharge</div>
                            @if($patient['symphony_discharge_outcome_val'] == 1)
                                Admitted
                            @else
                                Non-Admitted
                            @endif
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Speciality</div>
                            @if(empty($patient['symphony_specialty']))
                                No Speciality
                            @else
                                {{ $patient['symphony_specialty'] }}
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
    <div class="custom_not_found">
        {{ NotFoundMessage() }}
    </div>
    @endif
</div>
