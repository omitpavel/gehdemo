<div class="mb-3">
    <div class="top-label">
        <h6 class="mb-0">{{ $success_array['section_head'] }}</h6>
    </div>
</div>
<div class="card-grey-chart mb-2">
    <div class="row">
        <div class="col-12" id="my_div" style="min-height:63px;">
            @if(isset($success_array['current_week_days_text_green']) && !empty($success_array['current_week_days_text_green']))
                <div class="row gx-2">
                    <div class="col-11 text-end">
                        <span class="fs-12">{{ @$success_array['current_week_days_text_green'] }}</span>
                    </div>
                    <div class="col-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19">
                            <rect id="Rectangle_14941" data-name="Rectangle 14941" width="19" height="19" rx="3" fill="#2fb07d"></rect>
                        </svg>
                    </div>
                </div>

                @endif

                @if(isset($success_array['last_year_current_week_days_text_red']) && !empty($success_array['last_year_current_week_days_text_red']))
                <div class="row gx-2">
                    <div class="col-11 text-end">
                        <span class="fs-12">{{ @$success_array['last_year_current_week_days_text_red'] }}</span>
                    </div>
                    <div class="col-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19">
                            <rect id="Rectangle_14943" data-name="Rectangle 14943" width="19" height="19" rx="3" fill="#e53935"></rect>
                        </svg>
                    </div>
                </div>

                @endif
                @if(isset($success_array['last_four_week_days_text_blue']) && !empty($success_array['last_four_week_days_text_blue']))
                <div class="row gx-2">
                    <div class="col-11 text-end">
                        <span class="fs-12">{{ @$success_array['last_four_week_days_text_blue'] }}</span>
                    </div>
                    <div class="col-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19">
                            <rect id="Rectangle_14942" data-name="Rectangle 14942" width="19" height="19" rx="3" fill="#2471a3"></rect>
                        </svg>
                    </div>
                </div>
                @endif
        </div>
    </div>
    <div class="BoxPlogGroupchartWrap js-plotly-plot" style="min-height: 290px;">
        <div id="GroupedBoxplotChartDaySummary"></div>
    </div>

</div>

