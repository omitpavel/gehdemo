<div class=" pharmacy-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_ward_summary_boardround_pharmacy" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">PHARMACY</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                      onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_pharmacy');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row camis_patient_ward_summary_boardround_pharmacy_inner">

        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_pharmacy_info ">
                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_pharmacy');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

