<div class="patients-details-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class dtoc_data" id="patientDetails" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-keyboard="false">

    <div class="modal-popup-loader-content"></div>


</div>
<div class="sau-board-round-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" id="sau_patientDetails"
    role="dialog">
    <div class="modal-popup-loader-content"></div>
</div>
<div class="modal fade comments-history-modal" id="modal_comment_history" data-bs-backdrop="false"  data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title mb-0">Comment History</h6>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100" onclick="Backdropremove();" data-bs-dismiss="modal"  data-bs-target="#modal_comment_history" aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body">
                <div class=" mb-3 camis_patient_ward_summary_dtoc_comment_history">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="timeline-modal modal fade camis_ward_summary_boardround_sub_inner_popup_common_class" id="timeline" data-bs-backdrop="false"  data-bs-keyboard="false"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title mb-0">Timeline</h6>
                <div class="">
                    <button type="button" onclick="Backdropremove();" class="btn-grey text-end w-100" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body" id="medfit_timeline_data">

            </div>
        </div>
    </div>
</div>
