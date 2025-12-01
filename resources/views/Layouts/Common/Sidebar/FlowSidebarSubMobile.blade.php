
<div class="sidenav-link">
    <span @if(CheckDashboardPermission('flow_dashboard_siteoverview_view')) class="{{ Request::routeIs('inpatients.siteoverview') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
        <a @if(CheckDashboardPermission('flow_dashboard_siteoverview_view')) href="{{ route('inpatients.siteoverview') }}" @endif class="{{ Request::RouteIs('inpatients.siteoverview') ? 'active' : '' }}" >Site Overview
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


    <span  @if(CheckDashboardPermission('flow_dashboard_red_bed_view') || CheckDashboardPermission('flow_dashboard_redbed_performance_view')) class="{{ Request::routeIs('red.bed.dashboard') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('flow_dashboard_red_bed_view') || CheckDashboardPermission('flow_dashboard_redbed_performance_view')) href="{{ route('red.bed.dashboard') }}" @endif  class="{{ Request::RouteIs('red.bed.dashboard') ? 'active' : '' }}">Red to Green
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
{{--    <span  @if(CheckDashboardPermission('leaflet_dashboard_view')) class="{{ Request::routeIs('virtual.ward.leaflet') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>--}}
{{--        <a @if(CheckDashboardPermission('leaflet_dashboard_view')) href="{{ route('virtual.ward.leaflet') }}" @endif  class="{{ Request::RouteIs('virtual.ward.leaflet') ? 'active' : '' }}">Leaflet 01--}}
{{--            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">--}}
{{--                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">--}}
{{--                    <path id="Path_19238" data-name="Path 19238"--}}
{{--                          d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"--}}
{{--                          transform="translate(0 5.237)"></path>--}}
{{--                    <path id="Path_19239" data-name="Path 19239"--}}
{{--                          d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"--}}
{{--                          transform="translate(0 0)"></path>--}}
{{--                </g>--}}
{{--            </svg>--}}
{{--        </a>--}}
{{--    </span>--}}
    <span  @if(CheckDashboardPermission('stranded_dashboard')) class="{{ Request::routeIs('site.stranded_patients') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('stranded_dashboard')) href="{{ route('site.stranded_patients') }}" @endif  class="{{ Request::RouteIs('site.stranded_patients') ? 'active' : '' }}"> Patients By LOS
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
    <span  @if(CheckDashboardPermission('r_to_r_view_')) class="{{ Request::routeIs('reason_reside.dashboard') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('r_to_r_view_')) href="{{ route('reason_reside.dashboard') }}" @endif  class="{{ Request::RouteIs('reason_reside.dashboard') ? 'active' : '' }}">Reason To Reside
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
    <span  @if(CheckDashboardPermission('allowed_to_move_dashboard_view')) class="{{ Request::routeIs('allowed_to_move.dashboard') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('allowed_to_move_dashboard_view')) href="{{ route('allowed_to_move.dashboard') }}" @endif  class="{{ Request::RouteIs('allowed_to_move.dashboard') ? 'active' : '' }}">Allowed To Move
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
    <span  @if(CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')) class="{{ Request::routeIs('discharges_patient.dashboard') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')) href="{{ route('discharges_patient.dashboard') }}" @endif  class="{{ Request::RouteIs('discharges_patient.dashboard') ? 'active' : '' }}">Discharged Patients
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
    {{-- <span  @if(CheckDashboardPermission('site_office_report_view')) class="{{ Request::routeIs('site.office') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('site_office_report_view')) href="{{ route('site.office') }}" @endif  class="{{ Request::RouteIs('site.office') ? 'active' : '' }}">Site Office Text Reports
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
    </span> --}}
    <span  @if(CheckDashboardPermission('flow_dashboard_patient_search_view')) class="{{ Request::routeIs('global.patient.search') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('flow_dashboard_patient_search_view')) href="{{ route('global.patient.search') }}" @endif  class="{{ Request::RouteIs('global.patient.search') ? 'active' : '' }}">Patient Search
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
    <span @if(CheckDashboardPermission('pharmacy_dashboard_')) class="{{ Request::routeIs('pharmacy.dashboard') ? 'active' : '' }}" @else  class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('pharmacy_dashboard_')) href="{{ route('pharmacy.dashboard') }}" @endif class="{{ Request::RouteIs('pharmacy.dashboard') ? 'active' : '' }}">Pharmacy Dashboard
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
