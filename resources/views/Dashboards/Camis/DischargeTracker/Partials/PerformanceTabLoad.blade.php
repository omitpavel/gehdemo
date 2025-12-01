<div class="col-lg-12">
    <div class="row gx-2 ">
        <div class="col-lg-3 col-md-4 mb-2">
            {!! AllWardListDropdown('ward_id') !!}
        </div>
        <div class="col-lg-3 col-md-4 mb-2">
            <select class="form-select selectric-select w-100" aria-label="Default select example" id="reason_code_id">
                <option value="">All Reason Codes</option>
                @foreach ($success_array['reason_list'] as $reason_id => $reason_name)
                    <option value="{{ $reason_id }}" {{ (request()->reason_code_id == $reason_id) ? 'selected' : '' }}>{{ $reason_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3 col-md-4 mb-2">
            <select class="form-select selectric-select w-100" aria-label="Default select example" id="medfit_status">
                <option value="" {{ (request()->medfit_status == '') ? 'selected' : '' }}>All Med Fit</option>
                <option value="2" {{ (request()->medfit_status == 2) ? 'selected' : '' }}>No</option>
                <option value="1" {{ (request()->medfit_status == 1) ? 'selected' : '' }}>Yes</option>
            </select>
        </div>
    </div>
    <div class="cdt-performance-wrapper">
        <div class="row gx-2">
            <div class="col-xl-5 mb-2">
                <div class="todays-position-wrapper">
                    <h6 class="text-center">TODAY'S POSITION</h6>
                    <div class="row gx-2">
                        <div class="col-lg-9">
                            <div class="chart-wrapper">
                                <h6>PATIENTS BY PATHWAYS</h6>
                                <div id="pathway-patients"></div>
                            </div>
                            <div class="cdt-authority-section">
                                <h6>PATIENTS BY AUTHORITY</h6>
                                <div class="cdt-pathway-wrapper">
                                    <div class="header-pathway">PATHWAY</div>
                                    @php
                                        $firstRow = reset($success_array['patient_by_authority']);
                                    @endphp

                                    <table class="table-cdt-pathway">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach($firstRow as $key => $val)
                                                    <th>{{ strtoupper(substr($key, 0, 4)) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($success_array['patient_by_authority'] as $pathway => $counts)
                                                <tr>
                                                    <td>{{ $pathway }}</td>
                                                    @foreach($firstRow as $key => $val)
                                                        <td onclick="PatientByPathway('{{ $pathway }}', '{{ $key }}', '', 0);" class="cursor_pointer">{{ $counts[$key] ?? 0 }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="cdt-performance-count-wrapper">
                                <div class="rectangle-block-1 mb-lg-2 cursor_pointer click_open_discharge_today_count">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28.377"
                                            height="28.377" viewBox="0 0 28.377 28.377">
                                            <g id="Group_2969" data-name="Group 2969"
                                                transform="translate(0.75 0.75)">
                                                <path id="Path_22199" data-name="Path 22199"
                                                    d="M11.959,29.877H5.986A2.986,2.986,0,0,1,3,26.89V5.986A2.986,2.986,0,0,1,5.986,3h5.973"
                                                    transform="translate(-3 -3)" fill="none"
                                                    stroke="#007af7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22200" data-name="Path 22200"
                                                    d="M16,21.931l7.466-7.466L16,7"
                                                    transform="translate(3.411 -1.027)" fill="none"
                                                    stroke="#007af7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <line id="Line_1" data-name="Line 1" x1="18"
                                                    transform="translate(8.72 14.078)" fill="none"
                                                    stroke="#007af7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                            </g>
                                        </svg>
                                        <h6>CDT DISCHARGE <br> TODAY</h6>
                                        <h4>{{ $success_array['today_discharge'] }}</h4>
                                    </div>
                                </div>
                                <div class="rectangle-block-1 mb-lg-2 cursor_pointer" onclick="PatientByPathway('', '', '', 1);">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30.114"
                                            height="24.135" viewBox="0 0 30.114 24.135">
                                            <g id="Group_2968" data-name="Group 2968"
                                                transform="translate(1.061 1.061)">
                                                <path id="Path_22194" data-name="Path 22194"
                                                    d="M3,12.862,6.931,8.931,3,5"
                                                    transform="translate(-3 -5)" fill="none"
                                                    stroke="#5a54ff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22195" data-name="Path 22195"
                                                    d="M3,21.862l3.931-3.931L3,14"
                                                    transform="translate(-3 0.152)" fill="none"
                                                    stroke="#5a54ff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22196" data-name="Path 22196"
                                                    d="M10,6H27.3"
                                                    transform="translate(1.007 -4.428)" fill="none"
                                                    stroke="#5a54ff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22197" data-name="Path 22197"
                                                    d="M10,12H27.3"
                                                    transform="translate(1.007 -0.993)" fill="none"
                                                    stroke="#5a54ff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22198" data-name="Path 22198"
                                                    d="M10,18H27.3"
                                                    transform="translate(1.007 2.441)" fill="none"
                                                    stroke="#5a54ff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                            </g>
                                        </svg>
                                        <h6>TOTAL <br> ON CDT LIST <br> (MFFD)</h6>
                                        <h4>{{ $success_array['cdt_approved'] }}</h4>
                                    </div>
                                </div>
                                <div class="rectangle-block-1 cursor_pointer click_open_cdt_pending_coount">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="29.5"
                                            height="29.5" viewBox="0 0 29.5 29.5">
                                            <g id="Group_2970" data-name="Group 2970"
                                                transform="translate(1.03 0.433)">
                                                <rect id="Rectangle_16045"
                                                    data-name="Rectangle 16045" width="28"
                                                    height="28" rx="2"
                                                    transform="translate(-0.28 0.317)" fill="none"
                                                    stroke="#007af7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22201" data-name="Path 22201"
                                                    d="M8,7V17.867"
                                                    transform="translate(-0.238 -0.581)" fill="none"
                                                    stroke="#007af7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22202" data-name="Path 22202"
                                                    d="M12,7v6.209"
                                                    transform="translate(1.971 -0.581)" fill="none"
                                                    stroke="#007af7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                                <path id="Path_22203" data-name="Path 22203"
                                                    d="M16,7V20.971"
                                                    transform="translate(4.181 -0.581)" fill="none"
                                                    stroke="#007af7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5" />
                                            </g>
                                        </svg>
                                        <h6>TOTAL PENDING <br> (REFERRAL / <br
                                                class="d-none d-lg-block"> REVIEW)</h6>
                                        <h4>{{ $success_array['cdt_awaiting'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 mb-2">
                <div class="row gx-2 mb-2">
                    <div class="col-lg-7">
                        <div class="delay-reasons-section">
                            <table class="table-delay-reasons">
                                <thead>
                                    <tr>
                                        <th colspan="2">DELAY REASONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($success_array['patient_by_reason']  as $reason_id => $patient_count)
                                        <tr>
                                            <td>{{ $success_array['reason_list'][$reason_id] ?? '' }}</td>
                                            <td onclick="PatientByPathway('', '', '{{ $reason_id }}', 0);" class="cursor_pointer">{{ $patient_count }}</td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="chart-wrapper">
                            <h6 class="text-center">CDT WEEKLY DISCHARGE</h6>
                            <div id="pathway-patients-weekly"></div>
                        </div>
                    </div>
                </div>
                <div class="cdt-patient-details-wrapper">
                    <div class="rectangle-block-1">
                        <div class="col-lg-12">
                            <div
                                class="d-flex justify-content-between align-items-center rectangle-block-2">
                                <p class="mb-0">PATIENTS DETAILS</p>
                                <a  target="_blank" href="{{ route('discharged.performance.cdt.export') }}?ward_id={{ request()->has('ward_id') ? implode(',', (array) request()->ward_id) : '' }}&medfit_status={{ request()->medfit_status }}&reason_code_id={{ request()->reason_code_id }}" class="btn btn-export"><img
                                        src="{{asset('asset_v2/Template/icons/export.svg') }}" alt="" class="me-2"
                                        width="14">Export</a>
                            </div>
                        </div>
                    </div>
                    <div class="cdt-patient-details">
                        @foreach ($success_array['patient_list'] as $ward_name => $patient_list)
                        <div class="name-header">
                            <span>{{ $ward_name }}</span>
                        </div>
                        <table class="responsiveTable table-cdt-patient-details">
                            <tbody class="table-patient-tbody">
                                @foreach ($patient_list as $patient)
                                    <tr class="patient-data-row">
                                        <td class="pivoted">
                                            <div class="tdBefore">Bay &amp; Bed</div>
                                            <span>{{ $patient['bed_name'] }}</span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Hospital Number</div>
                                            <span>{{ $patient['pas_id'] }}</span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Patient Name</div>
                                            <span>{{ $patient['patient_name'] }}</span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Total LOS</div>
                                            <span>{{ $patient['los'] }}</span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">LOS Since Med Fit</div>
                                            <span>{{ $patient['los_since_medfit'] }}</span>
                                        </td>

                                        <td class="pivoted">
                                            <div class="tdBefore">Pathway</div>
                                            <span>{{ $patient['pathway'] }}</span>
                                        </td>
                                        <td class="pivoted">
                                            <div class="tdBefore">Reason Code</div>
                                            <span>{{ $patient['reason'] }} </span>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var options = {
    series: [{
        name: '',
        data: {!! json_encode(array_values($success_array['discharges_this_week'])) !!}
    }, ],
    chart: {
        toolbar: {
            show: false,
        },
        type: 'bar',
        height: 180,
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
    colors: ['#0066FF', '#0066FF'],
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
        categories: {!! json_encode(array_keys($success_array['discharges_this_week'])) !!},
        labels: {
            show: true,
            style: {
                fontWeight: 600,
                fontSize: 8
            },
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors: ['#0066FF', '#0066FF'], // optional, if not defined - uses the shades of same color in series
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 100],
            colorStops: []
        }
    },
    legend: {
        show: false,
        position: 'right',
        offsetX: 0,
        offsetY: 50
    },
};
if (document.querySelector("#pathway-patients-weekly")) {
    var chart = new ApexCharts(document.querySelector("#pathway-patients-weekly"), options);
    chart.render();
}
</script>
<script>

    var options = {
        series: [{
            name: '',
            data: {!! json_encode(array_values($success_array['patient_by_pathway'])) !!}
        }, ],
        chart: {
            toolbar: {
                show: false,
            },
            type: 'bar',
            height: 180,
            stacked: true,
            fontFamily: 'Poppins, sans-serif',
            events: {
                dataPointSelection: function(event, chartContext, config) {
                    const category = config.w.globals.labels[config.dataPointIndex];
                    const value = config.w.config.series[config.seriesIndex].data[config.dataPointIndex];
                    PatientByPathway(category, '', '', 0)
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
        colors: ['#0066FF', '#0066FF'],
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
            categories: {!! json_encode(array_keys($success_array['patient_by_pathway'])) !!},
            labels: {
                show: true,
                style: {
                    fontWeight: 600,
                    fontSize: 8
                },
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.5,
                gradientToColors: ['#0066FF', '#0066FF'], // optional, if not defined - uses the shades of same color in series
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 100],
                colorStops: []
            }
        },
        legend: {
            show: false,
            position: 'right',
            offsetX: 0,
            offsetY: 50
        },
    };
    if (document.querySelector("#pathway-patients")) {
        var chart = new ApexCharts(document.querySelector("#pathway-patients"), options);
        chart.render();
    }
</script>
