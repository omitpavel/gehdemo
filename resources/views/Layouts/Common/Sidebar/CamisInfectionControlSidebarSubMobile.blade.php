
<div class="sidenav-link">
    <span @if(CheckDashboardPermission('infection_control_ic_patients_view')) class="{{ Request::routeIs('infection.index') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif  >
        <a @if(CheckDashboardPermission('infection_control_sideroom_tools_view')) href="{{ route('infection.index') }}" @endif class="{{ Request::RouteIs('infection.index') ? 'active' : '' }}">IC Patients
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238"
                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"
                        transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239"
                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"
                        transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(CheckDashboardPermission('infection_control_sideroom_tools_view'))  class="{{ Request::routeIs('infection.sideroom.patients') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
        <a @if(CheckDashboardPermission('infection_control_sideroom_tools_view'))  href="{{ route('infection.sideroom.patients') }}"@endif class="{{ Request::RouteIs('infection.sideroom.patients') ? 'active' : '' }}">Side Room Tool
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238"
                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"
                        transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239"
                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"
                        transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>

     <span @if(CheckDashboardPermission('infection_control_ipc_sideroom_tools_view'))  class="{{ Request::routeIs('infection.ipc.sideroom.patients') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
        <a @if(CheckDashboardPermission('infection_control_ipc_sideroom_tools_view'))  href="{{ route('infection.ipc.sideroom.patients') }}"@endif class="{{ Request::RouteIs('infection.ipc.sideroom.patients') ? 'active' : '' }}">IPC Side Room Tool
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238"
                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"
                        transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239"
                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"
                        transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>


    <span @if(CheckDashboardPermission('infection_control_covid_wards_view')) class="{{ Request::routeIs('infection.covid.ward') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
        <a @if(CheckDashboardPermission('infection_control_covid_wards_view')) href="{{ route('infection.covid.ward') }}" @endif class="{{ Request::RouteIs('infection.covid.ward') ? 'active' : '' }}">Outbreak Wards
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238"
                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"
                        transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239"
                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"
                        transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    {{-- <span @if(CheckDashboardPermission('infection_control_covid_siterep_view')) class="{{ Request::routeIs('infection.covid.sitrep') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
        <a @if(CheckDashboardPermission('infection_control_covid_siterep_view')) href="{{ route('infection.covid.sitrep') }}"@endif  class="{{ Request::RouteIs('infection.covid.sitrep') ? 'active' : '' }}">COVID-19 SITREP
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238"
                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"
                        transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239"
                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"
                        transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>--}}

    <span @if(CheckDashboardPermission('infection_control_covid_contact_tracing_view')) class="{{ Request::routeIs('infection.ontact.tracing') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
        <a @if(CheckDashboardPermission('infection_control_covid_contact_tracing_view')) href="{{ route('infection.contact.tracing') }}" @endif class="{{ Request::RouteIs('infection.covid.sitrep') ? 'active' : '' }}">CONTACT TRACING
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238"
                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"
                        transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239"
                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"
                        transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>

</div>
