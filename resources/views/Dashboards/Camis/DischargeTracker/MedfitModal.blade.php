
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
                    <div class="rectangle-block-1 mb-1">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="rectangle-block-2">
                                    <p class="mb-0">Reason to Reside</p>
                                </div>
                            </div>
                        </div>
                        <div class=" reside-contents">
                            <input type="hidden" name="ibox_board_round_content_med_fit_set_as_no" id="ibox_board_round_content_med_fit_set_as_no" value="" />

                            <div class="reason-content-block d-none">
                                <div class="reasons-list-block bg-white">
                                    <ul class="reason-list">
                                        <li> <input class="form-check-input" type="radio" name="ibox_board_round_content_patient_reason_to_reside" id="ibox_board_round_content_patient_reason_to_reside" value="0"></li>
                                        <li>No Reason to reside </li>

                                    </ul>
                                </div>
                            </div>

                            <div class="reason-content-block">
                                <div class="header-primary">
                                    <h6>Physiology</h6>
                                </div>



                                @if (!empty($success_array['reason_to_reside']))
                                    @foreach ($success_array['reason_to_reside'] as $key=> $row_reason)
                                        @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Physiology') && $row_reason->reason_to_reside_board_round_show_status == 1)
                                            <div class="reasons-list-block">

                                                <ul class="reason-list">
                                                    <li> <input id="physiology_{{ $key }}" class="form-check-input ibox_board_round_content_patient_reason_to_reside" type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                                                value="{{ $row_reason->id }}"></li>
                                                    <li> <label for="physiology_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }} </label></li>

                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                            </div>

                            <div class="reason-content-block">
                                <div class="header-primary">
                                    <h6>Recovery</h6>
                                </div>
                                @if (!empty($success_array['reason_to_reside']))
                                    @foreach ($success_array['reason_to_reside'] as $key=> $row_reason)
                                        @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Recovery') && $row_reason->reason_to_reside_board_round_show_status == 1)
                                            <div class="reasons-list-block">

                                                <ul class="reason-list">
                                                    <li> <input id="recovery_{{ $key }}" class="form-check-input ibox_board_round_content_patient_reason_to_reside" type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                                                value="{{ $row_reason->id }}"></li>
                                                    <li> <label for="recovery_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>  </li>

                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                            </div>

                            <div class="reason-content-block">
                                <div class="header-primary">
                                    <h6>Treatment</h6>
                                </div>
                                @if (!empty($success_array['reason_to_reside']))
                                    @foreach ($success_array['reason_to_reside'] as $key=> $row_reason)
                                        @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Treatment') && $row_reason->reason_to_reside_board_round_show_status == 1)
                                            <div class="reasons-list-block">

                                                <ul class="reason-list">
                                                    <li> <input id="treatment_{{ $key }}" class="form-check-input ibox_board_round_content_patient_reason_to_reside" type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                                                value="{{ $row_reason->id }}"></li>
                                                    <li> <label for="treatment_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>  </li>

                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            <div class="reason-content-block">
                                <div class="header-primary">
                                    <h6>Function</h6>
                                </div>
                                @if (!empty($success_array['reason_to_reside']))
                                    @foreach ($success_array['reason_to_reside'] as $key=> $row_reason)
                                        @if (strtolower($row_reason->reason_to_reside_text_value_category) == strtolower('Function') && $row_reason->reason_to_reside_board_round_show_status == 1)
                                            <div class="reasons-list-block">

                                                <ul class="reason-list">
                                                    <li> <input id="function_{{ $key }}" class="form-check-input ibox_board_round_content_patient_reason_to_reside" type="radio" name="ibox_board_round_content_patient_reason_to_reside"
                                                                value="{{ $row_reason->id }}"></li>
                                                    <li> <label for="function_{{ $key }}">{{ $row_reason->reason_to_reside_text_value }}</label>  </li>

                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>







                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="red_green_status_type" value="0">

    </div>

    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2  reason_to_reside_save_area">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_reason_to_reside ">

                            <img class='loading-save-svg-to-show-on-save'
                                 src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                 alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                 class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="20"><span id="r2r_button_text">SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6">
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