<div id="attendence-details" class="attendence-details">
    <div class="card-grey-chart">
        <div class="attendanceTableWrap">
            <div class="attendTableRow dayTxtrow">
                <div class="columnFirst"></div>
                <div class="column">
                    <span class="dayTxt @if ($success_array['current_week_box_plot_data']['monday']['current_day'] == 'live') active @endif">Mon</span>
                </div>
                <div class="column">
                    <span class="dayTxt @if ($success_array['current_week_box_plot_data']['tuesday']['current_day'] == 'live') active @endif">Tue</span>
                </div>
                <div class="column">
                    <span class="dayTxt @if ($success_array['current_week_box_plot_data']['wednesday']['current_day'] == 'live') active @endif">Wed</span>
                </div>
                <div class="column">
                    <span class="dayTxt @if ($success_array['current_week_box_plot_data']['thursday']['current_day'] == 'live') active @endif">Thu</span>
                </div>
                <div class="column">
                    <span class="dayTxt @if ($success_array['current_week_box_plot_data']['friday']['current_day'] == 'live') active @endif">Fri</span>
                </div>
                <div class="column">
                    <span class="dayTxt @if ($success_array['current_week_box_plot_data']['saturday']['current_day'] == 'live') active @endif">Sat</span>
                </div>
                <div class="column">
                    <span class="dayTxt @if ($success_array['current_week_box_plot_data']['sunday']['current_day'] == 'live') active @endif">Sun</span>
                </div>
            </div>
            <div class="attendTableRow head">
                <div class="columnFirst">
                    <span class="attendncesHead">ATTENDANCE</span>
                </div>
                <div class="column">
                    @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_attendence']))
                        <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_attendence'] }}</span>
                    @else
                        <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_attendence'] }}</span>
                    @endif
                    <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_attendence'] }}</span>
                </div>
                <div class="column">
                    @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_attendence']))
                        <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_attendence'] }}</span>
                    @else
                        <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_attendence'] }}</span>
                    @endif
                    <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_attendence'] }}</span>
                </div>
                <div class="column">
                    @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_attendence']))
                        <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_attendence'] }}</span>
                    @else
                        <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_attendence'] }}</span>
                    @endif
                    <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_attendence'] }}</span>
                </div>
                <div class="column">
                    @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_attendence']))
                        <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_attendence'] }}</span>
                    @else
                        <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_attendence'] }}</span>
                    @endif
                    <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_attendence'] }}</span>
                </div>
                <div class="column">
                    @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_attendence']))
                        <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_attendence'] }}</span>
                    @else
                        <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_attendence'] }}</span>
                    @endif
                    <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_attendence'] }}</span>
                </div>
                <div class="column">
                    @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_attendence']))
                        <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_attendence'] }}</span>
                    @else
                        <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_attendence'] }}</span>
                    @endif
                    <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_attendence'] }}</span>
                </div>
                <div class="column">
                    @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_attendence']))
                        <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_attendence'] }}</span>
                    @else
                        <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_attendence'] }}</span>
                    @endif
                    <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_attendence'] }}</span>
                </div>
            </div>
            <div class="attendTableRow inBody">
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell1">Avg Attd Per Day</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_attendence_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_attendence_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_attendence_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_attendence_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_attendence_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_attendence_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_attendence_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_attendence_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_attendence_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_attendence_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_attendence_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_attendence_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_attendence_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_attendence_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_attendence_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_attendence_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_attendence_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_attendence_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_attendence_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_attendence_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_attendence_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_attendence_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_attendence_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_attendence_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_attendence_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_attendence_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_attendence_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_attendence_day'] }}</span>
                    </div>
                </div>
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell2">Avg Time In Dept(Min)</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_attendence_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_attendence_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_attendence_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_attendence_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_attendence_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_attendence_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_attendence_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_attendence_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_attendence_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_attendence_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_attendence_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_attendence_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_attendence_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_attendence_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_attendence_day_in_minutes'] }}</span>
                    </div>
                </div>
            </div>
            <div class="attendTableRow inBody">
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell1">Avg Adm Per Day</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_admissions_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_admissions_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_admissions_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_admissions_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_admissions_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_admissions_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_admissions_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_admissions_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_admissions_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_admissions_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_admissions_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_admissions_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_admissions_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_admissions_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_admissions_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_admissions_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_admissions_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_admissions_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_admissions_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_admissions_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_admissions_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_admissions_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_admissions_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_admissions_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_admissions_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_admissions_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_admissions_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_admissions_day'] }}</span>
                    </div>
                </div>
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell2">Avg Time In Dept(Min)</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_admissions_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_admissions_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_admissions_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_admissions_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_admissions_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_admissions_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_admissions_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_admissions_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_admissions_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_admissions_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_admissions_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_admissions_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_admissions_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_admissions_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_admissions_day_in_minutes'] }}</span>
                    </div>
                </div>
            </div>
            <div class="attendTableRow inBody">
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell1">Avg Amb Arrivals</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_ambulance_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_ambulance_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_ambulance_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_ambulance_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_ambulance_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_ambulance_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_ambulance_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_ambulance_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_ambulance_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_ambulance_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_ambulance_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_ambulance_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_ambulance_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_ambulance_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_ambulance_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_ambulance_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_ambulance_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_ambulance_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_ambulance_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_ambulance_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_ambulance_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_ambulance_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_ambulance_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_ambulance_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_ambulance_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_ambulance_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_ambulance_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_ambulance_day'] }}</span>
                    </div>
                </div>
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell2">Avg Time In Dept(Min)</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_ambulance_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_ambulance_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_ambulance_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_ambulance_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_ambulance_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_ambulance_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_ambulance_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_ambulance_day_in_minutes'] }}</span>
                    </div>
                </div>
            </div>
            <div class="attendTableRow inBody">
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell1">Avg Walk-In Arrivals</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_walkin_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_walkin_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_walkin_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_walkin_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_walkin_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_walkin_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_walkin_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_walkin_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_walkin_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_walkin_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_walkin_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_walkin_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_walkin_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_walkin_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_walkin_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_walkin_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_walkin_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_walkin_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_walkin_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_walkin_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_walkin_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_walkin_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_walkin_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_walkin_day'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_walkin_day']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_walkin_day'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_walkin_day'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_walkin_day'] }}</span>
                    </div>
                </div>
                <div class="atTbleBodyRow">
                    <div class="columnFirst">
                        <div class="attendanceTableBodyFirstClm">
                            <span class="cell cell2">Avg Time In Dept(Min)</span>
                        </div>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_walkin_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['monday']['green']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['monday']['red']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['monday']['blue']['box_plot_average_walkin_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_walkin_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['tuesday']['green']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['tuesday']['red']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['tuesday']['blue']['box_plot_average_walkin_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_walkin_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['wednesday']['green']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['wednesday']['red']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['wednesday']['blue']['box_plot_average_walkin_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_walkin_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['thursday']['green']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['thursday']['red']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['thursday']['blue']['box_plot_average_walkin_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_walkin_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['friday']['green']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['friday']['red']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['friday']['blue']['box_plot_average_walkin_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_walkin_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['saturday']['green']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['saturday']['red']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['saturday']['blue']['box_plot_average_walkin_day_in_minutes'] }}</span>
                    </div>
                    <div class="column">
                        @if (isset($success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_walkin_day_in_minutes']))
                            <span class="box bgCol1">{{ $success_array['current_week_box_plot_data']['sunday']['green']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @else
                            <span class="box bgCol3">{{ $success_array['current_week_box_plot_data']['sunday']['red']['box_plot_average_walkin_day_in_minutes'] }}</span>
                        @endif
                        <span class="box bgCol2">{{ $success_array['current_week_box_plot_data']['sunday']['blue']['box_plot_average_walkin_day_in_minutes'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var data = [
        [{
                y: <?php echo $success_array['box_plot_graph_green_data']; ?>,
                x: ["Monday", "Monday", "Monday", "Monday", "Monday", "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Thursday", "Thursday", "Thursday", "Thursday", "Thursday", "Friday", "Friday", "Friday", "Friday", "Friday", "Saturday", "Saturday", "Saturday", "Saturday", "Saturday", "Sunday", "Sunday", "Sunday", "Sunday", "Sunday", ],
                marker: {
                    color: "#2fb07d",
                    outliercolor: "#2fb07d",
                    opacity: 1,
                },
                fillcolor: "#2fb07d",
                type: "box",
                name: ''
            },
            {
                y: <?php echo $success_array['box_plot_graph_blue_data']; ?>,
                x: ["Monday", "Monday", "Monday", "Monday", "Monday", "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Thursday", "Thursday", "Thursday", "Thursday", "Thursday", "Friday", "Friday", "Friday", "Friday", "Friday", "Saturday", "Saturday", "Saturday", "Saturday", "Saturday", "Sunday", "Sunday", "Sunday", "Sunday", "Sunday", ],
                marker: {
                    color: "#2471a3",
                    outliercolor: "#2471a3",
                    opacity: 1,
                },
                fillcolor: "#2471a3",
                hover_data: ["continent", "pop", "sdf", "SDf", "SDf"],
                type: "box",
                name: ''
            },
            {
                y: <?php echo $success_array['box_plot_graph_red_data']; ?>,
                x: ["Monday", "Monday", "Monday", "Monday", "Monday", "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Thursday", "Thursday", "Thursday", "Thursday", "Thursday", "Friday", "Friday", "Friday", "Friday", "Friday", "Saturday", "Saturday", "Saturday", "Saturday", "Saturday", "Sunday", "Sunday", "Sunday", "Sunday", "Sunday", ],
                marker: {
                    color: "#e53935",
                    outliercolor: "#e53935",
                    opacity: 1,
                },
                fillcolor: "#e53935",
                type: "box",
                name: ''
            },
        ],
    ];

    var GroupedBoxplotChartDaySummary = data[0];
    var layout = {
        xaxis: {
            visible: true,
            color: '#000',
            fixedrange: true
        },
        showlegend: false,
        yaxis: {
            title: 'Time',
            zeroline: false,
            rangemode: 'tozero',
            fixedrange: true
        },
        boxmode: "group",
        height: 265,
        margin: {
            l: 60,
            r: 0,
            t: 5,
            b: 25
        },
        autosize: true,
        opacity: 1,
        hovermode: "x unified",
    };
    var config = {
        responsive: true
    };

    Plotly.newPlot("GroupedBoxplotChartDaySummary", GroupedBoxplotChartDaySummary, layout, config);

    function EdOverviewLoadAfterScriptGraphDaySummary() {
        Plotly.newPlot("GroupedBoxplotChartDaySummary", GroupedBoxplotChartDaySummary, layout, config);
    }
</script>

