<div class="col-lg-12">
    <div class="row date-range g-2 mb-2">
        <div class="col-lg-3 col-md-6 ">
            <div>
                {!! AllWardListDropdown() !!}
            </div>

        </div>

        <div class="col-lg-3 col-md-6">
            <div>
                <select class="form-select w-100" aria-label="Default select example"  name="tab1_search_month" id="month">
                    @foreach($success_array['month_list'] as $month)
                        <option value="{{ $month }}" @if($success_array['selected_date'] == $month) selected @endif>{{ $month }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="container-fluid">
            <div class="col-lg-12  ">
                <div class="summary-card mb-2">
                    <h6>Task Response Time Analysis</h6>
                    <div class="border-bottom mb-2"></div>
                    <div class="row align-items-center">
                        <div class="col-xl-9 col-lg-8 pe-lg-1">

                            <div id="response-time-chart" class="pt-3"></div>
                        </div>
                        <div class="col-xl-3 col-lg-4 ps-lg-1 summary-counts">
                            <div class="bg-list mb-2">
                                <div class="row align-items-center">
                                    <div class="col-9 pe-1">
                                        <h6 class="mb-0">Task List <br> Generated</h6>
                                    </div>
                                    <div class="col-3 ps-1">
                                        <h4 class="mb-0"> {{ $success_array['escalation_count'] }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-no-escalation mb-2">
                                <div class="row align-items-center">
                                    <div class="col-9 pe-1">
                                        <h6 class="mb-0">Patient Not <br> Escalated</h6>
                                    </div>
                                    <div class="col-3 ps-1">
                                        <h4 class="mb-0">{{ $success_array['escalation_no_count'] }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-escalation">
                                <div class="row align-items-center">
                                    <div class="col-9 pe-1">
                                        <h6 class="mb-0">Number of <br> Escalated Patients </h6>
                                    </div>
                                    <div class="col-3 ps-1">
                                        <h4 class="mb-0"> {{ $success_array['escalation_yes_count'] }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-2 bottom-charts">
                    <div class="col-xl-7">
                        <div class="summary-card mb-2">
                            <h6>Task List completion Time in Minutes</h6>
                            <div class="border-bottom"></div>
                            <div id="response-line-chart"  class="pt-3"></div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="summary-card mb-2">
                            <h6>Task Response Time Analysis</h6>
                            <div class="border-bottom"></div>
                            <div id="task-response-chart"  class="pt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('Dashboards.Camis.DeterioratingPatient.TaskSummaryGraphScript')

