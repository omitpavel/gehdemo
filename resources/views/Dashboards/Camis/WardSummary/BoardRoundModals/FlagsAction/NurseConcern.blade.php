
<div class="dp-tasks-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_summary_boardround_patient_nurse_concern"
    aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">DP TASKS</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_nurse_concern');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row dp-tasks">
            <div class="tasks-content-block">
                <div class="header-primary">
                    <h6>Assigning nursing concern will automatically assign the following DP tasks</h6>
                </div>
                <div class="">
                    <ul class="tasks-list">



                        @foreach($success_array['dp_task'] as $task)
                            <li>{{$task['auto_populate_task_name']}} - {{$task['task_user_group']['task_group_name'] ?? ''}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="dp-note text-center">
                <p>Please Note: Tasked to be completed will be marked as incomplete and new set of tasks will be
                    added. SOC will also be reset</p>
            </div>

        </div>


    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag">
                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" data-bs-dismiss="offcanvas" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_nurse_concern');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
