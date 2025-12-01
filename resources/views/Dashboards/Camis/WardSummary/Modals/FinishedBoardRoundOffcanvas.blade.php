<div class="modal fade" data-bs-backdrop="static" id="get_board_round_user_list_with_warning" tabindex="-1"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h6 class="modal-title" id="exampleModalLabel">Complete Board Round</h6>
            </div>
            <div>
                <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                    aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <h6><span class="show_missing_number">20</span> Patients Have Not Been Reviewed During This Boardround. Are You Sure You Want To Complete  Boardround ?
                </h6>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-lg-8 offset-lg-3">
                    <div class="row g-2">
                        <div class="col-lg-4 col-md-6 col-6">
                            <button class="btn btn-primary-grey get_board_round_user_list"><img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                    class="btn-icon-modal" width="18" height="18"><span>YES</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-6 col-6">
                            <button class="btn btn-primary-grey" data-bs-dismiss="modal"
                            aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                    class="btn-icon-modal" width="12" height="12"><span>NO</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
