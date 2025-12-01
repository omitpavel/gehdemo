
<div class="discharge-summary-modal offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"  id="dischargeSummary" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">DISCHARGE SUMMARY</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('dischargeSummary');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg')  }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body ibox_discharge_summary_body"  id="summery_data">


    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2 ">
            <div class="col-md-3 offset-md-3 {{ PermissionDeniedDiv('discharged_dashboard_patient_board_round_info_view') }}">

                <button class="btn btn-primary-grey mb-2 mb-md-0  @if(PermitedStatus('discharged_dashboard_patient_board_round_info_view')) print_ibox_discharge_summary @endif "><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt=""
                                                                                                                                                                                           class="btn-icon-modal" width="16" height="16"><span>PRINT</span>
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary-grey mb-2 mb-md-0"  onclick="CloseOffcanvas('dischargeSummary');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                                                                                   class="btn-icon-modal" width="14" height="14"><span>CANCEL</span>
                </button>
            </div>
        </div>
    </div>
</div>
