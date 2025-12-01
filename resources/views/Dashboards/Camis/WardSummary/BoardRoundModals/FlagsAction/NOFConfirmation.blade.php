

<div class="leaflet-one-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="nof_removal_confirmation" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel"> NOF TASK</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('nof_removal_confirmation');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row ">
            <div class="col-lg-12 ">
                <div class="leaflet-one-modal">
                    <div class="header-primary">
                        <h6>Do you want to remove the automatically added tasks ?</h6>
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
                        <button class="btn btn-primary-grey camis_patient_ward_summary_boardround_remove_patient_flag "  data-bs-dismiss="offcanvas">
                            <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal" width="18" height="18"><span>Yes</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey remove_nof_flag_without_auto_task"  onclick="CloseOffcanvas('nof_removal_confirmation');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>No</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
