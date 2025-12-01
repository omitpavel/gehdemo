

<style>
    .time-wrapper {
        position: relative;
    }

    .time-wrapper svg {
        position: absolute;
        top: 6px;
        right: 10px;
    }
</style>
<div class="assign-task-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_summary_boardround_assign_task"
     aria-labelledby="offcanvasRightLabel" style="z-index: 1111 !important;">

    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">ASSIGN TASK</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_assign_task');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row ">
            <input type="hidden" name="boardround_patient_task_category" id="boardround_patient_task_category">
            <input type="hidden" class='boardround_patient_task_id_update ibox_board_round_patient_task_description_open ui-autocomplete-input' name="boardround_patient_task_id_update" id="boardround_patient_task_id_update" value="" />
            <div class="mb-2">
                <label class="form-label">Task</label>
                <input type="text" class="form-control boardround_patient_task_description" id="boardround_patient_task_description" aria-describedby="">
            </div>
            <div class="mb-2">
                <select class="form-select boardround_patient_task_group"  id='boardround_patient_task_group' name="boardround_patient_task_group">
                    <option value="">Select User Group</option>
                    @if (!empty(AllTaskGroup()))
                        @foreach (AllTaskGroup() as $row)
                            <option {{ $row->id =='43' ? "selected":'' }}  value="{{ $row->task_group_name }}">{{ $row->task_group_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-2">
                <div class="row">
                    <div class="col-md-6 mb-2 pe-md-1">
                        <div>
                            <input id="boardround_patient_task_estimated_date_for_completion"  readonly="readonly" class="datepickerInput form-control boardround_patient_task_estimated_date_for_completion" data-estimated-date-for-completion="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">

                        </div>
                    </div>
                    <div class="col-md-6  mb-2 ps-md-1">
                        <div class="time-wrapper clockpicker_233">
                            <input type="text" readonly="readonly" class="form-control boardround_patient_task_estimated_time_for_completion clockpicker_2" data-estimated-time-for-completion="{{ date('H') . ':00' }}" value="{{ date('H') . ':00' }}" name="boardround_patient_task_estimated_time_for_completion" id="boardround_patient_task_estimated_time_for_completion" placeholder="Task Estimated Completion Time">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                 viewBox="0 0 22.213 22.213">
                                <path id="time1-svgrepo-com"
                                      d="M14.106,3.5A11.106,11.106,0,1,0,25.213,14.606,11.106,11.106,0,0,0,14.106,3.5Zm-.09,20.1a8.971,8.971,0,1,1,8.971-8.971A8.971,8.971,0,0,1,14.017,23.6Zm2.593-8.455H14.064v-4.3a.845.845,0,1,0-1.691,0V15.99a.845.845,0,0,0,.846.845H16.61a.845.845,0,1,0,0-1.69Z"
                                      transform="translate(-3 -3.5)" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="row  g-2 mb-2">
                    <div class="col-md-4 ">
                        <button type="button" class="btn btn-primary-grey w-100 ibox_board_round_patient_task_assign_priority_inner">PRIORITY 1</button>
                    </div>
                    <div class="col-md-4 ">
                        <button type="button" class="btn btn-primary-grey w-100 ibox_board_round_patient_task_assign_morning_evening_inner">MORNING BOARD ROUND</button>
                    </div>
                    <div class="col-md-4 ">
                        <button type="button" class="btn btn-primary-grey w-100 ibox_board_round_patient_task_assign_daily_inner">ADD AS DAILY</button>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Please enter comment</label>
                <textarea class="form-control boardround_patient_task_comment" id="boardround_patient_task_comment" rows="8"></textarea>
            </div>


        </div>


    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_task_create_or_update_inPharmacy"><img class='loading-save-svg-to-show-on-save'
                                                                                                                                                                                   src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                                                                                                                                                                   alt="" /><img src="{{asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey bottom-delete-button camis_patient_ward_summary_boardround_cancel_task_create_or_update" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_assign_task');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
