<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12 " id="custom-tab">
            <!-- Nav tabs -->


            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2 {{ PermissionDeniedDiv('ed_live_summary_view') }}">
                    <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('ed_live_summary_view') }}" id="live_summary_tab" data-bs-toggle="tab" href="#live_summary_tab_content" >
                        <div class="tab-active">Live</div>
                    </a>
                </li>
                <li class="mb-2  {{ PermissionDeniedDiv('ed_day_summary_view') }}">
                    <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('ed_day_summary_view') }}" id="day_summary_tab" data-bs-toggle="tab" href="#day_summary_tab_content">
                        <div class="tab-active">Today</div>
                    </a>
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content " id="tabcontent">
                <div class="common_page_tab_nav_contents tab-pane tab-pane-page fade show active" id="live_summary_tab_content" role="tabpanel" aria-labelledby="day_summary_tab_content">
                    <div class="tabinnerWrap ">
                        <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_1">
                            <span class="screen-center"></span>
                        </div>
                        <div class="live_summary_tab_content_data_load" id="live_summary_tab_content_data_load">@include('Dashboards.Symphony.EDOverview.IndexDataLoadTabContent1')</div>
                    </div>
                </div>
                <div class="tab-pane tab-pane-page fade" id="day_summary_tab_content" role="tabpanel" aria-labelledby="week_summary_tab_content">
                    <div class="tabinnerWrap dashboardTabWrap">
                        <div class="loader-bg-inside-content all_tab_content_loader_image all_tab_content_loader_image_2">
                            <span class="screen-center"></span>
                        </div>
                        <div class="day_summary_tab_content_data_load" id="day_summary_tab_content_data_load"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
