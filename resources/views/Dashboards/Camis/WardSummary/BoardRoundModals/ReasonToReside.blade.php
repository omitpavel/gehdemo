
<div class="reason-reside-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_summary_boardround_reason_to_reside"
     aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0 reason_to_reside_modal_title" id="offcanvasRightLabel">REASON TO RESIDE</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100 d-none reason_to_reside_close_area" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_reason_to_reside');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body">
        <div id="resonToResideSection" style="display: block;">
            <div class="row gx-2">
                <div class="col-12 mb-2">
                    <div class="row gx-2 ">
                        <div class="col-md-12 ">
                            <div class="rectangle-block-1 medfit-section">
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div class="rectangle-block-2">
                                            <p class="mb-0">Med Fit</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="medfit-buttons" id="medfitSection">
                                    <button name="" class="btn btn-medfit-no {{ DisabledButtonOnRolePermission('camis_reason_to_reside_update') }}  click_popup_open_ibox_board_round_medfit_no_modal">NO</button>
                                    <button class="btn btn-medfit-yes {{ DisabledButtonOnRolePermission('camis_medfit_yes_update') }} click_popup_open_ibox_board_round_medfit_yes_modal" >
                                        YES
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="medfit-card mb-2 d-none">
                <div class="mb-2">
                    <span>Consultant: <span class="fw-500 medfit_yes_consultant_head_doctor_name"></span> </span>
                </div>
                <div class="row ">
                    <form>
                        <div class="mb-2">
                            <label for="ibox_board_round_content_patient_medically_fit_status_comment" class="form-label">Please enter comment</label>
                            <textarea class="form-control ibox_board_round_content_patient_medically_fit_status_comment" id="ibox_board_round_content_patient_medically_fit_status_comment" rows="8"></textarea>
                        </div>

                        <div class="fw-500">
                            <p class="mb-0">Assigning MED FIT 'Yes' will automatically assign reason to reside with value of 'No
                                Reason'
                                to Reside'</p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row gx-2 content-section r2r_checkbox_section">
                <div class="col-md-12">
                    <div class="rectangle-block-1 mb-1 camis_ward_summary_boardround_sub_inner_popup_common_class">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="rectangle-block-2">
                                    <p class="mb-0">Reason to Reside</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="ibox_board_round_content_med_fit_set_as_no" id="ibox_board_round_content_med_fit_set_as_no" value="" />

                        <div class="reason-content-block d-none">
                            <div class="reasons-list-block bg-white">
                                <ul class="reason-list">
                                    <li> <input class="form-check-input" type="radio" name="ibox_board_round_content_patient_reason_to_reside" id="ibox_board_round_content_patient_reason_to_reside" value="0"></li>
                                    <li>No Reason to reside </li>

                                </ul>
                            </div>
                        </div>
                        <div class="modal-popup-loader-content"></div>
                        <div class=" reside-contents all_reason_list_content ward_summary_sub_modal_inner_body">


                            






                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="red_green_status_type" value="0">
        <div id="redToGreenSection" style="display: none;">
            <div class="red-green-sticky {{ PermissionDeniedDiv('camis_bed_red_green_update') }}">
                <div class="d-flex justify-content-between align-items-center mb-2 {{ DisabledButtonOnRolePermission('camis_bed_red_green_update') }} r2g_div_area">

                    <svg xmlns="http://www.w3.org/2000/svg" width="71.397" height="25" viewBox="0 0 71.397 32.863">
                        <path id="Subtraction_64" data-name="Subtraction 64" d="M57.453,32.863a19.5,19.5,0,0,1-2.98-.225l.027.036H45.048V27.3H30.613v-.135l7.8-7.595c3.5-3.518,6.188-6.532,6.188-10.6,0-3.991-2.494-7.213-6.673-8.618H53.261l-.052.1A18.058,18.058,0,0,1,57.3,0c7.32,0,12.871,4.343,13.812,10.807h-6.6A7.117,7.117,0,0,0,57.322,5.5c-5.2,0-8.3,4.017-8.3,10.746,0,6.842,3.272,11.093,8.541,11.093,4.3,0,7.279-2.654,7.408-6.6l.021-.507H58.149V15.386H71.4v3.589C71.4,27.671,66.185,32.863,57.453,32.863ZM6.7,32.675H0V.344H13.221c.33,0,.655.008.965.024L14.177.352H28.56a9.961,9.961,0,0,0-7.153,9.714v.111h6.209v-.111a5.079,5.079,0,0,1,1.529-3.7A5.518,5.518,0,0,1,33.006,4.89c2.9,0,5.08,1.869,5.08,4.346,0,2.23-.95,3.833-4.237,7.149L21.784,28.129v4.545H18.143l-5.962-11.83H6.7v11.83Zm0-27.044V15.938h5.877c3.347,0,5.346-1.927,5.346-5.156,0-3.129-2.123-5.151-5.41-5.151Z">
                        </path>
                    </svg>
                    <button class="btn btn-danger width-btn-adjust camis_patient_ward_summary_boardround_save_red_bed_status"><img
                            src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" alt="" class="me-2" width="18" id="red_bed_modal" class="d-none"
                            height="18"> Red
                        Bed</button>
                    <button class="btn btn-success width-btn-adjust camis_patient_ward_summary_boardround_save_green_bed_status"><img
                            src="{{ asset('asset_v2/Template') }}/icons/tick-circle.svg" alt="" class="me-2" width="18" id="green_bed_modal"  class="d-none"
                            height="18">Green Bed</button>
                </div>

                <div class="row gx-2 red_bed_search_input">
                    <div class="col-12 mb-2">
                        <div class="">
                            <label class="form-label mb-1">Selected
                                Red Reason</label>
                            <div class="red-reason-block red_block_list">

                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2 position-relative">
                        <input type="text" class="form-control" id="red_to_green_search" aria-describedby="">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-R2G red_bed_reason_list d-none">
                <div class="red2green-section ">

                    <div class="reside-contents">
                        <div class="reason-content-block">
                            <div class="reasons-list-block red_reason_list_block">
                                @if (!empty($success_array['bed_red_reason']))
                                    @foreach ($success_array['bed_red_reason'] as $id => $value)
                                        <ul class="reason-list">
                                            <li> <input class="form-check-input" type="checkbox" name="bed_red_green_name" value="{{ $id }}"></li>
                                            <li>{{ $value }} </li>
                                        </ul>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-4 offset-lg-4 reason_to_reside_save_area">
                <div class="row g-2">
                    <div class="col-lg-12 col-md-12 col-12">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_reason_to_reside ">

                            <img class='loading-save-svg-to-show-on-save'
                                 src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                 alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                 class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="20"><span id="r2r_button_text">SAVE & Next</span>
                        </button>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 offset-lg-2 redbed_save_area d-none">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_reason_to_reside"><img class='loading-save-svg-to-show-on-save'
                                                                                                                                                                              src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                                                                                                                                                              alt="" /><img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                                                                                                                                                                            class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="20"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_ward_summary_boardround_reason_to_reside');">

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                 class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
