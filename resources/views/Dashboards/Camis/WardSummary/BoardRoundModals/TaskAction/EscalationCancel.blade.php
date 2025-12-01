<div class="escalation-status-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_task_dp_escalation_status_cancel" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Escalation Status</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_task_dp_escalation_status_cancel');"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div>

            <div class="reasons-list-block mb-3">
                <ul class="reason-list">
                    <li> <input class="form-check-input p-2" type="checkbox" name="eol" id="eol_checkbox">
                    </li>
                    <li>EOL</li>
                </ul>
                <ul class="reason-list">
                    <li><input class="form-check-input p-2" name="others" id="others_checkbox" type="checkbox">
                    </li>
                    <li>Other</li>

                </ul>
             </div>

             <div class="mb-2">
                <label class="form-label">Please enter comment</label>
                <textarea class="form-control ibox_board_round_escalation_text" id="ibox_board_round_escalation_text" rows="6"></textarea>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_escalation_cancel">
                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>CONFIRM</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey " onclick="CloseOffcanvas('camis_task_dp_escalation_status_cancel');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
