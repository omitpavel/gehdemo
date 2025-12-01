


@if(count($success_array['patient_details'])>0)

    <div id="dataHandoverDetails">
        <div class="print-handover-details">


        @foreach($success_array['patient_details'] as $ward_key => $ward_data)



            @php $beck_ch_roll = "";  @endphp
            @foreach($ward_data as $bedgroup_key=>$bedgroup)
                @foreach($bedgroup as $bedgroup_number_key=>$bedgroup_number)
                    @php $p_group_check_num   =   $bedgroup_key."-".$bedgroup_number_key;   @endphp
                    @if($beck_ch_roll !="")
                        @if($beck_ch_roll != $p_group_check_num)
                            @isset($success_array['is_page_break'])
                                <div style=" @if($success_array['is_page_break'] == 1) page-break-after: always; @endif width: 100%;"></div>
                            @endisset
                        @endif
                    @endif


                    <div class="row gx-1" >
                        <div class="col-12">
                            <div class="ward-name">
                                <h6>@if ($bedgroup_number_key != 0)
                                    {{ $bedgroup_key }} - {{ $bedgroup_number_key }} @else {{ $bedgroup_key }} @endif</h6>
                            </div>
                        </div>
                    </div>




                         @php $beck_ch_roll = $p_group_check_num; $num = 0;  @endphp

                         @foreach ($bedgroup_number as $bed)


                                <div class="handover-print-data" style="break-inside: avoid;">

                                    @php
                                        $bed['los_ward_value'] = \Illuminate\Support\Carbon::parse($bed['camis_patient_ward_start_date'])->diffInDays(\Illuminate\Support\Carbon::now());
                                    @endphp

                                    @if ($bed['camis_patient_id'] != "")
                                        <div class="col-12">
                                            <div class="row gx-1 top-row">
                                                <div class="col-sm-12">
                                                    <h6>{{ucwords(strtolower($bed['camis_patient_name']))}} @if($bed['camis_patient_pas_number']!="") ({{ $bed['camis_patient_pas_number'] }}) @endif - @if ($bed['ibox_actual_bed_full_name'] != "")
                                                        {{ $bed['ibox_actual_bed_full_name'] }}
                                                    @endif</h6>
                                                </div>
                                                {{-- <div class="col-sm-4 text-end">
                                                    <h6>Age : {{ $bed['camis_patient_age'] }} (DOB: {{ date("d-m-Y",strtotime($bed['camis_patient_date_of_birth'])) }}) </h6>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="handover-contents">
                                            <div class="row gx-2 ">
                                                <div class="row gx-1 mb-1">
                                                    <div class="col-sm-7">
                                                        <div class="row gx-0 handover-patient-details">
                                                            <div class="col-sm-6 border-handover-end">


                                                                <ul>
                                                                    <li class="label-primary">Age</li>
                                                                    <li>:{{ $bed['camis_patient_age'] }} (DOB: {{ date("d-m-Y",strtotime($bed['camis_patient_date_of_birth'])) }}) </li>
                                                                </ul>
                                                                <ul>
                                                                    <li class="label-primary">Consultant</li>
                                                                    <li>: {{ $bed['camis_consultant_name']}}</li>
                                                                </ul>
                                                                <ul>
                                                                    <li class="label-primary">LOS</li>
                                                                    <li>: {{ PatientLos($bed['camis_patient_admission_date_time']) }} Total With {{ PatientLos($bed['camis_patient_ward_start_date']) }} On This Ward</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <ul>
                                                                    <li class="label-primary">Med Fit</li>
                                                                    <li>: {{ $bed['board_round_medically_fit_data'] ? $bed['board_round_medically_fit_data']['patient_medically_fit_status'] == 1? 'Yes' : 'No' : 'No' }} </li>
                                                                </ul>
                                                                <ul>
                                                                    <li class="label-primary">EDD</li>
                                                                    <li>: {{ $bed['board_round_estimated_discharge_date'] ? $bed['board_round_estimated_discharge_date']['patient_estimated_discharge_date'] : '' }} </li>
                                                                </ul>
                                                                <ul>
                                                                    <li class="label-primary">OBS</li>
                                                                    <li>: {{ $bed['patient_hand_over']['ibox_handover_obs_varience'] ?? '' }} </li>
                                                                </ul>

                                                            </div>
                                                            <div class="col-12">
                                                                <ul>
                                                                    <li class="label-primary">Red/Green</li>

                                                                    <li>: @if(isset($bed['red_green_bed']['patient_red_green_status']) && $bed['red_green_bed']['patient_red_green_status'] == 1)
                                                                        @php
                                                                            $red_bed = json_decode($bed['red_green_bed']['patient_red_green_status_reason_code'], true);
                                                                            $pending_red_bed_task = array_keys(array_filter($red_bed, function($value) {
                                                                                return ((!isset($value['is_complete']) && $value == 0) || (isset($value['is_complete']) && $value['is_complete'] == 0));
                                                                            }));
                                                                        @endphp
                                                                        Red ( @foreach ($pending_red_bed_task as $pending_red_task)
                                                                        {{ $success_array['red_bed_reason_list'][$pending_red_task]}} @if(!$loop->last) , @endif
                                                                        @endforeach )
                                                                        @elseif(isset($bed['red_green_bed']['patient_red_green_status']) && $bed['red_green_bed']['patient_red_green_status'] == 2)
                                                                            Green
                                                                        @else -- @endif</li>
                                                                </ul>
                                                                <ul>
                                                                    <li class="label-primary">Variances</li>
                                                                    <li>: {{ $bed['patient_hand_over']['ibox_handover_varience_store'] ?? '' }} </td>
                                                                </ul>
                                                                <ul>
                                                                    <li class="label-primary">Pain/Analgesia</li>
                                                                    <li>: @if(isset($bed['patient_hand_over']['ibox_handover_pain_analgesia']) && $bed['patient_hand_over']['ibox_handover_pain_analgesia'] == 1)

                                                                        Refer to EPMA
                                                                @endif </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="pac-count-box">
                                                            <h6 class="fw-bold">Vital PAC</h6>
                                                            @if(isset($bed['patient_vital_pac_info']['totalews']))
                                                                <div class="ews-wrapper @if(is_numeric($bed['patient_vital_pac_info']['totalews']) && $bed['patient_vital_pac_info']['totalews'] < 5) ews-low-value @endif">
                                                                    <span class="ews-text">{{ $bed['patient_vital_pac_info']['totalews'] }}</span>
                                                                    <span class="ews-header">EWS</span>
                                                                </div>
                                                            @else
                                                                <div class="ews-wrapper ews-low-value">
                                                                    <span class="ews-text">--</span>
                                                                    <span class="ews-header">EWS</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="handover-icons-wrapper">
                                                            @foreach ($bed['patient_wise_flags'] as $key => $pl_flag)
                                                                @if($pl_flag['patient_flag_name'] != '' && $pl_flag['patient_flag_status_value'] == 1)
                                                                <div class="flag-group">
                                                                    <img src="{{ asset('asset_v2/Template/icons/ward_icons/'.GetBedFlagImagesByName($pl_flag['patient_flag_name']).'.png') }}" alt="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@if (isset($pl_flag['patient_flag_list']) && $pl_flag['patient_flag_list']['patient_flag_name'] != '')
                                                                                {{ $pl_flag['patient_flag_list']['patient_flag_name'] }}
                                                                                @endif" >
                                                                    <span>@if (isset($pl_flag['patient_flag_list']) && $pl_flag['patient_flag_list']['patient_flag_name'] != '')
                                                                        {{ $pl_flag['patient_flag_list']['patient_flag_name'] }}
                                                                    @endif</span>
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row gx-1">
                                                    <div class="col-12 reason-block">
                                                        <ul>
                                                            <li> <span class="left-label">Admitting Reason</span>:
                                                                {{ $bed['board_round_admitting_reason'] ? $bed['board_round_admitting_reason']['patient_admitting_reason'] : '' }}</li>
                                                        </ul>
                                                        <ul>
                                                            <li> <span class="left-label">Past Medical History</span>: {{ $bed['board_round_past_medical_history'] ? $bed['board_round_past_medical_history']['patient_past_medical_history'] : '' }}</li>
                                                        </ul>
                                                        <ul>
                                                            <li> <span class="left-label">Social History</span>: {{ $bed['board_round_social_history'] ? $bed['board_round_social_history']['patient_social_history'] : '' }}</li>
                                                        </ul>
                                                        <ul>
                                                            <li> <span class="left-label">Patient Goal</span>: {{ $bed['board_round_patient_goal'] ? $bed['board_round_patient_goal']['patient_patient_goal'] : '' }}</li>
                                                        </ul>
                                                        <ul>
                                                            <li> <span class="left-label">Pharmacy</span>: @php $drug_text_show        = ""; @endphp

                                                                @if (isset($bed['board_round_pharmacy_data']))
                                                                    @php $pharmacy_drug_status  = $bed['board_round_pharmacy_data']['pharmacy_drug_history'] ?? ''; @endphp
                                                                    @if($pharmacy_drug_status == 1 || $pharmacy_drug_status  == 2 || $pharmacy_drug_status  == 3)
                                                                        @if($pharmacy_drug_status  == 1)
                                                                            @php $drug_text_show = "Drug History Partial";  @endphp
                                                                        @elseif($pharmacy_drug_status  == 2)
                                                                            @php $drug_text_show = "Drug History Full";  @endphp
                                                                        @elseif($pharmacy_drug_status  == 3)
                                                                            @php $drug_text_show = "Drug History Reviewed";  @endphp
                                                                        @elseif($pharmacy_drug_status  == 4)
                                                                            @php $drug_text_show = "PHARMACIST SCREENED";  @endphp
                                                                        @endif
                                                                    @endif
                                                                    @if($bed['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1 || $bed['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1)
                                                                        @if($drug_text_show != "")
                                                                            @php $drug_text_show = $drug_text_show . " - Antibiotics: "; @endphp
                                                                        @else
                                                                            @php $drug_text_show = $drug_text_show . "Antibiotics: "; @endphp
                                                                        @endif

                                                                        @if($bed['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1)
                                                                            @php $drug_text_show = $drug_text_show ." IV "; @endphp
                                                                        @endif
                                                                        @if($bed['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1)
                                                                            @php $drug_text_show =  $drug_text_show . " and "; @endphp
                                                                        @endif
                                                                        @if($bed['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1)
                                                                            @php $drug_text_show =  $drug_text_show ." Oral "; @endphp
                                                                        @endif

                                                                    @endif
                                                                    {{$drug_text_show}}
                                                                    @php $lat_date_pharm = ""; @endphp
                                                                    @if($bed['board_round_pharmacy_data']['pharmacy_drug_history_date'] != "" && $bed['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date'] != "")
                                                                        @if(strtotime($bed['board_round_pharmacy_data']['pharmacy_drug_history_date']) > strtotime($bed['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']))
                                                                            @php $lat_date_pharm = date("jS M Y, H:i", strtotime($bed['board_round_pharmacy_data']['pharmacy_drug_history_date'])); @endphp
                                                                        @else
                                                                            @php $lat_date_pharm = date("jS M Y, H:i", strtotime($bed['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date'])); @endphp
                                                                        @endif
                                                                    @elseif($bed['board_round_pharmacy_data']['pharmacy_drug_history_date'] != "")
                                                                        @php $lat_date_pharm = date("jS M Y, H:i", strtotime($bed['board_round_pharmacy_data']['pharmacy_drug_history_date'])); @endphp
                                                                    @elseif($bed['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date'] != "")
                                                                        @php $lat_date_pharm = date("jS M Y, H:i", strtotime($bed['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date'])); @endphp
                                                                    @endif

                                                                @endif</li>
                                                        </ul>
                                                        <ul>
                                                            <li> <span class="left-label">Comment</span>: {{$bed['board_round_pharmacy_data']['pharmacy_latest_comment'] ?? '' }}</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="row gx-1">
                                                    <div class="col-12 p-0">
                                                        <table class="table-values mb-1">
                                                            <thead>
                                                            <tr>
                                                                <th>S-Surface</th>
                                                                <th>S-Skin</th>
                                                                <th>K-Keep Moving</th>
                                                                <th>I-Continence</th>
                                                                <th>N-Nutrition</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                @php
                                                                    $s_surface_varience_array = [];
                                                                    $s_surface_varience_array = explode(',', $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_s_surface'] :'');
                                                                @endphp
                                                                <td>@foreach($s_surface_varience_array as $row)
                                                                        {{ $row }} <br>
                                                                    @endforeach</td>
                                                                <td>Repositioning Routine : {{ $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_repositioning_routine'] : '' }}
                                                                    <br> Skin Conditioning : {{ $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_skin_conditioning'] : '' }}
                                                                    <br>Dressings : {{ $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_dressings'] : '' }}</td>
                                                                <td>Mobility : {{ $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_mobility'] : '' }}
                                                                    <br> Equipment : {{ $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_equipment'] : '' }}
                                                                    <br>Assistance Needed : {{ $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_assistance_needed'] : '' }}</td>
                                                                <td>{{ $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_i_continence'] : '' }}
                                                                    <br> </td>
                                                                @php
                                                                    $s_surface_varience_array = [];
                                                                    $s_surface_varience_array = explode(',', $bed['patient_hand_over'] ? $bed['patient_hand_over']['ibox_handover_n_nutrition']  : "");

                                                                @endphp
                                                                <td> @foreach($s_surface_varience_array as $row) {{ $row }} <br> @endforeach
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>



                                                    </div>
                                                </div>

                                                <div class="row gx-1">
                                                    <div class="col-12">
                                                        <div class="task-comments-section">
                                                            <div class="header-task">
                                                                <h6>Task to be Completed</h6>
                                                            </div>
                                                            <div class="handover-tasks-row">
                                                                <div class="handover-tasks-col-1">
                                                                    <div class="completed-tasks">
                                                                        <div class="row gx-0">
                                                                            @if(isset($bed['board_round_patient_tasks']) && count($bed['board_round_patient_tasks']) > 0)
                                                                                        @php
                                                                                            $tasks = $bed['board_round_patient_tasks'];

                                                                                        @endphp
                                                                                        @foreach ($tasks as $task)
                                                                                            @php
                                                                                                $index = $loop->parent->index * 2 + $loop->index;
                                                                                                $task_category = isset($task['patient_task_category']) ? $task['patient_task_category']['task_category_name'] : '';
                                                                                                $task_group    = isset($task['patient_task_group']) ? $task['patient_task_group']['task_group_name'] : '';
                                                                                                $task_description = $task['task_description'];
                                                                                                $task_created_at = PredefinedDateFormatOnTask($task['task_created_at']);
                                                                                                $task_content = $task_category . '-' . $task_description . '-' . $task_group . '(' . $task_created_at . ')';
                                                                                            @endphp

                                                                                                <div class="col-sm-4"><div class="cell ">

                                                                                                    <p class="comment">{{ $loop->iteration }}. {{ $task_content }}
                                                                                                    </p>
                                                                                                </div></div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <div class="col-12 no-records-div">
                                                                                            {{ NotFoundMessage() }}
                                                                                        </div>
                                                                                    @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                @if(isset($bed['patient_hand_over']['ibox_handover_comment']) && $bed['patient_hand_over']['ibox_handover_comment'] != '')
                                                <div class="row gx-1">
                                                    <div class="col-12">
                                                        <ul class="comment-handover">
                                                            <li> <span class="left-label">Comment</span> : {{ $bed['patient_hand_over']['ibox_handover_comment'] ?? '' }}</li>
                                                        </ul>
                                                    </div>

                                                </div>
                                                @endif

                                            </div>
                                        </div>




















                                    @endif

                                </div>


                         @endforeach

                @endforeach
            @endforeach

        @endforeach
    </div>
    </div>
@endif

