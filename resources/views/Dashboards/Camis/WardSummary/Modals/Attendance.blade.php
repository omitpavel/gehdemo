<div class="assign-task-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_boardround_attendance" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">Attendance</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_boardround_attendance');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">

        <div class="row ">
            <div class="col-lg-12 ">
                <div class="allow-move">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 ">
                                <div class="row g-2 mb-2 pharmacy-btn-grp" id="attendance_user_list">

                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row" id="grey-btns-group">
            <div class="col-lg-6 offset-lg-3">
                <div class="row ibox_modal_footer_button_class">
                    <div class="col-lg-6 col-md-6 mb-2 pe-md-1">
                        <button class="btn btn-primary-grey w-100 save_attendance_ward  all_modal_save_button_for_js bottom-save-button" onclick="CloseOffcanvas('camis_boardround_attendance');"><img
                                src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal"
                                width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-2 ps-md-1">
                        <button class="btn btn-primary-grey w-100"   onclick="CloseOffcanvas('camis_boardround_attendance');" ><img class="btn-icon-modal"
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



