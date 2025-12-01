
<div class="assign-task-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_task_dp_working_diagnosis_update" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">Working Diagnosis Update On Ibox</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_task_dp_working_diagnosis_update');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">

        <div class="row ">
            <div class="col-lg-12 ">
                    <div class="row mb-3">
                       <div class="col-12 ">


                           <div class="mb-2">
                               <textarea name="working_diagnosis_update_text" class="form-control ibox_board_round_working_diagnonsis_update_text" id="ibox_board_round_working_diagnonsis_update_text"
                                   placeholder="Please enter comment" rows="6"></textarea>
                           </div>
                       </div>
                   </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_working_diagnosis_update">
                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>CONFIRM</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_task_dp_working_diagnosis_update');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
