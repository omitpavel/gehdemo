<link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />

<div class="row mb-3">
    <div class="container-fluid">
        <div class="col-lg-12  ">
            <div class="row gx-2 mb-2">
                <div class="col-xl-3 col-lg-4">
                    <div class="card-date">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="cyan-circle text-center me-2">
                                    <i class="bi bi-calendar3 "></i>
                                </div>
                                <div class="date-box w-90">
                                    <input type="hidden" value="{{ $success_array['filter_value_selected'] }}" class="breach_tab_1_date_selected" id="breach_tab_1_date_selected">
                                    <input  type="text"  name="datepicker"  class="datepickerInput" id="datepick2" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="breach-reason-table">
                <div>
                    <table class="breachReasonTable responsiveTable table-breach">
                        <thead>
                            <tr>
                                <th class="text-center column_row_id">#</th>
                                <th class="text-center">Attendance ID</th>
                                <th class="text-center">PAS Number</th>
                                <th class="text-center column_patient_name">Patient Name</th>
                                <th class="text-center">First Location</th>
                                <th class="text-center column_breach_dates">Registration DT</th>
                                <th class="text-center column_breach_dates">Triage DT</th>
                                <th class="text-center column_breach_dates hide-on-smaller-width">Consultant Seen Time</th>
                                <th class="text-center">Discharge DT</th>
                                <th class="text-center">Duration (Mins)</th>
                                <th class="text-center hide-on-smaller-width">Processing Complaint</th>
                                <th class="text-center">Discharge Outcome</th>
                                <th class="text-center column_breach_reason">Breach Reason</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if (count($success_array['breach_record_array']))
                                @foreach ($success_array['breach_record_array'] as $row)
                                    {!! Form::hidden('breach_reason_previous_attendence_id_' . $row['attendance_id'], $row['prev_attendance_number'], ['id' => 'breach_reason_previous_attendence_id_' . $row['attendance_id']]) !!}
                                    {!! Form::hidden('breach_reason_next_attendence_id_' . $row['attendance_id'], $row['next_attendance_number'], ['id' => 'breach_reason_next_attendence_id_' . $row['attendance_id']]) !!}
                                    <tr class="breach-row-data-tr-{{ $row['attendance_id'] }} @if ($row['breach_reason_name'] != '') breach-reason-added-row @endif ">
                                        <td class="pivoted">
                                            <div class="tdBefore">Row ID</div>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Attendance ID</div>
                                            {{ $row['attendance_id'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Pas Number</div>
                                            {{ $row['pas_number'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Patient Name</div>
                                            {!! SymphonyPatientGender($row['patient_sex'], $row['patient_name']) !!}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">First Location</div>
                                            {{ $row['first_location'] }}
                                        </td>
                                        <td class="pivoted text-center">
                                            <div class="tdBefore">Registration Date Time</div>
                                            {{ $row['registration_date'] }}
                                        </td>
                                        <td class="pivoted text-center">
                                            <div class="tdBefore">Triage Date Time</div>
                                            {{ $row['triage_date'] }}
                                        </td>
                                        <td class="pivoted hide-on-smaller-width text-center">
                                            <div class="tdBefore ">Consultant Seen Time</div>
                                            {{ $row['consultant_seen_time'] }}
                                        </td>
                                        <td class="pivoted text-center">
                                            <div class="tdBefore">Left Department</div>
                                            {{ $row['left_department'] }}
                                        </td>
                                        <td class="pivoted  text-center">
                                            <div class="tdBefore">In Department</div>
                                            {{ $row['minutes_in_department'] }} Min
                                        </td>
                                        <td class="pivoted  hide-on-smaller-width">
                                            <div class="tdBefore">Processing Complaint</div>
                                            {{ $row['processing_complaint'] }}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Discharge Outcome</div>
                                            {{ $row['discharge_outcome'] }}
                                        </td>
                                        <td @if (CheckSpecificPermission('add_breach_reason_popup_view')) class="pivoted  add_update_breach_reason " @else class="pivoted" onclick="CommonLoginModalPopupOpenOnRequest();" @endif data-patient-attendance-id="{{ $row['attendance_id'] }}">
                                            <div class="tdBefore">Breach Reason</div>
                                            <div class="breach_reason_show_data_column_row breach_reason_show_data_column_{{ $row['attendance_id'] }}" style="cursor: pointer;">
                                                @if ($row['breach_reason_name'] == '')
                                                    Add Reason
                                                @else
                                                    <div class="data-breach-reason">
                                                        <div class="reason">
                                                            {{ $row['breach_reason_name'] }} <br>
                                                            {{ $row['breach_reason_updated_user_name'] }}
                                                            ({{ $row['breach_reason_updated_at'] }})
                                                        </div>
                                                        <div class="icon-lock">
                                                            <img src="{{ asset('asset_v2/Ibox') }}/icons/lock-black.svg" alt="">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="message-no-data-row">
                                    <td colspan="15" class='full_width_ibox message-no-data' style="text-align: center;">
                                        <span clas5="nodataMessage">{{ NotFoundMessage() }}</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<button class="d-none breach_reason_dashboard_search"></div>
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
    $(function() {

        @if(!empty($success_array['filter_value_selected']))
            var start = moment('{{$success_array['filter_value_selected']}}', 'YYYY-MM-DD');
        @else
            var start = moment().endOf('day');
        @endif

    function cb(start) {
        $('#datepick2').val(start.format('MMMM D, YYYY'));
        $('#breach_tab_1_date_selected').val(start.format('ddd MMMM D, YYYY'));
        if(start.format('YYYY-MM-DD') != '{{$success_array['filter_value_selected']}}'){
            $(".breach_reason_dashboard_search").click();
        }
    }


        $('input[name="datepicker"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        startDate: start,
        maxDate: moment().endOf('day'),
        locale: {
            format: 'ddd MMMM D, YYYY'
        }
        }, cb);



    });
</script>
