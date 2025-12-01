
<div class="sidebar-menu d-none d-lg-block" id="sidebar">
    <nav class="" id="navbar">
        <ul class="">
            <li class="nav-item icon-next">
                <a href="{{ url('/home') }}" class="nav-link ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31.156 29.096" fill="currentColor">
                        <g id="home-svgrepo-com" transform="translate(-0.946 -2.25)">
                            <path id="Path_22090" data-name="Path 22090" d="M31.048,22H2" transform="translate(0 8.596)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22091" data-name="Path 22091" d="M2,14.238,13.8,4.8a4.357,4.357,0,0,1,5.444,0l11.8,9.442" transform="translate(0 0.381)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22092" data-name="Path 22092" d="M15.5,6.631v-2.9A.726.726,0,0,1,16.226,3h3.631a.726.726,0,0,1,.726.726v7.262" transform="translate(6.107)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22093" data-name="Path 22093" d="M4,27.655V9.5" transform="translate(0.905 2.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22094" data-name="Path 22094" d="M20,27.655V9.5" transform="translate(8.143 2.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>
                            <path id="Path_22095" data-name="Path 22095" d="M17.714,25.619V18.357c0-2.054,0-3.081-.638-3.719S15.411,14,13.357,14s-3.081,0-3.719.638S9,16.3,9,18.357v7.262" transform="translate(3.167 4.976)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                            <path id="Path_22096" data-name="Path 22096" d="M15.81,10.4a2.9,2.9,0,1,1-2.9-2.9A2.9,2.9,0,0,1,15.81,10.4Z" transform="translate(3.619 2.036)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Home</span>
                </a>
            </li>

            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('dp_dashboard_new_patients_view')) class="nav-item {{ Request::RouteIs('new.patient') ? 'cyan-border active' : '' }} icon-next" @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('dp_dashboard_new_patients_view')) href="{{ route('new.patient') }}" @endif class="nav-link {{ Request::RouteIs('new.patient') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.118" height="19.699" viewBox="0 0 26.118 19.699" fill="currentColor">
                        <g id="Group_2954" data-name="Group 2954" transform="translate(-43.25 -685.051)">
                            <path id="Path_21138" data-name="Path 21138" d="M18.621,12.7l2.413-2.413m2.413-2.413-2.413,2.413m0,0L18.621,7.879m2.413,2.413L23.447,12.7" transform="translate(56.86 670.475) rotate(45)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                            <path id="Path_21139" data-name="Path 21139" d="M1,21.1V19.962A7.962,7.962,0,0,1,8.962,12h0a7.962,7.962,0,0,1,7.962,7.962V21.1" transform="translate(43 682.9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                            <path id="Path_21140" data-name="Path 21140" d="M8.55,13.1A4.55,4.55,0,1,0,4,8.55,4.55,4.55,0,0,0,8.55,13.1Z" transform="translate(43.412 681.801)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">New <br> Patients</span>
                </a>
            </li>

            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('dp_dashboard_reviewed_patients_view')) class="nav-item {{ Request::RouteIs('reviewed.patient') ? 'cyan-border active' : '' }} icon-next"  @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('dp_dashboard_reviewed_patients_view')) href="{{ route('reviewed.patient') }}" @endif class="nav-link {{ Request::RouteIs('reviewed.patient') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22.475" height="22.475" viewBox="0 0 22.475 22.475" fill="currentColor">
                        <g id="tick-circle-svgrepo-com" transform="translate(-1.25 -1.25)">
                            <path id="Path_21289" data-name="Path 21289" d="M12.487,22.975A10.487,10.487,0,1,0,2,12.487,10.518,10.518,0,0,0,12.487,22.975Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                            <path id="Path_21290" data-name="Path 21290" d="M7.75,12.138l2.968,2.968L16.664,9.17" transform="translate(0.28 0.349)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Reviewed <br> Patients </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('dp_dashboard_removed_patients_view')) class="nav-item {{ Request::RouteIs('removed.patient') ? 'cyan-border active' : '' }} icon-next"  @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('dp_dashboard_removed_patients_view')) href="{{ route('removed.patient') }}" @endif class="nav-link {{ Request::RouteIs('removed.patient') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.68" height="19.699" viewBox="0 0 24.68 19.699" fill="currentColor">
                        <g id="Group_2328" data-name="Group 2328" transform="translate(-43.25 -685.051)">
                            <path id="Path_21138" data-name="Path 21138" d="M18.621,12.7l2.413-2.413m2.413-2.413-2.413,2.413m0,0L18.621,7.879m2.413,2.413L23.447,12.7" transform="translate(43.422 682.334)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                            <path id="Path_21139" data-name="Path 21139" d="M1,21.1V19.962A7.962,7.962,0,0,1,8.962,12h0a7.962,7.962,0,0,1,7.962,7.962V21.1" transform="translate(43 682.9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                            <path id="Path_21140" data-name="Path 21140" d="M8.55,13.1A4.55,4.55,0,1,0,4,8.55,4.55,4.55,0,0,0,8.55,13.1Z" transform="translate(43.412 681.801)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Removed <br> Patients </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('dp_dashboard_dp_summary_view')) class="nav-item {{ Request::RouteIs('DPSummaryMenu') ? 'cyan-border active' : '' }} icon-next"  @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('dp_dashboard_dp_summary_view')) href="{{ route('DPSummaryMenu') }}" @endif class="nav-link {{ Request::RouteIs('DPSummaryMenu') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22.746" height="20.119" viewBox="0 0 22.746 20.119" fill="currentColor">
                        <g id="task-svgrepo-com" transform="translate(-19.25 -21.15)">
                            <g id="Group_2321" data-name="Group 2321" transform="translate(19.25 21.15)">
                                <g id="Group_2320" data-name="Group 2320">
                                    <path id="Path_21132" data-name="Path 21132" d="M29.662,22.121l-.8-.8a.552.552,0,0,0-.8,0l-5.025,5.025L21.02,24.329a.552.552,0,0,0-.8,0l-.8.8a.552.552,0,0,0,0,.8l2.817,2.817a1.161,1.161,0,0,0,.8.343,1.1,1.1,0,0,0,.8-.343l5.824-5.824A.63.63,0,0,0,29.662,22.121Z" transform="translate(-19.25 -21.15)"></path>
                                </g>
                            </g>
                            <g id="Group_2322" data-name="Group 2322" transform="translate(30.575 24.519)">
                                <path id="Path_21133" data-name="Path 21133" d="M59.659,33.045h-9.9A.764.764,0,0,1,49,32.284V30.761A.764.764,0,0,1,49.761,30h9.9a.764.764,0,0,1,.761.761v1.523A.764.764,0,0,1,59.659,33.045Z" transform="translate(-49 -30)"></path>
                            </g>
                            <g id="Group_2323" data-name="Group 2323" transform="translate(28.291 31.371)">
                                <path id="Path_21134" data-name="Path 21134" d="M55.943,51.045H43.761A.764.764,0,0,1,43,50.284V48.761A.764.764,0,0,1,43.761,48H55.943a.764.764,0,0,1,.761.761v1.523A.764.764,0,0,1,55.943,51.045Z" transform="translate(-43 -48)"></path>
                            </g>
                            <g id="Group_2324" data-name="Group 2324" transform="translate(22.2 31.371)">
                                <path id="Path_21135" data-name="Path 21135" d="M29.284,51.045H27.761A.764.764,0,0,1,27,50.284V48.761A.764.764,0,0,1,27.761,48h1.523a.764.764,0,0,1,.761.761v1.523A.764.764,0,0,1,29.284,51.045Z" transform="translate(-27 -48)"></path>
                            </g>
                            <g id="Group_2325" data-name="Group 2325" transform="translate(22.2 38.224)">
                                <path id="Path_21136" data-name="Path 21136" d="M29.284,69.045H27.761A.764.764,0,0,1,27,68.284V66.761A.764.764,0,0,1,27.761,66h1.523a.764.764,0,0,1,.761.761v1.523A.764.764,0,0,1,29.284,69.045Z" transform="translate(-27 -66)"></path>
                            </g>
                            <g id="Group_2326" data-name="Group 2326" transform="translate(28.291 38.224)">
                                <path id="Path_21137" data-name="Path 21137" d="M55.943,69.045H43.761A.764.764,0,0,1,43,68.284V66.761A.764.764,0,0,1,43.761,66H55.943a.764.764,0,0,1,.761.761v1.523A.764.764,0,0,1,55.943,69.045Z" transform="translate(-43 -66)"></path>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">DP <br> Summary </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('dp_dashboard_patient_search_view')) class="nav-item {{ Request::RouteIs('patient.search') ? 'cyan-border active' : '' }} icon-next"  @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('dp_dashboard_patient_search_view')) href="{{ route('patient.search') }}" @endif class="nav-link {{ Request::RouteIs('patient.search') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="search-svgrepo-com" width="20.137" height="20.12" viewBox="0 0 20.137 20.12" fill="currentColor">
                        <g id="Group_209" data-name="Group 209" transform="translate(0 0)">
                            <path id="Path_147" data-name="Path 147" d="M19.883,18.886,14.105,13.1A7.8,7.8,0,0,0,15.93,8.086,7.965,7.965,0,0,0,0,8.09a7.973,7.973,0,0,0,12.9,6.178l5.8,5.8a.835.835,0,1,0,1.18-1.18ZM1.692,8.09a6.269,6.269,0,0,1,12.537,0,6.269,6.269,0,0,1-12.537,0Z" transform="translate(0 -0.2)"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Patient <br> Search </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('dp_dashboard_summary_view')) class="nav-item {{ Request::RouteIs('patient.task.summary') ? 'cyan-border active' : '' }} icon-next" @else class="nav-item icon-next ibox-side-menu-disabled-icon" onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('dp_dashboard_summary_view')) href="{{ route('patient.task.summary') }}" @endif class="nav-link {{ Request::RouteIs('patient.task.summary') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18.442" height="25.873" viewBox="0 0 18.442 25.873" fill="currentColor">
                        <path id="note-svgrepo-com" d="M24.379,21.368c-.044-1.347-.1-2.692-.127-4.039-.01-.708-.039-1.414-.047-2.122s-.006-1.441-.014-2.159c-.007-.685-.025-1.37-.028-2.055,0-.7.012-1.4.033-2.1.018-.6.033-1.2.033-1.8,0-.666.01-1.328.053-1.994a.723.723,0,0,0-.5-.694.583.583,0,0,0-.4-.146c-.549.033-1.1,0-1.65-.015-.006-.443,0-.885-.006-1.327a.724.724,0,1,0-1.449,0c.012.433.026.869.051,1.3-.282,0-.563-.006-.845-.012-.189,0-.379,0-.569-.006-.034-.423-.059-.847-.092-1.271a.775.775,0,0,0-.213-.513.727.727,0,0,0-1.028,0,.7.7,0,0,0-.213.513c.04.423.09.844.143,1.264L16.076,4.2c0-.2,0-.4,0-.6.007-.288.021-.578.033-.866A.734.734,0,0,0,15.384,2a.741.741,0,0,0-.731.731c-.012.5.023.991.026,1.486-.466.008-.93.013-1.4.024.018-.45.055-.9.082-1.346a.736.736,0,1,0-1.471,0c-.022.455-.038.913-.03,1.369-.105,0-.211,0-.316,0-.29,0-.58-.009-.87-.011,0-.168-.007-.337,0-.506.007-.306.014-.614.027-.918a.743.743,0,1,0-1.486,0c0,.295,0,.59.011.885q.01.261.022.521c-.575-.008-1.149-.008-1.723-.021-.146,0-.292,0-.438-.006a.681.681,0,0,0-.529.265.729.729,0,0,0-.525.689c.007.711.055,1.423.055,2.134S6.043,8.71,6.041,9.414c0,1.386-.039,2.772-.007,4.158.016.715.053,1.429.062,2.143.007.688.031,1.374.07,2.061.08,1.4.139,2.809.139,4.214,0,.48-.006.959,0,1.439,0,.431.041.861.03,1.289A.663.663,0,0,0,6.388,25c0,.006,0,.011,0,.018a.74.74,0,0,0,.735.735c.1,0,.194-.007.29-.011.027.253.055.506.061.76a2.778,2.778,0,0,0,.067.676.911.911,0,0,0,.636.649,2.788,2.788,0,0,0,.745.035l1.1-.025c.7-.014,1.4-.006,2.092-.019s1.407-.033,2.111-.031,1.388.012,2.082.006,1.414-.014,2.121-.023c.675-.007,1.349-.018,2.024-.021.179,0,.359,0,.54,0,.429,0,.859,0,1.287-.021.1-.007.195-.012.294-.021a.941.941,0,0,0,.6-.234,1.167,1.167,0,0,0,.3-.552,3.182,3.182,0,0,0,0-1.123.636.636,0,0,0,.684-.171.768.768,0,0,0,.209-.5c.03-.261.043-.529.063-.792a8.948,8.948,0,0,0,.031-.9C24.446,22.742,24.4,22.055,24.379,21.368ZM9.148,5.557c.692-.007,1.384-.023,2.076-.028,1.324-.012,2.647-.044,3.971-.062,1.307-.016,2.616-.019,3.924,0,.663.012,1.326.033,1.99.044.56.009,1.119.036,1.679.057,0,.578.024,1.157.03,1.736.007.7.01,1.4,0,2.092s-.018,1.361-.018,2.043c0,.7.028,1.4.035,2.1.007.727,0,1.454-.01,2.182s.018,1.429.033,2.143c.014.666.049,1.332.063,2s0,1.3.03,1.953c.03.614.06,1.224.055,1.839,0,.221-.006.444-.012.665-.477.013-.953.024-1.429.024-.7,0-1.409.012-2.111.018s-1.4.01-2.1.019c-.725.01-1.453.033-2.18.041-.692.007-1.384.006-2.076-.01-.671-.018-1.342-.043-2.013-.047-1.112-.01-2.223-.056-3.335-.068-.043-.556-.037-1.116-.043-1.672-.009-.7-.028-1.4-.049-2.1s-.037-1.4-.074-2.1-.1-1.37-.123-2.059c-.023-.72-.019-1.441-.043-2.16C7.4,13.5,7.4,12.8,7.4,12.1c0-1.386-.014-2.77.058-4.154.023-.444.018-.889.016-1.333,0-.341.009-.682.016-1.023C8.045,5.582,8.6,5.563,9.148,5.557ZM20.7,26.359c-.671.006-1.344.023-2.015.041-1.388.035-2.778.084-4.167.1-.5,0-1.006.006-1.509.016-.478.009-.954.031-1.431.039-.515.006-1.028,0-1.542-.014-.371-.007-.746-.013-1.116-.041-.017-.261-.029-.522-.048-.783.149,0,.3,0,.445,0,.71.016,1.419,0,2.129,0,.743,0,1.484.028,2.228.031s1.49,0,2.232-.014c1.306-.031,2.61-.025,3.916-.007q.941.011,1.883.012h.323c0,.006,0,.013,0,.019.016.171.043.34.07.509,0,.022,0,.044,0,.066C21.639,26.361,21.17,26.355,20.7,26.359ZM11.719,12.384a.742.742,0,0,1,.733-.733c.766-.038,1.534-.046,2.3-.046l.823,0c.5,0,.991.008,1.484.016.431.007.859-.01,1.287-.014a.737.737,0,0,1,0,1.474c-.435-.033-.877-.031-1.314-.037-.5-.007-.989-.033-1.483-.044-.471-.01-.945-.018-1.416,0-.56.025-1.121.078-1.683.113A.737.737,0,0,1,11.719,12.384Zm0,2.576a.71.71,0,0,1,.7-.7c.546,0,1.092.019,1.641.021.5,0,1,0,1.493-.009.517-.01,1.031-.018,1.548-.033.246-.007.492-.01.737-.018s.474-.039.713-.051h.032a.721.721,0,0,1,.477,1.232.691.691,0,0,1-.509.211,6.8,6.8,0,0,0-.739,0q-.369.008-.737.01c-.507.007-1.015.012-1.521.006s-1.014-.01-1.521-.007c-.538,0-1.076.031-1.612.044A.706.706,0,0,1,11.719,14.96Zm-.077,2.584a.755.755,0,0,1,.748-.747c1.088.008,2.177.055,3.264.072.525.007,1.051,0,1.574-.028.44-.02.878-.045,1.317-.045H18.7a.728.728,0,1,1,0,1.456c-.489-.025-.986,0-1.474.021-.525.021-1.047.03-1.574.018-.55-.012-1.1-.039-1.649-.033s-1.076.028-1.614.033A.755.755,0,0,1,11.643,17.544Z" transform="translate(-6.021 -2)" fill="currentColor"></path>
                    </svg>
                    <br>
                    <span class="link-name">Summary</span>
                </a>
            </li>
            <div class="borderline"></div>
        </ul>
    </nav>
</div>
