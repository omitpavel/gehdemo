

<div class="card-assigned-speciality mb-2">
    @if (count($success_array['assigned_specialities']) > 0)
    <table class="breachReasonTable responsiveTable @if(request()->type == 'speciality') table-assigned-speciality @else table-ane-patients-data @endif">
        <thead>
        <tr class="position-relative">

            <th>#</th>
            <th>Hospital Number</th>
            @if(request()->type == 'speciality')
                <th>Speciality Referral Date/Time</th>
                <th>DTA Date/Time </th>
            @else
                <th>Attendance ID</th>
            @endif
            <th>Patient Name</th>
            <th>Registration Date</th>
            <th>Seen By Date/Time </th>
            <th>Seen By</th>
            <th>Final Location</th>


        </tr><tr>
        </tr>
        </thead>
        <tbody>

        @foreach($success_array["assigned_specialities"] as $speacitly)
        <tr>
            <td class="pivoted">
                <div class="tdBefore">#</div>
               {{ $loop->iteration }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Hospital Number</div>
                {{ $speacitly['symphony_pas_number'] }}
            </td>
            @if(request()->type == 'speciality')
                <td class="pivoted">
                    <div class="tdBefore">Speciality Referral Date/Time</div>

                    {{ PredefinedDateFormatFor24Hour($speacitly['symphony_refferal_date']) }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">DTA Date/Time </div>
                    {{ PredefinedDateFormatFor24Hour($speacitly['symphony_request_date']) }}
                </td>
            @else
            <td class="pivoted">
                <div class="tdBefore">Attendance ID</div>

                {{ $speacitly['symphony_attendance_id'] }}
            </td>

            @endif
            <td class="pivoted">
                <div class="tdBefore">Patient Name</div>
                {{ ucfirst(strtolower($speacitly['symphony_patient_name']))  }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Registration Date</div>
                {{ PredefinedDateFormatFor24Hour($speacitly['symphony_registration_date_time']) }}
            </td>

            <td class="pivoted">
                <div class="tdBefore">Seen By Date/Time</div>
                {{ !empty($speacitly['symphony_seen_date']) ? PredefinedDateFormatFor24Hour($speacitly['symphony_seen_date']) : PredefinedDateFormatFor24Hour(CurrentDateOnFormat()) }}

            </td>
            <td class="pivoted">
                <div class="tdBefore">Seen By</div>
                {{ $speacitly['symphony_seen_by'] }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Final Location</div>
                {{ $speacitly['symphony_final_location'] }}
            </td>


        </tr>
        @endforeach

        </tbody>
    </table>
    @else
        <div class="work-plan-wrapper No_record_css">
            <div class="work-plan mb-2">
                <h6>No Records Found!</h6>

            </div>
        </div>
    @endif
</div>
