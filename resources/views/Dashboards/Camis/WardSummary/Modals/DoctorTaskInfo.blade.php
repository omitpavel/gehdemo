
<div class="offcanvas-header card-header fw-bold" id="header_title">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div>
            @if($success_array['type'] == 'doctor')
                <h6  class="mb-0" id="drworkplanPopLabel"> {{ $success_array['patient_name'] }} WORK PLAN - {{ count($success_array['patients']) }} Patients & {{ count($success_array['task_of_patients']) }} Tasks </h6>
            @elseif($success_array['type'] == 'others')
                <h6  class="mb-0" id="drworkplanPopLabel"> {{ $success_array['task_group_name'] }} WORK PLAN - {{ count($success_array['patients']) }} Patients & {{ count($success_array['task_of_patients']) }} Tasks </h6>
            @endif
        </div>
        <div>
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('drworkplanPop');"
                    aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>

</div>
<div class="modal-popup-loader-content" ></div>
<div class="offcanvas-body ward_summary_sub_modal_inner_body doctors-plan-modal">



    @php
        $patientIds = $success_array['task_of_patients']->pluck('patient_id')->toArray();

    @endphp

    <div class="doctor-work-plan" id="workplan_wo" >

        <div class="mb-2">
            <input type="hidden" class="type_of_modal" value="{{ $success_array['type'] }}">
            <input type="hidden" class="type_id" value="{{ $success_array['type_id'] }}">
            <select class="form-select" name="doctor_task_name" id="doctortask_filter" aria-label="Default select example">
                @if($success_array['type'] == 'doctor')
                    <option {{ $success_array['filter_value'] == "all_doc" ? "selected":'' }} value="all_doc">All Doctor</option>
                    @foreach( $success_array['all_consultant']  as  $consultant)
                        <option {{ $success_array['filter_value'] == $consultant ? "selected":'' }} value="{{ $consultant }}">{{ $consultant }}</option>
                    @endforeach
                @elseif($success_array['type'] == 'others')
                    @foreach($success_array['task_groups'] as $task_data)
                        <option {{ $success_array['filter_value'] == $task_data->id  ? "selected":'' }} value="{{ $task_data->id }}">{{ $task_data->task_group_name  }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        @if(count($success_array['patients']) > 0)

            @foreach($success_array['patients'] as $patient_data)
                @if(in_array($patient_data->camis_patient_id, $patientIds))
                    <div class="work-plan-wrapper">
                        <div class="work-plan mb-2" >

                            <div class="name-header" >
                                <h6>{{ $patient_data->camis_patient_forename }} - {{ $patient_data->ibox_actual_bed_full_name }}</h6>
                            </div>
                            @if(count($success_array['task_of_patients'])>0)
                                @foreach($success_array['task_of_patients'] as $task)
                                    @if($task->patient_id == $patient_data->camis_patient_id)
                                        <div class="plan-details" >
                                            <div class="row align-items-center">
                                                <div class="col-md-8 pe-md-1">
                                                    <ul >

                                                        <li class="plan-header" > @if($task->task_priority == 1) ! @endif @if($task->task_category) {{  @$task->PatientTaskCategory->task_category_name }} - @endif {{ $task->task_description }}</li>
                                                        <li>Assigned To {{ $task->PatientTaskGroup? $task->PatientTaskGroup->task_group_name : '' }} :({{  PredefinedDateFormatOnTask($task->task_estimated_date_for_completion) }}) </li>
                                                    </ul>
                                                </div>
                                                @if($success_array['type'] == 'doctor')
                                                    <div class="col-md-4 ps-md-1">
                                                        <button type="button" class="btn btn-primary-grey w-100 @if(!in_array($task->task_category, [6,7,8]) && CheckSpecificPermission('camis_doctor_word_plan_modal_update')) click_to_complete_buttons @endif" @if(!in_array($task->task_category, [6,7,8]) && CheckSpecificPermission('camis_doctor_word_plan_modal_update')) id="task_id{{$task->id}}" data-value="{{ $task->id }}" onclick="StoreId(this.id)" @else @if(!CheckSpecificPermission('camis_doctor_word_plan_modal_update')) onclick='toastr.error("Permission Denied");' @else onclick='toastr.warning("DP Task Can Only Be Modified From Board Round");' @endif style="opacity: 0.4;" @endif >CLICK TO
                                                            COMPLETE</button>
                                                    </div>
                                                @elseif($success_array['type'] == 'others')
                                                    <div class="col-md-4 ps-md-1">
                                                        <button type="button" class="btn btn-primary-grey w-100 @if(!in_array($task->task_category, [6,7,8]) && CheckSpecificPermission('camis_nurse_word_plan_modal_update')) click_to_complete_buttons @endif" @if(!in_array($task->task_category, [6,7,8]) && CheckSpecificPermission('camis_nurse_word_plan_modal_update')) id="task_id{{$task->id}}" data-value="{{ $task->id }}" onclick="StoreId(this.id)" @else @if(!CheckSpecificPermission('camis_nurse_word_plan_modal_update')) onclick='toastr.error("Permission Denied");' @else onclick='toastr.warning("DP Task Can Only Be Modified From Board Round");' @endif style="opacity: 0.4;" @endif >CLICK TO
                                                            COMPLETE</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class=" No_record_css bg-assigned-details">
                                    <div class="work-plan mb-2">
                                        <h6>No Records Found!</h6>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class=" No_record_css bg-assigned-details">
                        <div class="work-plan mb-2">
                            <h6>No Records Found!</h6>

                        </div>
                    </div>

                @endif

            @endforeach
        @else
            <div class=" No_record_css bg-assigned-details">
                <div class="work-plan mb-2">
                    <h6>No Records Found!</h6>

                </div>
            </div>

        @endif


        <input type="hidden" value="" id="selected_task_id">


    </div>
</div>
<div class="offcanvas-footer">
    <div class="row">
        <div class="col-12">
            <div class="row g-2">
                @if($success_array['type_id'] == $success_array['doctor_task_id'])
                    <input type="hidden" value="{{ $success_array['patients_total'] }}" id="doctor_task">
                    <div class="col-lg-4 col-md-4 {{ PermissionDeniedDiv('camis_doctor_word_plan_modal_update') }}">
                        <button  type="button" class=" @if(count($success_array['task_of_patients'])== 0) disabled @endif btn btn-primary-grey w-100" id="save_button_dr"><img src="{{ asset('asset_v2/Template/icons/save.svg') }}"
                                                                                                                                                                               alt="" class="btn-icon-modal" width="16"
                                                                                                                                                                               height="16"><span>SAVE</span></button>
                    </div>
                    <div class="col-lg-4 col-md-4 {{ PermissionDeniedDiv('camis_doctor_word_plan_modal_print') }}">
                        <button type="button" class=" @if(count($success_array['task_of_patients']) == 0) disabled @else print_doctor_task @endif btn btn-primary-grey w-100 {{ DisabledButtonOnRolePermission('camis_doctor_word_plan_modal_print') }}"><img
                                src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16"
                                height="16"><span>PRINT</span></button>
                    </div>
                    <div class="col-lg-4 col-md-4 {{ PermissionDeniedDiv('camis_doctor_word_plan_modal_print') }}">
                        <button type="button"  class=" @if(count($success_array['task_of_patients']) == 0) disabled @else print_doctor_task_wo @endif btn btn-primary-grey w-100 {{ DisabledButtonOnRolePermission('camis_doctor_word_plan_modal_print') }}"><img
                                src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16"
                                height="16"><span>PRINT W/O
                                    PAGEBREAK</span></button>
                    </div>
                @elseif($success_array['type'] == 'others')
                    @if($success_array['type_id'] == $success_array['nurse_task_id'])
                        <input type="hidden" value="{{ count($success_array['task_of_patients']) }}" id="nurse_task">
                    @endif
                    <div class="col-lg-4 col-md-4  {{ PermissionDeniedDiv('camis_nurse_word_plan_modal_update') }}">
                        <button type="button"  id="save_button_dr" class=" @if(count($success_array['task_of_patients']) == 0) disabled @endif btn btn-primary-grey w-100 {{ DisabledButtonOnRolePermission('camis_nurse_word_plan_modal_update') }}"><img src="{{ asset('asset_v2/Template/icons/save.svg') }}"
                                                                                                                                                                                                                                                           alt="" class="btn-icon-modal" width="16"
                                                                                                                                                                                                                                                           height="16"><span>SAVE</span></button>
                    </div>
                    <div class="col-lg-4 col-md-4 {{ PermissionDeniedDiv('camis_nurse_word_plan_modal_print') }}">
                        <button type="button" class=" @if(count($success_array['task_of_patients']) == 0) disabled @else print_doctor_task @endif btn btn-primary-grey w-100 {{ DisabledButtonOnRolePermission('camis_nurse_word_plan_modal_print') }}"><img
                                src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16"
                                height="16"><span>PRINT</span></button>
                    </div>
                    <div class="col-lg-4 col-md-4 {{ PermissionDeniedDiv('camis_nurse_word_plan_modal_print') }}">
                        <button type="button"  class=" @if(count($success_array['task_of_patients']) == 0) disabled @else print_doctor_task_wo @endif btn btn-primary-grey w-100 {{ DisabledButtonOnRolePermission('camis_nurse_word_plan_modal_print') }}"><img
                                src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16"
                                height="16"><span>PRINT W/O
                                    PAGEBREAK</span></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<script>
    @if($success_array['type'] == 'doctor')
    $(document).ready(function () {

        var group =   $('#doctortask_filter').val()

        if(group == '{{ $success_array['doctor_task_id'] }}'){
            var initialNurseTaskValue = $("#doctor_task").val();
            $('#total_doctor_task').html(initialNurseTaskValue);
        }
        var initialNurseTaskValue = $("#doctor_task").val();
        $('#total_doctor_task').html(initialNurseTaskValue);

    });
    @endif
    @if($success_array['filter_value'] == $success_array['nurse_task_id'])
    $(document).ready(function () {
        var initialNurseTaskValue = $("#nurse_task").val();
        $('#total_nurse_task').html(initialNurseTaskValue);

    });
    @endif
</script>


