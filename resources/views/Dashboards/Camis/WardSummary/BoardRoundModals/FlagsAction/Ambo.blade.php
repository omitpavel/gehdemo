<div class="dialysis-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_summary_boardround_patient_flag_ambo" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">AMBO</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_ambo');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row g-2">

            <div class="col-md-12">
                <div class="">
                    <label for="flag_ambo_ref" class="form-label">Ref</label>
                    <input type="text" class="form-control" id="flag_ambo_ref" placeholder="Enter Reference">
                </div>
            </div>
            <div class="col-md-12">
                <div class="">
                    <label for="flag_ambo_time" class="form-label">Time</label>
                    <div class="time-wrapper clockpicker_233">
                        <input type="text" readonly="readonly" class="clockpicker_2 form-control boardround_patient_task_estimated_time_for_completion clockpicker_2" data-estimated-time-for-completion="17:00" value="17:00" name="boardround_patient_task_estimated_time_for_completion" id="flag_ambo_time" placeholder="Enter Time">

                         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22.213 22.213">
                             <path id="time1-svgrepo-com" d="M14.106,3.5A11.106,11.106,0,1,0,25.213,14.606,11.106,11.106,0,0,0,14.106,3.5Zm-.09,20.1a8.971,8.971,0,1,1,8.971-8.971A8.971,8.971,0,0,1,14.017,23.6Zm2.593-8.455H14.064v-4.3a.845.845,0,1,0-1.691,0V15.99a.845.845,0,0,0,.846.845H16.61a.845.845,0,1,0,0-1.69Z" transform="translate(-3 -3.5)"></path>
                         </svg>
                     </div>
                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_ambo flag_button">
                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey me-2 all_modal_delete_button_for_js bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                            <img class='loading-delete-svg-to-show-on-delete'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/deselect.svg') }}" alt=""
                                class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="16" height="16"><span>DESELECT</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_ambo');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
