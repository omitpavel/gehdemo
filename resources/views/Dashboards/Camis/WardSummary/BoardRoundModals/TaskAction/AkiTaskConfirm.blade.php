
<div class="aki-assessment-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_ward_summary_boardround_confirm_aki_task" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">AKI Assessment</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_confirm_aki_task');" 
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div>
            <div class="header-primary">
                <h6>Automatically assign the following AKI tasks</h6>
            </div>
            <div class="questions-list">
                <ul  id="aki_assigned_task">

                </ul>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-4 offset-lg-4">
                <div class="row g-2">

                    <div class="col-12">
                        <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_confirm_aki_task');">

                            <span>CONFIRM</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
