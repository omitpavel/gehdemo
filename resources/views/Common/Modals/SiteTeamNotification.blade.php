<div class="notification-panel offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
    tabindex="-1" id="site_team_notification_offcanvas" aria-labelledby="site_team_notification_offcanvasLabel">

    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="site_team_notification_offcanvasLabel">NOTIFICATIONS</h6>
        <button type="button" class="btn-grey text-end "
            onclick="CloseOffcanvas('site_team_notification_offcanvas');"><img
                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                class="me-3">
            CLOSE</button>

    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body site_team_notification_offcanvas_data">

    </div>
</div>
<div class="action-reason-modal modal fade camis_ward_summary_boardround_sub_inner_popup_common_class"
    id="notification_reject_reason" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">Add Reason</h6>
                </div>
                <div>
                    <button type="button" class="btn-grey text-end w-100"  onclick="closeModal('notification_reject_reason');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                            width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body">
                <div class="">
                    <input type="hidden" id="move_to_notification_patient_id" value="" />
                    <textarea class="form-control" id="move_to_notification_reject_reason" rows="6"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row g-0">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="row g-2 ibox_modal_footer_button_class">
                            <div class="col-md-6">
                                <button
                                    class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_move_to_reject_reason"><img
                                        class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                                    <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                        class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                        height="18">
                                    <span>SAVE</span>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary-grey"  onclick="closeModal('notification_reject_reason');"><img
                                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                        class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
