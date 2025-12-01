@if(count($ward_wise_patient) > 0)



    @foreach ($ward_wise_patient as $ward_name => $patient_list)
        <div class="card-table-listing mb-lg-2">
            <div class="sub-header">
                <span>{{ $ward_name }}</span>
                <span>{{ count($patient_list) }}</span>
            </div>
            <table class="breachReasonTable responsiveTable table-listing">
                <thead>
                    <tr class="position-relative">
                        <th>Bay & Bed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patient_list as $patient)

                        <tr>

                            <td class="pivoted">
                                <div class="tdBefore">Bay & Bed</div>
                                {{ $patient['ibox_actual_bed_full_name'] }}
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






