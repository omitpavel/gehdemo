
<div class="plasma-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_ward_summary_boardround_patient_flag_plasma" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">PLASMA</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_plasma');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div>
            <div class="row mb-2 ">
                <div class="col-lg-12 ">
                    <div class="row g-2">
                        <div class="col-lg-6 col-md-6">
                            <button data-plasma-id="1" type="button" class="btn btn-primary-grey ibox_boardround_patient_flag_plasma_button ibox_boardround_patient_flag_plasma_on_plasma"> ON
                                PLASMA</button>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <button data-plasma-id="2" type="button" class="btn btn-primary-grey ibox_boardround_patient_flag_plasma_button ibox_boardround_patient_flag_plasma_requiring_plasma"> REQUIRING
                                PLASMA</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2 ">
            <div class="row g-2">
                <div class="col-lg-4 col-md-4">
                    <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_plasma flag_button">
                        <img class='loading-save-svg-to-show-on-save'
                                    src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                    alt="" />
                        <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                    </button>
                </div>
                <div class="col-lg-4 col-md-4">
                    <button class="btn btn-primary-grey all_modal_delete_button_for_js bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete'
                                    src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}"
                                    alt="" />
                        <img src="{{ asset('asset_v2/Template/icons/deselect.svg') }}" alt="" class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="16" height="16"><span>DESELECT</span>
                    </button>
                </div>
                <div class="col-lg-4 col-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_plasma');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
