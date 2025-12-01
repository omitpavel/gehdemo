<link rel="stylesheet" href="{{ asset(' ') }}" crossorigin="anonymous">
@php
    $lastSegment = substr(strrchr(request()->url(), '/'), 1);
@endphp
<div class="sidenav-link">
    <span class="{{ $lastSegment == 'one-to-one-care' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', ['virtualward' => 'one-to-one-care']) }}" class="{{ $lastSegment == 'one-to-one-care' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>One To One Care
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
    <span class="{{ $lastSegment == 'frailty' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'frailty') }}" class="{{ $lastSegment == 'frailty' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>Frailty
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
    <span class="{{ $lastSegment == 'diabetics-status' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'diabetics-status') }}" class="{{ $lastSegment == 'diabetics-status' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>Diabetics + Diabetic Foot
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
    <span class="{{ $lastSegment == 'dementia-delirium' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'dementia-delirium') }}" class="{{ $lastSegment == 'dementia-delirium' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>Dementia + Delirium
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
    <span class="{{ $lastSegment == 'risk-of-falls' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{  route('virtual.ward.summary', 'risk-of-falls') }}" class="{{ $lastSegment == 'risk-of-falls' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>Falls
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
    <span class="{{ $lastSegment == 'nutrition-risk' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{  route('virtual.ward.summary', 'nutrition-risk') }}" class="{{ $lastSegment == 'nutrition-risk' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>Nutrition Risk
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
    <span class="{{ $lastSegment == 'pressure-ulcer' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{  route('virtual.ward.summary', 'pressure-ulcer') }}" class="{{ $lastSegment == 'pressure-ulcer' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>Pressure Ulcer
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
    <span class="{{ $lastSegment == 'amber-care-eol' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{  route('virtual.ward.summary', 'amber-care-eol') }}" class="{{ $lastSegment == 'amber-care-eol' ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>Amber Care + End of Life
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
    <span class="{{ $lastSegment == 'sova-dols-ld' ? 'active' : '' }}">
         <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{  route('virtual.ward.summary', 'sova-dols-ld') }}" class="{{ $lastSegment == 'sova-dols-ld' ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>SOVA + DOLS + LD
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
    <span class="{{ $lastSegment == 'palliative-care' ? 'active' : '' }}">
        <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{  route('virtual.ward.summary', 'palliative-care') }}"  class="{{ $lastSegment == 'palliative-care' ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon permission_denied_div" @endif>PALLIATIVE CARE
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
    <span class="{{ Request::RouteIs('bed.status.flag') ? 'active' : '' }}">
        <a    @if(PermitedStatus('bed_flag_dashboard_view')) href="{{ route('bed.status.flag') }}" class="{{ Request::RouteIs('bed.status.flag') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon permission_denied_div"  @endif >Bed Flag Dashboard
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
