@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Home')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Home.css') }}" crossorigin="anonymous" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="col-lg-12  ">

            <div class="home-wrapper ">
                <div class="row gx-2 align-items-center">
                    <div class="col-12">
                        <div class="logo-header">
                            <div class="row gx-2 align-items-center">
                                <div class="col-lg-1 text-center text-lg-start">
                                    <img src="{{ asset('asset_v2/Template/images/Logo.svg') }}" alt="" width="70" class="img-fluid">
                                </div>
                                <div class="col-lg-11">

                                    <h6>Transforming healthcare with user-friendly, <br>
                                        award
                                        winning
                                        technology.</h6>
                                </div>
                            </div>
                        </div>

                        <div class="row row-cols-lg-6 row-cols-1 gx-lg-4 align-items-center">



                            <div class="col @if(CheckDashboardPermission('flow_dashboard_') || CheckDashboardPermission('pharmacy_dashboard_view') || CheckDashboardPermission('doctor_at_night_dashboard_view') || CheckDashboardPermission('leaflet_dashboard_view') || CheckDashboardPermission('stranded_dashboard') || CheckDashboardPermission('r_to_r_view_') || CheckDashboardPermission('surgical_wards_dashboard_view') || CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')  || CheckDashboardPermission('site_office_report_view')) menu-enabled @else menu-disabled @endif">
                                <div class="card-box-1"
                                @if(CheckDashboardPermission('flow_dashboard_') || CheckDashboardPermission('pharmacy_dashboard_view') || CheckDashboardPermission('doctor_at_night_dashboard_view') || CheckDashboardPermission('leaflet_dashboard_view') || CheckDashboardPermission('stranded_dashboard') || CheckDashboardPermission('r_to_r_view_') || CheckDashboardPermission('surgical_wards_dashboard_view') || CheckDashboardPermission('discharged_patient_is_view_dashbaord_view')  || CheckDashboardPermission('site_office_report_view')) onclick="window.location.href = '{{ route('inpatients.siteoverview') }}'"  @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                                    <div class="icon-bg-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="30"
                                            viewBox="0 0 33 35" fill="currentColor">
                                            <g id="Group_2949" data-name="Group 2949"
                                                transform="translate(-179 -155.075)">
                                                <path id="Path_22097" data-name="Path 22097"
                                                    d="M29.384,23.687V17.646a2.351,2.351,0,0,0-2.351-2.351h-9.4V9.254a4.7,4.7,0,1,0-2.351,0v6.041h-9.4a2.351,2.351,0,0,0-2.351,2.351v6.041a4.7,4.7,0,1,0,2.351,0V17.646H27.033v6.041a4.7,4.7,0,1,0,2.351,0ZM7.052,28.224A2.351,2.351,0,1,1,4.7,25.873,2.351,2.351,0,0,1,7.052,28.224ZM14.1,4.717a2.351,2.351,0,1,1,2.351,2.351A2.351,2.351,0,0,1,14.1,4.717Zm14.1,25.858a2.351,2.351,0,1,1,2.351-2.351A2.351,2.351,0,0,1,28.208,30.574Z"
                                                    transform="translate(179 155.075)"></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="sl-no">01</h3>
                                        <h6 class="name">FLOW <br>&nbsp;</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col @if(!CheckAnyPermissionWildcard(['live_status_view', 'activity_profile_view', 'referral_to_speciality*', 'ambulance_dashboard*', 'ed_live_summary_view', 'ed_day_summary_view', 'breach_*','flow_dashboard_shankey_view', 'ane_welcome_screen_view'])) menu-disabled @endif">
                                <div class="card-box-2" @if(CheckAnyPermissionWildcard(['live_status_view', 'activity_profile_view', 'referral_to_speciality*', 'ambulance_dashboard*', 'ed_live_summary_view', 'ed_day_summary_view', 'breach_*','flow_dashboard_shankey_view', 'ane_welcome_screen_view'])) onclick="window.location.href = '{{ route('ane_home') }}'"  @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                                    <div class="icon-bg-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30.73" height="30.73"
                                            viewBox="0 0 30.73 30.73">
                                            <g id="hospital-svgrepo-com" transform="translate(0 0)">
                                                <g id="Group_2075" data-name="Group 2075"
                                                    transform="translate(0 0)">
                                                    <path id="Path_21009" data-name="Path 21009"
                                                        d="M22.165,0H8.565A8.6,8.6,0,0,0,0,8.565v13.6A8.6,8.6,0,0,0,8.565,30.73h13.6a8.6,8.6,0,0,0,8.565-8.565V8.565A8.6,8.6,0,0,0,22.165,0Zm6.014,22.165a6,6,0,0,1-6.014,6.014H8.565a6,6,0,0,1-6.014-6.014V8.565A6,6,0,0,1,8.565,2.551h13.6a6,6,0,0,1,6.014,6.014v13.6Z"
                                                        fill="" />
                                                    <path id="Path_21010" data-name="Path 21010"
                                                        d="M126.922,118.457h-5.75v-5.75a1.307,1.307,0,1,0-2.614,0v5.75h-5.75a1.307,1.307,0,0,0,0,2.614h5.75v5.75a1.307,1.307,0,0,0,2.614,0v-5.75h5.75a1.307,1.307,0,0,0,0-2.614Z"
                                                        transform="translate(-104.493 -104.399)" fill="" />
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="sl-no">02</h3>
                                        <h6 class="name">A&E <br>&nbsp;</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col @if(!CheckAnyPermissionWildcard(['camis*', 'virtual_ward*', 'pd_dashboard*', 'board_round_dashboard*', 'infection_control*', 'discharge_lounge*']))  menu-disabled @endif">
                                <div class="card-box-3" @if(CheckAnyPermissionWildcard(['camis*', 'virtual_ward*', 'pd_dashboard*', 'board_round_dashboard*', 'infection_control*', 'discharge_lounge*'])) onclick="window.location.href = '{{ route('ward.dashboard') }}'"  @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                                    <div class="icon-bg-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Group_2941"
                                            data-name="Group 2941" width="51.824" height="31.852"
                                            viewBox="0 0 51.824 31.852">
                                            <path id="Path_20625" data-name="Path 20625"
                                                d="M19.969,2652.526v1.513H34.635v-1.513H19.969Zm15.964,0v1.513h4.409A3.477,3.477,0,0,1,44,2657.691v3.135a3.086,3.086,0,1,1-1.449-.012h0v-3.138a2.009,2.009,0,0,0-1.941-2.128H35.933v1.587h3.734a.814.814,0,0,1,.812.812h0a.814.814,0,0,1-.812.812H30.9a.814.814,0,0,1-.812-.812h0a.814.814,0,0,1,.812-.812h3.734v-1.587H19.969v3.7h4.708a.814.814,0,0,1,.812.812h0a.814.814,0,0,1-.812.812H13.827a.814.814,0,0,1-.812-.812h0a.814.814,0,0,1,.812-.812h4.843v-3.7H11.5c-1.16.256-2.055.769-2.1,2.1v3.222a3.087,3.087,0,1,1-1.65.037V2657.9c-.011-2.339,1.316-3.492,3.529-3.859h7.4v-1.513H2c-3.175-.834-2.114-4.649,0-4.683h9.366a.788.788,0,0,1,.034,1.53H2.209a.793.793,0,0,0,0,1.562l46.021-.022c3.486-.9,1.669-4.76,0-4.617l-29.676-.021a4.579,4.579,0,0,1-3.45-1.4l-8.021-8.031c-.591-.577-1.548.367-1.157,1l8.2,8.322a6.874,6.874,0,0,0,5.307,1.64h28.7a.79.79,0,0,1,0,1.511H17.895c-1.962.139-3.665-.9-5.256-2.454l-8.115-8.3c-1.114-2.423,2.058-4.608,3.624-2.786l7.793,7.726c1.49,1.279,1.864,1.083,4.057,1.141H48.56c3.457.694,5.147,6.252,0,7.884H35.934Zm7.313,9.726a1.569,1.569,0,1,1-1.569,1.569A1.569,1.569,0,0,1,43.247,2662.251Zm-34.612.044a1.569,1.569,0,1,1-1.569,1.569A1.569,1.569,0,0,1,8.635,2662.3Z"
                                                transform="translate(0.007 -2635.099)" fill=""
                                                fill-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="sl-no">03</h3>
                                        <h6 class="name">INPATIENTS <br>WARDS</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col @if(!CheckDashboardPermission('dp_dashboard')) menu-disabled @endif ">
                                <div class="card-box-4"
                                @if(CheckDashboardPermission('dp_dashboard')) onclick="window.location.href = '{{ route('new.patient') }}'"  @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                                    <div class="icon-bg-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36.36"
                                            height="27.276" viewBox="0 0 36.36 27.276">
                                            <path id="Union_141" data-name="Union 141"
                                                d="M27.382,27.275H20.833l-2.06-6.4,2.993-9.259,2.367,7.635L30.2,0H36.36L27.383,27.276Zm-18.6,0L0,0H6.113l5.968,19.254L18.146,0h6.163L15.332,27.276ZM14.4,7.285,12.052,0h4.717L14.4,7.285v0Z"
                                                fill="" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="sl-no">04</h3>
                                        <h6 class="name">DETERIORATING <br> PATIENT</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col @if(!CheckAnyPermissionWildcard($dtoc_permission)) menu-disabled @endif">
                                <div class="card-box-5"
                                @if(CheckAnyPermissionWildcard($dtoc_permission)) onclick="window.location.href = '{{ $dtoc_redirect_url }}'" @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>
                                    <div class="icon-bg-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_x0020_1"
                                            width="33.572" height="32.991" viewBox="0 0 33.572 32.991">
                                            <path id="Path_20620" data-name="Path 20620"
                                                d="M2.491-.031H22.5a2.5,2.5,0,0,1,2.49,2.49V4.684H23.548V2.8A1.423,1.423,0,0,0,22.129,1.38H2.866A1.423,1.423,0,0,0,1.447,2.8V30.13a1.423,1.423,0,0,0,1.419,1.419H22.129a1.423,1.423,0,0,0,1.419-1.419V17h1.446V30.469a2.5,2.5,0,0,1-2.49,2.49H2.491A2.5,2.5,0,0,1,0,30.469V2.46a2.5,2.5,0,0,1,2.49-2.49ZM20.1,10.287,29.4,3.48c2.507-1.836,6.018,1.966,3.031,4.154l-9.294,6.807c-2.7,1.975-5.835-2.1-3.031-4.154Zm.779.835,9.019-6.5c1.464-1.056,3.388,1.165,1.718,2.354L22.88,13.194c-1.982,1.412-3.412-1.054-2-2.073Zm-2.973-.087c-.01,3.925.108,3.91,3.881,5.355l-7.026.935,3.145-6.29Zm-.554,4.058.458.539-.931.171Zm-12.89,12.3V26.013H21.191v1.379Zm0-3.839V22.174H21.191v1.379Zm0-3.931V18.243H21.234v1.379Zm0-3.7V14.54h7.961V15.92Zm.233-7.7V6.839H7.061V4.474H8.44V6.839h2.365V8.218H8.44v2.365H7.061V8.218Z"
                                                transform="translate(0 0.031)" fill=""
                                                fill-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="sl-no">05</h3>
                                        <h6 class="name">DISCHARGE <br> TRACKER</h6>
                                    </div>
                                </div>
                            </div>


                            {{--<div class="col @if(!CheckDashboardPermission('dp_dashboard')) menu-disabled @endif">
                                <div class="card-box-3"
                                @if(CheckDashboardPermission('dp_dashboard')) onclick="window.location.href = '{{ route('new.patient') }}'"  @else onclick="CommonLoginModalPopupOpenOnRequest();" @endif>--}}



                            <div class="col @if(session()->get('AD_LOGIN') != 1) menu-disabled @endif">
                                <div class="card-box-6 " @if(session()->get('AD_LOGIN') == 1)  onclick="window.location.href = '{{ $redirect_url }}'" @endif>
                                    <div class="icon-bg-circle">
                                        <svg fill="#3C486A" height="30" width="30" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490.706 490.706" xml:space="preserve">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <g>
                                                        <path d="M490.133,178.037c-1.493-4.373-5.547-7.253-10.133-7.36H309.653l-54.187-163.2c-1.813-5.547-7.893-8.64-13.44-6.827 c-3.2,1.067-5.76,3.627-6.827,6.827l-54.187,164.267H10.667C4.8,170.784,0,175.477,0,181.45c0,3.307,1.493,6.4,4.16,8.427 l136.96,107.2L81.493,476.49c-1.92,5.547,1.067,11.627,6.72,13.547c3.307,1.067,6.933,0.533,9.707-1.493l147.52-107.52 L392.96,486.09c4.8,3.413,11.413,2.347,14.827-2.453c1.92-2.773,2.453-6.293,1.493-9.493L350.187,292.81L486.4,189.984 C490.133,187.21,491.627,182.41,490.133,178.037z M331.307,280.224c-3.627,2.773-5.12,7.467-3.733,11.84l51.413,157.76 l-127.36-90.773c-3.733-2.667-8.747-2.667-12.48,0.107l-126.827,92.48l51.413-154.88c1.387-4.267,0-8.96-3.52-11.733L41.6,192.01 h147.093c4.587,0,8.64-2.987,10.133-7.36l46.507-140.16l46.507,140.16c1.493,4.373,5.547,7.253,10.133,7.36h146.133 L331.307,280.224z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="sl-no">06</h3>
                                        <h6 class="name">FAVOURITES <br>&nbsp;</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="row gx-2 align-items-center">
                        <div class="col-lg-9 mb-2">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-3 text-lg-end text-center mb-2">
                            <h6>© {{ date('Y') }} · iboxhealthcare.co.uk</h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
