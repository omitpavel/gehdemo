
<div class="col-lg-12  ">
    <div class="row">
        <div class="col-lg-12">
            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('flow_dashboard_red_bed_view') }}">
                      <a class="tab-custom-btn {{ DisabledButtonOnRolePermission('flow_dashboard_red_bed_view') }}" onclick="ReasonListLoad();">
                        <div class="tab-active">Red Reasons</div>
                      </a>
                    </li>
                    <li class="mb-2  {{ PermissionDeniedDiv('flow_dashboard_redbed_performance_view') }}">
                      <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('flow_dashboard_redbed_performance_view') }}"  onclick="PerformanceTabReset();">
                        <div class="tab-active">Performance</div>
                      </a>
                    </li>
                </ul>
                <div class="filters-performance" id="filtersPerformance" style="display: block !important;">
                    <div class="row gx-2">
                        <div class="col-xl-3 col-lg-4 col-md-4 mb-2">
                            <select class="3col active"  multiple="multiple" aria-label="Default select example" id="ward_id_performance">
                                <optgroup label="Medical Wards">
                                    @foreach ($success_array['medical_wards'] as $ward)
                                    <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif >
                                        {{ $ward['ward_name'] }}</option>
                                    @endforeach

                                </optgroup>
                                <optgroup label="Surgical Wards">
                                    @foreach ($success_array['surgical_wards'] as $ward)
                                    <option value="{{ $ward['id'] }}"@if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                        {{ $ward['ward_name'] }}</option>
                                    @endforeach

                                </optgroup>
                                <optgroup label="Others Wards">
                                    @foreach ($success_array['other_wards'] as $ward)
                                    <option value="{{ $ward['id'] }}" @if (request()->filled('ward_id') && in_array($ward['id'], request()->ward_id)) selected @endif>
                                        {{ $ward['ward_name'] }}</option>
                                    @endforeach

                                </optgroup>

                            </select>


                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 mb-2">
                            <select name="basic[]" multiple="multiple" id="reason_id_performance" class="3col active">
                                <optgroup label="Clinical Review">
                                    @foreach ($success_array['clinical_review'] as $reason_id => $reason)
                                        <option value="{{ $reason_id }}" @if(request()->filled('reason_id') && in_array($reason_id, request()->reason_id))  selected @endif>{{  $reason }}{{-- str_replace('ClinicalReview-','',$reason) --}} </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Discharge Plan">
                                    @foreach ($success_array['discharge_plan'] as $reason_id => $reason)
                                        <option value="{{ $reason_id }}" @if(request()->filled('reason_id') && in_array($reason_id, request()->reason_id))  selected @endif>{{  $reason }}{{-- str_replace('DischargePlan-','',$reason) --}} </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Diagnostics">
                                    @foreach ($success_array['diagnostics'] as $reason_id => $reason)
                                        <option value="{{ $reason_id }}" @if(request()->filled('reason_id') && in_array($reason_id, request()->reason_id))  selected @endif>{{  $reason }}{{-- str_replace('Diagnostics-','',$reason) --}}</option>
                                    @endforeach
                                </optgroup>

                            </select>
                        </div>
                        <div class="col-xl-1 col-md-2 mb-2">
                            <button class="btn btn-search" onclick="PerformanceTabLoad();">Search</button>
                        </div>
                        <div class="col-xl-1 col-lg-2 col-md-2 offset-xl-4">
                            <button type="button" class="btn btn-export w-100"  onclick="PerformanceTabReset();"><img src="{{ asset('asset_v2/Template/icons/reset.svg') }}" alt="" width="16" class="me-2">Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="tabcontent">

                <div id="performance" class="tab-pane fade active show" role="tabpanel" aria-labelledby="#performanceTab">
                  <div class="other-dashboard-contents">
                    <div class="performance-contents">
                      <div class="row gx-2 mb-2">
                        <div class="col-xl-3">
                            <div class="">
                                <div id="redReasonsSummary"></div>
                                <h6 class="graph-title">NUMBER OF PATIENTS</h6>
                                <div id="redReasonsAvg"></div>
                                <h6 class="graph-title">AVERAGE DAYS</h6>
                            </div>
                        </div>
                        <div class="col-xl-9">
                          <div class="row red_bed_performance_right_section ">
                            <div class="col-lg-12 ">
                                  <div class="tree-chart-section cursor_pointer">
                                    <div id="redReasonTreeMap"></div>
                                  </div>
                                    <script>
                                        var options = {
                                            series: [
                                            {
                                                data: {!! $success_array['tree_data'] !!}
                                            }
                                            ],
                                            legend: {
                                            show: false
                                            },
                                            chart: {
                                                toolbar: {
                                                show: false,
                                            },
                                            height: 350,
                                            type: 'treemap',
                                            fontFamily: 'Poppins, sans-serif',
                                                events: {
                                                    dataPointSelection: function(event, chartContext, config) {
                                                        var reason_name = config.w.config.series[config.seriesIndex].data[config.dataPointIndex].x;
                                                        var formatted_reason_name = reason_name.replace(/\n/g, " ");
                                                        var adjust_clinical_review = formatted_reason_name.replace('Clinical Review', 'Clinical Review -');
                                                        var adjust_discharge_plan = adjust_clinical_review.replace('Discharge Plan', 'Discharge Plan -');
                                                        var adjust_diagnostics_plan = adjust_discharge_plan.replace('Diagnostics', 'Diagnostics -');

                                                        FilterSubReasonListWithPatient(adjust_diagnostics_plan);
                                                    }
                                                }
                                            },
                                            dataLabels: {
                                            enabled: true,
                                            style: {
                                                fontSize: '12px',
                                            },
                                            formatter: function(text, op) {
                                                var formattedText = text.replace(/\n/g,'\n')+'\n'+op.value;
                                                return formattedText.split('\n');
                                            }
                                            ,
                                            offsetY: -4
                                            },
                                            plotOptions: {
                                                treemap: {
                                                    enableShades: true,
                                                    shadeIntensity: 0.5,
                                                    reverseNegativeShade: true,
                                                    colorScale: {
                                                    ranges: [
                                                        {
                                                        from: 0,
                                                        to: 4,
                                                        color: '#0066FF'
                                                        },
                                                        {
                                                        from: 5,
                                                        to: 8,
                                                        color: '#CD363A'
                                                        }
                                                    ]
                                                    }
                                                }
                                            }
                                            };
                                        if (document.querySelector("#redReasonTreeMap")) {
                                            var chart = new ApexCharts(document.querySelector("#redReasonTreeMap"), options);
                                            chart.render();
                                        }
                                    </script>

                                  <div class="card-table mb-lg-2 ">

                                    <div class="red-reasons-performance-data">
                                      <div class="rectangle-block-1">
                                        <div class="col-lg-12">
                                          <div class="d-flex justify-content-between align-items-center rectangle-block-2">
                                            <p class="mb-0">Patients Details </p>
                                            <button type="button" class="btn btn-export" id="red_patient_export_filter"><img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" class="me-2" width="14">Export</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="modal-popup-loader-content"></div>
                                      <div class="red-reasons-patient-details ward_summary_sub_modal_inner_body red_bed_performance_patient_list">
                                        @if (!empty($success_array['patient_list_with_pending_task']))

                                            <table class="responsiveTable table-custom">
                                            <thead>
                                                <tr class="position-relative">
                                                <th>Name</th>
                                                <th>Hospital Number</th>
                                                <th>Ward</th>
                                                <th>Bay &amp; Bed</th>
                                                <th>Delay Days</th>
                                                <th>Created Date</th>
                                                <th>Red Reason</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                @foreach ($success_array['patient_list_with_pending_task'] as $patient_data)

                                                    <tr>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Name</div>
                                                            {{ $patient_data['patient_name'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Hospital Number</div>
                                                            {{ $patient_data['patient_pas_number'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Ward</div>
                                                            {{ $patient_data['patient_ward'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Bay &amp; Bed</div>
                                                            {{ $patient_data['patient_bed'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Delay Days</div>
                                                            {{ $patient_data['patient_delay_time'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Created Date</div>
                                                            {{ $patient_data['reason_created_time'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Red Reason</div>
                                                            {{ $patient_data['patient_reason'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                            </table>
                                        @else
                                            <div class="custom_not_found">
                                                {{ NotFoundMessage() }}
                                            </div>
                                        @endif
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
        </div>
    </div>
</div>
<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.bg-sticky');
    var noRecords = document.querySelector('.custom_not_found');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            var bgSticky = document.querySelector('.bg-sticky');
            if(bgSticky){
                bgSticky.style.top = '135px';
            }
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '135px';
            })


            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');
                if (noRecords) {
                    if(bgSticky){
                        bgSticky.style.top = '60px';
                    }
                    noRecords.style.marginTop = '40px';
                }

            }


        }
        else{
            document.getElementById("stickyToprow").style.top = "60px";
            var bgSticky = document.querySelector('.bg-sticky');
            if(bgSticky){
                bgSticky.style.top = '110px';
            }
            var stickyHeader = document.querySelectorAll('.sticky-header');
            stickyHeader.forEach(function (header) {
                header.style.top = '110px';
            })


            if (document.getElementById("stickyToprow")) {
                var noRecords = document.querySelector('.custom_not_found');
                if (noRecords) {
                    if(bgSticky){
                        bgSticky.style.top = '60px';
                    }
                    noRecords.style.marginTop = '40px';
                }

            }
        }


    }



</script>

<script>
    var options = {
        series: [{
            name: '',
            data: [{{ count($success_array['clinical_patient_count']) }}, {{ count($success_array['diagnostics_patient_count']) }}, {{ count($success_array['discharge_plan_patient_count']) }}]
        }, ],
        chart: {
            toolbar: {
                show: false,
            },
            type: 'bar',
            height: 315,
            stacked: true,
            fontFamily: 'Poppins, sans-serif',
            events: {
                dataPointSelection: function(event, chartContext, config) {
                    document.querySelectorAll("#redReasonsSummary .apexcharts-bar-area").forEach((bar, index) => {
                        if (index === config.dataPointIndex) {
                            bar.style.opacity = "1";
                        } else {
                            bar.style.opacity = "0.5";
                        }
                    });

                    FilterSubReasonList(config.w.config.xaxis.categories[config.dataPointIndex]);
                }
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 3,
                borderRadiusWhenStacked: 'all',
                dataLabels: {
                    total: {

                        enabled: false,
                        position: 'bottom'
                    }
                },
            }

        },
        grid: {
            show: false,

        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: false,
        },
        colors: ['#0066FF', '#C2DAF2'],
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {

                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        xaxis: {
            categories: ['Clinical Review', 'Diagnostics', 'Discharge Plan'],
            labels: {
                show: true,
                style: {
                    fontWeight: 600,
                    fontSize: 10
                },
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.5,
                gradientToColors: ['#0066FF', '#9DB6CD'],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 100],
                colorStops: []
            }
        },
        legend: {
            show: false
        },
    };

    if (document.querySelector("#redReasonsSummary")) {
        var chart = new ApexCharts(document.querySelector("#redReasonsSummary"), options);
        chart.render().then(() => {
            document.querySelectorAll("#redReasonsSummary .apexcharts-bar-area").forEach((bar) => {
                bar.classList.add("cursor_pointer");
            });
        });
    }





</script>
<script>
    var options = {
        series: [{
            name: '',
            data: [{{ round($success_array['clinical_patient_avg']) }}, {{ round($success_array['diagnostics_patient_avg']) }}, {{ round($success_array['discharge_plan_patient_avg']) }}]
        }, ],
        chart: {
            toolbar: {
                show: false,
            },
            type: 'bar',
            height: 315,
            stacked: true,
            fontFamily: 'Poppins, sans-serif'
        },
        plotOptions: {
            bar: {
                borderRadius: 3,
                borderRadiusWhenStacked: 'all',
                dataLabels: {
                    total: {

                        enabled: false,
                        position: 'bottom'
                    }
                },
            }

        },
        grid: {
            show: false,

        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: false,
        },
        colors: ['#0066FF', '#C2DAF2'],
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {

                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        xaxis: {
            categories: ['Clinical Review', 'Diagnostics', 'Discharge Plan'],
            labels: {
                show: true,
                style: {
                    fontWeight: 600,
                    fontSize: 10
                },
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.5,
                gradientToColors: ['#0066FF', '#9DB6CD'],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 100],
                colorStops: []
            }
        },
        legend: {
            show: false,
        },
    };
    if (document.querySelector("#redReasonsAvg")) {
        var chart = new ApexCharts(document.querySelector("#redReasonsAvg"), options);
        chart.render();
    }
    function FilterSubReasonList(reason_name) {
        CommonDisableEnableOnOpen();
        var ward_id = $('#ward_id_performance').val();
        var reason_id = $('#reason_id_performance').val();

        $.ajax({
            _token: tok,
            url: "{{ route('red.bed.performance.right.section') }}",
            type: 'POST',
            data: {
                "ward_id": ward_id,
                "reason_id": reason_id,
                "reason_name": reason_name,
                _token: tok
            },
            success: function(result) {
                $('.red_bed_performance_right_section').html(result);
                DisableLoaderAndMakeVisibleInnerBody();
                console.log = function () {};
                console.clear();
            }
        });
    }


    function FilterSubReasonListWithPatient(reason_id) {
        CommonDisableEnableOnOpen();
        var ward_id = $('#ward_id_performance').val();

        $.ajax({
            _token: tok,
            url: "{{ route('red.bed.performance.patient_list') }}",
            type: 'POST',
            data: {
                "ward_id": ward_id,
                "reason_id": reason_id,
                _token: tok
            },
            success: function(result) {
                $('.red_bed_performance_patient_list').html(result);
                DisableLoaderAndMakeVisibleInnerBody();
                console.log = function () {};
                console.clear();
            }
        });
    }
</script>

