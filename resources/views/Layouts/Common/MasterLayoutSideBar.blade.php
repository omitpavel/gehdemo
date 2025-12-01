@if (!in_array(Route::currentRouteName(), ['ed.performance', 'ed.home']))
{{--@push('template-style')--}}
{{--    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Sidebar.css') }}" crossorigin="anonymous">--}}
{{--@endpush--}}

    @php
        $lastSegment = substr(strrchr(request()->url(), '/'), 1);
        $vertual_ward = ['one-to-one-care', 'frailty', 'amhat', 'diabetics-status','dementia-delirium','risk-of-falls','nutrition-risk','pressure-ulcer','amber-care-eol','sova-dols-ld', 'palliative-care'];
    @endphp

    @if (in_array(Route::currentRouteName(), ['user.favourites']) || (request()->has('favourites') && !in_array(Route::currentRouteName(), ['ed.home'])))


        @include('Layouts.Common.Sidebar.FavouritesSidebar')
    @elseif(request()->has('dtoc_favourites'))


        @include('Layouts.Common.Sidebar.DischargeTrackerSidebarMain')

    @elseif(in_array(Route::currentRouteName(), ['home', 'notification.index']))


        @include('Layouts.Common.Sidebar.ANESidebarMain')
    @elseif (in_array(Route::currentRouteName(), [
            'virtual.ward',
            'site.dashboard',
            // 'report.dashboard'
        ]))

        @include('Layouts.Common.Sidebar.ANESidebarMain')
    @elseif (in_array(Route::currentRouteName(), [
            'pharmacy.dashboard',
            'inpatients.siteoverview',
            'red.bed.dashboard',
            'global.patient.search',
            'report.dashboard','reason_reside.dashboard','mobility.score','virtual.ward.leaflet','site.stranded_patients','discharges_patient.dashboard', 'site.office','allowed_to_move.dashboard'
        ]))

        @include('Layouts.Common.Sidebar.SiteOverViewSidebar')
    @elseif (Request::is('ane*'))

        @include('Layouts.Common.Sidebar.ANESidebarSub')
    @elseif (in_array(Route::currentRouteName(), ['ane_home']))

        @include('Layouts.Common.Sidebar.ANESidebarMain')
    @elseif (Request::routeIs('inpatients*') || Request::routeIs('bed.matrix') || Request::routeIs(['board_round.dashboard','site.pd_discharge','surgical.ward','doctor.at.night', 'ward.dashboard', 'wardtype.ward-performance']))
        @include('Layouts.Common.Sidebar.CamisSidebarMain')
    @elseif (Request::routeIs('discharged*') || Request::routeIs('discharge.tracker*'))
         @include('Layouts.Common.Sidebar.DischargeTrackerSidebarMain')
    @elseif (Request::routeIs('infection*'))

        @include('Layouts.Common.Sidebar.InPatientsSidebarMain')
{{--    @elseif (Request::routeIs(['report.dashboard','reason_reside.dashboard','surgical.ward','doctor.at.night','mobility.score','virtual.ward.leaflet','site.stranded_patients','discharges_patient.dashboard', 'site.office']))--}}
{{--        @include('Layouts.Common.Sidebar.CamisOtherDashboardSidebar')--}}
    @elseif ((Request::routeIs(['bed.status.flag'])) || ((Request::routeIs(['virtual.ward.summary']) && (in_array($lastSegment,$vertual_ward)))))
        @include('Layouts.Common.Sidebar.CamisVirtualwardSidebar')

        @elseif (Request::routeIs([
            'discharge.lounge*',
        ]))

        @include('Layouts.Common.Sidebar.DischargeLoungeSidebar')
    @elseif (Request::routeIs([
            'new.patient',
            'reviewed.patient',
            'removed.patient',
            'patient.task.details',
            'patient.search',
            'DPSummaryMenu',
            'patient.task.summary',
        ]))

        @include('Layouts.Common.Sidebar.DeterioratingPatientSidebar')
    @elseif (!Request::routeIs('inpatients/dashboards/ward-summary*'))
        {{--    @elseif (in_array(Route::currentRouteName(), [''])) --}}
        {{--        <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/sidebar.css') }}" crossorigin="anonymous" /> --}}
        {{--        @include('Layouts.Common.Sidebar.InPatientsSidebarSub') --}}
    @else

        @include('Layouts.Common.Sidebar.ANESidebarSub')
    @endif
@endif
