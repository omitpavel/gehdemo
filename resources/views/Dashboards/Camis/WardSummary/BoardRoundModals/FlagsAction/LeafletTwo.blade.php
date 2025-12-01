

<div class="leaflet-two-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_ward_summary_boardround_patient_flag_leaflet_two" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel"> Leaflet Two</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_leaflet_two');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div >
            <div class="reasons-list-block mb-3">
                <ul class="reason-list">
                    <li> <input class="form-check-input p-2" name="leaflet_two" type="radio"  value="1" checked="checked">
                    </li>
                    <li>A: You are leaving hospital and returning home</li>

                </ul>
                <ul class="reason-list">
                    <li><input class="form-check-input p-2"name="leaflet_two" type="radio"  value="2">
                    </li>
                    <li>B: You are leaving hospital moving or returning to another place of care</li>
                </ul>
                <ul class="reason-list">
                    <li> <input class="form-check-input p-2" name="leaflet_two" type="radio"  value="3">
                    </li>
                    <li>C: Looking after family and friends after they leave hospital</li>
                </ul>
            </div>

        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 ibox_modal_footer_button_class">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_leaflet_two flag_button">
                            <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_leaflet_two');">
                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
