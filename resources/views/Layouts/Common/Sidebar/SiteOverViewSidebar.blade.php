

<div class="sidebar-menu d-none d-lg-block" id="sidebar">
    <nav class="" id="navbar">
        <ul class="">
            <li class="nav-item cyan-border ">
                <a href="{{ route('home') }}" class="nav-link ">
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
            <li @if(CheckDashboardPermission('flow_dashboard_siteoverview_view'))class="nav-item cyan-border   {{ Request::RouteIs('inpatients.siteoverview') ? 'active' : '' }} " @else class="nav-item ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                <a  @if(CheckDashboardPermission('flow_dashboard_siteoverview_view')) href="{{ route('inpatients.siteoverview') }}" @endif class="nav-link {{ Request::RouteIs('inpatients.siteoverview') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="30" viewBox="0 0 26.813 31.063" fill="currentColor">
                        <path id="document-file-paper-28-svgrepo-com" d="M27.957,22.275v-11.7a.87.87,0,0,0-.252-.612l-.881-.881L21.881,4.141,21,3.262a.87.87,0,0,0-.612-.252H9.8A4.314,4.314,0,0,0,5.5,7.329V29.751A4.314,4.314,0,0,0,9.8,34.07h.935a.864.864,0,1,0,0-1.727H9.8a2.586,2.586,0,0,1-2.574-2.591V7.329A2.586,2.586,0,0,1,9.8,4.737h9.783a1.385,1.385,0,0,0-.057.38V8.832a2.613,2.613,0,0,0,2.608,2.608h3.712a1.408,1.408,0,0,0,.382-.057v9.425c-.093-.048-.192-.079-.288-.121s-.2-.092-.307-.13a5.35,5.35,0,0,0-.648-.192c-.088-.021-.174-.05-.264-.066a5.258,5.258,0,0,0-.929-.088c-.054,0-.105.009-.159.01a5.334,5.334,0,0,0-.777.074c-.1.017-.2.043-.3.067a5.781,5.781,0,0,0-.627.185c-.1.038-.2.076-.3.121a5.116,5.116,0,0,0-.6.316c-.085.05-.171.1-.252.152a5.274,5.274,0,0,0-.769.629A5.3,5.3,0,0,0,20.74,29.9c.067.048.136.092.206.136a5.225,5.225,0,0,0,.691.371c.048.022.1.048.145.069a5.22,5.22,0,0,0,.862.263c.081.017.162.028.245.041a5.524,5.524,0,0,0,.7.069c.057,0,.112.017.168.017.028,0,.055-.009.085-.009a5.322,5.322,0,0,0,.947-.1c.074-.014.145-.036.219-.054.131-.031.264-.055.394-.1l.472.468a2.565,2.565,0,0,1-2.211,1.271h-9.95a.864.864,0,1,0,0,1.727h9.95a4.29,4.29,0,0,0,3.458-1.759l1.036,1.03a2.4,2.4,0,0,0,1.726.729h0a2.426,2.426,0,0,0,1.715-4.149l-2.759-2.774A5.316,5.316,0,0,0,27.957,22.275Zm-6.164.247c.085-.055.178-.092.266-.14a4.039,4.039,0,0,1,.363-.19c.111-.045.226-.069.34-.1s.216-.074.328-.1a3.14,3.14,0,0,1,.358-.038c.109-.01.219-.031.328-.031a3.2,3.2,0,0,1,.427.035c.081.009.164.009.244.022a3.369,3.369,0,0,1,.406.112c.079.024.162.038.24.069a3.552,3.552,0,0,1,.4.2c.066.036.138.062.2.1a3.1,3.1,0,0,1,.53.423,2.156,2.156,0,0,0,.223.252A3.619,3.619,0,0,1,27.05,27a3.487,3.487,0,0,1-.586.878.721.721,0,0,0-.154.187,4.026,4.026,0,0,1-.515.437,2.947,2.947,0,0,1-.53.3h0l-.01.007a3.562,3.562,0,0,1-4.028-.739,3.607,3.607,0,0,1,.567-5.549Zm.342-12.809a.882.882,0,0,1-.881-.881V5.959l3.754,3.754H22.135Zm8.449,21.921a.667.667,0,0,1-.206.485l-.017.017a.667.667,0,0,1-.485.206.679.679,0,0,1-.5-.214l-1.864-1.859s0-.009-.007-.012l-.463-.456-.041-.041a6.224,6.224,0,0,0,.529-.468,1.858,1.858,0,0,0,.254-.3c.071-.078.14-.159.206-.244l2.386,2.4A.667.667,0,0,1,30.584,31.634Z" transform="translate(-5.5 -3.01)" fill="currentColor"></path>
                    </svg>
                    <br>
                    <span class="link-name">Site <br>Overview</span>
                </a>
            </li>

            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('flow_dashboard_red_bed_view') || CheckDashboardPermission('flow_dashboard_redbed_performance_view')) class="nav-item cyan-border   {{ Request::RouteIs('red.bed.dashboard') ? 'active' : '' }} " @else class="nav-item ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                <a @if(CheckDashboardPermission('flow_dashboard_red_bed_view') || CheckDashboardPermission('flow_dashboard_redbed_performance_view')) href="{{ route('red.bed.dashboard') }}" @endif class="nav-link  {{ Request::RouteIs('red.bed.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 30 45" fill="currentColor">
                        <g id="Group_2961" data-name="Group 2961" transform="translate(-85 -617)">
                            <g id="Group_2959" data-name="Group 2959">
                                <g id="Group_2958" data-name="Group 2958">
                                    <g id="Group_2957" data-name="Group 2957" transform="translate(83.614 617.424)">
                                        <g id="Ellipse_707" data-name="Ellipse 707" transform="translate(0.386 8.576)" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="15.5" cy="15.5" r="15.5" stroke="none"></circle>
                                            <circle cx="15.5" cy="15.5" r="14.75" fill="none"></circle>
                                        </g>
                                        <g id="Subtraction_106" data-name="Subtraction 106" transform="translate(3.481 11.535)" fill="none">
                                            <path d="M14.6,25.06h0V23.295a2.07,2.07,0,0,0-4.141,0v1.764A12.705,12.705,0,0,1,0,14.6H1.489a2.07,2.07,0,1,0,0-4.14H0A12.707,12.707,0,0,1,10.46,0V1.489a2.07,2.07,0,0,0,4.141,0V0A12.709,12.709,0,0,1,25.06,10.46H22.882a2.07,2.07,0,1,0,0,4.14H25.06A12.71,12.71,0,0,1,14.6,25.06Z" stroke="none"></path>
                                            <path d="M 16.09775543212891 23.1492977142334 C 17.72684669494629 22.60423851013184 19.20804214477539 21.68765449523926 20.4481143951416 20.4475154876709 C 21.68748092651367 19.20806694030762 22.60362434387207 17.72780227661133 23.14865493774414 16.09980392456055 L 22.88161468505859 16.09980392456055 C 20.91309547424316 16.09980392456055 19.31159400939941 14.49830532073975 19.31159400939941 12.52980518341064 C 19.31159400939941 10.56130504608154 20.91309547424316 8.959804534912109 22.88162422180176 8.959804534912109 L 23.14861869812012 8.959806442260742 C 22.60359954833984 7.331906795501709 21.6875114440918 5.851880073547363 20.44817543029785 4.612595081329346 C 19.20284271240234 3.367322206497192 17.71402549743652 2.448235988616943 16.07668304443359 1.904097080230713 C 15.87013339996338 3.677505731582642 14.35864162445068 5.058614730834961 12.5307149887085 5.058614730834961 C 10.70220279693604 5.058614730834961 9.190258979797363 3.67735481262207 8.98381519317627 1.903778076171875 C 7.346284866333008 2.447779178619385 5.857571601867676 3.366777896881104 4.612174987792969 4.612174987792969 C 3.366777896881104 5.857579231262207 2.447787284851074 7.346264839172363 1.903790235519409 8.98378849029541 C 3.67798376083374 9.190022468566895 5.059504985809326 10.70163726806641 5.059504985809326 12.52980518341064 C 5.059504985809326 14.35797214508057 3.677970886230469 15.86958885192871 1.903769493103027 16.0758228302002 C 2.447780847549438 17.71346855163574 3.366820573806763 19.20239639282227 4.61222505569458 20.44793510437012 C 5.852436065673828 21.68825721740723 7.333699703216553 22.6046199798584 8.962748527526855 23.1490478515625 C 9.039432525634766 21.24780464172363 10.61050701141357 19.7247142791748 12.5307149887085 19.7247142791748 C 14.45019435882568 19.7247142791748 16.02072525024414 21.24747085571289 16.09775543212891 23.1492977142334 M 14.59954452514648 25.06000518798828 L 14.60071468353271 23.29470443725586 C 14.60071468353271 22.15330505371094 13.67210483551025 21.2247142791748 12.5307149887085 21.2247142791748 C 11.38881492614746 21.2247142791748 10.45981502532959 22.15330505371094 10.45981502532959 23.29470443725586 L 10.45981502532959 25.05877494812012 C 7.832074642181396 24.62883567810059 5.443624973297119 23.40083503723145 3.551514863967896 21.508544921875 C 1.659204840660095 19.61603546142578 0.4312948286533356 17.22703552246094 0.0005348272970877588 14.59979438781738 L 1.488614797592163 14.59980487823486 C 2.630504846572876 14.59980487823486 3.559504747390747 13.67120456695557 3.559504747390747 12.52980518341064 C 3.559504747390747 11.38840484619141 2.630504846572876 10.45980453491211 1.488614797592163 10.45980453491211 L 0.0005348272970877588 10.45980453491211 C 0.4314248263835907 7.831804752349854 1.659684777259827 5.443355083465576 3.551514863967896 3.551514863967896 C 5.443844795227051 1.659194827079773 7.832695007324219 0.4312848448753357 10.45981502532959 0.0005348544218577445 L 10.45981502532959 1.488614797592163 C 10.45981502532959 2.630014896392822 11.38881492614746 3.55861496925354 12.5307149887085 3.55861496925354 C 13.67210483551025 3.55861496925354 14.60071468353271 2.630014896392822 14.60071468353271 1.488614797592163 L 14.60071468353271 0.0006748544401489198 C 17.22858428955078 0.4318148493766785 19.61696434020996 1.660154819488525 21.50880432128906 3.551904916763306 C 23.40122413635254 5.444244861602783 24.62918472290039 7.832964897155762 25.05995559692383 10.45981502532959 L 22.88161468505859 10.45980453491211 C 21.74020576477051 10.45980453491211 20.81159400939941 11.38840484619141 20.81159400939941 12.52980518341064 C 20.81159400939941 13.67120456695557 21.74020576477051 14.59980487823486 22.88161468505859 14.59980487823486 L 25.05996513366699 14.59980487823486 C 24.6290454864502 17.2276439666748 23.40072441101074 19.61610412597656 21.50880432128906 21.50814437866211 C 19.61642456054688 23.40062522888184 17.2276439666748 24.62877464294434 14.60070514678955 25.059814453125 L 14.59954452514648 25.06000518798828 Z" stroke="none" fill="currentColor"></path>
                                        </g>
                                        <g id="Rectangle_15983" data-name="Rectangle 15983" transform="translate(9.386 -0.424)" fill="#fff" stroke="currentColor" stroke-width="1.5">
                                            <path d="M3,0h7a3,3,0,0,1,3,3V6a0,0,0,0,1,0,0H0A0,0,0,0,1,0,6V3A3,3,0,0,1,3,0Z" stroke="none"></path>
                                            <path d="M3,.75h7A2.25,2.25,0,0,1,12.25,3V4.5a.75.75,0,0,1-.75.75H1.5A.75.75,0,0,1,.75,4.5V3A2.25,2.25,0,0,1,3,.75Z" fill="none"></path>
                                        </g>
                                        <path id="Path_22108" data-name="Path 22108" d="M-12433.177-8949.25v4.162" transform="translate(12447.092 8953.958)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                        <path id="Path_22110" data-name="Path 22110" d="M-12434.48-8970.049l-2.437,7.047" transform="translate(12439 9004.578)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                        <path id="Path_22113" data-name="Path 22113" d="M-12436.918-8970.049l2.438,7.047" transform="translate(12464.257 9004.578)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                        <path id="Path_22111" data-name="Path 22111" d="M-12435.379-8966.776l-1.539,4.379" transform="translate(12443.83 9003.974)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                        <path id="Path_22115" data-name="Path 22115" d="M-12436.919-8966.776l1.539,4.379" transform="translate(12460.326 9003.974)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                        <path id="Path_22109" data-name="Path 22109" d="M-12433.177-8949.25v4.162" transform="translate(12450.957 8953.958)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                    </g>
                                    <path id="Path_22114" data-name="Path 22114" d="M-11981.23-9546h43.88" transform="translate(12058.73 10205)" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                    <path id="Path_2" data-name="Path 2" d="M15.156,11.718h-1.6a1.665,1.665,0,0,0-.863.117,2.517,2.517,0,0,0-.643.776l-.7,1.027c-.244.36-.366.541-.521.536s-.271-.191-.5-.565L7.953,9.768c-.216-.349-.324-.523-.471-.535s-.27.144-.516.456L5.951,10.975a2.36,2.36,0,0,1-.616.647,1.649,1.649,0,0,1-.781.1H3" transform="translate(88.416 629.727)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.2"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Red to Green</span>
                </a>
            </li>

{{--            <div class="borderline"></div>--}}
{{--            <li @if(CheckDashboardPermission('leaflet_dashboard_view'))  class="nav-item cyan-border {{ Request::RouteIs('virtual.ward.leaflet') ? 'active' : '' }} " @else class="nav-item ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();" @endif>--}}
{{--                <a @if(CheckDashboardPermission('leaflet_dashboard_view')) href="{{ route('virtual.ward.leaflet') }}" @endif class="nav-link {{ Request::RouteIs('virtual.ward.leaflet') ? 'active' : '' }}">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="40" viewBox="0 0 50 40" fill="currentColor">--}}
{{--                        <g id="Group_2962" data-name="Group 2962" transform="translate(-80 -895)">--}}
{{--                            <g id="document-svgrepo-com" transform="translate(91 905)">--}}
{{--                                <path id="Path_22102" data-name="Path 22102" d="M3,16V11.333c0-4.4,0-6.6,1.367-7.967S7.934,2,12.333,2h2.333c4.4,0,6.6,0,7.966,1.367a5.045,5.045,0,0,1,1.248,3.3M24,11.333V16c0,4.4,0,6.6-1.367,7.966s-3.567,1.367-7.966,1.367H12.333c-4.4,0-6.6,0-7.967-1.367a5.045,5.045,0,0,1-1.248-3.3" transform="translate(0 0)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>--}}
{{--                                <path id="Path_22103" data-name="Path 22103" d="M8,14h5.833" transform="translate(0.833 2)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>--}}
{{--                                <path id="Path_22104" data-name="Path 22104" d="M8,10H9.167m8.167,0H12.667" transform="translate(0.833 1.333)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"></path>--}}
{{--                            </g>--}}
{{--                        </g>--}}
{{--                    </svg>--}}
{{--                    <br>--}}
{{--                    <span class="link-name">Leaflet 01 </span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <div class="borderline"></div>
            <li @if(PermitedStatus('stranded_dashboard')) class="nav-item cyan-border {{ Request::RouteIs('site.stranded_patients') ? 'active' : '' }}  " @else  class="nav-item  ibox-side-menu-disabled-icon"  onclick="CommonLoginModalPopupOpenOnRequest();"  @endif >
                <a @if(PermitedStatus('stranded_dashboard'))  href="{{ route('site.stranded_patients') }}" class="nav-link {{ Request::RouteIs('site.stranded_patients') ? 'active' : '' }}" @else class="nav-link" @endif  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="40" viewBox="0 0 50 40" fill="currentColor">
                        <g id="Group_2953" data-name="Group 2953" transform="translate(-80 -1165)">
                            <g id="Group_2951" data-name="Group 2951" transform="translate(-3 -1.286)">
                                <g id="Rectangle_15973" data-name="Rectangle 15973" transform="translate(96 1178.286)" fill="none" stroke="currentColor" stroke-width="1">
                                    <rect width="10" height="10" rx="2" stroke="none"></rect>
                                    <rect x="0.5" y="0.5" width="9" height="9" rx="1.5" fill="none"></rect>
                                </g>
                                <g id="Rectangle_15974" data-name="Rectangle 15974" transform="translate(110 1178.286)" fill="none" stroke="currentColor" stroke-width="1">
                                    <rect width="10" height="10" rx="2" stroke="none"></rect>
                                    <rect x="0.5" y="0.5" width="9" height="9" rx="1.5" fill="none"></rect>
                                </g>
                                <path id="Path_22100" data-name="Path 22100" d="M10.22,10.342H9.272a1.286,1.286,0,0,0-.513.052,1.287,1.287,0,0,0-.382.346l-.413.459c-.145.161-.217.241-.309.239s-.161-.085-.3-.252L5.941,9.471c-.128-.156-.193-.233-.28-.239s-.16.064-.306.2l-.6.574a1.278,1.278,0,0,1-.366.289,1.278,1.278,0,0,1-.464.043H3" transform="translate(93.96 1172.935)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"></path>
                                <path id="Path_22101" data-name="Path 22101" d="M12,8v2.295l1.434,1.434" transform="translate(102.682 1173.484)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"></path>
                            </g>
                            <rect id="Rectangle_15975" data-name="Rectangle 15975" width="29" height="2" rx="1" transform="translate(90 1199)"></rect>
                            <rect id="Rectangle_15978" data-name="Rectangle 15978" width="18" height="2" rx="1" transform="translate(100 1195)"></rect>
                            <rect id="Rectangle_15976" data-name="Rectangle 15976" width="16" height="2" rx="1" transform="translate(92 1190) rotate(90)"></rect>
                            <rect id="Rectangle_15977" data-name="Rectangle 15977" width="7" height="2" rx="1" transform="translate(119 1199) rotate(90)"></rect>
                            <circle id="Ellipse_706" data-name="Ellipse 706" cx="2" cy="2" r="2" transform="translate(95 1193)"></circle>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Patients <br> By LOS </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('r_to_r_view_')) class="nav-item cyan-border {{ Request::RouteIs('reason_reside.dashboard') ? 'active' : '' }}  " @else  class="nav-item  ibox-side-menu-disabled-icon "   onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a  @if(PermitedStatus('r_to_r_view_')) href="{{ route('reason_reside.dashboard') }}" class="nav-link {{ Request::RouteIs('reason_reside.dashboard') ? 'active' : '' }}" @else class="nav-link " @endif >
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="40" viewBox="0 0 50 40" fill="currentColor">
                        <g id="Group_2954" data-name="Group 2954" transform="translate(-77 -1290)">
                            <path id="Subtraction_1" data-name="Subtraction 1" d="M12074.119,10234.5h-.037a11.561,11.561,0,0,1-3.753-.617,22.207,22.207,0,0,0-4.945-1.35v1a.751.751,0,0,1-.75.749h-3.883a.751.751,0,0,1-.75-.749v-12.209a.751.751,0,0,1,.75-.75h3.883a.751.751,0,0,1,.75.75v.758h2.169a.634.634,0,0,1,.21.031l4.76,1.393h3.784l-.01,0a2.02,2.02,0,0,1,.2-.01,2.514,2.514,0,0,1,2.5,2.477.23.23,0,0,1-.014.071l0,.007a.274.274,0,0,0-.012.058l5.779-2.6-.024.012a3.748,3.748,0,0,1,3.034-.082l.019.007a3.157,3.157,0,0,1,1.6,2.336v-.006a.745.745,0,0,1-.03.431l-.006.021a3.1,3.1,0,0,1-.871,1.116l.013-.016a17.169,17.169,0,0,1-1.562,1.254c-1.182.854-2.494,1.7-4.13,2.673-.292.172-.579.349-.947.578a21.631,21.631,0,0,1-3.282,1.788l.079-.027A11.821,11.821,0,0,1,12074.119,10234.5Zm-3.446-2.079h0a10.577,10.577,0,0,0,3.437.573,10.342,10.342,0,0,0,3.893-.747l.128-.051a20.594,20.594,0,0,0,2.864-1.587l.159-.1.025-.015c.279-.173.568-.351.853-.519,1.607-.953,2.883-1.778,4.015-2.6l.048-.033a14.8,14.8,0,0,0,1.326-1.06l0,0a4.16,4.16,0,0,0,.429-.437v-.012a1.618,1.618,0,0,0-.752-1.044,2.337,2.337,0,0,0-.743-.118,2.385,2.385,0,0,0-.98.209l-7.794,3.5a.743.743,0,0,1-.3.064h-7.785a.75.75,0,1,1,0-1.5h6.808c.885,0,1.2-.521,1.2-.968s-.314-.972-1.2-.972h-3.89a.63.63,0,0,1-.209-.03l-4.761-1.4h-2.062v7.437l.118.013a21.713,21.713,0,0,1,5.249,1.407Zm-9.173-10.343v10.71h2.382v-10.71Zm14.19-1.344a.739.739,0,0,1-.556-.246l-5.979-6.632c-.115-.106-.224-.217-.322-.326a2.565,2.565,0,0,0,1.369-.421c.051-.042.107-.088.168-.136l5.32,5.895,5.422-6.014.027-.027a4.3,4.3,0,0,0,1.407-2.973v-.007a3.361,3.361,0,0,0-3.331-3.35h-.036a4.26,4.26,0,0,0-2.962,1.408.75.75,0,0,1-1.059,0,3.742,3.742,0,0,0-2.643-1.214,3.162,3.162,0,0,0-.834.109l-.024.006a3.647,3.647,0,0,0-2.519,2.54,3.427,3.427,0,0,0-.1.825,3.509,3.509,0,0,0,.247,1.3c-.076.031-.157.061-.241.088a7.545,7.545,0,0,1-1.217.287,5.029,5.029,0,0,1-.14-2.891l.009-.036a5.173,5.173,0,0,1,3.6-3.568l-.036.006a5.017,5.017,0,0,1,1.25-.16,4.91,4.91,0,0,1,3.175,1.163,5.027,5.027,0,0,1,6.943.057,4.751,4.751,0,0,1,1.42,3.4v.051a5.7,5.7,0,0,1-1.832,4l-5.968,6.617A.751.751,0,0,1,12075.69,10220.735Z" transform="translate(-11971 -8904.408)"></path>
                            <path id="Path_2" data-name="Path 2" d="M15.5,11.155H13.862a2.227,2.227,0,0,0-.888.09,2.23,2.23,0,0,0-.661.6l-.715.794c-.251.279-.376.418-.536.415s-.278-.148-.517-.437L8.094,9.646c-.222-.27-.334-.4-.484-.413s-.277.111-.53.352l-1.044.995a2.213,2.213,0,0,1-.633.5,2.214,2.214,0,0,1-.8.074H3" transform="translate(94.5 1296.273)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.2"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Reason to <br> Reside </span>
                </a>
            </li>

            <div class="borderline"></div>
            <li @if(PermitedStatus('allowed_to_move_dashboard_view')) class="nav-item cyan-border {{ Request::RouteIs('allowed_to_move.dashboard') ? 'active' : '' }}  " @else class="nav-item  ibox-side-menu-disabled-icon "  onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
                <a @if(PermitedStatus('allowed_to_move_dashboard_view')) href="{{ route('allowed_to_move.dashboard') }}" class="nav-link {{ Request::RouteIs('allowed_to_move.dashboard') ? 'active' : '' }}" @else class="nav-link" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24.269 24.269">
                        <g id="bed-single-hotel-svgrepo-com" transform="translate(-1.75 -1.75)">
                            <path id="Path_21440" data-name="Path 21440" d="M6,9h4.837" transform="translate(0.628 1.256)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                            <path id="Path_21441" data-name="Path 21441" d="M3,3V24.769m21.769-4.837v4.837m0-4.837H3m21.769,0V16.3a2.419,2.419,0,0,0-2.419-2.419H3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Allowed To <br> Move </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(PermitedStatus('discharged_patient_is_view_dashbaord_view')) class="nav-item cyan-border {{ Request::RouteIs('discharges_patient.dashboard') ? 'active' : '' }}  " @else class="nav-item  ibox-side-menu-disabled-icon "  onclick="CommonLoginModalPopupOpenOnRequest();"  @endif>
                <a @if(PermitedStatus('discharged_patient_is_view_dashbaord_view')) href="{{ route('discharges_patient.dashboard') }}" class="nav-link {{ Request::RouteIs('discharges_patient.dashboard') ? 'active' : '' }}" @else class="nav-link" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" id="Page-1" width="22" height="18" viewBox="0 0 28 18" fill="currentColor">
                        <g id="Icon-Set" transform="translate(-206 -626)">
                            <path id="list" d="M207,626a1,1,0,1,0,1,1,1,1,0,0,0-1-1Zm26,8H213a1,1,0,0,0,0,2h20a1,1,0,0,0,0-2Zm0,8H213a1,1,0,0,0,0,2h20a1,1,0,0,0,0-2Zm-26-8a1,1,0,1,0,1,1,1,1,0,0,0-1-1Zm0,8a1,1,0,1,0,1,1,1,1,0,0,0-1-1Zm6-14h20a1,1,0,0,0,0-2H213a1,1,0,0,0,0,2Z" fill-rule="evenodd"></path>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Discharged <br> Patients </span>
                </a>
            </li>
            {{-- <div class="borderline"></div>
            <li @if(CheckDashboardPermission('site_office_report_view'))  class="nav-item cyan-border {{ Request::RouteIs('site.office') ? 'active' : '' }}  "  @else class="nav-item ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('site_office_report_view')) href="{{ route('site.office') }}" @endif class="nav-link {{ Request::RouteIs('site.office') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 34 34" fill="currentColor">
                        <g id="dashboard" transform="translate(-2 -2)">
                            <line id="Line_1" data-name="Line 1" x2="32" transform="translate(3 35)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                            <line id="Line_2" data-name="Line 2" y2="32" transform="translate(3 3)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                            <line id="Line_3" data-name="Line 3" y2="22" transform="translate(19 8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                            <line id="Line_4" data-name="Line 4" y2="17" transform="translate(26 13)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                            <line id="Line_5" data-name="Line 5" y2="11" transform="translate(11 19)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Site Office <br> Tax Reports </span>
                </a>
            </li> --}}
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('pharmacy_dashboard_'))class="nav-item cyan-border   {{ Request::RouteIs('pharmacy.dashboard') ? 'active' : '' }} " @else class="nav-item ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();" @endif >
                <a @if(CheckDashboardPermission('pharmacy_dashboard_')) href="{{ route('pharmacy.dashboard') }}" @endif class="nav-link  {{ Request::RouteIs('pharmacy.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 50 30" fill="currentColor">
                        <g id="Group_2960" data-name="Group 2960" transform="translate(-80 -473)">
                            <g id="medicine-bottle-drug-svgrepo-com" transform="translate(88.018 471.019)">
                                <path id="Path_22116" data-name="Path 22116" d="M9.966,9.784l.006,1.192a.987.987,0,0,1-.986.991h0a3,3,0,0,0-3,3V26.98a3,3,0,0,0,3,3h14a3,3,0,0,0,3-3V14.967a3,3,0,0,0-3-3h0a1,1,0,0,1-1-1l0-1.193a3,3,0,0,0,1.986-2.823V4.981a3,3,0,0,0-3-3h-10a3,3,0,0,0-3,3V6.955a3,3,0,0,0,2,2.829Zm13.012,4.183h0a1,1,0,0,1,1,1V26.98a1,1,0,0,1-1,1H8.984a1,1,0,0,1-1-1V14.967a1,1,0,0,1,1-1h0a2.986,2.986,0,0,0,2.986-3l-.005-.985h8.011l0,.995A3,3,0,0,0,22.978,13.967ZM21.964,4.981V6.955a1,1,0,0,1-1,1h-10a1,1,0,0,1-1-1V4.981a1,1,0,0,1,1-1h10a1,1,0,0,1,1,1Z" fill-rule="evenodd"></path>
                                <path id="Path_22117" data-name="Path 22117" d="M14.982,17.98H12.97a1,1,0,0,0,0,2h2.012v2.011a1,1,0,0,0,2,0V19.98h2.011a1,1,0,0,0,0-2H16.982V15.968a1,1,0,1,0-2,0Z" fill-rule="evenodd"></path>
                            </g>
                        </g>
                    </svg>
                    <br>
                    <span class="link-name">Pharmacy <br> Dashboard </span>
                </a>
            </li>
            <div class="borderline"></div>
            <li @if(CheckDashboardPermission('flow_dashboard_patient_search_view'))  class="nav-item cyan-border {{ Request::RouteIs('global.patient.search') ? 'active' : '' }} "  @else class="nav-item ibox-side-menu-disabled-icon " onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                <a @if(CheckDashboardPermission('flow_dashboard_patient_search_view')) href="{{ route('global.patient.search') }}" @endif class="nav-link {{ Request::RouteIs('global.patient.search') ? 'active' : '' }}">
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
        </ul>
    </nav>
</div>
