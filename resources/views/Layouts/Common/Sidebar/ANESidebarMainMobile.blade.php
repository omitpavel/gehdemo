<div class="sidenav-link">
    <span @if(CheckDashboardPermission('flow_dashboard_') || CheckDashboardPermission('pharmacy_dashboard_view') || CheckDashboardPermission('doctor_at_night_dashboard_view') || CheckDashboardPermission('leaflet_dashboard_view') || CheckDashboardPermission('stranded_dashboard') || CheckDashboardPermission('r_to_r_view_') || CheckDashboardPermission('surgical_wards_dashboard_view') || CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')  || CheckDashboardPermission('site_office_report_view')) class="{{ Request::routeIs('inpatients.siteoverview') ? '' : 'active' }}" @else class="ibox-side-menu-disabled-icon" @endif>
        <a @if(CheckDashboardPermission('flow_dashboard_') || CheckDashboardPermission('pharmacy_dashboard_view') || CheckDashboardPermission('doctor_at_night_dashboard_view') || CheckDashboardPermission('leaflet_dashboard_view') || CheckDashboardPermission('stranded_dashboard') || CheckDashboardPermission('r_to_r_view_') || CheckDashboardPermission('surgical_wards_dashboard_view') || CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')  || CheckDashboardPermission('site_office_report_view')) href="{{ route('inpatients.siteoverview') }}" @endif class="{{ Request::routeIs('inpatients.siteoverview') ? '' : 'active' }}">Flow
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(CheckAnyPermissionWildcard(['live_status_view', 'activity_profile_view', 'referral_to_speciality*', 'ambulance_dashboard*', 'ed_live_summary_view', 'ed_day_summary_view', 'breach_*','flow_dashboard_shankey_view', 'ane_welcome_screen_view'])) class="{{ Request::routeIs('ane_home') ? '' : 'active' }}"  @else class="ibox-side-menu-disabled-icon" @endif>
        <a @if(CheckAnyPermissionWildcard(['live_status_view', 'activity_profile_view', 'referral_to_speciality*', 'ambulance_dashboard*', 'ed_live_summary_view', 'ed_day_summary_view', 'breach_*','flow_dashboard_shankey_view', 'ane_welcome_screen_view'])) href="{{ route('ane_home') }}" @endif class="{{ Request::routeIs('ane_home') ? 'active' : '' }}">A&E
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(CheckAnyPermissionWildcard(['camis*', 'virtual_ward*', 'pd_dashboard*', 'board_round_dashboard*', 'infection_control*', 'discharge_lounge*'])) class='{{ Request::is('inpatients*') ? '' : 'active' }}'  @else class="ibox-side-menu-disabled-icon" @endif>
        <a @if(CheckAnyPermissionWildcard(['camis*', 'virtual_ward*', 'pd_dashboard*', 'board_round_dashboard*', 'infection_control*', 'discharge_lounge*'])) href="{{ route('ward.dashboard') }}" @endif class=''>Wards
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>


   <span @if(CheckDashboardPermission('dp_dashboard')) class='{{ Request::routeIs('new.patient') ? '' : 'ibox-side-menu-disabled-icon' }}'  @else class="ibox-side-menu-disabled-icon" @endif>

        <a @if(CheckDashboardPermission('dp_dashboard')) href="{{ route('new.patient') }}" @endif class=''>DP Virtual Ward
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(CheckAnyPermissionWildcard($dtoc_permission)) class='active' @else class="ibox-side-menu-disabled-icon" @endif>
        <a @if(CheckAnyPermissionWildcard($dtoc_permission)) href="{{ $dtoc_redirect_url }}" @endif class=''>Discharge Tracker
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span class='{{ Request::routeIs('Live_statusTab') ? '' : 'ibox-side-menu-disabled-icon' }}'>
        <a href="#" class=''>Theatres
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>



    <span class='{{ Request::routeIs('report.dashboard') ? '' : 'ibox-side-menu-disabled-icon' }}'>
        <a href="{{ route('report.dashboard') }}" class=''>Other Dashboard
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
</div>
