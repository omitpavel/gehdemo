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
                },
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
      <div class="card-table mb-lg-2">
        <div class="red-reasons-performance-data">
          <div class="rectangle-block-1">
            <div class="col-lg-12">
              <div class="d-flex justify-content-between align-items-center rectangle-block-2">
                <p class="mb-0">Patients Details </p>
                <button type="button" class="btn btn-export" id="red_patient_export_filter"><img src="{{ asset('asset_v2/Template/icons/export.svg') }}" alt="" class="me-2" width="14">Export</button>
              </div>
            </div>
          </div>
          <div class="red-reasons-patient-details red_bed_performance_patient_list">
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
                <tbody>
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
