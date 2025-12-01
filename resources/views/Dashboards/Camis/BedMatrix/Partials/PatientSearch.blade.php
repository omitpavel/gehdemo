@if(count($success_array['patient_list']) > 0)
    <table class="breachReasonTable responsiveTable table-bed-patients">
        <thead>
            <tr class="position-relative">
                <th>Patient ID</th>
                <th>ED - Attendance ID</th>
                <th>Inpatient ID</th>
                <th>In ED Now</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($success_array['patient_list'] as $patient)


                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">Hospital Number</div>
                        {{ $patient['pas_number'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">ED - Attendance ID</div>
                        {{ $patient['attendance_id'] ?? '--' }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Inpatient ID</div>
                        {{ $patient['patient_id'] ?? '--' }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">In ED Now</div>
                        @if($patient['data_source'] == 1)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">First Name</div>
                        {{ $patient['surname'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Last Name</div>
                        {{ $patient['forname'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore"></div>
                        <button class="btn btn-primary-grey select_patient_pas" onclick="SelectPatient(this)" value="{{ $patient['pas_number'] }}">Select </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
<div class="custom_not_found" >
    {{ NotFoundMessage() }}
</div>
@endforelse
