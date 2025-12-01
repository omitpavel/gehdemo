

<div class="sidebar-menu d-none d-lg-block" id="sidebar">
    <nav class="" id="navbar">
        <ul class="">
            <li class="nav-item cyan-border">
                <a @if(Request::RouteIs('ward.dashboard') || request()->has('favourites')) href="{{ route('home') }}" @else href="{{ route('ward.dashboard') }}" @endif class="nav-link ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31.156 29.096"
                         fill="currentColor">
                        <g id="home-svgrepo-com" transform="translate(-0.946 -2.25)">
                            <path id="Path_22090" data-name="Path 22090" d="M31.048,22H2" transform="translate(0 8.596)"
                                  fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22091" data-name="Path 22091"
                                  d="M2,14.238,13.8,4.8a4.357,4.357,0,0,1,5.444,0l11.8,9.442" transform="translate(0 0.381)"
                                  fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22092" data-name="Path 22092"
                                  d="M15.5,6.631v-2.9A.726.726,0,0,1,16.226,3h3.631a.726.726,0,0,1,.726.726v7.262"
                                  transform="translate(6.107)" fill="none" stroke="currentColor" stroke-linecap="round"
                                  stroke-width="1.5" />
                            <path id="Path_22093" data-name="Path 22093" d="M4,27.655V9.5" transform="translate(0.905 2.941)"
                                  fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22094" data-name="Path 22094" d="M20,27.655V9.5" transform="translate(8.143 2.941)"
                                  fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" />
                            <path id="Path_22095" data-name="Path 22095"
                                  d="M17.714,25.619V18.357c0-2.054,0-3.081-.638-3.719S15.411,14,13.357,14s-3.081,0-3.719.638S9,16.3,9,18.357v7.262"
                                  transform="translate(3.167 4.976)" fill="none" stroke="currentColor" stroke-width="1.5" />
                            <path id="Path_22096" data-name="Path 22096"
                                  d="M15.81,10.4a2.9,2.9,0,1,1-2.9-2.9A2.9,2.9,0,0,1,15.81,10.4Z" transform="translate(3.619 2.036)"
                                  fill="none" stroke="currentColor" stroke-width="1.5" />
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Home</span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('camis_classic_view')) class="nav-item cyan-border {{ Request::RouteIs('ward.dashboard') ? 'active' : '' }} " @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('camis_classic_view')) href="{{ route('ward.dashboard') }}" @endif class="nav-link {{ Request::RouteIs('ward.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 33 33" fill="currentColor">
                        <g id="Group_2864" data-name="Group 2864" transform="translate(13494 13164)">
                            <path id="Path_21630" data-name="Path 21630"
                                  d="M29.107,16.357H19.679a2.36,2.36,0,0,0-2.357,2.357v7.071H4.357V14H2V32.857H4.357V28.143H32.643v4.714H35V22.25a5.9,5.9,0,0,0-5.893-5.893Zm3.536,9.429H19.679V18.714h9.429a3.54,3.54,0,0,1,3.536,3.536Z"
                                  transform="translate(-13496 -13163.857)" fill="currentColor" />
                            <path id="Path_21631" data-name="Path 21631"
                                  d="M10.125,17.357a1.768,1.768,0,1,1-1.768,1.768,1.768,1.768,0,0,1,1.768-1.768m0-2.357a4.125,4.125,0,1,0,4.125,4.125A4.125,4.125,0,0,0,10.125,15Z"
                                  transform="translate(-13495.286 -13163.679)" fill="currentColor" />
                            <path id="Path_21632" data-name="Path 21632"
                                  d="M22.786,6.714H18.071V2H15.714V6.714H11V9.071h4.714v4.714h2.357V9.071h4.714Z"
                                  transform="translate(-13494.393 -13166)" fill="currentColor" />
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Ward View <br></span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('camis_list_view_view')) class="nav-item cyan-border  {{ Request::RouteIs('bed.matrix') ? 'active' : '' }} "  @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('camis_list_view_view')) href="{{ route('bed.matrix') }}" @endif class="nav-link {{ Request::RouteIs('bed.matrix') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" viewBox="0 0 28 20" fill="currentColor">
                        <g id="patient-bed-hospital-svgrepo-com" transform="translate(-2 -6)">
                            <path id="Path_21633" data-name="Path 21633"
                                  d="M15,9H13a1,1,0,0,0,0,2h2l-.006,2a1,1,0,1,0,2,.006L17,11h2a1,1,0,0,0,0-2H17l.006-2a1,1,0,0,0-2-.006L15,9Z"
                                  fill-rule="evenodd" />
                            <path id="Path_21634" data-name="Path 21634"
                                  d="M5.992,23v2a1,1,0,0,0,2,0V23h16v2a1,1,0,0,0,2,0V23H27a3,3,0,0,0,3-3V14a1,1,0,0,0-2,0v3H11V15.981a3,3,0,0,0-3-3H4V11.5a1,1,0,0,0-2,0V20a3,3,0,0,0,3,3ZM28,19H4v1a1,1,0,0,0,1,1H27a1,1,0,0,0,1-1ZM4,14.981V17H9V15.981a1,1,0,0,0-1-1Z"
                                  fill-rule="evenodd" />
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Bed <br> Management <br> </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('pd_dashboard')) class="nav-item cyan-border {{ Request::RouteIs('site.pd_discharge') ? 'active' : '' }}   "@else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('pd_dashboard') }}"  @endif >
                <a @if(PermitedStatus('pd_dashboard')) href="{{ route('site.pd_discharge') }}"  @endif class="nav-link {{ Request::RouteIs('site.pd_discharge') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 23.118 30.704"
                         fill="currentColor">
                        <g id="medical-result-svgrepo-com" transform="translate(-63.247)">
                            <g id="Group_2851" data-name="Group 2851" transform="translate(63.247)">
                                <g id="Group_2850" data-name="Group 2850" transform="translate(0)">
                                    <path id="Path_21623" data-name="Path 21623"
                                          d="M85.763,0H63.849a.6.6,0,0,0-.6.6V30.1a.6.6,0,0,0,.6.6H85.763a.6.6,0,0,0,.6-.6V.6A.6.6,0,0,0,85.763,0Zm-.6,29.5H64.451V1.2h20.71V29.5Z"
                                          transform="translate(-63.247)" />
                                </g>
                            </g>
                            <g id="Group_2853" data-name="Group 2853" transform="translate(68.605 18.649)">
                                <g id="Group_2852" data-name="Group 2852" transform="translate(0)">
                                    <path id="Path_21624" data-name="Path 21624"
                                          d="M154.523,310.987H153.2a.6.6,0,1,0,0,1.2h1.324a.6.6,0,1,0,0-1.2Z"
                                          transform="translate(-152.597 -310.987)" />
                                </g>
                            </g>
                            <g id="Group_2855" data-name="Group 2855" transform="translate(71.856 18.649)">
                                <g id="Group_2854" data-name="Group 2854" transform="translate(0)">
                                    <path id="Path_21625" data-name="Path 21625"
                                          d="M215.357,310.987H207.41a.6.6,0,1,0,0,1.2h7.947a.6.6,0,1,0,0-1.2Z"
                                          transform="translate(-206.808 -310.987)" />
                                </g>
                            </g>
                            <g id="Group_2857" data-name="Group 2857" transform="translate(68.605 21.539)">
                                <g id="Group_2856" data-name="Group 2856" transform="translate(0)">
                                    <path id="Path_21626" data-name="Path 21626"
                                          d="M154.523,359.175H153.2a.6.6,0,0,0,0,1.2h1.324a.6.6,0,1,0,0-1.2Z"
                                          transform="translate(-152.597 -359.175)" />
                                </g>
                            </g>
                            <g id="Group_2859" data-name="Group 2859" transform="translate(71.856 21.539)">
                                <g id="Group_2858" data-name="Group 2858" transform="translate(0)">
                                    <path id="Path_21627" data-name="Path 21627"
                                          d="M215.357,359.175H207.41a.6.6,0,0,0,0,1.2h7.947a.6.6,0,1,0,0-1.2Z"
                                          transform="translate(-206.808 -359.175)" />
                                </g>
                            </g>
                            <g id="Group_2861" data-name="Group 2861" transform="translate(69.749 6.378)">
                                <g id="Group_2860" data-name="Group 2860" transform="translate(0)">
                                    <path id="Path_21628" data-name="Path 21628"
                                          d="M176.728,106.362a5.057,5.057,0,1,0,5.057,5.057A5.063,5.063,0,0,0,176.728,106.362Zm0,8.91a3.853,3.853,0,1,1,3.853-3.853A3.857,3.857,0,0,1,176.728,115.272Z"
                                          transform="translate(-171.671 -106.362)" />
                                </g>
                            </g>
                            <g id="Group_2863" data-name="Group 2863" transform="translate(72.037 8.833)">
                                <g id="Group_2862" data-name="Group 2862" transform="translate(0)">
                                    <path id="Path_21629" data-name="Path 21629"
                                          d="M214.757,149.462h-1.565V147.9a.6.6,0,0,0-1.2,0v1.565h-1.565a.6.6,0,0,0,0,1.2h1.565v1.565a.6.6,0,0,0,1.2,0v-1.565h1.565a.6.6,0,0,0,0-1.2Z"
                                          transform="translate(-209.82 -147.295)" />
                                </g>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Definite / <br> Potential <br> Discharges </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('board_round_dashboard')) class="nav-item cyan-border {{ Request::RouteIs('board_round.dashboard') ? 'active' : '' }} " @else  class="nav-item  ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
                <a @if(PermitedStatus('board_round_dashboard'))  href="{{ route('board_round.dashboard') }}" @endif class="nav-link {{ Request::RouteIs('board_round.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="doctor-surgeon-svgrepo-com" width="30" height="30"
                         viewBox="0 0 31.867 31.867" fill="currentColor">
                        <g id="Group_2835" data-name="Group 2835" transform="translate(16.658 23.176)">
                            <g id="Group_2834" data-name="Group 2834">
                                <circle id="Ellipse_914" data-name="Ellipse 914" cx="1.448" cy="1.448" r="1.448" />
                            </g>
                        </g>
                        <g id="Group_2837" data-name="Group 2837" transform="translate(3.621)">
                            <g id="Group_2836" data-name="Group 2836">
                                <path id="Path_21622" data-name="Path 21622"
                                      d="M71.44,17.382h-.019a3.584,3.584,0,0,0,.743-2.173V10.864a2.173,2.173,0,0,0,0-4.346v-2.9A3.625,3.625,0,0,0,68.543,0H62.749a3.625,3.625,0,0,0-3.621,3.621v2.9a2.173,2.173,0,1,0,0,4.346v4.346a3.584,3.584,0,0,0,.743,2.173h-.019A6.525,6.525,0,0,0,53.334,23.9v7.243a.724.724,0,0,0,.724.724H77.234a.724.724,0,0,0,.724-.724V23.9A6.525,6.525,0,0,0,71.44,17.382Zm.724-9.415a.724.724,0,0,1,0,1.449ZM59.128,9.415a.724.724,0,0,1,0-1.449Zm1.448-5.794a2.175,2.175,0,0,1,2.173-2.173h5.794a2.175,2.175,0,0,1,2.173,2.173V5.07H60.576Zm0,6.318V6.518h10.14v4.346H60.576Zm0,2.373h10.14v2.9a2.175,2.175,0,0,1-2.173,2.173H62.749a2.175,2.175,0,0,1-2.173-2.173ZM76.51,30.419H72.165V23.9a.724.724,0,1,0-1.449,0v6.518H60.576V23.9a.724.724,0,1,0-1.449,0v6.518H54.782V23.9a5.076,5.076,0,0,1,5.07-5.07H71.44a5.076,5.076,0,0,1,5.07,5.07Z"
                                      transform="translate(-53.334)" />
                            </g>
                        </g>
                        <g id="Group_2839" data-name="Group 2839" transform="translate(0 13.761)">
                            <g id="Group_2838" data-name="Group 2838">
                                <circle id="Ellipse_915" data-name="Ellipse 915" cx="0.724" cy="0.724" r="0.724" />
                            </g>
                        </g>
                        <g id="Group_2841" data-name="Group 2841" transform="translate(2.897 13.761)">
                            <g id="Group_2840" data-name="Group 2840">
                                <circle id="Ellipse_916" data-name="Ellipse 916" cx="0.724" cy="0.724" r="0.724" />
                            </g>
                        </g>
                        <g id="Group_2843" data-name="Group 2843" transform="translate(5.794 13.761)">
                            <g id="Group_2842" data-name="Group 2842">
                                <circle id="Ellipse_917" data-name="Ellipse 917" cx="0.724" cy="0.724" r="0.724" />
                            </g>
                        </g>
                        <g id="Group_2845" data-name="Group 2845" transform="translate(24.625 13.761)">
                            <g id="Group_2844" data-name="Group 2844">
                                <circle id="Ellipse_918" data-name="Ellipse 918" cx="0.724" cy="0.724" r="0.724" />
                            </g>
                        </g>
                        <g id="Group_2847" data-name="Group 2847" transform="translate(27.522 13.761)">
                            <g id="Group_2846" data-name="Group 2846">
                                <circle id="Ellipse_919" data-name="Ellipse 919" cx="0.724" cy="0.724" r="0.724" />
                            </g>
                        </g>
                        <g id="Group_2849" data-name="Group 2849" transform="translate(30.419 13.761)">
                            <g id="Group_2848" data-name="Group 2848">
                                <circle id="Ellipse_920" data-name="Ellipse 920" cx="0.724" cy="0.724" r="0.724" />
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Board <br> Round </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('infection_control')) class="nav-item cyan-border " @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('infection_control')) href="{{ route('infection.index') }}" @endif class="nav-link  {{ Request::RouteIs('infection.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 33.367 33.367"
                         fill="currentColor">
                        <path id="virus-svgrepo-com"
                              d="M12.563,8.266l-2.1-3.631m-2.2,7.929-3.631-2.1m2.058,7.967H2.5m4.193,0A11.741,11.741,0,0,0,18.434,30.174M6.693,18.434A11.741,11.741,0,0,1,18.434,6.693M8.266,24.3,4.635,26.4m7.929,2.2-2.1,3.631m7.967,2.135V30.174m0,0A11.741,11.741,0,0,0,30.174,18.434M26.4,32.233,24.3,28.6m7.929-2.2L28.6,24.3m5.766-5.87H30.174m0,0A11.741,11.741,0,0,0,18.434,6.693m13.8,3.774-3.631,2.1m-5.136,10.9v.017M26.4,4.635,24.3,8.266m-5.87-1.573V2.5M11.725,16.756v.017m5.032,6.692a1.677,1.677,0,1,1-1.677-1.677A1.677,1.677,0,0,1,16.756,23.465Zm6.709-8.386a3.354,3.354,0,1,1-3.354-3.354A3.354,3.354,0,0,1,23.465,15.079Z"
                              transform="translate(-1.75 -1.75)" fill="none" stroke="currentColor" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="1.5" />
                    </svg>
                    <br>
                    <span class="link-name">Infection <br> Control </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('camis_ward_type_performance_page_view')) class="nav-item cyan-border  {{ Request::RouteIs('wardtype.ward-performance') ? 'active' : '' }}" @else class="nav-item  ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a class="nav-link {{ Request::RouteIs('wardtype.ward-performance') ? 'active' : '' }}" @if(CheckDashboardPermission('camis_ward_type_performance_page_view')) href="{{ route('wardtype.ward-performance') }}" @endif >
                  <svg xmlns="http://www.w3.org/2000/svg" width="23" height="40" viewBox="0 0 23.173 42.955">
                    <g id="Group_3463" data-name="Group 3463" transform="translate(-62.5 -982.36)" fill="currentColor">
                      <g id="layer2" transform="translate(62.626 1006.463)">
                        <g id="g7483" transform="translate(0.374 2.009)">
                          <path id="path7377" d="M10349.359,9623.617a6.525,6.525,0,0,0-4.11,1.3,4.745,4.745,0,0,0-1.76,3.8h0c0,.024,0,1.449,0,1.449l0,1.938h11.587l.01-1.937s0-.7,0-.969,0-.492,0-.473v-.011a4.718,4.718,0,0,0-1.94-3.923,6.5,6.5,0,0,0-3.79-1.173Zm0,.978a5.6,5.6,0,0,1,3.212.984,3.649,3.649,0,0,1,1.541,3.135c0,.07,0,.215,0,.479s0,.62,0,.97,0,.7,0,.963h-9.628c0-.268,0-.615,0-.963,0-.7,0-1.372,0-1.448a3.691,3.691,0,0,1,1.393-3.035A5.583,5.583,0,0,1,10349.359,9624.595Z" transform="translate(-10338.112 -9615.26)"></path>
                          <path id="ellipse7379" d="M10397.406,9426.95a3.733,3.733,0,1,0,3.739,3.732A3.742,3.742,0,0,0,10397.406,9426.95Zm0,.978a2.756,2.756,0,1,1-2.76,2.755A2.751,2.751,0,0,1,10397.406,9427.928Z" transform="translate(-10386.16 -9426.95)"></path>
                          <path id="path7381" d="M10222.08,9632.763a5.4,5.4,0,0,0-3.673,1.231,4.6,4.6,0,0,0-1.442,3.539h0c0,.026,0,1.417,0,1.417l.01,1.907h4.544v-.978h-3.573c0-.261,0-.594,0-.931,0-.687,0-1.356,0-1.421a3.566,3.566,0,0,1,1.116-2.807,4.435,4.435,0,0,1,3.019-.983c.146,0,.576.044.576.044s.5-.594.724-.882l-.482-.074a5.514,5.514,0,0,0-.812-.065h0Z" transform="translate(-10216.965 -9624.017)"></path>
                          <path id="path7381-2" data-name="path7381" d="M10218.262,9632.763a5.4,5.4,0,0,1,3.673,1.231,4.6,4.6,0,0,1,1.442,3.539h0c0,.026,0,1.417,0,1.417l-.01,1.907h-4.544v-.978h3.573c0-.261,0-.594,0-.931,0-.687,0-1.356,0-1.421a3.566,3.566,0,0,0-1.116-2.807,4.435,4.435,0,0,0-3.019-.983c-.146,0-.576.044-.576.044s-.5-.594-.724-.882l.482-.074a5.514,5.514,0,0,1,.813-.065h0Z" transform="translate(-10200.704 -9624.016)"></path>
                          <path id="path7383" d="M10259.628,9456.628a3.367,3.367,0,1,0,2.144,5.944c.074-.062.146-.127.214-.2l.248-.249-.593-.788-.262.271c-.048.05-.183.169-.235.213a2.388,2.388,0,1,1-.365-3.912l.426.239s.306-.8.349-.922l-.3-.17A3.378,3.378,0,0,0,10259.628,9456.628Z" transform="translate(-10254.562 -9455.367)"></path>
                          <path id="path7383-2" data-name="path7383" d="M10258.837,9456.628a3.367,3.367,0,1,1-2.144,5.944c-.074-.062-.146-.127-.214-.2l-.248-.249.593-.788.262.271c.048.05.183.169.235.213a2.388,2.388,0,1,0,.365-3.912l-.426.239s-.306-.8-.349-.922l.3-.17A3.378,3.378,0,0,1,10258.837,9456.628Z" transform="translate(-10241.231 -9455.367)"></path>
                        </g>
                      </g>
                      <line id="Line_1" data-name="Line 1" x1="4.519" transform="translate(67.087 991.581)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"></line>
                      <line id="Line_2" data-name="Line 2" x1="2.26" transform="translate(79.336 996.428)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"></line>
                      <line id="Line_3" data-name="Line 3" x1="2.26" transform="translate(79.336 999.31)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"></line>
                      <line id="Line_6" data-name="Line 6" x1="4.519" transform="translate(67.087 995.163)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"></line>
                      <line id="Line_7" data-name="Line 7" x1="4.519" transform="translate(67.087 998.693)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"></line>
                      <path id="Subtraction_127" data-name="Subtraction 127" d="M13453.359,13617.8V13599a.637.637,0,0,1,.332-.559l11.639-6.36a.644.644,0,0,1,.31-.08.628.628,0,0,1,.327.091.646.646,0,0,1,.312.555v21.088a17.414,17.414,0,0,0-1.777-.092,16.988,16.988,0,0,0-11.14,4.158Zm21.941-.289h0a16.9,16.9,0,0,0-8.955-3.771v-15.118l8.651,4.949a.645.645,0,0,1,.306.545v13.4Z" transform="translate(-13390.359 -12609.139)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"></path>
                    </g>
                  </svg>
                  <br>
                  <span class="link-name">Directorate <br></span>
                </a>
              </li>
              <div class="borderline"></div>
{{--            <li @if(CheckDashboardPermission('doctor_at_night_dashboard_view')) class="nav-item cyan-border  {{ Request::RouteIs('doctor.at.night') ? 'active' : '' }}" @else class="nav-item  " onclick="CommonLoginModalPopupOpenOnRequest();" @endif>--}}
{{--                <a @if(CheckDashboardPermission('doctor_at_night_dashboard_view')) href="{{ route('doctor.at.night') }}" @endif class="nav-link  {{ Request::RouteIs('doctor.at.night') ? 'active' : '' }}">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="40" viewBox="0 0 56 40" fill="currentColor">--}}
{{--                        <g id="Group_2956" data-name="Group 2956" transform="translate(-76 -740)">--}}
{{--                          <g id="night-svgrepo-com" transform="translate(90 751.905)">--}}
{{--                            <path id="Path_22105" data-name="Path 22105" d="M14.936,1.126l-.9,1.805a.228.228,0,0,1-.1.1l-1.805.9a.228.228,0,0,0,0,.408l1.805.9a.228.228,0,0,1,.1.1l.9,1.805a.228.228,0,0,0,.408,0l.9-1.805a.228.228,0,0,1,.1-.1l1.805-.9a.228.228,0,0,0,0-.408l-1.805-.9a.228.228,0,0,1-.1-.1l-.9-1.805A.228.228,0,0,0,14.936,1.126Z" transform="translate(1.547)" fill="currentColor"></path>--}}
{{--                            <path id="Path_22106" data-name="Path 22106" d="M19.717,5.091l-.888,2.665a.228.228,0,0,1-.144.144l-2.664.888a.228.228,0,0,0,0,.433l2.664.888a.228.228,0,0,1,.144.144l.888,2.664a.228.228,0,0,0,.433,0l.888-2.664a.228.228,0,0,1,.144-.144l2.665-.888a.228.228,0,0,0,0-.433L21.182,7.9a.228.228,0,0,1-.144-.144L20.15,5.091A.228.228,0,0,0,19.717,5.091Z" transform="translate(2.091 0.554)" fill="currentColor"></path>--}}
{{--                            <path id="Path_22107" data-name="Path 22107" d="M11.731,15.414a8.848,8.848,0,0,0,11.7.805l.127-.1q.239-.195.466-.409.092-.087.182-.177c.584-.584,1.783-.239,1.606.568q-.091.418-.211.827-.071.242-.151.481l-.045.13a12.69,12.69,0,0,1-11.857,8.525A12.547,12.547,0,0,1,1,13.516,12.694,12.694,0,0,1,9.748,1.588l.061-.02q.164-.053.33-.1.441-.129.893-.226c.848-.181,1.194,1.087.581,1.7q-.091.091-.179.184-.174.185-.335.377l-.07.085A8.843,8.843,0,0,0,11.731,15.414Zm-1.613,1.613a11.213,11.213,0,0,0,11.514,2.727A10.219,10.219,0,1,1,7.457,5.324,11.209,11.209,0,0,0,10.118,17.027Z" transform="translate(0 0.031)" fill="currentColor" fill-rule="evenodd">--}}
{{--                            </path>--}}
{{--                          </g>--}}
{{--                        </g>--}}
{{--                    </svg>--}}
{{--                    <br>--}}
{{--                    <span class="link-name">Doctor <br> At Night </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <div class="borderline"></div>--}}
{{--            <li @if(CheckDashboardPermission('surgical_wards_dashboard_view')) class="nav-item cyan-border  {{ Request::RouteIs('surgical.ward') ? 'active' : '' }} " @else class="nav-item " onclick="CommonLoginModalPopupOpenOnRequest();" @endif>--}}
{{--                <a @if(CheckDashboardPermission('surgical_wards_dashboard_view')) href="{{ route('surgical.ward') }}" @endif class="nav-link  {{ Request::RouteIs('surgical.ward') ? 'active' : '' }}">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="40" viewBox="0 0 56 40" fill="currentColor">--}}
{{--                        <g id="Group_2956" data-name="Group 2956" transform="translate(-76 -740)">--}}
{{--                          <g id="night-svgrepo-com" transform="translate(90 751.905)">--}}
{{--                            <path id="Path_22105" data-name="Path 22105" d="M14.936,1.126l-.9,1.805a.228.228,0,0,1-.1.1l-1.805.9a.228.228,0,0,0,0,.408l1.805.9a.228.228,0,0,1,.1.1l.9,1.805a.228.228,0,0,0,.408,0l.9-1.805a.228.228,0,0,1,.1-.1l1.805-.9a.228.228,0,0,0,0-.408l-1.805-.9a.228.228,0,0,1-.1-.1l-.9-1.805A.228.228,0,0,0,14.936,1.126Z" transform="translate(1.547)" fill="currentColor"></path>--}}
{{--                            <path id="Path_22106" data-name="Path 22106" d="M19.717,5.091l-.888,2.665a.228.228,0,0,1-.144.144l-2.664.888a.228.228,0,0,0,0,.433l2.664.888a.228.228,0,0,1,.144.144l.888,2.664a.228.228,0,0,0,.433,0l.888-2.664a.228.228,0,0,1,.144-.144l2.665-.888a.228.228,0,0,0,0-.433L21.182,7.9a.228.228,0,0,1-.144-.144L20.15,5.091A.228.228,0,0,0,19.717,5.091Z" transform="translate(2.091 0.554)" fill="currentColor"></path>--}}
{{--                            <path id="Path_22107" data-name="Path 22107" d="M11.731,15.414a8.848,8.848,0,0,0,11.7.805l.127-.1q.239-.195.466-.409.092-.087.182-.177c.584-.584,1.783-.239,1.606.568q-.091.418-.211.827-.071.242-.151.481l-.045.13a12.69,12.69,0,0,1-11.857,8.525A12.547,12.547,0,0,1,1,13.516,12.694,12.694,0,0,1,9.748,1.588l.061-.02q.164-.053.33-.1.441-.129.893-.226c.848-.181,1.194,1.087.581,1.7q-.091.091-.179.184-.174.185-.335.377l-.07.085A8.843,8.843,0,0,0,11.731,15.414Zm-1.613,1.613a11.213,11.213,0,0,0,11.514,2.727A10.219,10.219,0,1,1,7.457,5.324,11.209,11.209,0,0,0,10.118,17.027Z" transform="translate(0 0.031)" fill="currentColor" fill-rule="evenodd">--}}
{{--                            </path>--}}
{{--                          </g>--}}
{{--                        </g>--}}
{{--                    </svg>--}}
{{--                    <br>--}}
{{--                    <span class="link-name">Surgical <br> Handover </span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <div class="borderline"></div>--}}
        </ul>
    </nav>
</div>
