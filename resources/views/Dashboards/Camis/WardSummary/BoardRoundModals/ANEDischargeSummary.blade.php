
<div class="ae-summary-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="ane_patient_history_all_symphony_data"
    aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="a_e_discharge_summary_title">A&E DISCHARGE SUMMARY <span id="symphony_search_curr_attendance_note"></span></h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('ane_patient_history_all_symphony_data');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>

    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body print_ane_summary" id="symphony_data_search_show_data_sec_body_print">
        <div  id="symphony_data_search_show_data_sec_body"> </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2 footer-offcanvas" id="grey-btns-group">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <button class="btn btn-primary-grey btn-large mb-2 w-100 symphony_search_patient_popup_back" id="symphony_search_patient_popup_back"><img src="{{ asset('asset_v2/Template/icons/previous.svg') }}" alt=""
                        class="btn-icon-modal" width="16" height="16"><span>PREVIOUS ATTENDANCE <span id='symphony_search_prev_attendance_note' class='symphony_search_prev_attendance_note'></span></span>
                </button>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <button class="btn btn-primary-grey mb-2 w-100 symphony_search_patient_popup_next" id="symphony_search_patient_popup_next"><img src="{{ asset('asset_v2/Template/icons/next-right.svg') }}" alt=""
                        class="btn-icon-modal" width="16" height="16"><span>NEXT ATTENDANCE<span id='symphony_search_next_attendance_note'></span></span>
                </button>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6">
                <button class="btn btn-primary-grey mb-2 w-100 print_ane_discharge_summary inactive" onclick="PrintPage('ane_patient_history_all_symphony_data','')" id="symphony_search_patient_popup_print" disabled><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt=""
                        class="btn-icon-modal" width="16" height="16"><span>PRINT</span>
                </button>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6">
                <button class="btn btn-primary-grey mb-2 w-100" onclick="CloseOffcanvas('ane_patient_history_all_symphony_data');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                        class="btn-icon-modal" width="14" height="14"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>
