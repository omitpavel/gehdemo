@if (!empty($success_array['patient_list_with_pending_task']))

    <table class="responsiveTable table-custom">
    <thead>
        <tr class="position-relative">
        <th>Name</th>
        <th>Hospital Number</th>
        <th>Ward</th>
        <th>Bay &amp; Bed</th>
        <th>Delay Days</th>
        <th>Created Date</th>
        <th>Red Reason</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($success_array['patient_list_with_pending_task'] as $patient_data)

            <tr>
                <td class="pivoted">
                    <div class="tdBefore">Name</div>
                    {{ $patient_data['patient_name'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Hospital Number</div>
                    {{ $patient_data['patient_pas_number'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Ward</div>
                    {{ $patient_data['patient_ward'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Bay &amp; Bed</div>
                    {{ $patient_data['patient_bed'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Delay Days</div>
                    {{ $patient_data['patient_delay_time'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Created Date</div>
                    {{ $patient_data['reason_created_time'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Red Reason</div>
                    {{ $patient_data['patient_reason'] }}
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
@else
    <div class="custom_not_found">
        {{ NotFoundMessage() }}
    </div>
@endif
