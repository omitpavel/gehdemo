

<div class="sidebar-menu d-none d-lg-block" id="sidebar">
    <nav class="" id="navbar">
        <ul class="">
            <li @if(CheckDashboardPermission('flow_dashboard_') || CheckDashboardPermission('pharmacy_dashboard_view') || CheckDashboardPermission('doctor_at_night_dashboard_view') || CheckDashboardPermission('leaflet_dashboard_view') || CheckDashboardPermission('stranded_dashboard') || CheckDashboardPermission('r_to_r_view_') || CheckDashboardPermission('surgical_wards_dashboard_view') || CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')  || CheckDashboardPermission('site_office_report_view')) class="nav-item cyan-border   {{ Request::RouteIs('inpatients.siteoverview') ? 'active' : '' }} icon-next" @else class="nav-item ibox-side-menu-disabled-icon icon-next" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('flow_dashboard_') || CheckDashboardPermission('pharmacy_dashboard_view') || CheckDashboardPermission('doctor_at_night_dashboard_view') || CheckDashboardPermission('leaflet_dashboard_view') || CheckDashboardPermission('stranded_dashboard') || CheckDashboardPermission('r_to_r_view_') || CheckDashboardPermission('surgical_wards_dashboard_view') || CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')  || CheckDashboardPermission('site_office_report_view')) href="{{ route('inpatients.siteoverview') }}" @endif class="nav-link ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="33" height="30" viewBox="0 0 33 35" fill="currentColor">
                        <g id="Group_2949" data-name="Group 2949" transform="translate(-179 -155.075)">
                            <path id="Path_22097" data-name="Path 22097" d="M29.384,23.687V17.646a2.351,2.351,0,0,0-2.351-2.351h-9.4V9.254a4.7,4.7,0,1,0-2.351,0v6.041h-9.4a2.351,2.351,0,0,0-2.351,2.351v6.041a4.7,4.7,0,1,0,2.351,0V17.646H27.033v6.041a4.7,4.7,0,1,0,2.351,0ZM7.052,28.224A2.351,2.351,0,1,1,4.7,25.873,2.351,2.351,0,0,1,7.052,28.224ZM14.1,4.717a2.351,2.351,0,1,1,2.351,2.351A2.351,2.351,0,0,1,14.1,4.717Zm14.1,25.858a2.351,2.351,0,1,1,2.351-2.351A2.351,2.351,0,0,1,28.208,30.574Z" transform="translate(179 155.075)"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Flow</span>
                </a>
            </li>
            <div class="borderline"></div>

            <li @if(!CheckAnyPermissionWildcard(['live_status_view', 'activity_profile_view', 'referral_to_speciality*', 'ambulance_dashboard*', 'ed_live_summary_view', 'ed_day_summary_view', 'breach_*','flow_dashboard_shankey_view', 'ane_welcome_screen_view']))  class="nav-item cyan-border ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @else class="nav-item   {{ Request::RouteIs('ane_home') ? 'cyan-border active' : '' }}" @endif>
                <a @if(CheckAnyPermissionWildcard(['live_status_view', 'activity_profile_view', 'referral_to_speciality*', 'ambulance_dashboard*', 'ed_live_summary_view', 'ed_day_summary_view', 'breach_*','flow_dashboard_shankey_view', 'ane_welcome_screen_view'])) href="{{ route('ane_home') }}" @endif class="nav-link {{ Request::RouteIs('ane_home') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30.73" height="30.73" viewBox="0 0 30.73 30.73" fill="currentColor">
                        <g id="hospital-svgrepo-com" transform="translate(0 0)">
                            <g id="Group_2075" data-name="Group 2075" transform="translate(0 0)">
                                <path id="Path_21009" data-name="Path 21009" d="M22.165,0H8.565A8.6,8.6,0,0,0,0,8.565v13.6A8.6,8.6,0,0,0,8.565,30.73h13.6a8.6,8.6,0,0,0,8.565-8.565V8.565A8.6,8.6,0,0,0,22.165,0Zm6.014,22.165a6,6,0,0,1-6.014,6.014H8.565a6,6,0,0,1-6.014-6.014V8.565A6,6,0,0,1,8.565,2.551h13.6a6,6,0,0,1,6.014,6.014v13.6Z" fill="currentColor"></path>
                                <path id="Path_21010" data-name="Path 21010" d="M126.922,118.457h-5.75v-5.75a1.307,1.307,0,1,0-2.614,0v5.75h-5.75a1.307,1.307,0,0,0,0,2.614h5.75v5.75a1.307,1.307,0,0,0,2.614,0v-5.75h5.75a1.307,1.307,0,0,0,0-2.614Z" transform="translate(-104.493 -104.399)" fill="currentColor"></path>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">A &amp; E<br></span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckAnyPermissionWildcard(['camis*', 'virtual_ward*', 'pd_dashboard*', 'board_round_dashboard*', 'infection_control*', 'discharge_lounge*'])) class="nav-item cyan-border" @else class="nav-item cyan-border ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckAnyPermissionWildcard(['camis*', 'virtual_ward*', 'pd_dashboard*', 'board_round_dashboard*', 'infection_control*', 'discharge_lounge*'])) href="{{ route('ward.dashboard') }}" @endif class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" viewBox="0 0 51.824 31.852" fill="currentColor">
                        <g id="Group_2945" data-name="Group 2945" transform="translate(0)">
                            <path id="Path_20625" data-name="Path 20625" d="M19.969,2652.526v1.513H34.635v-1.513H19.969Zm15.964,0v1.513h4.409A3.477,3.477,0,0,1,44,2657.691v3.135a3.086,3.086,0,1,1-1.449-.012h0v-3.138a2.009,2.009,0,0,0-1.941-2.128H35.933v1.587h3.734a.814.814,0,0,1,.812.812h0a.814.814,0,0,1-.812.812H30.9a.814.814,0,0,1-.812-.812h0a.814.814,0,0,1,.812-.812h3.734v-1.587H19.969v3.7h4.708a.814.814,0,0,1,.812.812h0a.814.814,0,0,1-.812.812H13.827a.814.814,0,0,1-.812-.812h0a.814.814,0,0,1,.812-.812h4.843v-3.7H11.5c-1.16.256-2.055.769-2.1,2.1v3.222a3.087,3.087,0,1,1-1.65.037V2657.9c-.011-2.339,1.316-3.492,3.529-3.859h7.4v-1.513H2c-3.175-.834-2.114-4.649,0-4.683h9.366a.788.788,0,0,1,.034,1.53H2.209a.793.793,0,0,0,0,1.562l46.021-.022c3.486-.9,1.669-4.76,0-4.617l-29.676-.021a4.579,4.579,0,0,1-3.45-1.4l-8.021-8.031c-.591-.577-1.548.367-1.157,1l8.2,8.322a6.874,6.874,0,0,0,5.307,1.64h28.7a.79.79,0,0,1,0,1.511H17.895c-1.962.139-3.665-.9-5.256-2.454l-8.115-8.3c-1.114-2.423,2.058-4.608,3.624-2.786l7.793,7.726c1.49,1.279,1.864,1.083,4.057,1.141H48.56c3.457.694,5.147,6.252,0,7.884H35.934Zm7.313,9.726a1.569,1.569,0,1,1-1.569,1.569A1.569,1.569,0,0,1,43.247,2662.251Zm-34.612.044a1.569,1.569,0,1,1-1.569,1.569A1.569,1.569,0,0,1,8.635,2662.3Z" transform="translate(0.007 -2635.099)" fill-rule="evenodd"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Wards <br> </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li  @if(CheckDashboardPermission('dp_dashboard')) class="nav-item cyan-border " @else class="nav-item cyan-border ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a  @if(CheckDashboardPermission('dp_dashboard')) href="{{ route('new.patient') }}" @endif  class="nav-link  {{ Request::RouteIs('new.patient') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 36.36 27.276" fill="currentColor">
                        <path id="Union_156" data-name="Union 156" d="M27.382,27.275H20.833l-2.06-6.4,2.993-9.259,2.367,7.635L30.2,0H36.36L27.383,27.276Zm-18.6,0L0,0H6.113l5.968,19.254L18.146,0h6.163L15.332,27.276ZM14.4,7.285,12.052,0h4.717L14.4,7.285v0Z"></path>
                    </svg>
                    <br>
                    <span class="link-name">DP Virtual <br> Ward </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckAnyPermissionWildcard($dtoc_permission)) class="nav-item cyan-border" @else class="nav-item cyan-border ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                <a @if(CheckAnyPermissionWildcard($dtoc_permission)) href="{{ $dtoc_redirect_url }}" @endif class="nav-link  {{ Request::RouteIs('discharged.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_x0020_1" width="30" height="30" viewBox="0 0 33.572 32.991" fill="currentColor">
                        <path id="Path_20620" data-name="Path 20620" d="M2.491-.031H22.5a2.5,2.5,0,0,1,2.49,2.49V4.684H23.548V2.8A1.423,1.423,0,0,0,22.129,1.38H2.866A1.423,1.423,0,0,0,1.447,2.8V30.13a1.423,1.423,0,0,0,1.419,1.419H22.129a1.423,1.423,0,0,0,1.419-1.419V17h1.446V30.469a2.5,2.5,0,0,1-2.49,2.49H2.491A2.5,2.5,0,0,1,0,30.469V2.46a2.5,2.5,0,0,1,2.49-2.49ZM20.1,10.287,29.4,3.48c2.507-1.836,6.018,1.966,3.031,4.154l-9.294,6.807c-2.7,1.975-5.835-2.1-3.031-4.154Zm.779.835,9.019-6.5c1.464-1.056,3.388,1.165,1.718,2.354L22.88,13.194c-1.982,1.412-3.412-1.054-2-2.073Zm-2.973-.087c-.01,3.925.108,3.91,3.881,5.355l-7.026.935,3.145-6.29Zm-.554,4.058.458.539-.931.171Zm-12.89,12.3V26.013H21.191v1.379Zm0-3.839V22.174H21.191v1.379Zm0-3.931V18.243H21.234v1.379Zm0-3.7V14.54h7.961V15.92Zm.233-7.7V6.839H7.061V4.474H8.44V6.839h2.365V8.218H8.44v2.365H7.061V8.218Z" transform="translate(0 0.031)" fill-rule="evenodd"></path>
                    </svg>
                    <br>
                    <span class="link-name">Discharge <br> Tracker </span>
                </a>
            </li>

            <div class="borderline"></div>
            <li class="nav-item cyan-border ibox-side-menu-disabled-icon">
                <a class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 35.519 32.479" fill="currentColor">
                        <path id="medical-operation-svgrepo-com" d="M12.635,35.554H33.772v-1.32a.873.873,0,0,1,1.746,0v2.193a.873.873,0,0,1-.873.873H12.635a.873.873,0,0,1,0-1.746Zm8.337-1.146a.873.873,0,0,0,1.173-.386c.734-1.454,1.558-2.047,2.847-2.047H26.8c1.288,0,2.113.593,2.847,2.047a.873.873,0,1,0,1.559-.787A4.743,4.743,0,0,0,26.8,30.23H24.991a4.743,4.743,0,0,0-4.406,3.006A.873.873,0,0,0,20.972,34.408Zm.509-9.463a4.162,4.162,0,0,1,2.687-3.889,4.156,4.156,0,1,1,5.594,4.393,4.156,4.156,0,0,1-8.281-.5Zm4.4-3.383c0,.038,0,.076,0,.114,0,0,0,0,0,0v.012a2.413,2.413,0,0,0,2.4,2.28h.023a2.439,2.439,0,0,0,.287-.019h0a2.41,2.41,0,1,0-2.713-2.391Zm-2.656,3.383a2.41,2.41,0,0,0,4.7.757,4.151,4.151,0,0,1-3.568-2.8A2.414,2.414,0,0,0,23.227,24.946Zm-16.058,4.7a3.828,3.828,0,1,1-3.828,3.828A3.832,3.832,0,0,1,7.168,29.645Zm0,1.746A2.081,2.081,0,1,0,9.25,33.473,2.084,2.084,0,0,0,7.168,31.391Zm28.35,17.622a.873.873,0,0,1-.873.873H.873a.873.873,0,1,1,0-1.746H4.221V40.759H.873A.873.873,0,0,1,0,39.886c0-.006,0-.012,0-.018V24.027a5.1,5.1,0,0,1,5.094-5.094H8.073A6.347,6.347,0,0,1,14.351,24.4h3.408a.873.873,0,1,1,0,1.746H9.316a.873.873,0,1,1,0-1.746h3.265a4.6,4.6,0,0,0-4.508-3.718H5.094a3.352,3.352,0,0,0-3.348,3.348V39.013h32.9a.873.873,0,1,1,0,1.746H31.3V48.14h3.348A.873.873,0,0,1,35.519,49.013Zm-5.968-8.254H5.967V48.14H29.551V40.759ZM28.293,22.528a.965.965,0,1,0-.965-.965A.965.965,0,0,0,28.293,22.528Z" transform="translate(0 -17.407)" fill-rule="evenodd"></path>
                    </svg>
                    <br>
                    <span class="link-name">Theatres <br> </span>
                </a>
            </li>

            <div class="borderline"></div>
            <li class="nav-item cyan-border ibox-side-menu-disabled-icon">
                <a  class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" id="i-outpatient-svgrepo-com" width="24" height="35" viewBox="0 0 24.729 44.242" fill="currentColor">
                        <path id="Path_20621" data-name="Path 20621" d="M28.511,8.057a3.706,3.706,0,1,0-3.4-3.986,3.711,3.711,0,0,0,3.4,3.986Z" transform="translate(-18.122 -0.657)"></path>
                        <path id="Path_20622" data-name="Path 20622" d="M26.681,18.975a2.506,2.506,0,0,1-.48,4.965H18.083a1.591,1.591,0,0,1-1.473-2.193l.878-2.049,9.776-7H22.606a3.705,3.705,0,0,0-3.767,1.981c-.489.948-3.083,6.745-3.083,6.745a2.505,2.505,0,0,0,2.328,3.434h3.171l-.935,6.15L15.4,45.228a2.394,2.394,0,0,0,4.546,1.5L25.6,30.686c1.1,1.793,3.3,5.007,3.674,5.614.086,1.009.876,9.905.876,9.905a2.394,2.394,0,1,0,4.769-.425l-.93-10.47a2.348,2.348,0,0,0-.348-1.045l-4.068-6.594.648-8.275s.964,3.275,1.035,3.511a3.25,3.25,0,0,0,1.15,1.548c.28.223,5.029,3.455,5.029,3.455a2.088,2.088,0,0,0,.763.249,1.672,1.672,0,0,0,1.145-3s-4.732-3.249-4.924-3.39a1,1,0,0,1-.312-.433L32.238,14.6A2.751,2.751,0,0,0,29.6,12.7h-.56L26.68,18.976Z" transform="translate(-15.276 -4.146)"></path>
                        <path id="Path_20623" data-name="Path 20623" d="M30.256,25.95a1.585,1.585,0,0,0,.17-3.162L29.265,25.96Z" transform="translate(-19.331 -7.071)"></path>
                    </svg>
                    <br>
                    <span class="link-name">Outpatients <br></span>
                </a>
            </li>
            <div class="borderline"></div>
        </ul>
    </nav>
</div>
