@if(count($movement_data) > 0)
<table class="responsiveTable table-listing">
    <thead>
        <tr class="position-relative">
            <th>Patient Name</th>
            <th>Moved From</th>
            <th>Moved To</th>
            <th>Moved By</th>
            <th>Moved At</th>
        <tr>
    </thead>
    <tbody>
        @foreach($movement_data as $patient)
            <tr>
                <td class="pivoted">
                    <div class="tdBefore">Patient Name</div>
                    {{ $patient['patient_name'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Moved From</div>
                    {{ $patient['previous_area'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Moved To</div>
                    {{ $patient['current_area'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Moved By</div>
                    {{ $patient['updated_by'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Moved At</div>
                    {{ $patient['updated_at'] }}
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
