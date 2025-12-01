<div class="modal fade  zoom-in" id="common_error_modal_show" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="card-header fw-bold d-flex align-items-center justify-content-between ">
                ERROR
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="col-md-12 padding-zero">
                    <div class="col-md-12 padding-zero popup_alert_response_show_div">
                        <div class="alert_common alert-danger ibox_alert_styles mb-3 mt-3" role="alert"> {{ $success_array['script_error_message'] ?? '' }}</div>
                    </div>
                </div>
            </div>

            <div class="modal-footer text-center">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="btn btn-light-grey  bottom-cancel-button" data-bs-dismiss="modal"  aria-label="Close">
                        <svg width="12" height="12" viewBox="0 0 15.201 15.561" id="cancel-svg">
                            <path id="Union_12" data-name="Union 12" d="M13.995,15.355,7.6,8.961,1.209,15.355a.708.708,0,0,1-1-1L6.717,7.845a.62.62,0,0,1,0-.065c0-.022,0-.044,0-.066L.208,1.206a.707.707,0,0,1,1-1L7.6,6.6,13.995.207a.706.706,0,0,1,1,1L8.486,7.713a.636.636,0,0,1,0,.066.621.621,0,0,1,0,.065l6.508,6.508a.707.707,0,0,1-.5,1.209A.7.7,0,0,1,13.995,15.355Z" />
                        </svg>
                        <span class="btnLbl ">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in" id="common_message_for_modal_show" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
             <div class="card-header fw-bold d-flex align-items-center justify-content-between ">
                <h5 class="modal-title common_message_for_modal_show_title">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="col-md-12 padding-zero">
                    <div class="col-md-12 padding-zero popup_alert_response_show_div">
                        <div class="common_message_for_modal_show_content  mb-3 mt-3" ></div>
                    </div>
                </div>
            </div>
           <div class="modal-footer text-center">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="btn btn-light-grey  bottom-cancel-button" data-bs-dismiss="modal"  aria-label="Close">
                        <svg width="12" height="12" viewBox="0 0 15.201 15.561" id="cancel-svg">
                            <path id="Union_12" data-name="Union 12" d="M13.995,15.355,7.6,8.961,1.209,15.355a.708.708,0,0,1-1-1L6.717,7.845a.62.62,0,0,1,0-.065c0-.022,0-.044,0-.066L.208,1.206a.707.707,0,0,1,1-1L7.6,6.6,13.995.207a.706.706,0,0,1,1,1L8.486,7.713a.636.636,0,0,1,0,.066.621.621,0,0,1,0,.065l6.508,6.508a.707.707,0,0,1-.5,1.209A.7.7,0,0,1,13.995,15.355Z" />
                        </svg>
                        <span class="btnLbl ">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_round_disabled" id="camis_patient_ward_summary_boardround_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable WardboxModal" style='max-width:99%;' role="document">
        <div class="modal-content">
            <div class="camis_patient_ward_summary_boardround_modal_content"></div>

        </div>
    </div>
</div>





<div class="outstanding-tasks-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_outstanding_task" data-bs-backdrop="static"
     aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">OutStanding Task</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_outstanding_task');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="page-data-loader_two" style="z-index: 99999;"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">

        <div class="card-outstanding-tasks">
            <table class="breachReasonTable responsiveTable table-outstanding-tasks show_patient_outstanding_task" id="show_patient_outstanding_task">
                <thead>
                <tr class="position-relative">
                    <th>Task</th>
                    <th></th>
                </tr>
                </thead>

            </table>
        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_outstanding_task');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>




