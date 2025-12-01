@if(count($success_array['patient_move_in']) > 0 || count($success_array['allowed_to_move_in_from_reserved']) > 0)

@if(count($success_array['patient_move_in']) > 0)
<div class="card-table-listing mb-2">

    <table class="breachReasonTable responsiveTable table-listing">
        <thead>
            <tr class="position-relative">

                <th>Bay & Bed No</th>

                <th>Patient Name</th>
                <th>Patient ID</th>
                <th>To Move IN From </th>
            </tr>
        </thead>
        <tbody>
            @foreach($success_array['patient_move_in'] as $allowed_to_move_patient)
            <tr>
                <td class="pivoted">
                    <div class="tdBefore">Bay & Bed No</div>
                    {{ $allowed_to_move_patient['ibox_actual_bed_full_name']  }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Patient Name</div>
                    {{ $allowed_to_move_patient['camis_patient_name'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Patient ID</div>
                    {{ $allowed_to_move_patient['camis_patient_nhs_number'] }}
                </td>


                <td class="pivoted">
                    <div class="tdBefore">To Move IN From </div>
                    {{$success_array['ward_array'][$allowed_to_move_patient['patient_allowed_to_be_moved_from']]}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

 </div>
@else
    @if(count($success_array['allowed_to_move_in_from_reserved']) < 1)
        <div class="No_record_css">
            {{ NotFoundMessage() }}
        </div>
    @endif
@endif

@if(count($success_array['allowed_to_move_in_from_reserved']) > 0)
    <div class="card-table-listing   bed-reservation">
        <div class="sub-header">
            <span>Assigned From Bed Reservation</span>
        </div>
        <table class="breachReasonTable responsiveTable table-listing">
            <thead>
                <tr class="position-relative">
                    <th>Reserved Bay & Bed</th>
                    <th>Patient ID</th>
                    <th>ED-Attendance ID</th>
                    <th>In Patient ID</th>
                    <th>Name </th>
                    <th>To Move IN From </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($success_array['allowed_to_move_in_from_reserved'] as $allowed_data)

                    <tr>
                        <td class="pivoted">
                            <div class="tdBefore">Reserved Bay & Bed</div>
                            {{ $allowed_data['patient_information_with_bed_details']['ibox_actual_bed_full_name'] ?? '' }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Patient ID</div>
                            {{ $allowed_data['reserved_for'] ?? '' }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">ED-Attendance ID</div>
                            {{ $allowed_data['reserved_data']['attendance_id'] ?? '' }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Patient ID</div>
                            {{ $allowed_data['reserved_data']['patient_id'] ?? '' }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">Name</div>
                            {{ $allowed_data['patient_name'] }}
                        </td>
                        <td class="pivoted">
                            <div class="tdBefore">To Move IN From</div>
                            @if(isset($allowed_data['patient_current_data']['ibox_ward_short_name']) && (isset($allowed_data['reserved_data']['data_source'])) && $allowed_data['reserved_data']['data_source'] == 2)
                                {{$success_array['ward_array'][$allowed_data['patient_current_data']['ibox_ward_short_name']]}}
                            @else
                                A&E
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    @if(count($success_array['patient_move_in']) < 1)
        <div class="No_record_css">
            {{ NotFoundMessage() }}
        </div>
    @endif
@endif
@else
<div class="No_record_css">
{{ NotFoundMessage() }}
</div>
@endif
