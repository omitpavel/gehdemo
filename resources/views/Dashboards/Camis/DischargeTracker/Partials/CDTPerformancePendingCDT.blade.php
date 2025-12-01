@if(count($patient_list) > 0)
    <table class="responsiveTable table-listing">
        <thead>
            <tr class="position-relative">
                <th>Ward Name</th>
                <th>Bay & Bed</th>
                <th>Patient Name</th>
                <th>PAS Number</th>
                <th>Consultant</th>
                <th>Admitted Date</th>
                <th>Status</th>
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
                        <div class="tdBefore">Ward</div>
                        {{ $patient['ward_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Bay & Bed</div>
                        {{ $patient['ibox_actual_bed_full_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">PAS Number</div>
                        {{ $patient['camis_patient_pas_number'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Consultant</div>
                        {{ $patient['camis_consultant_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Admitted Date</div>
                        {{ PredefinedDateFormatFor24Hour($patient['camis_patient_admission_date_time']) }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Status</div>
                        @if($patient['board_round_cdt']['cdt_status'] == 0)
                            Pending
                        @elseif($patient['board_round_cdt']['cdt_status'] == 2)
                            In Review
                        @endif
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
@else
    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
@endif
