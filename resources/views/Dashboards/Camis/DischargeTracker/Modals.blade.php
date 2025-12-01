<div class="patients-details-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class dtoc_data"
    id="patientDetails" aria-labelledby="exampleModalLabel" data-bs-keyboard="false">

    <div class="modal-popup-loader-content" style="display: none;"></div>

</div>







<div class="enter-comment-modal modal fade" id="modal_add_comment_popup" data-bs-backdrop="false" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">COMMENT</h6>
                </div>
                <div>
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                        onclick="Backdropremove();" aria-label="Close"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>

            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body">
                <input type="hidden" id="comment_patient_id" value="">
                <input type="hidden" id="comment_type" value="">
                <div class="row g-2 camis_patient_ward_summary_dtoc_comment_inner">

                </div>



            </div>


            <div class="modal-footer">
                <div class="row gx-2 ibox_modal_footer_button_class">
                    <div class="col-md-4 mb-2 mb-xl-0">
                        <button
                            class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_save_discharge_comment">

                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-md-4 mb-2 mb-md-0">
                        <button class="btn btn-primary-grey me-2 comment_history_modal">

                            <img src="{{ asset('asset_v2/Template/icons/history.svg') }}" alt=""
                                class="btn-icon-modal" width="16" height="16"><span>History</span>
                        </button>
                    </div>
                    <div class="col-md-4 mb-2 mb-md-0">
                        <button class="btn btn-primary-grey" onclick="Backdropremove();" data-bs-dismiss="modal"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>



<div class="modal fade" id="set_tu_for_default" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title mb-0">TEAM UPDATE - CONFIRMATION</h6>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                        onclick="Backdropremove();" aria-label="Close"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12 ">
                        <div class="row">
                            <div class="col-12 pe-md-1 mb-2 text-center">
                                <p>Are you sure, you want to set Team Update as default for this sesion ?</p>
                                <input type="hidden" value="" id="dtoc_tu_set_default_patient_id">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row ibox_modal_footer_button_class">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="row g-2">
                            <div class="col-lg-6 col-md-6 col-6">
                                <button
                                    class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button dtoc_tu_set_default_patient">

                                    <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                                    <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                        class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                        height="18"><span>YES</span>
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6">
                                <button class="btn btn-primary-grey " data-bs-dismiss="modal"
                                    onclick="Backdropremove();" aria-label="Close">

                                    <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                        class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="12"
                                        height="12"><span>CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="comments-history-modal modal fade" id="modal_comment_history" data-bs-backdrop="false"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title mb-0">Comment History</h6>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                        onclick="Backdropremove();" data-bs-target="#modal_comment_history" aria-label="Close"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body">
                <div class=" row gx-2 camis_patient_ward_summary_dtoc_comment_history">
                </div>
            </div>
        </div>
    </div>
</div>



<div class="comments-all-offcanvas offcanvas offcanvas-end" id="viewAllComments" data-bs-backdrop="static"
    aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">ALL COMMENTS</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('viewAllComments');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content" style="display: none;"></div>
    <div class="offcanvas-body">
        <div class="card-comments" id="viewAllCommentsBody">

        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('viewAllComments');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                        class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>





<div class="timeline-modal modal fade camis_ward_summary_boardround_sub_inner_popup_common_class" id="timeline"
    data-bs-backdrop="false" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title mb-0">Timeline</h6>
                <div class="">
                    <button type="button" onclick="Backdropremove();" class="btn-grey text-end w-100"
                        data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                            height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body" id="medfit_timeline_data">

            </div>
        </div>
    </div>
</div>




<div class="accept-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
    data-bs-backdrop="static" tabindex="-1" id="offcanvas_cdt_status_1" aria-labelledby="offcanvasRightLabel"
    style="visibility: visible;" aria-modal="true" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Accept</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('offcanvas_cdt_status_1');" aria-label="Close"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="text-center">
            <h6>Are you sure you want to Approve?</h6>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button
                            class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button cdt_approval_button"
                            data-status="1">

                            <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('offcanvas_cdt_status_1');">

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accept Offcanvas End -->

