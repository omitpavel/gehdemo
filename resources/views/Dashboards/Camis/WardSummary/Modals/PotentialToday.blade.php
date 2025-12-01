<div class="potential-discharge-offcanvas offcanvas offcanvas-end" tabindex="-1" id="potentialDischargeList" data-bs-backdrop="static" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">POTENTIAL DISCHARGE PATIENT LISTS</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="btn-custom-print">
                    <button class="btn btn-primary-grey print_potential_discharges" id="potential_definite_print"><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16" height="16"><span class="d-none d-md-block">PRINT</span>
                    </button>
                </div>
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('potentialDischargeList');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="potential-dsicharge-list potential_discharge_list">



        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('potentialDischargeList');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>
