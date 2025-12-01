

<div class="handover-modal modal fade" id="handoverModal" tabindex="-1" data-bs-backdrop="static"   aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">HAND OVER DETAILS</h6>
                </div>
                <div>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('handoverModal');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-body" id="HandOverModalContent">

            </div>



        </div>
    </div>
</div>



<div class="modal fade" id="HandOverPrintFilterPopUpModal" tabindex="-1" data-bs-backdrop="static"   aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">Handover Print Customization</h6>
                </div>
                <div>
                    <button type="button" class="btn-grey text-end w-100" onclick="ShowHandoverFilterPopUpClose();"  id="HandOverPrintFilterPopupCancel" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>

            <div class="modal-body" id="HandOverModalPopUpContent">
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-8 offset-lg-3">
                        <div class="row g-2 ibox_modal_footer_button_class">
                            <div class="col-lg-4 col-md-6 col-6">
                                <button class="btn btn-primary-grey  bottom-save-button" onclick="PrintHandoverDetailsWithFilterData();"><img src="{{ asset("/asset_v2/Template/icons/print.svg") }}" alt="" class="btn-icon-modal" width="18" height="18"><span>YES</span>
                                </button>
                            </div>
                            <div class="col-lg-4 col-md-6 col-6">
                                <button class="btn btn-primary-grey  bottom-cancel-button bottom-cancel-button"  id="HandOverPrintFilterPopupCancel" onclick="ShowHandoverFilterPopUpClose();" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset("/asset_v2/Template/icons/cancel.svg") }}" alt="" class="btn-icon-modal" width="12" height="12"><span>NO</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

