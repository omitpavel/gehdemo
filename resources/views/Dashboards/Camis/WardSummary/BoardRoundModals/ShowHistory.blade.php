<div class="card-history mb-2" >

    <table class="breachReasonTable responsiveTable table-history">
        <thead>
            <tr class="position-relative">
                <th>DATA ENTERED</th>
                <th>UPDATE</th>
                <th>DATE & TIME</th>
                <th>USER</th>
                <th>WARD</th>
                <th>BAY & BED</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>

           @forelse($success_array['governance_data'] as $gov_data)
                <tr>
                    <td class="pivoted">
                        <div class="tdBefore">DATA ENTERED</div>
                        {{$gov_data['gov_func_identity']}}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore"> TBC</div>
                        {{$gov_data['gov_description']}}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">DATE & TIME</div>
                        {{PredefinedDateFormatFor24Hour($gov_data['created_at'])}}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">USER</div>
                        {{$gov_data['gov_user_username']}}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">WARD</div>
                          {{$gov_data['gov_patient_ward_name']}}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">BAY & BED</div>
                        {{$gov_data['gov_patient_ibox_bed_actual_name']}}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">STATUS</div>
                        @if($gov_data['gov_updation_status'] == 1)
                            Insert
                        @elseif($gov_data['gov_updation_status'] == 2)
                            Update
                        @elseif($gov_data['gov_updation_status'] == 3)
                            Delete
                        @else
                            Undefined
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="popup_history_table_td_style" colspan="7">
                        {{ NotFoundMessage() }}
                    </td>

                </tr>
            @endforelse
        </tbody>
    </table>
</div>



