
<div class="site-reports">
    <div class="last-update-time">
        <span>Last Date Refresh : {{ PredefinedDateFormatFor24Hour(CurrentDateOnFormat()) }}</span>
    </div>
    <div class="mb-2">
        <textarea class="form-control" id="current_text" rows="6">{!! $success_array["text_create_show_case"] !!}</textarea>

    </div>
    <div class="row g-2 mb-2">
        <div class="col-lg-3 col-md-3">
          <button class="btn btn-primary-grey show_hide_last_message">Show Last Saved Text</button>
        </div>
        <div class="col-lg-2 col-md-3 offset-md-3 offset-lg-5 col-6 @if(!CheckDashboardPermission('site_office_report_update')) permission_denied_div @endif ">
          <button class="btn btn-primary-grey save_office_reports @if(!CheckDashboardPermission('site_office_report_update')) permission_restricted @endif "><img src="{{ asset('asset_v2/Template/icons/save.svg') }}" alt="" class="btn-icon-modal" width="16" height="16">Save</button>
        </div>
        <div class="col-lg-2 col-md-3 col-6 @if(!CheckDashboardPermission('site_office_report_print')) permission_denied_div @endif ">
          <button class="btn btn-primary-grey print_office_reports @if(!CheckDashboardPermission('site_office_report_print')) permission_restricted @endif "><img src="{{ asset('asset_v2/Template/icons/print.svg') }}" alt="" class="btn-icon-modal" width="16">Print</button>
        </div>
    </div>

    <div class="mb-2 last_message_textarea"  style="display: none;">
        <textarea class="form-control" id="previous_text" rows="6">{{$success_array["office_text"]->office_text ?? ''}}</textarea>
    </div>
    </div>
</div>
<script>
$('#current_text').summernote({
    height: '70vh',
    minHeight: null,
    maxHeight: null,
    focus: true,
    toolbar: [
        ['style', []],
        ['font', []],
        ['color', []],
        ['para', []],
        ['height', []],
        ['insert', []],
        ['view', []],
        ['help', []]
      ]
});
$('#previous_text').summernote({
    height: '300px',
    minHeight: null,
    maxHeight: null,
    toolbar: [
        ['style', []],
        ['font', []],
        ['color', []],
        ['para', []],
        ['height', []],
        ['insert', []],
        ['view', []],
        ['help', []]
      ]
});
</script>
