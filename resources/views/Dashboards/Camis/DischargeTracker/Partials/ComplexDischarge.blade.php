<input type="hidden" id="medfit_data" value="1">
<input type="hidden" id="today_discharges_value" value="{{ $success_array['discharges_today'] }}">

<div class="col-lg-12  ">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <!-- Nav tabs -->

            <div class="sticky-toprow" id="stickyToprow">
              <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2">
                  <a class="tab-custom-btn click_dtoc_search_reset active">
                    <div class="tab-active">CDT Patients</div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="tab-custom-btn click_discharges_from_cdt" >
                    <div class="tab-active">Discharge From CDT</div>
                  </a>
                </li>
                <li class="mb-2">
                    <a class="tab-custom-btn click_discharges_from_ed_referral" >
                      <div class="tab-active">ED Referral</div>
                    </a>
                </li>
              </ul>
            </div>

            <!-- Tab panes -->

            <div class="tab-content" id="tabcontent">
                <div id="cdtPatients" class="tab-pane active">
                        <div class="dashboard-contents">


                            <div class="medfit-row" id="medfitRow">
                                <div class="row gx-2 ">

                                    <div class="col-xxl-6 mb-2">
                                        <div class="row row-cols-md-5 row-cols-1 gx-2">
                                            <div class="col mb-2 mb-md-0">
                                                <select class="3col active"  multiple="multiple" aria-label="Default select example" id="ward_id">
                                                    <optgroup label="Medical Wards">
                                                        @foreach ($medical_wards as $ward)
                                                        <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif >
                                                            {{ $ward['ward_name'] }}</option>
                                                        @endforeach

                                                    </optgroup>
                                                    <optgroup label="Surgical Wards">
                                                        @foreach ($surgical_wards as $ward)
                                                        <option value="{{ $ward['id'] }}"@if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                                            {{ $ward['ward_name'] }}</option>
                                                        @endforeach

                                                    </optgroup>
                                                    <optgroup label="Others Wards">
                                                        @foreach ($other_wards as $ward)
                                                        <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                                            {{ $ward['ward_name'] }}</option>
                                                        @endforeach

                                                    </optgroup>

                                                </select>
                                            </div>
                                            <div class="col mb-2 mb-md-0">
                                                <select class="3col active" aria-label="Default select example" id="medfit_value"  multiple="multiple">
                                                    <option value="1" @if(request()->filled('medfit') && in_array(1, request()->medfit)) selected @endif>Med Fit : Yes</option>
                                                    <option value="0" @if(request()->filled('medfit') && in_array(0, request()->medfit)) selected @endif>Med Fit : No</option>
                                                </select>
                                            </div>
                                            <div class="col mb-2 mb-md-0">
                                                <select class="3col active" aria-label="Default select example" id="pathway_id"  multiple="multiple">
                                                    <option value="blank" @if(request()->filled('pathway_id') && in_array('blank', request()->pathway_id)) selected @endif>Blank</option>
                                                    @foreach ($success_array['dtoc_path_way_drop'] as $item)
                                                        <option value="{{ $item->id }}" @if(request()->filled('pathway_id') && in_array($item->id, request()->pathway_id)) selected @endif>{{ $item->dtoc_pathway_text }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col mb-2 mb-md-0">
                                                <select id="authority_id" class="3col active" aria-label="Default select example" multiple="multiple">
                                                    <option value="blank" @if(request()->filled('authority_id') && in_array('blank', request()->authority_id)) selected @endif>Blank</option>
                                                    @foreach($success_array['dtoc_current_service_value_drop'] as $key => $authority)
                                                    <option @if(request()->filled('authority_id') && in_array($key, request()->authority_id)) selected @endif value="{{ $key }}">{{ $authority }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col mb-0">
                                                <select id="service_id" class="3col active" aria-label="Default select example"  multiple="multiple">
                                                    <option value="blank" @if(request()->filled('service_id') && in_array('blank', request()->service_id)) selected @endif>Blank</option>
                                                    @foreach($success_array['dtoc_service_value_drop'] as $key => $service)
                                                        <option @if(request()->filled('service_id') && in_array($key, request()->service_id)) selected @endif value="{{ $key }}">{{ $service }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xxl-6">
                                        <div class="row gx-2">
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <div class="card-date">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="Select Confirmed Discharge Date">
                                                            <div class="cyan-circle text-center me-2">
                                                            <i class="bi bi-calendar3 "></i>
                                                            </div>
                                                            <div class="date-box w-90">
                                                                <input type="hidden" value="{{ request()->date }}" class="start_date_day_summary_val" id="start_date_day_summary_val">
                                                            <input type="text" name="datepicker"  id="start_date_day_summary" placeholder="{{ request()->filled('date') ? PredefinedYearFormat(request()->date) : 'Select Date' }}"
                                                                class="hasDatepicker" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 mb-2">
                                                <div class="d-flex justify-content-between ">
                                                    <input class="form-control" type="text" placeholder="" value="{{ $success_array['selected_search_text'] }}" aria-label="default input example" id="search_text">
                                                    <button type="button" class="btn btn-dark ms-2" id="submit_search_text"><i class="bi bi-search "></i></button>

                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 mb-2">
                                                <button type="button" class="btn btn-export w-100 click_dtoc_search_reset"><img
                                                        src="{{ asset('asset_v2/Template/icons/reset.svg') }}" alt="" width="16" class="me-2">Reset
                                                    Search</button>
                                            </div>
                                            <div class="col-lg-3 col-md-5 mb-2">
                                                <select name="basic" id="sort_by">
                                                    <option value="">Sort By</option>
                                                <option value="1" @if(request()->sort_by == 1) selected @endif >Surname(Asc)</option>
                                                <option value="2" @if(request()->sort_by == 2) selected @endif >Surname (Desc)</option>
                                                <option value="3" @if(request()->sort_by == 3) selected @endif >Discharge Date (Asc)</option>
                                                <option value="4" @if(request()->sort_by == 4) selected @endif >Discharge Date(Desc)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-6 mb-2 d-lg-none {{ PermissionDeniedDiv('discharge_tracker_complex_discharge_export_view') }}">
                                                <button type="button" class="btn btn-export w-100 {{ DisabledButtonOnRolePermission('discharge_tracker_complex_discharge_export_view') }} export_discharge_tracker">
                                                    <img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" class="me-2" width="15" />Export
                                                </button>
                                            </div>
                                            <div class="col-md-2 col-6 mb-2 d-lg-none {{ PermissionDeniedDiv('discharge_tracker_complex_discharge_print') }}">
                                                <button type="button" class="btn btn-export w-100 {{ DisabledButtonOnRolePermission('discharge_tracker_complex_discharge_print') }} print_complex_discharge">
                                                    <img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="me-2" width="16" />Print
                                                </button>
                                            </div>








                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="discharge-tracker-contents">
                                @if(count($success_array['all_patients']) > 0)
                                    <div class="bg-sticky"></div>
                                    <div class="patients-details">
                                        @forelse($success_array['all_patients'] as $wards => $patients)
                                            @if(count($patients) > 0)
                                                <div class="wards-patients-details">
                                                    <div class="sticky-header">
                                                        <div class="name-header">
                                                            <span>{{ $wards }}</span>
                                                        </div>
                                                    </div>


                                                    <div class="custom-card">
                                                        <table class="breachReasonTable responsiveTable table-custom">

                                                            @foreach($patients as $patient)

                                                                @php
                                                                    $patient_cdt_status = PatientCDTStatus($patient['board_round_cdt']['cdt_action'], $patient['board_round_cdt']['cdt_action_time'], $patient['board_round_cdt']['is_equipment'], $patient['board_round_cdt']['is_equipment_time'], $patient['board_round_cdt']['discharge_for_today'], $patient['board_round_cdt']['discharge_for_today_time']);

                                                                @endphp


                                                                <tbody class="table-patient-tbody update_patient_date_{{ $patient['camis_patient_id'] }} {{ $patient_cdt_status['type'] }}" id="patient_list_with_{{ $patient['camis_patient_id'] }}">
                                                                {!! $patient_cdt_status['html'] !!}
                                                                <tr class="table-patient-row-1 @if(CheckSpecificPermission('discharge_tracker_discharge_info_popup_view')) discharge_patient_modal cursor_pointer @else permission_denied_alert @endif" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">

                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Bay & Bed</div>
                                                                        <span class="count_patient">{{ $patient['ibox_actual_bed_full_name'] }}</span>
                                                                    </td>

                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Name</div>
                                                                        {!! CamisPatientGender($patient['camis_patient_sex'], $patient['camis_patient_name']) !!}
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Hospital Number</div>
                                                                        <span>{{ $patient['camis_patient_pas_number'] }}</span>
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        @if(isset($patient['board_round_cdt']))
                                                                        @if(isset($patient['board_round_cdt']['cdt_status']) &&  $patient['board_round_cdt']['cdt_status'] == 1)
                                                                                <div class="tdBefore " id="cdt_text_{{ $patient['camis_patient_id'] }}">Referral Date</div>
                                                                                <span class="cdt-reviewed" id="cdt_username_date_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_cdt']['accepted_by_username']) && isset($patient['board_round_cdt']['accepted_date'])) {{ $patient['board_round_cdt']['accepted_by_username'] }} - {{ PredefinedDateFormatFor24Hour($patient['board_round_cdt']['accepted_date']) }} @else -- @endif </span>

                                                                            @else
                                                                                <span>--</span>
                                                                            @endif
                                                                        @else
                                                                            <div class="tdBefore" id="cdt_text">Referral Date</div>
                                                                            <span>--</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Services</div>
                                                                        <span id="dtoc_services_text_{{ $patient['camis_patient_id'] }}" > @if(isset($patient['board_round_pathway_requirement']) && isset($patient['board_round_pathway_requirement']['service_by_pathway_text']) ) {{ $patient['board_round_pathway_requirement']['service_by_pathway_text'] }} @else -- @endif </span>
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Current Status</div>
                                                                        <span id="dtoc_current_status_text_{{ $patient['camis_patient_id'] }}" > @if(isset($patient['board_round_pathway_requirement']) && isset($patient['board_round_pathway_requirement']['dtoc_status']) ) {{ $patient['board_round_pathway_requirement']['dtoc_status']['dtoc_current_status_text'] }} @else -- @endif </span>
                                                                    </td>


                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">LOS</div>
                                                                        <span>{{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) }} {{ NumberOfDaysBetweenTwoDates($patient['camis_patient_admission_date_time'], date('Y-m-d')) > 1 ? 'Days' : 'Day' }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Med Fit</div>
                                                                        <span id="{{ $patient['camis_patient_id'] }}_medfit">
                                                                            @if(isset($patient['board_round_medically_fit_data']['patient_medically_fit_status']) && $patient['board_round_medically_fit_data']['patient_medically_fit_status'] == 1)
                                                                                Yes {{ isset($patient['board_round_medically_fit_data']['updated_at']) ? '- '.PredefinedDateFormatMedFitDate($patient['board_round_medically_fit_data']['updated_at']).'' : '' }}
                                                                            @else
                                                                                No
                                                                            @endif
                                                                        </span>
                                                                    </td>

                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Confirmed Discharge Date</div>
                                                                        <span id="planned_discharged_date_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_pathway_requirement']) && isset($patient['board_round_pathway_requirement']['planned_discharge_date'])){{ PredefinedDateFormatForPD($patient['board_round_pathway_requirement']['planned_discharge_date']) }} @else -- @endif</span>
                                                                    </td>


                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Pathway</div>
                                                                        <span id="dtoc_pathway_text_{{ $patient['camis_patient_id'] }}"

                                                                        @if(isset($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']))
                                                                            @if(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 0')
                                                                                class="total_p0"
                                                                            @elseif(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 1')
                                                                                class="total_p1"
                                                                            @elseif(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 2')
                                                                                class="total_p2"
                                                                            @elseif(strtolower($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text']) == 'pathway 3')
                                                                                class="total_p3"
                                                                            @endif
                                                                        @endif
                                                                        >@if(isset($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text'])) {{ \Illuminate\Support\Str::limit($patient['board_round_pathway_requirement']['dtoc_pathway']['dtoc_pathway_text'], 200, '...') }} @else -- @endif</span>
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Authority</div>

                                                                        <span id="dtoc_authority_text_{{ $patient['camis_patient_id'] }}" >  @if(isset($patient['board_round_pathway_requirement']) && !empty($patient['board_round_pathway_requirement']['dtoc_service_text']) )  @if(strtolower($patient['board_round_pathway_requirement']['dtoc_service_text']) == 'ooa') OOA: {{ $patient['board_round_pathway_requirement']['others_authority_text'] }} @else {{ $patient['board_round_pathway_requirement']['dtoc_service_text'] }} @endif @else -- @endif </span>
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">Reason Code</div>
                                                                        <span id="dtoc_reason_text_{{ $patient['camis_patient_id'] }}">@if(isset($patient['board_round_pathway_requirement']['dtoc_authority']['dtoc_authority_text'])) {{ \Illuminate\Support\Str::limit($patient['board_round_pathway_requirement']['dtoc_authority']['dtoc_authority_text'], 200, '...') }} @else -- @endif </span>
                                                                    </td>
                                                                    <td class="pivoted">
                                                                        <div class="tdBefore">&nbsp;</div>
                                                                        <div class="cell-data">

                                                                            <div class="data-group">
                                                                                @if(isset($patient['board_round_tto']['discharge_planning_tto_status']) && in_array($patient['board_round_tto']['discharge_planning_tto_status'], [1, 2]))
                                                                                    <div @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) class="bg-tto-yes" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) class="bg-tto-no" @else class="bg-tto-na" @endif data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom" @if($patient['board_round_tto']['discharge_planning_tto_status'] == 1) title="TTO Required - Completed" @elseif($patient['board_round_tto']['discharge_planning_tto_status'] == 2) title="TTO Required - Not Completed" @else  title="TTO Status Not Applicable" @endif>TTO</div>
                                                                                @endif
                                                                                @if(isset($patient['board_round_edn']['discharge_planning_edn_status']) && in_array($patient['board_round_edn']['discharge_planning_edn_status'], [1, 2]))
                                                                                    <div  @if($patient['board_round_edn']['discharge_planning_edn_status'] == 1) class="bg-eds-yes" @elseif($patient['board_round_edn']['discharge_planning_edn_status'] == 2) class="bg-eds-no" @else class="bg-edn-na" @endif data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom" @if($patient['board_round_edn']['discharge_planning_edn_status'] == 1) title="EDS Required - Completed" @elseif($patient['board_round_edn']['discharge_planning_edn_status'] == 2) title="EDS Required - Not Completed" @else  title="EDN Status Not Applicable" @endif>EDS</div>
                                                                                @endif
                                                                                <div>
                                                                                    @if($ambo = CheckSpecificBedFlagsExitsOnArrayWithData($patient['patient_wise_flags'], 'ibox_patient_flag_ambo', 'flag_ambo_ref'))

                                                                                    <span class="bg-ambo" data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom" title="{{ strtoupper($ambo) }}"> AMBO </span>
                                                                                    <span>REF:{{ strtoupper($ambo) }}</span>
                                                                                    @endif

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </td>



                                                                </tr>
                                                                <tr class="table-patient-row-2">
                                                                    <td class="pivoted spl-cell" rowspan="3" >
                                                                        <div class="header-comment">
                                                                            <p class="flex-grow-1">Comments</p>
                                                                            <button class="btn btn-assign-task view_cdt_comment" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">
                                                                                CDT Comment
                                                                            </button>
                                                                            <button  class="btn btn-assign-task add_comment {{ DisabledButtonOnRolePermission('discharge_tracker_discharge_info_comment_add') }}" data-comment-id="" data-camis-patient-id="{{ $patient['camis_patient_id'] }}">Add Comment</button>
                                                                            <button data-bs-toggle="offcanvas" data-bs-target="#viewAllComments"
                                                                                    aria-controls="offcanvasRight" onclick="ViewAllComment('{{ $patient['camis_patient_id'] }}');"
                                                                                    class="btn btn-assign-task">View All
                                                                            </button>
                                                                            <button id="remove_from_list" onclick="RemovePatients('{{ $patient['camis_patient_id'] }}','{{ 4 }}');" class="btn btn-remove">
                                                                                Remove From List
                                                                            </button>
                                                                        </div>
                                                                        @if(isset($patient['board_round_dtoc_comments']) && count($patient['board_round_dtoc_comments']) > 0)
                                                                            <div class="card-col-grp" id="comment_list_{{ $patient['camis_patient_id'] }}">
                                                                                {!! app('App\Http\Controllers\Iboards\Camis\DischargeTrackerController')->DtocWardCommentList($patient['camis_patient_id']) !!}

                                                                            </div>
                                                                        @else
                                                                            <div class="card-col-grp"  id="comment_list_{{ $patient['camis_patient_id'] }}" style="overflow-y: hidden;">
                                                                                <div class="custom_not_founds" style="position: relative;top: 40%;text-align: center;">{{ NotFoundMessage() }}</div>
                                                                            </div>

                                                                        @endif

                                                                    </td>

                                                                </tr>

                                                                </tbody>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="patients-details">
                                                <div class="custom_not_found">{{ NotFoundMessage() }}</div>
                                            </div>
                                        @endforelse

                                    </div>
                                @else
                                    <div class="patients-details">
                                        <div class="custom_not_found">{{ NotFoundMessage() }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1400) {
      if (
        document.getElementById("marquee-content") &&
        document.getElementsByClassName(".bg-sticky") &&
        document.getElementsByClassName(".sticky-header")
      ) {
        document.getElementById("stickyToprow").style.top = "85px";
        document.getElementById("medfitRow").style.top = "145px";
        if (document.querySelector(".bg-sticky")) {
          var bgSticky = document.querySelector(".bg-sticky");
          bgSticky.style.top = "206px";
          var stickyHeader = document.querySelectorAll(".sticky-header");
          stickyHeader.forEach(function (header) {
            header.style.top = "206px";
          });
        }
      } else {
        document.getElementById("stickyToprow").style.top = "60px";
        document.getElementById("medfitRow").style.top = "120px";
        if (document.querySelector(".bg-sticky")) {
          var bgSticky = document.querySelector(".bg-sticky");
          bgSticky.style.top = "180px";
          var stickyHeader = document.querySelectorAll(".sticky-header");
          stickyHeader.forEach(function (header) {
            header.style.top = "180px";
          });
        }
      }
      if (document.getElementById("medfitRow")) {
        if (document.querySelector(".custom_not_found")) {
          var noRecords = document.querySelector(".custom_not_found");
          noRecords.style.marginTop = "53px";
        }
      }
    } else if (windowWidth > 1026 && windowWidth < 1399) {
      if (document.getElementById("marquee-content")) {
        document.getElementById("stickyToprow").style.top = "85px";
        document.getElementById("medfitRow").style.top = "146px";
        if (document.querySelector(".bg-sticky")) {
          var bgSticky = document.querySelector(".bg-sticky");
          bgSticky.style.top = "258px";
          var stickyHeader = document.querySelectorAll(".sticky-header");
          stickyHeader.forEach(function (header) {
            header.style.top = "258px";
          });
        }
      }
      if (document.getElementById("medfitRow")) {
        if (document.querySelector(".custom_not_found")) {
          var noRecords = document.querySelector(".custom_not_found");
          noRecords.style.marginTop = "103px";
        }
      }
    }
  </script>
<script>

$(document).ready(function () {
    var windowWidth = window.innerWidth;

    $("tbody.table-patient-tbody").each(function () {
        var $tbody = $(this);

        if ($tbody.hasClass("border-cdt-actions") ||
            $tbody.hasClass("border-equipment") ||
            $tbody.hasClass("border-discharge-today")) {

            if (windowWidth > 1400) {
                $tbody.find(".table-patient-row-1").css("width", "58%");
                $tbody.find(".table-patient-row-2").css("width", "40%");
            }
        }
    });
});

</script>
<script>
    $(document).ready(function () {
        function adjustPatientTableWidth() {
            var windowWidth = $(window).width();

            $("tbody.table-patient-tbody").each(function () {
                var $tbody = $(this);

                if (
                    $tbody.hasClass("border-cdt-actions") ||
                    $tbody.hasClass("border-equipment") ||
                    $tbody.hasClass("border-discharge-today")
                ) {
                    if (windowWidth > 1400) {
                        $tbody.find(".table-patient-row-1").css("width", "58%");
                        $tbody.find(".table-patient-row-2").css("width", "40%");
                    } else {
                        $tbody.find(".table-patient-row-1").css("width", "");
                        $tbody.find(".table-patient-row-2").css("width", "");
                    }
                }
            });
        }

        adjustPatientTableWidth();

        $(window).on('resize', function () {
            adjustPatientTableWidth();
        });
    });
</script>

<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
     $(function() {

        var start = '{{ request()->date }}' ? moment('{{ request()->date }}') : null;



        function DataPageLoad(ward_id, medfit, search_text, pathway_id,service_id,authority_id ){
            @if(CheckSpecificPermission('discharge_tracker_complex_discharge_view'))
                var token               = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                var sort_by = $('#sort_by').val();
                var date = $('#start_date_day_summary_val').val();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.complex.data.load') }}",
                        type: 'POST',
                        data: { "_token": token, "ward_id": ward_id, "medfit": medfit, "search_text": search_text, "pathway_id": pathway_id, "service_id":service_id, "authority_id":authority_id, "sort_by":sort_by,"date":date},
                        success: function (response)
                        {
                            if(response != ""){

                                $('#contentSection_data').html(response);
                                $('.SelectBoxWrap select').selectric('refresh');
                                $('.page-data-loader').hide();
                                MultiSelectJs('ward_id', 'Ward');
                                MultiSelectJs('medfit_value', 'MedFit');
                                MultiSelectJs('pathway_id', 'Pathway');
                                MultiSelectJs('authority_id', 'Authority');
                                MultiSelectJs('service_id', 'Service');
                            }
                        },
                        error: function(status, err){
                            $('.page-data-loader').hide();
                        }
                    });
                },2000)
            @else
                PermissionDeniedAlert();
            @endif
        }

        function cb(start) {
                $('#start_date_day_summary_val').val(start.format('YYYY-MM-DD'));
                $('#start_date_day_summary').val(start.format('ddd MMMM D, YYYY'));


             if(start.format('YYYY-MM-DD') != '{{request()->date}}'){
                var ward_id         = $('#ward_id').val();
                var medfit          = $('#medfit_value').val();
                var search_text     = $('#search_text').val();
                var pathway_id     = $('#pathway_id').val();
                var service_id     = $('#service_id').val();
                var authority_id     = $('#authority_id').val();


                DataPageLoad(ward_id, medfit, search_text, pathway_id,service_id,authority_id );
             }
         }
         $('#start_date_day_summary').daterangepicker({
             singleDatePicker: true,
             showDropdowns: true,
             autoApply: true,
             startDate:  start || moment(),
             locale: {
                 format: 'ddd MMMM D, YYYY'
             }
         }, cb);

         if (!start) {
            $('#start_date_day_summary').val('Select Date');
        }

     });
</script>
