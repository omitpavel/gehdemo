<div class="beds-count offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" id="bedsCount" data-bs-backdrop="static" aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true" role="dialog">

        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel"><span id="wardname"></span> </h6>
                </div>
                <div class="d-flex align-items-center">
                    <div class="btn-custom-view {{ PermissionDeniedDiv('camis_list_view_name_show_hide_view') }}" @if (CheckSpecificPermission('camis_list_view_name_show_hide_view')) id="patient_name_show" @endif>
                        <button class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('camis_list_view_name_show_hide_view') }}"><img src="{{ asset('asset_v2/Template/icons/eye.svg') }}" alt="" class="btn-icon-modal"
                                width="16" height="16">
                        </button>
                    </div>
                    <div class="btn-custom-view content_display_none {{ PermissionDeniedDiv('camis_list_view_name_show_hide_view') }}" @if (CheckSpecificPermission('camis_list_view_name_show_hide_view')) id="patient_name_hide" @endif>
                        <button class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('camis_list_view_name_show_hide_view') }}"><img src="{{ asset('asset_v2/Template/icons/eye.svg') }}" alt="" class="btn-icon-modal"
                                width="16" height="16">
                        </button>
                    </div>
                    <button type="button" class="btn-grey text-end w-100" onclick="CloseBedCountModal();"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body">
            <div class="row">
                <div class="container-fluid">
                    <div class="col-lg-12"  id="ward_content">
                    </div>
                </div>

            </div>
        </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseBedCountModal();"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>



<div class="bed-status-modal modal fade camis_ward_summary_boardround_sub_inner_popup_common_class" id="bed_details_modal"  data-bs-backdrop="false" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h6 class="modal-title" id="exampleModalLabel">ADD BED STATUS</h6>
                    </div>
                    <div>
                        <button type="button" class="btn-grey text-end w-100 close_bed_update"
                            aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                            CLOSE</button>
                    </div>
                </div>
                <div class="modal-popup-loader-content"></div>
                <div class="modal-body ward_summary_sub_modal_inner_body" id="bed_status_data">

                </div>
                <div class="modal-footer">
                    <div class="row gx-2 ibox_modal_footer_button_class">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="row gx-2">
                                <div class="col-lg-6 col-md-6 col-6">
                                    <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_bed_status">
                                        <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                                        <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                            class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                                    </button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-6">
                                    <button class="btn btn-primary-grey close_bed_update" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
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









    <div class="potential-discharge-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" id="definite_patient_modal" aria-labelledby="offcanvasRightLabel" data-bs-backdrop="static">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">DEFINITE DISCHARGE PATIENT LISTS</h6>
                </div>
                <div class="d-flex align-items-center">
                    <div class="btn-custom-discharges {{ PermissionDeniedDiv('pd_dashboard') }}" onclick="window.location.href = '{{ route('site.pd_discharge') }}'">
                        <button class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('pd_dashboard') }}"><span>Definite/Potential
                                Discharges</span>
                        </button>
                    </div>
                    <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('definite_patient_modal');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body">
            <div class="potential-dsicharge-list"  id="definite_patient_list_data">

            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('definite_patient_modal');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="potential-discharge-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" id="potential_patient_modal" data-bs-backdrop="static" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">POTENTIAL DISCHARGE PATIENT LISTS</h6>
                </div>
                <div class="d-flex align-items-center">
                    <div class="btn-custom-discharges {{ PermissionDeniedDiv('pd_dashboard') }}" onclick="window.location.href = '{{ route('site.pd_discharge') }}'">
                        <button class="btn btn-primary-grey {{ DisabledButtonOnRolePermission('pd_dashboard') }}"><span>Definite/Potential
                                Discharges</span>
                        </button>
                    </div>
                    <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('potential_patient_modal');"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body">
            <div class="potential-dsicharge-list" id="potential_patient_list_data">

            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('potential_patient_modal');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>




    <div class="bay-status  modal fade" id="bayClose"  aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">Bay Status</h6>
                </div>
                <div>
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-lg-12">
                            <div class="row gx-2">
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="input_bay_status" id="open"
                                            value="0" checked>
                                        <label class="form-check-label" for="open">
                                            Bay Status - Open
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="input_bay_status"
                                            id="restricted" value="2">
                                        <label class="form-check-label" for="restricted">
                                            Bay Status - Restricted
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="input_bay_status"
                                            id="closed" value="1">
                                        <label class="form-check-label" for="closed">
                                            Bay Status - Closed
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_bay_status ">

                                    <img class='loading-save-svg-to-show-on-save'
                                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                                alt="" />
                                    <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                        class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary-grey" data-bs-dismiss="modal"
                                aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                        class="btn-icon-modal" width="14" height="14"><span>CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


