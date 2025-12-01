


<div class="missing-boardound-patients  offcanvas offcanvas-end" tabindex="-1" id="missung_board_round_offcanvas" aria-labelledby="offcanvasRightLabel" data-bs-backdrop="static">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0">Patients NOT Updated During This Board Round Session </h6>
            </div>
            <div class="d-flex align-items-center">

                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('missung_board_round_offcanvas');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body missing_board_round_patient_list" id="missing_board_round_patient_list">




    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('missung_board_round_offcanvas');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>




