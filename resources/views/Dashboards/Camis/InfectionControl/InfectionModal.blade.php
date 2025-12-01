<div class="ipc-infection-risk-offcanvas offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1"
    id="camis_patient_ward_summary_boardround_patient_flag_infection_risk" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="ipc-infection-header">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">INFECTION RISK</h6>
            </div>
            <div class="offcanvas-top-btn-wrapper">
                <div class="reverse-barrier-block " id="reverseBarrierSection">
                    <button class="btn btn-reverse-barrier click_assign_reverse_barrier">Reverse Barrier <img
                            src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" class="ms-2"
                            width="18" height="18">
                    </button>
                </div>
                <div class="infection-history-btn click_open_ipc_infection_history">
                    <button class="btn btn-grey " >Infection History
                    </button>
                </div>
                <div class="close-btn">
                    <button type="button" class="btn-grey text-end" onclick="CloseICOffcanvas('camis_patient_ward_summary_boardround_patient_flag_infection_risk');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none infection_risk_master_div_for_repeat">
        <div class="card-infection-data clone-me ">
            <div class="header-chart">
                <h6 class="title">Infection Risk List</h6>
                <div class="section-buttons">
                    <div class="primary-btn" id="primaryInfectionButton">
                        <button class="btn btn-primary-grey me-2 make_primary_infection"><img
                                src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt=""
                                class="ms-3" width="16" height="16">Primary
                            Infection</button>
                    </div>
                    <button class="btn btn-primary-grey infection_risk_delete"><i
                            class="bi bi-trash3-fill me-2"></i>Delete</button>
                </div>
            </div>
            <div class="data-section">
                <div class="row g-2">
                    <div class="col-lg-3 col-md-6">
                        <button type="button" class="btn btn-primary-grey infection_risk_button">QUERY</button>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button type="button" class="btn btn-primary-grey infection_risk_button">CONFIRMED</button>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button type="button" class="btn btn-primary-grey infection_risk_button">RESOLVED</button>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button type="button" class="btn btn-primary-grey infection_risk_button">CAN STAY IN
                            BAY</button>
                    </div>
                </div>
                <div class="row gx-2 mt-3">
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Infection
                            Risk</label>
                        <select class="form-select ic_id" aria-label="Default select example">
                            <option value="">Select Infection Risk</option>
                            @if (!empty($success_array['infection_control']))
                                @foreach ($success_array['infection_control'] as $row)
                                    <option value="{{ $row->id }}"
                                        data-infection-name="{{ $row->infection_list_show_data_name }}">
                                        {{ $row->infection_list_show_data_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Next Review
                            Date</label>
                        <input type="text" class="form-control ic_date" id="" placeholder="Select date">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-12 ">
                <div class="infection-ipc-wrapper">
                    <div class="card-infection-data past-infections-section">
                        <div class="header-chart">
                            <h6 class="title">Past Infections</h6>
                        </div>
                        <div class="data-section">
                            <div class="row ">
                                <div class="">
                                    <textarea class="form-control" id="past_infection_history" rows="2" disabled=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="container" class="infection_list_class">
                        <div class="card-infection-data clone-me ">
                            <div class="header-chart">
                                <h6 class="title">Infection Risk List</h6>
                                <div class="section-buttons">
                                    <div class="primary-btn" id="primaryInfectionButton">
                                        <button class="btn btn-primary-grey me-2 make_primary_infection active"><img
                                                src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}"
                                                alt="" class="ms-3" width="16" height="16">Primary
                                            Infection</button>
                                    </div>
                                    <button class="btn btn-primary-grey infection_risk_delete"><i
                                            class="bi bi-trash3-fill me-2"></i>Delete</button>
                                </div>
                            </div>
                            <div class="data-section">
                                <div class="row g-2">
                                    <div class="col-lg-3 col-md-6">
                                        <button type="button"
                                            class="btn btn-primary-grey infection_risk_button">QUERY</button>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <button type="button"
                                            class="btn btn-primary-grey infection_risk_button">CONFIRMED</button>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <button type="button"
                                            class="btn btn-primary-grey infection_risk_button">RESOLVED</button>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <button type="button" class="btn btn-primary-grey infection_risk_button">CAN
                                            STAY
                                            IN
                                            BAY</button>
                                    </div>
                                </div>
                                <div class="row gx-2 mt-3">
                                    <div class="col-md-6">
                                        <label for="exampleFormControlTextarea1" class="form-label">Infection
                                            Risk</label>
                                        <select class="form-select ic_id" aria-label="Default select example">
                                            <option value="">Select Infection Risk</option>
                                            @if (!empty($success_array['infection_control']))
                                                @foreach ($success_array['infection_control'] as $row)
                                                    <option value="{{ $row->id }}"
                                                        data-infection-name="{{ $row->infection_list_show_data_name }}">
                                                        {{ $row->infection_list_show_data_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleFormControlTextarea1" class="form-label">Next Review
                                            Date</label>
                                        <input type="text" class="form-control ic_date" id=""
                                            placeholder="Select date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-more">
                        <div class="row">
                            <div class="col-xxl-3 col-md-4 offset-xxl-9 offset-md-8">
                                <button class="btn btn-primary-grey clone_infection_div"><i
                                        class="bi bi-plus-lg me-2"></i>Add
                                    More</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-infection-data ipc-module">
                    <div class="header-chart">
                        <h6 class="title">Comments</h6>
                        <div class="section-buttons">
                            <button class="btn btn-primary-grey me-2 click_open_ipc_comment_history">History</button>
                            <button class="btn btn-primary-grey delete_comment_button"><i
                                    class="bi bi-trash3-fill me-2"></i>Delete</button>
                        </div>
                    </div>
                    <div class="data-section">
                        <div class="row ">
                            <div class="">
                                <textarea class="form-control" id="ipc_comment_value" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-4 col-md-4">
                        <button
                            class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_infection_risk flag_button">
                            <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button
                            class="btn btn-primary-grey me-2 all_modal_delete_button_for_js bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag flag_button">
                            <img class='loading-delete-svg-to-show-on-delete'
                                src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/deselect.svg') }}" alt=""
                                class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="16"
                                height="16"><span>REMOVE INFECTION</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey"
                            onclick="CloseICOffcanvas('camis_patient_ward_summary_boardround_patient_flag_infection_risk');"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="ipc-comment-modal modal fade camis_ward_summary_boardround_sub_inner_popup_common_class" id="ipcComment">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">Comment</h6>
                </div>
                <div>
                    <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                        aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}"
                            alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body comment_history_data ward_summary_sub_modal_inner_body">


            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <button class="btn btn-primary-grey" data-bs-dismiss="modal" aria-label="Close"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="ipc-add-patient-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" data-bs-backdrop="static" tabindex="-1"
    id="add_scub_patient" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">ADD PATIENT DETAILS</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseICOffcanvas('add_scub_patient');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14"
                        class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="row">
            <div class="col-12 ">
                <div class="ipc-patient-data-wrapper">
                        <input type="hidden" id="scub_bed_id" value="">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div>
                                    <label for="scub_camis_patient_id" class="form-label">RTL ID</label>
                                    <input type="text" class="form-control" id="scub_camis_patient_id" aria-describedby="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="scub_pas_number" class="form-label">Hospital Number</label>
                                    <input type="text" class="form-control" id="scub_pas_number" aria-describedby="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="scub_patient_name" class="form-label">Patient Name</label>
                                    <input type="text" class="form-control" id="scub_patient_name" aria-describedby="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="scub_consultant_name" class="form-label">Consultant Name</label>
                                    <input type="text" class="form-control" id="scub_consultant_name" aria-describedby="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <label for="scub_speciality" class="form-label">Speciality</label>
                                    <input type="text" class="form-control" id="scub_speciality" aria-describedby="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="scub_patient_gender" class="form-label">Patient Gender</label>
                                    <select class="form-select selectric-select" id="scub_patient_gender" aria-label="Default select example">
                                        <option selected>Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="scub_admitting_date" class="form-label">Admitting Date</label>
                                    <input type="text" class="form-control" id="scub_admitting_date" aria-describedby="" readonly>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-12">
                <div class="row g-2 ibox_modal_footer_button_class">
                    <div class="col-lg-4 col-md-4">
                        <button
                            class="btn btn-primary-grey me-2 all_modal_save_button_for_js bottom-save-button camis_patient_ward_summary_boardround_save_patient_scub_patient_data ">
                            <img class='loading-save-svg-to-show-on-save'
                                src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18"
                                height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button
                            class="btn btn-primary-grey me-2 all_modal_delete_button_for_js bottom-delete-button camis_patient_ward_summary_boardround_remove_scub_patient_data flag_button">
                            <img class='loading-delete-svg-to-show-on-delete'
                                src="{{ asset('asset_v2/Ibox/icons/loading-delete.svg') }}" alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/deselect.svg') }}" alt=""
                                class="btn-icon-modal normal-delete-svg-to-show-on-delete" width="16"
                                height="16"><span>REMOVE PATIENT</span>
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button class="btn btn-primary-grey"  onclick="CloseICOffcanvas('add_scub_patient');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="infection-history-modal modal fade camis_ward_summary_boardround_sub_inner_popup_common_class" id="infectionHistory" data-bs-backdrop="static" tabindex="-1"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h6 class="modal-title" id="exampleModalLabel">Infection History</h6>
            </div>
            <div>
                <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                    aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
        <div class="modal-popup-loader-content"></div>
        <div class="modal-body infection_history_data ward_summary_sub_modal_inner_body">

        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-lg-2 col-md-4 offset-md-4 offset-lg-5">
                    <button class="btn btn-primary-grey"  data-bs-dismiss="modal"
                    aria-label="Close"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                            class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
