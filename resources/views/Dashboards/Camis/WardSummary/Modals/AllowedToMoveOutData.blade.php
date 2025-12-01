@if(count($success_array['patient_move_out']) > 0)
    <div class="card-table-listing " id="allowed_to_move_out_details_insert">
        <table class="breachReasonTable responsiveTable table-listing">
            <thead>
                <tr class="position-relative">
                    <th>Bay & Bed No</th>

                    <th>Patient Name</th>
                    <th>Patient ID</th>
                    <th>To Move OUT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($success_array['patient_move_out'] as $allowed_to_move_patient)
                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">Bay & Bed No</div>
                        {{ $allowed_to_move_patient['patient_information_with_bed_details']['ibox_actual_bed_full_name']  }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {{ $allowed_to_move_patient['patient_information_with_bed_details']['camis_patient_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient ID</div>
                        {{ $allowed_to_move_patient['patient_information_with_bed_details']['camis_patient_nhs_number'] }}
                    </td>



                    <td class="pivoted">
                        <div class="tdBefore">To Move OUT</div>
                        {{$success_array['ward_array'][$allowed_to_move_patient['patient_allowed_to_be_moved_to']]}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="No_record_css">
        {{ NotFoundMessage() }}
    </div>
@endif
