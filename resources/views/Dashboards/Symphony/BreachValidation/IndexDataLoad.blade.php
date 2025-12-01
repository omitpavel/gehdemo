<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12 tabbed" id="custom-tab">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2 {{ PermissionDeniedDiv('breach_reason_view') }}">
                    <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('breach_reason_view') }}" id="breach_list_tab" data-bs-toggle="tab" href="#breach_list_tab_content"><div class="tab-active">Breach Reason</div></a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('breach_dashboard_view') }}">
                    <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('breach_dashboard_view') }}" id="day_summary_tab" data-bs-toggle="tab" href="#day_summary_tabs"><div class="tab-active">Dashboard</div></a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('breach_weekly_dashboard_view') }}">
                    <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('breach_weekly_dashboard_view') }}" id="week_summary_tab" data-bs-toggle="tab" href="#week_summary_tab_content"><div class="tab-active">Weekly Dashboard</div></a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('breach_monthly_dashboard_view') }}">
                    <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('breach_monthly_dashboard_view') }}" id="month_summary_tab" data-bs-toggle="tab" href="#month_summary_tab_content"><div class="tab-active">Monthly Dashboard</div></a>
                </li>
                <li class="mb-2 {{ PermissionDeniedDiv('breach_monthly_report_view') }}">
                    <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('breach_monthly_report_view') }}" id="month_summary_overall_tab" data-bs-toggle="tab" href="#month_summary_overall_tab_content"><div class="tab-active">Month</div></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content bg-light-blue" id="tabcontent">
                <div class="common_page_tab_nav_contents tab-pane tab-pane-page fade show active "  role="tabpanel" id="breach_list_tab_content">
                    <div class="loader-bg-inside-content all_tab_content_loader_image_1"> <span class="screen-center"></span> </div>
                    <div class="breach_list_tab_content_data_load" id="breach_list_tab_content_data_load">

                    </div>
                </div>
                <div id="day_summary_tabs" class=" tab-pane fade "  role="tabpanel">
                    <div class="tabinnerWrap dashboardTabWrap">
                        <div class="loader-bg-inside-content all_tab_content_loader_image_2"> <span class="screen-center"></span> </div>
                        <div class="day_summary_tab_content_data_load" id="day_summary_tab_content_data_load"></div>
                    </div>
                </div>
                <div class=" tab-pane fade " id="week_summary_tab_content"  role="tabpanel">
                    <div class="tabinnerWrap dashboardTabWrap">
                        <div class="loader-bg-inside-content all_tab_content_loader_image_3"> <span class="screen-center"></span> </div>
                        <div class="week_summary_tab_content_data_load" id="week_summary_tab_content_data_load"></div>
                    </div>
                </div>
                <div id="month_summary_tab_content" class=" tab-pane fade "  role="tabpanel">
                    <div class="tabinnerWrap dashboardTabWrap">
                        <div class="loader-bg-inside-content all_tab_content_loader_image_4"> <span class="screen-center"></span> </div>
                        <div class="contentArea month_summary_tab_content_data_load" id="month_summary_tab_content_data_load"> </div>
                    </div>
                </div>
                <div id="month_summary_overall_tab_content" class=" tab-pane fade  "  role="tabpanel">
                    <div class="tabinnerWrap dashboardTabWrap">
                        <div class="loader-bg-inside-content all_tab_content_loader_image_5"> <span class="screen-center"></span> </div>
                        <div class="contentArea month_summary_overall_tab_content_data_load" id="month_summary_overall_tab_content_data_load"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
