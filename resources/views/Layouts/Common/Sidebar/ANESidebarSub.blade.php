
<!-- Sidebar Menu -->

<div class="sidebar-menu d-none d-lg-block" id="sidebar">
    <nav class="" id="navbar">
        <ul class="">
            <li class="nav-item cyan-border ">
                <a @if(Request::RouteIs('ane_home') || request()->has('favourites')) href="{{ route('home') }}" @else href="{{ route('ane_home') }}" @endif class="nav-link ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31.156 29.096"
                         fill="currentColor">
                        <g id="home-svgrepo-com" transform="translate(-0.946 -2.25)">
                            <path id="Path_22090" data-name="Path 22090" d="M31.048,22H2"
                                  transform="translate(0 8.596)" fill="none" stroke="currentColor"
                                  stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22091" data-name="Path 22091"
                                  d="M2,14.238,13.8,4.8a4.357,4.357,0,0,1,5.444,0l11.8,9.442"
                                  transform="translate(0 0.381)" fill="none" stroke="currentColor"
                                  stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22092" data-name="Path 22092"
                                  d="M15.5,6.631v-2.9A.726.726,0,0,1,16.226,3h3.631a.726.726,0,0,1,.726.726v7.262"
                                  transform="translate(6.107)" fill="none" stroke="currentColor"
                                  stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22093" data-name="Path 22093" d="M4,27.655V9.5"
                                  transform="translate(0.905 2.941)" fill="none" stroke="currentColor"
                                  stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22094" data-name="Path 22094" d="M20,27.655V9.5"
                                  transform="translate(8.143 2.941)" fill="none" stroke="currentColor"
                                  stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22095" data-name="Path 22095"
                                  d="M17.714,25.619V18.357c0-2.054,0-3.081-.638-3.719S15.411,14,13.357,14s-3.081,0-3.719.638S9,16.3,9,18.357v7.262"
                                  transform="translate(3.167 4.976)" fill="none" stroke="currentColor"
                                  stroke-width="1.5" />
                            <path id="Path_22096" data-name="Path 22096"
                                  d="M15.81,10.4a2.9,2.9,0,1,1-2.9-2.9A2.9,2.9,0,0,1,15.81,10.4Z"
                                  transform="translate(3.619 2.036)" fill="none" stroke="currentColor"
                                  stroke-width="1.5" />
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Home</span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('live_status_view')) class="nav-item cyan-border  {{ request()->is('ane/dashboards/accident-and-emergency') ? 'active' : '' }}"  @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('live_status_view')) href="{{ url('/ane/dashboards/accident-and-emergency') }}" @endif class="nav-link {{ request()->is('ane/dashboards/accident-and-emergency') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="20" viewBox="0 0 30.304 21.18"
                         fill="none">
                        <path id="Union_116" data-name="Union 116"
                              d="M24.418,20.823a1.365,1.365,0,0,1-.092-1.935,12.29,12.29,0,0,0,0-16.594L26.364.448a15.023,15.023,0,0,1,0,20.283,1.383,1.383,0,0,1-1.946.091ZM3.941,20.731a15.019,15.019,0,0,1,0-20.283L5.979,2.293a12.287,12.287,0,0,0,0,16.594,1.374,1.374,0,0,1-2.038,1.844Zm15.38-4.518a1.365,1.365,0,0,1-.092-1.935,5.461,5.461,0,0,0,0-7.375l2.038-1.845a8.193,8.193,0,0,1,0,11.064,1.383,1.383,0,0,1-1.946.091ZM9.036,16.122a8.2,8.2,0,0,1,0-11.064L11.075,6.9a5.464,5.464,0,0,0,0,7.375,1.374,1.374,0,0,1-2.038,1.844ZM13.775,10.6V10.59h2.755V10.6a1.377,1.377,0,0,1-2.755,0Zm0-.014a1.377,1.377,0,0,1,2.755,0Zm5.547-5.623a1.383,1.383,0,0,1,1.946.091L19.23,6.9A1.366,1.366,0,0,1,19.321,4.966ZM9.036,5.057a1.383,1.383,0,0,1,1.946-.091A1.366,1.366,0,0,1,11.075,6.9ZM24.418.357a1.383,1.383,0,0,1,1.946.091L24.326,2.293A1.366,1.366,0,0,1,24.418.357ZM3.941.448A1.381,1.381,0,0,1,5.886.357a1.367,1.367,0,0,1,.093,1.937Z"
                              transform="translate(0 0)" fill="currentColor" />
                    </svg>
                    <br>
                    <span class="link-name">Live Status <br></span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('activity_profile_view')) class="nav-item cyan-border  {{ request()->is('ane/dashboards/activity-profile') ? 'active' : '' }}"  @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('activity_profile_view')) href="{{ url('/ane/dashboards/activity-profile') }}" @endif class="nav-link {{ request()->is('ane/dashboards/activity-profile') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30.838" height="18.407"
                         viewBox="0 0 30.838 18.407">
                        <path id="Path_22037" data-name="Path 22037"
                              d="M7.33,23.709l6.786-8.81a2.862,2.862,0,0,1,4.02-.513l5.218,4.106a2.884,2.884,0,0,0,4.02-.485l6.586-8.5"
                              transform="translate(-5.226 -7.406)" fill="none" stroke="currentColor"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                    </svg>
                    <br>
                    <span class="link-name">Activity <br> Flow <br> </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('referral_to_speciality')) class="nav-item cyan-border  {{ request()->is('ane/dashboards/referral-to-speciality') ? 'active' : '' }}" @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('referral_to_speciality')) href="{{ url('/ane/dashboards/referral-to-speciality') }}" @endif class="nav-link {{ request()->is('ane/dashboards/referral-to-speciality') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="26" viewBox="0 0 31.644 26.413"
                         fill="currentColor">
                        <g id="Group_2907" data-name="Group 2907" transform="translate(-48.088 -579.982)">
                            <rect id="Rectangle_15899" data-name="Rectangle 15899" width="28.291" height="2.176"
                                  rx="1" transform="translate(49.764 595.217)" />
                            <rect id="Rectangle_15901" data-name="Rectangle 15901" width="6.529" height="2.176"
                                  rx="1" transform="translate(51.941 595.841) rotate(90)" />
                            <rect id="Rectangle_15906" data-name="Rectangle 15906" width="12.948" height="2.176"
                                  rx="1" transform="translate(64.998 589.422) rotate(90)" />
                            <rect id="Rectangle_15903" data-name="Rectangle 15903" width="5.53" height="1.882"
                                  rx="0.941" transform="translate(48.088 604.513)" />
                            <rect id="Rectangle_15907" data-name="Rectangle 15907" width="5.53" height="1.882"
                                  rx="0.941" transform="translate(74.202 604.513)" />
                            <rect id="Rectangle_15908" data-name="Rectangle 15908" width="5.53" height="1.882"
                                  rx="0.941" transform="translate(61.145 604.513)" />
                            <rect id="Rectangle_15902" data-name="Rectangle 15902" width="6.529" height="2.176"
                                  rx="1" transform="translate(78.055 595.841) rotate(90)" />
                            <g id="Ellipse_705" data-name="Ellipse 705" transform="translate(58.469 579.982)"
                               fill="none" stroke="currentColor" stroke-width="2">
                                <ellipse cx="5.441" cy="5.441" rx="5.441" ry="5.441" stroke="none" />
                                <ellipse cx="5.441" cy="5.441" rx="4.441" ry="4.441" fill="none" />
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Speciality <br> Referral </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('ambulance_dashboard')) class="nav-item cyan-border   {{ request()->is('ane/dashboards/ambulance-arrivals') ? 'active' : '' }}"  @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('ambulance_dashboard')) href="{{ url('/ane/dashboards/ambulance-arrivals') }}" @endif class="nav-link  {{ request()->is('ane/dashboards/ambulance-arrivals') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 40 25"
                         fill="currentColor">
                        <g id="Group_2950" data-name="Group 2950" transform="translate(-176 -285)">
                            <path id="alert-svgrepo-com"
                                  d="M17.96,6.137H15.823V4H17.96Zm9.51,2.688L25.959,7.313,24.448,8.824l1.511,1.511Zm-18.134,0L7.825,7.313,6.314,8.825l1.511,1.511ZM27.578,27.509h3.206v2.137H3V27.509H6.206V17.892a10.686,10.686,0,0,1,21.372,0Zm-2.137-9.617a8.549,8.549,0,0,0-17.1,0v9.617h17.1Zm-20.3-1.069H3V18.96H5.137Zm23.509,0V18.96h2.137V16.823ZM10.48,17.892v7.48h2.137v-7.48a4.275,4.275,0,0,1,4.274-4.274V11.48A6.411,6.411,0,0,0,10.48,17.892Z"
                                  transform="translate(178 286)" fill="currentColor" />
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Ambulance <br> Analytics </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('ed_live_summary_view') || CheckDashboardPermission('ed_day_summary_view')) class="nav-item cyan-border  {{ request()->is('ane/dashboards/ed-overview') ? 'active' : '' }}"  @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('ed_live_summary_view') || CheckDashboardPermission('ed_day_summary_view')) href="{{ url('/ane/dashboards/ed-overview') }}" @endif class="nav-link {{ request()->is('ane/dashboards/ed-overview') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="search-svgrepo-com" width="22" height="20"
                         viewBox="0 0 22 20" fill="currentColor">
                        <g id="Group_209" data-name="Group 209" transform="translate(0 0)">
                            <path id="Path_147" data-name="Path 147"
                                  d="M19.883,18.886,14.105,13.1A7.8,7.8,0,0,0,15.93,8.086,7.965,7.965,0,0,0,0,8.09a7.973,7.973,0,0,0,12.9,6.178l5.8,5.8a.835.835,0,1,0,1.18-1.18ZM1.692,8.09a6.269,6.269,0,0,1,12.537,0,6.269,6.269,0,0,1-12.537,0Z"
                                  transform="translate(0 -0.2)" />
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">ED <br> Overview </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('breach_')) class="nav-item cyan-border  {{ request()->is('ane/dashboards/breach-validation') ? 'active' : '' }}" @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('breach_')) href="{{ url('/ane/dashboards/breach-validation') }}" @endif class="nav-link {{ request()->is('ane/dashboards/breach-validation') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22.163" height="20"
                         viewBox="0 0 22.163 15.883" fill="currentColor">
                        <path id="tick-svgrepo-com" d="M4.892,15.1l5.762,5.762L23.519,8"
                              transform="translate(-3.124 -6.232)" fill="none" stroke="currentColor"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
                    </svg>
                    <br>
                    <span class="link-name">Breach <br> Validation </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('opel_data_history_page_view')) class="nav-item cyan-border icon-next {{ request()->is('ane/dashboards/ed-opel') ? 'active' : '' }}"  @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('opel_data_history_page_view')) href="{{ url('/ane/dashboards/ed-opel') }}" @endif class="nav-link {{ request()->is('ane/dashboards/ed-opel') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="26" viewBox="0 0 31.644 26.413" fill="currentColor">
                        <g id="Group_2907" data-name="Group 2907" transform="translate(-48.088 -579.982)">
                            <rect id="Rectangle_15899" data-name="Rectangle 15899" width="28.291" height="2.176" rx="1" transform="translate(49.764 595.217)"></rect>
                            <rect id="Rectangle_15901" data-name="Rectangle 15901" width="6.529" height="2.176" rx="1" transform="translate(51.941 595.841) rotate(90)"></rect>
                            <rect id="Rectangle_15906" data-name="Rectangle 15906" width="12.948" height="2.176" rx="1" transform="translate(64.998 589.422) rotate(90)"></rect>
                            <rect id="Rectangle_15903" data-name="Rectangle 15903" width="5.53" height="1.882" rx="0.941" transform="translate(48.088 604.513)"></rect>
                            <rect id="Rectangle_15907" data-name="Rectangle 15907" width="5.53" height="1.882" rx="0.941" transform="translate(74.202 604.513)"></rect>
                            <rect id="Rectangle_15908" data-name="Rectangle 15908" width="5.53" height="1.882" rx="0.941" transform="translate(61.145 604.513)"></rect>
                            <rect id="Rectangle_15902" data-name="Rectangle 15902" width="6.529" height="2.176" rx="1" transform="translate(78.055 595.841) rotate(90)"></rect>
                            <g id="Ellipse_705" data-name="Ellipse 705" transform="translate(58.469 579.982)" fill="none" stroke="currentColor" stroke-width="2">
                                <ellipse cx="5.441" cy="5.441" rx="5.441" ry="5.441" stroke="none"></ellipse>
                                <ellipse cx="5.441" cy="5.441" rx="4.441" ry="4.441" fill="none"></ellipse>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">EMS Data <br> History</span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('flow_dashboard_shankey_view')) class="nav-item cyan-border  {{ request()->is('ane/dashboards/sankey-charts') ? 'active' : '' }}"   @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('flow_dashboard_shankey_view')) href="{{ url('/ane/dashboards/sankey-charts') }}" @endif class="nav-link {{ request()->is('ane/dashboards/sankey-charts') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26.368" height="20"
                         viewBox="0 0 26.368 25.785" fill="currentColor">
                        <g id="Group_2908" data-name="Group 2908" transform="translate(7506.526 9211.125)">
                            <path id="Path_22038" data-name="Path 22038"
                                  d="M1890.858-8835.337a14.532,14.532,0,0,1,7.35,2.107c3.418,2.2,6.32,6.681,6.32,6.681a26.848,26.848,0,0,0,6.172,5.653,12.82,12.82,0,0,0,6.444,1.64"
                                  transform="translate(-9397.357 -374.784)" fill="none" stroke="currentColor"
                                  stroke-width="2" />
                            <path id="Path_22040" data-name="Path 22040"
                                  d="M1890.858-8835.337a14.532,14.532,0,0,1,7.35,2.107c3.418,2.2,6.32,6.681,6.32,6.681a26.848,26.848,0,0,0,6.172,5.653,12.82,12.82,0,0,0,6.444,1.64"
                                  transform="translate(-9397.357 -367.1)" fill="none" stroke="currentColor"
                                  stroke-width="2" />
                            <path id="Path_22039" data-name="Path 22039"
                                  d="M1917.115-8819.791a18.06,18.06,0,0,0-7.875,1.51,26.62,26.62,0,0,0-7.12,5.574,13.484,13.484,0,0,1-4.675,3.271,22.673,22.673,0,0,1-6.588,1.227"
                                  transform="translate(-9397.357 -386.187)" fill="none" stroke="currentColor"
                                  stroke-width="2" />
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Sankey <br> Visualisation </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('ane_welcome_screen_view')) class="nav-item cyan-border  {{ request()->is('ane/dashboards/ed-home') ? 'active' : '' }}" @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('ane_welcome_screen_view')) href="{{ url('/ane/dashboards/ed-home') }}" @endif class="nav-link {{ request()->is('ane/dashboards/ed-home') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26.667" height="20" viewBox="0 0 26.667 20"
                         fill="currentColor">
                        <path id="Path_95" data-name="Path 95"
                              d="M4.833,17H1.845l1.91-1.91a.863.863,0,0,0,.182-.272A.833.833,0,0,0,4,14.5V8.667h.833A.833.833,0,1,0,4.833,7H3.443L-2.11,2.833A4.2,4.2,0,0,0-4.61,2h-.842a4.142,4.142,0,0,0-.967.125A.818.818,0,0,0-6.833,2h-4.6a5.87,5.87,0,0,0-4.123,1.708l-1.625,1.625h-2.988A.833.833,0,0,0-21,6.167.833.833,0,0,0-20.167,7h2.5v8.333h-2.5a.833.833,0,0,0-.833.833.833.833,0,0,0,.833.833h2.988l3.292,3.292A5.87,5.87,0,0,0-9.763,22H-5.57a5.87,5.87,0,0,0,4.123-1.708L.178,18.667H4.833a.833.833,0,1,0,0-1.667ZM-4.612,3.667a2.5,2.5,0,0,1,1.5.5L2.333,8.25v5.378a9.24,9.24,0,0,1-4.667-1.8l-4-3a.833.833,0,0,0-.5-.167.833.833,0,0,0-.59.243L-8.6,10.09a2.268,2.268,0,0,1-3.13,0,.833.833,0,0,1-.245-.59.833.833,0,0,1,.245-.59L-7.22,4.4a2.518,2.518,0,0,1,1.767-.732Zm1.987,15.447a4.192,4.192,0,0,1-2.945,1.22H-9.763a4.192,4.192,0,0,1-2.945-1.22L-16,15.822V6.512l1.625-1.625a4.192,4.192,0,0,1,2.945-1.22h2.585L-12.91,7.732a2.5,2.5,0,0,0,0,3.537,3.973,3.973,0,0,0,5.487,0l.667-.667,3.423,2.565a10.888,10.888,0,0,0,4.657,2L-.755,17.245h0Z"
                              transform="translate(21 -2)" />
                    </svg>
                    <br>
                    <span class="link-name">Welcome <br> Screen </span>
                </a>
            </li>
            <div class="borderline"></div>
        </ul>
    </nav>
</div>

<!-- Sidebar Menu End-->
