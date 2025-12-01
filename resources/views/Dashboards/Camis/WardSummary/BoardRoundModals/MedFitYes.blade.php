


<div class="medically-fit-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_summary_boardround_medically_fit_for_discharge_yes"
        aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">MEDICALLY FIT FOR DISCHARGE</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="offcanvas" data-bs-target="#camis_patient_ward_summary_boardround_medically_fit_for_discharge_yes" aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="mb-2 medfit_yes_text_consultant_block">
            <span>Consultant: <span class="fw-500 medfit_yes_consultant_head_doctor_name"></span> </span>
        </div>
        <div class="row ">

                <div class="mb-2">
                    <label class="form-label">Please enter comment</label>
                    <textarea class="form-control ibox_board_round_content_patient_medically_fit_status_comment" id="ibox_board_round_content_patient_medically_fit_status_comment" rows="8"></textarea>
                </div>
                <div class="form-check mb-2" style="padding-left: 35px !important">
                    <input class="form-check-input p-2 medfit_yes_consultant_check_input" type="checkbox" value="" id="medfit_yes_consultant_check_input">
                    <label class="form-check-label ms-3">
                        Click to acknowledge that the consultant responsible for the care of this patient has agreed
                        that the patient is medically fit to be discharged.
                    </label>
                </div>
                <div class="fw-500">
                    <p>Assigning MED FIT 'Yes' will automatically assign reason to reside with value of 'No Reason'
                        to Reside'</p>
                </div>






        </div>


    </div>

    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_medfit_for_discharge ">

                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" data-bs-dismiss="offcanvas" data-bs-target="#camis_patient_ward_summary_boardround_medically_fit_for_discharge_yes" aria-label="Close">

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
