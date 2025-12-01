<input type="hidden" name="board_symphony_search_attendance_number_current" id="board_symphony_search_attendance_number_current" value="{{$all_data_array['current_attendence_number']}}" >
<input type="hidden" name="board_symphony_search_attendance_number_next" id="board_symphony_search_attendance_number_next" value="{{$all_data_array['next_attendence_number']}}" >
<input type="hidden" name="board_symphony_search_attendance_number_prev" id="board_symphony_search_attendance_number_prev" value="{{$all_data_array['previous_attendence_number']}}" >


@if(isset($all_data_array["symphony_data_patient_details"]->name))
    @if($all_data_array["symphony_data_patient_details"]->name != "")
        <div class="row">
            <div class="col-12">
                <div class="card-shadow patient-details-card">
                    <div class="rectangle-block-1 mb-2">
                        <div class="blue-rectangle-block ">
                            <h6 class="mb-0">PATIENT DETAILS</h6>
                        </div>
                        <div>
                            <table class="breachReasonTable responsiveTable table-discharge-details">
                                <thead>
                                <tr class="position-relative">
                                    <th>Patient Name</th>
                                    <th>Gender</th>
                                    <th>Dob</th>
                                    <th>Age</th>
                                    <th>Address</th>
                                </tr>
                                </thead>
                                <tbody class="details-patient">
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">Patient Name</div>
                                        {{$all_data_array["symphony_data_patient_details"]->name}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Gender</div>
                                        {{$all_data_array["symphony_data_patient_details"]->gender}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Dob</div>
                                        @if(isset($all_data_array["symphony_data_patient_details"]->pat_dob)) @if($all_data_array["symphony_data_patient_details"]->pat_dob != ""){{ PredefinedDateFormatShowOnCalendarWithoutDay($all_data_array["symphony_data_patient_details"]->pat_dob)}}@endif @endif
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Age</div>
                                        {{$all_data_array["symphony_data_patient_details"]->age}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Address</div>
                                        {{$all_data_array["symphony_data_patient_details"]->address}}
                                    </td>
                                </tr>
                                </tbody>
                                <thead>
                                <tr class="position-relative">
                                    <th>Hospital Number</th>
                                    <th>NHS Number</th>
                                    <th>Home Tel</th>
                                    <th>Mobile Tel</th>
                                    <th>GP Details</th>
                                </tr>
                                </thead>
                                <tbody class="details-hospital">
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">Hospital Number</div>
                                        {{$all_data_array["symphony_data_patient_details"]->hospital_num}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">NHS Number</div>
                                        {{$all_data_array["symphony_data_patient_details"]->nhs_number}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Home Tel</div>
                                        {{$all_data_array["symphony_data_patient_details"]->tel_home}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Mobile Tel</div>
                                        {{$all_data_array["symphony_data_patient_details"]->tel_mobile}}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">GP Details</div>
                                        {{$all_data_array["symphony_data_patient_details"]->gp_name}}, {{$all_data_array["symphony_data_patient_details"]->gp_address}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($all_data_array["symphony_data_attendance_detail"]))
                <div class="col-12">
                    <div class="card-shadow attendance-details">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">ATTENDANCE DETAILS</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Presenting Complaint</th>
                                        <th>Chief Complaint</th>
                                        <th>Arrival Date / Time</th>
                                        <th>Arrival Mode</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="pivoted">
                                            <div class="tdBefore">Presenting Complaint</div>
                                            {{$all_data_array["symphony_data_attendance_detail"]->presenting_complaints}}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Chief Complaint</div>
                                            {{$all_data_array["symphony_data_attendance_detail"]->chief_complaints}}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Arrival Date / Time</div>
                                            {{PredefinedDateFormatFor24Hour($all_data_array["symphony_data_attendance_detail"]->atd_arrivaldate)}}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Arrival Mode</div>
                                            {{$all_data_array["symphony_data_attendance_detail"]->arrival_mode}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Discharge Date / Time</th>
                                        <th>Discharge Outcome</th>
                                        <th>Discharge Destination</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="pivoted">
                                            <div class="tdBefore">Discharge Date / Time</div>
                                            @if($all_data_array["symphony_data_attendance_detail"]->dischdate != "") {{PredefinedDateFormatFor24Hour($all_data_array["symphony_data_attendance_detail"]->dischdate)}} @endif
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Discharge Outcome</div>
                                            {{$all_data_array["symphony_data_attendance_detail"]->Discharge_outcome}}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Discharge Destination</div>
                                            {{$all_data_array["symphony_data_attendance_detail"]->discharge_destination}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if((isset($all_data_array["allergies_str"]) && $all_data_array["allergies_str"] != "") ||
            (isset($all_data_array["special_cases_str"]) && $all_data_array["special_cases_str"] != ""))
                <div class="col-12">
                    <div class="card-shadow alerts">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">ALERTS</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Allergies</th>

                                        <th>Special Cases</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="pivoted">
                                            <div class="tdBefore">Allergies</div>
                                            {{ isset($all_data_array["allergies_str"]) ? $all_data_array["allergies_str"] : ""  }}
                                        </td>

                                        <td class="pivoted">
                                            <div class="tdBefore">Special Cases</div>
                                            {{ isset($all_data_array["special_cases_str"]) ? $all_data_array["special_cases_str"] : '' }}
                                        </td>
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_linked_attendance_data"]) && count($all_data_array["symphony_data_linked_attendance_data"])>0)
                <div class="col-12">
                    <div class="card-shadow linked-attendance-details">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">LINKED ATTENDANCE DETAILS</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Presenting Complaint</th>
                                        <th>Cheif Complaint</th>
                                        <th>Arrival Date\Time</th>
                                        <th>Arrival Mode</th>
                                        <th>Care Group</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($all_data_array["symphony_data_linked_attendance_data"] as $linked_data)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Presenting Complaint</div>
                                                {{ $linked_data['l_complaint'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Cheif Complaint</div>
                                                {{ $linked_data['l_chief_complaints'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Arrival Date\Time</div>
                                                {{ PredefinedDateFormatFor24Hour($linked_data['l_atd_arrivaldate']) }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Arrival Mode</div>
                                                {{ $linked_data['l_arrival_mode'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Care Group</div>
                                                {{ $linked_data['l_caregroup'] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_triage_data"]) && count($all_data_array["symphony_data_triage_data"])>0)
                <div class="col-12">
                    <div class="card-shadow triage-table">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">TRIAGE</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Date</th>
                                        <th>Complaint Att Reason</th>
                                        <th>Triage Cat</th>
                                        <th>Pain Score</th>
                                        <th>Treatments</th>
                                        <th>Triage Comment</th>
                                        <th>Abroad Lately</th>
                                        <th>Destination Returned</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($all_data_array["symphony_data_triage_data"] as $triage)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Date</div>
                                                {{ PredefinedDateFormatShowOnCalendarWithoutDay(str_replace('/', '-', $triage['tri_date'])) }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Complaint Att Reason</div>
                                                {{ $triage['tri_complaint'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Triage Cat</div>
                                                {{ $triage['tri_category'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Pain Score</div>
                                                {{ $triage['pain_score'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Treatments</div>
                                                {{ $triage['treatments'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Triage Comment</div>
                                                {{ $triage['tri_comments'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Abroad Lately</div>
                                                {{ $triage['abroad_lately'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Destination Returned</div>
                                                {{ $triage['discharge_destination'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_management_plan"]) && count($all_data_array["symphony_data_management_plan"])>0)
                <div class="col-12">
                    <div class="card-shadow management-plan">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">MANAGEMENT PLAN</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Date</th>
                                        <th>Diagnosis</th>
                                        <th>Moderator</th>
                                        <th>Diagnosis Comment</th>
                                        <th>ED/EA</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($all_data_array["symphony_data_management_plan"] as $plan)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Date</div>
                                                {{ PredefinedDateFormatShowOnCalendarWithoutDay(str_replace('/', '-', $plan['diagnosis_date'])) }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Diagnosis</div>
                                                {{ $plan['diagnosis'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Moderator</div>
                                                {{ str_replace('/', '-', $plan['dagnosis_moderator']) }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Diagnosis Comment</div>
                                                {{ $plan['diagnosis_comment'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">ED/EA</div>
                                                {{ $plan['atd_num'] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_refferal"]) && count($all_data_array["symphony_data_refferal"])>0)
                <div class="col-12">
                    <div class="card-shadow refferal">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">REFERRALS</h6>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 pe-lg-0">
                                    <div class="bg-header-grey">
                                        <span>REFERRALS REQUEST</span>
                                    </div>
                                    <div>
                                        <table class="breachReasonTable responsiveTable table-discharge-details">
                                            <thead>
                                            <tr class="position-relative">
                                                <th>Date/Time</th>
                                                <th>Specialty</th>
                                                <th>Comments</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_data_array["symphony_data_refferal"] as $row)
                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Date/Time</div>
                                                        {{PredefinedDateFormatShowOnCalendarWithoutDay(str_replace('/', '-', $row->request_date))}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Specialty</div>
                                                        {{$row->request_value}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Comments</div>
                                                        {{$row->request_value}}
                                                    </td>
                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 ps-lg-0 outcome-section">
                                    <div class="bg-header-grey">
                                        <span>REFERRALS OUTCOME</span>
                                    </div>
                                    <div>
                                        <table class="breachReasonTable responsiveTable table-discharge-details">
                                            <thead>
                                            <tr class="position-relative">
                                                <th>Date/Time</th>
                                                <th>Specialty</th>
                                                <th>Additional Information</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_data_array["symphony_data_refferal"] as $row)
                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Date/Time</div>
                                                        {{PredefinedDateFormatShowOnCalendarWithoutDay(str_replace('/', '-', $row->refferal_outcome_dt))}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Specialty</div>
                                                        {{$row->refferal_speciality}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Additional Information</div>
                                                        {{$row->aditional_info}}
                                                    </td>
                                                </tr>

                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_clinician_seen"]) && count($all_data_array["symphony_data_clinician_seen"])>0)
                <div class="col-12">
                    <div class="card-shadow clinician">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">CLINICIAN'S SEEN</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Date / Time</th>
                                        <th>DEP Name</th>
                                        <th>Clinician Seen</th>
                                        <th>Grade</th>
                                        <th>ED/EA</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $all_data_array["symphony_data_clinician_seen"] as $clinician_seen)

                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Date / Time</div>
                                                {{PredefinedDateFormatShowOnCalendarWithoutDay(str_replace('/', '-', $clinician_seen['clinician_date']))}}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">DEP Name</div>
                                                {{  $clinician_seen['depname']  }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Clinician Seen</div>
                                                {{  $clinician_seen['clinicianname']  }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Grade</div>
                                                {{  $clinician_seen['grade']  }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">ED/EA</div>
                                                {{  $clinician_seen['atd_num']  }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_e_notes"]) && count($all_data_array["symphony_data_e_notes"])>0)
                <div class="col-12">
                    <div class="card-shadow notes-table">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">E - NOTES</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Date / Time Created</th>
                                        <th>Assessment</th>
                                        <th>Note</th>
                                        <th>Created By</th>
                                        <th>ED/EA</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($all_data_array["symphony_data_e_notes"] as $row)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore ">Date / Time Created</div>
                                                {{PredefinedDateFormatFor24Hour(str_replace('/', '-', $row->e_note_date))}}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore ">Assessment</div>
                                                {{$row->Assesment}}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore ">Note</div>
                                                {{$row->Notes}}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore ">Created By</div>
                                                {{$row->notes_created_by}}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore ">ED/EA</div>
                                                {{$row->atd_num}}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_ae_treatment"]) && count($all_data_array["symphony_data_ae_treatment"])>0)
                <div class="col-12">
                    <div class="card-shadow treatment-section">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">TREATMENTS</h6>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 pe-lg-0">
                                    <div class="bg-header-grey">
                                        <span>TREATMENT REQUEST</span>
                                    </div>
                                    <div>
                                        <table class="breachReasonTable responsiveTable table-discharge-details">
                                            <thead>
                                            <tr class="position-relative">
                                                <th>Date/Time</th>
                                                <th>Treatments</th>
                                                <th>Comments</th>
                                                <th>No. Sutures</th>
                                                <th>Days</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_data_array["symphony_data_ae_treatment"] as $row)
                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Date / Time</div>
                                                        {{ PredefinedDateFormatFor24Hour(str_replace('/', '-', $row->treatment_reqdate)) }}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Treatments</div>
                                                        {{$row->Treatments}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Comments</div>
                                                        {{$row->treatment_comments}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">No. Sutures</div>
                                                        {{$row->no_sutures}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Days</div>
                                                        {{$row->days}}
                                                    </td>
                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 ps-lg-0 outcome-section">
                                    <div class="bg-header-grey">
                                        <span>TREATMENT OUTCOME</span>
                                    </div>
                                    <div>
                                        <table class="breachReasonTable responsiveTable table-discharge-details">
                                            <thead>
                                            <tr class="position-relative">

                                                <th>Date</th>
                                                <th>Outcome</th>
                                                <th>Comments</th>
                                                <th>ED/EA</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_data_array["symphony_data_ae_treatment"] as $row)
                                                <tr>


                                                    <td class="pivoted">
                                                        <div class="tdBefore">Date</div>
                                                        {{$row->result_date}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Outcome</div>
                                                        {{$row->treat_outcome}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Comments</div>
                                                        {{$row->comment}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">ED/EA</div>
                                                        {{$row->atd_num}}
                                                    </td>
                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_ae_investigation"]) && count($all_data_array["symphony_data_ae_investigation"])>0)
                <div class="col-12">
                    <div class="card-shadow investigations">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">A&amp;E INVESTIGATIONS</h6>
                            </div>
                            <div>
                                <table class="breachReasonTable responsiveTable table-discharge-details">
                                    <thead>
                                    <tr class="position-relative">
                                        <th>Date / Time</th>
                                        <th>Investigations</th>
                                        <th>Comments</th>
                                        <th>ED/EA</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($all_data_array["symphony_data_ae_investigation"] as $investigation)
                                        <tr>
                                            <td class="pivoted">
                                                <div class="tdBefore">Date / Time</div>
                                                {{ str_replace('/', '-', $investigation['investigation_date']) }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Investigations</div>
                                                {{ $investigation['investigation'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">Comments</div>
                                                {{ $investigation['investigation_comment'] }}

                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">ED/EA</div>
                                                {{ $investigation['atd_num'] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($all_data_array["symphony_data_ice_details"]) && count($all_data_array["symphony_data_ice_details"])>0)
                <div class="col-12">
                    <div class="card-shadow ice-order-section">
                        <div class="rectangle-block-1 mb-2">
                            <div class="blue-rectangle-block ">
                                <h6 class="mb-0">ICE ORDERS</h6>
                            </div>
                            <div class="row ">
                                <div class="col-lg-6 pe-lg-0">
                                    <div class="bg-header-grey">
                                        <span>ICE REQUEST</span>
                                    </div>
                                    <div>
                                        <table class="breachReasonTable responsiveTable table-discharge-details">
                                            <thead>
                                            <tr class="position-relative">
                                                <th>Date/Time</th>
                                                <th>Examination</th>
                                                <th>Comment</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_data_array["symphony_data_ice_details"] as $row)
                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Date / Time</div>
                                                        {{date("jS M Y", strtotime($row->ice_req_date))}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Examination</div>
                                                        {{$row->ice_examination}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Comments</div>
                                                        {{$row->ice_comments}}
                                                    </td>
                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 ps-lg-0 outcome-section">
                                    <div class="bg-header-grey">
                                        <span>ICE OUTCOME</span>
                                    </div>
                                    <div>
                                        <table class="breachReasonTable responsiveTable table-discharge-details">
                                            <thead>
                                            <tr class="position-relative">
                                                <th>Date / Time Result</th>
                                                <th>ED/EA</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_data_array["symphony_data_ice_details"] as $row)
                                                <tr>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">Date / Time Result</div>
                                                        {{$row->ice_res_date}}
                                                    </td>
                                                    <td class="pivoted">
                                                        <div class="tdBefore">ED/EA</div>
                                                        {{$row->atd_num}}
                                                    </td>
                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
@else

    <div class="col-md-12  " style='text-align:center; padding-top:50px; font-size:14px; padding-bottom: 30px;'>
        No Records Found !
    </div>
@endif

