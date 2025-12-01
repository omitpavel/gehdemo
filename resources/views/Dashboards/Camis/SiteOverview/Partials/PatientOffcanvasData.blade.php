@if(count($ward_wise_patient) > 0)



    @foreach ($ward_wise_patient as $ward_name => $patient_list)
        <div class="card-table-listing  mb-lg-2">
            <div class="sub-header">
                <span>{{ $ward_name }}</span>
                <span>{{ count($patient_list) }}</span>
            </div>
            <table class="breachReasonTable responsiveTable table-listing">
                <thead>
                    <tr class="position-relative">
                        <th>Bay & Bed</th>
                        <th>Hospital Number</th>
                        <th>Patient Name</th>
                        <th>Med Fit</th>
                        <th>LOS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patient_list as $patient)

                        <tr>
                            <td class="pivoted">
                                <div class="tdBefore">Bay & Bed</div>
                                {{ $patient['ibox_actual_bed_full_name'] }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Hospital Number</div>
                                {{ $patient['camis_patient_pas_number'] }}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Patient Name</div>
                                {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">Med Fit</div>
                                {{ @$patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'YES' : 'No' }} @if(isset($patient['board_round_medically_fit_data']['updated_at']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)- {{ PredefinedDateFormatWithoutYear($patient['board_round_medically_fit_data']['updated_at']) }} @endif
                            </td>
                            <td class="pivoted">
                                <div class="tdBefore">LOS</div>
                                {{ PatientLos($patient['camis_patient_admission_date_time']) }}
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

