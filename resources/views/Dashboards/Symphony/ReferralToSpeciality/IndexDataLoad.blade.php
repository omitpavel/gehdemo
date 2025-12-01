 <div class="col-lg-12">
     <div class="row ps-lg-0">
         <div class="col-lg-12 tabbed" id="custom-tab">
             <!-- Nav tabs -->
             <ul class="nav nav-tabs" role="tablist">
                 <li class="mb-2 {{ PermissionDeniedDiv('referral_to_speciality_week_view') }}">
                     <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('referral_to_speciality_week_view') }}" id="week_summary_tab" data-bs-toggle="tab" href="#week_summary_tab_content">
                        <div class="tab-active">Week Summary</div>
                     </a>
                 </li>
                 <li class="mb-2 {{ PermissionDeniedDiv('referral_to_speciality_month_view') }}">
                     <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('referral_to_speciality_month_view') }}" id="month_summary_tab" data-bs-toggle="tab" href="#month_summary_tab_content">
                        <div class="tab-active">Month Summary</div>
                     </a>
                 </li>
                 <li class="mb-2 {{ PermissionDeniedDiv('referral_to_speciality_last_1000_view') }}">
                     <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('referral_to_speciality_last_1000_view') }}" id="last_thousand_summary_tab" data-bs-toggle="tab" href="#last_thousand_summary_tab_content">
                        <div class="tab-active">Last 1000</div>
                     </a>
                 </li>
             </ul>
             <!-- Tab panes -->
             <div class="tab-content bg-light-blue" id="tabcontent">
                 <div class="common_page_tab_nav_contents tab-pane tab-pane-page fade show active" id="week_summary_tab_content" role="tabpanel" aria-labelledby="week_summary_tab_content">
                     <div class="tabinnerWrap ">
                         <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_1">
                             <span class="screen-center"></span>
                         </div>
                         <div class="week_summary_tab_content_data_load" id="week_summary_tab_content_data_load">
                             @include('Dashboards.Symphony.ReferralToSpeciality.IndexDataLoadTabContent')
                         </div>
                     </div>
                 </div>
                 <div class="tab-pane tab-pane-page fade" id="month_summary_tab_content" role="tabpanel" aria-labelledby="month_summary_tab_content">
                     <div class="tabinnerWrap dashboardTabWrap">
                         <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_2">
                             <span class="screen-center"></span>
                         </div>
                         <div class="month_summary_tab_content_data_load" id="month_summary_tab_content_data_load"></div>
                     </div>
                 </div>
                 <div class="tab-pane tab-pane-page fade" id="last_thousand_summary_tab_content" role="tabpanel" aria-labelledby="last_thousand_summary_tab_content">
                     <div class="tabinnerWrap dashboardTabWrap">
                         <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_3">
                             <span class="screen-center"></span>
                         </div>
                         <div class="contentArea last_thousand_summary_tab_content_data_load" id="last_thousand_summary_tab_content_data_load"></div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
