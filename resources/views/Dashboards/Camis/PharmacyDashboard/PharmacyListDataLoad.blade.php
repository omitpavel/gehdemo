

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <!-- Nav tabs -->

            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('pharmacy_dashboard_view') }}">
                        <a class="tab-custom-btn @if ($success_array['tab_type'] == 'pharmacy_list') active @endif" @if(PermitedStatus('pharmacy_dashboard_view'))  onclick="TabType('pharmacy_list');" data-bs-toggle="tab" id="pharmacyListTab" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif
                        href="#pharmacyList">
                            <div class="tab-active">Pharmacy List</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pharmacy_dashboard_screened_view') }}">
                        <a class="tab-custom-btn @if ($success_array['tab_type'] == 'pharmacy_screened') active @endif"  @if(PermitedStatus('pharmacy_dashboard_screened_view'))  onclick="TabType('pharmacy_screened');"  data-bs-toggle="tab" id="pharmacistScreenedTab" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif
                        href="#pharmacistScreened">
                            <div class="tab-active">Pharmacist Screened</div>
                        </a>
                    </li>
                </ul>
                <div class="row gx-2 " id="listRow">
                    <div class="col-lg-3 col-md-6 mb-2">
                        {!! AllWardListDropdown('ward_id') !!}
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <select class="form-select" id="antibiotic_type" aria-label="Default select example">
                            <option {{ $success_array['antibiotic_type'] == 'all_patient' ? 'selected': '' }}  value="all_patient"> All Patients</option>
                            <option {{ $success_array['antibiotic_type'] == 'all_antibiotic' ? 'selected': '' }}  value="all_antibiotic"> All Antibiotic</option>
                            <option  {{ $success_array['antibiotic_type'] == 'iv' ? 'selected': '' }} value="iv">Antibiotic IV</option>
                            <option  {{ $success_array['antibiotic_type'] == 'oral' ? 'selected': '' }} value="oral">Antibiotic ORAL</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <select class="form-select" id="drug_history_type" aria-label="Default select example">
                            <option {{ $success_array['drug_history_type'] == 'all' ? 'selected': '' }}  value="all"> All Patients</option>
                            <option  {{ $success_array['drug_history_type'] == 1 ? 'selected': '' }} value="1">Drug History Partial</option>
                            <option  {{ $success_array['drug_history_type'] == 2 ? 'selected': '' }} value="2">Drug History Full</option>
                            <option  {{ $success_array['drug_history_type'] == 3 ? 'selected': '' }} value="3">Medication In Draft To Be Reviewed</option>
                            <option  {{ $success_array['drug_history_type'] == 0 ? 'selected': '' }} value="0">Patients To Be Reviewed</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <div class="bg-patients-count">
                            <h6>Total Patients</h6>
                            <h5>{{ count($success_array['total_patients']) }}</h5>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tab panes -->

            <div class="tab-content" id="tabcontent">
                <input type="hidden" id="tab_type" value="{{  $success_array['tab_type'] }}">
                <div id="pharmacyList" class="tab-pane active">
                    <div class="pharmacy-dashboard-contents">
                        <div class="bg-sticky"></div>
                        <div class="patients-details">
                            @if (count($success_array['patient_details']) > 0)
                                @foreach ($success_array['patient_details'] as $ward => $patient_info)
                                    <div class="wards-patients-details">
                                        <div class="sticky-header">
                                            <div class="name-header">
                                                <span>{{ $ward }} - {{ WardType($ward) }}</span>
                                            </div>
                                        </div>
                                        <div class="custom-card">
                                            <table class="breachReasonTable responsiveTable table-custom">
                                                @foreach($patient_info as $patient)
                                                    <tbody class="table-patient-tbody">
                                                    <tr class="table-patient-row-1">
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Bay & Bed</div>
                                                            <span>{{ $patient['ibox_actual_bed_full_name'] }}</span>
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Name</div>
                                                            {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore"> Hospital Number </div>
                                                            <span>  {{ $patient['camis_patient_pas_number'] }}</span>
                                                        </td>


                                                        <td class="pivoted">
                                                            <div class="tdBefore">Consultant</div>
                                                            <span>  {{ $patient['camis_consultant_name'] }}</span>
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Antibiotic IV</div>
                                                            @if(isset($patient['board_round_pharmacy_data'])  && ($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date'] != null))
                                                                <span>{{ PredefinedDateFormatShowOnCalendarDashboard($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }} </span>
                                                            @else
                                                                <span>--</span>
                                                            @endif
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Antibiotic ORAL</div>
                                                            @if(isset($patient['board_round_pharmacy_data'])  && ($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date'] != null))
                                                                <span>{{ PredefinedDateFormatShowOnCalendarDashboard($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }} </span>
                                                            @else
                                                                <span>--</span>
                                                            @endif
                                                        </td>


                                                        <td class="pivoted">
                                                            <div class="tdBefore" id="drug_history_title">
                                                                @if(isset($patient['board_round_pharmacy_data']))
                                                                    @if($patient['board_round_pharmacy_data']['pharmacy_drug_history'] == 1)Drug History Partial
                                                                    @elseif($patient['board_round_pharmacy_data']['pharmacy_drug_history'] == 2)Drug History Full
                                                                    @elseif($patient['board_round_pharmacy_data']['pharmacy_drug_history'] == 3)Medication In Draft To Be Reviewed @else  Drug History
                                                                    @endif
                                                                @else Drug History @endif</div>
                                                            @if(isset($patient['board_round_pharmacy_data']) )
                                                                <span> @if(($patient['board_round_pharmacy_data']['pharmacy_drug_history'] != 0) && ($patient['board_round_pharmacy_data']['pharmacy_drug_history_date'] != null)) {{ PredefinedDateFormatFor24Hour($patient['board_round_pharmacy_data']['pharmacy_drug_history_date']) }} @else -- @endif</span>
                                                            @else
                                                                <span>--</span>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    <tr class="table-patient-row-2">
                                                        <td class="pivoted spl-cell" rowspan="3">
                                                            <div class="header-comment">
                                                                <p class="flex-grow-1">Pharamacy Tasks</p>
                                                                <div>
                                                                    <button class="btn btn-assign-task w-auto"  @if(PermitedStatus('pharmacy_dashboard_task_filter_view')) onclick="TaskAssignFunction('{{ $patient['camis_patient_id'] }}');" @endif  data-bs-target="#camis_patient_ward_summary_boardround_assign_task"  data-bs-toggle="offcanvas" aria-controls="offcanvasRight">
                                                                        Task Assign
                                                                    </button>
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-assign-task w-auto click_open_pharmacy_task update_task_list_{{ $patient['camis_patient_id'] }}" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">All
                                                                        Tasks
                                                                    </button>
                                                                </div>

                                                            </div>
                                                            <div class="card-col-grp" id="updated_task_list_{{ $patient['camis_patient_id'] }}">
                                                                {!! GetCamisOutstandingTaskByGroup($patient['board_round_patient_tasks'], 2, $success_array['pharmacy_task_group'], null) !!}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="table-patient-row-3">
                                                        <td class="pivoted spl-cell" rowspan="3">
                                                            <div class="pharmacy-block">



                                                                <div class="comment-pharmacy">
                                                                    <div class="header-comment">
                                                                        <p class="flex-grow-1"> Pharmacy Comment (Latest) </p>
                                                                        <div class="{{ PermissionDeniedDiv('pharmacy_board_round_view') }}">
                                                                            <button class="btn btn-board-round w-auto {{ DisabledButtonOnRolePermission('pharmacy_board_round_view') }}" @if(PermitedStatus('pharmacy_board_round_view')) onclick="BoardRoundInfo('{{ $patient['camis_patient_id'] }}', '{{ strtolower($patient['ibox_ward_short_name']) }}');" @endif id="{{ $patient['camis_patient_id'] }}">Board
                                                                                Round Info
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <textarea class="form-control ibox_board_round_pharmacy_updated_comment_show_{{ $patient['camis_patient_id'] }}" id="exampleFormControlTextarea1" rows="" readonly>{{ $patient['board_round_pharmacy_data']['pharmacy_latest_comment'] ?? '' }}</textarea>
                                                                </div>



                                                                <div class="btn-grp-pharmacy">
                                                                    <div class="row gx-2">
                                                                        <div class="col">
                                                                            <a class="btn btn-darkcyan w-100 click_popup_open_ibox_board_round_pharmacy" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">Pharmacy <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 22.052 22.059">
                                                                                    <g id="plus-svgrepo-com" transform="translate(0 0)">
                                                                                        <path id="Path_20866" data-name="Path 20866" d="M8.1,22.059a.732.732,0,0,1-.733-.733V14.742H.783A.732.732,0,0,1,.05,14.01V8.052a.732.732,0,0,1,.732-.732H7.366V.733A.733.733,0,0,1,8.1,0h5.956a.732.732,0,0,1,.733.733V7.317h6.582a.732.732,0,0,1,.733.733v5.958a.732.732,0,0,1-.732.732H14.786v6.585a.732.732,0,0,1-.732.732Zm0-8.782a.732.732,0,0,1,.733.733v6.585H13.32V14.008a.732.732,0,0,1,.732-.732h6.583V8.782H14.055a.733.733,0,0,1-.733-.733V1.465H8.832V8.051a.732.732,0,0,1-.732.732H1.516v4.493Z" transform="translate(-0.05 0)" fill="#fff"></path>
                                                                                    </g>
                                                                                </svg>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col">
                                                                            <button class="btn btn-black w-100 patient_pharmacy_antibiotic_iv patient_pharmacy_antibiotic_iv_id_{{ $patient['camis_patient_id'] }}" data-camis-patient-id="{{ $patient['camis_patient_id'] }}" @if (isset($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status']) && $patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1) data-antibiotic-iv='1' @else data-antibiotic-iv='0' @endif data-old_antibiotic_iv_time="@if (isset($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) && $patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1 && !empty($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date'])){{ PredefinedDateFormatFor24Hour($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }}@endif"> Antibiotic IV <div class="lh-12">
                                                          <span class="date-time-stamp patient_antibiotic_iv_updated_date_{{ $patient['camis_patient_id'] }}">
                                                            @if (isset($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) && $patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_status'] == 1 && !empty($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']))
                                                                  {{ PredefinedDateFormatFor24Hour($patient['board_round_pharmacy_data']['pharmacy_antibiotic_iv_date']) }}
                                                              @endif
                                                         </span>
                                                                                </div>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col">
                                                                            <button class="btn btn-black w-100 patient_pharmacy_antibiotic_oral patient_pharmacy_antibiotic_oral_id_{{ $patient['camis_patient_id'] }}" data-camis-patient-id="{{ $patient['camis_patient_id'] }}" @if (isset($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status']) && $patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1) data-antibiotic-oral='1' @else data-antibiotic-oral='0' @endif data-old_antibiotic_oral_time="@if (isset($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) && $patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1 && !empty($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date'])){{ PredefinedDateFormatFor24Hour($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }}@endif"> Antibiotics Oral <div class="lh-12">
                                                          <span class="date-time-stamp patient_antibiotic_oral_updated_date_{{ $patient['camis_patient_id'] }}">
                                                            @if (isset($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) && $patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_status'] == 1 && !empty($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']))
                                                                  {{ PredefinedDateFormatFor24Hour($patient['board_round_pharmacy_data']['pharmacy_antibiotic_oral_date']) }}
                                                              @endif
                                                          </span>
                                                                                </div>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>

                                @endforeach
                            @else
                                <div class="wards-patients-details">
                                    <div class="custom_not_found">
                                        {{ NotFoundMessage() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.bg-sticky');
    var noRecords = document.querySelector('.custom_not_found');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            var bgSticky = document.querySelector('.bg-sticky');
            bgSticky.style.top = '185px';
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '185px';
            })
            var noRecords = document.querySelector('.custom_not_found');
            if (noRecords) {
                bgSticky.style.top = '90px';
                noRecords.style.marginTop = '40px';
            }
        }
        else{
            document.getElementById("stickyToprow").style.top = "60px";
            var bgSticky = document.querySelector('.bg-sticky');
            bgSticky.style.top = '160px';
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '160px';
            })


            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');
                if (noRecords) {
                    bgSticky.style.top = '60px';
                    noRecords.style.marginTop = '40px';
                }

            }
        }


    }
