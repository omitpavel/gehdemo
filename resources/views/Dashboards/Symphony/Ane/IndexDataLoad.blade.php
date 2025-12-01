
<div id="url_of_attendance" data-url="{{ route('GetPatientByIdFromBarChart') }}" class="d-none"></div>
<div class="col-lg-12">
    <div class="row gx-2">
        <div class="col-xxl-5 ane-leftside-content">
            <div class="row gx-2 mb-2">
                <div class="col-lg-6 col-xl-3 col-md-2 col-3 click_open_ane_new_opel"  >
                    <div class="shape-box-grey">
                        <p class="header-conversion">CONVERSION</p>
                        <h4 class="value-conversion">{{ $success_array['top_matrix']['conversion_rate'] }}%  </h4>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-9 col-md-10 col-9">
                    <div class="shape-box-grey align-items-center">
                        <div class="row gx-2 align-items-center ">
                            <div class="col-lg-2 col-md-3 col-3">
                                <div class="ane-breach-count">
                                    <h5 id="number_of_breach">{{ $success_array['top_matrix']['breaches_value'] }}</h5>
                                    <p>BREACHES</p>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6 col-5">
                                <div class="d-flex pt-1 justify-content-center align-items-center">
                                    <div class="progress-bg {{ $success_array['top_matrix']['performance_value_guage_border_colour'] }}">
                                        <div class="bar-progress">
                                            <div class="{{ $success_array['top_matrix']['performance_value_guage_colour'] }}" style="width: {{ round($success_array['top_matrix']['performance_value']) }}%">

                                            </div>
                                            <div class="bars-ash" style="width: {{ round(100 - $success_array['top_matrix']['performance_value']) }}%">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-4">
                                <div class="ane-percentage-count">
                                    <h5 class="text-center" id="overall_performance" style='color:{{ $success_array['top_matrix']['performance_text_colour'] }};'>{{ $success_array['top_matrix']['performance_value'] }}% </h5>
                                    <p>PERFORMANCE</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-2">
                <div class="col-lg-6 col-md-6 mb-2">
                    <div class="blue-tile-top">
                        <h6>SINCE MIDNIGHT</h6>
                    </div>
                    <div class="tile-shape-bottom">
                        <div class="row gx-2">
                            <div class="col-4 border-end">
                                <div class="data-details">
                                    <p class="header-data-details">Arrived</p>
                                    <h6 class="value-data-details">{{ $success_array['top_sub_matrix']['since_midnight']['arrived_value'] }}</h6>
                                </div>
                            </div>
                            <div class="col-4 border-end">
                                <div class="data-details">
                                    <p class="header-data-details">Left</p>
                                    <h6 class="value-data-details">{{ $success_array['top_sub_matrix']['since_midnight']['left_value'] }}</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="data-details">
                                    <p class="header-data-details">Admitted</p>
                                    <h6 class="value-data-details">{{ $success_array['top_sub_matrix']['since_midnight']['admitted_value'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mb-2">
                    <div class="purple-tile-top">
                        <h6>IN LAST HOUR</h6>
                    </div>
                    <div class="tile-shape-bottom">
                        <div class="row gx-2">
                            <div class="col-4 border-end">
                                <div class="data-details">
                                    <p class="header-data-details">Arrived</p>
                                    <h6 class="value-data-details">{{ $success_array['top_sub_matrix']['last_hour']['arrived_value'] }}</h6>
                                </div>
                            </div>
                            <div class="col-4 border-end">
                                <div class="data-details">
                                    <p class="header-data-details">Left</p>
                                    <h6 class="value-data-details">{{ $success_array['top_sub_matrix']['last_hour']['left_value'] }}</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="data-details">
                                    <p class="header-data-details">Admitted</p>
                                    <h6 class="value-data-details">{{ $success_array['top_sub_matrix']['last_hour']['admitted_value'] }}</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            @include('Dashboards.Symphony.Ane.AneMainGraph')


        </div>
        <div class="col-xxl-7 ane-rightside-content">
            <div class="row gx-2 ">
                <div class="col-lg-4 col-md-4 mb-2" id="percentage-section">
                    <div class="admission-section">
                        <div class="shape-box-grey">
                            <div class="admitted-details">
                                <h6 class="header-admitted">Admitted</h6>
                                <h5 class="count-admitted text-green">{{ $success_array['top_matrix']['performance']['admitted_value'] }}%</h5>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="non-admitted-details">
                                <h6 class="header-non-admitted">Non-Admitted</h6>
                                <h5 class="count-non-admitted text-ae-cyan">{{ $success_array['top_matrix']['performance']['nonadmitted_value'] }}%</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 mb-2">
                    <div class="shape-box-grey-table">
                        <table class="table-data-comparison ane_table_top_small_breach">
                            <tbody>
                            <tr>
                                <td class="head-types">
                                    Attendances
                                    <div class="border-bottom-td"></div>
                                </td>
                                <td rowspan="3" class="text-mode"><span>ED</span>
                                </td>
                                <td class="shape-box-column">  {{ $success_array['top_matrix']['category_breach_details']['ED']['arrived'] }}
                                    <div class="border-td-bottom"></div>
                                </td>
                                <td rowspan="3" class="text-mode"><span>UTC</span>
                                </td>
                                <td class="shape-box-column ">{{ $success_array['top_matrix']['category_breach_details']['UTC']['arrived'] }}
                                    <div class="border-td-bottom"></div>
                                </td>
                                <td rowspan="3" class="text-mode"><span>TOTAL</span>
                                </td>
                                <td class="shape-box-column">{{ $success_array['top_matrix']['category_breach_details']['total']['arrived'] }}
                                    <div class="border-td-bottom"></div>
                                </td>

                            </tr>
                            <tr>
                                <td class="head-type">
                                    Breaches
                                    <div class="border-bottom-td"></div>
                                </td>
                                <td class="shape-box-column-1">{{ $success_array['top_matrix']['category_breach_details']['ED']['breach'] }}
                                    <div class="border-td-bottom"></div>
                                </td>
                                <td class="shape-box-column-1">{{ $success_array['top_matrix']['category_breach_details']['UTC']['breach'] }}
                                    <div class="border-td-bottom"></div>
                                </td>
                                <td class="shape-box-column-1">{{ $success_array['top_matrix']['category_breach_details']['total']['breach'] }}
                                    <div class="border-td-bottom"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Performance</td>
                                <td class="shape-box-column-2" style="color: {{ $success_array['top_matrix']['category_breach_details']['ED']['performance_text_colour'] }}">{{ $success_array['top_matrix']['category_breach_details']['ED']['performance'] }}%</td>
                                <td class="shape-box-column-2" style="color: {{ $success_array['top_matrix']['category_breach_details']['UTC']['performance_text_colour'] }}">{{ $success_array['top_matrix']['category_breach_details']['UTC']['performance'] }}%</td>
                                <td class="shape-box-column-2" style="color: {{ $success_array['top_matrix']['category_breach_details']['total']['performance_text_colour'] }}">{{ $success_array['top_matrix']['category_breach_details']['total']['performance'] }}%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row gx-2">
                <div class="col-lg-7 col-md-12 row-padding order-0 ">
                    <div class="row row-cols-5 gx-2 align-items-center height-tile">

                        <div class="col">
                            <div class="shape-square ">
                                <div>
                                    <p class="fs-12">{{ $success_array['bar_graph']['colour_band_graph']['green_time'] }}</p>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 ">{{ $success_array['bar_graph']['colour_band_graph']['green_value'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="shape-square-brown ">
                                <div>
                                    <p class="fs-12">{{ $success_array['bar_graph']['colour_band_graph']['yellow_time'] }}</p>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 ">{{ $success_array['bar_graph']['colour_band_graph']['yellow_value'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="shape-square-orange ">
                                <div>
                                    <p class="fs-12">{{ $success_array['bar_graph']['colour_band_graph']['orange_time'] }}</p>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 ">{{ $success_array['bar_graph']['colour_band_graph']['orange_value'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="shape-square-red ">
                                <div>
                                    <p class="fs-12">{{ $success_array['bar_graph']['colour_band_graph']['red_time'] }}</p>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 ">{{ $success_array['bar_graph']['colour_band_graph']['red_value'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="shape-square-black ">
                                <div>
                                    <p class="fs-12 "> {{ $success_array['bar_graph']['colour_band_graph']['purple_time'] }} </p>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 ">{{ $success_array['bar_graph']['colour_band_graph']['purple_value'] }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="col-lg-7 order-1 order-lg-2" >
                    <div class="ane-graph-section" id="ane_graph_height">

                        <div id="BarGraphWrap" class="graphWrap" ></div>

                    </div>
                </div>

                <div class="col-lg-5 order-2 order-lg-1 dta-header-section mb-2">
                    <div class="dta-tab">
                        <ul class="nav nav-tabs" role="tabpanel">
                            <li class="nav-item">
                                <a class="nav-link active" href="#dta" data-bs-toggle="tab">
                                    <div class="dta-tile-top">
                                        <h6>DTA</h6>
                                        <h6>
                                            @if (count($success_array['content']['dta_list']) > 0)
                                                {{ count($success_array['content']['dta_list']) }}
                                            @endif
                                        </h6>

                                    </div>
                                    <div class="dta-tile-bottom">
                                        <div class="">
                                            <h6 class="dta-time">@if(isset($success_array['top_sub_matrix']['longest_wait_time']['dta_wait'])) {{ $success_array['top_sub_matrix']['longest_wait_time']['dta_wait'] }} @else &nbsp; @endif</h6>
                                            <div class="fs-11">
                                                <p class="mb-0">Longest Wait</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#assessment" data-bs-toggle="tab">
                                    <div class="dta-tile-top">
                                        <h6>Triage Wait</h6>
                                        <h6>
                                            @if (count($success_array['content']['triage_waiting_list']) > 0)
                                                {{ count($success_array['content']['triage_waiting_list']) }}
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="dta-tile-bottom ">
                                        <div
                                            class="d-flex align-items-center justify-content-between ">
                                            <h6 class="dta-time">@if(isset($success_array['top_sub_matrix']['longest_wait_time']['triage_wait'])) {{ $success_array['top_sub_matrix']['longest_wait_time']['triage_wait'] }} @else &nbsp; @endif</h6>
                                            <i class="bi bi-circle-fill text-dta-grey fs-10"></i>
                                        </div>
                                        <div class="fs-11">
                                            <p class="mb-0">Longest Wait</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#speciality" data-bs-toggle="tab">
                                    <div class="dta-tile-top">
                                        <h6>Dr Seen Wait</h6>
                                        <h6>
                                            @if (count($success_array['content']['patient_wait_to_see_consultant_list']) > 0)
                                                {{ count($success_array['content']['patient_wait_to_see_consultant_list']) }}
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="dta-tile-bottom">
                                        <div
                                            class="d-flex align-items-center justify-content-between ">
                                            <h6 class="dta-time">@if(isset($success_array['top_sub_matrix']['longest_wait_time']['consultant_wait'])) {{ $success_array['top_sub_matrix']['longest_wait_time']['consultant_wait'] }} @else &nbsp; @endif</h6>
                                            <i class="bi bi-circle-fill text-dta-blue  fs-10"></i>
                                        </div>
                                        <div class="fs-11">
                                            <p class="mb-0">Longest Wait</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 order-3 ">
                    <div class="dta-content-section">
                        <div class="tab-content custom-common-content">
                            <div id="dta" class="tab-pane  active">
                                <div class="card-table">
                                    <div class="head-count border">
                                        <h6 class="mb-0">DTA</h6>
                                        <h6 class="mb-0">
                                            @if (count($success_array['content']['dta_list']) > 0)
                                                {{ count($success_array['content']['dta_list']) }} Patient
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="ane-content" >
                                        @if (isset($success_array['content']['dta_list']) && count($success_array['content']['dta_list']) > 0)
                                            @foreach ($success_array['content']['dta_list'] as $row)
                                                <div class="dta-border-bottom ">
                                                    <div class="dta-name-bg rounded-0">
                                                        <div class="row align-items-center ">
                                                            <div class="col-lg-10 col-md-10 col-10 ps-3">
                                                                <p class="mb-0">{{ $row['symphony_patient_name'] }}</p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-2 text-end">

                                                                @if (strtolower($row['symphony_patient_sex']) == 'female')
                                                                    <img src="{{ asset('asset_v2/Template') }}/icons/female.svg" alt="">
                                                                @elseif (strtolower($row['symphony_patient_sex']) == 'male')
                                                                    <img src="{{ asset('asset_v2/Template') }}/icons/male.svg" alt="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-white">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-6 col-md-6 col-6 border-end">
                                                                @php
                                                                    $time = intval(explode(" ", $row['wait_time_hour_minutes'])[0]);
                                                                @endphp
                                                                <div class="p-2">
                                                                    <p class="mb-0 "> <span  @if(($time >0) && ($time <= 8)) style="color: #00b060;" @elseif(($time >8) && ($time <= 10)) style="color: #FFBF00;"  @elseif(($time >10) && ($time <= 12)) style="color: #ff0000;"  @elseif(($time >12) ) style="color:#000000;" @endif >  {{ $row['wait_time_hour_minutes'] }}</span>  <span>({{ $row['symphony_specialty'] }})</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-6">
                                                                <div class="p-2">
                                                                    <p class="mb-0 ">{{ $row['symphony_dta_ward'] }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-12 col-md-12 col-12 pe-0">
                                                            <div class="dta-bg">

                                                                <div class="dta-bg-grey ">
                                                                    <div>
                                                                        @if ($row['ane_dta_user_comments'] == '')
                                                                            <p class="ane_dta_comment_show_section_text_description_{{ $row['symphony_attendance_id'] }} ps-2">Add Comment</p>
                                                                        @else
                                                                            <p class="ane_dta_comment_show_section_text_description_{{ $row['symphony_attendance_id'] }} ps-2">{{ substr($row['ane_dta_user_comments'], 0, 20) . '...' }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="dta-bg-brown w-25">
                                                                    <div class="text-center   ">
                                                                        @if ($row['ane_dta_user_comments'] == '')
                                                                            <a {{ CheckSpecificPermission('dta_comment_add') ? 'sas':'ass' }}  @if(CheckSpecificPermission('dta_comment_add'))  id="add_button_{{ $row['symphony_attendance_id'] }}" class="text-black fs-14 mb-0 btn ane_dta_comments_modal comment_btton_{{ $row['symphony_attendance_id'] }}" data-ane-dta-attendance-id="{{ $row['symphony_attendance_id'] }}" @else  class="text-black fs-14 mb-0 btn" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>Add</a>
                                                                        @else
                                                                            <a  @if(CheckSpecificPermission('dta_comment_add'))  id="edit_button_{{ $row['symphony_attendance_id'] }}" class="text-black fs-14 mb-0 btn ane_dta_comments_modal comment_btton_{{ $row['symphony_attendance_id'] }}" data-ane-dta-attendance-id="{{ $row['symphony_attendance_id'] }}" @else  class="text-black fs-14 mb-0 btn" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>Edit</a>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="dta-border-bottom ">
                                                <div class="dta-name-bg rounded-0">
                                                    <div class="row align-items-center ">
                                                        <div class="col-lg-12 col-md-12 col-12 ps-3 text-center">
                                                            <p class="mb-0">{{ NotFoundMessage() }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div id="assessment" class="tab-pane  fade">
                                <div class="card-table">
                                    <div class="head-count border">
                                        <h6 class="mb-0 text-uppercase">Triage Wait</h6>
                                        <h6 class="mb-0">
                                            @if (count($success_array['content']['triage_waiting_list']) > 0)
                                                {{ count($success_array['content']['triage_waiting_list']) }} Patients
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="ane-content">
                                        @if (isset($success_array['content']['triage_waiting_list']) && count($success_array['content']['triage_waiting_list']) > 0)
                                            @foreach ($success_array['content']['triage_waiting_list'] as $row)
                                                <div class="dta-border-bottom ">
                                                    <div class="dta-name-bg rounded-0">
                                                        <div class="row align-items-center ">
                                                            <div class="col-lg-10 col-md-10 col-10 ps-3">
                                                                <p class="mb-0">{{ $row['symphony_patient_name'] }}</p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-2 text-end">
                                                                @if (strtolower($row['symphony_patient_sex']) == 'female')
                                                                    <img src="{{ asset('asset_v2/Template') }}/icons/female.svg" alt="">
                                                                @else
                                                                    <img src="{{ asset('asset_v2/Template') }}/icons/male.svg" alt="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-white">
                                                        <div class="row align-items-center">
                                                            <div
                                                                class="col-lg-6 col-md-6 col-6 border-end pe-0">
                                                                <div class="p-2">
                                                                    <p class="mb-0 ">{{ $row['wait_time_hour_minutes'] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-6 ps-0">
                                                                <div class="p-2">
                                                                    <p class="mb-0 ">{{ $row['reg_date_show'] }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="dta-border-bottom ">
                                                <div class="dta-name-bg rounded-0">
                                                    <div class="row align-items-center ">
                                                        <div class="col-lg-12 col-md-12 col-12 ps-3 text-center">
                                                            <p class="mb-0">{{ NotFoundMessage() }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div id="speciality" class="tab-pane  fade">
                                <div class="card-table">
                                    <div class="head-count border">
                                        <h6 class="mb-0 text-uppercase">Consultant Seen Wait</h6>
                                        <h6 class="mb-0">
                                            @if (count($success_array['content']['patient_wait_to_see_consultant_list']) > 0)
                                                {{ count($success_array['content']['patient_wait_to_see_consultant_list']) }}
                                                Patients
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="ane-content" >
                                        @if (isset($success_array['content']['patient_wait_to_see_consultant_list']) && count($success_array['content']['patient_wait_to_see_consultant_list']) > 0)
                                            @foreach ($success_array['content']['patient_wait_to_see_consultant_list'] as $row)
                                                <div class="dta-border-bottom ">
                                                    <div class="dta-name-bg rounded-0">
                                                        <div class="row align-items-center ">
                                                            <div class="col-lg-10 col-md-10 col-10 ps-3">
                                                                <p class="mb-0">{{ $row['symphony_patient_name'] }}</p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-2 text-end">
                                                                @if (strtolower($row['symphony_patient_sex']) == 'female')
                                                                    <img src="{{ asset('asset_v2/Template') }}/icons/female.svg" alt="">
                                                                @else
                                                                    <img src="{{ asset('asset_v2/Template') }}/icons/male.svg" alt="">
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-white">
                                                        <div class="row align-items-center">
                                                            <div
                                                                class="col-lg-6 col-md-6 col-6 border-end pe-0">
                                                                <div class="p-2">
                                                                    <p class="mb-0 ">{{ $row['symphony_final_location'] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-6 ps-0">
                                                                <div class="p-2">
                                                                    <p class="mb-0 ">{{ $row['wait_time_hour_minutes'] }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="dta-border-bottom ">
                                                <div class="dta-name-bg rounded-0">
                                                    <div class="row align-items-center ">
                                                        <div class="col-lg-12 col-md-12 col-12 ps-3 text-center">
                                                            <p class="mb-0">{{ NotFoundMessage() }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var barData = <?php echo json_encode($success_array['bar_graph']['graph_data']); ?>;
</script>

<script src="{{ asset('asset_v2/Ibox/Js/AneBarGraph.js') }}"></script>

<script>
    function GetAttandaceDetailsById(attendance_id,url) {
        @if(CheckSpecificPermission('ane_bar_chart_patient_details_view'))
            $('.modal-popup-loader-content').show();
            $.ajax({

                url: url,
                type: 'GET',
                data: { "attendance_id": attendance_id,},
                success: function (result)
                {

                    if (typeof result !== 'undefined') {
                        if(result !== 'permission_restricted') {


                            $('#attendence_details').html(result);

                            var attendence_details_modal = new bootstrap.Offcanvas(document.getElementById('symphony_attendance_id_patient_details'), {
                                relatedTarget: 'offcanvasRight',
                                backdrop: 'static'
                            });
                            attendence_details_modal.show();
                            DisableLoaderAndMakeVisibleInnerBody();
                        }else{
                            toastr.error('Permission Denied');
                        }
                        $('.modal-popup-loader-content').hide();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                        $('.modal-popup-loader-content').hide();
                    }




                }
            });
        @else
            toastr.error('Permission Denied');
        @endif
    }

</script>

<script>
    function GetDetailsBySpeciality(key,type) {
        @if(CheckSpecificPermission('ane_bar_chart_patient_details_view'))
        $('.modal-screen-center_1').show();
         if(key === 'in_ed'){
             if(type === 'all'){
                 $('#assigned_speciality_title').html('IN ED NOW');
             }else{
                 $('#assigned_speciality_title').html('IN ED NOW' + '-'+ type.toUpperCase() );
             }

         }
        else if(key === 'dta'){
             if(type === 'all'){
                 $('#assigned_speciality_title').html('DTA');
             }else{
                 $('#assigned_speciality_title').html('DTA' + '-'+ type.toUpperCase() );
             }

        }
         else if(key === 'triage'){
             if(type === 'all'){
                 $('#assigned_speciality_title').html('TRIAGE');
             }else{
                 $('#assigned_speciality_title').html('TRIAGE' + '-'+ type.toUpperCase());
             }

        }else{
             $('#assigned_speciality_title').html(key);
         }



        var url = '{{ route('GetDetailsBySpeciality') }}';
        $.ajax({

            url: url,
            type: 'GET',
            data: { "key": key,"type" : type,},
            success: function (result)
            {

                if (typeof result !== 'undefined') {
                    $('#get_data_of_canvas').html(result);



                    var assignedSpeciality = new bootstrap.Offcanvas(document.getElementById('assignedSpeciality'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: 'static'
                    });
                    assignedSpeciality.show();


                    DisableLoaderAndMakeVisibleInnerBody();
                    $('.modal-screen-center_1').hide();
                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }




            }
        });
        @else
        toastr.error('Permission Denied');
        @endif
    }


    function GetDetailsBySpecialityGraph(key,type) {
        @if(CheckSpecificPermission('ane_bar_chart_patient_details_view'))
        $('.modal-screen-center_1').show();
         if(key === 'in_ed'){
             if(type === 'all'){
                 $('.ane_patient_data_title').html('IN ED NOW');
             }else{
                 $('.ane_patient_data_title').html('IN ED NOW' + '-'+ type.toUpperCase() );
             }

         }
        else if(key === 'dta'){
             if(type === 'all'){
                 $('.ane_patient_data_title').html('DTA');
             }else{
                 $('.ane_patient_data_title').html('DTA' + '-'+ type.toUpperCase() );
             }

        }
         else if(key === 'triage'){
             if(type === 'all'){
                 $('.ane_patient_data_title').html('TRIAGE');
             }else{
                 $('.ane_patient_data_title').html('TRIAGE' + '-'+ type.toUpperCase());
             }

        }else{
             $('.ane_patient_data_title').html(key);
         }



        var url = '{{ route('GetDetailsBySpeciality') }}';
        $.ajax({

            url: url,
            type: 'GET',
            data: { "key": key,"type" : type,},
            success: function (result)
            {

                if (typeof result !== 'undefined') {
                    $('#get_data_of_canvas_graph').html(result);



                    var assignedSpeciality = new bootstrap.Offcanvas(document.getElementById('anePatientsData'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: 'static'
                    });
                    assignedSpeciality.show();


                    DisableLoaderAndMakeVisibleInnerBody();
                    $('.modal-screen-center_1').hide();
                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }




            }
        });
        @else
        toastr.error('Permission Denied');
        @endif
    }
</script>
