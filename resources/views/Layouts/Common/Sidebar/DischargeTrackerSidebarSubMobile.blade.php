
<div class="sidenav-link">
    @if ($favourites_menu->isNotEmpty())
        @foreach ($favourites_menu as $my_menu)
            @if(isset($my_menu->Menus->dashboard_name) && $my_menu->Menus->status == 1)
                <span @if(CheckMultipleDashboardPermission($my_menu->Menus->dashboard_required_permission)) class="{{ Request::routeIs($my_menu->Menus->dashboard_routes) ? 'active' : '' }}" @else  class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                    <a @if(CheckMultipleDashboardPermission($my_menu->Menus->dashboard_required_permission)) href="{{ route($my_menu->Menus->dashboard_routes, ['dtoc_favourites' => 1]) }}" @endif class="{{ Request::RouteIs($my_menu->Menus->dashboard_routes) ? 'active' : '' }}">{{ $my_menu->Menus->dashboard_name }}
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
            @endif
        @endforeach
    @else
        <span @if(CheckDashboardPermission('discharge_tracker_referral_view')) class="{{ Request::routeIs('discharged.referral') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_referral_view')) href="{{ route('discharged.referral') }}" @endif class=" {{ Request::RouteIs('discharged.referral') ? 'active' : '' }}">Referral
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
        <span @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) class="{{ Request::routeIs('discharged.index') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) href="{{ route('discharged.index') }}" @endif class=" {{ Request::RouteIs('discharged.index') ? 'active' : '' }}">CDT Patient List
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
        <span @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) class="{{ Request::routeIs('discharged.removed_patients') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_complex_discharge_view')) href="{{ route('discharged.removed_patients') }}" @endif class=" {{ Request::RouteIs('discharged.removed_patients') ? 'active' : '' }}">Removed Patients
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
        <span @if(CheckDashboardPermission('discharge_tracker_performance_view')) class="{{ Request::routeIs('discharged.performance') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_performance_view')) href="{{ route('discharged.performance') }}" @endif class=" {{ Request::RouteIs('discharged.performance') ? 'active' : '' }}">Performance
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
        <span @if(CheckDashboardPermission('discharge_tracker_medfit')) class="{{ Request::routeIs('discharged.medfit') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_medfit')) href="{{ route('discharged.medfit') }}" @endif class=" {{ Request::RouteIs('discharged.medfit') ? 'active' : '' }}">Med Fit
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
        <span @if(CheckDashboardPermission('discharge_tracker_month_summary_view'))  class="{{ Request::routeIs('discharged.month.summary') ? 'active' : '' }}"  @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_month_summary_view')) href="{{ route('discharged.month.summary') }}" @endif class=" {{ Request::RouteIs('discharged.month.summary') ? 'active' : '' }}">Month Summary
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
        <span  @if(CheckDashboardPermission('discharge_tracker_month_list_summary_view'))  class="{{ Request::routeIs('discharged.monthlist.summary') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_month_list_summary_view'))  href="{{ route('discharged.monthlist.summary') }}" @endif class=" {{ Request::RouteIs('discharged.monthlist.summary') ? 'active' : '' }}">Month List Summary
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
        <span  @if(CheckDashboardPermission('discharge_tracker_patient_search_view')) class="{{ Request::routeIs('discharged.patient.search') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_patient_search_view')) href="{{ route('discharged.patient.search') }}" @endif class=" {{ Request::RouteIs('discharged.patient.search') ? 'active' : '' }}">Patient Search
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
        <span @if(CheckDashboardPermission('discharge_tracker_discharge_view')) class="{{ Request::routeIs('discharged.dischargepatient') ? 'active' : '' }}" @else class="ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
            <a @if(CheckDashboardPermission('discharge_tracker_discharge_view')) href="{{ route('discharged.dischargepatient') }}" @endif class=" {{ Request::RouteIs('discharged.dischargepatient') ? 'active' : '' }}">Discharges
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
    @endif
</div>