</script>
<script>
    var windowWidth = window.innerWidth;
    $("#hideRow").show();
    $("#hideBgSticky").addClass("bg-sticky");

</script>
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1026) {
        $("#listRow").show();

        $("#hideBgSticky").removeClass("bg-sticky");
        $(".sticky-toprow").height("92px");

        $("#pharmacyListTab").click(function () {
            $("#listRow").show();

            $("#hideBgSticky").removeClass("bg-sticky");
            $(".sticky-toprow").height("92px");

        });

    } else if (windowWidth < 1026) {
        $("#listRow").show();
        $("#screenedRow").show();
        $("#pharmacyListTab").click(function () {
            $("#listRow").show();

        });

    }
</script>

<script>
    function GetTaskByGroup(patient_id)
    {
            @if(CheckSpecificPermission('pharmacy_dashboard_task_filter_view'))
        var task_type = event.target.id
        var total_text = 'all_task_'+patient_id;

        if(task_type === total_text){
            $("#"+task_type).text('Show Pharmacy Tasks')
            event.target.id= 'pharmacy_task_'+patient_id;
            var task_group = 'all_task';

        }else{
            $("#"+task_type).text('Show All Tasks')
            event.target.id= total_text;
            var task_group = 'pharmacy_task';

        }

        // console.log(task_type,total_text);



        var url = "{{ route('pharmacy.TaskByGroup') }}";

        $.ajax({
            url: url,
            type: 'GET',
            data: {task_type:task_group,patient_id:patient_id},
            success: function (result)
            {
                if(result != '{{PermissionDenied()}}'){
                    $('#updated_task_list_'+patient_id).html(result);
                    $('.page-data-loader').hide();
                } else {
                    $('.page-data-loader').hide();
                    toastr.error('Permission Restricted.');
                }
            }
        });
        @else
        toastr.error('Permission Denied');
        @endif
    }
</script>

