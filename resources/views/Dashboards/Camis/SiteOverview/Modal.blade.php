<div class="directorate-boardround-report offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1"
    id="directorateBoardroundReport" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Board Round Report</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('directorateBoardroundReport');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                        class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="directorate-boardround-wrapper board_round_report_result">

        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('directorateBoardroundReport');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                        height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="empty-bed-details-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1"
        id="emptyBedDetails" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog"
        style="visibility: visible;">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0" id="offcanvasRightLabel">Empty Bed Details</h6>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('emptyBedDetails');"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="offcanvas-body ward_summary_sub_modal_inner_body patient_bed_empty">

        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('emptyBedDetails');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                            height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


<div class="bed-details-offcanvas offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="bedDetails"
    aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog" style="visibility: visible;">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Bed Details</h6>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('bedDetails');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body patient_bed_list" >

    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('bedDetails');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                        height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="ed-patients-offcanvas  offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1"
    id="ane_patient_details_offcanvas" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Patient Details</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('ane_patient_details_offcanvas');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                        class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="card-table-listing ane_patient_list">

        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('ane_patient_details_offcanvas');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                        height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="therapy-details-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1" id="MedfitDetails" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog" style="visibility: visible;">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0 medfit_patient_modal_title" id="offcanvasRightLabel">Medfit Patients</h6>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('MedfitDetails');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                    class="me-3">
                CLOSE</button>
            </div>
        </div>
    </div>

    <div class="offcanvas-body  ">

        <div class="row g-2 mb-2">
            <div class="col-lg-3 col-md-6">
                <select class="form-select selectric-select w-100" aria-label="Default select example" id="cdt_status_medfit">
                    <option selected value="">CDT Status All</option>
                    <option value="cdt_yes">CDT Yes</option>
                    <option value="cdt_no">CDT No</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <select class="form-select selectric-select w-100" id="therapy_status_medfit">
                    <option selected  value="">Therapy Fit All</option>
                    <option value="therapy_yes">Therapy Fit Yes</option>
                    <option value="therapy_no">Therapy Fit No</option>
                </select>
            </div>
        </div>



        <div class="modal-popup-loader-content"></div>
        <div class="cdt_medfit_patient_list ward_summary_sub_modal_inner_body"></div>
    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('MedfitDetails');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                        height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="therapy-details-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1" id="therapyDetails" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog" style="visibility: visible;">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0 therapy_patient_modal_title" id="offcanvasRightLabel">Therapy Patients</h6>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('therapyDetails');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                    class="me-3">
                CLOSE</button>
            </div>
        </div>
    </div>

    <div class="offcanvas-body">
        <div class="row g-2 mb-2">
            <div class="col-lg-3 col-md-6">
                <select class="form-select selectric-select w-100" aria-label="Default select example" id="cdt_status_therapy">
                    <option selected value="">CDT Status All</option>
                    <option value="cdt_yes">CDT Yes</option>
                    <option value="cdt_no">CDT No</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <select class="form-select selectric-select w-100" id="medfit_status_therapy">
                    <option selected  value="">MedFit Fit All</option>
                    <option value="medfit_yes">MedFit Fit Yes</option>
                    <option value="medfit_no">MedFit Fit No</option>
                </select>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class=" ward_summary_sub_modal_inner_body cdt_therapy_patient_list"></div>
    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('therapyDetails');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                        height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>