<!-- Add Review Reason Offcanvas -->

<div class="review-reason-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
    data-bs-backdrop="static" tabindex="-1" id="offcanvas_cdt_status_3" aria-labelledby="offcanvasRightLabel"
    style="visibility: visible;" aria-modal="true" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Add Review Reason</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('offcanvas_cdt_status_3');" aria-label="Close"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row ">
            <div class="">
                <textarea class="form-control cdt_comments" id="cdt_comments_2" rows="6"></textarea>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button
                            class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button cdt_approval_button "
                            data-status="2">

                            <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('offcanvas_cdt_status_3');">

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Review Reason Offcanvas End -->

<!-- Add Reject Reason Offcanvas -->

<div class="reject-reason-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
    data-bs-backdrop="static" tabindex="-1" id="offcanvas_cdt_status_2" aria-labelledby="offcanvasRightLabel"
    style="visibility: visible;" aria-modal="true" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Add Reject Reason</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('offcanvas_cdt_status_2');" aria-label="Close"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row ">
            <div class="">
                <textarea class="form-control cdt_comments" id="cdt_comments_3" rows="6"></textarea>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button
                            class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button cdt_approval_button "
                            data-status="3">

                            <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('offcanvas_cdt_status_2');">

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Reject Reason Offcanvas End -->


<div class="remove-reason-offcanvas offcanvas offcanvas-end " data-bs-backdrop="static" tabindex="-1"
    id="removeFromList" aria-labelledby="offcanvasRightLabel" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Add Remove Reason</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('removeFromList');"
                    aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                        width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <input type="hidden" id="patient_id">
        <div class="row ">
            <div class="">
                <textarea class="form-control cdt_comments" id="cdt_comments_4" rows="6"></textarea>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button
                            class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button cdt_removed_button "
                            data-status="4"> <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>CONFIRM</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('removeFromList');">

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" class="btn-icon-modal"
                                width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="cdt-comment-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
    data-bs-backdrop="static" tabindex="-1" id="camid_dtoc_cdt_comment" aria-labelledby="offcanvasRightLabel"
    style="visibility: visible;" aria-modal="true" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">CDT Comment</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('camid_dtoc_cdt_comment');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <input type="hidden" id="cdt_patient_id">
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row mb-2">
            <div class="">
                <textarea class="form-control patient_cdt_comment" rows="6"></textarea>
            </div>
        </div>
        <div class="cdt_comment_history"></div>

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button
                            class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_dtoc_update_cdt "
                            data-status="4"> <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/tick-black.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camid_dtoc_cdt_comment');"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>











