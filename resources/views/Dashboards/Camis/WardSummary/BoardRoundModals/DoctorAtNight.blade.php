

<div class="doctor-night-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_ward_summary_boardround_doctors_at_night"
     aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">DOCTOR AT NIGHT</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="offcanvas"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body show_doctors_at_night_task ward_summary_sub_modal_inner_body">

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2 ibox_modal_footer_button_class bottom-save-button">
                    <div class="col-lg-6 col-md-6 col-6 {{ PermissionDeniedDiv('camis_doctor_at_night_add') }}">
                        <button class="all_modal_save_button_for_js btn btn-primary-grey camis_patient_ward_summary_boardround_update_doctor_at_night me-2 {{ DisabledButtonOnRolePermission('camis_doctor_at_night_add') }}">
                            <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal normal-save-svg-to-show-on-save" width="16" height="16"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn btn-primary-grey"  data-bs-dismiss="offcanvas" aria-label="Close" type="button">
                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="14" height="14"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


