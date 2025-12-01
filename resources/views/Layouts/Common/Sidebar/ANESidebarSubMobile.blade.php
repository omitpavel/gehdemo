<div class="sidenav-link">
    <span>
        <a href="{{ route('ane_home') }}">Home
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('live_status_view')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('live_status_view')) href="{{ url('/ane/dashboards/accident-and-emergency') }}" @endif class="{{ request()->is('ane/dashboards/accident-and-emergency') ? 'active' : '' }}"> Live Status
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('activity_profile_view')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('activity_profile_view')) href="{{ url('/ane/dashboards/activity-profile') }}" @endif class="{{ request()->is('ane/dashboards/activity-profile') ? 'active' : '' }}">Activity Flow
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('referral_to_speciality')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('referral_to_speciality')) href="{{ url('/ane/dashboards/referral-to-speciality') }}" @endif class="{{ request()->is('ane/dashboards/referral-to-speciality') ? 'active' : '' }}">Speciality Referral
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('ambulance_dashboard')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('ambulance_dashboard')) href="{{ url('/ane/dashboards/ambulance-arrivals') }}" @endif class="{{ request()->is('ane/dashboards/ambulance-arrivals') ? 'active' : '' }}">Ambulance Analytics
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('ed_live_summary_view') || !CheckDashboardPermission('ed_day_summary_view')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('ed_live_summary_view') || CheckDashboardPermission('ed_day_summary_view')) href="{{ url('/ane/dashboards/ed-overview') }}" @endif class="{{ request()->is('ane/dashboards/ed-overview') ? 'active' : '' }}">ED Overview
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>

    <span @if(!CheckDashboardPermission('breach_')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('breach_')) href="{{ url('/ane/dashboards/breach-validation') }}" @endif class="{{ request()->is('ane/dashboards/breach-validation') ? 'active' : '' }}">Breach Validation Tool
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('opel_data_history_page_view')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('opel_data_history_page_view')) href="{{ url('/ane/dashboards/ed-opel') }}" @endif class="{{ request()->is('/ane/dashboards/ed-opel') ? 'active' : '' }}">EMS Data History
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('flow_dashboard_shankey_view')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('flow_dashboard_shankey_view')) href="{{ url('/ane/dashboards/sankey-charts') }}" @endif  class="{{ request()->is('ane/dashboards/sankey-charts') ? 'active' : '' }}">A&E Sankey
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
    <span @if(!CheckDashboardPermission('ane_welcome_screen_view')) class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('ane_welcome_screen_view')) href="{{ url('/ane/dashboards/ed-home') }}" @endif class="{{ request()->is('ane/dashboards/ed-home') ? 'active' : '' }}">Welcome Screen
            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">
                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">
                    <path id="Path_19238" data-name="Path 19238" d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z" transform="translate(0 5.237)"></path>
                    <path id="Path_19239" data-name="Path 19239" d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z" transform="translate(0 0)"></path>
                </g>
            </svg>
        </a>
    </span>
</div>
