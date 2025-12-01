

<div class="sidebar-menu d-none d-lg-block" id="sidebar">
    <nav class="" id="navbar">
        <ul class="">
            <li class="nav-item cyan-border ">
                <a href="{{ route('home') }}" class="nav-link ">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31.156 29.096" fill="currentColor">
                        <g id="home-svgrepo-com" transform="translate(-0.946 -2.25)">
                            <path id="Path_22090" data-name="Path 22090" d="M31.048,22H2" transform="translate(0 8.596)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22091" data-name="Path 22091" d="M2,14.238,13.8,4.8a4.357,4.357,0,0,1,5.444,0l11.8,9.442" transform="translate(0 0.381)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22092" data-name="Path 22092" d="M15.5,6.631v-2.9A.726.726,0,0,1,16.226,3h3.631a.726.726,0,0,1,.726.726v7.262" transform="translate(6.107)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22093" data-name="Path 22093" d="M4,27.655V9.5" transform="translate(0.905 2.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22094" data-name="Path 22094" d="M20,27.655V9.5" transform="translate(8.143 2.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22095" data-name="Path 22095" d="M17.714,25.619V18.357c0-2.054,0-3.081-.638-3.719S15.411,14,13.357,14s-3.081,0-3.719.638S9,16.3,9,18.357v7.262" transform="translate(3.167 4.976)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                            <path id="Path_22096" data-name="Path 22096" d="M15.81,10.4a2.9,2.9,0,1,1-2.9-2.9A2.9,2.9,0,0,1,15.81,10.4Z" transform="translate(3.619 2.036)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Home</span>
                </a>
            </li>

            @if ($favourites_menu->isNotEmpty())
                @foreach ($favourites_menu as $my_menu)
                    @if(isset($my_menu->Menus->dashboard_name) && $my_menu->Menus->status == 1)
                        <div class="borderline"></div>
                        <li @if(CheckMultipleDashboardPermission($my_menu->Menus->dashboard_required_permission)) class="nav-item cyan-border  {{ Request::RouteIs($my_menu->Menus->dashboard_routes) ? 'active' : '' }}" @else class="nav-item cyan-border ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                            <a @if(CheckMultipleDashboardPermission($my_menu->Menus->dashboard_required_permission)) href="{{ route($my_menu->Menus->dashboard_routes, ['dtoc_favourites' => 1]) }}" @endif class="nav-link {{ Request::RouteIs($my_menu->Menus->dashboard_routes) ? 'active' : '' }}">
                                {!! $my_menu->Menus->dashboard_icon !!}
                                <br>
                                <span class="link-name">{{ $my_menu->Menus->dashboard_name }} <br> </span>
                            </a>
                        </li>
                    @endif
                @endforeach
            @else
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_referral_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.referral') ? 'active' : '' }} " @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                    <a @if(CheckDashboardPermission('discharge_tracker_referral_view')) href="{{ route('discharged.referral') }}" @endif class="nav-link {{ Request::RouteIs('discharged.referral') ? 'active' : '' }}">
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
                        <span class="link-name">Referral</span>
                    </a>
                </li>

                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.index') ? 'active' : '' }} " @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                    <a @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) href="{{ route('discharged.index') }}" @endif class="nav-link {{ Request::RouteIs('discharged.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 40.868 34.085" fill="currentColor">
                            <g id="Group_2975" data-name="Group 2975" transform="translate(-832 -396)">
                                <path id="Subtraction_3" data-name="Subtraction 3" d="M16.5,39.715H13.864A1.8,1.8,0,0,1,12.2,37.922c0-.051,0-.1.005-.146l.01-2.083-.091-.028a12.1,12.1,0,0,1-1.547-.651L9.1,36.489a2.072,2.072,0,0,1-1.452.64H7.628a1.519,1.519,0,0,1-1.076-.443L3.027,33.161a1.807,1.807,0,0,1,.2-2.552L4.7,29.147a12.6,12.6,0,0,1-.676-1.638H1.948c-.048,0-.1.006-.154.006A1.806,1.806,0,0,1,0,25.846V20.856a1.807,1.807,0,0,1,1.794-1.663c.053,0,.1,0,.148.005l2.085.011.026-.092A11.978,11.978,0,0,1,4.7,17.57L3.23,16.1a1.8,1.8,0,0,1-.2-2.547l3.526-3.526a1.8,1.8,0,0,1,2.547.2l1.467,1.48a12.8,12.8,0,0,1,1.636-.675V8.948c0-.048-.006-.1-.006-.154A1.808,1.808,0,0,1,13.873,7H16.5V8.658l-2.626.014a.025.025,0,0,1,.02.008c.012.014.006.048,0,.1a.946.946,0,0,0-.019.174v2.676a.108.108,0,0,1-.005.028.141.141,0,0,0,0,.022.707.707,0,0,1-.033.165.722.722,0,0,1-.357.478.846.846,0,0,1-.164.083.08.08,0,0,0-.02.01.081.081,0,0,1-.022.011l-.079.02a11.124,11.124,0,0,0-2.38,1,.767.767,0,0,1-.926-.111.073.073,0,0,0-.035-.014.069.069,0,0,1-.037-.016L7.926,11.4a.4.4,0,0,0-.276-.147L4.216,14.724a.02.02,0,0,1,.011,0c.018,0,.037.028.067.07a1.056,1.056,0,0,0,.111.138L6.3,16.819l.011.027a.818.818,0,0,1,.219.526c0,.009,0,.016,0,.024a.192.192,0,0,1,0,.034.811.811,0,0,1-.076.345,11.275,11.275,0,0,0-1.04,2.5.032.032,0,0,1-.01.016.033.033,0,0,0-.009.012v.005a.8.8,0,0,1-.261.379.565.565,0,0,1-.068.045.807.807,0,0,1-.45.149L1.936,20.87a.14.14,0,0,0-.028,0,.441.441,0,0,0-.271.094l.024,4.89c0-.018.01-.025.032-.025a.424.424,0,0,1,.066.009l.027,0a.9.9,0,0,0,.152.014H4.614a.128.128,0,0,1,.037.007.163.163,0,0,0,.027.006.682.682,0,0,1,.118.023H4.8a.777.777,0,0,1,.19.063l.006,0a1.554,1.554,0,0,1,.235.183,1.376,1.376,0,0,1,.16.274.1.1,0,0,0,.011.022.089.089,0,0,1,.012.023l.02.08a10.974,10.974,0,0,0,1,2.379l0,0a.813.813,0,0,1,.1.386.281.281,0,0,1,0,.038c0,.009,0,.019,0,.029a.815.815,0,0,1-.219.519l-.013.029L4.4,31.8a.443.443,0,0,0-.144.277l3.476,3.44a.025.025,0,0,1-.009-.02c0-.019.031-.04.071-.069a1,1,0,0,0,.134-.11l1.892-1.891a.026.026,0,0,1,.016-.007.029.029,0,0,0,.016-.007.81.81,0,0,1,.515-.213l.026,0a.265.265,0,0,1,.038,0h.006a.8.8,0,0,1,.331.072l-.01-.005.024.012-.014-.007a11.291,11.291,0,0,0,2.511,1.042.093.093,0,0,1,.024.011.107.107,0,0,0,.02.01l.005,0a.741.741,0,0,1,.162.084l0,0a.841.841,0,0,1,.106.073,1.44,1.44,0,0,1,.192.252l0-.006a.844.844,0,0,1,.053.161v-.007a.815.815,0,0,1,.033.166.131.131,0,0,0,.005.023.107.107,0,0,1,.006.03l-.014,2.676a.22.22,0,0,0,0,.025.445.445,0,0,0,.094.273l2.54-.013v1.644ZM16.36,28.629a5.268,5.268,0,1,1,0-10.536l.139,0v1.664c-.041,0-.087,0-.139,0a3.6,3.6,0,1,0,0,7.21l.139,0v1.664H16.36Z" transform="translate(832 390)"></path>
                                <g id="Layer_x0020_1" transform="translate(849.025 396.041)">
                                    <path id="Path_22140" data-name="Path 22140" d="M6.982,16.4h8.729a1.952,1.952,0,0,1,1.864-1.465,2.02,2.02,0,0,1,0,4.036,1.952,1.952,0,0,1-1.864-1.465H6.982V16.4ZM21.9,6.827a2.02,2.02,0,0,1,0,4.036,1.882,1.882,0,0,1-1.214-.445l-4.4,3.492a5.692,5.692,0,0,1-3.839,1.038V13.93l1.154-.031A3.485,3.485,0,0,0,15.2,13.46l4.9-3.888a2.086,2.086,0,0,1-.13-.727A1.979,1.979,0,0,1,21.9,6.827Zm0,.979a1.04,1.04,0,1,1-1,1.039A1.019,1.019,0,0,1,21.9,7.806Zm-4.33,8.111a1.04,1.04,0,1,1-1,1.039A1.019,1.019,0,0,1,17.575,15.918Zm-1.1,14.175a2.01,2.01,0,0,1,1.382,1.934,1.939,1.939,0,1,1-3.875,0,2.008,2.008,0,0,1,1.409-1.942V24.552a2.05,2.05,0,0,0-1.874-1.874H9.155V21.623h4.261A2.921,2.921,0,0,1,16.478,24.5v5.6Zm-.556.894a1.04,1.04,0,1,1-1,1.039A1.019,1.019,0,0,1,15.922,30.987Zm0-31.028a1.979,1.979,0,0,1,1.938,2.018,2.01,2.01,0,0,1-1.381,1.934V9.566a2.921,2.921,0,0,1-3.062,2.872H9.155V11.382H13.52a2.05,2.05,0,0,0,1.874-1.874V3.919a2.009,2.009,0,0,1-1.409-1.942A1.979,1.979,0,0,1,15.922-.041Zm0,.979a1.019,1.019,0,0,1,1,1.039,1,1,0,1,1-2,0A1.019,1.019,0,0,1,15.922.938Zm-4,3.757a1.979,1.979,0,0,1,1.938,2.018,1.979,1.979,0,0,1-1.938,2.018A1.955,1.955,0,0,1,10.041,7.2h-1A.874.874,0,0,0,8.1,8.216V10.6c-.217,1.1-.786,1.75-1.809,1.809H3.835v-1L6.2,11.392c.586-.116.869-.58.857-1.383V7.837a1.641,1.641,0,0,1,1.7-1.568H10.03a1.958,1.958,0,0,1,1.89-1.575Zm0,.979a1.04,1.04,0,1,1-1,1.039A1.019,1.019,0,0,1,11.921,5.674ZM21.9,23.022a2.02,2.02,0,1,1-1.938,2.018,2.085,2.085,0,0,1,.14-.755l-4.7-3.716A2.486,2.486,0,0,0,13.9,20H3.813V18.894H13.9a4.018,4.018,0,0,1,2.283.866l4.5,3.714a1.882,1.882,0,0,1,1.221-.451Zm0,.979a1.04,1.04,0,1,1-1,1.039A1.019,1.019,0,0,1,21.9,24Zm-9.984,1.177a2.02,2.02,0,0,1,0,4.036,1.955,1.955,0,0,1-1.881-1.533H8.765a1.641,1.641,0,0,1-1.7-1.568V23.942c.012-.8-.271-1.267-.857-1.383l-2.368-.016v-1H6.288c1.023.058,1.592.705,1.809,1.809v2.38a.874.874,0,0,0,.941,1.012h.994a1.957,1.957,0,0,1,1.889-1.569Zm0,.979a1.04,1.04,0,1,1-1,1.039A1.019,1.019,0,0,1,11.921,26.157ZM1.776,18.894H2.883V20H1.776Zm-1.22-5.03H1.663V14.97H.556V13.863Zm2.075,0h7.546V14.97H2.631V13.863ZM-.01,16.4H5.775V17.51H-.01V16.4Z" transform="translate(0 0)" fill-rule="evenodd"></path>
                                </g>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">CDT Patient  <br>List</span>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.removed_patients') ? 'active' : '' }} " @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                    <a @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) href="{{ route('discharged.removed_patients') }}" @endif class="nav-link {{ Request::RouteIs('discharged.removed_patients') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24.68" height="19.699" viewBox="0 0 24.68 19.699" fill="currentColor">
                            <g id="Group_2328" data-name="Group 2328" transform="translate(-43.25 -685.051)">
                                <path id="Path_21138" data-name="Path 21138" d="M18.621,12.7l2.413-2.413m2.413-2.413-2.413,2.413m0,0L18.621,7.879m2.413,2.413L23.447,12.7" transform="translate(43.422 682.334)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                <path id="Path_21139" data-name="Path 21139" d="M1,21.1V19.962A7.962,7.962,0,0,1,8.962,12h0a7.962,7.962,0,0,1,7.962,7.962V21.1" transform="translate(43 682.9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                <path id="Path_21140" data-name="Path 21140" d="M8.55,13.1A4.55,4.55,0,1,0,4,8.55,4.55,4.55,0,0,0,8.55,13.1Z" transform="translate(43.412 681.801)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">Removed  <br>Patients</span>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_performance_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.performance') ? 'active' : '' }} " @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_tracker_performance_view')) href="{{ route('discharged.performance') }}" @endif class="nav-link {{ Request::RouteIs('discharged.performance') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 34 34" fill="currentColor">
                            <g id="dashboard" transform="translate(-2 -2)">
                                <line id="Line_1" data-name="Line 1" x2="32" transform="translate(3 35)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                <line id="Line_2" data-name="Line 2" y2="32" transform="translate(3 3)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                <line id="Line_3" data-name="Line 3" y2="22" transform="translate(19 8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                <line id="Line_4" data-name="Line 4" y2="17" transform="translate(26 13)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                <line id="Line_5" data-name="Line 5" y2="11" transform="translate(11 19)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">Performance <br> </span>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_medfit')) class="nav-item cyan-border {{ Request::RouteIs('discharged.medfit') ? 'active' : '' }} " id="medfit" @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                    <a @if(CheckDashboardPermission('discharge_tracker_medfit')) href="{{ route('discharged.medfit') }}" @endif class="nav-link {{ Request::RouteIs('discharged.medfit') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 34.529 30.494" fill="currentColor">
                            <g id="heart-pulse-svgrepo-com" transform="translate(-1.25 -2.249)">
                                <path id="Path_22097" data-name="Path 22097" d="M25.272,13.548H23.985a5.265,5.265,0,0,0-2.551.313c-.552.313-.9.884-1.58,2.026l-.05.083c-.639,1.064-.958,1.6-1.422,1.588s-.764-.552-1.362-1.64l-2.71-4.927c-.558-1.014-.837-1.521-1.282-1.545s-.777.45-1.441,1.4l-.455.649c-.7,1.007-1.057,1.51-1.58,1.783a5.217,5.217,0,0,1-2.367.272H6" transform="translate(2.878 4.361)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                                <path id="Path_22098" data-name="Path 22098" d="M13.635,29.008l.746-.946ZM18.514,7.471l-.868.835a1.2,1.2,0,0,0,1.736,0Zm4.879,21.537.746.946h0Zm-4.879,2.529v0ZM3.509,20.152a1.2,1.2,0,1,0,2.045-1.273Zm6.22,3.815a1.2,1.2,0,0,0-1.7,1.705ZM3.659,13.311c0-4.5,2.019-7.294,4.544-8.255s6.058-.268,9.444,3.25l1.736-1.671C15.542,2.646,11.038,1.4,7.346,2.805s-6.1,5.288-6.1,10.506ZM24.14,29.954A48.391,48.391,0,0,0,31.693,22.7c2.259-2.8,4.085-6.062,4.085-9.39H33.37c0,2.491-1.4,5.213-3.551,7.877a46.023,46.023,0,0,1-7.171,6.874ZM35.779,13.311c0-5.218-2.4-9.1-6.1-10.506s-8.2-.159-12.036,3.831l1.736,1.671c3.386-3.518,6.912-4.213,9.444-3.25S33.37,8.81,33.37,13.311ZM12.889,29.954c2.047,1.613,3.457,2.788,5.625,2.788V30.333c-1.173,0-1.9-.512-4.134-2.271Zm9.759-1.892c-2.232,1.759-2.96,2.271-4.134,2.271v2.409c2.168,0,3.579-1.175,5.625-2.788ZM5.554,18.879a10.825,10.825,0,0,1-1.9-5.567H1.25a13.185,13.185,0,0,0,2.259,6.84Zm8.827,9.184a53.883,53.883,0,0,1-4.652-4.1l-1.7,1.705a56.245,56.245,0,0,0,4.862,4.282Z" transform="translate(0 0)" fill="currentColor"></path>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">Med Fit </span>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_month_summary_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.month.summary') ? 'active' : '' }} " id="month_summary"  @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_tracker_month_summary_view')) href="{{ route('discharged.month.summary') }}" @endif class="nav-link {{ Request::RouteIs('discharged.month.summary') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26.946 26.309" fill="currentColor">
                            <g id="calendar-svgrepo-com" transform="translate(-1.25 -1.75)">
                                <path id="Path_22128" data-name="Path 22128" d="M2,14.178c0-4.8,0-7.2,1.491-8.688S7.38,4,12.178,4h5.089c4.8,0,7.2,0,8.688,1.491s1.491,3.89,1.491,8.688v2.545c0,4.8,0,7.2-1.491,8.688S22.065,26.9,17.267,26.9H12.178c-4.8,0-7.2,0-8.688-1.491S2,21.521,2,16.723Z" transform="translate(0 0.408)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                <path id="Path_22129" data-name="Path 22129" d="M7,4.408V2.5" transform="translate(1.361)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                                <path id="Path_22130" data-name="Path 22130" d="M17,4.408V2.5" transform="translate(4.084)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                                <path id="Path_22131" data-name="Path 22131" d="M2.5,9H26.673" transform="translate(0.136 1.77)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                                <path id="Path_22132" data-name="Path 22132" d="M18.545,17.272A1.272,1.272,0,1,1,17.272,16,1.272,1.272,0,0,1,18.545,17.272Z" transform="translate(3.812 3.676)" fill="currentColor"></path>
                                <path id="Path_22133" data-name="Path 22133" d="M18.545,13.272A1.272,1.272,0,1,1,17.272,12,1.272,1.272,0,0,1,18.545,13.272Z" transform="translate(3.812 2.587)" fill="currentColor"></path>
                                <path id="Path_22134" data-name="Path 22134" d="M13.545,17.272A1.272,1.272,0,1,1,12.272,16,1.272,1.272,0,0,1,13.545,17.272Z" transform="translate(2.451 3.676)" fill="currentColor"></path>
                                <path id="Path_22135" data-name="Path 22135" d="M13.545,13.272A1.272,1.272,0,1,1,12.272,12,1.272,1.272,0,0,1,13.545,13.272Z" transform="translate(2.451 2.587)" fill="currentColor"></path>
                                <path id="Path_22136" data-name="Path 22136" d="M8.545,17.272A1.272,1.272,0,1,1,7.272,16,1.272,1.272,0,0,1,8.545,17.272Z" transform="translate(1.089 3.676)" fill="currentColor"></path>
                                <path id="Path_22137" data-name="Path 22137" d="M8.545,13.272A1.272,1.272,0,1,1,7.272,12,1.272,1.272,0,0,1,8.545,13.272Z" transform="translate(1.089 2.587)" fill="currentColor"></path>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">Month <br> Summary </span>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_month_list_summary_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.monthlist.summary') ? 'active' : '' }} " id="month_list_summary" @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_tracker_month_list_summary_view')) href="{{ route('discharged.monthlist.summary') }}" @endif class="nav-link {{ Request::RouteIs('discharged.monthlist.summary') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Page-1" width="22" height="18" viewBox="0 0 28 18" fill="currentColor">
                            <g id="Icon-Set" transform="translate(-206 -626)">
                                <path id="list" d="M207,626a1,1,0,1,0,1,1,1,1,0,0,0-1-1Zm26,8H213a1,1,0,0,0,0,2h20a1,1,0,0,0,0-2Zm0,8H213a1,1,0,0,0,0,2h20a1,1,0,0,0,0-2Zm-26-8a1,1,0,1,0,1,1,1,1,0,0,0-1-1Zm0,8a1,1,0,1,0,1,1,1,1,0,0,0-1-1Zm6-14h20a1,1,0,0,0,0-2H213a1,1,0,0,0,0,2Z" fill-rule="evenodd"></path>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">Month List <br> Summary </span>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_patient_search_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.patient.search') ? 'active' : '' }} " id="patient_comment" @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_tracker_patient_search_view')) href="{{ route('discharged.patient.search') }}" @endif class="nav-link {{ Request::RouteIs('discharged.patient.search') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" id="search-svgrepo-com" width="20.137" height="20.12" viewBox="0 0 20.137 20.12" fill="currentColor">
                            <g id="Group_209" data-name="Group 209" transform="translate(0 0)">
                                <path id="Path_147" data-name="Path 147" d="M19.883,18.886,14.105,13.1A7.8,7.8,0,0,0,15.93,8.086,7.965,7.965,0,0,0,0,8.09a7.973,7.973,0,0,0,12.9,6.178l5.8,5.8a.835.835,0,1,0,1.18-1.18ZM1.692,8.09a6.269,6.269,0,0,1,12.537,0,6.269,6.269,0,0,1-12.537,0Z" transform="translate(0 -0.2)"></path>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">Patient <br> Search </span>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_tracker_discharge_view')) class="nav-item cyan-border {{ Request::RouteIs('discharged.dischargepatient') ? 'active' : '' }} " @else  class="nav-item cyan-border  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_tracker_discharge_view')) href="{{ route('discharged.dischargepatient') }}" @endif class="nav-link {{ Request::RouteIs('discharged.dischargepatient') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="24" viewBox="0 0 30.62 29.102" fill="currentColor">
                            <g id="Group_2974" data-name="Group 2974" transform="translate(-836 -1242.94)">
                                <path id="Subtraction_2" data-name="Subtraction 2" d="M28.363,29.1H.74a.74.74,0,1,1,0-1.479H3.946V.74A.741.741,0,0,1,4.686,0h19.7a.741.741,0,0,1,.739.74V17.492H23.648V1.479H5.426V27.623H23.648v-.006h1.479v.006h3.235a.74.74,0,0,1,0,1.479ZM19.484,15.3H19.47a.681.681,0,0,1-.5-.217.713.713,0,0,1-.238-.529v0a.725.725,0,0,1,.237-.533.758.758,0,0,1,1.025,0,.829.829,0,0,1,.236.533.78.78,0,0,1-.236.533A.711.711,0,0,1,19.484,15.3Z" transform="translate(836 1242.94)"></path>
                                <path id="arrow-sm-left-svgrepo-com" d="M12.262,9.763H1.517m10.745,0L9.5,7m2.763,2.763L9.5,12.525" transform="translate(853.298 1255.728)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                            </g>
                        </svg>
                        <br>
                        <span class="link-name">Discharges <br> </span>
                    </a>
                </li>
                <div class="borderline"></div>
            @endif
        </ul>
    </nav>
</div>
