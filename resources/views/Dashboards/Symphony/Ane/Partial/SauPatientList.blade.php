

<div class="card-assigned-speciality mb-2">
    @if (count($success_array['attendance_data']) > 0)
    <table class="breachReasonTable responsiveTable table-assigned-speciality">
        <thead>
        <tr class="position-relative">

            <th>#</th>
            <th>Hospital Number</th>
            <th>Attendance ID</th>
            <th>Patient Name</th>
            <th>Registration Date</th>
            <th>Seen By</th>
            <th>Final Location</th>


        </tr><tr>
        </tr>
        </thead>
        <tbody>

        @foreach($success_array["attendance_data"] as $patient)
        <tr>
            <td class="pivoted">
                <div class="tdBefore">#</div>
               {{ $loop->iteration }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Hospital Number</div>
                {{ $patient['symphony_pas_number'] }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Attendance ID</div>
                {{ $patient['symphony_attendance_id'] }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Patient Name</div>
                {{ ucfirst(strtolower($patient['symphony_patient_name']))  }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Registration Date</div>
                {{ PredefinedDateFormatFor24Hour($patient['symphony_registration_date_time']) }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Seen By</div>
                {{ $patient['symphony_seen_by'] }}
            </td>
            <td class="pivoted">
                <div class="tdBefore">Final Location</div>
                {{ $patient['symphony_final_location'] }}
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
