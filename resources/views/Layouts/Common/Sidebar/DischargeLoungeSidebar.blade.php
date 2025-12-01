<div class="sidebar-menu d-none d-lg-block" id="sidebar-custom">
    <div class="sidebar-menu d-none d-lg-block" id="sidebar">
        <nav class="" id="navbar">
            <ul class="">
                <li class="nav-item cyan-border icon-next">
                    <a href="{{ route('home') }}" class="nav-link ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="30px" height="30px" viewBox="0 0 24 24" id="home-svg" data-name="Line Color" class="icon line-color">
                            <polygon id="primary" points="19 11 19 21 14 21 14 14 10 14 10 21 5 21 5 11 3 11 12 2 21 11 19 11" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 1;">
                            </polygon>
                        </svg> <br>
                        <span class="home-text">Home</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_lounge_summary_view')) class="nav-item cyan-border  {{ Request::RouteIs('discharge.lounge.patients') ? 'active' : '' }} icon-next"  @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_lounge_summary_view')) href="{{ route('discharge.lounge.patients') }}" @endif class="nav-link {{ Request::RouteIs('discharge.lounge.patients') ? 'active' : '' }}">
                        <span class=" ">Patients <br></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_lounge_awating_referral_view')) class="nav-item cyan-border ibox-side-menu-disabled-icon  {{ Request::RouteIs('discharge.lounge.waiting-referral') ? 'active' : '' }} icon-next"  @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
{{--                    <a @if(CheckDashboardPermission('discharge_lounge_awating_referral_view')) href="{{ route('discharge.lounge.waiting-referral') }}" @endif class="nav-link {{ Request::RouteIs('discharge.lounge.waiting-referral') ? 'active' : '' }}">--}}
                    <a @if(CheckDashboardPermission('discharge_lounge_awating_referral_view')) href="#" @endif class="nav-link ibox-side-menu-disabled-icon {{ Request::RouteIs('discharge.lounge.waiting-referral') ? 'active' : '' }}">
                        <span class=" ">Awaiting <br>Referral</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_lounge_summary_view')) class="nav-item cyan-border {{ Request::RouteIs('discharge.lounge.summary') ? 'active' : '' }} icon-next"   @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_lounge_summary_view')) href="{{ route('discharge.lounge.summary') }}" @endif class="nav-link {{ Request::RouteIs('discharge.lounge.summary') ? 'active' : '' }}">
                        <span class=" ">Summary<br></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_lounge_week_summary_view')) class="nav-item cyan-border {{ Request::RouteIs('discharge.lounge.summaryweek') ? 'active' : '' }} icon-next"   @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_lounge_week_summary_view')) href="{{ route('discharge.lounge.summaryweek') }}" @endif class="nav-link {{ Request::RouteIs('discharge.lounge.summaryweek') ? 'active' : '' }}">
                        <span class=" ">Week <br>Summary<br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_lounge_month_summary_view')) class="nav-item cyan-border {{ Request::RouteIs('discharge.lounge.summarymonth') ? 'active' : '' }} icon-next" @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_lounge_month_summary_view')) href="{{ route('discharge.lounge.summarymonth') }}" @endif class="nav-link {{ Request::RouteIs('discharge.lounge.summarymonth') ? 'active' : '' }}">
                        <span class=" ">Month <br> Summary <br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>


                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('discharge_lounge_out_view')) class="nav-item cyan-border {{ Request::RouteIs('discharge.lounge.outofoffice') ? 'active' : '' }} icon-next"   @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('discharge_lounge_out_view')) href="{{ route('discharge.lounge.outofoffice') }}" @endif class="nav-link {{ Request::RouteIs('discharge.lounge.outofoffice') ? 'active' : '' }}">
                        <span class="">Out Of <br>Office</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
            </ul>
        </nav>
    </div>
</div>
