<script src="{{ url('asset_v2/Generic/Js/d3.v7.min.js') }}" charset="utf-8"></script>
<script src="{{ url('asset_v2/Generic/Js/billboard.js') }}" charset="utf-8"></script>
<link href="{{ asset('asset_v2/Generic/Css/daterangepicker.css') }}" rel="stylesheet" />

<div class="row ed-activity-top-row">
    <div class="col-xxl-8 left-area pe-xxl-0">

        <div class="row gx-2 align-items-center">
            <div class="col-xl-4 col-lg-6 mb-2">
                <div class="ed-activity-greybox">
                    <div class="row gx-2 align-items-center">
                        <div class="col-1  text-center">
                            <div class="cyan-circle text-center ">
                                <svg xmlns="http://www.w3.org/2000/svg" id="calendar-svgrepo-com" width="20" height="20" viewBox="0 0 21.687 20.584">
                                    <g id="Group_1737" data-name="Group 1737" transform="translate(0 0)">
                                        <circle id="Ellipse_156" data-name="Ellipse 156" cx="0.907" cy="0.907" r="0.907" transform="translate(4.617 8.004)" fill="#fff">
                                        </circle>
                                        <circle id="Ellipse_157" data-name="Ellipse 157" cx="0.907" cy="0.907" r="0.907" transform="translate(9.916 8.004)" fill="#fff">
                                        </circle>
                                        <circle id="Ellipse_158" data-name="Ellipse 158" cx="0.907" cy="0.907" r="0.907" transform="translate(15.21 8.004)" fill="#fff">
                                        </circle>
                                        <circle id="Ellipse_159" data-name="Ellipse 159" cx="0.907" cy="0.907" r="0.907" transform="translate(4.617 14.13)" fill="#fff">
                                        </circle>
                                        <circle id="Ellipse_160" data-name="Ellipse 160" cx="0.907" cy="0.907" r="0.907" transform="translate(9.916 14.13)" fill="#fff">
                                        </circle>
                                        <circle id="Ellipse_161" data-name="Ellipse 161" cx="0.907" cy="0.907" r="0.907" transform="translate(15.21 14.13)" fill="#fff">
                                        </circle>
                                        <path id="Path_20674" data-name="Path 20674" d="M20.77,14.336H18.606v-.965a.921.921,0,0,0-1.842,0v.965H4.883v-.965a.921.921,0,0,0-1.842,0v.965H.921A.926.926,0,0,0,0,15.257V32.114a.926.926,0,0,0,.921.921h19.8a.96.96,0,0,0,.965-.921V15.257A.919.919,0,0,0,20.77,14.336Zm-.921,16.9H1.8V16.182H3.041v.691a.921.921,0,0,0,1.842,0v-.691H16.764v.691a.926.926,0,0,0,.921.921.989.989,0,0,0,.921-.921v-.691h1.244Z" transform="translate(0 -12.45)" fill="#fff">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                        </div>

                        <div class="col-11 ps-3">
                            <div class="date-box">

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-3 mb-2 ">
                <div class="ed-activity-greybox">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-3  text-lg-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 37.113 37.355">
                                <path id="user-nurse-svgrepo-com" d="M28.41,22.387c-.034-.015-.066-.031-.1-.044-.257-.116-.511-.237-.774-.342A11.2,11.2,0,1,0,13.7,22c-.263.1-.517.226-.774.342-.035.013-.066.029-.1.044A18.568,18.568,0,0,0,2.071,37.276a1.867,1.867,0,0,0,3.712.4A14.833,14.833,0,0,1,13.227,26.37l6.07,6.07a1.866,1.866,0,0,0,2.64,0l6.07-6.07A14.833,14.833,0,0,1,35.45,37.681,1.867,1.867,0,0,0,37.3,39.345a1.957,1.957,0,0,0,.205-.011,1.867,1.867,0,0,0,1.654-2.058A18.568,18.568,0,0,0,28.41,22.387ZM13.226,12.452a7.425,7.425,0,0,1,14.782,0ZM20.617,28.48,17,24.864a14.625,14.625,0,0,1,7.232,0Zm0-7.8a7.473,7.473,0,0,1-6.84-4.491H27.457a7.473,7.473,0,0,1-6.84,4.491Z" transform="translate(-2.06 -1.991)"></path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-6 pt-1 pt-lg-0">
                            <h6 class="mb-0 ms-md-2 ">ATTENDANCE <br>TOTAL
                            </h6>
                        </div>
                        <div class="col-lg-4 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array['attendence_total'] }}</h5>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-lg-3 mb-2 ">
                <div class="ed-activity-greybox">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-2 col-3  text-lg-center">
                            <svg xmlns="http://www.w3.org/2000/svg" id="close-svgrepo-com" width="30" height="30" viewBox="0 0 44.233 44.233">
                                <path id="Path_20664" data-name="Path 20664" d="M22.117,0A22.117,22.117,0,1,0,44.233,22.117,22.142,22.142,0,0,0,22.117,0Zm0,41.074A18.957,18.957,0,1,1,41.074,22.117,18.979,18.979,0,0,1,22.117,41.074Z" transform="translate(0 0)"></path>
                                <path id="Path_20665" data-name="Path 20665" d="M98.769,85.214a1.58,1.58,0,0,0-2.234,0l-4.543,4.543-4.544-4.544a1.58,1.58,0,0,0-2.234,2.234l4.544,4.544-4.544,4.544a1.58,1.58,0,0,0,2.234,2.234l4.544-4.544,4.544,4.544a1.58,1.58,0,0,0,2.234-2.234l-4.544-4.544,4.544-4.544A1.58,1.58,0,0,0,98.769,85.214Z" transform="translate(-69.875 -69.875)"></path>
                            </svg>
                        </div>
                        <div class="col-lg-6 col-6 pt-1 pt-lg-0">
                            <h6 class="mb-0 ms-md-2 ">BREACHES<br>TOTAL </h6>
                        </div>
                        <div class="col-lg-4 col-3 text-center">
                            <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array['breaches'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="col-xxl-4 mb-2 right-area">
        <div class="ed-activity-greybox">
            <div class="row gx-2 align-items-center">
                <div class="col-lg-2 col-3 text-lg-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 41.846 41.846">
                        <g id="Group_1714" data-name="Group 1714" transform="translate(1.5 1.5)">
                            <path id="Path_20662" data-name="Path 20662" d="M33.157,6.612a19.414,19.414,0,1,0,7.111,7.136" transform="translate(-4 -4)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                            </path>
                            <path id="Path_20663" data-name="Path 20663" d="M31.61,16.05s-3.29,8.784-4.807,10.3a3.885,3.885,0,1,1-5.494-5.494C22.826,19.34,31.61,16.05,31.61,16.05Z" transform="translate(-4.466 -4.347)" fill="none" stroke="#000" stroke-linejoin="round" stroke-width="3">
                            </path>
                        </g>
                    </svg>
                </div>
                <div class="col-lg-6 col-6  pt-1 pt-lg-0">
                    <h6 class="mb-0 ms-md-2 ">PERFORMANCE <br>OVERALL <br class="d-none d-md-block"> </h6>
                </div>
                <div class="col-lg-4 col-3 text-center">
                    <h5 class="fw-bold fs-lg-4 mb-0 ">{{ $success_array['performance_overall'] }}%</h5>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="Ibox_AEAdminApp_wrap EDActivityouter">
    <div class="EDActivityinner">
        <div class="row EDActivityinnerRow">
            <div class="col-xxl-8 sideLft">


                <div class="EDActivityGraphWrap"  id="EDActivityGraphWrap">
                    <span class="overlaySelectionBox" style="top:40px"></span>


                    <div class="FixedTabletop">
                        <div class="box heatMeaterBubbleBoxWrap scroll_part" >
                            <div class="leftSide" id="leftSecDiv">
                                <ul class="leftHeadList">
                                    <li class="bgcol7 hourBtn activeRowRemovecell">
                                        Hour
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" size="16" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M459.15 269.75a133.197 133.197 0 0 1-55.862 179.975l-42.782 22.541-10.52 5.533a71.277 71.277 0 0 1-62.966 1.685l-167.077-71.38 15.733-46.676 99.363 19.194-51.458-97.78-82.843-157.411 40.357-21.232 82.844 157.457 19.934-10.485-36.521-69.445 40.335-21.22 36.52 69.445 19.935-10.485-28.2-53.598 40.358-21.232 28.2 53.598 19.945-10.576-19.354-36.886 40.346-21.174 19.354 36.885 54.348 103.301zM73.268 146.674a60.03 60.03 0 0 1 42.361-102.459 60.098 60.098 0 0 1 56.58 80.169l10.588 20.013A78.29 78.29 0 0 0 115.708 26a78.233 78.233 0 0 0-5.635 156.262L99.428 162.02a59.688 59.688 0 0 1-26.16-15.346z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="bgcol2">Arrivals</li>
                                    <li class="bgcol4">Left ED</li>
                                    <li class="bgcol3">Still in ED</li>
                                    <li class="bgcol5">Breaches</li>
                                    <li class="bgcol5">Perfrormance</li>
                                </ul>
                            </div>
                            <div class="rightSide">
                                <ul class="bubbleList head EDactivityRowClickTriggerList">
                                    <li class='clickedHour'>00</li>
                                    <li class='clickedHour'>01</li>
                                    <li class='clickedHour'>02</li>
                                    <li class='clickedHour'>03</li>
                                    <li class='clickedHour'>04</li>
                                    <li class='clickedHour'>05</li>
                                    <li class='clickedHour'>06</li>
                                    <li class='clickedHour'>07</li>
                                    <li class='clickedHour'>08</li>
                                    <li class='clickedHour'>09</li>
                                    <li class='clickedHour'>10</li>
                                    <li class='clickedHour'>11</li>
                                    <li class='clickedHour'>12</li>
                                    <li class='clickedHour'>13</li>
                                    <li class='clickedHour'>14</li>
                                    <li class='clickedHour'>15</li>
                                    <li class='clickedHour'>16</li>
                                    <li class='clickedHour'>17</li>
                                    <li class='clickedHour'>18</li>
                                    <li class='clickedHour'>19</li>
                                    <li class='clickedHour'>20</li>
                                    <li class='clickedHour'>21</li>
                                    <li class='clickedHour'>22</li>
                                    <li class='clickedHour'>23</li>
                                </ul>
                                @if (isset($success_array['top_hour_data']) && count($success_array['top_hour_data']) > 0)
                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_arrivals'], $success_array['ane_attendance_arrivals_top_hour_data_min'], $success_array['ane_attendance_arrivals_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_arrivals'] }}</li>
                                        @endforeach
                                    </ul>

                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_left_ed'], $success_array['ane_attendance_left_ed_top_hour_data_min'], $success_array['ane_attendance_left_ed_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_left_ed'] }}</li>
                                        @endforeach
                                    </ul>

                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_still_in_ed'], $success_array['ane_attendance_still_in_ed_top_hour_data_min'], $success_array['ane_attendance_still_in_ed_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_still_in_ed'] }}</li>
                                        @endforeach
                                    </ul>

                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_breaches'], $success_array['ane_attendance_breaches_top_hour_data_min'], $success_array['ane_attendance_breaches_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_breaches'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ HeatMapColourMakerFromMaxMinPerformance($row['ane_attendance_performance']) }}">
                                                {{ $row['ane_attendance_performance'] }}%</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="chart-box pt-2">
                        <div class="bg-ed-legends ms-2 me-2">
                            <div class="row gx-2">
                                <div class="col-md-3 col-6 mb-2 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-ed-legends-blue-box "></div>
                                        <h6 class="mb-0">BELOW AVERAGE</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-2 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-ed-legends-cyan-box "></div>
                                        <h6 class="mb-0">AVERAGE</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-ed-legends-maroon-box "></div>
                                        <h6 class="mb-0">ABOVE AVERAGE</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-ed-legends-purple-box "></div>
                                        <h6 class="mb-0">HIGH</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box heatMeaterBubbleBoxWrap">
                            <div class="leftSide leftcolorDiv sdfsdf" id="leftSecDiv">
                                <ul class="leftHeadList">
                                    <li class="bgcol7 hourBtn activeRowRemovecell">
                                        Hour<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" size="16" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M459.15 269.75a133.197 133.197 0 0 1-55.862 179.975l-42.782 22.541-10.52 5.533a71.277 71.277 0 0 1-62.966 1.685l-167.077-71.38 15.733-46.676 99.363 19.194-51.458-97.78-82.843-157.411 40.357-21.232 82.844 157.457 19.934-10.485-36.521-69.445 40.335-21.22 36.52 69.445 19.935-10.485-28.2-53.598 40.358-21.232 28.2 53.598 19.945-10.576-19.354-36.886 40.346-21.174 19.354 36.885 54.348 103.301zM73.268 146.674a60.03 60.03 0 0 1 42.361-102.459 60.098 60.098 0 0 1 56.58 80.169l10.588 20.013A78.29 78.29 0 0 0 115.708 26a78.233 78.233 0 0 0-5.635 156.262L99.428 162.02a59.688 59.688 0 0 1-26.16-15.346z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="bgcol2">Arrivals</li>
                                    <li class="bgcol4">Left ED</li>
                                    <li class="bgcol3">Still in ED</li>
                                    <li class="bgcol5">Breaches</li>
                                    <li class="bgcol5">Performance</li>
                                </ul>
                            </div>
                            <div class="rightSide">
                                <ul class="bubbleList head EDactivityRowClickTriggerList">
                                    <li class="clickedHour">00</li>
                                    <li class="clickedHour">01</li>
                                    <li class="clickedHour">02</li>
                                    <li class="clickedHour">03</li>
                                    <li class="clickedHour">04</li>
                                    <li class="clickedHour">05</li>
                                    <li class="clickedHour">06</li>
                                    <li class="clickedHour">07</li>
                                    <li class="clickedHour">08</li>
                                    <li class="clickedHour">09</li>
                                    <li class="clickedHour">10</li>
                                    <li class="clickedHour">11</li>
                                    <li class="clickedHour">12</li>
                                    <li class="clickedHour">13</li>
                                    <li class="clickedHour">14</li>
                                    <li class="clickedHour">15</li>
                                    <li class="clickedHour">16</li>
                                    <li class="clickedHour">17</li>
                                    <li class="clickedHour">18</li>
                                    <li class="clickedHour">19</li>
                                    <li class="clickedHour">20</li>
                                    <li class="clickedHour">21</li>
                                    <li class="clickedHour">22</li>
                                    <li class="clickedHour">23</li>
                                </ul>
                                @if (isset($success_array['top_hour_data']) && count($success_array['top_hour_data']) > 0)
                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_arrivals'], $success_array['ane_attendance_arrivals_top_hour_data_min'], $success_array['ane_attendance_arrivals_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_arrivals'] }}</li>
                                        @endforeach
                                    </ul>

                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_left_ed'], $success_array['ane_attendance_left_ed_top_hour_data_min'], $success_array['ane_attendance_left_ed_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_left_ed'] }}</li>
                                        @endforeach
                                    </ul>

                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_still_in_ed'], $success_array['ane_attendance_still_in_ed_top_hour_data_min'], $success_array['ane_attendance_still_in_ed_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_still_in_ed'] }}</li>
                                        @endforeach
                                    </ul>

                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_breaches'], $success_array['ane_attendance_breaches_top_hour_data_min'], $success_array['ane_attendance_breaches_top_hour_data_max']) }}">
                                                {{ $row['ane_attendance_breaches'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['top_hour_data'] as $row)
                                            <li class="{{ HeatMapColourMakerFromMaxMinPerformance($row['ane_attendance_performance']) }}">
                                                {{ $row['ane_attendance_performance'] }}%</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>




                    <div class="PatientPerHourChartArea">
                        <div class="topHeadArea">
                            <div class="headSection">
                                <span class="imgWrap"><img src="{{ asset('asset_v2/Template') }}/images/twent_four_hour.png" alt=""></span>
                                <h3 class="head">Patients per hour<span>Status</span></h3>
                            </div>

                        </div>
                        <div class="stackedBarChartWrapouter">
                            <div class="leftTitleSec">
                                <span class="axisLabel">Arrivals</span><span class="axisLabel" style='width:100px;'>Left ED</span>
                            </div>
                            <div class="StackedBarchartGroupwrap">
                                <div id="StackedBarchartBarMirror"></div>
                            </div>
                        </div>
                    </div>


                   <div class="chart-box">
                       <div class="boxWrapper">
                           <div class="header-chart">
                               <h6 class="title">Arrival Method</h6>
                           </div>
                           <div class="box heatMeaterBubbleBoxWrap commonTablebubble arrivalMethodTable">
                               <div class="leftSide">
                                   <ul class="leftHeadList">
                                       <li class="bgcol2">Ambulance</li>
                                       <li class="bgcol4">Walk In</li>
                                   </ul>
                               </div>
                               <div class="rightSide">
                                   @if (isset($success_array['arrival_method']) && count($success_array['arrival_method']) > 0)
                                       <ul class="bubbleList">
                                           @foreach ($success_array['arrival_method'] as $row)
                                               <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_ambulance'], $success_array['ane_attendance_ambulance_arrival_method_min'], $success_array['ane_attendance_ambulance_arrival_method_max']) }}">
                                                   {{ $row['ane_attendance_ambulance'] }}</li>
                                           @endforeach
                                       </ul>
                                       <ul class="bubbleList">
                                           @foreach ($success_array['arrival_method'] as $row)
                                               <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ane_attendance_walk_in'], $success_array['ane_attendance_walk_in_arrival_method_min'], $success_array['ane_attendance_walk_in_arrival_method_max']) }}">
                                                   {{ $row['ane_attendance_walk_in'] }}</li>
                                           @endforeach
                                       </ul>
                                   @endif
                               </div>
                           </div>
                       </div>
                   </div>




                    <div class="chart-box">
                        <div class="boxWrapper">
                        <div class="header-chart">
                            <h6 class="title">Triage Category</h6>
                        </div>


                        <div class="box heatMeaterBubbleBoxWrap commonTablebubble arrivalMethodTable">
                            <div class="leftSide">
                                <ul class="leftHeadList">
                                    <li class="bgcol2">1</li>
                                    <li class="bgcol2">2</li>
                                    <li class="bgcol4">3</li>
                                    <li class="bgcol4">4</li>
                                    <li class="bgcol4">5</li>
                                </ul>
                            </div>
                            <div class="rightSide">
                                @if (isset($success_array['triage_cat']) && count($success_array['triage_cat']) > 0)
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_cat'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_category_1'], $success_array['triage_category_1_triage_cat_min'], $success_array['triage_category_1_triage_cat_max']) }}">
                                                {{ $row['triage_category_1'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_cat'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_category_2'], $success_array['triage_category_2_triage_cat_min'], $success_array['triage_category_2_triage_cat_max']) }}">
                                                {{ $row['triage_category_2'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_cat'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_category_3'], $success_array['triage_category_3_triage_cat_min'], $success_array['triage_category_3_triage_cat_max']) }}">
                                                {{ $row['triage_category_3'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_cat'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_category_4'], $success_array['triage_category_4_triage_cat_min'], $success_array['triage_category_4_triage_cat_max']) }}">
                                                {{ $row['triage_category_4'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_cat'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_category_5'], $success_array['triage_category_5_triage_cat_min'], $success_array['triage_category_5_triage_cat_max']) }}">
                                                {{ $row['triage_category_5'] }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>




                    <div class="chart-box">

                        <div class="boxWrapper">
                            <div class="header-chart">
                                <h6 class="title">Patients Still In ED</h6>
                            </div>

                            <div class="box heatMeaterBubbleBoxWrap commonTablebubble patientStillinEd">
                                <div class="leftSide">
                                    <ul class="leftHeadList">
                                        <li class="bgcol2">UTC</li>
                                        <li class="bgcol4">Majors</li>
                                        <li class="bgcol4">Resus</li>
                                        <li class="bgcol2">Paeds</li>
                                        <li class="bgcol2">Others</li>
                                    </ul>
                                </div>

                                <div class="rightSide">
                                    @if (isset($success_array['patients_still_in_ed']) && count($success_array['patients_still_in_ed']) > 0)
                                        <ul class="bubbleList">
                                            @foreach ($success_array['patients_still_in_ed'] as $row)
                                                <li class="{{ NewHeatMapColourMakerFromMaxMin($row['still_in_ae_utc'], $success_array['still_in_ae_utc_patients_still_in_ed_min'], $success_array['still_in_ae_utc_patients_still_in_ed_max']) }}">
                                                    {{ $row['still_in_ae_utc'] }}</li>
                                            @endforeach
                                        </ul>
                                        <ul class="bubbleList">
                                            @foreach ($success_array['patients_still_in_ed'] as $row)
                                                <li class="{{ NewHeatMapColourMakerFromMaxMin($row['still_in_ae_majors'], $success_array['still_in_ae_majors_patients_still_in_ed_min'], $success_array['still_in_ae_majors_patients_still_in_ed_max']) }}">
                                                    {{ $row['still_in_ae_majors'] }}</li>
                                            @endforeach
                                        </ul>
                                        <ul class="bubbleList">
                                            @foreach ($success_array['patients_still_in_ed'] as $row)
                                                <li class="{{ NewHeatMapColourMakerFromMaxMin($row['still_in_ae_resus'], $success_array['still_in_ae_resus_patients_still_in_ed_min'], $success_array['still_in_ae_resus_patients_still_in_ed_max']) }}">
                                                    {{ $row['still_in_ae_resus'] }}</li>
                                            @endforeach
                                        </ul>
                                        <ul class="bubbleList">
                                            @foreach ($success_array['patients_still_in_ed'] as $row)
                                                <li class="{{ NewHeatMapColourMakerFromMaxMin($row['still_in_ae_paed_eds'], $success_array['still_in_ae_paed_eds_patients_still_in_ed_min'], $success_array['still_in_ae_paed_eds_patients_still_in_ed_max']) }}">
                                                    {{ $row['still_in_ae_paed_eds'] }}</li>
                                            @endforeach
                                        </ul>
                                        <ul class="bubbleList">
                                            @foreach ($success_array['patients_still_in_ed'] as $row)
                                                <li class="{{ NewHeatMapColourMakerFromMaxMin($row['still_in_ae_others'], $success_array['still_in_ae_others_patients_still_in_ed_min'], $success_array['still_in_ae_others_patients_still_in_ed_max']) }}">
                                                    {{ $row['still_in_ae_others'] }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>


{{--                   <div class="chart-box">--}}
{{--                       <div class="boxWrapper">--}}

{{--                           <div class="header-chart">--}}
{{--                               <h6 class="title">Target Times</h6>--}}
{{--                           </div>--}}

{{--                           <div class="box heatMeaterBubbleBoxWrap commonTablebubble TriageBoxTable">--}}
{{--                               <div class="leftSide">--}}
{{--                                   <ul class="leftHeadList">--}}
{{--                                       <li class="leftside-target-bg-ed">--}}
{{--                                           <span class="headLabel ">Triage &gt; 15 Mins</span>--}}
{{--                                       </li>--}}
{{--                                       <li class="leftside-target-bg-ed">--}}
{{--                                           <span class="headLabel ">ED Clinician &gt; 60 Mins</span>--}}
{{--                                       </li>--}}
{{--                                       <li class="leftside-target-bg-ed">--}}
{{--                                           <span class="headLabel ">Spec Dr &gt; 60 Mins</span>--}}
{{--                                       </li>--}}
{{--                                   </ul>--}}
{{--                               </div>--}}
{{--                               <div class="rightSide">--}}
{{--                                   <div class="listWrap">--}}
{{--                                       @if (isset($success_array['target_times']) && count($success_array['target_times']) > 0)--}}
{{--                                           <div class="listWrap">--}}
{{--                                               <ul class="bubbleList">--}}
{{--                                                   @foreach ($success_array['target_times'] as $row)--}}
{{--                                                       <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage'], $success_array['triage_target_times_min'], $success_array['triage_target_times_max']) }}">--}}
{{--                                                           {{ $row['triage'] }}</li>--}}
{{--                                                   @endforeach--}}
{{--                                               </ul>--}}
{{--                                               <ul class="bubbleList">--}}
{{--                                                   @foreach ($success_array['target_times'] as $row)--}}
{{--                                                       <li>{{ $row['triage_longer_time'] }}</li>--}}
{{--                                                   @endforeach--}}
{{--                                               </ul>--}}
{{--                                           </div>--}}
{{--                                           <div class="listWrap">--}}
{{--                                               <ul class="bubbleList">--}}
{{--                                                   @foreach ($success_array['target_times'] as $row)--}}
{{--                                                       <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ed_clinician'], $success_array['ed_clinician_target_times_min'], $success_array['ed_clinician_target_times_max']) }}">--}}
{{--                                                           {{ $row['ed_clinician'] }}</li>--}}
{{--                                                   @endforeach--}}
{{--                                               </ul>--}}

{{--                                               <ul class="bubbleList">--}}
{{--                                                   @foreach ($success_array['target_times'] as $row)--}}
{{--                                                       <li>{{ $row['ed_clinician_longer_time'] }}</li>--}}
{{--                                                   @endforeach--}}
{{--                                               </ul>--}}
{{--                                           </div>--}}
{{--                                           <div class="listWrap">--}}
{{--                                               <ul class="bubbleList">--}}
{{--                                                   @foreach ($success_array['target_times'] as $row)--}}
{{--                                                       <li class="{{ NewHeatMapColourMakerFromMaxMin($row['speciality_doctor'], $success_array['speciality_doctor_target_times_min'], $success_array['speciality_doctor_target_times_max']) }}">--}}
{{--                                                           {{ $row['speciality_doctor'] }}</li>--}}
{{--                                                   @endforeach--}}
{{--                                               </ul>--}}
{{--                                               <ul class="bubbleList">--}}
{{--                                                   @foreach ($success_array['target_times'] as $row)--}}
{{--                                                       <li>{{ $row['speciality_doctor_longer_time'] }}</li>--}}
{{--                                                   @endforeach--}}
{{--                                               </ul>--}}
{{--                                           </div>--}}
{{--                                       @endif--}}
{{--                                   </div>--}}
{{--                               </div>--}}
{{--                           </div>--}}
{{--                       </div>--}}
{{--                   </div>--}}


                    <div class="chart-box">
                        <div class="header-chart">
                            <h6 class="title">Triage</h6>
                        </div>
                        <div class="boxWrapper">

                            <div class="box heatMeaterBubbleBoxWrap commonTablebubble patientStillinEd">
                                <div class="leftSide">
                                    <ul class="leftHeadList">
                                        <li>
                                            <span class="headLabel">Patients Seen </span>
                                        </li>
                                        <li>
                                            <span class="headLabel">&gt; 15 Mins</span>
                                        </li>
                                        <li>
                                            <span class="headLabel">Avg Time</span>
                                        </li>
                                        <li>
                                            <span class="headLabel">Longest Wait </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="rightSide">
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_patients_seen'], $success_array['triage_patients_seen_triage_times_min'], $success_array['triage_patients_seen_triage_times_max']) }}">
                                                {{ $row['triage_patients_seen'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_greater_than'], $success_array['triage_greater_than_triage_times_min'], $success_array['triage_greater_than_triage_times_max']) }}">
                                                {{ $row['triage_greater_than'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_avg_time'], $success_array['triage_avg_time_triage_times_min'], $success_array['triage_avg_time_triage_times_max']) }}">
                                                {{ $row['triage_avg_time'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['triage_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['triage_longer_time'], $success_array['triage_longer_time_triage_times_min'], $success_array['triage_longer_time_triage_times_max']) }}">
                                                {{ $row['triage_longer_time'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart-box">
                        <div class="header-chart">
                            <h6 class="title">ED Clinician</h6>
                        </div>
                        <div class="boxWrapper">

                            <div class="box heatMeaterBubbleBoxWrap commonTablebubble patientStillinEd">
                                <div class="leftSide">
                                    <ul class="leftHeadList">
                                        <li>
                                            <span class="headLabel">Patients Seen </span>
                                        </li>
                                        <li>
                                            <span class="headLabel">&gt; 60 Mins</span>
                                        </li>
                                        <li>
                                            <span class="headLabel">Avg Time</span>
                                        </li>
                                        <li>
                                            <span class="headLabel">Longest Wait </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="rightSide">
                                    <ul class="bubbleList">
                                        @foreach ($success_array['ed_clinician_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ed_clinician_patients_seen'], $success_array['ed_clinician_patients_seen_ed_clinician_times_min'], $success_array['ed_clinician_patients_seen_ed_clinician_times_max']) }}">
                                                {{ $row['ed_clinician_patients_seen'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['ed_clinician_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ed_clinician_greater_than'], $success_array['ed_clinician_greater_than_ed_clinician_times_min'], $success_array['ed_clinician_greater_than_ed_clinician_times_max']) }}">
                                                {{ $row['ed_clinician_greater_than'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['ed_clinician_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ed_clinician_avg_time'], $success_array['ed_clinician_avg_time_ed_clinician_times_min'], $success_array['ed_clinician_avg_time_ed_clinician_times_max']) }}">
                                                {{ $row['ed_clinician_avg_time'] }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="bubbleList">
                                        @foreach ($success_array['ed_clinician_times'] as $row)
                                            <li class="{{ NewHeatMapColourMakerFromMaxMin($row['ed_clinician_longer_time'], $success_array['ed_clinician_longer_time_ed_clinician_times_min'], $success_array['ed_clinician_longer_time_ed_clinician_times_max']) }}">
                                                {{ $row['ed_clinician_longer_time'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="chart-box">
                        <div class="boxWrapper">
                            <div class="header-chart">
                                <h6 class="title">DTA</h6>
                            </div>
                            <div class="DTABoxinner">
                                <div class="box heatMeaterBubbleBoxWrap DTABoxTable">
                                    <div class="leftSide">
                                        <ul class="leftHeadList">
                                            <li>Total Patients</li>
                                            <li>Assigned</li>
                                       </ul>
                                    </div>
                                    <div class="rightSide">
                                        @if (isset($success_array['dta']) && count($success_array['dta']) > 0)
                                            <ul class="bubbleList">
                                                @foreach ($success_array['dta'] as $row)
                                                    <li class="{{ NewHeatMapColourMakerFromMaxMin($row['dta_total_patient'], $success_array['dta_total_patient_dta_min'], $success_array['dta_total_patient_dta_max']) }}">
                                                        {{ $row['dta_total_patient'] }}</li>
                                                @endforeach
                                            </ul>
                                            <ul class="bubbleList">
                                                @foreach ($success_array['dta'] as $row)
                                                    <li class="{{ NewHeatMapColourMakerFromMaxMin($row['dta_assigned_patient'], $success_array['dta_assigned_patient_dta_min'], $success_array['dta_assigned_patient_dta_max']) }}">
                                                        {{ $row['dta_assigned_patient'] }}</li>
                                                @endforeach
                                            </ul>

                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="col-xxl-4 sideRgt" id="charts-card">
                @include('Dashboards.Symphony.ActivityProfile.ContentDataLoadRightMatrix')
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="start_date" id="date_picker_6_start_date" value="{{ request()->filter_value_start}}">
<input type="hidden" name="end_date" id="date_picker_6_end_date" value="{{ request()->filter_value_end}}">


<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>

<script>

    function EdActivityDataLoadBlade(filter_value_start, filter_value_end) {
        if (typeof EdActivityChartApexChartDestroy == "function") {
            EdActivityChartApexChartDestroy();
        }
        $('.all_tab_content_loader_image').show();
        $('.ed_activity_content_data_load').hide();
        $('.ed_activity_content_data_load').html('');
        $.ajax({
            url: "{{ url('/ane/dashboards/activity-profile/content-data-load') }}",
            type: 'POST',
            data: {
                "_token": tok,
                "filter_value_start": filter_value_start,
                "filter_value_end": filter_value_end,
            },
            success: function(page_load_data) {
                $('.ed_activity_content_data_load').show();
                setTimeout(function() {
                    $('.ed_activity_content_data_load').html(page_load_data);
                    $('.all_tab_content_loader_image').hide();
                    $('.ed_activity_content_data_load').show();

                    EdActivityChartLoadAfterScriptGraph();
                }, 100);
            },
            error: function(textStatus, errorThrown) {
                $('.all_tab_content_loader_image').hide();
                $('.ed_activity_content_data_load').html('');
                CommonErrorModalPopupOpen();
            }
        });
    }
    @if(request()->filled('filter_value_start') && request()->filled('filter_value_end'))
        var start = moment('{{request()->filter_value_start}}', 'YYYY-MM-DD');
        var end = moment('{{request()->filter_value_end}}', 'YYYY-MM-DD');
    @else

        var start = moment().endOf('day');
        var end = moment().endOf('day');
    @endif

    function cb(start, end) {
        $('.date-box').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#date_picker_6_start_date').val(start.format('YYYY-MM-DD'));
        $('#date_picker_6_end_date').val(end.format('YYYY-MM-DD'));
        if(start.format('YYYY-MM-DD') != '{{request()->filter_value_start}}' || end.format('YYYY-MM-DD') != '{{request()->filter_value_end}}'){
            EdActivityDataLoadBlade(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
        }
    }

    $('.date-box').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
        format: 'MMMM D, YYYY'},
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
</script>
<script>


    var chart = bb.generate({
        bindto: "#StackedBarchartBarMirror",
        data: {
            columns: [
                <?php echo $success_array['patient_per_hour_1']; ?>,
                <?php echo $success_array['patient_per_hour_2']; ?>,
                <?php echo $success_array['patient_per_hour_3']; ?>,
                <?php echo $success_array['patient_per_hour_4']; ?>
            ],
            types: {
                arrivals: "bar",
                leftED: "bar",
                forecast: "area-spline",
                admitted: "bar"
            },
            groups: [
                ["arrivals", "leftED", "admitted"]
            ],
            names: {
                arrivals: "Arrivals",
                leftED: "Discharge Outcome Home",
                forecast: "Arrivals Forecast",
                admitted: "Discharge Outcome Admitted"
            },
            colors: {
                arrivals: "#169ebe",
                leftED: "#4864a8",
                forecast: "#00c898",
                admitted: "#fea600"
            },
            labels: {
                show: true,
                format: function (v, id) {
                    if (id === 'forecast') {
                        return null;
                    }
                    if(Math.abs(v) > 4){
                        return Math.abs(v);
                    }

                }
            },
            order: null
        },
        axis: {
            x: {
                show: false
            },
            y: {
                show: true,
                tick: {
                    format: function() {
                        return '';
                    }
                }
            }
        },
        grid: {
            y: {
                lines: [{ value: 0 }]
            }
        },
        bar: {
            width: {
                ratio: 0.8
            }
        },
        size: {
            height: 500
        },
        padding: {
            bottom: 0,
            top: 70,
            left: 13,
            right: 6
        },
        tooltip: {
            format: {
                value: function(value, ratio, id, index) {
                    if (id === "breaches" && value === 0.1) {
                        return 0;
                    }
                    return value < 0 ? Math.abs(value) : value;
                }
            }
        },
        legend: {
            show: true
        },
         onrendered: function() {
            setTimeout(function() {
                document.querySelectorAll('.bb-texts-leftED text').forEach(el => {
                    el.setAttribute('y', parseFloat(el.getAttribute('y')) + 7);
                    el.style.fill = '#4864a8';
                });

                document.querySelectorAll('.bb-texts-admitted text').forEach(el => {
                    el.setAttribute('y', parseFloat(el.getAttribute('y')) + 5);
                    el.style.fill = '#fea600';
                });

                document.querySelectorAll('.bb-texts-arrivals text').forEach(el => {
                    el.setAttribute('y', parseFloat(el.getAttribute('y')) + 18);
                    el.style.fill = '#ffffff';
                });
            }, 200);
        }

    });


    if ($(".notification_text_top_header_marquee").length) {
        $(".activity_profile_fixed_top_matrix_on_scroll").addClass("top_message_scroll_bar_exist");
    }



</script>


<script>
    $(document).ready(function() {
        let fixedDivWidth = $(".EDActivityGraphWrap").innerWidth();
        $(".FixedTabletop").css("width", fixedDivWidth + "px");
    });

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 500) {
            $(".FixedTabletop").addClass("active");
            var marqueeContent = document.getElementById("marquee-content");
            if (marqueeContent) {

                if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

                } else {
                    $(".FixedTabletop").css("top", "85px");
                }

            }else{
                if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

                } else {
                    $(".FixedTabletop").css("top", "60px");
                }
            }

        } else {
            $(".FixedTabletop").removeClass("active");
        }
    });
    $(".EDactivityRowClickTriggerList li").on("click", function (e) {

        $(".overlaySelectionBox").css({
        left: this.offsetLeft + "px",
        display: "block",
        width: e.target.offsetWidth,
        transform: "translateX(" + ($(".leftcolorDiv").width() + 7) + "px)",
        });
    });

    $(".activeRowRemovecell").on("click", function () {
        $(".overlaySelectionBox").css("display", "none");
    });

    $(".dropDownNavTigger").on("click", function () {
        $(".CheckBoxWrapper").toggleClass("show");
    });

</script>


