@if(count($patient_list) > 0)
    <table class="responsiveTable table-listing">
        <thead>
            <tr class="position-relative">
                <th>Sl</th>
                <th>Ward Name</th>
                <th>Patient Name</th>
                <th>Hospital Number</th>
                <th>Admitted Date & Time</th>
                <th>Discharge Date & Time</th>
                <th>LOS</th>
            </tr>
        </thead>
        <tbody>
            @php
                usort($patient_list, function ($a, $b) {
                    return strcmp($a['ward_name'], $b['ward_name']);
                });
            @endphp
            @foreach ($patient_list as $patient)

                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">Sl</div>
                        {{ $loop->iteration }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Ward Name</div>
                        {{ $patient['ward_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Hospital Number</div>
                        {{ $patient['camis_patient_pas_number'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Admitted Date & Time</div>
                        {{ PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Discharge Date & Time</div>
                        {{ PredefinedDateFormatFor24Hour($patient['camis_patient_discharge_date_time']) }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">LOS</div>
                        @php

                            $admission = Carbon\Carbon::parse($patient['camis_patient_admission_date_time']);
                            $discharge = Carbon\Carbon::parse($patient['camis_patient_discharge_date_time']);

                            $discharge_hour = $discharge->hour;
                            $days_diff = $admission->diffInDays($discharge);
                        @endphp
                        {{ $days_diff }} Days
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
@else
    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
@endif
