@extends('Layouts.Common.MasterLayout')
@section('page-title', 'A&E Home')
@section('page-top-title', 'A&E')
@section('page-top-title-sub', date('jS F H:i'))
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/AeHome.css') }}" crossorigin="anonymous" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="col-lg-12  ">

            <div class="wrapper-ae">
                <div @if(CheckSpecificPermission('live_status_view')) class="hexagon-live" @else class="hexagon-live ibox-side-menu-disabled-icon"  @endif>
                    <div class="content-live d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-red.svg') }}" alt="">
                        <span>A real-time view of the Emergency Department</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckSpecificPermission('live_status_view')) href="{{ url('/ane/dashboards/accident-and-emergency') }}" @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-red.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/status-live.svg') }}" alt="">
                                            <span class="text-live">LIVE</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">LIVE STATUS</span>
                        </a>
                    </div>
                    <div class="custom-hexagon-1 d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-fill-lg.svg') }}" alt="">
                    </div>
                    <div class="content-sm-shape-1 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-red.svg') }}" alt="">
                        <div>
                            <span>A real-time view of the Emergency Department</span>
                        </div>

                    </div>
                    <div class="sm-hexagon-1 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>
                    <div class="sm-hexagon-2 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>
                </div>
                <div @if(CheckDashboardPermission('breach_')) class="hexagon-breach" @else class="hexagon-breach ibox-side-menu-disabled-icon"  @endif>
                    <div class="content-breach d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-blue.svg') }}" alt="">
                        <span>A list of all the 4 hour breaches that are required to be validated</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckDashboardPermission('breach_')) href="{{ url('/ane/dashboards/breach-validation') }}" @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-blue.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/breach.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">BREACH <br> VALIDATION TOOL</span>
                        </a>
                        <div class="custom-hexagon-6 d-none d-lg-block">
                            <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-fill-lg.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="content-sm-shape-2 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-blue.svg') }}" alt="">
                        <div>
                            <span>A list of all the 4 hour breaches that are required to be validated</span>
                        </div>

                    </div>
                    <div class="sm-hexagon-3 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>
                    <div class="sm-hexagon-4 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/xs-hexagon.svg') }}" alt="">
                    </div>
                    <div class="sm-hexagon-5 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>
                    <div class="sm-hexagon-6 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/xs-hexagon.svg') }}" alt="">
                    </div>
                </div>
                <div @if(CheckDashboardPermission('activity_profile_view')) class="hexagon-activity" @else class="hexagon-activity ibox-mouse-pointer ibox-side-menu-disabled-icon"  @endif>
                    <div class="content-activity d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-cyan.svg') }}" alt="">
                        <span>A hour-by-hour deep-dive analysis of the Emergency Department</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckDashboardPermission('activity_profile_view')) href="{{ url('/ane/dashboards/activity-profile') }}"  @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-cyan.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/activity.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">ACTIVITY <br> PROFILE</span>
                        </a>
                        <div class="custom-hexagon-2 d-none d-lg-block">
                            <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-fill-lg.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="content-sm-shape-3 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-cyan.svg') }}" alt="">
                        <div>
                            <span>A hour-by-hour deep-dive analysis of the Emergency Department</span>
                        </div>
                    </div>
                </div>

                <div @if(CheckDashboardPermission('flow_dashboard_shankey_view')) class="hexagon-sankey"  @else class="hexagon-sankey ibox-side-menu-disabled-icon"  @endif>
                    <div class="content-sankey d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-darkblue.svg') }}" alt="">
                        <span>A sankey view of A&E activity flowing from arrival to departure</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckDashboardPermission('flow_dashboard_shankey_view')) href="{{ url('/ane/dashboards/sankey-charts') }}" @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-purple.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/sankey.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">SANKEY <br> DASHBOARD</span>
                        </a>
                    </div>
                    <div class="content-sm-shape-5 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-purple.svg') }}" alt="">
                        <div>
                            <span>A sankey view of A&E activity flowing from arrival to departure</span>
                        </div>
                    </div>
                    <div class="sm-hexagon-9 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/xs-hexagon.svg') }}" alt="">
                    </div>

                </div>
                <div @if(CheckDashboardPermission('ed_')) class="hexagon-ed" @else class="hexagon-ed ibox-side-menu-disabled-icon"  @endif>
                    <div class="content-ed d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-maroon.svg') }}" alt="">
                        <span>Provide a core set of metrics to show the demands across the different
                            areas
                            of the Emergency Department</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckDashboardPermission('ed_')) href="{{ url('/ane/dashboards/ed-overview') }}" @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-maroon.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/hospital.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">ED <br> OVERVIEW</span>
                        </a>
                    </div>
                    <div class="content-sm-shape-6 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-maroon.svg') }}" alt="">
                        <div>
                            <span>Provide a core set of metrics to show the demands across the different
                                areas of the Emergency Department</span>
                        </div>
                    </div>
                    <div class="sm-hexagon-10 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>
                    <div class="sm-hexagon-11 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/xs-hexagon.svg') }}" alt="">
                    </div>


                </div>

                <div @if(CheckDashboardPermission('ambulance_dashboard')) class="hexagon-ambulance" @else class="hexagon-ambulance ibox-side-menu-disabled-icon"  @endif>
                    <div class="content-ambulance d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-coral.svg') }}" alt="">
                        <span>A view of all the arrivals into the Emergency Department with an Arrival
                            Mode
                            of 'Ambulance</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckDashboardPermission('ambulance_dashboard')) href="{{ url('/ane/dashboards/ambulance-arrivals') }}"  @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-coral.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/ambulance.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">AMBULANCE <br> ANALYTICS</span>
                        </a>
                    </div>
                    <div class="content-sm-shape-7 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-orange.svg') }}" alt="">
                        <div>
                            <span>A view of all the arrivals into the Emergency Department with an
                                Arrival
                                Mode of 'Ambulance</span>
                        </div>

                    </div>
                    <div class="sm-hexagon-12 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>
                    <div class="sm-hexagon-13 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/xs-hexagon.svg') }}" alt="">
                    </div>


                </div>


                <div @if(CheckDashboardPermission('referral_to_speciality')) class="hexagon-opel" @else class="hexagon-opel ibox-side-menu-disabled-icon"  @endif>
                    <div class="content-opel d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-orange.svg') }}" alt="">
                        <span>A view of time taken from Referrals to Specialty Consultant seeing the patient
                            in ED.</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckDashboardPermission('referral_to_speciality')) href='/ane/dashboards/referral-to-speciality' @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-orange.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/refferal.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">SPECIALTY <br>REFERRAL</span>
                        </a>
                    </div>
                    <div class="custom-hexagon-3 d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-fill-lg.svg') }}" alt="">
                    </div>
                    <div class="content-sm-shape-8 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-pink.svg') }}" alt="">
                        <div>
                            <span>A view of time taken from Referrals to Specialty Consultant seeing the
                                patient in ED.</span>
                        </div>
                    </div>
                    <div class="sm-hexagon-14 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>





                </div>
                <div @if(CheckDashboardPermission('ane_welcome_screen_view')) class="hexagon-welcome"  @else class="hexagon-welcome ibox-side-menu-disabled-icon" @endif>
                    <div class="content-welcome d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-content-green.svg') }}" alt="">
                        <span>A patient facing view with metrics regarding estimated wait times</span>
                    </div>
                    <div class="icons-wrap">
                        <a @if(CheckDashboardPermission('ane_welcome_screen_view')) href="{{ url('/ane/dashboards/ed-home') }}" @else onclick="CommonLoginModalPopupOpenOnRequest();" href="#" @endif>
                            <div class="hexagon-bg">
                                <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-bg.svg') }}" alt="">
                                <div class="hexagon-gradient">
                                    <img src="{{ asset('asset_v2/Template/icons/a&e/gradient-green.svg') }}" alt="">
                                    <div class="hexagon-inner">
                                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-inner.svg') }}" alt="">
                                        <div class="icon-status">
                                            <img src="{{ asset('asset_v2/Template/icons/a&e/welcome.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="dashboard-name">WELCOME <br> SCREEN</span>
                        </a>
                    </div>
                    <div class="custom-hexagon-4 d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-fill-sm.svg') }}" alt="">
                    </div>
                    <div class="custom-hexagon-5 d-none d-lg-block">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/hexagon-fill-lg.svg') }}" alt="">
                    </div>
                    <div class="content-sm-shape-4 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/pin-hexagon-sm-green.svg') }}" alt="">
                        <div>
                            <span>A patient facing view with metrics regarding estimated wait times</span>
                        </div>

                    </div>
                    <div class="sm-hexagon-7 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/xs-hexagon.svg') }}" alt="">
                    </div>
                    <div class="sm-hexagon-8 d-lg-none">
                        <img src="{{ asset('asset_v2/Template/icons/a&e/sm-hexagon.svg') }}" alt="">
                    </div>
                    <div class="header-ae-mobile d-lg-none">
                        <h1 class="">A&amp;E</h1>
                    </div>


                </div>
                <div class="header-ae d-none d-lg-block">
                    <h1 class="">A&amp;E</h1>
                </div>





            </div>

        </div>
    </div>
@endsection
