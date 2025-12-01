<link rel="stylesheet" href="{{ asset(' ') }}" crossorigin="anonymous">

<div class="sidenav-link">

    <span @if(CheckDashboardPermission('dp_dashboard_new_patients_view')) class="{{ Request::is('new.patient') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('dp_dashboard_new_patients_view')) href="{{ route('new.patient') }}" @endif class="{{ Request::RouteIs('new.patient') ? 'active' : '' }}">New Patients
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
    <span @if(CheckDashboardPermission('dp_dashboard_reviewed_patients_view'))  class="{{ Request::is('reviewed.patient') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('dp_dashboard_reviewed_patients_view')) href="{{ route('reviewed.patient') }}"  @endif class="{{ Request::RouteIs('reviewed.patient') ? 'active' : '' }}">Reviewed Patients
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
    <span @if(CheckDashboardPermission('dp_dashboard_removed_patients_view')) class="{{ Request::is('removed.patient') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('dp_dashboard_removed_patients_view')) href="{{ route('removed.patient') }}"  @endif class="{{ Request::RouteIs('removed.patient') ? 'active' : '' }}">Removed Patients
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
    <span @if(CheckDashboardPermission('dp_dashboard_dp_summary_view')) class="{{ Request::is('DPSummaryMenu') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('dp_dashboard_dp_summary_view')) href="{{ route('DPSummaryMenu') }}"  @endif class="{{ Request::RouteIs('DPSummaryMenu') ? 'active' : '' }}">DP Summary
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
    <span  @if(CheckDashboardPermission('dp_dashboard_patient_search_view')) class="{{ Request::is('patient.search') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('dp_dashboard_patient_search_view')) href="{{ route('patient.search') }}"  @endif class="{{ Request::RouteIs('patient.search') ? 'active' : '' }}">Patient Search
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
    <span  @if(CheckDashboardPermission('dp_dashboard_summary_view')) class="{{ Request::is('patient.task.summary') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('dp_dashboard_summary_view')) href="{{ route('patient.task.summary') }}" @endif class="{{ Request::RouteIs('patient.task.summary') ? 'active' : '' }}">Summary
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
