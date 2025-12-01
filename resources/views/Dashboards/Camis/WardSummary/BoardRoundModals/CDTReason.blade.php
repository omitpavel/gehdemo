<div class="referral-again-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1"
id="camis_cdt_details_offcanvas" aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true"
role="dialog">
<div class="offcanvas-header card-header fw-bold">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="">
            <h6 class="mb-0" id="offcanvasRightLabel">CDT Refferal</h6>
        </div>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_cdt_details_offcanvas');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
</div>
<div class="modal-popup-loader-content"></div>
<div class="offcanvas-body ward_summary_sub_modal_inner_body">
    <div class="row ">
        <label for="cdt_comment" id="cdt_status_text">Comments</label>
        <div class="">
            <textarea class="form-control" disabled
                id="cdt_comment"
                rows="6"></textarea>
        </div>
    </div>
</div>
<div class="offcanvas-footer">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="row g-2">
                <div class="col-lg-6 col-md-6 col-6">
                    <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button cdt_to_review ">

                        <img class='loading-save-svg-to-show-on-save'
                                    src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                    alt="" />
                        <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                            class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>REFERRAL AGAIN</span>
                    </button>
                </div>
                <div class="col-lg-6 col-md-6 col-6">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_cdt_details_offcanvas');">

                        <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                            class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
