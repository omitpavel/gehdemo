<div class="offcanvas-header card-header fw-bold">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="">
            <h6 class="mb-0" id="offcanvasRightLabel">{{ $success_array['patient']['camis_patient_forename'] }} {{ $success_array['patient']['camis_patient_surname'] }} -  {{ $success_array['patient']['ibox_actual_bed_full_name'] }} ({{ $success_array['patient']['ibox_ward_name'] }})</h6>
        </div>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('patientDetails');"><img src="{{ asset('asset_v2/Template') }}/icons/cancel.svg" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
</div>

<div class="modal-popup-loader-content"></div>

<div class="offcanvas-body ward_summary_sub_modal_inner_body">

    <div class="" style="pointer-events: none;">
        <div class="bg-blue mb-2">
            <div class="row gx-2">
                <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                    <h6 class="fw-normal">NHS Number</h6>
                    <h6>{{ $success_array['patient']['camis_patient_nhs_number'] }}</h6>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                    <h6 class="fw-normal">Hospital Number</h6>
                    <h6>{{ $success_array['patient']['camis_patient_pas_number'] }}</h6>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                    <h6 class="fw-normal">First Name</h6>
                    <h6>{!! CamisPatientGender($success_array['patient']['camis_patient_sex'], $success_array['patient']['camis_patient_name']) !!}</h6>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                    <h6 class="fw-normal">Surname</h6>
                    <h6>{{ $success_array['patient']['camis_patient_surname'] }}</h6>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                    <h6 class="fw-normal">DOB</h6>
                    <h6>{{ PredefinedDateFormatShowOnCalendarWithoutDay($success_array['patient']['camis_patient_date_of_birth']) }}</h6>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                    <h6 class="fw-normal">Med Fit</h6>
                    <h6>{{ @$success_array['patient']['board_round_medically_fit_data']['patient_medically_fit_status'] == 1 ? 'YES' : 'No' }}</h6>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-xl-7 requirements-section">
                <h6 class="">Pathway Requirements</h6>
                <div class="border-bottom mb-2"></div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Pathway</label>
                        <select class="form-select w-100 bg-grey"
                                aria-label="Default select example" id="dtoc_pathway">
                            <option value="">Select Pathway</option>
                            @foreach ($success_array['dtoc_path_way_drop'] as $item)
                                <option value="{{ $item->id }}" @if(isset($success_array['patient']['board_round_pathway_requirement']['dtoc_pathway_id']) &&  $item->id == $success_array['patient']['board_round_pathway_requirement']['dtoc_pathway_id']) selected @endif>{{ $item->dtoc_pathway_text }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Services</label>
                        <select class="form-select w-100 bg-grey"
                                aria-label="Default select example" id="dtoc_service_by_pathway">
                            <option value="">Select Service</option>
                            @if(count($success_array['dtoc_service_value_drop']) > 0)
                                @foreach ($success_array['dtoc_service_value_drop'] as $key => $item_ser)
                                    <option value="{{ $key }}" @if(isset($success_array['patient']['board_round_pathway_requirement']['service_by_pathway_id']) &&  $key == $success_array['patient']['board_round_pathway_requirement']['service_by_pathway_id']) selected @endif>{{ $item_ser }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Reason Code</label>
                        <select class="form-select w-100 bg-grey"
                                aria-label="Default select example" id="dtoc_reason_code">
                            <option value="">Select Reason Code</option>
                            @foreach ($success_array['dtoc_authority_drop'] as $item)
                                <option value="{{ $item->id }}"  @if(isset($success_array['patient']['board_round_pathway_requirement']['dtoc_authority_id']) &&  $item->id == $success_array['patient']['board_round_pathway_requirement']['dtoc_authority_id']) selected @endif  >{{ $item->dtoc_authority_text}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Current Status (Optional)</label>
                        <select class="form-select w-100 bg-grey"
                                aria-label="Default select example"  id="dtoc_current_status">
                            <option value="">Select Current Status</option>
                            @foreach ($success_array['dtoc_current_status_drop'] as $item)
                                <option @if(isset($success_array['patient']['board_round_pathway_requirement']['dtoc_current_status_id']) &&  $item->id == $success_array['patient']['board_round_pathway_requirement']['dtoc_current_status_id']) selected @endif value="{{ $item->id }}" data-service_id="{{ $item->dtoc_current_status_coded }}">{{ $item->dtoc_current_status_text }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Authority </label>
                        <select class="form-select w-100 bg-grey"
                                aria-label="Default select example"  id="dtoc_service">
                            <option value="">Select Authority </option>
                            @if(count($success_array['dtoc_current_service_value_drop']) > 0)
                              @foreach ($success_array['dtoc_current_service_value_drop'] as $key => $item_ser)
                                  <option value="{{ $key }}" @if(isset($success_array['patient']['board_round_pathway_requirement']['service_id']) &&  $key == $success_array['patient']['board_round_pathway_requirement']['service_id']) selected @endif>{{ $item_ser }}
                                  </option>
                              @endforeach
                          @endif
                        </select>

                    </div>


                    <div class="col-md-6 position-relative">
                        <label class="form-label">Confirmed Discharge Date</label>
                        <div class="delete-icon delete_cdt_date">
                          <button class="btn btn-primary-grey mb-2 mb-lg-0 w-100"><img src="{{ asset('asset_v2/Template/icons/delete.svg') }}" class="me-2" alt="" width="14" height="14">
                            Delete
                          </button>
                        </div>
                        <input id="planned_date_show_calendar_div" class="form-control bg-grey" readonly @if(isset($success_array['patient']['board_round_pathway_requirement']) && isset($success_array['patient']['board_round_pathway_requirement']['planned_discharge_date'])) value="{{ PredefinedDateFormatForPlannedDichargedDate($success_array['patient']['board_round_pathway_requirement']['planned_discharge_date'])}}" @endif placeholder="mm/dd/yyyy">
                        <div class="date-icon">

                            <i class="bi bi-calendar"></i>
                        </div>
                        <input type="hidden" name="planned_discharge_date" id="planned_discharge_date" @if(isset($success_array['patient']['board_round_pathway_requirement']) && isset($success_array['patient']['board_round_pathway_requirement']['planned_discharge_date'])) value="{{ date('Y-m-d', strtotime($success_array['patient']['board_round_pathway_requirement']['planned_discharge_date']))}}" @endif />
                    </div>


                    <div class="col-md-6">
                      <div class="pb-2 @if(isset($success_array['patient']['board_round_pathway_requirement']['dtoc_service_text']) && strtolower($success_array['patient']['board_round_pathway_requirement']['dtoc_service_text']) == 'ooa') show_additional_text @else d-none @endif" id="show_other_authority_box">
                        <label class="form-label">Authority Details</label>
                        <input type="text" class="form-control bg-grey selected_authority" id="selected_authority" value="{{ $success_array['patient']['board_round_pathway_requirement']['others_authority_text'] ?? ''}}">
                      </div>

                    </div>



                  <div class="col-md-6">
                      <div class="medfit-section" style="display: contents !important;">
                          <div class="rectangle-block-1">
                              <div class="row gx-2 align-items-center w-100 medfit_div_area">
                                  <div class="col-3  ">
                                      <h6 class="mb-0">Medically Fit</h6>
                                  </div>
                                  <div class="col-9 gx-0 text-end" id="medfitSection">
                                      <button name="" class="btn btn-medfit-no {{ DisabledButtonOnRolePermission('camis_reason_to_reside_update') }} click_popup_open_ibox_board_round_medfit_no @if((isset($success_array['patient']['board_round_medically_fit_data']['patient_medically_fit_status']) && $success_array['patient']['board_round_medically_fit_data']['patient_medically_fit_status'] == 0) || !isset($success_array['patient']['board_round_medically_fit_data']['patient_medically_fit_status'])) active @else @endif">
                                          No</button>
                                      <button class="{{ DisabledButtonOnRolePermission('camis_medfit_yes_update') }} btn btn-medfit-yes click_popup_open_ibox_board_round_medfit_yes @if(isset($success_array['patient']['board_round_medically_fit_data']['patient_medically_fit_status']) && $success_array['patient']['board_round_medically_fit_data']['patient_medically_fit_status'] == 1) active @else  @endif" name=""
                                              data-bs-dismiss="offcanvas" data-bs-target="#camis_patient_ward_summary_boardround_reason_to_reside" aria-label="Close">
                                          Yes
                                      </button>

                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
                  <div class="col-md-12">
                      <div class="switches-wrapper">
                        <div class="row g-2">
                          <div class="col-md-4">
                            <div class="switch-discharge">
                              <label  class="form-label">Discharge For Today</label>
                              <div class="highlight-patient">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="patient_discharge_for_today" @if(isset($success_array['patient']['board_round_cdt']['discharge_for_today']) && $success_array['patient']['board_round_cdt']['discharge_for_today'] == 1) checked @endif>

                                </div>
                                <div class="stamp-update">
                                  <ul>
                                    <li class="patient_discharge_for_today_user">@if(isset($success_array['patient']['board_round_cdt']['discharge_for_today']) && $success_array['patient']['board_round_cdt']['discharge_for_today'] == 1)
                                      {{ $success_array['users'][$success_array['patient']['board_round_cdt']['discharge_for_today_by']] ?? '' }} @endif</li>
                                    <li class="patient_discharge_for_today_datetime">@if(isset($success_array['patient']['board_round_cdt']['discharge_for_today']) && $success_array['patient']['board_round_cdt']['discharge_for_today'] == 1)
                                      {{ PredefinedDateFormatFor24Hour($success_array['patient']['board_round_cdt']['discharge_for_today_time']) }} @endif</li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="switch-equipment">
                              <label  class="form-label">Equipment</label>
                              <div class="highlight-patient">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch"  id="patient_is_equipment" @if(isset($success_array['patient']['board_round_cdt']['is_equipment']) && $success_array['patient']['board_round_cdt']['is_equipment'] == 1) checked @endif>

                                </div>
                                <div class="stamp-update">
                                  <ul>
                                    <li class="patient_is_equipment_user">@if(isset($success_array['patient']['board_round_cdt']['is_equipment']) && $success_array['patient']['board_round_cdt']['is_equipment'] == 1)
                                      {{ $success_array['users'][$success_array['patient']['board_round_cdt']['is_equopment_by']] ?? '' }} @endif</li>
                                    <li class="patient_is_equipment_datetime">@if(isset($success_array['patient']['board_round_cdt']['is_equipment']) && $success_array['patient']['board_round_cdt']['is_equipment'] == 1)
                                      {{ PredefinedDateFormatFor24Hour($success_array['patient']['board_round_cdt']['is_equipment_time']) }} @endif</li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="switch-cdt-actions">
                              <label  class="form-label">CDT Actions</label>
                              <div class="highlight-patient">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch"  id="patient_cdt_action" @if(isset($success_array['patient']['board_round_cdt']['cdt_action']) && $success_array['patient']['board_round_cdt']['cdt_action'] == 1) checked @endif>
                                </div>
                                <div class="stamp-update">
                                  <ul>
                                    <li class="patient_cdt_action_user">@if(isset($success_array['patient']['board_round_cdt']['cdt_action']) && $success_array['patient']['board_round_cdt']['cdt_action'] == 1)
                                      {{ $success_array['users'][$success_array['patient']['board_round_cdt']['cdt_action_by']] ?? '' }} @endif</li>
                                    <li class="patient_cdt_action_datetime">@if(isset($success_array['patient']['board_round_cdt']['cdt_action']) && $success_array['patient']['board_round_cdt']['cdt_action'] == 1)
                                      {{ PredefinedDateFormatFor24Hour($success_array['patient']['board_round_cdt']['cdt_action_time']) }}
                                       @endif</li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="">
                          <label  class="form-label">Discharge Pathway</label>
                          <select class="form-select w-100 " id="discharge_pathway">
                            <option value="" >Select Discharge Pathway</option>
                            @foreach($success_array['discharge_tracker_dropdown'] as $reason)
                                <option value="{{ $reason->discharge_drop_id }}" @if(isset($success_array['patient']['discharge_assigned_data']['dt_drop_id']) &&  $reason->discharge_drop_id == $success_array['patient']['discharge_assigned_data']['dt_drop_id']) selected @endif>{{ $reason->discharge_drop_name }}</option>
                            @endforeach
                        </select>
                        </div>
                  </div>


                </div>
            </div>
            <div class="col-xl-5">
                <div class="comment-discharges">
                    <div class="card-col-grp" id="comment_list_modal_{{ $success_array['patient']['camis_patient_id'] }}">
                        {!! app('App\Http\Controllers\Iboards\Camis\DischargeTrackerController')->DtocWardCommentList($success_array['patient']['camis_patient_id']) !!}

                    </div>
                </div>
                <div class="row gx-2 pt-1 grp-grey-btns">
                    <div class="col-lg-3 col-md-6 {{ PermissionDeniedDiv('discharge_tracker_discharge_info_comment_add') }}">
                        <button  class="btn btn-grey mb-2 mb-lg-0 w-100 add_comment {{ DisabledButtonOnRolePermission('discharge_tracker_discharge_info_comment_add') }}" data-comment-id="" data-camis-patient-id="{{ $success_array['patient']['camis_patient_id'] }}">ENTER COMMENT</button>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button class="btn btn-grey mb-2 mb-lg-0 w-100 comment_history_modal">HISTORY</button>
                    </div>
                    <div class="col-lg-3 col-md-6">
                      <button class="btn btn-grey mb-1 mb-lg-0 w-100 patient_cdt_timeline"  data-patient-id="{{ $success_array['patient']['camis_patient_id'] }}">
                        CDT TIMELINE
                      </button>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button class="btn btn-grey mb-1 mb-lg-0 w-100 medfit_timeline"  data-patient-id="{{ $success_array['patient']['camis_patient_id'] }}">TIMELINE</button>
                    </div>
                </div>

            </div>
        </div>
        <input type="hidden" name="dtoc_patient_id" id="dtoc_patient_id" value="{{ $success_array['patient']['camis_patient_id'] }}">
        <input type="hidden" class="boardround_patient_consultant_full_name_show" id="boardround_patient_consultant_full_name_show" value="{{ $success_array['patient']['camis_consultant_name'] }}">
    </div>

</div>

<div class="offcanvas-footer">


        @if(!request()->has('from_cdt_page'))
            <div class="row">
                <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                    <button class="btn btn-primary-grey" onclick="CloseOffcanvas('patientDetails');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                    </button>
                </div>
            </div>
        @else
        <div class="row ibox_modal_footer_button_class">
            <div class="col-lg-8 offset-lg-2">
                <div class="row g-2">
                    <div class="col-6 ">
                        <button class="btn btn-primary-grey save_dtoc_next_patient all_modal_save_button_for_js bottom-save-button" data-camis-next-patient="current" data-next_patient_go="0"> <img class='loading-save-svg-to-show-on-save' src="{{ asset('asset_v2/Ibox/icons/loading-save.svg') }}" alt="" /> <img src="{{ asset('asset_v2/Template') }}/icons/save.svg" alt="" width="15" height="15" class="btn-icon-modal">SAVE</button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary-grey" onclick="CloseOffcanvas('patientDetails');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
</div>
@if(request()->has('from_cdt_page'))
<script>

    @if(isset($success_array['patient']['board_round_pathway_requirement']) && isset($success_array['patient']['board_round_pathway_requirement']['planned_discharge_date'])) var selectedDate = "{{ PredefinedDateFormatForPlannedDichargedDate($success_array['patient']['board_round_pathway_requirement']['planned_discharge_date'])}}";


        $("#planned_date_show_calendar_div").datepicker({
                showOn: 'focus',
                showButtonPanel: true,
                closeText: 'Clear',
                language: "nl",
                dateFormat: 'D dd MM yy',
                numberOfMonths: 2,
                minDate: 0,
                onClose: function () {
                    var event = arguments.callee.caller.caller.arguments[0];
                    if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                        $(this).val('');
                    }
                }
        });
        $('#planned_date_show_calendar_div').datepicker('setDate', selectedDate);


    @else

        $("#planned_date_show_calendar_div").datepicker({
            showOn: 'focus',
            showButtonPanel: true,
            closeText: 'Clear',
            language: "nl",
            dateFormat: 'D dd MM yy',
            numberOfMonths: 2,
            minDate: 0,
            onClose: function () {
                var event = arguments.callee.caller.caller.arguments[0];
                if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                    $(this).val('');
                }
            }
        });
    @endif





    $('#planned_date_show_calendar_div').datepicker().on('change', function(e) {
        var date = $('#planned_date_show_calendar_div').val();
        $("#planned_discharge_date").val(date);
        EnableSaveButtonForModals();

    });




</script>
@endif
