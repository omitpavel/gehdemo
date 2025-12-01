
<div class="sidenav-link">
    <span @if(CheckDashboardPermission('discharge_lounge_summary_view')) class="{{ Request::routeIs('discharge.lounge.patients') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('discharge_lounge_summary_view')) href="{{ route('discharge.lounge.patients') }}" @endif class=" {{ Request::RouteIs('discharge.lounge.patients') ? 'active' : '' }}">Patients
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
{{--    <span @if(CheckDashboardPermission('discharge_lounge_awating_referral_view')) class="{{ Request::routeIs('discharge.lounge.waiting-referral') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>--}}
{{--        <a @if(CheckDashboardPermission('discharge_lounge_awating_referral_view')) href="{{ route('discharge.lounge.waiting-referral') }}" @endif class=" {{ Request::RouteIs('discharge.lounge.waiting-referral') ? 'active' : '' }}">Awaiting Referral--}}
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
    <span @if(CheckDashboardPermission('discharge_lounge_summary_view'))  class="{{ Request::routeIs('discharge.lounge.summary') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('discharge_lounge_summary_view')) href="{{ route('discharge.lounge.summary') }}" @endif class=" {{ Request::RouteIs('discharge.lounge.summary') ? 'active' : '' }}">Summary
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
    <span  @if(CheckDashboardPermission('discharge_lounge_week_summary_view'))  class="{{ Request::routeIs('discharge.lounge.summaryweek') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('discharge_lounge_week_summary_view'))  href="{{ route('discharge.lounge.summaryweek') }}" @endif class=" {{ Request::RouteIs('discharge.lounge.summaryweek') ? 'active' : '' }}">Week Summary
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
    <span  @if(CheckDashboardPermission('discharge_lounge_month_summary_view')) class="{{ Request::routeIs('discharge.lounge.summarymonth') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('discharge_lounge_month_summary_view')) href="{{ route('discharge.lounge.summarymonth') }}" @endif class=" {{ Request::RouteIs('discharge.lounge.summarymonth') ? 'active' : '' }}">Month Summary
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
    <span @if(CheckDashboardPermission('discharge_lounge_out_view')) class="{{ Request::routeIs('discharge.lounge.outofoffice') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('discharge_lounge_out_view')) href="{{ route('discharge.lounge.outofoffice') }}" @endif class=" {{ Request::RouteIs('discharge.lounge.outofoffice') ? 'active' : '' }}">Out Of Office
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
