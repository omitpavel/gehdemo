<div class="d-lg-none sm-count">
    <div class="mobile-header">
        <h6 class="mb-0">{{ $success_array['ward_summary']['ward_name'] }}</h6>
        <span class="fs-10">{!! strip_tags($success_array['ward_last_boardround']) !!}</span>
    </div>
    <div class="emergency-count">
        <h6 class="mb-0">Elective - <span class="elective_mobile"></span></h6>
        <h6 class="mb-0 text-center">|</h6>
        <h6 class="mb-0"><span class="non_elective_mobile"></span> - Non-Elective</h6>
    </div>
</div>

<div class="col-lg-12">
    <div class="ward-summary-header">
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-6 mb-2">
                <div class="bed-count">
                    <div class="grey-tile-bottom">
                        <div
                            class="d-flex justify-content-between justify-content-xl-between border-bottom pt-2 pb-1">
                            <div class="d-flex align-items-center ">
                                <img src="{{ asset('asset_v2/Template/icons/male-icon.svg') }}" alt="" class="me-2">
                                <h6>Male</h6>
                            </div>
                            <h6 class="gender-count text-end">{{ $success_array['empty_bed_male']  }}</h6>
                        </div>
                        <div
                            class="d-flex justify-content-between justify-content-xl-between border-bottom pt-2 pb-1">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('asset_v2/Template/icons/female-icon.svg') }}" alt="" class="me-2">
                                <h6 class="">Female</h6>
                            </div>
                            <h6 class="gender-count text-end">{{ $success_array['empty_bed_female'] }}</h6>
                        </div>
                        <div
                            class="d-flex justify-content-between justify-content-xl-between pt-2 pb-1">
                            <div class="d-flex align-items-center ">
                                <img src="{{ asset('asset_v2/Template/icons/room.svg') }}" alt="" width="16" height="16" class="me-2">
                                <h6 class="">Side Rooms</h6>
                            </div>
                            <h6 class="gender-count text-end">{{ $success_array['empty_bed_sideroom'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-2 col-xl-4 col-lg-4 col-md-6 mb-2">
                <div class="tasks">
                    <div class="row g-2">
                        <div class="col-3 ">
                            <div class="bg-faculty-task cursor_pointer {{ PermissionDeniedDiv('camis_doctor_word_plan_modal_view') }}" @if(CheckSpecificPermission('camis_doctor_word_plan_modal_view')) onclick="Modal_open_of_dr_task('doctor','{{ $success_array['doctor_task_id'] }}');" @endif>
                                <div>
                                    <svg id="Group_2694" data-name="Group 2694" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 31.997 31.997">
                                        <g id="Group_2693" data-name="Group 2693">
                                            <g id="Ellipse_452" data-name="Ellipse 452" fill="#fff" stroke="#12afb2" stroke-width="1.5">
                                                <circle cx="15.999" cy="15.999" r="15.999" stroke="none"></circle>
                                                <circle cx="15.999" cy="15.999" r="15.249" fill="none"></circle>
                                            </g>
                                            <text id="Dr" transform="translate(8 20.608)" fill="#109ea0" font-size="14" font-family="Oxygen-Bold, Oxygen" font-weight="700">
                                                <tspan x="0" y="0">Dr</tspan>
                                            </text>
                                        </g>
                                    </svg>
                                </div>
                                <div class="task-role">
                                    <h6>Doctor <br> Tasks</h6>
                                </div>
                                <div class="task-count">
                                    <h6 id="total_doctor_task">{{ $success_array['patient_doctor_task']  }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 " >
                            <div class="bg-faculty-task cursor_pointer {{ PermissionDeniedDiv('camis_nurse_word_plan_modal_view') }}" @if(CheckSpecificPermission('camis_nurse_word_plan_modal_view')) onclick="Modal_open_of_dr_task('others','{{ $success_array['nurse_task_id'] }}');" @endif>
                                <div >
                                    <svg id="Group_2696" data-name="Group 2696" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32.001 32.001">
                                        <g id="Group_2695" data-name="Group 2695">
                                            <g id="Group_2692" data-name="Group 2692">
                                                <g id="Ellipse_453" data-name="Ellipse 453" fill="#fff" stroke="#7d087d" stroke-width="1.5">
                                                    <circle cx="16" cy="16" r="16" stroke="none"></circle>
                                                    <circle cx="16" cy="16" r="15.25" fill="none"></circle>
                                                </g>
                                                <text id="Rn" transform="translate(8.001 19.607)" fill="#7d087d" font-size="12" font-family="Oxygen-Bold, Oxygen" font-weight="700">
                                                    <tspan x="0" y="0">Rn</tspan>
                                                </text>
                                            </g>
                                        </g>
                                    </svg>

                                </div>
                                <div class="task-role">
                                    <h6>Nurses <br> Tasks</h6>
                                </div>
                                <div class="task-count">
                                    <h6 id="total_nurse_task">{{ $success_array['patient_nurse_task']  }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 {{ PermissionDeniedDiv('camis_ward_priority_task_view') }}">
                            <div class="bg-faculty-task click_open_camis_ward_priority_task {{ DisabledButtonOnRolePermission('camis_ward_priority_task_view') }}" type="button" class="btn p-0"
                               >
                                <div>
                                    <svg id="Group_2696" data-name="Group 2696"
                                        xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        viewBox="0 0 32.001 32.001">
                                        <g id="Group_2695" data-name="Group 2695">
                                            <g id="Group_2692" data-name="Group 2692">
                                                <g id="Ellipse_453" data-name="Ellipse 453"
                                                    fill="#fff" stroke="#FC0000" stroke-width="1.5">
                                                    <circle cx="16" cy="16" r="16" stroke="none" />
                                                    <circle cx="16" cy="16" r="15.25" fill="none" />
                                                </g>
                                                <text id="!" transform="translate(13.001 22.607)"
                                                    fill="#FC0000" font-size="22"
                                                    font-family="Oxygen-Bold, Oxygen"
                                                    font-weight="700">
                                                    <tspan x="0" y="0">!</tspan>
                                                </text>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="task-role">
                                    <h6>Priority <br>Tasks </h6>
                                </div>
                                <div class="task-count">
                                    <h6 id="priority_task_count">{{ $success_array['priority_task']  }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="bg-faculty-task cursor_pointer {{ PermissionDeniedDiv('camis_handover_modal_view') }}"  @if(CheckSpecificPermission('camis_handover_modal_view') && $success_array['total_handover'] > 0) data-bs-toggle="modal" onclick="HandOverDetailsModal({{ $success_array['ward_summary']['id'] }});" data-bs-target="#handoverModal" @endif>
                                <div>
                                    <button type="button" class="btn p-0"><img src="{{ asset('asset_v2/Template/icons/hand_over_icon@2x.png') }}" alt="" width="28" height="28"></button>
                                </div>
                                <div class="task-role">
                                    <h6>Nurses <br>
                                        Handover</h6>
                                </div>
                                <div class="task-count">
                                    <h6 class="handover_count" id="handover_count">{{ $success_array['total_handover']  }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-2 col-xl-5 col-lg-5 col-md-6 mb-2">
                <div class="row">
                    <div class="col-lg-12 ps-lg-1 ps-md-3 pe-xxl-0  ">
                        <div class="calender-box">
                            <div class="row align-items-center mb-2">
                                <div class="col-lg-4 col-md-4 col-4 ps-1 pe-lg-0  mb-2">
                                    <div class="maroon-box-medical">
                                        <h6 class="mb-0">DAILY TARGET</h6>
                                        <h6 class="mb-0">{{ isset($success_array['daily_target']) ? $success_array['daily_target'] : 0 }}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4 mb-2 gx-1">
                                    <h6 class="mb-0 text-center fw-bold head-calender">WEEKLY <br> DISCHARGE
                                    </h6>

                                </div>
                                <div class="col-lg-4 col-md-4 col-4 pe-1 ps-lg-0">
                                    <div class="green-box-medical">
                                        <h6 class="mb-0">TOTAL</h6>
                                        <h6 class="mb-0">{{ isset($success_array['weekly_discharges_total']) ? $success_array['weekly_discharges_total'] : 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="week-data">
                                <div class="day-data">
                                    <h6>M</h6>
                                    <h6 class="calender-date-bg">{{ isset($success_array['weekly_discharges']['monday']) ? $success_array['weekly_discharges']['monday'] : 0 }}</h6>
                                </div>
                                <div class="day-data">
                                    <h6>T</h6>
                                    <h6 class="calender-date-bg">{{ isset($success_array['weekly_discharges']['tuesday']) ? $success_array['weekly_discharges']['tuesday'] : 0 }}</h6>
                                </div>
                                <div class="day-data">
                                    <h6>W</h6>
                                    <h6 class="calender-date-bg">{{ isset($success_array['weekly_discharges']['wednesday']) ? $success_array['weekly_discharges']['wednesday'] : 0 }}</h6>
                                </div>
                                <div class="day-data">
                                    <h6>T</h6>
                                    <h6 class="calender-date-bg">{{ isset($success_array['weekly_discharges']['thursday']) ? $success_array['weekly_discharges']['thursday'] : 0 }}</h6>
                                </div>
                                <div class="day-data">
                                    <h6>F</h6>
                                    <h6 class="calender-date-bg">{{ isset($success_array['weekly_discharges']['friday']) ? $success_array['weekly_discharges']['friday'] : 0 }}</h6>
                                </div>
                                <div class="day-data">
                                    <h6>S</h6>
                                    <h6 class="calender-date-bg">{{ isset($success_array['weekly_discharges']['saturday']) ? $success_array['weekly_discharges']['saturday'] : 0 }}</h6>
                                </div>
                                <div class="day-data">
                                    <h6>S</h6>
                                    <h6 class="calender-date-bg">{{ isset($success_array['weekly_discharges']['sunday']) ? $success_array['weekly_discharges']['sunday'] : 0 }}</h6>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            @if(strtolower($success_array['ward_summary']['ward_url_name']) != 'rltsauip')

                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-6 mb-2">
                    <div class="edd-header">
                        <div class="grey-tile-bottom">
                            <div class="edd-data-box">
                                <h6>1 To 3 Days Over</h6>
                                <h6 class="gender-count text-end">{{ $success_array['patient_edd_1_3_days'] }}</h6>
                            </div>
                            <div class="edd-data-box">
                                <h6 class="">4 To 7 Days Over</h6>
                                <h6 class="gender-count text-end">{{ $success_array['patient_edd_4_7_days'] }}</h6>
                            </div>
                            <div class="edd-data-box">
                                <h6 class="me-1">8 Or More Days Over</h6>
                                <h6 class="gender-count text-end">{{ $success_array['patient_edd_8_more_days'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-xxl-2 col-xl-5 col-lg-5 col-md-8 mb-2">
                    <div class="row gx-0 inner-row">
                        <div id="firstColumn"
                            class="col-lg-4 col-md-5 col-8 pe-1 ps-lg-1 cursor-pointer">
                            <div @if(!CheckSpecificPermission('camis_definite_today_modal_view'))  onclick="CommonLoginModalPopupOpenOnRequest();" @endif class="tile-left-medical mb-1 @if(CheckSpecificPermission('camis_definite_today_modal_view')) click_open_camis_definite_today @endif" data-type="definite">
                                <div class="dp-data" >
                                    <div>
                                        <h6 class="maroon-circle">D</h6>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Definite <br> Today</h6>
                                    </div>
                                    <div>
                                        <h6 class="total">{{ $success_array['patient_definite_discharge_date']}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div  @if(!CheckSpecificPermission('camis_potential_today_modal_view'))  onclick="CommonLoginModalPopupOpenOnRequest();"  @endif class="tile-left-medical @if(CheckSpecificPermission('camis_potential_today_modal_view')) click_open_camis_definite_today @endif"  data-type="potential">
                                <div class="dp-data" >
                                    <div>
                                        <h6 class="purple-circle">P</h6>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 ">Potential <br> Today</h6>
                                    </div>
                                    <div>
                                        <h6 class="total">{{ $success_array['patient_definite_potential_date']}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="secondColumn" class="col-lg-3 col-md-2 col-4 pe-1 ps-1 mb-2 mb-md-0">
                            <div class="cdt-cell">
                                <div class="">
                                    <h6> <span class="fw-bold">CDT</span> <br> Confirmed <br> Discharge
                                        <br> Today</h6>
                                </div>
                                <div class="cdt-count">
                                    <h6>{{ $success_array['cdt_confirm_date'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 ps-md-1 pe-1" >
                            <div class="los-header">
                                <div class="grey-tile-bottom">
                                    <div class="edd-data-box">
                                        <h6>7 to 13 days</h6>
                                        <h6 class="gender-count text-end">{{ $success_array['patient_los_7_13_days'] }}</h6>
                                    </div>
                                    <div class="edd-data-box">
                                        <h6 class="">14 to 20 days</h6>
                                        <h6 class="gender-count text-end">{{ $success_array['patient_los_14_20_days'] }}</h6>
                                    </div>
                                    <div class="edd-data-box">
                                        <h6 class="">21+ days</h6>
                                        <h6 class="gender-count text-end">{{ $success_array['patient_los_21_days_more'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-9 mb-2">
                    <div class="tile-movement mb-1 click_open_camis_allowed_to_move_in">
                        <div class="bg-move">
                            <h6 class="mb-0">TO MOVED IN</h6>
                            <div class="line"></div>
                            <h6 class="total mb-0">{{ ($success_array['patient_allowed_to_move_in']+$success_array['allowed_to_move_in_from_reserved']) }}</h6>
                        </div>
                    </div>
                    <div class="tile-movement click_open_camis_allowed_to_move_out">
                        <div class="bg-move-not">
                            <h6 class="mb-0">TO MOVED OUT</h6>
                            <div class="line"></div>
                            <h6 class="total mb-0">{{ $success_array['patient_allowed_to_move_out'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-3 mb-2 {{ PermissionDeniedDiv('camis_ward_performance_page_view') }}">
                    <div class="bg-wine-red cursor_pointer {{ DisabledButtonOnRolePermission('camis_ward_performance_page_view') }}" @if(CheckSpecificPermission('camis_ward_performance_page_view')) onclick="location.href='{{ route('ward.ward-performance', $success_array['ward_summary']['ward_url_name']) }}';" @endif>
                        <div class="text-end ">
                            <div class="position-relative ">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40"
                                    viewBox="0 0 48 48">
                                    <defs>
                                        <linearGradient id="linear-gradient" x1="0.5" y1="0.4" x2="0.5"
                                            y2="1.103" gradientUnits="objectBoundingBox">
                                            <stop offset="0" stop-color="#fdfdfe"></stop>
                                            <stop offset="1" stop-color="#d9d9d9"></stop>
                                        </linearGradient>
                                        <filter id="Rectangle_14212" x="0" y="0" width="48" height="48"
                                            filterUnits="userSpaceOnUse">
                                            <feOffset dy="3" input="SourceAlpha"></feOffset>
                                            <feGaussianBlur stdDeviation="3" result="blur"></feGaussianBlur>
                                            <feFlood flood-opacity="0.188"></feFlood>
                                            <feComposite operator="in" in2="blur"></feComposite>
                                            <feComposite in="SourceGraphic"></feComposite>
                                        </filter>
                                    </defs>
                                    <g transform="matrix(1, 0, 0, 1, 0, 0)" filter="url(#Rectangle_14212)">
                                        <rect id="Rectangle_14212-2" data-name="Rectangle 14212" width="30"
                                            height="30" rx="4" transform="translate(9 6)"
                                            fill="url(#linear-gradient)"></rect>
                                    </g>
                                </svg>
                                <div class="next-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10.947" height="11.004"
                                        viewBox="0 0 10.947 11.004">
                                        <g id="Group_2304" data-name="Group 2304"
                                            transform="translate(10.947) rotate(90)">
                                            <path id="Path_19238" data-name="Path 19238"
                                                d="M5.438,0h.126a.863.863,0,0,1,.613.254L10.75,4.827A.865.865,0,1,1,9.529,6.051L5.5,2.023,1.474,6.051A.865.865,0,0,1,.252,4.827L4.826.254A.87.87,0,0,1,5.438,0Z"
                                                transform="translate(0 4.643)" fill="#771b36"></path>
                                            <path id="Path_19239" data-name="Path 19239"
                                                d="M5.438,0h.126a.867.867,0,0,1,.613.252L10.75,4.827A.865.865,0,0,1,9.529,6.051L5.5,2.023,1.474,6.051A.865.865,0,0,1,.252,4.827L4.826.252A.875.875,0,0,1,5.438,0Z"
                                                transform="translate(0 0)" fill="#771b36"></path>
                                        </g>
                                    </svg>
                                    <div class="hand-click-icon">
                                        <svg fill="#ffffff" width="15px" height="15px" viewBox="0 0 36 36"
                                            version="1.1" preserveAspectRatio="xMidYMid meet"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path class="clr-i-outline clr-i-outline-path-1"
                                                    d="M30.4,17.6c-1.8-1.9-4.2-3.2-6.7-3.7c-1.1-0.3-2.2-0.5-3.3-0.6c2.8-3.3,2.3-8.3-1-11.1s-8.3-2.3-11.1,1s-2.3,8.3,1,11.1 c0.6,0.5,1.2,0.9,1.8,1.1v2.2l-1.6-1.5c-1.4-1.4-3.7-1.4-5.2,0c-1.4,1.4-1.5,3.6-0.1,5l4.6,5.4c0.2,1.4,0.7,2.7,1.4,3.9 c0.5,0.9,1.2,1.8,1.9,2.5v1.9c0,0.6,0.4,1,1,1h13.6c0.5,0,1-0.5,1-1v-2.6c1.9-2.3,2.9-5.2,2.9-8.1v-5.8 C30.7,17.9,30.6,17.7,30.4,17.6z M8.4,8.2c0-3.3,2.7-5.9,6-5.8c3.3,0,5.9,2.7,5.8,6c0,1.8-0.8,3.4-2.2,4.5V7.9 c-0.1-1.8-1.6-3.2-3.4-3.2c-1.8-0.1-3.4,1.4-3.4,3.2v5.2C9.5,12.1,8.5,10.2,8.4,8.2L8.4,8.2z M28.7,24c0.1,2.6-0.8,5.1-2.5,7.1 c-0.2,0.2-0.4,0.4-0.4,0.7v2.1H14.2v-1.4c0-0.3-0.2-0.6-0.4-0.8c-0.7-0.6-1.3-1.3-1.8-2.2c-0.6-1-1-2.2-1.2-3.4 c0-0.2-0.1-0.4-0.2-0.6l-4.8-5.7c-0.3-0.3-0.5-0.7-0.5-1.2c0-0.4,0.2-0.9,0.5-1.2c0.7-0.6,1.7-0.6,2.4,0l2.9,2.9v3l1.9-1V7.9 c0.1-0.7,0.7-1.3,1.5-1.2c0.7,0,1.4,0.5,1.4,1.2v11.5l2,0.4v-4.6c0.1-0.1,0.2-0.1,0.3-0.2c0.7,0,1.4,0.1,2.1,0.2v5.1l1.6,0.3v-5.2 l1.2,0.3c0.5,0.1,1,0.3,1.5,0.5v5l1.6,0.3v-4.6c0.9,0.4,1.7,1,2.4,1.7L28.7,24z">
                                                </path>
                                                <rect x="0" y="0" width="36" height="36" fill-opacity="0">
                                                </rect>
                                            </g>
                                        </svg>
                                    </div>

                                </div>
                            </div>


                        </div>
                        <div class="icon-carrier pb-2">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#FABE00">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                    stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11 9V13.1707C9.83481 13.5825 9 14.6938 9 16C9 17.6569 10.3431 19 12 19C13.6569 19 15 17.6569 15 16C15 14.6938 14.1652 13.5825 13 13.1707V9H11ZM11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16Z"
                                        fill="#FABE00"></path>
                                    <path
                                        d="M12 5C15.866 5 19 8.13401 19 12V13H17V12C17 9.23858 14.7614 7 12 7C9.23858 7 7 9.23858 7 12V13H5V12C5 8.13401 8.13401 5 12 5Z"
                                        fill="#FABE00"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                        fill="#FABE00"></path>
                                </g>
                            </svg>
                        </div>
                        <h6>WARD PERFORMANCE</h6>
                    </div>
                </div>
            @else
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-6 mb-2">
                    <div class="edd-header">
                        <div class="grey-tile-bottom">
                            <div class="edd-data-box click_view_in_ed_now_patients cursor_pointer" data-ward="sau" data-type="en_ed_now">
                                <h6>In ED Now</h6>
                                <h6 class="gender-count text-end">{{ $success_array['in_ed_now'] }}</h6>
                            </div>
                            <div class="edd-data-box click_view_in_ed_now_patients cursor_pointer" data-ward="sau" data-type="with_dta">
                                <h6 class="">With DTA</h6>
                                <h6 class="gender-count text-end">{{ $success_array['total_dta_patients'] }}</h6>
                            </div>
                            <div class="edd-data-box click_view_in_ed_now_patients cursor_pointer" data-ward="sau" data-type="awaiting_bed">
                                <h6 class="">Awaiting Bed</h6>
                                <h6 class="gender-count text-end">{{ $success_array['total_without_bed'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-5 col-lg-5 col-md-8 mb-2">
                    <div class="row gx-0 inner-row">
                        <div id="firstColumn" class="col-lg-4 col-md-5 col-8 pe-1 ps-lg-1 ">
                            <div class="tile-left-medical mb-1">
                                <div class="dp-data">
                                    <div>
                                        <h6 class="mb-0">Admitted <br> Today</h6>
                                    </div>
                                    <div>
                                        <h6 class="total">{{ $success_array['admitted_today'] }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="tile-left-medical">
                                <div class="dp-data">
                                    <div>
                                        <h6 class="mb-0 ">Discharged<br> Today</h6>
                                    </div>
                                    <div>
                                        <h6 class="total">{{ $success_array['discharged_today'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="secondColumn" class="col-lg-3 col-md-2 col-4 pe-1 ps-1 mb-2 mb-md-0">
                            <div class="cdt-cell">
                                <div class="">
                                    <h6>Average <br> LOS</h6>
                                </div>
                                <div class="cdt-count">
                                    <h6>{{ floor($success_array['average_los_in_minutes'] / 60) }} H {{ $success_array['average_los_in_minutes'] % 60 }} M
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 ps-md-1 pe-1">
                            <div class="los-header">
                                <div class="grey-tile-bottom">
                                    <div class="edd-data-box">
                                        <h6>0 to 3 Hours</h6>
                                        <h6 class="gender-count text-end">{{ $success_array['stay_in_minutes']['0_3_hours'] }}</h6>
                                    </div>
                                    <div class="edd-data-box">
                                        <h6 class="">3 to 6 Hours</h6>
                                        <h6 class="gender-count text-end">{{ $success_array['stay_in_minutes']['3_6_hours'] }}</h6>
                                    </div>
                                    <div class="edd-data-box">
                                        <h6 class="">6+ Hours</h6>
                                        <h6 class="gender-count text-end">{{ $success_array['stay_in_minutes']['6_more_hours'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-7 mb-2 sau_patient_view_offcanvas">
                    <div class="sau-patient-count">
                        <div class="header-box">
                            <h6 class="mb-2">Patients To
                                <br>SAU</h6>
                        </div>
                        <div class="count-box">
                            <h6>{{ $success_array['ane_patients_to_sau'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-5 mb-2 {{ PermissionDeniedDiv('camis_ward_performance_page_view') }}">
                    <div class="bg-wine-red cursor_pointer {{ DisabledButtonOnRolePermission('camis_ward_performance_page_view') }}" @if(CheckSpecificPermission('camis_ward_performance_page_view')) onclick="location.href='{{ route('ward.ward-performance', $success_array['ward_summary']['ward_url_name']) }}';" @endif>
                        <div class="text-end ">
                            <div class="position-relative ">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40"
                                    viewBox="0 0 48 48">
                                    <defs>
                                        <linearGradient id="linear-gradient" x1="0.5" y1="0.4" x2="0.5"
                                            y2="1.103" gradientUnits="objectBoundingBox">
                                            <stop offset="0" stop-color="#fdfdfe"></stop>
                                            <stop offset="1" stop-color="#d9d9d9"></stop>
                                        </linearGradient>
                                        <filter id="Rectangle_14212" x="0" y="0" width="48" height="48"
                                            filterUnits="userSpaceOnUse">
                                            <feOffset dy="3" input="SourceAlpha"></feOffset>
                                            <feGaussianBlur stdDeviation="3" result="blur"></feGaussianBlur>
                                            <feFlood flood-opacity="0.188"></feFlood>
                                            <feComposite operator="in" in2="blur"></feComposite>
                                            <feComposite in="SourceGraphic"></feComposite>
                                        </filter>
                                    </defs>
                                    <g transform="matrix(1, 0, 0, 1, 0, 0)" filter="url(#Rectangle_14212)">
                                        <rect id="Rectangle_14212-2" data-name="Rectangle 14212" width="30"
                                            height="30" rx="4" transform="translate(9 6)"
                                            fill="url(#linear-gradient)"></rect>
                                    </g>
                                </svg>
                                <div class="next-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10.947" height="11.004"
                                        viewBox="0 0 10.947 11.004">
                                        <g id="Group_2304" data-name="Group 2304"
                                            transform="translate(10.947) rotate(90)">
                                            <path id="Path_19238" data-name="Path 19238"
                                                d="M5.438,0h.126a.863.863,0,0,1,.613.254L10.75,4.827A.865.865,0,1,1,9.529,6.051L5.5,2.023,1.474,6.051A.865.865,0,0,1,.252,4.827L4.826.254A.87.87,0,0,1,5.438,0Z"
                                                transform="translate(0 4.643)" fill="#771b36"></path>
                                            <path id="Path_19239" data-name="Path 19239"
                                                d="M5.438,0h.126a.867.867,0,0,1,.613.252L10.75,4.827A.865.865,0,0,1,9.529,6.051L5.5,2.023,1.474,6.051A.865.865,0,0,1,.252,4.827L4.826.252A.875.875,0,0,1,5.438,0Z"
                                                transform="translate(0 0)" fill="#771b36"></path>
                                        </g>
                                    </svg>
                                    <div class="hand-click-icon">
                                        <svg fill="#ffffff" width="15px" height="15px" viewBox="0 0 36 36"
                                            version="1.1" preserveAspectRatio="xMidYMid meet"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path class="clr-i-outline clr-i-outline-path-1"
                                                    d="M30.4,17.6c-1.8-1.9-4.2-3.2-6.7-3.7c-1.1-0.3-2.2-0.5-3.3-0.6c2.8-3.3,2.3-8.3-1-11.1s-8.3-2.3-11.1,1s-2.3,8.3,1,11.1 c0.6,0.5,1.2,0.9,1.8,1.1v2.2l-1.6-1.5c-1.4-1.4-3.7-1.4-5.2,0c-1.4,1.4-1.5,3.6-0.1,5l4.6,5.4c0.2,1.4,0.7,2.7,1.4,3.9 c0.5,0.9,1.2,1.8,1.9,2.5v1.9c0,0.6,0.4,1,1,1h13.6c0.5,0,1-0.5,1-1v-2.6c1.9-2.3,2.9-5.2,2.9-8.1v-5.8 C30.7,17.9,30.6,17.7,30.4,17.6z M8.4,8.2c0-3.3,2.7-5.9,6-5.8c3.3,0,5.9,2.7,5.8,6c0,1.8-0.8,3.4-2.2,4.5V7.9 c-0.1-1.8-1.6-3.2-3.4-3.2c-1.8-0.1-3.4,1.4-3.4,3.2v5.2C9.5,12.1,8.5,10.2,8.4,8.2L8.4,8.2z M28.7,24c0.1,2.6-0.8,5.1-2.5,7.1 c-0.2,0.2-0.4,0.4-0.4,0.7v2.1H14.2v-1.4c0-0.3-0.2-0.6-0.4-0.8c-0.7-0.6-1.3-1.3-1.8-2.2c-0.6-1-1-2.2-1.2-3.4 c0-0.2-0.1-0.4-0.2-0.6l-4.8-5.7c-0.3-0.3-0.5-0.7-0.5-1.2c0-0.4,0.2-0.9,0.5-1.2c0.7-0.6,1.7-0.6,2.4,0l2.9,2.9v3l1.9-1V7.9 c0.1-0.7,0.7-1.3,1.5-1.2c0.7,0,1.4,0.5,1.4,1.2v11.5l2,0.4v-4.6c0.1-0.1,0.2-0.1,0.3-0.2c0.7,0,1.4,0.1,2.1,0.2v5.1l1.6,0.3v-5.2 l1.2,0.3c0.5,0.1,1,0.3,1.5,0.5v5l1.6,0.3v-4.6c0.9,0.4,1.7,1,2.4,1.7L28.7,24z">
                                                </path>
                                                <rect x="0" y="0" width="36" height="36" fill-opacity="0">
                                                </rect>
                                            </g>
                                        </svg>
                                    </div>

                                </div>
                            </div>


                        </div>
                        <div class="icon-carrier pb-2">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#FABE00">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                    stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11 9V13.1707C9.83481 13.5825 9 14.6938 9 16C9 17.6569 10.3431 19 12 19C13.6569 19 15 17.6569 15 16C15 14.6938 14.1652 13.5825 13 13.1707V9H11ZM11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16Z"
                                        fill="#FABE00"></path>
                                    <path
                                        d="M12 5C15.866 5 19 8.13401 19 12V13H17V12C17 9.23858 14.7614 7 12 7C9.23858 7 7 9.23858 7 12V13H5V12C5 8.13401 8.13401 5 12 5Z"
                                        fill="#FABE00"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                        fill="#FABE00"></path>
                                </g>
                            </svg>
                        </div>
                        <h6>WARD PERFORMANCE</h6>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <input type="hidden" value="{{ $success_array['ward_summary']['id'] }}" id="ward_id">

    @include('Dashboards.Camis.WardSummary.WardSummaryPatientBedDetails')
</div>

