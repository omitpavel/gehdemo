
<div class="sidenav-link">
    <span @if(CheckDashboardPermission('camis_classic_view')) class="{{ Request::routeIs('ward.dashboard') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(CheckDashboardPermission('camis_classic_view')) href="{{ route('ward.dashboard') }}"@endif  class="{{ Request::RouteIs('ward.dashboard') ? 'active' : '' }}">Ward View
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
    <span @if(CheckDashboardPermission('camis_list_view_view')) class="{{ Request::routeIs('bed.matrix') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
        <a @if(CheckDashboardPermission('camis_list_view_view')) href="{{ route('bed.matrix') }}" @endif  class="{{ Request::RouteIs('bed.matrix') ? 'active' : '' }}">Bed Management
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
    <span @if(PermitedStatus('pd_dashboard')) class="{{ Request::routeIs('site.pd_discharge') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
        <a @if(PermitedStatus('pd_dashboard')) href="{{ route('site.pd_discharge') }}" @endif   class="{{ Request::RouteIs('site.pd_discharge') ? 'active' : '' }}">P/D Discharge
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
    <span @if(PermitedStatus('board_round_dashboard')) class="{{ Request::routeIs('board_round.dashboard') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon "  onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
        <a @if(PermitedStatus('pd_dashboard')) href="{{ route('board_round.dashboard') }}"  @endif  class="{{ Request::RouteIs('board_round.dashboard') ? 'active' : '' }}">Board Round
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
    <span @if(PermitedStatus('infection_control'))  class="{{ Request::routeIs('infection.index') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon "  onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(PermitedStatus('infection_control')) href="{{ route('infection.index') }}" @endif class="{{ Request::RouteIs('infection.index') ? 'active' : '' }}">Infection Control
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
    <span @if(PermitedStatus('camis_ward_type_performance_page_view'))  class="{{ Request::routeIs('wardtype.ward-performance') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon "  onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
        <a @if(PermitedStatus('camis_ward_type_performance_page_view')) href="{{ route('wardtype.ward-performance') }}" @endif class="{{ Request::RouteIs('wardtype.ward-performance') ? 'active' : '' }}">Directorate
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
{{--    <span class="{{ Request::routeIs('doctor.at.night') ? '' : 'ibox-side-menu-disabled-icon' }}">--}}
{{--        <a href="{{ route('doctor.at.night') }}">Doctor At Night--}}
{{--            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">--}}
{{--                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">--}}
{{--                    <path id="Path_19238" data-name="Path 19238"--}}
{{--                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"--}}
{{--                        transform="translate(0 5.237)"></path>--}}
{{--                    <path id="Path_19239" data-name="Path 19239"--}}
{{--                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"--}}
{{--                        transform="translate(0 0)"></path>--}}
{{--                </g>--}}
{{--            </svg>--}}
{{--        </a>--}}
{{--    </span>--}}
{{--    <span class="{{ Request::routeIs('surgical.ward') ? '' : 'ibox-side-menu-disabled-icon' }}">--}}
{{--        <a href="{{ route('surgical.ward') }}">Surgical Handover--}}
{{--            <svg width="14.132" height="15.528" viewBox="0 0 14.132 15.528">--}}
{{--                <g id="Group_2333" data-name="Group 2333" transform="translate(14.132) rotate(90)" opacity="0.29">--}}
{{--                    <path id="Path_19238" data-name="Path 19238"--}}
{{--                        d="M7.674,0h.178a1.218,1.218,0,0,1,.865.358L15.17,6.811a1.22,1.22,0,0,1-1.724,1.727L7.765,2.854,2.08,8.538A1.22,1.22,0,0,1,.356,6.811L6.81.358A1.228,1.228,0,0,1,7.674,0Z"--}}
{{--                        transform="translate(0 5.237)"></path>--}}
{{--                    <path id="Path_19239" data-name="Path 19239"--}}
{{--                        d="M7.674,0h.178a1.224,1.224,0,0,1,.865.356L15.17,6.811a1.22,1.22,0,0,1-1.724,1.728L7.765,2.855,2.08,8.539A1.221,1.221,0,0,1,.356,6.811L6.81.356A1.234,1.234,0,0,1,7.674,0Z"--}}
{{--                        transform="translate(0 0)"></path>--}}
{{--                </g>--}}
{{--            </svg>--}}
{{--        </a>--}}
{{--    </span>--}}
</div>
