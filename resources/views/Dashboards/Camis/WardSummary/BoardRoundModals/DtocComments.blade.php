<div class="discharge-comments offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1"
        id="camis_dtoc_all_comments" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Discharge Tracker Comments</h6>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_dtoc_all_comments');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
                </div>
            </div>
        </div>
        <div class="offcanvas-body" id="viewAllCommentsBody">

        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('camis_dtoc_all_comments');"><img src="{{asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
                </div>
            </div>
        </div>
    </div>
