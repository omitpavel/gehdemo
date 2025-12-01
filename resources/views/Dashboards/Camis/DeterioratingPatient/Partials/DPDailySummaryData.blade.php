<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">


            <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2">
                    <a  onclick="DailySummaryData('{{ date('Y-m-01') }}', '{{ date('Y-m-d') }}');" class="tab-custom-btn active" data-bs-toggle="tab" href="#dailySummary">
                        <div class="tab-active">Task Details</div>
                    </a>
                </li>
                <li class="mb-2">
                    <a  onclick="WardSummaryData('{{ \Carbon\Carbon::now()->format('F Y') }}');" class="tab-custom-btn " data-bs-toggle="tab" href="#wardSummary">
                        <div class="tab-active">Ward Summary</div>
                    </a>
                </li>

            </ul>


            <div class="tab-content" id="tabcontent">
                <div id="dailySummary" class=" tab-pane  active">
                    <div class="row gx-2 date-range">
                        <div class="col-lg-3 col-md-6  mb-2">
                            <div>
                                {!! AllWardListDropdown() !!}
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">Date From
                                                    </span>
                                <input type="text" class="form-control" aria-describedby="basic-addon1"
                                       id="daterangepicker">
                                <input type="hidden" name="start_date" id="start_date" value="{{request()->start_date}}">
                                <input type="hidden" name="end_date" id="end_date" value="{{request()->end_date}}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="start_date" id="start_date" value="{{request()->start_date}}">
                    <input type="hidden" name="end_date" id="end_date" value="{{request()->end_date}}">
                    <div class="row mb-2">
                        <div class="container-fluid">
                            <div class="col-lg-12  ">
                                <div class="row">
                                    <div class="col-xl-8 pe-xl-0 mb-1">
                                        <div class="virtual-ward-table">
                                            <table class="breachReasonTable responsiveTable table-task-details">
                                                <thead>
                                                    <tr class="position-relative">
                                                        <th width="100">Date</th>
                                                        @foreach ($success_array['master_dp_task'] as $master_task_name)
                                                            <th width="70">{{ $master_task_name }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($success_array['all_dates'] as $key => $value)


                                                        <tr>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Date</div>
                                                                {{ $value['date'] }}
                                                            </td>
                                                            @foreach ($success_array['master_dp_task'] as $master_task_name)
                                                                <td class="pivoted">
                                                                    <div class="tdBefore">$master_task_name</div>
                                                                    {{ $value[$master_task_name] ?? 0 }}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 ps-xl-1">
                                        <div class="virtual-ward-escalation">
                                            <table class="breachReasonTable responsiveTable table-task-details">
                                                <thead>
                                                    <tr class="position-relative">
                                                        <th width="100">Date</th>
                                                        <th width="90">No. of Task List Generated</th>
                                                        <th width="40">Escalation No</th>
                                                        <th width="40">Escalation Yes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($success_array['escalation_all'] as $key => $value)
                                                        <tr>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Date</div>
                                                                {{ $value['date'] }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">No. of Task List Generated</div>
                                                                {{ $value['escalation'] }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Escalation No</div>
                                                                {{ $value['escalation_no'] }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Escalation Yes</div>
                                                                {{ $value['escalation_yes'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
