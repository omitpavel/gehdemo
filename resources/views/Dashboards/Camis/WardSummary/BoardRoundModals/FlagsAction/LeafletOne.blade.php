

<div class="leaflet-one-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_ward_summary_boardround_patient_flag_leaflet_one" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel"> Leaflet One</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_leaflet_one');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row ">
            <div class="col-lg-12 ">
                <div class="leaflet-one-modal">
                        <div class="header-primary">
                            <h6>Have you discussed the 4 questions with the patient?</h6>
                        </div>

                        <div class="questions-list mb-3">
                            <ul>
                                <li>What is the main reason I am in hospital for?</li>
                                <li>What is going to happen to me today and tomorrow?</li>
                                <li>What extra help may I need when I leave hospital?</li>
                                <li>When will I be able to leave hospital?</li>
                            </ul>
                        </div>



                </div>

            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 ibox_modal_footer_button_class">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag ">
                            <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal" width="18" height="18"><span>CONFRIM</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_patient_flag_leaflet_one');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
