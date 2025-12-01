<div class="nof-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_dp_add_comment" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel"> Add Comment</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_patient_dp_add_comment');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">

                        <div class="row mb-3">
                            <div class="col-12 ">


                                <div class="mb-2">
                                    <input type="hidden" name="camis_comment_user_id" id="camis_comment_user_id" value="">
                                    <input type="hidden" name="surgical_comment_id" id=""  value="">
                                    <textarea name="ibox_surgical_wards_comments" class="form-control ibox_surgical_wards_comments" id="ibox_surgical_wards_save_comments"
                                              placeholder="Please enter comment" rows="6"></textarea>
                                </div>
                            </div>
                        </div>





    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_dp_ward_save_comments ">

                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_dp_add_comment');" >

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="nof-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_dp_update_comment" aria-labelledby="offcanvasRightLabel" style="z-index: 10000;">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">Update Comment</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_dp_update_comment');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">

                    <div class="row mb-3">
                        <div class="col-12 ">


                            <div class="mb-2">
                                <input type="hidden" name="camis_comment_user_id" id="" value="">
                                <input type="hidden" name="surgical_comment_id" id="surgical_comment_id"  value="">
                                <textarea name="ibox_surgical_wards_comments" class="form-control ibox_surgical_wards_comments" id="ibox_surgical_wards_comments"
                                          placeholder="Please enter comment" rows="6"></textarea>
                            </div>
                        </div>
                    </div>







    </div>
    <div class="offcanvas-footer">
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey all_modal_save_button_for_js bottom-save-button camis_patient_dp_ward_update_comments ">

                            <img class='loading-save-svg-to-show-on-save'
                                        src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}"
                                        alt="" />
                            <img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt=""
                                class="btn-icon-modal normal-save-svg-to-show-on-save" width="18" height="18"><span>SAVE</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <button class="btn btn-primary-grey"  onclick="CloseOffcanvas('camis_patient_dp_update_comment');">

                            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="comments-all-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="viewAllComments" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">ALL COMMENTS</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('viewAllComments');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div class="card-comments all_comment_list">

        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('viewAllComments');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="show-history-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camis_patient_ward_boardround_show_history"
        aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel">HISTORY</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camis_patient_ward_boardround_show_history');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="offcanvas-body show_boardround_history">

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_ward_boardround_show_history');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="manage-task-offcanvas offcanvas offcanvas-end  camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="camis_patient_dp_task_management" aria-modal="true" role="dialog">
    <div class="offcanvas-header card-header fw-bold">
      <div class="d-flex align-items-center justify-content-between w-100">
        <div class="">
          <h6 class="mb-0" id="offcanvasRightLabel">Manage Task</h6>
        </div>
        <div class="">
          <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('camis_patient_dp_task_management');">
            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3" /> CLOSE </button>
        </div>
      </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
      <div class="ibox_board_round_patient_task_content_show">

      </div>
    </div>
    <div class="offcanvas-footer">
      <div class="row gx-2">
        <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
          <button class="btn btn-primary-grey" onclick="CloseOffcanvas('camis_patient_dp_task_management');">
            <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" class="btn-icon-modal" width="12" height="12" />
            <span>CLOSE</span>
          </button>
        </div>
      </div>
    </div>
</div>



@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.DPCommon')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.Escalation')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.EscalationCancel')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.DPTimeline')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.CapillaryBloodGlucose')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.WorkingDiagnosis')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.SepsisAssesment')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.SepsisAssesmentCheckBox')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.AkiAssessment')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.AkiTaskConfirm')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.DPTaskReview')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.TaskDetails')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.SepsisTaskList')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.Diabetic')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.Tep')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.Resuscitation')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.ReviewLatestInvestigation')

@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.ReasonableAdjustmentConsider')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.ReasonableAdjustmentRequired')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.ResusStatus')
@include('Dashboards.Camis.WardSummary.BoardRoundModals.TaskAction.EscalationPlan')
