<div class="sidebar-menu d-none d-lg-block" id="sidebar-custom">
    <div class="sidebar-menu d-none d-lg-block" id="sidebar">
        <nav class="" id="navbar">
            <ul class="">
                <li class="nav-item cyan-border icon-next">
                    <a href="{{ route('home') }}" class="nav-link ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="30px" height="30px" viewBox="0 0 24 24"
                             id="home-svg" data-name="Line Color" class="icon line-color">
                            <polygon id="primary" points="19 11 19 21 14 21 14 14 10 14 10 21 5 21 5 11 3 11 12 2 21 11 19 11"
                                     style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 1;" />
                        </svg> <br>
                        <span class="home-text">Home</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"
                             viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)" />
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)" />
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('surgical_wards_dashboard_view'))class="nav-item cyan-border  {{ Request::RouteIs('surgical.ward') ? 'active' : '' }} icon-next" @else class="nav-item ibox-side-menu-disabled-icon icon-next" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('surgical_wards_dashboard_view')) href="{{ route('surgical.ward') }}" @endif class="nav-link {{ Request::RouteIs('surgical.ward') ? 'active' : '' }}">
                        <span class=" ">Surgical <br>Handover <br></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"
                             viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)" />
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)" />
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
{{--                <li @if(PermitedStatus('doctor_at_night_dashboard_view')) class="nav-item cyan-border {{ Request::RouteIs('doctor.at.night') ? 'active' : '' }} icon-next " @else  class="nav-item icon-next ibox-side-menu-disabled-icon "  onclick="CommonLoginModalPopupOpenOnRequest();" @endif  >--}}
{{--                    <a @if(PermitedStatus('doctor_at_night_dashboard_view')) href="{{ route('doctor.at.night') }}" class="nav-link {{ Request::RouteIs('doctor.at.night') ? 'active' : '' }}" @else class="nav-link"  @endif>--}}
{{--                        <span class=" ">Doctors<br>At Night</span>--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"--}}
{{--                             viewBox="0 0 12.858 14.128">--}}
{{--                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">--}}
{{--                                <path id="Path_19238" data-name="Path 19238"--}}
{{--                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"--}}
{{--                                      transform="translate(0.972 5.738)" />--}}
{{--                                <path id="Path_19239" data-name="Path 19239"--}}
{{--                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"--}}
{{--                                      transform="translate(0.972 0.973)" />--}}
{{--                            </g>--}}
{{--                        </svg>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('leaflet_dashboard_view'))  class="nav-item cyan-border {{ Request::RouteIs('virtual.ward.leaflet') ? 'active' : '' }} icon-next" @else class="nav-item ibox-side-menu-disabled-icon icon-next" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('leaflet_dashboard_view')) href="{{ route('virtual.ward.leaflet') }}" @endif class="nav-link {{ Request::RouteIs('virtual.ward.leaflet') ? 'active' : '' }}">
                        <span class=" ">Leaflet <br>01<br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"
                             viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)" />
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)" />
                            </g>
                        </svg>
                    </a>
                </li>
{{--                <div class="borderline"></div>--}}
{{--                <li @if(CheckDashboardPermission('mobility_score_dashboard')) class="nav-item cyan-border {{ Request::RouteIs('mobility.score') ? 'active' : '' }} icon-next" @else class="nav-item ibox-side-menu-disabled-icon icon-next" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>--}}
{{--                    <a @if(CheckDashboardPermission('mobility_score_dashboard')) href="{{ route('mobility.score') }}" @endif class="nav-link {{ Request::RouteIs('mobility.score') ? 'active' : '' }}">--}}
{{--                        <span class=" ">Mobility <br> Score <br> </span>--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"--}}
{{--                             viewBox="0 0 12.858 14.128">--}}
{{--                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">--}}
{{--                                <path id="Path_19238" data-name="Path 19238"--}}
{{--                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"--}}
{{--                                      transform="translate(0.972 5.738)" />--}}
{{--                                <path id="Path_19239" data-name="Path 19239"--}}
{{--                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"--}}
{{--                                      transform="translate(0.972 0.973)" />--}}
{{--                            </g>--}}
{{--                        </svg>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <div class="borderline"></div>
                <li @if(PermitedStatus('stranded_dashboard')) class="nav-item cyan-border {{ Request::RouteIs('site.stranded_patients') ? 'active' : '' }} icon-next " @else  class="nav-item icon-next ibox-side-menu-disabled-icon"  onclick="CommonLoginModalPopupOpenOnRequest();"  @endif >
                    <a @if(PermitedStatus('stranded_dashboard'))  href="{{ route('site.stranded_patients') }}" class="nav-link {{ Request::RouteIs('site.stranded_patients') ? 'active' : '' }}" @else class="nav-link" @endif  >
                        <span class=" ">Stranded <br>Patients<br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"
                             viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)" />
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)" />
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(PermitedStatus('r_to_r_view_')) class="nav-item cyan-border {{ Request::RouteIs('reason_reside.dashboard') ? 'active' : '' }} icon-next " @else  class="nav-item icon-next ibox-side-menu-disabled-icon "   onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a  @if(PermitedStatus('r_to_r_view_')) href="{{ route('reason_reside.dashboard') }}" class="nav-link {{ Request::RouteIs('reason_reside.dashboard') ? 'active' : '' }}" @else class="nav-link " @endif >
                        <span class="">Reason  <br>To Reside</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"
                             viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)" />
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)" />
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>

                <li @if(PermitedStatus('discharged_patient_is_view_dashbaord_view')) class="nav-item cyan-border {{ Request::RouteIs('discharges_patient.dashboard') ? 'active' : '' }} icon-next " @else class="nav-item icon-next ibox-side-menu-disabled-icon "  onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
                    <a @if(PermitedStatus('discharged_patient_is_view_dashbaord_view')) href="{{ route('discharges_patient.dashboard') }}" class="nav-link {{ Request::RouteIs('discharges_patient.dashboard') ? 'active' : '' }}" @else class="nav-link" @endif>
                        <span class="">Discharged  <br>Patients</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128"
                             viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)" />
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)" />
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(CheckDashboardPermission('site_office_report_view'))  class="nav-item cyan-border {{ Request::RouteIs('site.office') ? 'active' : '' }} icon-next "  @else class="nav-item ibox-side-menu-disabled-icon icon-next" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckDashboardPermission('site_office_report_view')) href="{{ route('site.office') }}" @endif class="nav-link {{ Request::RouteIs('site.office') ? 'active' : '' }}">
                      <span class=" ">Site Office<br>Text Reports<br> </span>
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
