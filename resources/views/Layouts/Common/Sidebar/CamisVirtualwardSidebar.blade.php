
<div class="sidebar-menu d-none d-lg-block" id="sidebar">
    <nav class="" id="navbar">
        <ul class="">
            <li class="nav-item cyan-border">
                <a href="{{ route('ward.dashboard') }}" class="nav-link ">
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
            @php
                $lastSegment = substr(strrchr(request()->url(), '/'), 1);
            @endphp
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'one-to-one-care' ? "active":'' }} " @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', ['virtualward' => 'one-to-one-care']) }}"  @endif  class="nav-link {{ $lastSegment == 'one-to-one-care' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 33 48" fill="currentColor">
                        <text id="_1-1" data-name="1-1" transform="translate(0 39)" font-size="41" font-family="AmericanCaptain, American Captain">
                            <tspan x="0" y="0">1-1</tspan>
                        </text>
                    </svg>
                    <br>
                    <span class="link-name">One To One <br>Care</span>
                </a>
            </li>
            <div class="borderline"></div>

            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'amber-care-eol' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'amber-care-eol') }}" @endif class="nav-link {{ $lastSegment == 'amber-care-eol' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="20" viewBox="0 0 47.108 21.074" fill="currentColor">
                        <g id="Group_2876" data-name="Group 2876" transform="translate(-77.264 -219.5)">
                            <path id="swan-facing-right-svgrepo-com" d="M10.532,19.859c11.5,1.741,11.9-5.384,11.9-5.384.447-5.1-4.778-6.6-6.355-9.434S18.164,1.782,17.941,3.6a2.077,2.077,0,0,0,.912,2.287c.06.141,1.618,1.7,1.842,1.408s-.638-1.408-.638-1.408a2.246,2.246,0,0,0,.92-1.256C21.706,2.652,18.1-2.125,14.3,1.073c-3.726,3.442,1.253,7.168,2.551,9.03s1.248,3.267.444,3.523c-.821.26-1.463-.558-1.8-1.823a5.51,5.51,0,0,0-6.8-3.766C5.413,9.09,5.8,10.385,3.163,9.656,2.233,18.523,10.532,19.859,10.532,19.859Z" transform="translate(101.909 220)"></path>
                            <path id="Subtraction_76" data-name="Subtraction 76" d="M4.042,20.074H0L3.627,0H7.915l3.629,20.072H7.5l-.358-2.492H7.1l.01-.029-.433-3.326h0L5.784,7.282,4.844,14.4h0l-.615,4.2.017.025-.208,1.445Z" transform="translate(77.862 220)" stroke="rgba(0,0,0,0)" stroke-width="1"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Amber Care <br> + End of Life </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'risk-of-falls' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'risk-of-falls') }}" @endif class="nav-link {{ $lastSegment == 'risk-of-falls' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 40.203 35.736" fill="currentColor">
                        <g id="Group_2135" data-name="Group 2135" transform="translate(-469.691 -479.019)">
                            <path id="Polygon_68" data-name="Polygon 68" d="M18.358,3.1a2,2,0,0,1,3.486,0L38.526,32.755a2,2,0,0,1-1.743,2.981H3.42a2,2,0,0,1-1.743-2.981Z" transform="translate(469.691 479.019)"></path>
                            <g id="slide-svgrepo-com" transform="translate(482.736 495.012)">
                                <g id="Group_1985" data-name="Group 1985" transform="translate(0)">
                                    <ellipse id="Ellipse_480" data-name="Ellipse 480" cx="1.663" cy="1.663" rx="1.663" ry="1.663" transform="translate(0.094 0)" fill="#fff"></ellipse>
                                    <path id="Path_20932" data-name="Path 20932" d="M23.715,8.88a8.083,8.083,0,0,0-2.19-1.156,1.078,1.078,0,0,0-.773.013,1.039,1.039,0,0,0-.206-.02,5.409,5.409,0,0,0-2.31.544,2.16,2.16,0,0,0-.208-.362l-.945-1.325a5.549,5.549,0,0,0,1.808-2.353c.468-1.136-1.325-1.769-1.789-.641a3.393,3.393,0,0,1-1.125,1.444L15.46,4.3a21.78,21.78,0,0,0,2.822-2.469c.82-.86-.611-2.022-1.427-1.166a21.225,21.225,0,0,1-3.633,2.958,1.472,1.472,0,0,0-.276.188,1.649,1.649,0,0,0-.159,2.279l2.8,3.928a1.283,1.283,0,0,0,.643.466A6.532,6.532,0,0,1,17.88,15.5a.951.951,0,0,0,1.9.109,8.74,8.74,0,0,0-1.313-5.355,3.887,3.887,0,0,1,2.244-.7.927.927,0,0,0,.311-.056,6.34,6.34,0,0,1,1.531.809A.921.921,0,1,0,23.715,8.88Z" transform="translate(-10.251 -0.265)" fill="#fff"></path>
                                    <path id="Path_20933" data-name="Path 20933" d="M7.749,52.531a12.409,12.409,0,0,1-1.729-.46,4.056,4.056,0,0,1-.8-.376,1.045,1.045,0,0,1-.529-.669.746.746,0,0,0,.091.463,1.529,1.529,0,0,0,.3.38,3.322,3.322,0,0,0,.794.527,7.488,7.488,0,0,0,1.779.581A11.312,11.312,0,0,0,9.5,53.19a9.869,9.869,0,0,0,1.846-.1c-.611-.1-1.215-.17-1.815-.257S8.337,52.654,7.749,52.531Z" transform="translate(-4.687 -36.78)" fill="#fff"></path>
                                    <path id="Path_20934" data-name="Path 20934" d="M16.981,50.212a10.456,10.456,0,0,1-1.036-.254,2.762,2.762,0,0,1-.482-.2.641.641,0,0,1-.348-.37.619.619,0,0,0,.209.545,1.926,1.926,0,0,0,.48.348,4.046,4.046,0,0,0,1.086.376,5.578,5.578,0,0,0,1.127.109,4.5,4.5,0,0,0,1.124-.13c-.37-.1-.732-.16-1.093-.226Z" transform="translate(-12.194 -35.6)" fill="#fff"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Falls <br> </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'frailty' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'frailty') }}" @endif class="nav-link {{ $lastSegment == 'frailty' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 33 48" fill="currentColor">
                        <text id="Fr" transform="translate(0 45)" font-size="41" font-family="AmericanCaptain, American Captain">
                            <tspan x="0" y="0">Fr</tspan>
                        </text>
                    </svg>
                    <br>
                    <span class="link-name">Frality <br> </span>
                </a>
            </li>

            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'amhat' ? "active":'' }} " @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', ['virtualward' => 'amhat']) }}"  @endif  class="nav-link {{ $lastSegment == 'amhat' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 135 48" fill="currentColor">
                        <text id="_1-1" data-name="1-1" transform="translate(0 39)" font-size="61" font-family="AmericanCaptain, American Captain">
                            <tspan x="0" y="0">AMHAT</tspan>
                        </text>
                    </svg>
                    <br>
                    <span class="link-name">AMHAT</span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'sova-dols-ld' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'sova-dols-ld') }}" @endif class="nav-link {{ $lastSegment == 'sova-dols-ld' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="24" viewBox="0 0 62 24" fill="currentColor">
                        <text id="S_O_LD" data-name="S + O + LD" transform="translate(0 19)" font-size="20" font-family="AmericanCaptain, American Captain">
                            <tspan x="0" y="0">S + O + LD</tspan>
                        </text>
                    </svg>
                    <br>
                    <span class="link-name">SOVA + <br> DOLS + LD </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'nutrition-risk' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'nutrition-risk') }}" @endif class="nav-link {{ $lastSegment == 'nutrition-risk' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="nutrition-svgrepo-com" width="30" height="30" viewBox="0 0 33.43 34.554" fill="currentColor">
                        <path id="XMLID_11_" d="M8.616,137.921c.081-2.712-1.4-3.743-3.2-4.421a3.493,3.493,0,0,0,3.2,4.421" transform="translate(-5.292 -115.477)"></path>
                        <path id="XMLID_10_" d="M20.338,42.73c1.153-2.468.19-3.987-1.193-5.33a3.517,3.517,0,0,0,1.193,5.33" transform="translate(-16.608 -32.409)"></path>
                        <path id="XMLID_9_" d="M37.58,99.021c-.081-2.712,1.4-3.743,3.2-4.421a3.5,3.5,0,0,1-3.2,4.421" transform="translate(-33.198 -81.852)"></path>
                        <path id="XMLID_8_" d="M37.58,129.921c-.081-2.712,1.4-3.743,3.2-4.421a3.5,3.5,0,0,1-3.2,4.421" transform="translate(-33.198 -108.562)"></path>
                        <path id="XMLID_7_" d="M37.58,68.121c-.081-2.712,1.4-3.743,3.2-4.421a3.493,3.493,0,0,1-3.2,4.421" transform="translate(-33.198 -55.143)"></path>
                        <path id="XMLID_6_" d="M8.616,107.121c.081-2.712-1.4-3.743-3.2-4.421a3.5,3.5,0,0,0,3.2,4.421" transform="translate(-5.292 -88.854)"></path>
                        <path id="XMLID_5_" d="M8.616,76.221c.081-2.712-1.4-3.743-3.2-4.421a3.5,3.5,0,0,0,3.2,4.421" transform="translate(-5.292 -62.144)"></path>
                        <path id="XMLID_16_" d="M87.065,175.012H72.5L79.782,162.4Z" transform="translate(-63.386 -140.458)"></path>
                        <path id="XMLID_3_" d="M11.261,127.79,42.113,119.4l-.461-1.7L10.8,126.094Z" transform="translate(-10.053 -101.82)"></path>
                        <path id="XMLID_2_" d="M174.7.6s.231,4.448,4.123,4.068c0,.014.448-3.716-4.123-4.068" transform="translate(-151.726 -0.6)"></path>
                        <path id="XMLID_1_" d="M164.347,45.251a2.237,2.237,0,0,1-1.844.949,2.4,2.4,0,0,1-1.641-.705,19.145,19.145,0,0,1-1.926-2.97A7.153,7.153,0,0,1,158,39.351a3.836,3.836,0,0,1,3.743-3.851,3.725,3.725,0,0,1,2.617,1.071,3.725,3.725,0,0,1,2.617-1.071,3.836,3.836,0,0,1,3.743,3.851,7.251,7.251,0,0,1-.936,3.173,19.144,19.144,0,0,1-1.926,2.97,2.4,2.4,0,0,1-1.641.705,2.285,2.285,0,0,1-1.871-.949" transform="translate(-137.291 -30.767)"></path>
                    </svg>
                    <br>
                    <span class="link-name">Nutrition <br> Risk </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'diabetics-status' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'diabetics-status') }}" @endif class="nav-link {{ $lastSegment == 'diabetics-status' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="foot-massage-svgrepo-com" width="20" height="24" viewBox="0 0 22.399 25.308" fill="currentColor">
                        <g id="Group_1960" data-name="Group 1960" transform="translate(0)">
                            <path id="Path_20898" data-name="Path 20898" d="M60.851,59.4a1.055,1.055,0,1,0-.865-1.038A.964.964,0,0,0,60.851,59.4Z" transform="translate(-58.316 -54.336)"></path>
                            <path id="Path_20899" data-name="Path 20899" d="M99.5,40.616a1.055,1.055,0,1,0-.865-1.038A.965.965,0,0,0,99.5,40.616Z" transform="translate(-94.95 -36.532)"></path>
                            <path id="Path_20900" data-name="Path 20900" d="M48.393,89a7.124,7.124,0,0,0-3.048,1.009c-.388.2-.735.37-1.04.521-1.29.636-1.753.886-2.088,1.474l-.011.018a4.749,4.749,0,0,0-.729,3.509,12.154,12.154,0,0,0,.552,1.755,35.913,35.913,0,0,1,1.947,7.789c.465,2.964,1.555,4.6,3.07,4.6a1.714,1.714,0,0,0,.49-.066.312.312,0,0,1,.065-.02c.155-.044,2.6-.808,2.123-5.2-.583-5.4-.023-7.241.832-9.254.079-.187.17-.375.266-.574.622-1.29,1.265-2.624-.411-4.508A2.611,2.611,0,0,0,48.393,89Z" transform="translate(-40.684 -84.367)"></path>
                            <path id="Path_20901" data-name="Path 20901" d="M149.886,3.3a3.553,3.553,0,0,1,2.194.736,2.617,2.617,0,0,0,.547-1.624,2.107,2.107,0,1,0-4.171,0,2.705,2.705,0,0,0,.21,1.052A4.922,4.922,0,0,1,149.886,3.3Z" transform="translate(-142.176)"></path>
                            <path id="Path_20902" data-name="Path 20902" d="M29.654,89c0-.01,0-.019,0-.029a.879.879,0,1,0-1.73,0,1.035,1.035,0,0,0,.61.992A3.745,3.745,0,0,1,29.654,89Z" transform="translate(-27.925 -83.356)"></path>
                            <path id="Path_20903" data-name="Path 20903" d="M393.5,59.4a1.055,1.055,0,1,0-.865-1.038A.964.964,0,0,0,393.5,59.4Z" transform="translate(-373.633 -54.336)"></path>
                            <path id="Path_20904" data-name="Path 20904" d="M354.85,40.616a1.055,1.055,0,1,0-.865-1.038A.964.964,0,0,0,354.85,40.616Z" transform="translate(-337 -36.532)"></path>
                            <path id="Path_20905" data-name="Path 20905" d="M259.918,92.007c-.336-.588-.8-.838-2.088-1.474-.306-.151-.653-.322-1.04-.521A7.124,7.124,0,0,0,253.741,89a2.611,2.611,0,0,0-2.017,1.054c-1.676,1.884-1.033,3.218-.411,4.508.1.2.187.388.266.574.855,2.014,1.415,3.856.832,9.254-.474,4.387,1.967,5.152,2.123,5.2a.314.314,0,0,1,.065.02,1.714,1.714,0,0,0,.49.066c1.514,0,2.6-1.632,3.07-4.6A35.91,35.91,0,0,1,260.1,97.29a12.16,12.16,0,0,0,.552-1.755,4.749,4.749,0,0,0-.729-3.509Z" transform="translate(-239.051 -84.367)"></path>
                            <path id="Path_20906" data-name="Path 20906" d="M260.045,3.3a4.924,4.924,0,0,1,1.221.164,2.7,2.7,0,0,0,.21-1.052,2.107,2.107,0,1,0-4.171,0,2.617,2.617,0,0,0,.547,1.624A3.552,3.552,0,0,1,260.045,3.3Z" transform="translate(-245.356)"></path>
                            <path id="Path_20907" data-name="Path 20907" d="M425.557,87.938a.964.964,0,0,0-.865,1.038c0,.01,0,.019,0,.029a3.744,3.744,0,0,1,1.118.963,1.035,1.035,0,0,0,.61-.992A.964.964,0,0,0,425.557,87.938Z" transform="translate(-404.023 -83.357)"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Diabetics + <br> Diabetic Foot </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'palliative-care' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'palliative-care') }}" @endif class="nav-link {{ $lastSegment == 'palliative-care' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 34.403 34.5" fill="currentColor">
                        <path id="Subtraction_77" data-name="Subtraction 77" d="M12076.52,10239.5h-.043a13.534,13.534,0,0,1-4.392-.722,25.979,25.979,0,0,0-5.786-1.578v1.175a.877.877,0,0,1-.877.876h-4.543a.878.878,0,0,1-.878-.876V10224.1a.879.879,0,0,1,.878-.877h4.543a.878.878,0,0,1,.877.877v.887h2.538a.761.761,0,0,1,.246.036l5.568,1.629h4.428l-.011,0c.078-.008.158-.011.237-.011a2.94,2.94,0,0,1,2.93,2.9.277.277,0,0,1-.016.084l0,.008a.294.294,0,0,0-.014.067l6.763-3.037-.029.014a4.388,4.388,0,0,1,3.551-.1l.021.008a3.7,3.7,0,0,1,1.874,2.732v-.007a.877.877,0,0,1-.035.5l-.007.025a3.626,3.626,0,0,1-1.02,1.306l.015-.019a20.081,20.081,0,0,1-1.828,1.467c-1.383,1-2.918,1.993-4.832,3.126-.342.2-.678.407-1.108.676a25.252,25.252,0,0,1-3.841,2.091l.093-.031A13.839,13.839,0,0,1,12076.52,10239.5Zm-4.032-2.432h0a12.384,12.384,0,0,0,4.021.671,12.106,12.106,0,0,0,4.555-.874l.149-.06a24.078,24.078,0,0,0,3.352-1.855l.186-.115.03-.018c.326-.2.665-.41,1-.606,1.881-1.114,3.373-2.079,4.7-3.036l.057-.039a17.413,17.413,0,0,0,1.551-1.239l.006,0a4.8,4.8,0,0,0,.5-.51v-.014a1.89,1.89,0,0,0-.88-1.221,2.723,2.723,0,0,0-.869-.139,2.8,2.8,0,0,0-1.147.244l-9.119,4.095a.876.876,0,0,1-.355.075h-9.109a.876.876,0,1,1,0-1.753h7.966c1.035,0,1.4-.61,1.4-1.132s-.367-1.137-1.4-1.137h-4.552a.724.724,0,0,1-.244-.035l-5.57-1.632h-2.413v8.7l.138.015a25.394,25.394,0,0,1,6.142,1.646Zm-10.732-12.1v12.525h2.787v-12.525Zm16.6-1.571a.863.863,0,0,1-.65-.288l-7-7.756c-.135-.124-.262-.253-.377-.381a3.008,3.008,0,0,0,1.6-.492c.06-.05.126-.1.2-.159l6.225,6.894,6.344-7.033.032-.031a5.024,5.024,0,0,0,1.646-3.477v-.009a3.931,3.931,0,0,0-3.9-3.917h-.042a4.991,4.991,0,0,0-3.466,1.646.877.877,0,0,1-1.238,0,4.381,4.381,0,0,0-3.093-1.419,3.678,3.678,0,0,0-.976.128l-.028.007a4.265,4.265,0,0,0-2.947,2.971,4.027,4.027,0,0,0-.116.965,4.1,4.1,0,0,0,.289,1.522c-.089.036-.184.07-.282.1a8.855,8.855,0,0,1-1.424.336,5.88,5.88,0,0,1-.163-3.381l.01-.042a6.051,6.051,0,0,1,4.211-4.173l-.042.007a5.852,5.852,0,0,1,1.462-.187,5.747,5.747,0,0,1,3.715,1.36,5.882,5.882,0,0,1,8.124.066,5.55,5.55,0,0,1,1.661,3.98v.06a6.662,6.662,0,0,1-2.144,4.674l-6.982,7.738A.877.877,0,0,1,12078.358,10223.4Z" transform="translate(-12060.001 -10205.001)"></path>
                    </svg>
                    <br>
                    <span class="link-name">Palliative <br> Care </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'pressure-ulcer' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'pressure-ulcer') }}" @endif class="nav-link {{ $lastSegment == 'pressure-ulcer' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 18.783 24.214">
                        <g id="baby-feet-svgrepo-com" transform="translate(0.961 0.961)">
                            <path id="Path_20931" data-name="Path 20931" d="M14.552,18.544c-.785,3.392,3.582,4.256,2.551,6.646s-3.34,1.912-3.082,4.3,3.313,2.424,6.094.984c5.563-2.88,6.723-9.171,4.206-11.932C21.227,15.152,15.337,15.152,14.552,18.544Z" transform="translate(-11.69 -8.947)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                            <ellipse id="Ellipse_475" data-name="Ellipse 475" cx="1.103" cy="1.655" rx="1.103" ry="1.655" transform="matrix(0.766, 0.643, -0.643, 0.766, 13.857, 3.716)" fill="currentColor"></ellipse>
                            <ellipse id="Ellipse_476" data-name="Ellipse 476" cx="1.103" cy="1.655" rx="1.103" ry="1.655" transform="translate(10.495 2.109) rotate(25)" fill="currentColor"></ellipse>
                            <ellipse id="Ellipse_477" data-name="Ellipse 477" cx="1.103" cy="1.655" rx="1.103" ry="1.655" transform="translate(6.561 1.763) rotate(6)" fill="currentColor"></ellipse>
                            <ellipse id="Ellipse_478" data-name="Ellipse 478" cx="1.655" cy="2.207" rx="1.655" ry="2.207" transform="matrix(0.94, -0.342, 0.342, 0.94, 0, 1.132)" fill="none" stroke="currentColor" stroke-width="1.5"></ellipse>
                            <ellipse id="Ellipse_479" data-name="Ellipse 479" cx="1.103" cy="1.655" rx="1.103" ry="1.655" transform="matrix(0.643, 0.766, -0.766, 0.643, 16.404, 5.991)" fill="currentColor"></ellipse>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Pressure <br> Ulcer </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('virtual_ward_dashboard_view')) class="nav-item cyan-border {{ $lastSegment == 'dementia-delirium' ? "active":'' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('virtual_ward_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('virtual_ward_dashboard_view')) href="{{ route('virtual.ward.summary', 'dementia-delirium') }}" @endif class="nav-link {{ $lastSegment == 'dementia-delirium' ? "active":'' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="butterfly-animals-svgrepo-com" width="26" height="20" viewBox="0 0 27.092 20.241" fill="currentColor">
                        <g id="SVGCleanerId_0" transform="translate(6.481 14.587)">
                            <g id="Group_1964" data-name="Group 1964">
                                <path id="Path_20918" data-name="Path 20918" d="M124.926,340.645a.572.572,0,0,0-.8-.133,5.831,5.831,0,0,0-1.57,1.675.571.571,0,1,0,.97.6,4.7,4.7,0,0,1,1.264-1.349A.571.571,0,0,0,124.926,340.645Z" transform="translate(-122.474 -340.406)"></path>
                            </g>
                        </g>
                        <g id="Group_1966" data-name="Group 1966" transform="translate(3.13 5.15)">
                            <g id="Group_1965" data-name="Group 1965" transform="translate(0 0)">
                                <path id="Path_20919" data-name="Path 20919" d="M62.963,162.057H59.727a.571.571,0,0,0-.54.756,8.86,8.86,0,0,0,5.5,5.5.571.571,0,0,0,.755-.54v-3.239A2.481,2.481,0,0,0,62.963,162.057ZM64.3,166.93A7.746,7.746,0,0,1,61.006,164a7.566,7.566,0,0,1-.434-.8h2.391a1.337,1.337,0,0,1,1.335,1.336v2.395Z" transform="translate(-59.155 -162.057)"></path>
                            </g>
                        </g>
                        <g id="Group_1969" data-name="Group 1969" transform="translate(0 0)">
                            <g id="Group_1968" data-name="Group 1968" transform="translate(0 0)">
                                <g id="Group_1967" data-name="Group 1967">
                                    <path id="Path_20920" data-name="Path 20920" d="M25.362,73.847a11.5,11.5,0,0,0,1.73-6.077.571.571,0,0,0-.571-.571H20.154a5.172,5.172,0,0,0-4.89,3.505,3.049,3.049,0,0,0-1.141-1.684,3.563,3.563,0,0,1,3.534-3.144.571.571,0,0,0,0-1.143,4.706,4.706,0,0,0-4.13,2.457A4.706,4.706,0,0,0,9.4,64.734a.571.571,0,0,0,0,1.143,3.564,3.564,0,0,1,3.536,3.165,3.134,3.134,0,0,0-1.106,1.666A5.171,5.171,0,0,0,6.938,67.2H.571A.571.571,0,0,0,0,67.77,11.527,11.527,0,0,0,5.863,77.813a8.508,8.508,0,0,0-2.854,6.364.571.571,0,0,0,.571.571H8.2a3.906,3.906,0,0,0,3.426-2.036c.459,1.5,1.105,2.264,1.923,2.264s1.463-.761,1.923-2.262a3.905,3.905,0,0,0,3.425,2.035h4.618a.571.571,0,0,0,.571-.571,8.508,8.508,0,0,0-2.855-6.364A11.53,11.53,0,0,0,25.362,73.847Zm-14.4,7a2.763,2.763,0,0,1-2.76,2.76H4.172a7.371,7.371,0,0,1,3.067-5.432,1.12,1.12,0,0,0,.185-.223.57.57,0,0,0-.276-.759,10.387,10.387,0,0,1-5.99-8.85h5.78a4.025,4.025,0,0,1,4.02,4.02v8.484Zm4.034-3.663a19.456,19.456,0,0,1-.568,5.04c-.382,1.337-.788,1.61-.876,1.61s-.495-.273-.876-1.61a11.689,11.689,0,0,1-.259-1.141h.652a.571.571,0,0,0,0-1.143h-.817c-.05-.454-.088-.932-.113-1.428h1.412a.571.571,0,0,0,0-1.143H12.1c0-.071,0-.141,0-.212a22.532,22.532,0,0,1,.534-5.166c.379-1.534.805-1.949.911-1.983.106.035.532.449.911,1.983a22.5,22.5,0,0,1,.534,5.138v.054Zm4.953.007a.572.572,0,0,0-.277.759.579.579,0,0,0,.163.206h0l.018.014,0,0a7.371,7.371,0,0,1,3.068,5.433H18.895a2.763,2.763,0,0,1-2.76-2.76V78.728c0-.007,0-.014,0-.021V72.362a4.025,4.025,0,0,1,4.02-4.02h5.78a10.387,10.387,0,0,1-5.99,8.848Z" transform="translate(0 -64.734)"></path>
                                    <path id="Path_20921" data-name="Path 20921" d="M340.272,162.353a.548.548,0,0,0-.037-.058.561.561,0,0,0-.043-.053.57.57,0,0,0-.421-.186h-3.236a2.481,2.481,0,0,0-2.478,2.478h0v3.239h0a.564.564,0,0,0,.016.135.57.57,0,0,0,.739.405A8.734,8.734,0,0,0,337,167.2l.154-.11q.229-.167.447-.349l.144-.123a8.921,8.921,0,0,0,1.721-2.021,8.8,8.8,0,0,0,.849-1.79.572.572,0,0,0-.039-.459ZM338.492,164a7.749,7.749,0,0,1-3.293,2.929v-2.395a1.337,1.337,0,0,1,1.336-1.336h2.391A7.69,7.69,0,0,1,338.492,164Z" transform="translate(-316.381 -156.906)"></path>
                                    <path id="Path_20922" data-name="Path 20922" d="M342.283,340.674q-.114-.09-.232-.175a.572.572,0,0,0-.479-.087l-.052.017a.571.571,0,0,0-.133,1c.074.053.147.109.217.166a4.685,4.685,0,0,1,1.048,1.184.566.566,0,0,0,.095.115.559.559,0,0,0,.094.07.566.566,0,0,0,.451.063.562.562,0,0,0,.075-.027.575.575,0,0,0,.072-.038.567.567,0,0,0,.165-.155.57.57,0,0,0,.018-.631q-.154-.247-.329-.477a5.818,5.818,0,0,0-.77-.824Q342.406,340.771,342.283,340.674Z" transform="translate(-323.096 -325.806)"></path>
                                </g>
                            </g>
                        </g>
                        <g id="Group_1971" data-name="Group 1971" transform="translate(6.481 14.587)">
                            <g id="Group_1970" data-name="Group 1970">
                                <path id="Path_20923" data-name="Path 20923" d="M124.926,340.645a.572.572,0,0,0-.8-.133,5.831,5.831,0,0,0-1.57,1.675.571.571,0,1,0,.97.6,4.7,4.7,0,0,1,1.264-1.349A.571.571,0,0,0,124.926,340.645Z" transform="translate(-122.474 -340.406)"></path>
                            </g>
                        </g>
                        <g id="Group_1973" data-name="Group 1973" transform="translate(3.13 5.15)">
                            <g id="Group_1972" data-name="Group 1972" transform="translate(0 0)">
                                <path id="Path_20924" data-name="Path 20924" d="M62.963,162.057H59.727a.571.571,0,0,0-.54.756,8.86,8.86,0,0,0,5.5,5.5.571.571,0,0,0,.755-.54v-3.239A2.481,2.481,0,0,0,62.963,162.057ZM64.3,166.93A7.746,7.746,0,0,1,61.006,164a7.566,7.566,0,0,1-.434-.8h2.391a1.337,1.337,0,0,1,1.335,1.336v2.395Z" transform="translate(-59.155 -162.057)"></path>
                            </g>
                        </g>
                        <g id="Group_1975" data-name="Group 1975" transform="translate(18.051 14.586)">
                            <g id="Group_1974" data-name="Group 1974">
                                <path id="Path_20925" data-name="Path 20925" d="M343.622,342.175a5.835,5.835,0,0,0-1.57-1.676.571.571,0,0,0-.665.929,4.689,4.689,0,0,1,1.265,1.35.571.571,0,0,0,.97-.6Z" transform="translate(-341.148 -340.392)"></path>
                            </g>
                        </g>
                        <g id="SVGCleanerId_2" transform="translate(17.676 5.15)">
                            <g id="Group_1976" data-name="Group 1976" transform="translate(0 0)">
                                <path id="Path_20926" data-name="Path 20926" d="M340.235,162.3a.57.57,0,0,0-.464-.239h-3.236a2.481,2.481,0,0,0-2.478,2.478v3.239a.571.571,0,0,0,.756.54,8.86,8.86,0,0,0,5.5-5.5A.571.571,0,0,0,340.235,162.3Zm-1.743,1.7a7.749,7.749,0,0,1-3.293,2.929v-2.395a1.337,1.337,0,0,1,1.336-1.336h2.391A7.7,7.7,0,0,1,338.492,164Z" transform="translate(-334.057 -162.058)"></path>
                            </g>
                        </g>
                        <g id="Group_1978" data-name="Group 1978" transform="translate(17.676 5.15)">
                            <g id="Group_1977" data-name="Group 1977" transform="translate(0 0)">
                                <path id="Path_20927" data-name="Path 20927" d="M340.235,162.3a.57.57,0,0,0-.464-.239h-3.236a2.481,2.481,0,0,0-2.478,2.478v3.239a.571.571,0,0,0,.756.54,8.86,8.86,0,0,0,5.5-5.5A.571.571,0,0,0,340.235,162.3Zm-1.743,1.7a7.749,7.749,0,0,1-3.293,2.929v-2.395a1.337,1.337,0,0,1,1.336-1.336h2.391A7.7,7.7,0,0,1,338.492,164Z" transform="translate(-334.057 -162.058)"></path>
                            </g>
                        </g>
                        <g id="Group_1980" data-name="Group 1980" transform="translate(3.13 5.15)">
                            <g id="Group_1979" data-name="Group 1979" transform="translate(0 0)">
                                <path id="Path_20928" data-name="Path 20928" d="M62.963,162.057H59.727a.571.571,0,0,0-.54.756,8.86,8.86,0,0,0,5.5,5.5.571.571,0,0,0,.755-.54v-3.239A2.481,2.481,0,0,0,62.963,162.057ZM64.3,166.93A7.746,7.746,0,0,1,61.006,164a7.566,7.566,0,0,1-.434-.8h2.391a1.337,1.337,0,0,1,1.335,1.336v2.395Z" transform="translate(-59.155 -162.057)"></path>
                            </g>
                        </g>
                        <g id="Group_1982" data-name="Group 1982" transform="translate(6.481 14.587)">
                            <g id="Group_1981" data-name="Group 1981">
                                <path id="Path_20929" data-name="Path 20929" d="M124.926,340.645a.572.572,0,0,0-.8-.133,5.831,5.831,0,0,0-1.57,1.675.571.571,0,1,0,.97.6,4.7,4.7,0,0,1,1.264-1.349A.571.571,0,0,0,124.926,340.645Z" transform="translate(-122.474 -340.406)"></path>
                            </g>
                        </g>
                        <g id="Group_1984" data-name="Group 1984" transform="translate(18.051 14.586)">
                            <g id="Group_1983" data-name="Group 1983">
                                <path id="Path_20930" data-name="Path 20930" d="M343.622,342.175a5.835,5.835,0,0,0-1.57-1.676.571.571,0,0,0-.665.929,4.689,4.689,0,0,1,1.265,1.35.571.571,0,0,0,.97-.6Z" transform="translate(-341.148 -340.392)"></path>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Dementia + <br> Delirium </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('bed_flag_dashboard_view'))  class="nav-item cyan-border {{ Request::RouteIs('bed.status.flag') ? 'active' : '' }}" @else class="nav-item  ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('bed_flag_dashboard_view') }}"  @endif >
                <a @if(PermitedStatus('bed_flag_dashboard_view')) href="{{ route('bed.status.flag') }}" @endif class="nav-link {{ Request::RouteIs('bed.status.flag') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="i-inpatient-svgrepo-com" width="30" height="20" viewBox="0 0 32.438 20.268" fill="currentColor">
                        <path id="Path_20886" data-name="Path 20886" d="M10.643,33.756a2.267,2.267,0,1,1,2.267,2.267A2.263,2.263,0,0,1,10.643,33.756Z" transform="translate(-5.94 -28.335)"></path>
                        <path id="Path_20887" data-name="Path 20887" d="M37.334,33.133a1.791,1.791,0,0,1,1.81,1.771l0,4.781H20.958V33.138Z" transform="translate(-10.742 -29.099)"></path>
                        <path id="Path_20888" data-name="Path 20888" d="M13.262,43.441a1.115,1.115,0,0,0,0-2.23H10.039a1.115,1.115,0,0,0,0,2.23Z" transform="translate(-5.14 -32.859)"></path>
                        <path id="Path_20889" data-name="Path 20889" d="M31.329,40.869v4.985h2.952V30.045a1.476,1.476,0,0,0-2.952,0V37.3H4.824V27.062A1.52,1.52,0,0,0,3.3,25.586h0a1.459,1.459,0,0,0-1.454,1.475V45.854h2.98V40.868H31.329Z" transform="translate(-1.844 -25.586)"></path>
                    </svg>
                    <br>
                    <span class="link-name">Bed Flag <br> Dashboard </span>
                </a>
            </li>
            <div class="borderline"></div>
        </ul>
    </nav>
</div>
