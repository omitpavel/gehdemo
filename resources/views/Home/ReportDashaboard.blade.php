 @extends('Layouts.Common.MasterLayout')
 @section('page-title', 'Other Dashboard')
 @section('page-top-title', 'OTHER DASHBOARD')
 @push('custom-style')
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/OdHome.css') }}" crossorigin="anonymous">
 @endpush
 @section('content')

     <!-- Main Content -->

     <div class="honeyCombWrap">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-12">
                    <div class="dbviewInnerRow row">
                        <div class="honey_col swcol">
                            <h3>OTHER DASHBOARD</h3>
                         <ul class="container other_dashboard_container" >
                             <li class="item color-yellow @if(!CheckDashboardPermission('flow_dashboard_siteoverview_view')) {{ PermissionDeniedDiv('flow_dashboard_siteoverview_view') }} @endif">
                                 <a @if(CheckDashboardPermission('flow_dashboard_siteoverview_view')) href="{{ route('inpatients.siteoverview') }}" @endif><span>Site Overview</span></a>
                             </li>
                             <li class="item color-yellow {{ PermissionDeniedDiv('flow_dashboard_red_bed_view') }} {{ PermissionDeniedDiv('flow_dashboard_red_bed_view') }}">
                                 <a  @if(PermitedStatus('flow_dashboard_red_bed_view'))  href="{{ route('red.bed.dashboard') }}" @endif ><span>Red To Green</span></a>
                             </li>


                             <li class="item color-cyan {{ PermissionDeniedDiv('stranded_dashboard') }} {{ PermissionDeniedDiv('stranded_dashboard') }}">
                                 <a @if(CheckDashboardPermission('stranded_dashboard')) href="{{ route('site.stranded_patients') }}" @endif><span>Patients By LOS</span></a>
                             </li>

                             <li class="item color-maroon {{ PermissionDeniedDiv('r_to_r_view_') }} {{ PermissionDeniedDiv('r_to_r_view_') }}">
                                 <a data-toggle="tooltip" @if(PermitedStatus('r_to_r_view_')) href="{{ route('reason_reside.dashboard') }}" @endif><span>Reason To Reside</span></a>
                             </li>
                             <li class="item color-maroon {{ PermissionDeniedDiv('allowed_to_move_dashboard_view') }} {{ PermissionDeniedDiv('allowed_to_move_dashboard_view') }}">
                                <a data-toggle="tooltip"  @if(PermitedStatus('allowed_to_move_dashboard_view')) href="{{ route('allowed_to_move.dashboard') }}" @endif><span>Allowed To Move</span></a>
                            </li>
                             <li class="item color-grey {{ PermissionDeniedDiv('discharged_patient_is_view_dashbaord_view') }}  {{ PermissionDeniedDiv('discharged_patient_is_view_dashbaord_view') }}">
                                 <a data-toggle="tooltip" @if(PermitedStatus('discharged_patient_is_view_dashbaord_view'))  href="{{ route('discharges_patient.dashboard') }}" @endif><span>Discharged Patients</span></a>
                             </li>

                             <li   class="item color-cyan {{ PermissionDeniedDiv('pharmacy_dashboard_') }}  {{ PermissionDeniedDiv('pharmacy_dashboard_') }}">
                                 <a data-toggle="tooltip"
                                    @if(PermitedStatus('pharmacy_dashboard_')) href="{{ route('pharmacy.dashboard') }}" @endif><span>Pharmacy Dashboard</span>
                                 </a>
                             </li>
                             <li class="item color-cyan {{ PermissionDeniedDiv('flow_dashboard_patient_search_view') }} {{ PermissionDeniedDiv('flow_dashboard_patient_search_view') }}">
                                <a @if(PermitedStatus('flow_dashboard_patient_search_view')) href="{{ route('global.patient.search') }}" @endif><span>Patient Search</span></a>
                              </li>
                         </ul>

                        </div>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Main Content End-->
     @endsection
