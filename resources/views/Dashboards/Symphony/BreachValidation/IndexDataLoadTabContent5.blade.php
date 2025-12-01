<div class="row mb-3">
    <div class="container-fluid">
        <div class="col-lg-12  ">
            <div class="row gx-2">
                <div class="col-xl-2 mb-2">
                    <div class="">
                        <select class="form-select w-100" aria-label="Default select example" name="date_picker_tab_4" id="date_picker_tab_4">
                            <option selected>Months</option>
                            @if (count($success_array['month_filter_array']))
                                @foreach ($success_array['month_filter_array'] as $key => $row)
                                    <option value="{{ $row['filter_value'] }}" @if ($row['filter_value'] == $success_array['filter_value_selected']) selected @endif>
                                        {{ $row['filter_text'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                </div>

            </div>
            <div class="breach-month-data">
                <table class="breachReasonTable responsiveTable table-breach">
                    <thead>
                    <tr>
                        <th class="text-center">Registration Date</th>
                        <th class="text-center">Less Than 1 Hour</th>
                        <th class="text-center">1 To 2 Hours</th>
                        <th class="text-center">2 To 3 Hours</th>
                        <th class="text-center">3 To 4 Hours</th>
                        <th class="text-center">Greater Than 4 Hours</th>
                        <th class="text-center">Total Attendances</th>
                        <th class="text-center">Total Discharges</th>
                        <th class="text-center">Total Breaches</th>
                        <th class="text-center">Performance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($success_array['month_overall_summary_array']))
                            @foreach ($success_array['month_overall_summary_array'] as $key => $row)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">Registration Date</div>
                                        {{ $row['date'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Less Than 1 Hour</div>
                                        {{ $row['symphony_attendance_less_than_one_hour'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">1 To 2 Hours</div>
                                        {{ $row['symphony_attendance_one_to_two_hour'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">2 To 3 Hours</div>
                                        {{ $row['symphony_attendance_two_to_three_hour'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">3 To 4 Hours</div>
                                        {{ $row['symphony_attendance_three_to_four_hour'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Greater Than 4 Hours</div>
                                        {{ $row['symphony_attendance_four_hours_plus'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Total Attendances</div>
                                        {{ $row['symphony_attendance'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Total Discharges </div>
                                        {{ $row['symphony_discharged'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Total Breaches </div>
                                        {{ $row['symphony_breached'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Performance</div>
                                        {{number_format($row['symphony_breached_performance'],2) }} %
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore">Total</div>
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Less Than 1 Hour</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_attendance_less_than_one_hour'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">1 To 2 Hours</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_attendance_one_to_two_hour'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">2 To 3 Hours</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_attendance_two_to_three_hour'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">3 To 4 Hours</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_attendance_three_to_four_hour'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Greater Than 4 Hours</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_attendance_four_hours_plus'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Total Attendances</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_attendance'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Total Discharges</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_discharged'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Total Breaches</div>
                                    {{ $success_array['month_overall_summary_array_total']['symphony_breached'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Performance</div>
                                    {{ number_format($success_array['month_overall_summary_array_total']['symphony_breached_performance'],2) }} %
                                </td>
                            </tr>
                    @endif


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
