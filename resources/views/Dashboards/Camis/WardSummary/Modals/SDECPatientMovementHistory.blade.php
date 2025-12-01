<div class="patients-sdec-moving-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1"
    id="sdec_patient_movement_offcanvas" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" >Patients Moving History</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('sdec_patient_movement_offcanvas');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="card-table-listing mb-2 patient_movement_offcanvas_data">

        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey  "  onclick="CloseOffcanvas('sdec_patient_movement_offcanvas');"><img
                    src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal"
                    width="12" height="12"><span>CANCEL</span>
                </button>

            </div>
        </div>
    </div>
</div>
