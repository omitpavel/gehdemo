@if(count($task_list) > 0)
<table class="breachReasonTable responsiveTable table-listing">
    <thead>
        <tr class="position-relative">

            <th>Display Time</th>
            <th>Ward</th>
            <th>System Name</th>
            <th>Status</th>
            <th>Description </th>
            <th>Consultant</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($task_list as $task)
            <tr>
                <td class="pivoted">
                    <div class="tdBefore">Display Time</div>
                    {{ PredefinedDateFormatFor24Hour($task['display_date_time']) }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Ward</div>
                    {{ $task['requesting_location_description'] }}
                </td>

                <td class="pivoted">
                    <div class="tdBefore">System Name</div>
                    {{ $task['system_name'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Status</div>
                    {{ $task['order_item_filler_status_description'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Description</div>
                    {{ $task['order_item_type_description'] }}
                </td>
                <td class="pivoted">
                    <div class="tdBefore">Consultant</div>
                    {{ $task['requested_for_clinician_name'] }}
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
@else
<div class="No_record_css">
    {{ NotFoundMessage() }}
</div>
@endif
