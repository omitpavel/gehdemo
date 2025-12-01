<input type="hidden" value="{{ $discharge_lounge_ward_id }}" id="ward_id">
<div class="col-lg-12">
    <div class="ward-summary-header">
        <div class="row">
            <div class="col-xxl-2 col-lg-4 col-md-6 mb-2">
                <div class="tasks">
                    <div class="row g-2">
                        <div class="col-4">
                            <div class="bg-faculty-task cursor_pointer {{ PermissionDeniedDiv('camis_doctor_word_plan_modal_view') }}"
                                @if (CheckSpecificPermission('camis_doctor_word_plan_modal_view')) onclick="Modal_open_of_dr_task('doctor','{{ $success_array['doctor_task_id'] }}');" @endif>
                                <div>
                                    <svg id="Group_2694" data-name="Group 2694" xmlns="http://www.w3.org/2000/svg"
                                        width="28" height="28" viewBox="0 0 31.997 31.997">
                                        <g id="Group_2693" data-name="Group 2693">
                                            <g id="Ellipse_452" data-name="Ellipse 452" fill="#fff" stroke="#12afb2"
                                                stroke-width="1.5">
                                                <circle cx="15.999" cy="15.999" r="15.999" stroke="none">
                                                </circle>
                                                <circle cx="15.999" cy="15.999" r="15.249" fill="none">
                                                </circle>
                                            </g>
                                            <text id="Dr" transform="translate(8 20.608)" fill="#109ea0"
                                                font-size="14" font-family="Oxygen-Bold, Oxygen" font-weight="700">
                                                <tspan x="0" y="0">Dr</tspan>
                                            </text>
                                        </g>
                                    </svg>
                                </div>
                                <div class="task-role">
                                    <h6>Doctor <br> Tasks</h6>
                                </div>
                                <div class="task-count">
                                    <h6 id="total_doctor_task">{{ $success_array['patient_doctor_task'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-faculty-task cursor_pointer {{ PermissionDeniedDiv('camis_nurse_word_plan_modal_view') }}"
                                @if (CheckSpecificPermission('camis_nurse_word_plan_modal_view')) onclick="Modal_open_of_dr_task('others','{{ $success_array['nurse_task_id'] }}');" @endif>
                                <div>
                                    <svg id="Group_2696" data-name="Group 2696" xmlns="http://www.w3.org/2000/svg"
                                        width="28" height="28" viewBox="0 0 32.001 32.001">
                                        <g id="Group_2695" data-name="Group 2695">
                                            <g id="Group_2692" data-name="Group 2692">
                                                <g id="Ellipse_453" data-name="Ellipse 453" fill="#fff"
                                                    stroke="#7d087d" stroke-width="1.5">
                                                    <circle cx="16" cy="16" r="16" stroke="none">
                                                    </circle>
                                                    <circle cx="16" cy="16" r="15.25" fill="none">
                                                    </circle>
                                                </g>
                                                <text id="Rn" transform="translate(8.001 19.607)" fill="#7d087d"
                                                    font-size="12" font-family="Oxygen-Bold, Oxygen" font-weight="700">
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
                                    <h6 id="total_nurse_task">{{ $success_array['patient_nurse_task'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-faculty-task click_open_camis_ward_priority_task {{ DisabledButtonOnRolePermission('camis_ward_priority_task_view') }}"
                                type="button">
                                <div>
                                    <svg id="Group_2696" data-name="Group 2696" xmlns="http://www.w3.org/2000/svg"
                                        width="28" height="28" viewBox="0 0 32.001 32.001">
                                        <g id="Group_2695" data-name="Group 2695">
                                            <g id="Group_2692" data-name="Group 2692">
                                                <g id="Ellipse_453" data-name="Ellipse 453" fill="#fff"
                                                    stroke="#FC0000" stroke-width="1.5">
                                                    <circle cx="16" cy="16" r="16" stroke="none">
                                                    </circle>
                                                    <circle cx="16" cy="16" r="15.25" fill="none">
                                                    </circle>
                                                </g>
                                                <text id="!" transform="translate(13.001 22.607)" fill="#FC0000"
                                                    font-size="22" font-family="Oxygen-Bold, Oxygen" font-weight="700">
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
                                    <h6 id="priority_task_count">{{ $success_array['priority_task'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-5 col-md-6 mb-2">
                <div class="row">
                    <div class="col-lg-12 ps-lg-1 ps-md-3 pe-xxl-0 ">
                        <div class="calender-box">
                            <div class="row align-items-center mb-2">
                                <div class="col-lg-4 col-md-4 col-4 ps-1 pe-lg-0  mb-2">
                                    <div class="maroon-box-medical">
                                        <h6 class="mb-0">DAILY TARGET</h6>
                                        <h6 class="mb-0">{{ isset($success_array['daily_target']) ? $success_array['daily_target'] : 0 }}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4 mb-2 gx-1">
                                    <h6 class="mb-0 text-center fw-bold head-calender">WEEKLY <br>
                                        DISCHARGE
                                    </h6>

                                </div>
                                <div class="col-lg-4 col-md-4 col-4 pe-1 ps-lg-0">
                                    <div class="green-box-medical">
                                        <h6 class="mb-0">TARGET</h6>
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
            <div class="col-xxl-2 col-lg-3 col-md-4 mb-2">
                <div class="edd-header">
                    <div class="grey-tile-bottom">
                        <div class="edd-data-box click_view_in_ed_now_patients cursor_pointer"
                            data-ward="discharge_lounge" data-type="en_ed_now">
                            <h6>In ED Now</h6>
                            <h6 class="gender-count text-end">{{ $success_array['in_ed_now'] }}</h6>
                        </div>
                        <div class="edd-data-box click_view_in_ed_now_patients cursor_pointer"
                            data-ward="discharge_lounge" data-type="with_dta">
                            <h6 class="">With DTA</h6>
                            <h6 class="gender-count text-end">{{ $success_array['total_dta_patients'] }}</h6>
                        </div>
                        <div class="edd-data-box click_view_in_ed_now_patients cursor_pointer"
                            data-ward="discharge_lounge" data-type="awaiting_bed">
                            <h6 class="">Awaiting Bed</h6>
                            <h6 class="gender-count text-end">{{ $success_array['total_without_bed'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-12 col-md-8 mb-2">
                <div class="row gx-2 inner-row">
                    <div id="firstColumn" class="col-lg-4 col-md-5 col-8 cursor-pointer">
                        <div  class="tile-left-medical mb-1">
                            <div class="dp-data">
                                <div>
                                    <h6 class="mb-0">Admitted <br> Today</h6>
                                </div>
                                <div>
                                    <h6 class="total">{{ $success_array['admitted_today'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div  class="tile-left-medical">
                            <div class="dp-data">
                                <div>
                                    <h6 class="mb-0 ">Discharged <br> Today</h6>
                                </div>
                                <div>
                                    <h6 class="total">{{ $success_array['discharged_today'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="secondColumn" class="col-lg-3 col-md-2 col-4 mb-2 mb-md-0">
                        <div class="cdt-cell">
                            <div class="">
                                <h6>Average <br> LOS</h6>
                            </div>
                            <div class="cdt-count">
                                <h6>{{ floor($success_array['average_los_in_minutes'] / 60) }} H
                                    {{ $success_array['average_los_in_minutes'] % 60 }} M</h6>
                            </div>
                        </div>
                    </div>
                    <div id="thirdColumn" class="col-lg-5 col-md-5">
                        <div class="los-header">
                            <div class="grey-tile-bottom">
                                <div class="edd-data-box">
                                    <h6>0 to 3 Hours</h6>
                                    <h6 class="gender-count text-end">
                                        {{ $success_array['stay_in_minutes']['0_3_hours'] }}</h6>
                                </div>
                                <div class="edd-data-box">
                                    <h6 class="">3 to 6 Hours</h6>
                                    <h6 class="gender-count text-end">
                                        {{ $success_array['stay_in_minutes']['3_6_hours'] }}</h6>
                                </div>
                                <div class="edd-data-box">
                                    <h6 class="">6+ Hours</h6>
                                    <h6 class="gender-count text-end">
                                        {{ $success_array['stay_in_minutes']['6_more_hours'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Area Details -->

    <div class="patients-area-details">
        <div class="row gx-2">
            <div class="col-lg-6">
                <div class="waiting-area">
                    <div class="bg-area-patient  bg-area-grey">
                        <h6>Waiting Area</h6>
                    </div>
                    <div class="row gx-0 droppable " data-area="0">
                        @foreach ($waiting_area as $patient)
                            <div class="col-xxl-4 col-md-6 draggable its_a_bed"
                                data-patient-id="{{ $patient['camis_patient_id'] }}" {{-- @if (CheckSpecificPermission('camis_boardround_view')) onclick="window.location.href='{{ route('ward.boardround', ['ward' => 'rltsdecip', 'patient_id' => $patient['camis_patient_id']]) }}'" @endif --}}>
                                <div class="medical-details-card patient">
                                    <div class="row">
                                        <div class="col-12 pe-0 ps-0">
                                            <div class="ward-header-row">
                                                <div class="header-col-1 bed_black_background ">
                                                    <span>LOS:
                                                        {{ NumberOfHoursBetweenTwoDates($patient['camis_patient_admission_date_time'], CurrentDateOnFormat()) }}
                                                        Hours</span>
                                                </div>
                                                <div class="header-col-2 bed_black_background ">
                                                    <a
                                                        @if (CheckSpecificPermission('camis_boardround_view')) href="{{ route('ward.discharge.lounge.boardround', $patient['camis_patient_id']) }}" @else href="#" @endif><img
                                                            src="{{ asset('asset_v2/Template/icons/boardround.png') }}"
                                                            alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 p-0">
                                            <div class="card-medical">
                                                <div class="patient-data-table">
                                                    <div class="patient-data">
                                                        <div class="gender-icon">
                                                            @if (strtolower($patient['camis_patient_sex']) == 'male')
                                                                <img src="{{ asset('asset_v2/Template/icons/gender-male.svg') }}"
                                                                    alt="" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Male">
                                                            @elseif(strtolower($patient['camis_patient_sex']) == 'female')
                                                                <img src="{{ asset('asset_v2/Template/icons/gender-female.svg') }}"
                                                                    alt="" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" title="Female">
                                                            @endif

                                                        </div>
                                                        <div class="name">
                                                            <span class="patient_name_hide_on_request ">Patient
                                                                {{ WardBedShowPatientCharacter($loop->iteration) }}</span>
                                                            <span
                                                                class="content_display_none patient_name_show_on_request ">
                                                                {{ $patient['camis_patient_name'] }}</span>
                                                            <span
                                                                class="pass-id">({{ $patient['camis_patient_pas_number'] }})</span>
                                                        </div>
                                                    </div>
                                                    <div class="consultant-data">
                                                        <div class="label-consultant">
                                                            <span>Consultant</span>
                                                        </div>
                                                        <div class="consultant-name">
                                                            <span>{{ limitText($patient['camis_consultant_name'], 28) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="speciality-data">
                                                        <div class="label-speciality">
                                                            <span>Speciality</span>
                                                        </div>
                                                        <div class="speciality-name">
                                                            <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title="{{ $patient['camis_consultant_code_description'] }} ({{ $patient['camis_consultant_specialty'] }})">{{ limitText($patient['camis_consultant_code_description'], 21) }}
                                                                ({{ limitText($patient['camis_consultant_specialty'], 6) }})
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach




                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="assesment-area">
                    <div class="bg-area-patient">
                        <h6>Discharge Lounge Assessment Unit</h6>
                    </div>
                    <div class="row gx-0 bed_section_type" data-area="1">
                        @foreach ($discharge_lounge_area as $patient)
                            <div class="col-xxl-4 col-md-6">
                                <div class="medical-details-card cubical-card patient "
                                    data-bed-id="{{ $patient['bed_id'] }}">
                                    <div class="row">
                                        <div
                                            class="col-xl-12 col-lg-12 col-md-12 col-12 bg-bed-empty justify-content-start ps-1">
                                            <h6 class="mb-0 text-center">{{ $patient['bed_name'] }}</h6>
                                        </div>
                                    </div>
                                    @if (empty($patient['camis_patient_id']))
                                        <div class="sortable-placeholder droppable "> </div>
                                    @else
                                        <div class="sortable-placeholder droppable ">
                                            <div class="col-xxl-4 col-md-6 draggable">
                                                <div class="medical-details-card its_a_bed"
                                                    data-patient-id="{{ $patient['camis_patient_id'] }}">
                                                    <div class="row">
                                                        <div class="col-12 pe-0 ps-0">
                                                            <div class="ward-header-row">
                                                                <div class="header-col-1 bed_black_background">
                                                                    <span>LOS:
                                                                        {{ NumberOfHoursBetweenTwoDates($patient['camis_patient_admission_date_time'], CurrentDateOnFormat()) }}
                                                                        Hours</span>
                                                                </div>

                                                                <div class="header-col-2 bed_black_background">
                                                                    <a
                                                                        @if (CheckSpecificPermission('camis_boardround_view')) href="{{ route('ward.discharge.lounge.boardround', $patient['camis_patient_id']) }}" @else href="#" @endif>
                                                                        <img src="{{ asset('asset_v2/Template/icons/boardround.png') }}"
                                                                            alt="">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-0">
                                                            <div class="card-medical">
                                                                <div class="patient-data-table">
                                                                    <div class="patient-data">
                                                                        <div class="gender-icon">
                                                                            @if (strtolower($patient['camis_patient_sex']) == 'male')
                                                                                <img src="{{ asset('asset_v2/Template/icons/gender-male.svg') }}"
                                                                                    alt=""
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom"
                                                                                    title="Male">
                                                                            @elseif(strtolower($patient['camis_patient_sex']) == 'female')
                                                                                <img src="{{ asset('asset_v2/Template/icons/gender-female.svg') }}"
                                                                                    alt=""
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom"
                                                                                    title="Female">
                                                                            @endif
                                                                        </div>
                                                                        <div class="name">
                                                                            <span
                                                                                class="patient_name_hide_on_request ">Patient
                                                                                {{ WardBedShowPatientCharacter($loop->iteration) }}</span>
                                                                            <span
                                                                                class="content_display_none patient_name_show_on_request ">
                                                                                {{ $patient['camis_patient_name'] }}</span>
                                                                            <span
                                                                                class="pass-id">({{ $patient['camis_patient_pas_number'] }})</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="consultant-data">
                                                                        <div class="label-consultant">
                                                                            <span>Consultant</span>
                                                                        </div>
                                                                        <div class="consultant-name">
                                                                            <span>{{ limitText($patient['camis_consultant_name'], 28) }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="speciality-data">
                                                                        <div class="label-speciality">
                                                                            <span>Speciality</span>
                                                                        </div>
                                                                        <div class="speciality-name">
                                                                            <span data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom"
                                                                                title="{{ $patient['camis_consultant_code_description'] }} ({{ $patient['camis_consultant_specialty'] }})">{{ limitText($patient['camis_consultant_code_description'], 21) }}
                                                                                ({{ limitText($patient['camis_consultant_specialty'], 6) }})</span>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach




                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
    $(document).ready(function() {
        let holdTimer;
        let isDragging = false;


        function startDragging(element, event) {
            if (isDragging) return;
            element.addClass("active").draggable({
                revert: "invalid",
                start: function() {
                    $(this).css("cursor", "grabbing");
                    isDragging = true;
                },
                stop: function() {
                    $(this).removeClass("active").css("cursor", "move");
                    isDragging = false;
                    updateAllPositions();
                }
            }).draggable("enable");
            isDragging = true;
            let touch = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
            element.simulate("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
        }
        $(document).on("mousedown touchstart", ".draggable", function(e) {
            e.preventDefault();
            let element = $(this);
            holdTimer = setTimeout(function() {
                startDragging(element, e);
            }, 500);
        });
        $(document).on("mouseup touchend touchcancel", ".draggable", function() {
            clearTimeout(holdTimer);
        });
        $(".droppable").droppable({
            accept: ".draggable",
            drop: function(event, ui) {
                let droppable = $(this);
                let draggable = ui.draggable;
                let droppableOffset = droppable.offset().top;
                let draggableOffset = ui.offset.top;
                let items = droppable.children(".draggable").not(draggable);
                draggable.appendTo(droppable).css({
                    position: "relative",
                    top: "auto",
                    left: "auto",
                });
                let inserted = false;
                items.each(function() {
                    let item = $(this);
                    if (draggableOffset < item.offset().top) {
                        item.before(draggable);
                        inserted = true;
                        return false; // Break loop
                    }
                });
                if (!inserted) {

                    droppable.removeClass("droppable");
                    droppable.children('.cubical-card').addClass('d-none');
                    droppable.append(draggable);
                    $('.ui-droppable').each(function() {
                        const $dropArea = $(this);
                        // Count only visible elements or specific items (e.g., ".item")
                        const childCount = $dropArea.children().length;
                        if (childCount === 1) {
                            $dropArea.droppable("disable");

                            $dropArea.children('.draggable').removeClass(
                                'col-xxl-4 col-md-6'
                            );
                            if ($(".waiting-area .ui-droppable .draggable").length ===
                                1) {
                                $(".waiting-area .ui-droppable").children('.draggable')
                                    .addClass(
                                        'col-xxl-4 col-md-6'
                                    );
                                $(".waiting-area .ui-droppable").droppable("enable");
                            }
                            $dropArea.removeClass(['sortable-placeholder', 'its_a_bed']);
                            $dropArea.removeAttr('data-patient-id');
                        } else if (childCount === 0) {
                            $dropArea.droppable("enable");
                            $dropArea.children('.draggable').addClass(
                                'col-xxl-4 col-md-6'
                            );
                            $dropArea.addClass(['sortable-placeholder', 'its_a_bed']);
                            $dropArea.attr('data-patient-id', '');
                            if ($(".waiting-area .ui-droppable .draggable").length ===
                                0) {
                                $(".waiting-area .ui-droppable").removeClass(
                                    'sortable-placeholder'
                                );
                                $(".waiting-area .ui-droppable").removeClass(
                                    'its_a_bed'
                                );
                                $(".waiting-area .ui-droppable").addClass(
                                    'droppable'
                                );
                                $dropArea.removeAttr('data-patient-id');
                            }


                        } else {
                            $dropArea.droppable("enable");
                            $dropArea.children('.draggable').addClass(
                                'col-xxl-4 col-md-6'
                            );
                        }
                    });
                } else {
                    $('.ui-droppable').each(function() {
                        const $dropArea = $(this);

                        // Count only visible elements or specific items (e.g., ".item")
                        const childCount = $dropArea.children().length;
                        if (childCount === 1) {
                            $dropArea.droppable("disable");

                            $dropArea.children('.draggable').removeClass(
                                'col-xxl-4 col-md-6'
                            );
                            $dropArea.removeClass(['sortable-placeholder', 'its_a_bed']);
                            $dropArea.removeAttr('data-patient-id');
                        } else if (childCount === 0) {
                            $dropArea.droppable("enable");

                            $dropArea.children('.draggable').addClass(
                                'col-xxl-4 col-md-6'
                            );
                            $dropArea.addClass(['sortable-placeholder', 'its_a_bed']);
                            $dropArea.attr('data-patient-id', '');

                        } else {
                            $dropArea.droppable("enable");
                            $dropArea.children('.draggable').addClass(
                                'col-xxl-4 col-md-6'
                            );
                        }
                    });
                }
            }
        });
        // Simulate mousedown event for touch devices
        $.fn.simulate = function(eventName, options) {
            let event = new MouseEvent(eventName, {
                view: window,
                bubbles: true,
                cancelable: true,
                clientX: options.clientX,
                clientY: options.clientY
            });
            this[0].dispatchEvent(event);
            return this;
        };
        intialLoadCard();

    });

    function intialLoadCard() {

        // $($('.ED-area .droppable')[0]).appendTo(dragablewidget);
        $('.assesment-area .droppable').each(function() {
            const $dropArea = $(this);

            // Count only visible elements or specific items (e.g., ".item")
            const childCount = $dropArea.children().length;
            if (childCount === 1) {
                $dropArea.droppable("disable");

                $dropArea.children('.draggable').removeClass(
                    'col-xxl-4 col-md-6'
                );
                $dropArea.removeClass(['sortable-placeholder', 'its_a_bed']);
                $dropArea.removeAttr('data-patient-id');
                $dropArea.children('.draggable').draggable().draggable('enable');
            } else if (childCount === 0) {
                $dropArea.droppable("enable");

                $dropArea.children('.draggable').addClass(
                    'col-xxl-4 col-md-6'
                );
                $dropArea.addClass(['sortable-placeholder', 'its_a_bed']);
                $dropArea.attr('data-patient-id', '');

            } else {
                $dropArea.droppable("enable");
                $dropArea.children('.draggable').addClass(
                    'col-xxl-4 col-md-6'
                );
            }
        });


    }

    function updateAllPositions() {
        let allPositions = [];
        let lastArea = null;
        let positionIndex = 1;
        var token = "{{ csrf_token() }}";
        $(".its_a_bed").each(function() {
            let area = $(this).closest('[data-area]').data('area');
            let patientId = $(this).data('patient-id');
            let bedId = $(this).closest('[data-bed-id]').data('bed-id') || 0;


            if (area !== lastArea) {
                positionIndex = 1;
                lastArea = area;
            }


            allPositions.push({
                area: area,
                patient_id: patientId,
                position: positionIndex,
                bed_id: bedId
            });

            positionIndex++;
        });
        $('.page-data-loader').show();
        $.ajax({
            url: '{{ route('update.discharge.lounge.position') }}',
            type: 'POST',
            data: {
                allPositions: allPositions,
                _token: token
            },
            success: function(response) {
                toastr.success('Position updated successfully:', response);
                $('.page-data-loader').hide();
            },
            error: function(xhr, status, error) {
                $('.page-data-loader').hide();
                toastr.error('Error updating position:', error);
            }
        });

    }
</script>
