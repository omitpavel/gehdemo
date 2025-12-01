<input type="hidden" id="task_category" value="2">
<input type="hidden" id="filtered_task_id" value="">
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <div class="sticky-toprow" id="stickyToprow">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_today_dashboard_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_today_dashboard_view') }}"
                            onclick="DischargeDay('today');" data-bs-toggle="tab" href="#dischargeToday">
                            <div class="tab-active">D/P Discharge Today
                            </div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_tomorrow_dashboard_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_tomorrow_dashboard_view') }}"
                            data-bs-toggle="tab" href="#dischargeTomorrow" onclick="DischargeDay('tomorrow');">
                            <div class="tab-active">D/P Discharge {{ $success_array['tomorrow'] }}</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_day_after_tomorrow_dashboard_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_day_after_tomorrow_dashboard_view') }}"
                            data-bs-toggle="tab" href="#dischargeDayAfterTomorrow"
                            onclick="DischargeDay('day_after_tomorrow');">
                            <div class="tab-active">D/P Discharge {{ $success_array['day_after_tommrow'] }}</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_missed_discharged_view') }}">
                        <a class="tab-custom-btn  {{ DisabledButtonOnRolePermission('pd_dashboard_missed_discharged_view') }}"
                            data-bs-toggle="tab" href="#dischargeDayAfterTomorrow"
                            onclick="MissedDischarged('1', '0');">
                            <div class="tab-active">Failed Discharges</div>
                        </a>
                    </li>
                    <li class="mb-2 {{ PermissionDeniedDiv('pd_dashboard_missed_discharges_performance_view') }}">
                        <a class="tab-custom-btn active {{ DisabledButtonOnRolePermission('pd_dashboard_missed_discharges_performance_view') }}"
                            data-bs-toggle="tab" href="#dischargeDayAfterTomorrow"
                            onclick="FailedDischargesPerformance('{{ date('Y-m-d') }}', '{{ date('Y-m-d') }}', 1, 1);">
                            <div class="tab-active">Failed Discharges Performances</div>
                        </a>
                    </li>
                </ul>
            </div>


            <div class="tab-content" id="tabcontent">
                <div id="dischargeToday" class=" tab-pane active">
                    <div class="failed-performance-wrapper">
                        <div class="discharge-count-row">
                            <div class="discharge-count-col-2">
                                <div class="grey-count-box">
                                    <label for="" class="mb-1">Select Date</label>
                                    <div class="card-date w-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="cyan-circle text-center me-2">
                                                    <i class="bi bi-calendar3 "></i>
                                                </div>
                                                <div class="date-box w-90">
                                                    <input type="text" name="datepicker"
                                                        id="failed_date_range_picker"
                                                        placeholder="20th Dec 2025 - 31st Dec 2025"
                                                        class="hasDatepicker">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="discharge-count-col-2">
                                <div class="">
                                    <div class="planned-counts" id="pdDischargeSection">
                                        <button id="definiteButton" type="button"
                                            class="btn btn-primary-grey mb-1 performance_pd_count_definite @if ($success_array['definite_status'] == 1) active @endif
                                            me-2"
                                            data-type="definite"><span class="btn-name">Definite <br> Discharges
                                                Failed</span>
                                            <h5>{{ $success_array['total_definite'] }}</h5>
                                        </button>
                                        <button id="potentialButton" type="button"
                                            class="btn btn-primary-grey performance_pd_count_potential @if ($success_array['potential_status'] == 1) active @endif
                                        "
                                            data-type="potential"><span class="btn-name">Potential <br>
                                                Discharges Failed</span>
                                            <h5>{{ $success_array['total_potential'] }}</h5>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="discharge-count-col-1">
                                <div class="grey-count-box">
                                    <h5>18</h5>
                                    <h6>Total Discharges</h6>
                                </div>
                            </div> -->
                            <div class="discharge-count-col-1">
                                <div class="grey-count-box">
                                    <h5>{{ $success_array['total_failed_discharge'] }}


                                        {{-- $success_array['total_failed_discharges'] --}}
                                        {{-- ({{ $success_array['failed_discharge_percentage'] }}%) --}}</h5>
                                    <h6>Total Failed Discharges</h6>
                                </div>
                            </div>
                            <div class="discharge-count-col-1">
                                <div class="grey-count-box">
                                    <h5>{{ $success_array['total_lost_days'] }}</h5>
                                    <h6>Total Days Lost</h6>
                                </div>
                            </div>
                            <div class="discharge-count-col-1">
                                <div class="grey-count-box">
                                    <h5>{{ round($success_array['avg_lost_days']) }}</h5>
                                    <h6>Average Days Lost</h6>
                                </div>
                            </div>
                            <div class="discharge-count-col-2">
                                <div class="grey-count-box">
                                    <h5>{{ $success_array['most_common_reason'] }}</h5>
                                    <h6>Most Common reason</h6>
                                </div>
                            </div>
                        </div>






                        <div class="row g-2">
                            <div class="col-lg-4">
                                <div class="card-chart-container">
                                    <div class="title">
                                        <h6>PATIENTS BY GROUP</h6>
                                    </div>
                                    <div id="patientGroupChart"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-chart-container">
                                    <div class="title">
                                        <h6>DAYS LOST PER GROUP</h6>
                                    </div>
                                    <div id="daysGroupChart"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-chart-container">
                                    <div class="title">
                                        <h6>FAILED DISCHARGES PER GROUP</h6>
                                    </div>
                                    <div id="failedDischargesChart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="sub-reasons-wrapper">
                            <div class="row gx-2">
                                <div class="col-xl-8">
                                    <div class="bg-white-table">
                                        <table class="responsiveTable table-failed-reasons">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">FAILED DISCHARGES BY SUB-REASON
                                                    </th>
                                                    <th>Patients</th>
                                                    <th>Days Lost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($success_array['failed_patient_by_subcategory'] as $category => $subReasons)
                                                    @foreach ($subReasons as $reason => $vals)
                                                        <tr>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Category</div>
                                                                {{ $category }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Sub-Reason</div>
                                                                {{ $reason }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Patients</div>
                                                                {{ $vals['patients'] ?? 0 }}
                                                            </td>
                                                            <td class="pivoted">
                                                                <div class="tdBefore">Days Lost</div>
                                                                {{ $vals['delay_days'] ?? 0 }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @empty
                                                    <tr class="custom_not_found">
                                                        <td>
                                                            <div>{{ NotFoundMessage() }}</div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="bg-white-table">
                                        <table class="responsiveTable table-failed-count">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Patients</th>
                                                    <th>Days Lost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($success_array['patient_by_ward'] as $ward_type => $patient_by_ward)
                                                    <tr>
                                                        <td class="pivoted">
                                                            <div class="tdBefore"></div>
                                                            {{ ucfirst($ward_type) }} Wards
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Patients</div>
                                                            {{ $patient_by_ward['patients'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Days Lost
                                                            </div>
                                                            {{ $patient_by_ward['delay_days'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sub-reasons-details-wrapper">
                            <div class="row gx-2">
                                <div class="col-12">
                                    <div class="bg-white-table">
                                        <table class="responsiveTable table-failed-reasons-details">
                                            <thead>
                                                <tr>
                                                    <th>Patient ID</th>
                                                    <th>P/D Discharge Date</th>
                                                    <th>Discharge Date</th>
                                                    <th>Wards</th>
                                                    <th>Bay & Bed</th>
                                                    <th>Days Lost</th>
                                                    <th>Reason Category</th>
                                                    <th>Subreason</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse  ($success_array['all_failed_patients'] as $patient)
                                                    <tr>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Hospital Number
                                                            </div>
                                                            {{ $patient['pas_number'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">P/D Discharge
                                                                Date</div>
                                                            {{ $patient['pd_type'] }} -
                                                            {{ $patient['potential_definite_date'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Discharge Date
                                                            </div>
                                                            {{ $patient['discharge_date'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Wards
                                                            </div>
                                                            {{ $patient['ward'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Bay & Bed
                                                            </div>
                                                            {{ $patient['bed'] }}
                                                        </td>

                                                        <td class="pivoted">
                                                            <div class="tdBefore">Days Lost
                                                            </div>
                                                            {{ $patient['lost_days_row'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Reason Category
                                                            </div>
                                                            {{ $patient['main_reason'] }}
                                                        </td>
                                                        <td class="pivoted">
                                                            <div class="tdBefore">Subreason
                                                            </div>
                                                            {{ $patient['sub_reason'] }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr class="no-records-row">
                                                        <td colspan="8" class="no-records-cell">
                                                            No records found
                                                        </td>
                                                    </tr>
                                                @endforelse

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
<script src="{{ asset('asset_v2/Template/js/apexcharts.js') }}"></script>
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1025 && windowWidth < 1200) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '250px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function(header) {
                    header.style.top = '250px';
                })
            }
        } else {
            document.getElementById("stickyToprow").style.top = "60px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '250px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function(header) {
                    header.style.top = '250px';
                })
            }
        }
        if (document.getElementById("stickyToprow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector('.custom_not_found');
                noRecords.style.marginTop = '210px';
            }
        }
    } else if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementById("stickyToprow").style.top = "85px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '195px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function(header) {
                    header.style.top = '195px';
                })
            }
        } else {
            document.getElementById("stickyToprow").style.top = "65px";
            document.getElementById("stickyToprow").style.height = "60px";
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector('.bg-sticky');
                bgSticky.style.top = '185px';
                var stickyHeader = document.querySelectorAll('.sticky-header');
                stickyHeader.forEach(function(header) {
                    header.style.top = '185px';
                })
            }
        }
        if (document.getElementById("stickyToprow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector('.custom_not_found');
                noRecords.style.marginTop = '100px';
            }
        }
    }
    $(document).ready(function() {
        if ($("#marquee-content").length === 0 && window.innerWidth >= 1026) {
            $(".failed-performance-wrapper .discharge-count-row")
                .css("top", "117px");
        }
    });
</script>


<script>
    (function() {
        if (window.__patientChart) {
            try {
                window.__patientChart.destroy();
            } catch (e) {}
        }
        if (window.__daysChart) {
            try {
                window.__daysChart.destroy();
            } catch (e) {}
        }
        if (window.__failedChart) {
            try {
                window.__failedChart.destroy();
            } catch (e) {}
        }

        const cats = @json($success_array['categories'] ?? []);
        const patients = @json($success_array['patients_series'] ?? []);
        const days = @json($success_array['days_series'] ?? []);
        const failed = @json($success_array['failed_series'] ?? []);
        const valid_failed_data = failed
            .map((val, i) => ({
                value: val,
                label: cats[i]
            }))
            .filter(item => item.value > 0);
        const GOLDEN_ANGLE = 137.508;
        const MIN_HUE_DELTA = 18;
        const usedHues = [];
        const colorMap = new Map();

        function hashCode(str) {
            let h = 0;
            for (let i = 0; i < str.length; i++) {
                h = ((h << 5) - h) + str.charCodeAt(i);
                h |= 0;
            }
            return Math.abs(h);
        }

        function hsl(h, s, l) {
            return `hsl(${h}, ${s}%, ${l}%)`;
        }

        function pickDistinctHue(seedHue) {
            let hue = seedHue % 360;
            let tries = 0;

            function isFarEnough(h) {
                return usedHues.every(u => {
                    const d = Math.abs(h - u);
                    const wrap = Math.min(d, 360 - d);
                    return wrap >= MIN_HUE_DELTA;
                });
            }

            while (!isFarEnough(hue) && tries < 360) {
                hue = (hue + GOLDEN_ANGLE) % 360;
                tries++;
            }
            usedHues.push(hue);
            return hue;
        }

        function colorFor(label) {
            if (colorMap.has(label)) return colorMap.get(label);

            const baseHue = hashCode(label) % 360;
            const hue = pickDistinctHue(baseHue);
            const s = 65,
                l = 50;
            const col = hsl(hue, s, l);
            colorMap.set(label, col);
            return col;
        }

        const distColors = (cats || []).map(label => colorFor(label));

        (function() {
            const el = document.querySelector("#patientGroupChart");
            if (!el) return;
            const options = {
                series: [{
                    data: patients
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        distributed: true,
                        borderRadius: 2
                    }
                },
                colors: distColors,
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                grid: {
                    show: true,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                xaxis: {
                    categories: cats,
                    axisBorder: {
                        show: true,
                        color: '#707070',
                        height: 1,
                        width: '100%'
                    },
                    axisTicks: {
                        show: false
                    }
                },
                tooltip: {
    custom: function({ series, seriesIndex, dataPointIndex, w }) {

        const label = w.globals.labels[dataPointIndex];           // category name
        const val   = series[seriesIndex][dataPointIndex];        // value
        const color = w.globals.colors[dataPointIndex];           // distributed bar color

        return `
          <div style="
              background: ${color};
              color: #fff;
              padding: 8px 12px;
              border-radius: 4px;
              font-family: Poppins, sans-serif;
              font-size: 12px;
              box-shadow: 0 2px 8px rgba(0,0,0,0.18);
          ">
            ${label} : ${val} Patients
          </div>
        `;
    }
}



            };
            window.__patientChart = new ApexCharts(el, options);
            window.__patientChart.render();
        })();

        (function() {
            const el = document.querySelector("#daysGroupChart");
            if (!el) return;
            const options = {
                series: [{
                    data: days
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        distributed: true,
                        borderRadius: 2
                    }
                },
                colors: distColors,
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                grid: {
                    show: true,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                xaxis: {
                    categories: cats,
                    axisBorder: {
                        show: true,
                        color: '#707070',
                        height: 1,
                        width: '100%'
                    },
                    axisTicks: {
                        show: false
                    }
                },
                tooltip: {
    custom: function({ series, seriesIndex, dataPointIndex, w }) {

        const label = w.globals.labels[dataPointIndex];
        const val   = series[seriesIndex][dataPointIndex];
        const color = w.globals.colors[dataPointIndex];

        return `
          <div style="
              background: ${color};
              color: #fff;
              padding: 8px 12px;
              border-radius: 4px;
              font-family: Poppins, sans-serif;
              font-size: 12px;
              box-shadow: 0 2px 8px rgba(0,0,0,0.18);
          ">
            ${label} : ${val} Days
          </div>
        `;
    }
}


            };
            window.__daysChart = new ApexCharts(el, options);
            window.__daysChart.render();
        })();

        (function() {
            const el = document.querySelector("#failedDischargesChart");
            if (!el) return;
            const options = {
                series: valid_failed_data.map(item => item.value),
                labels: valid_failed_data.map(item => item.label),
                chart: {
                    type: 'donut',
                    height: 370,
                    fontFamily: 'Poppins, sans-serif'
                },
                colors: distColors,
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 270
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '13px',
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 3,
                    },
                    labels: {
                        useSeriesColors: true,
                    },
                    itemMargin: {
                        vertical: 4
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + ' Patients';
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 320
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            window.__failedChart = new ApexCharts(el, options);
            window.__failedChart.render();
        })();
    })();
</script>
