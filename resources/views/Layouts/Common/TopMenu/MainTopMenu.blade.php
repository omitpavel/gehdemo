<div class="topbar-menu @if(Request::routeIs('discharged*')) discharge-tracker-topbar @elseif(Request::routeIs('discharged*')) site-overview-topbar @endif " id="topbar">
    <nav class="navbar navbar-expand-lg ">
        <div class="topbar-contents">
            <div class="title ">
                <div class="page-name-wrapper">
                    <a @if (Sentinel::getUser() && Sentinel::getUser()->user_type == 0) href="{{ url('/home') }}" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                        <div class="brand-logo">
                            <img src="{{ asset('asset_v2/Ibox/Images/iBox-Logo.svg') }}" alt="" width="115" height="35">
                        </div>
                    </a>
                    @if (in_array(Route::currentRouteName(), ['inpatients.siteoverview']))
                        <div class="live">
                            <div class="circle"></div>LIVE
                        </div>
                    @endif
                    <div class="page-name">
                        <h6 class="navbar-brand @hasSection('page-top-title-sub') mb-2 @else mb-0  pt-1 @endif">@hasSection('page-top-title')
                            @yield('page-top-title')
                        @endif</h6>
                        @hasSection('page-top-title-sub')
                            <div class="mt-10">
                                @if (trim($__env->yieldContent('page-top-title-sub')) == 'autotimer')
                                    <span class="fs-12" id="@yield('page-top-title-sub')"></span>
                                @else
                                    <span class="fs-12 last_board_round_class_name">@yield('page-top-title-sub')</span>
                                @endif

                            </div>
                        @endif
                    </div>
                </div>
                <div class="other-topbar-section">
                    @if (Route::currentRouteName() == 'ward.sdec' || Route::currentRouteName() == 'ward.ward-details')
                        <div class="emergency-count">
                            <h6 class="mb-0">Elective - <span class="elective_web"></span></h6>
                            <h6 class="mb-0 text-center">|</h6>
                            <h6 class="mb-0"><span class="non_elective_web"></span> - Non-Elective</h6>
                        </div>
                    @endif

                    @if (Route::currentRouteName() == 'discharged.index')
                        <div class="pathway-details" id="pathway_details_count">
                            <div class="pathway-count">
                                <h6>Total :</h6>
                                <h6 class="complex_total_patient"> 0</h6>
                            </div>
                            <div class="pathway-count">
                                <h6>P1 :</h6>
                                <h6 class="complex_total_p1"> 0</h6>
                            </div>
                            <div class="pathway-count">
                                <h6>P2 :</h6>
                                <h6 class="complex_total_p2"> 0</h6>
                            </div>
                            <div class="pathway-count">
                                <h6>P3 :</h6>
                                <h6 class="complex_total_p3"> 0</h6>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="badges-section">
                <ul class="navbar-nav ms-auto ">
                    @hasSection('boardround-menus')
                        @yield('boardround-menus')
                    @endif
                    @if (Route::currentRouteName() == 'discharged.index')
                        <li class="nav-item count-discharge me-2">
                            <div>CDT Discharges for Today : <span class="today_discharges_value_class"></span></div>
                        </li>
                        <li class="nav-item me-2">
                            <div class="{{ PermissionDeniedDiv('discharge_tracker_complex_discharge_export_view') }}">
                                <button type="button"
                                    class="btn btn-export w-100 {{ DisabledButtonOnRolePermission('discharge_tracker_complex_discharge_export_view') }} export_discharge_tracker">
                                    <img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt=""
                                        class="me-2" width="15">Export
                                </button>
                            </div>
                        </li>
                        <li class="nav-item me-2">
                            <div class="{{ PermissionDeniedDiv('discharge_tracker_complex_discharge_print') }}">
                                <button type="button"
                                    class="btn btn-export w-100 {{ DisabledButtonOnRolePermission('discharge_tracker_complex_discharge_print') }} print_complex_discharge">
                                    <img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt=""
                                        class="me-2" width="16">Print
                                </button>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
            <div class="more">
                <button class="shape-btn" onclick="ResponsiveTopButtons($(this))">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
            </div>
            <div class="more-buttons d-none d-xl-block" id="moreButtons">
                <ul class="">
                    <li class="nav-item shape-btn me-2">
                        <a class=" text-center"
                            @if (Sentinel::getUser() && Sentinel::getUser()->user_type == 0)
                                @php
                                    $lastSegment = substr(strrchr(request()->url(), '/'), 1);
                                    $vertual_ward = ['one-to-one-care', 'frailty', 'amhat', 'diabetics-status','dementia-delirium','risk-of-falls','nutrition-risk','pressure-ulcer','amber-care-eol','sova-dols-ld', 'palliative-care'];
                                @endphp
                                @if (
                                    ((Request::routeIs('inpatients*') ||
                                        Request::routeIs('ward.boardround') ||
                                        Request::routeIs('discharge.lounge*') ||
                                        Request::routeIs('ward.ward-details') ||
                                        Request::routeIs('CcuItu*') ||
                                        Request::routeIs('CcuItuWardTciList.ward-details') ||
                                        Request::routeIs('bed.matrix') ||
                                        Request::routeIs(['board_round.dashboard', 'site.pd_discharge', 'surgical.ward', 'doctor.at.night'])) &&
                                        !Request::routeIs('inpatients.siteoverview') &&
                                        !Request::routeIs('ward.dashboard')) ||
                                        Request::routeIs(['bed.status.flag']) ||
                                        (Request::routeIs(['virtual.ward.summary']) && in_array($lastSegment, $vertual_ward)))
                                href="{{ route('ward.dashboard') }}"

                                @elseif (Request::is('ane*') && !Request::routeIs('ane_home'))
                                href="{{ route('ane_home') }}"
                                @else
                                href="{{ url('/home') }}" @endif
                    @elseif(Sentinel::getUser() && Sentinel::getUser()->user_type == 2) href="{{ route('ane.livestatus') }}" @else
                        onclick="CommonLoginModalPopupOpenOnRequest();" @endif role="button"
                        id="homepage_id">
                        <svg id="home-svgrepo-com" width="16" height="16" viewBox="0 0 19.08 19.514">
                            <g id="Group_210" data-name="Group 210" transform="translate(0)">
                                <path id="Path_149" data-name="Path 149"
                                    d="M23.729,7.091,15.46.289a1.271,1.271,0,0,0-1.615,0L11.327,2.361v-.4a.636.636,0,0,0-.636-.636H7.642a.636.636,0,0,0-.636.636V5.915L5.576,7.091a1.271,1.271,0,0,0,.6,2.236v8.915a1.271,1.271,0,0,0,1.271,1.271H11.83A1.271,1.271,0,0,0,13.1,18.242V15a.52.52,0,0,1,.143-.394H16.06A.52.52,0,0,1,16.2,15v3.241a1.271,1.271,0,0,0,1.271,1.271h4.384a1.271,1.271,0,0,0,1.271-1.271V9.328a1.271,1.271,0,0,0,.6-2.236ZM8.278,2.6h1.778v.807L8.278,4.869Zm13.58,5.474V18.242H17.474V15a1.547,1.547,0,0,0-1.391-1.665H13.221A1.547,1.547,0,0,0,11.83,15v3.241H7.446V8.073H6.383l8.269-6.8,8.269,6.8Z"
                                    transform="translate(-5.112)" />
                            </g>
                        </svg>
                    </a>
                </li>
                <li class="nav-item shape-btn me-2 {{ PermissionDeniedDiv('flow_dashboard_patient_search_view') }}">
                    <div
                        class=" text-center click_open_global_patient_search {{ DisabledButtonOnRolePermission('flow_dashboard_patient_search_view') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" id="search-svgrepo-com" width="16" height="16"
                            viewBox="0 0 20.137 20.12">
                            <g id="Group_209" data-name="Group 209" transform="translate(0 0)">
                                <path id="Path_147" data-name="Path 147"
                                    d="M19.883,18.886,14.105,13.1A7.8,7.8,0,0,0,15.93,8.086,7.965,7.965,0,0,0,0,8.09a7.973,7.973,0,0,0,12.9,6.178l5.8,5.8a.835.835,0,1,0,1.18-1.18ZM1.692,8.09a6.269,6.269,0,0,1,12.537,0,6.269,6.269,0,0,1-12.537,0Z"
                                    transform="translate(0 -0.2)"></path>
                            </g>
                        </svg>
                    </div>
                </li>
                @hasSection('top-menus')
                    @yield('top-menus')
                @endif
                @if (session()->get('is_site_team') == 1 ||
                !is_numeric(\App\Models\Common\User::find(session()->get('LOGGED_USER_ID', ''))->user_type ?? 0))
                    <li class="nav-item shape-btn me-2 click_view_site_team_notification" data-bs-toggle="offcanvas"
                    data-bs-target="#site_team_notification_offcanvas"
                    aria-controls="site_team_notification_offcanvas">
                        <a class=" text-center notification " >
                            <svg width="16" height="16" viewBox="0 0 19.818 19.217">
                                <g id="XMLID_169_" transform="translate(0 -5)">
                                    <path id="XMLID_197_"
                                        d="M248.665,5.215A.9.9,0,0,0,247.5,6.587a8.1,8.1,0,0,1,2.855,6.176.9.9,0,1,0,1.8,0A9.9,9.9,0,0,0,248.665,5.215Z"
                                        transform="translate(-232.336)" />
                                    <path id="XMLID_221_"
                                        d="M4.657,6.587A.9.9,0,1,0,3.489,5.215,9.9,9.9,0,0,0,0,12.764a.9.9,0,0,0,1.8,0A8.1,8.1,0,0,1,4.657,6.587Z"
                                        transform="translate(0 -0.001)" />
                                    <path id="XMLID_222_"
                                        d="M54.113,20.615h-.3V12.764a6.315,6.315,0,0,0-5.4-6.241V5.9a.9.9,0,0,0-1.8,0v.621a6.315,6.315,0,0,0-5.4,6.241v7.851h-.3a.9.9,0,0,0,0,1.8h4.058a2.7,2.7,0,0,0,5.1,0h4.058a.9.9,0,1,0,0-1.8ZM43,12.764a4.5,4.5,0,0,1,9.008,0v7.851H43Z"
                                        transform="translate(-37.598 -0.001)" />
                                </g>
                            </svg>
                            <div class="notification-bg notification_alert_class">
                                <span class="count_my_notification">0</span>
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item shape-btn ">
                    <a class=" text-center notification" href="{{ url('/logout') }}" title='Logout' role="button">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0" />
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                            <g id="SVGRepo_iconCarrier">
                                <path fill="#000"
                                    d="M10.2392344,0 C13.3845587,0 16.2966635,1.39466883 18.2279685,3.74426305 C18.4595621,4.02601608 18.4134356,4.43777922 18.124942,4.66396176 C17.8364485,4.89014431 17.4148346,4.84509553 17.183241,4.5633425 C15.5035716,2.51988396 12.9739849,1.30841121 10.2392344,1.30841121 C5.32416443,1.30841121 1.33971292,5.19976806 1.33971292,10 C1.33971292,14.8002319 5.32416443,18.6915888 10.2392344,18.6915888 C13.0144533,18.6915888 15.5774656,17.443711 17.2546848,15.3485857 C17.4825482,15.0639465 17.9035339,15.0136047 18.1949827,15.2361442 C18.4864315,15.4586837 18.5379776,15.8698333 18.3101142,16.1544725 C16.3816305,18.5634688 13.4311435,20 10.2392344,20 C4.58426141,20 8.8817842e-14,15.5228475 8.8817842e-14,10 C8.8817842e-14,4.4771525 4.58426141,0 10.2392344,0 Z M17.0978642,7.15999289 L19.804493,9.86662172 C20.0660882,10.1282169 20.071043,10.5473918 19.8155599,10.802875 L17.17217,13.4462648 C16.9166868,13.701748 16.497512,13.6967932 16.2359168,13.435198 C15.9743215,13.1736028 15.9693667,12.7544279 16.2248499,12.4989447 L17.7715361,10.9515085 L7.46239261,10.9518011 C7.0924411,10.9518011 6.79253615,10.6589032 6.79253615,10.2975954 C6.79253615,9.93628766 7.0924411,9.64338984 7.46239261,9.64338984 L17.7305361,9.64250854 L16.1726778,8.08517933 C15.9110825,7.82358411 15.9061278,7.40440925 16.1616109,7.14892607 C16.4170941,6.89344289 16.836269,6.89839767 17.0978642,7.15999289 Z" />
                            </g>
                        </svg>
                    </a>
                </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
