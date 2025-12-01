
@if(!request()->has('modal_click'))
    <div class="row">
        <div class="col-lg-12">
            <section class="cd-horizontal-timeline ">
                <div class="timeline">
                    <div class="events-wrapper">
                        <div class="events">
                            <ol>

                                @foreach($timeline_date_list as $series => $date)
                                    <li><a href="#" data-dp_series="{{$series }}" data-camis-patient-id="{{$board_round_deteriorating_list['camis_patient_id'] }}" data-date="series_{{ $series }}" class="{{ $loop->last ? 'selected' : '' }} {{ !$loop->last && $loop->iteration < $loop->count ? 'older-event' : '' }} dp_date_click"> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d M Y') }} <span class="timeline-no">{{ $loop->iteration }}</span></a></li>
                                @endforeach
                            </ol>

                            <span class="filling-line" aria-hidden="true"></span>
                        </div>
                    </div>
                    <ul class="cd-timeline-navigation">
                        <li><a href="#" class="prev inactive"></a></li>
                        <li><a href="#" class="next"></a></li>
                    </ul>
                </div>
                @endif
                <input type="hidden" id="dp_select_date" value="{{ PredefinedDateFormatShowOnCriticalcareDashboard($selected_date) }}">
                <div class="modal-popup-loader-content"></div>
                <div class="events-content  " style="height: auto;">

                    <ol>
                        @foreach($common_array as $key => $data)
                            <li class="@if($loop->last) selected @endif" data-date="series_{{ $key }}">
                                <div class="timeline-contents">
                                    <table
                                        class="breachReasonTable responsiveTable table-timeline">
                                        <tr class="position-relative header">
                                            <th>Patient Name</th>
                                            <th>PAS Number</th>
                                            <th>Age</th>
                                            <th>Sex</th>
                                            <th>Ward</th>
                                            <th>DOB</th>
                                            <th class="cell-span" rowspan="2">
                                                {!! GetEwsData($data['patient_details']['patient_vital_pac_info']['totalews'] ?? null, 30, 'EWS') !!}
                                            </th>
                                        </tr>
                                        <tr class="table-body">
                                            <td class="pivoted">
                                                <div class="tdBefore">
                                                    Date
                                                </div>
                                                {{$data['patient_details']['camis_patient_name'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">
                                                    PAS Number
                                                </div>
                                                {{$data['patient_details']['camis_patient_pas_number'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">
                                                    Age</div>
                                                {{$data['patient_details']['camis_patient_age'] }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">
                                                    Sex</div>
                                                {{ ucfirst($data['patient_details']['camis_patient_sex'])  }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">
                                                    Ward</div>
                                                {{$all_wards[$data['patient_details']['camis_patient_ward_id']] ?? '' }}
                                            </td>
                                            <td class="pivoted">
                                                <div class="tdBefore">
                                                    DOB</div>
                                                {{$data['patient_details']['camis_patient_date_of_birth'] }}
                                            </td>
                                        </tr>


                                    </table>


                                    <div class="dp_ajax_data_load ward_summary_sub_modal_inner_body">



                                        @if(count($data['virtual_comment_list']) > 0)
                                            <div class="dp-comments-section">
                                                <div class="row">
                                                    <h6>DP Comments</h6>

                                                    <div class="col-lg-12 ">
                                                        <div class="comment-list">
                                                            @foreach($data['virtual_comment_list'] as $content)

                                                                <p>{{ $loop->iteration }}. {{$content['additional_comment']}}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif
                                        <div class="timeline-footer @if(count($data['virtual_comment_list']) < 1) mt-4 @endif">
                                            <div class="completed-tasks-section">
                                                <div  class="header-task">

                                                    @php
                                                        if(count($data['patient_task_list']) > 0){
                                                             $first =  array_key_first($data['patient_task_list']);
                                                        }

                                                    @endphp

                                                    <span>Task List Created: @if(count($data['patient_task_list']) > 0) {{PredefinedDateFormatBoardRoundTaskToBeCompleted($data['patient_task_list'][$first]['task_created_at'])}} @else {{ PredefinedDateFormatShowOnCalendarWithoutDay($date) }} @endif</span>
                                                </div>
                                                <hr class="line ">
                                                @if(count($data['patient_task_list']) > 0)

                                                    @foreach($data['patient_task_list'] as $tasks)

                                                        <div class="row gx-2 align-items-center">
                                                            <div class="col-xxl-8 col-xl-7 col-md-6 mb-2 mb-md-0">
                                                                <span>{{$loop->iteration}}. {{ $tasks['patient_task_category']['task_category_name'] }} {{ $tasks['task_dp_status_order_value'] }} - {{ $tasks['task_description'] }} - {{ $tasks['patient_task_group']['task_group_name'] }}

                                                                    @if(strpos(strtolower($tasks['task_description']), 'aki') === false)
                                                                        @if(!empty($tasks['task_extra_data']) && is_array(json_decode($tasks['task_extra_data'], true)))
                                                                            <br>
                                                                            @foreach (json_decode($tasks['task_extra_data'], true) as $key => $task_extra)
                                                                                {{ (strtolower($key) === 'eol') ? strtoupper($key) : ucwords(str_replace('_', ' ', $key)) }} : {{ $task_extra }}<br>
                                                                            @endforeach
                                                                        @endif
                                                                    @endif
                                                                </span>

                                                            </div>
                                                            <div class="col-xxl-4 col-xl-5 col-md-6 mb-2 mb-md-0">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        @if($tasks['task_completed_status'] == 1)

                                                                                <div class="bg-task-complete me-2">
                                                                                    Yes
                                                                                </div>
                                                                        @elseif($tasks['task_completed_status'] == 0 && $tasks['task_not_applicable_status'] == 0)
                                                                            <div class="bg-task-not-complete me-2">
                                                                                No
                                                                            </div>
                                                                        @elseif($tasks['task_not_applicable_status'] == 1 && $tasks['task_completed_status'] == 0)
                                                                            <div class="bg-task-not-complete me-2">
                                                                                N/A
                                                                            </div>
                                                                        @else

                                                                            @php
                                                                                $status = [];
                                                                                if(!empty($tasks['task_extra_data'])){
                                                                                    $extra_data = json_decode($tasks['task_extra_data'], true);
                                                                                    if(is_array($extra_data) && count($extra_data) > 0){
                                                                                        $status = array_map('strtolower', array_values($extra_data));
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            @if(count($status) < 1)
                                                                                <div class="bg-task-complete me-2">
                                                                                    Yes
                                                                                </div>
                                                                            @elseif(isset($status['0']) && !in_array($status['0'], ['no', 'not applicable']))

                                                                                <button
                                                                                    class="bg-task-complete me-2">YES</button>
                                                                            @else
                                                                                @if (strpos(strtolower($tasks['task_description']), 'escalation') !== false )
                                                                                    <button
                                                                                    class="bg-task-complete me-2">YES</button>
                                                                                @else
                                                                                    <div class="bg-task-not-complete @if($status['0'] == 'not applicable') me-2 @else me-2 @endif">
                                                                                        @if(strtolower($status['0']) == 'not applicable') N/A @else {{ ucwords($status['0']) }} @endif
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        @if(!empty($tasks['task_completed_at']))

                                                                            <span>Completed At
                                                                        {{PredefinedDateFormatFor24Hour($tasks['task_completed_at'])}} ({{ Sentinel::findById($tasks['task_completed_by'])->username ?? '--' }})</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        @if (strpos(strtolower($tasks['task_description']), 'sepsis') !== false && count(ArrayFilter($data['list_of_sub_task'], function($task) {
                                                            return $task['task_category'] == 7;
                                                        })) > 0)
                                                            <div class="task-section">
                                                                <div class="sub-task-header">
                                                                    <h6>Sepsis Tasks</h6>
                                                                </div>




                                                                @foreach(array_filter($data['list_of_sub_task'], function($task) {
                                                                    return $task['task_category'] == 7;
                                                                }) as $sepsis_tasks)
                                                                    <div class="row gx-2 align-items-center sub-tasks-section">
                                                                        <div class="col-xxl-8 col-xl-7 col-md-6 mb-2 mb-md-0">
                                                                            <span class="sub-task">{{$loop->iteration}}. {{ $sepsis_tasks['patient_task_category']['task_category_name'] }} - {{ $sepsis_tasks['task_description'] }} - {{ $sepsis_tasks['patient_task_group']['task_group_name'] }}</span>
                                                                        </div>
                                                                        <div class="col-xxl-4 col-xl-5 col-md-6 mb-2 mb-md-0">
                                                                            <div class="btn-sub-task d-flex align-items-center">
                                                                                <div>


                                                                                    @if($sepsis_tasks['task_completed_status'] == 0 && $sepsis_tasks['task_not_applicable_status'] == 0)
                                                                                        <div class="bg-task-not-complete me-2">
                                                                                            No
                                                                                        </div>
                                                                                    @elseif($sepsis_tasks['task_not_applicable_status'] == 1 && $sepsis_tasks['task_completed_status'] == 0)
                                                                                        <div class="bg-task-not-complete me-2">
                                                                                            N/A
                                                                                        </div>
                                                                                    @else

                                                                                        <div class="bg-task-complete me-2">
                                                                                            Yes
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                                <div>
                                                                                    @if(!empty($sepsis_tasks['task_completed_at']))
                                                                                        <span>Completed At
                                                                                {{PredefinedDateFormatFor24Hour($sepsis_tasks['task_completed_at'])}}  ({{ Sentinel::findById($tasks['task_completed_by'])->username ?? '--' }})</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @elseif (strpos(strtolower($tasks['task_description']), 'aki') !== false && count(array_filter($data['list_of_sub_task'], function($task) {
                                                            return $task['task_category'] == 8;
                                                        })) > 0)
                                                            <div class="task-section">
                                                                <div class="sub-task-header">
                                                                    <h6>AKI Tasks</h6>
                                                                </div>
                                                                @foreach(array_filter($data['list_of_sub_task'], function($task) {
                                                                    return $task['task_category'] == 8;
                                                                }) as $sepsis_tasks)
                                                                    <div class="row gx-2 align-items-center sub-tasks-section">
                                                                        <div class="col-xxl-8 col-xl-7 col-md-6 mb-2 mb-md-0">
                                                                            <span class="sub-task">{{$loop->iteration}}. {{ $sepsis_tasks['patient_task_category']['task_category_name'] }} - {{ $sepsis_tasks['task_description'] }} - {{ $sepsis_tasks['patient_task_group']['task_group_name'] }}</span>
                                                                        </div>
                                                                        <div class="col-xxl-4 col-xl-5 col-md-6 mb-2 mb-md-0">
                                                                            <div class="bg-sub-task d-flex align-items-center">
                                                                                <div>
                                                                                    @if($sepsis_tasks['task_completed_status'] == 0 && $sepsis_tasks['task_not_applicable_status'] == 0)
                                                                                        <div class="bg-task-not-complete me-2">
                                                                                            No
                                                                                        </div>
                                                                                    @elseif($sepsis_tasks['task_not_applicable_status'] == 1 && $sepsis_tasks['task_completed_status'] == 0)
                                                                                        <div class="bg-task-not-complete me-2">
                                                                                            N/A
                                                                                        </div>
                                                                                    @else

                                                                                        <div class="bg-task-complete me-2">
                                                                                            Yes
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                                <div>
                                                                                    @if(!empty($sepsis_tasks['task_completed_at']))
                                                                                        <span>Completed At
                                                                                {{PredefinedDateFormatFor24Hour($sepsis_tasks['task_completed_at'])}}  ({{ Sentinel::findById($tasks['task_completed_by'])->username ?? '--' }})</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <div class="row align-items-center dp_print_section" style="background: none;">
                                                        <div class="col-lg-12 col-md-12 pe-md-1 mb-2 text-center"> {{ NotFoundMessage() }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </section>
            @if(!request()->has('modal_click'))
        </div>
    </div>
@endif
