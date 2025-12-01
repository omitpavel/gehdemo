<div class="mobile-menu" id="mobile-menu">
    @if (!in_array(Route::currentRouteName(), ['ed.performance', 'ed.home']))
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand ms-3  pt-lg-3 d-lg-none mt-2 mb-2" href="{{ url('/home') }}">
                <img alt="" width="115" height="35" src="{{ asset('asset_v2/Ibox/Images/iBox-Logo.svg') }}">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon " onclick="openNav()"></span>
            </button>
            <div id="mySidenav" class="sidenav d-lg-none">
                <a class="navbar-brand " href="{{ url('/home') }}">
                    <img alt="" width="115" height="35" src="{{ asset('asset_v2/Ibox/Images/iBox-Logo.svg') }}">
                </a>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="icons-bar">
                    <ul class="">
                        <li class="shape-btn ">
                            <a class=" text-center" href="{{ url('home') }}" role="button">
                                <svg id="home-svgrepo-com" width="19.08" height="19.514" viewBox="0 0 19.08 19.514">
                                    <g id="Group_210" data-name="Group 210" transform="translate(0)">
                                        <path id="Path_149" data-name="Path 149"
                                            d="M23.729,7.091,15.46.289a1.271,1.271,0,0,0-1.615,0L11.327,2.361v-.4a.636.636,0,0,0-.636-.636H7.642a.636.636,0,0,0-.636.636V5.915L5.576,7.091a1.271,1.271,0,0,0,.6,2.236v8.915a1.271,1.271,0,0,0,1.271,1.271H11.83A1.271,1.271,0,0,0,13.1,18.242V15a.52.52,0,0,1,.143-.394H16.06A.52.52,0,0,1,16.2,15v3.241a1.271,1.271,0,0,0,1.271,1.271h4.384a1.271,1.271,0,0,0,1.271-1.271V9.328a1.271,1.271,0,0,0,.6-2.236ZM8.278,2.6h1.778v.807L8.278,4.869Zm13.58,5.474V18.242H17.474V15a1.547,1.547,0,0,0-1.391-1.665H13.221A1.547,1.547,0,0,0,11.83,15v3.241H7.446V8.073H6.383l8.269-6.8,8.269,6.8Z"
                                            transform="translate(-5.112)"></path>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        {{-- <li class="shape-btn ">
                            <a class=" text-center" href="#" role="button">
                                <svg id="search-svgrepo-com" width="20.137" height="20.12" viewBox="0 0 20.137 20.12">
                                    <g id="Group_209" data-name="Group 209" transform="translate(0 0)">
                                        <path id="Path_147" data-name="Path 147" d="M19.883,18.886,14.105,13.1A7.8,7.8,0,0,0,15.93,8.086,7.965,7.965,0,0,0,0,8.09a7.973,7.973,0,0,0,12.9,6.178l5.8,5.8a.835.835,0,1,0,1.18-1.18ZM1.692,8.09a6.269,6.269,0,0,1,12.537,0,6.269,6.269,0,0,1-12.537,0Z" transform="translate(0 -0.2)"></path>
                                    </g>
                                </svg>
                            </a>
                        </li> --}}
                        {{-- <li class="shape-btn ">
                            <a class=" text-center" href="#" role="button">
                                <svg id="eye-svgrepo-com_1_" data-name="eye-svgrepo-com (1)" width="22.319" height="13.502" viewBox="0 0 22.319 13.502">
                                    <g id="Group_208" data-name="Group 208" transform="translate(0 0)">
                                        <g id="Group_207" data-name="Group 207" transform="translate(0 0)">
                                            <path id="Path_145" data-name="Path 145" d="M22.168,103.978a.786.786,0,0,0-.023-.957c-3.376-4.15-7.02-6.255-10.838-6.255-6.473,0-10.97,6.031-11.156,6.287a.786.786,0,0,0,.023.957c3.371,4.155,7.015,6.259,10.833,6.259C17.48,110.269,21.976,104.238,22.168,103.978Zm-11.161,4.729c-3.18,0-6.277-1.749-9.22-5.193,1.153-1.362,4.815-5.184,9.521-5.184,3.18,0,6.277,1.749,9.22,5.193C19.375,104.885,15.712,108.707,11.007,108.707Z" transform="translate(0 -96.767)">
                                            </path>
                                            <path id="Path_146" data-name="Path 146" d="M161.785,157.867a3.968,3.968,0,1,0,3.968,3.968A3.974,3.974,0,0,0,161.785,157.867Zm0,6.373a2.405,2.405,0,1,1,2.405-2.405A2.409,2.409,0,0,1,161.785,164.24Z" transform="translate(-150.628 -155.084)"></path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li> --}}
                        {{-- <li class="shape-btn ">
                            <a class=" text-center" href="#" role="button">
                                <svg id="settings-svgrepo-com" width="21.123" height="21.123" viewBox="0 0 21.123 21.123">
                                    <g id="Group_205" data-name="Group 205" transform="translate(0 0)">
                                        <path id="Path_139" data-name="Path 139"
                                            d="M20.042,8.345l-1.483-.252a8.371,8.371,0,0,0-.6-1.439l.874-1.222A1.3,1.3,0,0,0,18.7,3.752L17.381,2.437a1.3,1.3,0,0,0-.922-.384A1.282,1.282,0,0,0,15.7,2.3l-1.227.874a8.285,8.285,0,0,0-1.491-.613l-.247-1.465A1.3,1.3,0,0,0,11.451,0H9.593A1.3,1.3,0,0,0,8.3,1.091l-.256,1.5a8.166,8.166,0,0,0-1.434.6L5.4,2.322a1.3,1.3,0,0,0-1.681.141L2.4,3.778a1.306,1.306,0,0,0-.141,1.681L3.142,6.7a8.177,8.177,0,0,0-.587,1.443L1.09,8.389A1.3,1.3,0,0,0,0,9.678v1.858a1.3,1.3,0,0,0,1.09,1.288l1.5.256a8.166,8.166,0,0,0,.6,1.434l-.869,1.209A1.3,1.3,0,0,0,2.467,17.4l1.315,1.315A1.3,1.3,0,0,0,4.7,19.1a1.282,1.282,0,0,0,.755-.243l1.24-.883a8.348,8.348,0,0,0,1.394.574l.247,1.483a1.3,1.3,0,0,0,1.288,1.09H11.49a1.3,1.3,0,0,0,1.288-1.09l.252-1.483a8.372,8.372,0,0,0,1.439-.6l1.222.874a1.3,1.3,0,0,0,.759.243h0a1.3,1.3,0,0,0,.922-.384l1.315-1.315a1.306,1.306,0,0,0,.141-1.681l-.874-1.227a8.312,8.312,0,0,0,.6-1.439l1.483-.247a1.3,1.3,0,0,0,1.09-1.288V9.634A1.288,1.288,0,0,0,20.042,8.345Zm-.1,3.146a.114.114,0,0,1-.1.115l-1.853.309a.592.592,0,0,0-.477.437,7.064,7.064,0,0,1-.768,1.849.6.6,0,0,0,.026.649l1.09,1.536a.12.12,0,0,1-.013.15L16.534,17.85a.112.112,0,0,1-.084.035.108.108,0,0,1-.066-.022l-1.531-1.09a.6.6,0,0,0-.649-.026,7.064,7.064,0,0,1-1.849.768.586.586,0,0,0-.437.477l-.313,1.853a.114.114,0,0,1-.115.1H9.633a.114.114,0,0,1-.115-.1l-.309-1.853a.592.592,0,0,0-.437-.477,7.335,7.335,0,0,1-1.809-.741.611.611,0,0,0-.3-.079.581.581,0,0,0-.344.11L4.774,17.9a.131.131,0,0,1-.066.022.118.118,0,0,1-.084-.035L3.309,16.575a.12.12,0,0,1-.013-.15L4.382,14.9a.6.6,0,0,0,.026-.653A7,7,0,0,1,3.632,12.4a.6.6,0,0,0-.477-.437L1.288,11.65a.114.114,0,0,1-.1-.115V9.678a.114.114,0,0,1,.1-.115l1.84-.309a.6.6,0,0,0,.481-.441A7.057,7.057,0,0,1,4.364,6.96a.589.589,0,0,0-.031-.644l-1.1-1.544a.12.12,0,0,1,.013-.15L4.563,3.306a.112.112,0,0,1,.084-.035.108.108,0,0,1,.066.022L6.235,4.378a.6.6,0,0,0,.653.026,7,7,0,0,1,1.844-.777.6.6,0,0,0,.437-.477l.318-1.867a.114.114,0,0,1,.115-.1H11.46a.114.114,0,0,1,.115.1l.309,1.84a.6.6,0,0,0,.441.481,7.162,7.162,0,0,1,1.893.777.6.6,0,0,0,.649-.026l1.522-1.094a.131.131,0,0,1,.066-.022.118.118,0,0,1,.084.035L17.853,4.59a.12.12,0,0,1,.013.15l-1.09,1.531a.6.6,0,0,0-.026.649,7.064,7.064,0,0,1,.768,1.849.586.586,0,0,0,.477.437l1.853.313a.114.114,0,0,1,.1.115v1.858Z"
                                            transform="translate(0 -0.001)"></path>
                                        <path id="Path_140" data-name="Path 140" d="M140.658,136a4.558,4.558,0,1,0,4.558,4.558A4.561,4.561,0,0,0,140.658,136Zm0,7.925a3.367,3.367,0,1,1,3.367-3.367A3.369,3.369,0,0,1,140.658,143.926Z" transform="translate(-130.094 -130)"></path>
                                    </g>
                                </svg>
                            </a>
                        </li> --}}
                        {{-- <li class="shape-btn ">
                            <a class=" text-center notification" href="#" role="button">
                                <svg width="19.818" height="19.217" viewBox="0 0 19.818 19.217">
                                    <g id="XMLID_169_" transform="translate(0 -5)">
                                        <path id="XMLID_197_" d="M248.665,5.215A.9.9,0,0,0,247.5,6.587a8.1,8.1,0,0,1,2.855,6.176.9.9,0,1,0,1.8,0A9.9,9.9,0,0,0,248.665,5.215Z" transform="translate(-232.336)"></path>
                                        <path id="XMLID_221_" d="M4.657,6.587A.9.9,0,1,0,3.489,5.215,9.9,9.9,0,0,0,0,12.764a.9.9,0,0,0,1.8,0A8.1,8.1,0,0,1,4.657,6.587Z" transform="translate(0 -0.001)"></path>
                                        <path id="XMLID_222_" d="M54.113,20.615h-.3V12.764a6.315,6.315,0,0,0-5.4-6.241V5.9a.9.9,0,0,0-1.8,0v.621a6.315,6.315,0,0,0-5.4,6.241v7.851h-.3a.9.9,0,0,0,0,1.8h4.058a2.7,2.7,0,0,0,5.1,0h4.058a.9.9,0,1,0,0-1.8ZM43,12.764a4.5,4.5,0,0,1,9.008,0v7.851H43Z" transform="translate(-37.598 -0.001)"></path>
                                    </g>
                                </svg>
                                <div class="notification-bg"></div>
                            </a>
                        </li> --}}
                        <li class="nav-item shape-btn ">
                            <a class=" text-center notification" href="{{ url('/logout') }}" title='Logout' role="button">
                                <svg width="19.818" height="19.217" viewBox="0 0 20 20" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill="#555"
                                            d="M10.2392344,0 C13.3845587,0 16.2966635,1.39466883 18.2279685,3.74426305 C18.4595621,4.02601608 18.4134356,4.43777922 18.124942,4.66396176 C17.8364485,4.89014431 17.4148346,4.84509553 17.183241,4.5633425 C15.5035716,2.51988396 12.9739849,1.30841121 10.2392344,1.30841121 C5.32416443,1.30841121 1.33971292,5.19976806 1.33971292,10 C1.33971292,14.8002319 5.32416443,18.6915888 10.2392344,18.6915888 C13.0144533,18.6915888 15.5774656,17.443711 17.2546848,15.3485857 C17.4825482,15.0639465 17.9035339,15.0136047 18.1949827,15.2361442 C18.4864315,15.4586837 18.5379776,15.8698333 18.3101142,16.1544725 C16.3816305,18.5634688 13.4311435,20 10.2392344,20 C4.58426141,20 8.8817842e-14,15.5228475 8.8817842e-14,10 C8.8817842e-14,4.4771525 4.58426141,0 10.2392344,0 Z M17.0978642,7.15999289 L19.804493,9.86662172 C20.0660882,10.1282169 20.071043,10.5473918 19.8155599,10.802875 L17.17217,13.4462648 C16.9166868,13.701748 16.497512,13.6967932 16.2359168,13.435198 C15.9743215,13.1736028 15.9693667,12.7544279 16.2248499,12.4989447 L17.7715361,10.9515085 L7.46239261,10.9518011 C7.0924411,10.9518011 6.79253615,10.6589032 6.79253615,10.2975954 C6.79253615,9.93628766 7.0924411,9.64338984 7.46239261,9.64338984 L17.7305361,9.64250854 L16.1726778,8.08517933 C15.9110825,7.82358411 15.9061278,7.40440925 16.1616109,7.14892607 C16.4170941,6.89344289 16.836269,6.89839767 17.0978642,7.15999289 Z">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                @php
                    $lastSegment = substr(strrchr(request()->url(), '/'), 1);
                    $vertual_ward = ['one-to-one-care', 'frailty', 'amhat', 'diabetics-status','dementia-delirium','risk-of-falls','nutrition-risk','pressure-ulcer','amber-care-eol','sova-dols-ld', 'palliative-care'];
                @endphp
                @if (in_array(Route::currentRouteName(), ['user.favourites']) || (request()->has('favourites') && !in_array(Route::currentRouteName(), ['ed.home'])))


                    @include('Layouts.Common.Sidebar.FavouritesSidebarMobile')
                @elseif (request()->has('dtoc_favourites'))
                    @include('Layouts.Common.Sidebar.DischargeTrackerSidebarSubMobile')


                @elseif (in_array(Route::currentRouteName(), ['home']))
                    @include('Layouts.Common.Sidebar.ANESidebarMainMobile')

                @elseif ((Request::routeIs(['bed.status.flag'])) || ((Request::routeIs(['virtual.ward.summary']) && (in_array($lastSegment,$vertual_ward)))))
                    @include('Layouts.Common.Sidebar.CamisVirtualWardSidebarSubMobile')

                @elseif (in_array(Route::currentRouteName(), [
                        'red.bed.dashboard',
                        'pharmacy.dashboard',
                        'inpatients.siteoverview',
                        'global.patient.search',
                        'site.office','report.dashboard','reason_reside.dashboard','surgical.ward','doctor.at.night','mobility.score','virtual.ward.leaflet','site.stranded_patients','discharges_patient.dashboard','allowed_to_move.dashboard'
                    ]))
                    @include('Layouts.Common.Sidebar.FlowSidebarSubMobile')

                @elseif (Request::is('ane*'))
                    @include('Layouts.Common.Sidebar.ANESidebarSubMobile')

                @elseif (Request::routeIs('inpatients*') || Request::routeIs('bed.matrix') || Request::routeIs(['board_round.dashboard','site.pd_discharge','surgical.ward','doctor.at.night', 'ward.dashboard', 'wardtype.ward-performance']))
                    @include('Layouts.Common.Sidebar.CamisSidebarSubMobile')

                @elseif (Request::routeIs('infection*'))
                    @include('Layouts.Common.Sidebar.CamisInfectionControlSidebarSubMobile')

                @elseif (Request::routeIs(
                        'new.patient',
                        'reviewed.patient',
                        'removed.patient',
                        'patient.task.details',
                        'patient.search',
                          'DPSummaryMenu',
                        'patient.task.summary',
                        'patient.timeline'))
                    @include('Layouts.Common.Sidebar.DeterioratingPatientSidebarMobile')
{{--                @elseif (Request::routeIs([--}}
{{--                        'Theatre_summery',--}}
{{--                        'Live_statusTab',--}}
{{--                        'SergeryDemand',--}}
{{--                        'Cancellations',--}}
{{--                        'Performance',--}}
{{--                        'TheatreList',--}}
{{--                    ]))--}}
{{--                    @include('Layouts.Common.Sidebar.TheatreSidebarSubMobile')--}}
                @elseif (Request::routeIs('discharged*') || Request::routeIs('discharge.tracker*'))
                    @include('Layouts.Common.Sidebar.DischargeTrackerSidebarSubMobile')
                @elseif (Request::routeIs( 'discharge.lounge*'))
                    @include('Layouts.Common.Sidebar.DischargeLoungeSidebarSubMobile')

                @elseif (Request::routeIs([]))
                    @include('Layouts.Common.Sidebar.CamisOtherDashboardSidebarSubMobile')
                @else
                    @include('Layouts.Common.Sidebar.ANESidebarMainMobile')
                    {{--                    @include('Layouts.Common.Sidebar.ANESidebarSubMobile') --}}
                @endif
            </div>
        </nav>
    @endif
</div>