<div class="cdt-timeline-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_cdt_timeline"
    aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">CDT TIMELINE</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="offcanvas"
                    aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                        width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-dummy-content-loader"></div>
    <div class="offcanvas-body cdt_timeline_data">

    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" data-bs-dismiss="offcanvas" aria-label="Close"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                        class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="add-patients-ed-referral offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
    id="ed_referral_patient_search_modal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Add Patients to ED Referral</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('ed_referral_patient_search_modal');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body" id="ed_referral_patient_search">
        <div class="patients-ed-referral-wrapper">
            <div class="row g-2 mb-2 ed-referral-filters">
                <div class="col-xxl-3 col-lg-4 col-md-8 col-12">
                    <div class="d-flex justify-content-between">
                        <input class="form-control" type="text" placeholder="Search"
                            aria-label="default input example" id="search_ed_referral_patient_field" />
                        <button type="button" class="btn btn-dark ms-2 search_ed_referral_patient">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-table-listing ed_referral_patient_search">

            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2 ">
            <div class="col-md-3 offset-md-3">
                <button
                    class="btn btn-primary-grey mb-2 mb-md-0 all_modal_save_button_for_js bottom-save-button normal-save-svg-to-show-on-save click_add_patient_ed_referral">
                    <img class='loading-save-svg-to-show-on-save'
                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" /><img
                        src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal"
                        width="16" height="16"><span>save</span>
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary-grey mb-2 mb-md-0"
                    onclick="CloseOffcanvas('ed_referral_patient_search_modal');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                        class="btn-icon-modal" width="14" height="14"><span>CANCEL</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="ed-remove-reason-offcanvas offcanvas offcanvas-end" id="remove_ed_patients">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Add Remove Reason</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('remove_ed_patients');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <input type="hidden" id="cdt_remove_patient_id" value="">
        <div class="text-center">
            <h6>Are you sure you want to Remove?</h6>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button
                            class="btn btn-primary-grey mb-2 mb-md-0 all_modal_save_button_for_js bottom-save-button normal-save-svg-to-show-on-save click_remove_patient_ed_referral">
                            <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" /><img
                                src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal" width="16" height="16"><span>REMOVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('remove_ed_patients');"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="other-notes-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class"
    data-bs-backdrop="static" tabindex="-1" id="camis_discharge_comment_offcanvas"
    aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Other Notes</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('camis_discharge_comment_offcanvas');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body patient_discharge_comment_data">
        <input type="hidden" id="other_notes_patient_id">
        <div class="row ">
            <div class="">
                <textarea class="form-control" id="other_notes_input" rows="6"></textarea>
            </div>
        </div>
        <div class="history-card">
            <div class="rectangle-block-1">
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between rectangle-block-2">
                            <p class="mb-0">History</p>
                        </div>
                    </div>
                </div>
                <div class="data-area">
                    <div class="row mb-2">
                        <div class="col-12 other-notes-section">
                            <div class="rectangle-block-1">
                                <div class="other-notes other_notes_hisotry">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-10 offset-lg-1">
                <div class="row g-2">
                    <div class="col-lg-4 col-md-4">
                        <button
                            class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_save_discharge_comment ">
                            <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button
                            class="btn btn-primary-grey me-2 all_modal_delete_button_for_js bottom-delete-button camis_patient_ward_summary_boardround_remove_comment flag_button">
                            <img class='loading-delete-svg-to-show-on-delete'
                                src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/deselect.svg') }}" alt=""
                                class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="16"
                                height="16"><span>REMOVE OTHER NOTES</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey"
                            onclick="CloseOffcanvas('camis_discharge_comment_offcanvas');"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="export-columns-offcanvas offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1"
    id="exportColumns" aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true"
    role="dialog">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Set Export Columns</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"
                    onclick="CloseOffcanvas('exportColumns');"><img
                        src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                        height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    @php
        $exportableColumns = [
            //'patient_id' => 'Patient ID',
            'nhs_number' => 'NHS Number',
            'pas_id' => 'Hospital Number',
            'name' => 'Name',
            'dob' => 'Date Of Birth',
            'admission_date' => 'Admission Date',
            'ward' => 'Ward',
            //'bed' => 'Bay & Bed',
            'referral_date' => 'Referral Date',
            'services' => 'Services',
            //'current_status' => 'Current Status',
            'los' => 'LOS',
            'medfit' => 'Med Fit',
            'confirm_discharge_date' => 'Confirmed Discharge Date',
            'pathway_name' => 'Pathway',
            'authority_name' => 'Authority',
            //'reason_name' => 'Reason Code',
            'comment' => 'Latest Comment',
        ];
    @endphp
    <div class="offcanvas-body">
        <div class="text-end">
            <button class="btn btn-primary-grey export_column_selection">Select All</button>
        </div>
        <div class="card-export-columns">
            <div class="row gx-2">
                @foreach ($exportableColumns as $key => $label)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input export-col" type="checkbox" id="col_{{ $key }}"
                                value="{{ $key }}" checked>
                            <label class="form-check-label" for="col_{{ $key }}">
                                {{ $label }}
                            </label>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6 export_discharge_tracker_confirm">
                        <button class="btn btn-primary-grey"><img
                                src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt=""
                                class="btn-icon-modal" width="16" height="16"><span>EXPORT</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('exportColumns');"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Dashboards.Camis.DischargeTracker.MedfitModal')
