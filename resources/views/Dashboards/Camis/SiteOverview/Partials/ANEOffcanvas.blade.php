@if(count($data) > 0)
    <table class="responsiveTable table-listing">
        <thead>
            <tr class="position-relative">
                <th>Hospital Number</th>
                <th>Attendance ID</th>
                <th>Patient Name</th>
                <th>Resgistraion Date</th>
                <th>Seen Date/Time</th>
                <th>Seen By</th>
                <th>Final Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $patient)
                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">Hospital Number</div>
                        {{ $patient['pass_id'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Attendance ID</div>
                        {{ $patient['attendance_id'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {{ $patient['patient_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Resgistraion Date</div>
                        {{ $patient['registration_date'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Seen Date/Time</div>
                        {{ $patient['seen_by_datetime'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Seen By</div>
                        {{ $patient['seen_by'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Final Location</div>
                        {{ $patient['final_location'] }}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
@else
    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
@endif
