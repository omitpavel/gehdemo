<div class="card-table-listing patients-discharge">
    @if(count($patient_list) > 0)
        <table class="responsiveTable table-listing cdt_in_patient_offcanvas_export">
            <thead>
                <tr class="position-relative">
                    <th>Ward Name</th>
                    <th>Bay & Bed</th>
                    <th>Hospital Number</th>
                    <th>Patient Name</th>
                    <th>Med Fit</th>
                    <th>LOS</th>
                    <th>Pathway</th>
                    <th>Reason Code</th>
                </tr>
            </thead>
            <tbody>
                @php
                    usort($patient_list, function ($a, $b) {
                        return strcmp($a['ward_name'], $b['ward_name']);
                    });
                @endphp
                @foreach ($patient_list as $patient)
                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">Ward Name</div>
                        {{ $patient['ward_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Bay & Bed</div>
                        {{ $patient['bed_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Hospital Number</div>
                        {{ $patient['pas_id'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {{ $patient['patient_name'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Med Fit</div>
                        {{ $patient['medfit'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">LOS</div>
                        {{ $patient['los'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Pathway</div>
                        {{ $patient['pathway'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Reason Code</div>
                        {{ $patient['reason'] }}
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>
    @else
        <div class="custom_not_found">{{ NotFoundMessage() }}</div>
    @endif
</div>
