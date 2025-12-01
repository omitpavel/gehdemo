
@if(count($patients_list) > 0)
    <div class="card-table-listing mb-2">

    <table class="breachReasonTable responsiveTable table-listing">
        <thead>
            <tr class="position-relative">

                <th>Bay & Bed No</th>

                <th>Patient Name</th>
                <th>PAS Number</th>
                <th>Patient ID</th>
                <th>Consultant </th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients_list as $patient)
            @if(isset($patient['camis_patient_bed_name']))
                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">Bay & Bed No</div>
                        {{ $patient['camis_patient_bed_name']  }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {{ $patient['camis_patient_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">PAS Number</div>
                        {{ $patient['camis_patient_nhs_number'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient ID</div>
                        {{ $patient['camis_patient_id'] }}
                    </td>


                    <td class="pivoted">
                        <div class="tdBefore">Consultant</div>

                        {{ $patient['camis_consultant_name'] }} {{ $patient['camis_consultant_code_description'] }} ({{ limitText($patient['camis_consultant_specialty'], 6) }})
                    </td>
                </tr>
            @else
                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">Bay & Bed No</div>
                        {{ $patient['bed']  }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {{ $patient['name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">PAS Number</div>
                        {{ $patient['pas_number'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient ID</div>
                        {{ $patient['patient_id'] }}
                    </td>


                    <td class="pivoted">
                        <div class="tdBefore">Consultant</div>

                        {{ $patient['consultant'] }} {{ $patient['camis_consultant_code_description'] }} ({{ limitText($patient['camis_consultant_specialty'], 6) }})
                    </td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>

 </div>
@else
    <div class="No_record_css">
        {{ NotFoundMessage() }}
    </div>
@endif
