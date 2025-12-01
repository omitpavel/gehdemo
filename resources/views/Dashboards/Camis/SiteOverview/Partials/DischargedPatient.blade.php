

@if(count($ward_wise_patient) > 0)



    @foreach ($ward_wise_patient as $ward_name => $patient_list)
        <div class="card-table-listing   bed-reservation mb-2">
            <div class="sub-header">
                <span>{{ $ward_name }}</span>
            </div>
            <table class="breachReasonTable responsiveTable table-listing">
                <thead>
                    <tr class="position-relative">
                        <th>Hospital Number</th>
                        <th>Patient Name</th>
                        <th>LOS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patient_list as $patient)
                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">Hospital Number</div>
                                {{ $patient['patient_information']['camis_patient_pas_number'] }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Patient Name</div>
                                {!! CamisPatientGender($patient['patient_information']['camis_patient_sex'], $patient['patient_information']['camis_patient_name']) !!}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">LOS</div>
                                {{ PatientLos($patient['patient_information']['camis_patient_admission_date_time'],$patient['patient_information']['camis_patient_discharge_date_time']) }}
                                                                        Days
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

@else
    <div class="custom_not_found">{{ NotFoundMessage() }}</div>

@endif

