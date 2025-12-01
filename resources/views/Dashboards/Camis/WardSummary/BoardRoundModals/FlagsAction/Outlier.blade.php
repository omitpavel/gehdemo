<div class="dialysis-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_summary_boardround_patient_flag_outlier" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Outlier</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_outlier');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row reside-contents">
            <div class="reason-content-block">
                <div class="header-primary">
                    <h6>Please Select One Option </h6>
                </div>
                <div class="reasons-list-block">
                    <ul class="reason-list">
                        <li> <input class="form-check-input" type="radio" name="flag_outlier_value"
                                value="Surgical"></li>
                        <li>Surgical</li>

                    </ul>
                </div>
                <div class="reasons-list-block">
                    <ul class="reason-list">
                        <li> <input class="form-check-input" type="radio"  name="flag_outlier_value"
                                value="Gynaecology"></li>
                        <li>Gynaecology</li>
                    </ul>
                </div>
                <div class="reasons-list-block">
                    <ul class="reason-list">
                        <li> <input class="form-check-input" type="radio" name="flag_outlier_value"
                                value="Orthopaedics"></li>
                        <li>Orthopaedics</li>

                    </ul>
                </div>
                <div class="reasons-list-block">
                    <ul class="reason-list">
                        <li> <input class="form-check-input" type="radio" name="flag_outlier_value"
                                value="Other"></li>
                        <li>Other</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_outlier flag_button">
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
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_outlier');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
