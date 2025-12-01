<div class="modal fade" id="breach_dashboard_ambulance_data_update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">Ambulance Data</h6>
                </div>
                <div>
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-body ">
                <div id="breach_dashboard_ambulance_data_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="row g-2">
                    <div class="col-md-6 mb-1">
                        <label for="min_30_count" class="form-label">Total Ambulances Over
                            30 Mins
                        </label>
                        <input type="number" class="form-control" id="min_30_count" name="min_30_count" placeholder="" autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="min_60_count" class="form-label">Total Ambulances Over
                            60 Mins </label>
                        <input type="number" class="form-control" name="min_60_count" id="min_60_count" placeholder="" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="row g-2 ibox_modal_footer_button_class">
                            <div class="col-lg-6 col-md-6 col-6 {{ PermissionDeniedDiv('breach_dashboard_ambulance_data_update') }}">
                                <button type="button" class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('breach_dashboard_ambulance_data_update') }}  breach_dashboard_save_ambulance_count all_modal_save_button_for_js bottom-save-button">
                                    <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                                    <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                                        class="btn-icon-modal" width="18" height="18"><span>SAVE</span>
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-primary-grey  breach_dashboard_cancel_ambulance_count bottom-cancel-button" data-bs-dismiss="modal"  aria-label="Close">
                                    <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
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










<div class="breach-reason-modal modal fade " id="breach_dashboard_breach_reason_update" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="card-header fw-bold d-flex align-items-center justify-content-between ">
                <div class="">
                    <h6 class="mb-0">Breach Reason</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('asset_v2/Ibox/Images/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">
                    <div class="card-body" id="modal-breach-reason">
                        <div class="row  gx-2 mb-1">
                            <div class="breach_dashboard_breach_reason_update_content_data_load" style="min-height:calc(100vh - 120px);"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="row gx-2">
                            <div class="col-lg-3 col-md-6 col-6 mb-1 pe-lg-0">
                                <button type="button" class="btn btn-primary-grey me-2 bottom-prev-button-disabled breach_reason_attendance_previous_patient">
                                    <img src="{{ asset('asset_v2/Template/icons/previous.svg') }}" alt="" class="btn-icon-modal" width="16" height="16">
                                    <span>PREVIOUS</span>
                                </button>
                            </div>

                            <div class="col-lg-3 col-md-6 col-6 mb-1 pe-lg-0">
                                <button type="button" class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button-disabled breach_reason_attendance_save_patient">
                                    <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                                    <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal normal-save-svg-to-show-on-save" width="16" height="16">
                                    <span>SAVE</span>
                                </button>
                            </div>

                            <div class="col-lg-3 col-md-6 col-6 mb-1 pe-lg-0">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-primary-grey me-2 bottom-cancel-button breach_reason_attendance_cancel_patient">
                                    <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="14" height="14">
                                    <span>CANCEL</span>
                                </button>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6 mb-1 pe-lg-0">
                                <button type="button" class="btn btn-primary-grey me-2 bottom-next-button-disabled breach_reason_attendance_next_patient">

                                    <img src="{{ asset('asset_v2/Template/icons/next-right.svg') }}" alt="" class="btn-icon-modal" width="16" height="16">
                                    <span>NEXT</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
