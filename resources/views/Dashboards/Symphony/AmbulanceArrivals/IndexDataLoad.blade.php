 <div class="col-lg-12">
     <div class="row ">
         <div class="col-lg-12 " id="custom-tab">
             <!-- Nav tabs -->
             <ul class="nav nav-tabs" role="tablist">
                 <li class="mb-2 {{ PermissionDeniedDiv('ambulance_dashboard_live_view') }}">
                     <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('ambulance_dashboard_live_view') }}" id="day_summary_tab" data-bs-toggle="tab" href="#live"> <div class="tab-active">Day Summary</div></a>
                 </li>
                 <li class="mb-2 {{ PermissionDeniedDiv('ambulance_dashboard_week_to_date_view') }}">
                     <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('ambulance_dashboard_week_to_date_view') }}" id="week_summary_tab" data-bs-toggle="tab" href="#weekly">
                        <div class="tab-active">Week Summary</div>
                     </a>
                 </li>
                 <li class="mb-2 {{ PermissionDeniedDiv('ambulance_dashboard_last_four_week_view') }}">
                     <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('ambulance_dashboard_last_four_week_view') }}" id="month_summary_tab" data-bs-toggle="tab" href="#lastweek">
                        <div class="tab-active">Month Summary</div>
                     </a>
                 </li>
                 <li class="mb-2 {{ PermissionDeniedDiv('ambulance_dashboard_last_thousand_arrival_view') }}">
                     <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('ambulance_dashboard_last_thousand_arrival_view') }}" id="last_thousand_summary_tab" data-bs-toggle="tab" href="#last1000">
                        <div class="tab-active">Last 1000 Arrivals</div>
                     </a>
                 </li>
             </ul>
             <!-- Tab panes -->
             <div class="tab-content " id="tabcontent">
                 <div class="common_page_tab_nav_contents tab-pane fade show active" id="live" role="tabpanel" aria-labelledby="day_summary_tab_content">
                     <div class="tabinnerWrap ">
                         <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_1">
                             <span class="screen-center"></span>
                         </div>
                         <div class="day_summary_tab_content_data_load" id="day_summary_tab_content_data_load"></div>
                     </div>
                 </div>
                 <div class="tab-pane tab-pane-page fade" id="weekly" role="tabpanel" aria-labelledby="week_summary_tab_content">
                     <div class="tabinnerWrap dashboardTabWrap">
                         <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_2">
                             <span class="screen-center"></span>
                         </div>
                         <div class="week_summary_tab_content_data_load" id="week_summary_tab_content_data_load"></div>
                     </div>
                 </div>
                 <div class="tab-pane tab-pane-page fade" id="lastweek" role="tabpanel" aria-labelledby="month_summary_tab_content">
                     <div class="tabinnerWrap dashboardTabWrap">
                         <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_3">
                             <span class="screen-center"></span>
                         </div>
                         <div class="contentArea month_summary_tab_content_data_load" id="month_summary_tab_content_data_load"></div>
                     </div>
                 </div>
                 <div class="tab-pane tab-pane-page fade" id="last1000" role="tabpanel" aria-labelledby="last_thousand_summary_tab_content">
                     <div class="tabinnerWrap dashboardTabWrap">
                         <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_4">
                             <span class="screen-center"></span>
                         </div>
                         <div class="contentArea last_thousand_summary_tab_content_data_load" id="last_thousand_summary_tab_content_data_load"></div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
