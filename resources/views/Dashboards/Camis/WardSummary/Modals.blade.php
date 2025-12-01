

<div class="modal fade  zoom-in" id="ward_summary_dummy_modal_for_loader" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable WardboxModal" style='max-width:99%;'>
        <div class="modal-content">
            <div class="ward_summary_dummy_modal_for_loader_content">
                <div class="RodalHead wardboxPopupModalHead">
                    <h3 class="modal_popup_box_top_head_main_heading">
                        Patient Boardround
                    </h3>
                    <div class="modal_popup_box_top_head_right_button">
                        <button class="move button_red_gradiant" data-toggle="modal" data-dismiss="modal" data-target="#allowedTobemovedPop">
                            X
                        </button>
                    </div>
                </div>
                <div class="modal-body RodalComment">
                    <div class="container-fluid modal-ward-summary-loader-container-styles">
                        <div class="modal-dummy-content-loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--<!-- Modal -->--}}
{{--<div class="modal fade drworkplanPop" id="drworkplanPop" tabindex="-1" role="dialog" aria-labelledby="drworkplanPopLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog" role="document" id="doctor_modal_plan_html">--}}

{{--    </div>--}}
{{--</div>--}}


<!-- Doctor's Work Plan Modal -->



<!-- Doctor's Work Plan Modal End -->


