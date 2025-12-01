
<link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/Ane.css') }}" crossorigin="anonymous">
<div class="modal fade" id="ane_dta_comments" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="">
                    <h6 class="modal-title"> DTA COMMENT</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('asset_v2/Ibox/Images/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div >
                        <div class="col-md-12 padding-zero popup_alert_response_show_div"></div>
                        <input type="hidden" value="" id="ane_dta_comments_attendance_id" name="ane_dta_comments_attendance_id">
                        <textarea class="form-control"  name="ane_dta_user_comments" id="ane_dta_user_comments" rows="6" placeholder="Enter your comment here"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                   <div class="col-lg-8 offset-lg-2">
                       <div class="row g-2">
                           <div class="col-lg-4 col-md-4">
                               <button type="button" class="btn btn-primary-grey ane_dta_comments_save all_modal_save_button_for_js bottom-save-button">
                                   <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                                   <svg class="bi bi-save normal-save-svg-to-show-on-save" width="18" height="18" viewBox="0 0 17.947 17.947">
                                       <path id="Path_20804" data-name="Path 20804"
                                             d="M17.8,1.727,16.393.185A.568.568,0,0,0,15.974,0H.568A.568.568,0,0,0,0,.568V17.379a.568.568,0,0,0,.568.568H17.379a.568.568,0,0,0,.568-.568V2.11A.568.568,0,0,0,17.8,1.727Zm-4.912-.592v4.38H10.619V1.135Zm-3.4,0v4.38H5.06V1.135Zm4.431,15.676H4.033V10.057h9.881v6.754Zm2.9,0H15.05V9.49a.568.568,0,0,0-.568-.568H3.465A.568.568,0,0,0,2.9,9.49v7.322H1.135V1.135H3.925V6.084a.568.568,0,0,0,.568.568h8.962a.568.568,0,0,0,.568-.568V1.135h1.7L16.812,2.33Z" />
                                   </svg>
                                   <span class="btnLbl">Save</span>
                               </button>
                           </div>
                           <div class="col-lg-4 col-md-4">
                               <button id="ane_dta_comments_delete_button" type="button" class="btn btn-primary-grey ane_dta_comments_delete all_modal_delete_button_for_js bottom-delete-button">
                                   <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset_v2/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                                   <svg class="bi bi-trash normal-delete-svg-to-show-on-delete" width="18" height="18" viewBox="0 0 17.947 17.947">
                                       <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                       <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                   </svg>
                                   <span class="btnLbl">Delete</span>
                               </button>
                           </div>
                           <div class="col-lg-4 col-md-4">
                               <button type="button" class="btn btn-primary-grey ane_dta_comments_cancel bottom-cancel-button" data-bs-dismiss="modal" aria-label="Close">
                                   <svg width="18" height="18" viewBox="0 0 15.201 15.561" id="cancel-svg">
                                       <path id="Union_12" data-name="Union 12" d="M13.995,15.355,7.6,8.961,1.209,15.355a.708.708,0,0,1-1-1L6.717,7.845a.62.62,0,0,1,0-.065c0-.022,0-.044,0-.066L.208,1.206a.707.707,0,0,1,1-1L7.6,6.6,13.995.207a.706.706,0,0,1,1,1L8.486,7.713a.636.636,0,0,1,0,.066.621.621,0,0,1,0,.065l6.508,6.508a.707.707,0,0,1-.5,1.209A.7.7,0,0,1,13.995,15.355Z" />
                                   </svg>
                                   <span >CLOSE</span>
                               </button>
                           </div>

                       </div>



                   </div>
                </div>
            </div>
        </div>
    </div>
</div>








<div class="modal fade" id="ane_dta_comments_delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <div class="">
                    <h6 class="modal-title"> DELETE COMMENT</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('asset_v2/Ibox/Images/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form class="">
                    <input type="hidden" value="" id="ane_dta_comments_delete_attendance_id" name="ane_dta_comments_delete_attendance_id">
                    <div class="text-center">
                        <h6>Are you sure you want to delete this Comment?</h6>
                    </div>
                    <div class="row ">
                        <div class="mb-3">
                            <textarea class="form-control" readonly name="ane_dta_user_comments_delete" id="ane_dta_user_comments_delete" class="form-control ane_dta_user_comments_delete" placeholder="Enter your comment here" rows="6"></textarea>
                        </div>
                    </div>
                </form>
            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="row g-2">
                            <div class="col-lg-6 col-md-6">
                                <button type="button" class="btn btn-primary-grey ane_dta_comments_delete_confirm all_modal_delete_button_for_js bottom-delete-button">
                                    <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset_v2/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                                    <svg class="bi bi-trash normal-delete-svg-to-show-on-delete" width="18" height="18" viewBox="0 0 17.947 17.947">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg>
                                    <span >Yes</span>
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <button type="button" class="btn btn-primary-grey ane_dta_comments_cancel bottom-cancel-button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg width="18" height="18" viewBox="0 0 15.201 15.561" id="cancel-svg">
                                        <path id="Union_12" data-name="Union 12" d="M13.995,15.355,7.6,8.961,1.209,15.355a.708.708,0,0,1-1-1L6.717,7.845a.62.62,0,0,1,0-.065c0-.022,0-.044,0-.066L.208,1.206a.707.707,0,0,1,1-1L7.6,6.6,13.995.207a.706.706,0,0,1,1,1L8.486,7.713a.636.636,0,0,1,0,.066.621.621,0,0,1,0,.065l6.508,6.508a.707.707,0,0,1-.5,1.209A.7.7,0,0,1,13.995,15.355Z" />
                                    </svg>
                                    <span >No</span>
                                </button>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="navigation-modal modal fade" id="navigationModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h6 class="modal-title" id="exampleModalLabel">Navigation</h6>
                    </div>
                    <div>
                        <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                            aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                            CLOSE</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-primary-grey click_open_ane_new_opel" onclick="ClearEDThermoMeter();"  data-bs-dismiss="modal">A&E</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-primary-grey  @if(CheckSpecificPermission('opel_modal_view')) ane_status_opel_modal @endif" @if(!CheckSpecificPermission('opel_modal_view')) onclick="CommonLoginModalPopupOpenOnRequest();" @endif data-bs-toggle="modal"
                                        data-bs-target="#ane_status_opel_modal">GEH</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="ane-modal modal fade zoom-in" id="ane_status_opel_modal" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <div class="">
                    <h6 class="modal-title"> ED STATUS</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100"
                            data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                            width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-body EDStatusModal" id="modal-ed-btn">
                <div class="row">
                    <div class="col-lg-12" id="custom-tab">
                        <div class="col-md-12 padding-zero popup_alert_response_show_div"></div>
                        <!-- Nav tabs -->


                        <!-- Tab panes -->

                        <input type="hidden" value="" id="ane_ed_opel_status_data"
                                name="ane_ed_opel_status_data">
                        <input type="hidden" value="" id="ane_ward_opel_status_data"
                                name="ane_ward_opel_status_data">

                        <form class="">
                            <div class=" form-group">
                                <div class="row row-cols-lg-5 row-cols-2 g-2 mb-2">
                                    <div class="col text-start ane_ward_opel_button ane_ward_opel_button_1" data-ane-ward-opel-button-value="1">
                                        <a href="#">
                                            <div class="ed-blue-box " type="button">
                                                <div class="d-flex align-items-center  " >
                                                    <i class="bi bi-check-circle  fs-5 content_display_none opel_ward_checkbox opel_ward_tick_1"></i>
                                                    <h6 class="ms-2 mb-0">EMS 1</h6>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="col ane_ward_opel_button ane_ward_opel_button_2" data-ane-ward-opel-button-value="2">
                                        <a href="#">
                                            <div class="ed-purple-box " type="button">
                                                <div class="d-flex align-items-center ">
                                                    <i class="bi bi-check-circle   fs-5 content_display_none opel_ward_checkbox opel_ward_tick_2"></i>
                                                    <h6 class="ms-2 mb-0 text-black">EMS 2</h6>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="col ane_ward_opel_button ane_ward_opel_button_3"  data-ane-ward-opel-button-value="3">
                                        <a href="#">
                                            <div class="ed-green-box " type="button">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-check-circle   fs-5 content_display_none opel_ward_checkbox opel_ward_tick_3"></i>
                                                    <h6 class="ms-2 mb-0">EMS 3</h6>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="col ane_ward_opel_button ane_ward_opel_button_4" data-ane-ward-opel-button-value="5">
                                        <a href="#">
                                            <div class="ed-orange-box" type="button">
                                                <div class="d-flex align-items-center " >
                                                    <i class="bi bi-check-circle   fs-5 content_display_none opel_ward_checkbox opel_ward_tick_5"></i>
                                                    <h6 class="ms-2 mb-0">EMS Internal 4</h6>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="col ane_ward_opel_button ane_ward_opel_button_4" data-ane-ward-opel-button-value="4">
                                        <a href="#">
                                            <div class="ed-skyblue-box " type="button">
                                                <div class="d-flex align-items-center " >
                                                    <i class="bi bi-check-circle   fs-5 content_display_none opel_ward_checkbox opel_ward_tick_4"></i>
                                                    <h6 class="ms-2 mb-0">EMS 4</h6>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label
                                            class="form-label">Please
                                            add
                                            comment</label>
                                        <textarea name="ane_ward_opel_status_comment" rows="6" id="ane_ward_opel_status_comment"
                                                    class="form-control ane_ward_opel_status_comment"></textarea>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3 pt-3">
                                    <div class="col-lg-3 pe-lg-0 text-center text-lg-start mb-2 order-1 order-md-1 order-lg-0">
                                        <h6 class="mb-0">GEH Status Show</h6>
                                    </div>
                                    <div class="col-lg-2 ps-lg-0 text-center mb-2 order-2 order-md-2 order-lg-1">

                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-ed-info fs-12  ane_ward_opel_show_status_val_1"  id="ane_ward_opel_show_status_1" data-switch_out_of_office="1">YES</button>
                                            <button type="button" class="btn btn-ed-light fs-12  ane_ward_opel_show_status_val_0" id="ane_ward_opel_show_status_0" data-switch_out_of_office="0">NO</button>
                                        </div>

                                    </div>

                                    <div
                                        class="col-lg-7 order-0 order-md-0 order-lg-2 mb-2 text-center text-lg-end">
                                        <h6
                                            class="mb-0 ane_ward_opel_status_updated_date_time">
                                        </h6>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="row">

                    <div class="col-lg-6 offset-lg-3">
                        <div class="row g-2 ibox_modal_footer_button_class">
                            <div class="col-lg-6 col-md-6 col-6">
                                <button type="button"
                                        class="btn btn-primary-grey ane_opel_status_data_save all_modal_save_button_for_js bottom-save-button">
                                    <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" width="18" height="18"/>
                                    <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6">
                                <button type="button"
                                        class="btn btn-primary-grey bottom-cancel-button bottom-cancel-button"
                                        data-bs-dismiss="modal" aria-label="Close">
                                    <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="18" height="18"><span>CLOSE</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="attendance-details-offcanvas offcanvas offcanvas-end" tabindex="-1" id="symphony_attendance_id_patient_details" aria-labelledby="offcanvasRightLabel">


    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">Attendance Details</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('symphony_attendance_id_patient_details');"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body"  id="attendence_details">



    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('symphony_attendance_id_patient_details');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="assigned-speciality-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="symphony_sau_attendance_id_patient_details" aria-labelledby="offcanvasRightLabel">


    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="patient_to_ward_title">Patients To SAU</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('symphony_sau_attendance_id_patient_details');"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body"  id="sau_attendence_details">



    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('symphony_sau_attendance_id_patient_details');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Assigned Specialities Offcanvas -->



<div class="assigned-speciality-offcanvas offcanvas offcanvas-end" id="assignedSpeciality" tabindex="-1"  aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <div class="modal-screen-center_1" style="z-index: 99999; display: none;"></div>
                <h6 class="mb-0" id="assigned_speciality_title">ED</h6>
            </div>

            <div class="">
                <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('assignedSpeciality');"><img src="{{ asset('asset_v2/Template') }}/icons/cancel.svg" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body" id="get_data_of_canvas">

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('assignedSpeciality');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Specialities Offcanvas End -->
<div class="ane-patients-offcanvas offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1"
        id="anePatientsData" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header card-header fw-bold">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="">
                    <h6 class="mb-0 ane_patient_data_title" id="offcanvasRightLabel">RESUS</h6>
                </div>
                <div class="">
                    <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('anePatientsData');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
        <div class="offcanvas-body"  id="get_data_of_canvas_graph">

        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('anePatientsData');"><img
                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12"
                            height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
