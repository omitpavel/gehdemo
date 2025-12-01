<div class="col-lg-12  ">
    <div class="row">
        <div class="col-xl-9 pe-xl-0 mb-1">
            <div class="virtual-ward-table">
                <table class="breachReasonTable responsiveTable table-task-details">
                    <thead>
                        <tr class="position-relative">
                            <th width="100">Date</th>
                            <th width="70">Escalation Status</th>
                            <th width="70">Resuscitation Status </th>
                            <th width="50">TEP</th>
                            <th width="50">Reasonable Adjustments Required</th>
                            <th width="50">Reasonable Adjustments Considered</th>
                            <th width="50">Sepsis</th>
                            <th width="50">AKI</th>
                            <th width="100">Commence Fluid Balance Monitoring</th>
                            <th width="100">Capillary Blood Glucose</th>
                            <th width="70">Working Diagnosis</th>
                            <th width="70">Review Diabetic Status</th>
                            <th width="70">Medical Plan</th>
                            <th width="70">Investigations </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_reverse($all_dates) as $key => $value)


                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore">Date</div>
                                    {{ $value['date'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Escalation Status</div>
                                    {{ $value['escalation'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Resuscitation Status</div>
                                    {{ $value['resuscitation'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">TEP</div>
                                    {{ $value['tep'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Reasonable Adjustments Required</div>
                                    {{ $value['r_a_r'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Reasonable Adjustments Considered</div>
                                    {{ $value['r_a_c'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Sepsis</div>
                                    {{ $value['sepsis'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">AKI</div>
                                    {{ $value['aki'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Commence Fluid Balance Monitoring</div>
                                    {{ $value['fluid'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Capillary Blood Glucose</div>
                                    {{ $value['blood_glucose'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Working Diagnosis</div>
                                    {{ $value['ibox'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Review Diabetic Status</div>
                                    {{ $value['diabetic'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Medical Plan</div>
                                    {{ $value['medical_plan'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Investigations </div>
                                    {{ $value['investigation'] }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xl-3 ps-xl-1">
            <div class="virtual-ward-escalation">
                <table class="breachReasonTable responsiveTable table-task-details">
                    <thead>
                        <tr class="position-relative">
                            <th width="100">Date</th>
                            <th width="90">No. of Task List Generated</th>
                            <th width="40">Escalation No</th>
                            <th width="40">Escalation Yes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_reverse($escalation_all) as $key => $value)
                            <tr>
                                <td class="pivoted">
                                    <div class="tdBefore">Date</div>
                                    {{ $value['date'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">No. of Task List Generated</div>
                                    {{ $value['escalation'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Escalation No</div>
                                    {{ $value['escalation_no'] }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Escalation Yes</div>
                                    {{ $value['escalation_yes'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
