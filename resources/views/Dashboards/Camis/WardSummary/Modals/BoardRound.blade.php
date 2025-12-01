

<div class="board-round-tasks-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="modal_start_boardround" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">BOARD ROUND</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('modal_start_boardround');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body boardround_config_data">


    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 ibox_modal_footer_button_class">

                        <button class="btn btn-primary-grey camis_ward_action_boardround board_round_start all_modal_save_button_for_js bottom-save-button "   onclick="CloseOffcanvas('modal_start_boardround');" ><img
                                src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal"
                                width="18" height="18"  data-boardround-missed="0"><span class="board_round_button_text">START</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-primary-grey boardround_cancel_button finish_boardround get_board_round_user_list d-none"><span>FINISH BOARDROUND</span>
                        </button>

                        <button class="btn btn-primary-grey boardround_cancel_button stop_boardround"  onclick="CloseOffcanvas('modal_start_boardround');"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal"
                                width="12" height="12"><span>CANCEL</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