<!-- Modal -->
<div class="modal fade" id="RnworkflowPop" tabindex="-1" role="dialog" aria-labelledby="RnworkflowPopLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rodalModal TaskRnpopWrap TaskDrpopWrap wardboxpopupchildModals">
            <div class="modal-header ChildpopHeadBoardRound">
                <h5 class="modal-title" id="RnworkflowPopLabel">Nurse work plan - 0 Patients & 0 Tasks</h5>
                <button type="button" class="close" data-toggle="modal" data-target="#RnworkflowPop" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body addAttendanceBoardrounList TaskRnWrapInner TaskDrWrapInner">
                <div class="row">
                    <div class="col-md-12"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <select name="" id="">
                            <option value="value1">All Group</option>
                            @foreach($success_array['task_group'] as $group)
                               <option value="{{ $group->id }}">{{ $group->task_group_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(count($success_array['task_of_patients']) > 0)
                    <div class="contentWrap">
                        @foreach($success_array['task_of_patients'] as $task)
                            <table class="taskListTable" cellpadding="20px" style="width: 100%; margin-bottom: 10px;">
                                <thead>
                                <tr>
                                    <th colspan="2" style="padding: 8px; background-color: rgb(26, 188, 156); color: rgb(255, 255, 255); -webkit-print-color-adjust: exact;">
                                        {{ $task->camis_patient_forename }} - {{ $task->ibox_actual_bed_full_name }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($task->PatientTasks as $data)
                                <tr>

                                    <td>
                                        <table>
                                            <tbody>

                                                <tr>
                                                    <td style="padding: 10px; width: 100%; background-color: rgb(245, 245, 245);">
                                                        #{{ $data->task_description }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 10px; width: 100%; background-color: rgb(245, 245, 245);">
                                                        Assigned to: {{$data->GroupName->task_group_name}} ({{  PredefinedDateFormatOnTask($data->task_estimated_date_for_completion) }})</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                    <td><button>Click to compleate</button></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                    @else
                    <div class="col-md-12"><span class="nodataMessage">{{ NotFoundMessage() }}</span></div>
                    @endif
                </div>
                <div class="buttonWrapBottom"><button><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" size="18" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg><span>Save</span></button><button href="#"><svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" size="18" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.707 7.293l-4-4c-.187-.188-.441-.293-.707-.293h-8c-1.654 0-3 1.346-3 3v12c0 1.654 1.346 3 3 3h10c1.654 0 3-1.346 3-3v-10c0-.266-.105-.52-.293-.707zm-2.121.707h-1.086c-.827 0-1.5-.673-1.5-1.5v-1.086l2.586 2.586zm-.586 11h-10c-.552 0-1-.448-1-1v-12c0-.552.448-1 1-1h7v1.5c0 1.379 1.121 2.5 2.5 2.5h1.5v9c0 .552-.448 1-1 1z">
                            </path>
                        </svg><span>Print</span></button><button href="#"><svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" size="18" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.707 7.293l-4-4c-.187-.188-.441-.293-.707-.293h-8c-1.654 0-3 1.346-3 3v12c0 1.654 1.346 3 3 3h10c1.654 0 3-1.346 3-3v-10c0-.266-.105-.52-.293-.707zm-2.121.707h-1.086c-.827 0-1.5-.673-1.5-1.5v-1.086l2.586 2.586zm-.586 11h-10c-.552 0-1-.448-1-1v-12c0-.552.448-1 1-1h7v1.5c0 1.379 1.121 2.5 2.5 2.5h1.5v9c0 .552-.448 1-1 1z">
                            </path>
                        </svg><span> Print W/O Pagebreak</span></button></div>
            </div>

        </div>
    </div>
</div>



<div class="modal fade  zoom-in" id="camis_patient_ward_summary_boardround_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable WardboxModal" style='max-width:99%;'>
        <div class="modal-content">
            <div class="camis_patient_ward_summary_boardround_modal_content"></div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="btn btn-secondary bottom-prev-button-disabled button_ward_summary_boardround_prev_patient">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                        </svg>
                        <span class="btnLbl ">Prev Patient</span>
                    </button>
                    <button type="button" class="btn btn-secondary close_board_round bottom-cancel-button breach_reason_attendance_cancel_patient" data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-next-button-disabled button_ward_summary_boardround_next_patient">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                        <span class="btnLbl ">Next Patient</span>
                    </button>

                    <button type="button" class="btn btn-secondary button_ward_summary_boardround_show_history">
                        <span class="btnLbl ">Show History</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_admitting_reason" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Admitting Reason / Past Medical History</h5>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message"> </div>
                <div class="inputWrap">
                    <textarea name="ibox_board_round_content_admitting_reason" id='ibox_board_round_content_admitting_reason' class='form-control ibox_text_area_min_styles ibox_board_round_content_admitting_reason' type="text"></textarea>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_admitting_reason">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_social_history" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Social History / Patient Goal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_social_history_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="inputWrap">
                    <textarea name="ibox_board_round_content_social_history" id='ibox_board_round_content_social_history' class='form-control ibox_text_area_min_styles ibox_board_round_content_social_history' type="text"></textarea>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_social_history">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_working_diagnosis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Working Diagnosis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_working_diagnosis_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="inputWrap">
                    <textarea name="ibox_board_round_content_working_diagnosis" id='ibox_board_round_content_working_diagnosis' class='form-control ibox_text_area_min_styles ibox_board_round_content_working_diagnosis' type="text"></textarea>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_working_diagnosis">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_estimated_discharge_date" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estimated Discharge Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_edd_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="col-md-12  ">
                    <div class="col-md-12 padding-zero" id="boardround_edd_date_show_calendar_div"></div>
                    <input type="hidden" name="ibox_board_round_content_estimated_discharge_date" id="ibox_board_round_content_estimated_discharge_date" value="" />
                </div>
                <div class="col-md-12 inputWrap padding-zero boardround_edd_date_first_time_hide_edd_comments">
                    <div class="col-md-12  modal_head_sub_titles">
                        Reason To Change EDD Dates.
                    </div>
                    <div class="col-md-12  ">
                        <textarea id="ibox_board_round_content_estimated_discharge_date_comment" rows="6" class="form-control ibox_text_area_min_height ibox_board_round_content_estimated_discharge_date_comment"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_estimated_discharge_date">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_reason_to_reside" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style='max-width:80%'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reason To Reside</h5>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_reason_to_reside_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <input type="hidden" name="ibox_board_round_content_med_fit_set_as_no" id="ibox_board_round_content_med_fit_set_as_no" value="" />
                <div class="col-md-12 padding-zero">
                    <div class="col-md-12 padding-zero">
                        <div class="col-md-6 padding-zero popup_reason_to_reside_sub_content_block">
                            <div class="col-md-12 padding-zero">
                                <div class='popup_reason_to_reside_sub_head'>Physiology</div>
                            </div>
                            @if (!empty($success_array['reason_to_reside']))
                                @foreach ($success_array['reason_to_reside'] as $row_reason)
                                    @if ($row_reason->reason_to_reside_text_value_category == 'Physiology' && $row_reason->reason_to_reside_board_round_show_status == 1)
                                        <div class="col-md-12 popup_reason_to_reside_list_data">
                                            <div class='popup_reason_to_reside_list_data_radio'><input type="radio" class="ibox_board_round_content_patient_reason_to_reside" name="ibox_board_round_content_patient_reason_to_reside" value="{{ $row_reason->id }}"></div>
                                            <span class='popup_reason_to_reside_list_data_content'>{{ $row_reason->reason_to_reside_text_value }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-6 padding-zero popup_reason_to_reside_sub_content_block">
                            <div class="col-md-12 padding-zero">
                                <div class='popup_reason_to_reside_sub_head'>Recovery</div>
                            </div>
                            @if (!empty($success_array['reason_to_reside']))
                                @foreach ($success_array['reason_to_reside'] as $row_reason)
                                    @if ($row_reason->reason_to_reside_text_value_category == 'Recovery' && $row_reason->reason_to_reside_board_round_show_status == 1)
                                        <div class="col-md-12 popup_reason_to_reside_list_data">
                                            <div class='popup_reason_to_reside_list_data_radio'><input type="radio" class="ibox_board_round_content_patient_reason_to_reside" name="ibox_board_round_content_patient_reason_to_reside" value="{{ $row_reason->id }}"></div>
                                            <span class='popup_reason_to_reside_list_data_content'>{{ $row_reason->reason_to_reside_text_value }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-6 padding-zero popup_reason_to_reside_sub_content_block">
                            <div class="col-md-12 padding-zero">
                                <div class='popup_reason_to_reside_sub_head'>Treatment</div>
                            </div>
                            @if (!empty($success_array['reason_to_reside']))
                                @foreach ($success_array['reason_to_reside'] as $row_reason)
                                    @if ($row_reason->reason_to_reside_text_value_category == 'Treatment' && $row_reason->reason_to_reside_board_round_show_status == 1)
                                        <div class="col-md-12 popup_reason_to_reside_list_data">
                                            <div class='popup_reason_to_reside_list_data_radio'><input type="radio" class="ibox_board_round_content_patient_reason_to_reside" name="ibox_board_round_content_patient_reason_to_reside" value="{{ $row_reason->id }}"></div>
                                            <span class='popup_reason_to_reside_list_data_content'>{{ $row_reason->reason_to_reside_text_value }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-6 padding-zero popup_reason_to_reside_sub_content_block">
                            <div class="col-md-12 padding-zero" style="text-align:left;">
                                <div class='popup_reason_to_reside_sub_head'>Function</div>
                            </div>
                            @if (!empty($success_array['reason_to_reside']))
                                @foreach ($success_array['reason_to_reside'] as $row_reason)
                                    @if ($row_reason->reason_to_reside_text_value_category == 'Function' && $row_reason->reason_to_reside_board_round_show_status == 1)
                                        <div class="col-md-12 popup_reason_to_reside_list_data">
                                            <div class='popup_reason_to_reside_list_data_radio'><input type="radio" class="ibox_board_round_content_patient_reason_to_reside" name="ibox_board_round_content_patient_reason_to_reside" value="{{ $row_reason->id }}"></div>
                                            <span class='popup_reason_to_reside_list_data_content'>{{ $row_reason->reason_to_reside_text_value }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12" style="margin: 10px 0;"></div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_reason_to_reside">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-delete-button all_modal_delete_button_for_js" data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>








<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_medically_fit_for_discharge_yes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Medically Fit For Discharge</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_medfit_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="col-md-12   medfit_yes_text_consultant_block">
                    <span class='medfit_yes_consultant_head'>Consultant :</span><span class='medfit_yes_consultant_head_doctor_name'></span>
                </div>
                <div class="col-md-12   padding-zero ">
                    <textarea id="ibox_board_round_content_patient_medically_fit_status_comment" placeholder="Please Enter Comment" rows="6" class="form-control ibox_text_area_min_height ibox_board_round_content_patient_medically_fit_status_comment"></textarea>
                </div>
                <div class="col-md-12 medfit_yes_text_label_block">
                    <label class="medfit_yes_text_label form-check-label"><input type="checkbox" class="medfit_yes_consultant_check_input" id='medfit_yes_consultant_check_input' />Click to acknowledge that the consultant responsible for the care of this patient has agreed that the patient is medically fit to be discharged.</label>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_medfit_for_discharge">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


















<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_red_green_bed_status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Red To Green</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div id="camis_patient_ward_summary_boardround_red_to_green_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  modal_head_sub_titles modal_head_sub_titles_red_bed">
                        Reason For Red Status
                    </div>
                    <div class="col-md-12  padding-zero">
                        <select id='patient_red_green_status_reason_code' name="patient_red_green_status_reason_code" class="form-control patient_red_green_status_reason_code">
                            @if (!empty($success_array['bed_red_reason']))
                                @foreach ($success_array['bed_red_reason'] as $row)
                                    <option value="{{ $row->id }}">{{ $row->red_text_value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_red_bed_status">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_red_green_to_green_bed_status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Red To Green</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_red_to_green_green_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Are you sure, you want to set status as <br>
                        <div class="boardround_red_to_green_green_set_text">GREEN BED</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_green_bed_status">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_red_green_bed_status_remove" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Red To Green</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_red_to_green_remove_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Do you really want to <span class='boardround_remove_popup_text_highlight'>remove</span> this record?</div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_green_bed_status">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Delete</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_potential_definite" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Potential / Definite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_pd_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <input type="hidden" name="ibox_board_round_patient_potential_definite_status" id="ibox_board_round_patient_potential_definite_status" value="" />
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Are you sure, you want to set status as <br>
                        <div class="boardround_pd_set_text_value"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_potential_definite">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_potential_definite_status_remove" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Potential / Definite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_potential_definite_remove_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>


                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Do you really want to <span class='boardround_remove_popup_text_highlight'>remove</span> this record?</div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_potential_definite_status">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Delete</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_edn_status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDN Bed Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_edn_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <input type="hidden" name="ibox_board_round_patient_edn_status" id="ibox_board_round_patient_edn_status" value="" />
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Are you sure, you want to set status to <br>
                        <div class="boardround_edn_set_text_value"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_edn_status">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_edn_status_remove" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDN Bed Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_edn_remove_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>


                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Do you really want to <span class='boardround_remove_popup_text_highlight'>remove</span> this record?</div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_edn_status">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Delete</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_tto_status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TTO Bed Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_tto_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <input type="hidden" name="ibox_board_round_patient_tto_status" id="ibox_board_round_patient_tto_status" value="" />
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Are you sure, you want to set status to <br>
                        <div class="boardround_tto_set_text_value"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_tto_status">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_tto_status_remove" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TTO Bed Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_tto_remove_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>


                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Do you really want to <span class='boardround_remove_popup_text_highlight'>remove</span> this record?</div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>

                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_tto_status">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Delete</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>








<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_pharmacy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ward_summary_boardround_pharmacy_popup_wrap">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pharmacy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_pharmacy_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>


                <div class="pharmacyPopinner camis_patient_ward_summary_boardround_pharmacy_inner">

                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_pharmacy_info">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>





{{-- <div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_allowed_to_move" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Allowed To Move</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div id="camis_patient_ward_summary_boardround_allowed_to_move_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  padding-zero">
                        <input type="hidden" name="boardround_patient_allowed_to_be_moved_from" id="boardround_patient_allowed_to_be_moved_from" value="{{ $success_array['ward_details']['ward_short_name'] }}" />
                        <select id='boardround_patient_allowed_to_be_moved_to' name="boardround_patient_allowed_to_be_moved_to" class="form-control patient_red_greeboardround_patient_allowed_to_be_moved_ton_status_reason_code">
                            <option value="Do Not Move">Do Not Move</option>
                            @if (!empty($success_array['ward_list']))
                                @foreach ($success_array['ward_list'] as $row)
                                    @if ($row->ward_short_name != $success_array['ward_details']['ward_short_name'])
                                        <option value="{{ $row->ward_short_name }}">{{ $row->ward_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <div class="inputWrap">
                            <textarea name="boardround_patient_allowed_to_be_moved_comment" id='boardround_patient_allowed_to_be_moved_comment' class='form-control ibox_text_area_min_styles boardround_patient_allowed_to_be_moved_comment' type="text"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_allowed_to_be_moved">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_allowed_to_be_moved">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Delete</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> --}}







<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class " id="camis_patient_ward_summary_boardround_assign_task" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered board_round_assign_task_popup_wrap modal-dialog-scrollable" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Tasks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <input type="hidden" class='boardround_patient_task_id_update' name="boardround_patient_task_id_update" id="boardround_patient_task_id_update" value="" />
                <div id="camis_patient_ward_summary_boardround_assign_task_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="board_round_assign_task_popup_inner">
                    <div class="col-md-12 boardround_patient_task_description_inner">
                        <input class='form-control boardround_patient_task_description' id='boardround_patient_task_description' type="text" placeholder="Enter task description" value="">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <select id='boardround_patient_task_group' name="boardround_patient_task_group" class="form-control boardround_patient_task_group">
                                <option value="">Select User Group</option>
                                @if (!empty($success_array['task_group']))
                                    @foreach ($success_array['task_group'] as $row)
                                        <option value="{{ $row->task_group_name }}">{{ $row->task_group_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group DatePickerWrap">
                                    <div class="react-datepicker-wrapper">
                                        <div class="react-datepicker__input-container">
                                            <input type="text" readonly="readonly" placeholder="Task Estimated Completion Date" id='boardround_patient_task_estimated_date_for_completion' class="datepickerInput form-control boardround_patient_task_estimated_date_for_completion" data-estimated-date-for-completion="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="datePickerIco">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" size="20" height="20" width="20">
                                            <path d="M7 11H9V13H7zM7 15H9V17H7zM11 11H13V13H11zM11 15H13V17H11zM15 11H17V13H15zM15 15H17V17H15z"> </path>
                                            <path d="M5,22h14c1.103,0,2-0.897,2-2V8V6c0-1.103-0.897-2-2-2h-2V2h-2v2H9V2H7v2H5C3.897,4,3,4.897,3,6v2v12 C3,21.103,3.897,22,5,22z M19,8l0.001,12H5V8H19z"> </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="form-group clockpicker timePicker">
                                    <input type="text" readonly="readonly" class="form-control boardround_patient_task_estimated_time_for_completion" data-estimated-time-for-completion="{{ date('H') . ':00' }}" value="{{ date('H') . ':00' }}" name="boardround_patient_task_estimated_time_for_completion" id="boardround_patient_task_estimated_time_for_completion" placeholder="Task Estimated Completion Time">
                                    <button class="timepickerTrigger input-group-addon">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" size="16" color="#333" height="16" width="16" style="color: rgb(51, 51, 51);">
                                            <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z"> </path>
                                            <path d="M686.7 638.6L544.1 535.5V288c0-4.4-3.6-8-8-8H488c-4.4 0-8 3.6-8 8v275.4c0 2.6 1.2 5 3.3 6.5l165.4 120.6c3.6 2.6 8.6 1.8 11.2-1.7l28.6-39c2.6-3.7 1.8-8.7-1.8-11.2z"> </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 buttonWrap">
                                <button class="task_priority_inner ibox_buttons ibox_board_round_patient_task_assign_priority_inner ">Priority</button>
                                <button class="black ibox_buttons ibox_board_round_patient_task_assign_morning_evening_inner">Morning Board Round</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea class='form-control boardround_patient_task_comment' id='boardround_patient_task_comment' placeholder="Enter Comment"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_task_create_or_update">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button camis_patient_ward_summary_boardround_cancel_task_create_or_update" data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_assign" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Patient Flag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Are you sure, you want to assign <br>
                        <div class="boardround_patient_flag_image_content_show"></div>
                        <div class="boardround_patient_flag_text_content_show"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_remove" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Patient Flag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12  boardround_popup_sub_text_content_block"> Are you sure, you want to remove <br>
                        <div class="boardround_patient_flag_image_content_show"></div>
                        <div class="boardround_patient_flag_text_content_show"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_nof" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NOF Flag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12 col- padding-zero">
                        <div class="col-md-12" style=" padding: 15;">
                            <b> Assigning NOF Flag will automatically assign the following tasks</b><br/>
                            <ol style="font-size: 14px; margin-top: 20px; margin-bottom: 20px;" class="li-space">
                                @foreach($success_array['nof_task'] as $task)
                                    <li>{{$task['auto_populate_task_name']}} - {{$task['task_user_group']['task_group_name']}}</li>
                                @endforeach

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_cld" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CLD (Criteria Led Discharge)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div id="camis_patient_ward_summary_boardround_edd_success_message" class="col-xs-12 col-md-12 padding-zero"> </div>
                <div class="col-md-5  ">
                    <div class="col-md-12 padding-zero" id="datepicker"></div>
                    <input type="hidden" name="ibox_board_round_cld_date" id="ibox_board_round_content_cld_date" value="" />
                </div>
                <div class="col-md-7 inputWrap padding-zero boardround_edd_date_first_time_hide_edd_comments">
                    <div class="col-md-12  modal_head_sub_titles">
                        Additional Comment
                    </div>
                    <div class="col-md-12  ">
                        <textarea id="ibox_board_round_content_cld_comment" rows="6" class="form-control ibox_text_area_min_height ibox_board_round_content_cld_comment"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_cld">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_nurse_concern" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nurse Concern Flag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12 col- padding-zero">
                        <div class="col-md-12" style=" padding: 15;">
                            <b> Assigning Nurse Concern Flag will automatically assign the following tasks</b><br/>
                            <ol style="font-size: 14px; margin-top: 20px; margin-bottom: 20px;" class="li-space">
                                @foreach($success_array['dp_task'] as $task)
                                    <li>{{$task['auto_populate_task_name']}} - {{$task['task_user_group']['task_group_name']}}</li>
                                @endforeach

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_plasma" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Plasma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-6 col-6 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_plasma_button ibox_boardround_patient_flag_plasma_on_plasma ">
                            <span class="patient_flag_plasma_button_text">On Plasma</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-6 col-6 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_yellow_gradiant ibox_boardround_patient_flag_plasma_button ibox_boardround_patient_flag_plasma_requiring_plasma ">
                            <span class="patient_flag_plasma_button_text">Requiring Plasma</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_plasma">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_infection_risk" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style='width:700px; max-width:99%;'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Infection Risk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-3 col-6  infection_risk_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_infection_risk_button ibox_boardround_patient_flag_infection_risk_query ">
                            <span class="patient_flag_infection_risk_button_text">Query</span>
                            <div class="ibox_boardround_patient_flag_infection_risk_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-3 col-6  infection_risk_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_infection_risk_button ibox_boardround_patient_flag_infection_risk_confirmed ">
                            <span class="patient_flag_infection_risk_button_text">Confirmed</span>
                            <div class="ibox_boardround_patient_flag_infection_risk_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>

                    <div class="col-md-3 col-6  infection_risk_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_infection_risk_button ibox_boardround_patient_flag_infection_risk_resolved ">
                            <span class="patient_flag_infection_risk_button_text">Resolved</span>
                            <div class="ibox_boardround_patient_flag_infection_risk_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>

                    <div class="col-md-3 col-6  infection_risk_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_infection_risk_button ibox_boardround_patient_flag_infection_risk_can_stay_in_bed ">
                            <span class="patient_flag_infection_risk_button_text">Can Stay In Bay</span>
                            <div class="ibox_boardround_patient_flag_infection_risk_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>

                    <div class="col-md-12 infection_patient_flag_risk_reason">
                        <div class="form-group">
                            <select id='patient_flag_infection_risk_reason' name="patient_flag_infection_risk_reason" class="form-control patient_flag_infection_risk_reason">
                                <option value="">Select Infection Risk</option>
                                @if (!empty($success_array['infection_control']))
                                    @foreach ($success_array['infection_control'] as $row)
                                        <option value="{{ $row->id }}">{{ $row->infection_list_show_data_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_infection_risk">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_off_the_ward" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Off The Ward</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-4 col-4 padding-zero off_the_ward_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_off_the_ward_button ibox_boardround_patient_flag_off_the_ward_surgary ">
                            <span class="patient_flag_plasma_button_text">Surgery</span>
                            <div class="ibox_boardround_patient_flag_off_the_ward_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-4 col-4 padding-zero off_the_ward_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_off_the_ward_button ibox_boardround_patient_off_the_ward_therapies ">
                            <span class="patient_flag_plasma_button_text">Therapies</span>
                            <div class="ibox_boardround_patient_flag_off_the_ward_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-4 col-4 padding-zero off_the_ward_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_off_the_ward_button ibox_boardround_patient_flag_off_the_ward_other ">
                            <span class="patient_flag_plasma_button_text">Other</span>
                            <div class="ibox_boardround_patient_flag_off_the_ward_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_off_the_ward">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_leaflet_one" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style='width:700px; max-width:99%;'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leaflet One</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                    <div class="contentwrap">
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label">Have you discussed the 4 questions with the Patient?</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label">1. What is the main reason I am in hospital for?</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label">2. What is going to happen to me today and tomorrow?</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label">3. What extra help may I need when I leave hospital?</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label">4. When will I be able to leave hospital?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_leaflet_two" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style='width:700px; max-width:99%;'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leaflet Two</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                    <div class="contentwrap">
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="leaflet_two" id="leaflet_2" type="radio" class="form-check-input" value="1" checked="checked">A: You are leaving hospital and returning home</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="leaflet_two" id="leaflet_2" type="radio" class="form-check-input" value="2">B: You are leaving hospital moving or returning to another place of care</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="leaflet_two" id="leaflet_2" type="radio" class="form-check-input" value="3">C: Looking after family and friends after they leave hospital</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_leaflet_two">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>







<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_one_one_care" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style='width:700px; max-width:99%;'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">1 To 1 Care</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                    <div class="contentwrap">
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="eol" id="one_one_checkbox_1" type="checkbox" class="form-check-input">Risk Assessment</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="others" id="one_one_checkbox_2" type="checkbox" class="form-check-input">Agreed The One One</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_one_one_care">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_patient_flag_dialysis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dialysis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-6 col-6 padding-zero dialysis_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant ibox_boardround_patient_flag_dialysis_button ibox_boardround_patient_flag_dialysis_on_dialysis ">
                            <span class="patient_flag_dialysis_button_text">On Dialysis</span>
                            <div class="ibox_boardround_patient_flag_dialysis_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-6 col-6 padding-zero dialysis_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_yellow_gradiant ibox_boardround_patient_flag_dialysis_button ibox_boardround_patient_flag_dialysis_requiring_dialysis ">
                            <span class="patient_flag_dialysis_button_text">Requiring Dialysis</span>
                            <div class="ibox_boardround_patient_flag_dialysis_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_patient_flag_dialysis">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">SAVE</span>
                    </button>
                    <button type="button" class="all_modal_delete_button_for_js btn btn-secondary bottom-delete-button camis_patient_ward_summary_boardround_remove_patient_flag">
                        <img class='loading-delete-svg-to-show-on-delete' src="{{ asset('asset/Ibox/Images/icons/loading-delete.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-trash3-fill normal-delete-svg-to-show-on-delete" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        <span class="btnLbl">Deselect</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="potentialPop" tabindex="-1" role="dialog" aria-labelledby="definitePopLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rodalModal DischargePopWrap wardboxpopupchildModals">
            <div class="modal-header ChildpopHeadBoardRound">
                <h5 class="modal-title" id="definitePopLabel">Potential Discharge Patients List</h5>
                <div onclick="print_pd_doc('potential_document_details_insert')" class="close_ibox_top_div" style="right: 38px;">
                    <img src="{{asset('asset/icons/print_icon_da.png')}}" style="width:28px; cursor: pointer;">
                  </div>
                <button type="button" class="close" data-toggle="modal" data-target="#potentialPop" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body RodalComment DischargePopWrapInner"><div class="row"><div class="col-md-12">

                <div class="col-md-12 padding-zero" id="potential_document_details_insert">
                    @if(count($success_array['patient_potential_today']) > 0)
                        @foreach($success_array['patient_potential_today'] as $potential_discharge_patients)
                            <div class="content_box">

                                <h4 style="background-color: rgb(241, 241, 241); -webkit-print-color-adjust: exact;">
                                    {{ $potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_name }}
                                </h4>
                                <div class="row" style="background-color: rgb(249, 249, 249); -webkit-print-color-adjust: exact;">
                                    <div class="col-9">
                                        <p>Age : {{ $potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_age }}<br>
                                            Hospital Number : {{ $potential_discharge_patients->patient_id }} (DOB {{ $potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_date_of_birth }})<br>
                                            {{($potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_number != 0) ? $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_name . ' ' . $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_number : $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_name}} : {{$potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_type . ' ' . $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_no}} <br>
                                            LOS {{ NumberOfDaysBetweenTwoDates($potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_admission_date, date('Y-m-d')) }} Days Total with {{ NumberOfDaysBetweenTwoDates($potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_ward_start_date, date('Y-m-d')) }} Days on this ward <br>
                                            Admitting Reason / Past Medical History : {{ isset($potential_discharge_patients->AdmittingReason) ? $potential_discharge_patients->AdmittingReason->patient_admitting_reason : '' }}<br>
                                            Social History / Patient Goal : {{ isset($potential_discharge_patients->SocialHistory) ? $potential_discharge_patients->SocialHistory->patient_social_history : '' }}<br>
                                            Consultant : {{$potential_discharge_patients->PatientInformationWithBedDetails->camis_consultant_name}}<br>
                                            Med Fit :
                                            @if(!empty($potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_medical_fit_date))
                                                Yes
                                            @else
                                                @if(isset($potential_discharge_patients->BoardRoundMedicallyFitData))
                                                    @if($potential_discharge_patients->BoardRoundMedicallyFitData->patient_medically_fit_status  == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                @endif
                                            @endif <br>
                                            @if(isset($potential_discharge_patients->BoardRoundEstimatedDischargeDate))
                                            EDD : {{$potential_discharge_patients->BoardRoundEstimatedDischargeDate->patient_estimated_discharge_date }} <br>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-3">
                                        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
                                            @if($potential_discharge_patients->PatientFlag->count() > 0)
                                                @foreach($potential_discharge_patients->PatientFlag as $flags)
                                                        <img src="{{ asset('asset/Ibox/Images/icons/ward_flags/'.$flags->patient_flag_name.'.png')}}"  style="margin: 0; padding: 0; width: 25%;">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div id="potential_print_on_top_matrix_id" style="display: none;">IP00084761,IP00073524,IP00082732,IP00079924</div>
                    @else
                        <tr>
                            <td style="text-align: center; padding: 10px;">{{ NotFoundMessage() }}</td>
                        </tr>
                    @endif
                </div>

            </div></div></div>

        </div>
    </div>
</div>





<div class="modal fade zoom-in" id="potentialPop" tabindex="-1" role="dialog" aria-labelledby="definitePopLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rodalModal wardboxpopupchildModals">
            <div class="modal-header ChildpopHeadBoardRound">
                <h5 class="modal-title" id="definitePopLabel">Potential Discharge Patients List</h5>
                <div onclick="print_pd_doc('potential_document_details_insert')" class="close_ibox_top_div" style="right: 38px;">
                    <img src="{{asset('asset/icons/print_icon_da.png')}}" style="width:28px; cursor: pointer;">
                  </div>
                <button type="button" class="close" data-toggle="modal" data-target="#potentialPop" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body RodalComment"><div class="row"><div class="col-md-12">

                <div class="col-md-12 padding-zero" id="potential_document_details_insert">
                    @if(count($success_array['patient_potential_today']) > 0)
                        @foreach($success_array['patient_potential_today'] as $potential_discharge_patients)
                            <div class="content_box">

                                <h4 style="background-color: rgb(241, 241, 241); -webkit-print-color-adjust: exact;">
                                    {{ $potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_name }}
                                </h4>
                                <div class="row" style="background-color: rgb(249, 249, 249); -webkit-print-color-adjust: exact;">
                                    <div class="col-lg col-md-9 col-12">
                                        <p>Age : {{ $potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_age }}<br>
                                            Hospital Number : {{ $potential_discharge_patients->patient_id }} (DOB {{ $potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_date_of_birth }})<br>
                                            {{($potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_number != 0) ? $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_name . ' ' . $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_number : $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_name}} : {{$potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_type . ' ' . $potential_discharge_patients->PatientInformationWithBedDetails->ibox_bed_no}} <br>
                                            LOS {{ NumberOfDaysBetweenTwoDates($potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_admission_date, date('Y-m-d')) }} Days Total with {{ NumberOfDaysBetweenTwoDates($potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_ward_start_date, date('Y-m-d')) }} Days on this ward <br>
                                            Admitting Reason / Past Medical History : {{ isset($potential_discharge_patients->AdmittingReason) ? $potential_discharge_patients->AdmittingReason->patient_admitting_reason : '' }}<br>
                                            Social History / Patient Goal : {{ isset($potential_discharge_patients->SocialHistory) ? $potential_discharge_patients->SocialHistory->patient_social_history : '' }}<br>
                                            Consultant : {{$potential_discharge_patients->PatientInformationWithBedDetails->camis_consultant_name}}<br>
                                            Med Fit :
                                            @if(!empty($potential_discharge_patients->PatientInformationWithBedDetails->camis_patient_medical_fit_date))
                                                Yes
                                            @else
                                                @if(isset($potential_discharge_patients->BoardRoundMedicallyFitData))
                                                    @if($potential_discharge_patients->BoardRoundMedicallyFitData->patient_medically_fit_status  == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                @endif
                                            @endif <br>
                                            @if(isset($potential_discharge_patients->BoardRoundEstimatedDischargeDate))
                                            EDD : {{$potential_discharge_patients->BoardRoundEstimatedDischargeDate->patient_estimated_discharge_date }} <br>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-lg col-md-3 col-12">
                                        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
                                            @if($potential_discharge_patients->PatientFlag->count() > 0)
                                                @foreach($potential_discharge_patients->PatientFlag as $flags)
                                                    {!! GetWardSummaryBedFlagImages($flags->patient_flag_name) !!}
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div id="potential_print_on_top_matrix_id" style="display: none;">IP00084761,IP00073524,IP00082732,IP00079924</div>
                    @else
                        <tr>
                            <td style="text-align: center; padding: 10px;">{{ NotFoundMessage() }}</td>
                        </tr>
                    @endif
                </div>

            </div></div></div>

        </div>
    </div>
</div>





<div class="modal fade  zoom-in" id="definitePop" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content rodalModal  wardboxpopupchildModals">
            <div class="modal-header ChildpopHeadBoardRound">
                <h5 class="modal-title" id="definitePopLabel">Definite Discharge Patients List</h5>
                <div onclick="print_pd_doc('definite_document_details_insert')" class="close_ibox_top_div " style="right: 38px;">
                    <img src="{{asset('asset/icons/print_icon_da.png')}}" style="width:28px; cursor: pointer;">
                </div>
                <button type="button" class="close"  data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body RodalComment ">
                <div class="loader-bg hide-on-first-load">
                    <span class="screen-center"></span>
                </div>


                <div class="row"><div class="col-md-12">

                        <div class="col-md-12 padding-zero" id="definite_document_details_insert">
                            @if(count($success_array['patient_definite_today']) > 0)
                                @foreach($success_array['patient_definite_today'] as $definite_discharge_patients)
                                    <div class="content_box">

                            <h4 style="background-color: rgb(241, 241, 241); -webkit-print-color-adjust: exact;">
                                {{ $definite_discharge_patients->PatientInformationWithBedDetails->camis_patient_name }}
                            </h4>
                            <div class="row" style="background-color: rgb(249, 249, 249); -webkit-print-color-adjust: exact;">
                                <div class="col-lg col-md-9 col-12">
                                    <p>Age : {{ $definite_discharge_patients->PatientInformationWithBedDetails->camis_patient_age }}<br>
                                        Hospital Number : {{ $definite_discharge_patients->patient_id }} (DOB {{ $definite_discharge_patients->PatientInformationWithBedDetails->camis_patient_date_of_birth }})<br>
                                        {{($definite_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_number != 0) ? $definite_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_name . ' ' . $definite_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_number : $definite_discharge_patients->PatientInformationWithBedDetails->ibox_bed_group_name}} : {{$definite_discharge_patients->PatientInformationWithBedDetails->ibox_bed_type . ' ' . $definite_discharge_patients->PatientInformationWithBedDetails->ibox_bed_no}} <br>
                                        LOS {{ NumberOfDaysBetweenTwoDates($definite_discharge_patients->PatientInformationWithBedDetails->camis_patient_admission_date, date('Y-m-d')) }} Days Total with {{ NumberOfDaysBetweenTwoDates($definite_discharge_patients->PatientInformationWithBedDetails->camis_patient_ward_start_date, date('Y-m-d')) }} Days on this ward <br>
                                        Admitting Reason / Past Medical History : {{ isset($definite_discharge_patients->AdmittingReason) ? $definite_discharge_patients->AdmittingReason->patient_admitting_reason : '' }}<br>
                                        Social History / Patient Goal : {{ isset($definite_discharge_patients->SocialHistory) ? $definite_discharge_patients->SocialHistory->patient_social_history : '' }}<br>
                                        Consultant : {{$definite_discharge_patients->PatientInformationWithBedDetails->camis_consultant_name}}<br>
                                        Med Fit :
                                        @if(!empty($definite_discharge_patients->PatientInformationWithBedDetails->camis_patient_medical_fit_date))
                                            Yes
                                        @else
                                            @if(isset($definite_discharge_patients->BoardRoundMedicallyFitData))
                                                @if($definite_discharge_patients->BoardRoundMedicallyFitData->patient_medically_fit_status  == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            @endif
                                        @endif <br>
                                        @if(isset($definite_discharge_patients->BoardRoundEstimatedDischargeDate))
                                        EDD : {{$definite_discharge_patients->BoardRoundEstimatedDischargeDate->patient_estimated_discharge_date }} <br>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-lg col-md-3 col-12">
                                    <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
                                        @if($definite_discharge_patients->PatientFlag->count() > 0)
                                            @foreach($definite_discharge_patients->PatientFlag as $flags)
                                            {!! GetWardSummaryBedFlagImages($flags->patient_flag_name) !!}
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div id="definite_print_on_top_matrix_id" style="display: none;"></div>
                @else
                    <tr>
                        <td style="text-align: center; padding: 10px;">{{ NotFoundMessage() }}</td>
                    </tr>
                @endif
            </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_escalation_status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escalation Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-4 col-4 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant dp_task_escalation_status_yes ">
                            <span class="patient_flag_plasma_button_text">Yes</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-4 col-4 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_green_gradiant dp_task_escalation_status_no ">
                            <span class="patient_flag_plasma_button_text">NO</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-4 col-4 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_black_gradiant " data-dismiss="modal">
                            <span class="patient_flag_plasma_button_text">CANCEL</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_common_popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title common_message_for_dp_modal_show_title">Escalation Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-6 col-6 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant dp_task_common_status_yes ">
                            <span class="patient_flag_plasma_button_text">Confirm</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-6 col-6 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_black_gradiant " data-dismiss="modal">
                            <span class="patient_flag_plasma_button_text">Cancel</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_escalation_status_cancel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escalation Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                    <div class="contentwrap">
                        <div class="checkboxwrap" style="width:55%;">
                            <div class="form-check">
                                <label class="form-check-label"><input name="eol" id="eol_checkbox" type="checkbox" class="form-check-input">EOL</label>
                            </div>
                        </div>
                        <div class="checkboxwrap" style="width:45%;">
                            <div class="form-check">
                                <label class="form-check-label"><input name="others" id="others_checkbox" type="checkbox" class="form-check-input">Others</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inputWrap">
                    <textarea name="escalation_cancel_text" id="ibox_board_round_escalation_text" class="form-control ibox_text_area_min_styles ibox_board_round_content_admitting_reason" type="text"></textarea>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_escalation_cancel">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_capillary_blood_glucose" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Capillary Blood Glucose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">


                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message row">
                        <div class="col-md-6 padding-zero" style="font-size:14px;    padding: 5px 0 10px 0;">Capillary Blood Glucose Result</div>
                        <div class="col-md-5" style="padding-right: 8px;">
                            <input type="text" name="cbg_result" id="cbg_result" class="form-control">
                        </div>
                        <div class="col-md-1" style="line-height: 3; padding: 0;">
                            mmols
                        </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button dp_task_capillary_glucose_status_yes">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Confirm</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_working_diagnosis_update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title common_message_for_dp_modal_show_title">Working Diagnosis Update On Ibox</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                </div>
                <div class="inputWrap">
                    <textarea name="working_diagnosis_update_text" id="ibox_board_round_working_diagnonsis_update_text" class="form-control ibox_text_area_min_styles ibox_board_round_content_admitting_reason" type="text"></textarea>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_working_diagnosis_update">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_sepsis_assessment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title common_message_for_dp_modal_show_title">Sepsis Assessment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                    Is this a new episode ?
                </div>
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-6 col-6 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_red_gradiant sepsis_new_episode ">
                            <span class="patient_flag_plasma_button_text">Yes</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-6 col-6 padding-zero plasma_inner_div_width">
                        <button data-pd-option-value="1" class="ibox_buttons patient_flag_sub_inner_button_style button_black_gradiant " data-dismiss="modal">
                            <span class="patient_flag_plasma_button_text">Cancel</span>
                            <div class="ibox_boardround_patient_flag_plasma_tick">
                                <svg width="25" height="25" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_sepsis_assessment_checkbox" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sepsis Assessment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                    <div class="contentwrap">
                        <div class="checkboxwrap" >
                            <div class="form-check">
                                <label class="form-check-label"><input name="eol" id="sepsis_input_1" type="checkbox" class="form-check-input">History of immunosuppression / surgery / wound/ invasive procedure/trauma in the last 6 weeks?</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="others" id="sepsis_input_2" type="checkbox" class="form-check-input">Does the patient look ashen/mottled/cyanosed or have a non- blanching rash?</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="others" id="sepsis_input_3" type="checkbox" class="form-check-input">Are there signs of infection?</label>
                            </div>
                        </div>
                        <div class="checkboxwrap">
                            <div class="form-check">
                                <label class="form-check-label"><input name="others" id="sepsis_input_4" type="checkbox" class="form-check-input">Could this be Sepsis?</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_sepsis_task">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_task_dp_aki_assessment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">AKI Assessment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-xs-12 col-md-12 padding-zero ward_summary_boardround_sub_inner_popup_success_message">
                    <div class="col-md-12" style=" padding: 0 0 15px 0;">
                        <span style="font-size: 14px;">AKI Alert from ICE</span>
                    </div>
                    <div class="col-md-12" style=" padding: 0 0 15px 0;margin-bottom: 20px;">
                        <div class="col-md-6 padding-zero" style="font-weight:bold;">AKI Status</div>
                        <div class="col-md-6 padding-zero">
                            <span id="aki_value_popup" style="font-weight:bold;">No Status Documented</span>
                        </div>
                        <input type="hidden" id="aki_value">
                    </div>
                </div>

            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_save_aki_assessment">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Confirm</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_confirm_aki_task" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> AKI Assessment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12 col- padding-zero">
                        <div class="col-md-12" style=" padding: 15;">
                            <b>Below Task Has Been Assinged To The Patients</b><br/>
                            <ol style="font-size: 14px; margin-top: 20px; margin-bottom: 20px;" class="li-space" id="aki_assigned_task">


                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Okay</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_confirm_sepsis_task" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Sepsis Assessment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <div class="col-md-12 col- padding-zero">
                        <div class="col-md-12" style=" padding: 15;">
                            <b> Below Task Has Been Assinged To The Patients</b><br/>
                            <ol style="font-size: 14px; margin-top: 20px; margin-bottom: 20px;" class="li-space" id="sepsis_assigned_task">
                                @foreach($success_array['sepsis_task'] as $task)
                                    <li>{{$task['auto_populate_task_name']}} - {{$task['task_user_group']['task_group_name']}}</li>
                                @endforeach

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Okay</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_deteriorating_patient_timeline" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style='max-width:80%'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deteriorating Patient Timeline</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">

                <div class="loader-bg hide-on-first-load" style="display:none;">
                    <span class="screen-center"></span>
                </div>
                <div class="col-md-12 padding-zero" id="dp_task">

                </div>
            </div>

        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_mobility_score" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Mobility Score</h5>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-md-12 padding-zero mobility_show_data" style="text-align: center;">

                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class=" col-md-12 padding-zero" style="position: absolute;"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_ibox_save_mobility_score">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                    <button type="button" class="btn btn-secondary movement_scale_pre_admission_score">

                        <span class="btnLbl bottom-cancel-button">Pre Admission Score</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_pre_mobility_score" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Pre Admission Mobility Score</h5>
            </div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-md-12 padding-zero" style="text-align: center;">
                    <table class="movement_scale_table">

                        <tbody>
                            <tr>
                                <td rowspan="3" class="score_high set_text_vertical_first_col" style="width:200px;"> WALK
                                </td>
                                <td class="score_high" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class">Score Of 8 (Walk 75 Meters)</div>
                                        <div class="col-md-12 padding-zero">
                                            <ul class="ibox_boardround_movement_scale_score_li">
                                                <li>1. Distance can be cumulative within 1 treatment episode. Seated rest breaks are allowed.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="score_high" style="width:60px;">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="8">
                                </td>
                            </tr>
                            <tr>
                                <td class="score_high" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class">Score Of 7 (Walk 7.5 Meters)</div>
                                        <div class="col-md-12 padding-zero">
                                            <ul class="ibox_boardround_movement_scale_score_li">
                                                <li>1. Distance can be cumulative within 1 treatment episode. Seated rest breaks are allowed.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="score_high">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="7">
                                </td>
                            </tr>
                            <tr>
                                <td class="score_high" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class">Score Of 6 (Walk 10 Steps Or More)</div>
                                        <div class="col-md-12 padding-zero">
                                            <ul class="ibox_boardround_movement_scale_score_li">
                                                <li>1. Marching on the spot does not count as walking, this would be scored as a 5.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="score_high">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="6">
                                </td>
                            </tr>
                            <tr>
                                <td class="score_medium set_text_vertical_first_col"> STAND </td>
                                <td class="score_medium" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class">Score Of 5 (Stand 1 Or More Minutes)</div>
                                        <div class="col-md-12 padding-zero">
                                            <ul class="ibox_boardround_movement_scale_score_li">
                                                <li>1. Minute or more can be made up of cumulative performance during 1 treatment episode.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="score_medium">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="5">
                                </td>
                            </tr>

                            <tr>
                                <td class="score_average set_text_vertical_first_col"> CHAIR </td>
                                <td class="score_average" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class">Score Of 4 (Move To Chair / Commode)</div>
                                        <div class="col-md-12 padding-zero">
                                            <ul class="ibox_boardround_movement_scale_score_li">
                                                <li>1. Score of 4 is given if patient is not dependent on hoist or assistance of 3 or more people to transfer to chair or commode.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="score_average">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="4">
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="3" class="score_low set_text_vertical_first_col"> BED </td>
                                <td class="score_low" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class">Score of 3 (Sit at edge of bed)</div>
                                        <div class="col-md-12 padding-zero">
                                            <ul class="ibox_boardround_movement_scale_score_li">
                                                <li>1. Duration does not influence score.</li>
                                                <li>2. Score of 3 if requiring support of 2 people or less.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="score_low">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="3">
                                </td>
                            </tr>
                            <tr>
                                <td class="score_low" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class">Score Of 2 (Bed Activities / Dependent Transfer)</div>
                                        <div class="col-md-12 padding-zero">
                                            <ul class="ibox_boardround_movement_scale_score_li">
                                                <li>1. Dependent transfer from bed to chair using hoist or 3 or more people.</li>
                                                <li>2. Lateral transfer from bed to stretcher / trolley.</li>
                                                <li>3. Activities performed in bed e.g. range of movement exercises.</li>
                                                <li>4. Turning self or rolling in bed actively or passively with staff.</li>
                                                <li>5. Use of tilt table.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                                <td class="score_low">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="2">
                                </td>
                            </tr>
                            <tr>
                                <td class="score_low" colspan="2">
                                    <div class="col-md-12 padding-zero">
                                        <div class="ibox_boardround_movement_scale_score_head_class_bottom_none">Score Of 1 (Lay In Bed)</div>
                                    </div>
                                </td>
                                <td class="score_low">
                                    <input type="radio" class="ibox_boardround_movement_scale_score" name="movement_scale_score_pre_admission" value="1">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class=" col-md-12 padding-zero" style="position: absolute;"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_ibox_save_pre_mobility_score">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button pre-admission-cancel">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_summary_boardround_doctors_at_night" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Doctor At Night</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-md-12 padding-zero" style="text-align: center;">


                    <div class="col-md-12 padding-zero ">

                        <div class="col-md-12 padding-zero show_doctors_at_night_task"></div>



                    </div>


                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_patient_ward_summary_boardround_update_doctor_at_night">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl">Save</span>
                    </button>
                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patient_ward_boardround_show_history" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">History </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body ">
                <div class="col-md-12 padding-zero" style="text-align: center;">


                    <div class="col-md-12 padding-zero ">

                        <div class="col-md-12 padding-zero show_boardround_history"></div>



                    </div>


                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_patients_start_boardround" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title board_round_text">Start Board Round</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <div class="col-md-12 inputWrap padding-zero ">
                    <input type="hidden" value="" id="patient_id_board_round_all_selected_consultant_rand">
                    <input type="hidden" value="" id="consultant_board_round_all_selected_consultant_rand">
                    <input type="hidden" value="" id="board_round_all_selected_consultant_rand_type">


                    <label class="radio-button">
                        <input type="radio" name="boardround_config" value="bed_order"/>
                        <span class="radio-button-inner">Board Round By Bed Order</span>
                    </label>

                    @if(count($success_array['consultnat_list']) > 0)
                    <div class="col-md-12 padding-zero" style=" text-align: center; font-size: 19px; margin-top: 15px;">
                        Board Round With The Following Consultant
                    </div>
                    @foreach($success_array['consultnat_list'] as $consultant_code => $consultant_name)
                        <label class="radio-button">
                            <input type="radio" name="boardround_config" value="{{ $consultant_code }}"/>
                            <span class="radio-button-inner">{{ $consultant_name }}</span>
                        </label>
                    @endforeach
                    @endif
                    @if(isset($success_array['ward_summary']['Number_of_Stratderd_Patients']) && $success_array['ward_summary']['Number_of_Stratderd_Patients'] > 0)
                        <label class="radio-button">
                            <input type="radio" name="boardround_config" value="stranded"/>
                            <span class="radio-button-inner">Stranded Patients</span>
                        </label>
                    @endif

                </div>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button camis_ward_action_boardround board_round_start">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl board_round_button_text">Start</span>
                    </button>

                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade  zoom-in camis_ward_summary_boardround_sub_inner_popup_common_class" id="camis_boardround_attendance" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title board_round_text">Attendance Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-popup-loader-content"></div>
            <div class="modal-body ward_summary_sub_modal_inner_body red_bed_set_min_height_modal">
                <form method="POST" action="http://ibox-app/dashboard/patient-list/session/ward-round" accept-charset="UTF-8" class="boardround-form" id="boardround-form"><input name="_token" type="hidden" value="ZgdfHDd4T0eYNo6LXBe4J1CnCjdt5Kw11MxjOBJB">
                    <div class="row" id="attendance_user_list">

                    </div>

                </form>
            </div>
            <div class="modal-footer ">
                <div class="ibox_modal_footer_button_class col-md-12">
                    <div class="ibox_modal_footer_button_class_top_to_hide_button col-md-12 padding-zero"></div>
                    <button type="button" class="all_modal_save_button_for_js btn btn-secondary bottom-save-button save_attendance_ward">
                        <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset/Ibox/Images/icons/loading-save.svg') }}" alt="" />
                        <svg width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill normal-save-svg-to-show-on-save" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <span class="btnLbl ">Save</span>
                    </button>

                    <button type="button" class="btn btn-secondary bottom-cancel-button " data-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg>
                        <span class="btnLbl bottom-cancel-button">Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
