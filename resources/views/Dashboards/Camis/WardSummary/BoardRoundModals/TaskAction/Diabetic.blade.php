
<div class="assign-task-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_task_dp_diabetic_status" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">Review Diabetic Status</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_task_dp_diabetic_status');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div>
            <div class="header-primary">
                <h6>Is Diabetes Suspected/ OR Known?</h6>
            </div>

        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey me-2 dp_task_diabetinc_status_yes" data-status="Yes" >
                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>CONFIRM</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey me-2 dp_task_diabetinc_status_yes" data-status="Not Applicable" >
                            <img class='loading-delete-svg-to-show-on-delete'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/dont-save.svg') }}" alt=""
                                class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="16" height="16"><span>NOT APPLICABLE</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_task_dp_diabetic_status');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
