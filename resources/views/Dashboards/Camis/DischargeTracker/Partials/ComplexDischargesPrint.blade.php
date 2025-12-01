<div class="discharge-tracker-contents">
    @if(count($success_array['all_patients']) > 0)
        <div class="bg-sticky"></div>
        <div class="patients-details">
            @forelse($success_array['all_patients'] as $wards => $patients)
                @if(count($patients) > 0)
                    <div class="wards-patients-details">
                        <div class="sticky-header">
                            <div class="name-header">
                                <span>{{ $wards }}</span>
                            </div>
                        </div>


                        <div class="custom-card">
                            <table class="breachReasonTable responsiveTable table-custom">

                                @foreach($patients as $patient)

                                    @php
                                        $patient_cdt_status = PatientCDTStatus($patient['board_round_cdt']['cdt_action'], $patient['board_round_cdt']['cdt_action_time'], $patient['board_round_cdt']['is_equipment'], $patient['board_round_cdt']['is_equipment_time'], $patient['board_round_cdt']['discharge_for_today'], $patient['board_round_cdt']['discharge_for_today_time']);

                                    @endphp


                                    <tbody class="table-patient-tbody update_patient_date_{{ $patient['camis_patient_id'] }} {{ $patient_cdt_status['type'] }}" id="patient_list_with_{{ $patient['camis_patient_id'] }}">
                                    {!! $patient_cdt_status['html'] !!}
                                    <tr class="table-patient-row-1 @if(CheckSpecificPermission('discharge_tracker_discharge_info_popup_view')) discharge_patient_modal cursor_pointer @else permission_denied_alert @endif" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">

                                        <td class="pivoted">
                                            <div class="tdBefore">Bay & Bed</div>
                                            <span class="count_patient">{{ $patient['ibox_actual_bed_full_name'] }}</span>
                                        </td>

                                        <td class="pivoted">
                                            <div class="tdBefore">Name</div>
                                            {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Hospital Number</div>
                                            <span>{{ $patient['camis_patient_pas_number'] }}</span>
                                        </td>
                                        <td class="pivoted">
                                            @if(isset($patient['board_round_cdt']))
                                            @if(isset($patient['board_round_cdt']['cdt_status']) &&  $patient['board_round_cdt']['cdt_status'] == 1)
                                                    <div class="tdBefore " id="cdt_text_{{ $patient['camis_patient_id'] }}">Referral Date</div>
                                                    <span class="cdt-reviewed" id="cdt_username_date_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_cdt']['accepted_by_username']) && isset($patient['board_round_cdt']['accepted_date'])) {{ $patient['board_round_cdt']['accepted_by_username'] }} - {{ PredefinedDateFormatFor24Hour($patient['board_round_cdt']['accepted_date']) }} @else -- @endif </span>

                                                @else
                                                    <span>--</span>
                                                @endif
                                            @else
                                                <div class="tdBefore" id="cdt_text">Referral Date</div>
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Services</div>
                                            <span id="dtoc_services_text_{{ $patient['camis_patient_id'] }}" > @if(isset($patient['board_round_pathway_requirement']) && isset($patient['board_round_pathway_requirement']['service_by_pathway_text']) ) {{ $patient['board_round_pathway_requirement']['service_by_pathway_text'] }} @else -- @endif </span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Current Status</div>
                                            <span id="dtoc_current_status_text_{{ $patient['camis_patient_id'] }}" > @if(isset($patient['board_round_pathway_requirement']) && isset($patient['board_round_pathway_requirement']['dtoc_status']) ) {{ $patient['board_round_pathway_requirement']['dtoc_status']['dtoc_current_status_text'] }} @else -- @endif </span>
                                        </td>


                                        <td class="pivoted">
                                            <div class="tdBefore">LOS</div>
                                            <span>{{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) }} {{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) > 1 ? 'Days' : 'Day' }}
                                            </span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Med Fit</div>
                                            <span id="{{ $patient['camis_patient_id'] }}_medfit">
                                                @if(isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)
                                                    Yes {{ isset($patient['board_round_medically_fit_data']['updated_at']) ? '- '.PredefinedDateFormatMedFitDate($patient['board_round_medically_fit_data']['updated_at']).'' : '' }}
                                                @else
                                                    No
                                                @endif
                                            </span>
                                        </td>

                                        <td class="pivoted">
                                            <div class="tdBefore">Confirmed Discharge Date</div>
                                            <span id="planned_discharged_date_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_pathway_requirement']) && isset($patient['board_round_pathway_requirement']['planned_discharge_date'])){{ PredefinedDateFormatForPD($patient['board_round_pathway_requirement']['planned_discharge_date']) }} @else -- @endif</span>
                                        </td>


                                        <td class="pivoted">
                                            <div class="tdBefore">Pathway</div>
                                            <span id="dtoc_pathway_text_{{ $patient['camis_patient_id'] }}"

                                            @if(isset($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']))
                                                @if(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 0')
                                                    class="total_p0"
                                                @elseif(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 1')
                                                    class="total_p1"
                                                @elseif(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 2')
                                                    class="total_p2"
                                                @elseif(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 3')
                                                    class="total_p3"
                                                @endif
                                            @endif
                                            >@if(isset($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text'])) {{ \Illuminate\Support\Str::limit($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text'], 200, '...') }} @else -- @endif</span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Authority</div>

                                            <span id="dtoc_authority_text_{{ $patient['camis_patient_id'] }}" >  @if(isset($patient['board_round_pathway_requirement']) && !empty($patient['board_round_pathway_requirement']['dtoc_service_text']) )  @if(strtolower($patient['board_round_pathway_requirement']['dtoc_service_text']) == 'ooa') OOA: {{ $patient['board_round_pathway_requirement']['others_authority_text'] }} @else {{ $patient['board_round_pathway_requirement']['dtoc_service_text'] }} @endif @else -- @endif </span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Reason Code</div>
                                            <span id="dtoc_reason_text_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_pathway_requirement']['dtoc_authority']['dtoc_authority_text'])) {{ \Illuminate\Support\Str::limit($patient['board_round_pathway_requirement']['dtoc_authority']['dtoc_authority_text'], 200, '...') }} @else -- @endif </span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">&nbsp;</div>
                                            <div class="cell-data">

                                                <div class="data-group">
                                                    @if(isset($patient['board_round_tto']['discharge_planning_tto_status']) && in_array($patient['board_round_tto']['discharge_planning_tto_status'], [1, 2]))
                                                        <div @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) class="bg-tto-yes" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) class="bg-tto-no" @else class="bg-tto-na" @endif data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) title="TTO Required - Completed" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) title="TTO Required - Not Completed" @else  title="TTO Status Not Applicable" @endif>TTO</div>
                                                    @endif
                                                    @if(isset($patient['board_round_edn']['discharge_planning_edn_status']) && in_array($patient['board_round_edn']['discharge_planning_edn_status'], [1, 2]))
                                                        <div  @if($patient['board_round_edn']['discharge_planning_edn_status'] == 1) class="bg-eds-yes" @elseif($patient['board_round_edn']['discharge_planning_edn_status'] == 2) class="bg-eds-no" @else class="bg-edn-na" @endif data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" @if($patient['board_round_edn']['discharge_planning_edn_status'] == 1) title="EDS Required - Completed" @elseif($patient['board_round_edn']['discharge_planning_edn_status'] == 2) title="EDS Required - Not Completed" @else  title="EDN Status Not Applicable" @endif>EDS</div>
                                                    @endif
                                                    <div>
                                                        @if($ambo = CheckSpecificBedFlagsExitsOnArrayWithData($patient['patient_wise_flags'], 'ibox_patient_flag_ambo', 'flag_ambo_ref'))

                                                        <span class="bg-ambo" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="{{ strtoupper($ambo) }}"> AMBO </span>
                                                        <span>REF:{{ strtoupper($ambo) }}</span>
                                                        @endif

                                                    </div>
                                                </div>

                                            </div>
                                        </td>



                                    </tr>
                                    <tr class="table-patient-row-2">
                                        <td class="pivoted spl-cell" rowspan="3" >
                                            <div class="header-comment">
                                                <p class="flex-grow-1">Comments</p>
                                                <button class="btn btn-assign-task view_cdt_comment" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">
                                                    CDT Comment
                                                </button>
                                                <button  class="btn btn-assign-task add_comment {{ DisabledButtonOnRolePermission('discharge_tracker_discharge_info_comment_add') }}" data-comment-id="" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">Add Comment</button>
                                                <button data-bs-toggle="offcanvas" data-bs-target="#viewAllComments"
                                                        aria-controls="offcanvasRight" onclick="ViewAllComment('{{ $patient['camis_patient_id'] }}');"
                                                        class="btn btn-assign-task">View All
                                                </button>
                                                <button id="remove_from_list" onclick="RemovePatients('{{ $patient['camis_patient_id'] }}','{{ 4 }}');" class="btn btn-remove">
                                                    Remove From List
                                                </button>
                                            </div>
                                            @if(isset($patient['board_round_dtoc_comments']) && count($patient['board_round_dtoc_comments']) > 0)
                                                <div class="card-col-grp" id="comment_list_{{ $patient['camis_patient_id'] }}">
                                                    {!! app('App\Http\Controllers\Iboards\Camis\DischargeTrackerController')->DtocWardCommentList($patient['camis_patient_id']) !!}

                                                </div>
                                            @else
                                                <div class="card-col-grp"  id="comment_list_{{ $patient['camis_patient_id'] }}" style="overflow-y: hidden;">
                                                    <div class="custom_not_founds" style="position: relative;top: 40%;text-align: center;">{{ NotFoundMessage() }}</div>
                                                </div>

                                            @endif

                                        </td>

                                    </tr>

                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            @empty
                <div class="patients-details">
                    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
                </div>
            @endforelse

        </div>
    @else
        <div class="patients-details">
            <div class="custom_not_found">{{ NotFoundMessage() }}</div>
        </div>
    @endif
</div>
