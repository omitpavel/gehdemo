<div class="sidebar-menu d-none d-lg-block" id="sidebar-custom">
    <div class="sidebar-menu d-none d-lg-block" id="sidebar">


        <nav class="" id="navbar">
            <ul class="">
                <li class="nav-item cyan-border icon-next">
                    <a href="{{ url('/home') }}" class="nav-link ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="30px" height="30px"
                             viewBox="0 0 24 24" id="home-svg" data-name="Line Color" class="icon line-color">
                            <polygon id="primary"
                                     points="19 11 19 21 14 21 14 14 10 14 10 21 5 21 5 11 3 11 12 2 21 11 19 11"
                                     style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 1;">
                            </polygon>
                        </svg> <br>
                        <span class="home-text">Home</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858"
                             height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333"
                               transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>


                <div class="borderline"></div>
                <li  @if(PermitedStatus('theatres_live_status_')) class="nav-item cyan-border {{ Request::RouteIs('Live_statusTab') ? 'active' : '' }} icon-next" @else  class="nav-item cyan-border icon-next ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('theatres_live_status_') }}"  @endif >
                    <a @if(PermitedStatus('theatres_live_status_'))  href="{{ route('Live_statusTab') }}" class="nav-link {{ Request::RouteIs('Live_statusTab') ? 'active' : '' }}" @else class="nav-link" @endif >
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             fill="currentColor" version="1.1" id="Capa_1" width="23" height="22"
                             viewBox="0 0 300 374.846" xml:space="preserve" class="relative-svg">
                                    <g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M326.147,267.326c4.168-6.754,12.875-9.094,19.869-5.336l5.83,3.135c3.635,1.955,6.305,5.32,7.379,9.305     c1.076,3.984,0.461,8.236-1.695,11.754c-8.301,13.519-18.295,25.941-29.709,36.923c-2.805,2.692-6.531,4.188-10.397,4.188     c-0.242,0-0.482-0.006-0.726-0.018c-4.123-0.199-7.981-2.09-10.668-5.227l-4.309-5.025c-5.164-6.025-4.74-15.031,0.967-20.547     C311.678,287.793,319.573,277.984,326.147,267.326z" />
                                                <path
                                                    d="M208.809,338.262c12.505-0.903,24.873-3.344,36.77-7.252c7.529-2.475,15.685,1.334,18.617,8.695l2.451,6.153     c1.529,3.839,1.408,8.138-0.334,11.884c-1.74,3.746-4.953,6.604-8.873,7.907c-8.094,2.687-16.451,4.843-24.848,6.407     c-7.112,1.328-14.377,2.254-21.592,2.754c-0.349,0.023-0.693,0.035-1.037,0.035c-3.759,0-7.396-1.412-10.175-3.979     c-3.034-2.802-4.78-6.73-4.823-10.859l-0.071-6.625C194.809,345.459,200.906,338.834,208.809,338.262z" />
                                                <path
                                                    d="M89.693,312.596c5.039-6.135,13.984-7.276,20.404-2.612c10.135,7.36,21.16,13.435,32.773,18.053     c7.373,2.933,11.188,11.101,8.701,18.636l-2.072,6.287c-1.293,3.92-4.145,7.135-7.883,8.887     c-2.012,0.941-4.186,1.416-6.361,1.416c-1.867,0-3.738-0.35-5.512-1.049c-14.73-5.818-28.695-13.51-41.508-22.863     c-3.332-2.434-5.516-6.133-6.037-10.227c-0.52-4.097,0.672-8.224,3.291-11.41L89.693,312.596z" />
                                                <path
                                                    d="M28.699,214.609l6.508-1.216c7.82-1.454,15.414,3.438,17.314,11.156c3.029,12.289,7.592,24.129,13.561,35.191     c3.766,6.979,1.449,15.686-5.289,19.867l-5.625,3.491c-2.398,1.487-5.141,2.257-7.912,2.257c-1.285,0-2.576-0.164-3.842-0.5     c-3.992-1.061-7.371-3.716-9.342-7.348c-7.602-14.012-13.387-29.016-17.193-44.598c-0.979-4.005-0.266-8.234,1.971-11.697     C21.087,217.753,24.648,215.365,28.699,214.609z" />
                                                <path
                                                    d="M36.849,170.858h-6.727c-0.006,0-0.014,0-0.02,0c-8.287,0-15-6.715-15-15c0-1.219,0.143-2.404,0.418-3.539     c5.584-29.84,18.643-58.24,37.801-82.188C82.325,33.873,123.52,9.826,169.319,2.416C179.227,0.814,189.325,0,199.333,0     c25.752,0,51.313,5.385,74.813,15.67l11.687-11.688c2.413-2.412,5.909-3.389,9.225-2.574c3.313,0.812,5.961,3.299,6.981,6.555     l24.191,77.16c1.086,3.465,0.158,7.248-2.41,9.816c-2.567,2.568-6.35,3.496-9.815,2.41l-77.16-24.191     c-3.256-1.02-5.739-3.668-6.556-6.982c-0.813-3.312,0.162-6.811,2.576-9.223l13.013-13.014     c-15.021-4.963-30.656-7.473-46.685-7.473c-45.797,0-88.547,20.604-117.287,56.531c-15.309,19.135-25.793,41.84-30.322,65.662     C50.24,165.737,44.052,170.858,36.849,170.858z" />
                                            </g>
                                        </g>
                                    </g>
                                </svg> <br>
                        <span class=" " style="font-size: 12px;">Live Patient<br> Status <br></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858"
                             height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333"
                               transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li  @if(PermitedStatus('theatres_live_status_details_view')) class="nav-item cyan-border {{ Request::RouteIs('Live_status_details_Tab') ? 'active' : '' }} icon-next" @else  class="nav-item cyan-border icon-next ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('theatres_live_status_details_view') }}"  @endif >
                    <a @if(PermitedStatus('theatres_live_status_details_view'))  href="{{ route('Live_status_details_Tab') }}" class="nav-link {{ Request::RouteIs('Live_status_details_Tab') ? 'active' : '' }}" @else class="nav-link" @endif>

                        <svg height="23" width="22" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="currentColor" class="relative-svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path class="st0" d="M268.149,12.153c-7.179,0-14.309,0.309-21.374,0.926l4.905,56.561h0.016 c5.392-0.462,10.882-0.698,16.453-0.698c51.745,0.016,98.326,20.886,132.272,54.782c33.896,33.954,54.783,80.534,54.783,132.28 c0,51.745-20.887,98.326-54.783,132.271c-33.945,33.896-80.526,54.767-132.272,54.783c-51.746-0.016-98.326-20.886-132.272-54.783 c-18.239-18.264-32.532-40.279-42.017-64.699l31.102-4.376L44.729,201.952l-17.93,54.052h-2.485c0,2.192,0.26,4.32,0.325,6.505 L0,336.765l36.414-5.116c31.85,97.611,123.485,168.189,231.735,168.197C402.84,499.839,511.984,390.688,512,256.004 C511.984,121.313,402.84,12.161,268.149,12.153z">
                                    </path>
                                    <path class="st0" d="M113.041,151.425c3.054-4.532,6.335-8.941,9.794-13.237l-44.144-35.707 c-4.466,5.522-8.722,11.23-12.717,17.167l47.052,31.777H113.041z">
                                    </path>
                                    <path class="st0" d="M193.762,84.314c9.079-3.938,18.532-7.17,28.292-9.648L208.12,19.607c-12.766,3.232-25.11,7.472-36.966,12.62 l22.609,52.078V84.314z">
                                    </path>
                                    <path class="st0" d="M167.353,98.412l-30.664-47.807c-10.996,7.041-21.374,14.95-31.054,23.615l37.86,42.318 C150.933,109.887,158.908,103.812,167.353,98.412z">
                                    </path>
                                </g>
                            </g>
                                </svg>
                        <br>
                        <span class=" ">Live Patient<br> Details <br></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858" height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333" transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238" d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z" transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239" d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z" transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(PermitedStatus('theatres_surgery_demand_view')) class="nav-item cyan-border {{ Request::RouteIs('SergeryDemand') ? 'active' : '' }} icon-next" @else  class="nav-item cyan-border icon-next ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('theatres_surgery_demand_view') }}"  @endif  >
                    <a @if(PermitedStatus('theatres_surgery_demand_view'))  href="{{ route('SergeryDemand') }}" class="nav-link {{ Request::RouteIs('SergeryDemand') ? 'active' : '' }}" @else class="nav-link" @endif >
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="22" viewBox="0 0 24 28.546"
                             class="relative-svg">
                            <path id="surgical-scissors-svgrepo-com"
                                  d="M26.658,6.771a2.872,2.872,0,0,0-4.043-.019h0L13.349,14.99l.74-2.612,6.66-7.49v0a2.873,2.873,0,1,0-2.052.862c.035,0,.069,0,.1,0L.113,26.762a.443.443,0,0,0,.625.626L21.758,8.7c0,.035,0,.069,0,.1a2.874,2.874,0,1,0,4.906-2.032ZM17.292,4.28a1.989,1.989,0,1,1,1.406.582A1.991,1.991,0,0,1,17.292,4.28Zm-3.88,8.858-.679,2.4L5.792,21.708Zm12.62-2.929A1.987,1.987,0,1,1,26.614,8.8,1.975,1.975,0,0,1,26.032,10.209Z"
                                  transform="translate(0.547 0.5)" fill="#00b2b5" stroke="currentColor"
                                  stroke-width="1" />
                        </svg> <br>
                        <span class=" " style="font-size: 12px;">Surgery <br> Demand <br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858"
                             height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333"
                               transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(PermitedStatus('theatres_performance_view')) class="nav-item cyan-border {{ Request::RouteIs('Performance') ? 'active' : '' }} icon-next" @else  class="nav-item cyan-border icon-next ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('theatres_performance_view') }}"  @endif >
                    <a @if(PermitedStatus('theatres_performance_view'))  href="{{ route('Performance') }}" class="nav-link {{ Request::RouteIs('Performance') ? 'active' : '' }}" @else class="nav-link" @endif >
                        <svg width="30" height="28" viewBox="-5 0 58 38" fill="#FFFFFF"
                             xmlns="http://www.w3.org/2000/svg" class="relative-svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                                <rect width="48" height="58" fill="white" fill-opacity="0.01"></rect>
                                <path
                                    d="M34.0234 6.68921C31.0764 4.97912 27.6525 4 24 4C12.9543 4 4 12.9543 4 24C4 35.0457 12.9543 44 24 44C35.0457 44 44 35.0457 44 24C44 20.3727 43.0344 16.9709 41.3461 14.0377"
                                    stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M31.9498 16.0502C31.9498 16.0502 28.5621 25.0947 27.0001 26.6568C25.438 28.2189 22.9053 28.2189 21.3432 26.6568C19.7811 25.0947 19.7811 22.562 21.3432 20.9999C22.9053 19.4378 31.9498 16.0502 31.9498 16.0502Z"
                                    fill="#currentColor" stroke="currentColor" stroke-width="4"
                                    stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>
                        <span class=" " style="font-size: 12px;" >Performance <br> <br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858"
                             height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333"
                               transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
                <li @if(PermitedStatus('theatres_cancellations_')) class="nav-item cyan-border {{ Request::RouteIs('Cancellations') ? 'active' : '' }} icon-next" @else  class="nav-item cyan-border icon-next ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('theatres_cancellations_') }}"  @endif >
                    <a  @if(PermitedStatus('theatres_cancellations_'))  href="{{ route('Cancellations') }}" class="nav-link {{ Request::RouteIs('Cancellations') ? 'active' : '' }}" @else class="nav-link" @endif  >
                        <svg width="27" height="24" viewBox="0 0 28 32" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" class="relative-svg" fill="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M16 0c-8.836 0-16 7.163-16 16s7.163 16 16 16c8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 30.032c-7.72 0-14-6.312-14-14.032s6.28-14 14-14 14 6.28 14 14-6.28 14.032-14 14.032zM21.657 10.344c-0.39-0.39-1.023-0.39-1.414 0l-4.242 4.242-4.242-4.242c-0.39-0.39-1.024-0.39-1.415 0s-0.39 1.024 0 1.414l4.242 4.242-4.242 4.242c-0.39 0.39-0.39 1.024 0 1.414s1.024 0.39 1.415 0l4.242-4.242 4.242 4.242c0.39 0.39 1.023 0.39 1.414 0s0.39-1.024 0-1.414l-4.242-4.242 4.242-4.242c0.391-0.391 0.391-1.024 0-1.414z">
                                </path>
                            </g>
                        </svg>
                        <br>
                        <span class=" " style="font-size: 12px;" >Cancellations <br> <br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858"
                             height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333"
                               transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>

                <div class="borderline"></div>
                <li  @if(PermitedStatus('theatres_list_view')) class="nav-item cyan-border {{ Request::RouteIs('TheatreList') ? 'active' : '' }} icon-next" @else  class="nav-item cyan-border icon-next ibox-side-menu-disabled-icon {{ PermissionDeniedDiv('theatres_list_view') }}"  @endif>
                    <a  @if(PermitedStatus('theatres_list_view'))  href="{{ route('TheatreList') }}" class="nav-link {{ Request::RouteIs('TheatreList') ? 'active' : '' }}" @else class="nav-link" @endif >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22"
                             viewBox="0 0 25.696 28.385" class="relative-svg">
                            <g id="style_linear" data-name="style=linear" transform="translate(-2.25 -1.25)">
                                <g id="document" transform="translate(3 2)">
                                    <path id="rec"
                                          d="M3,8.721A6.721,6.721,0,0,1,9.721,2H20.475A6.721,6.721,0,0,1,27.2,8.721V22.164a6.721,6.721,0,0,1-6.721,6.721H9.721A6.721,6.721,0,0,1,3,22.164Z"
                                          transform="translate(-3 -2)" fill="none" stroke="currentColor"
                                          stroke-width="1.5" />
                                    <path id="line" d="M8,8.2H18.754" transform="translate(-1.279 0.134)"
                                          fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="1.5" />
                                    <path id="line_2" d="M8,12.2H18.754" transform="translate(-1.279 1.511)"
                                          fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="1.5" />
                                    <path id="line_3" d="M9,16.2h8.065" transform="translate(-0.935 2.888)"
                                          fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="1.5" />
                                </g>
                            </g>
                        </svg>
                        <br>
                        <span class="" style="font-size: 12px;" >Theatre Selection <br> </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="12.858"
                             height="14.128" viewBox="0 0 12.858 14.128">
                            <g id="next-svg" data-name="Group 333"
                               transform="translate(13.832 -0.972) rotate(90)">
                                <path id="Path_19238" data-name="Path 19238"
                                      d="M6.982,0h.162A1.108,1.108,0,0,1,7.93.326L13.8,6.2a1.11,1.11,0,0,1-1.568,1.571L7.065,2.6,1.893,7.768A1.11,1.11,0,0,1,.324,6.2L6.2.326A1.117,1.117,0,0,1,6.982,0Z"
                                      transform="translate(0.972 5.738)"></path>
                                <path id="Path_19239" data-name="Path 19239"
                                      d="M6.982,0h.162A1.113,1.113,0,0,1,7.93.324L13.8,6.2a1.11,1.11,0,0,1-1.568,1.572L7.065,2.6,1.893,7.769A1.111,1.111,0,0,1,.324,6.2L6.2.324A1.123,1.123,0,0,1,6.982,0Z"
                                      transform="translate(0.972 0.973)"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <div class="borderline"></div>
            </ul>
        </nav>


    </div>
</div>
