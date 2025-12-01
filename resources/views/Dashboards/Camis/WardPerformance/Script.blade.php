<script>
    date_list = {!! json_encode(array_reverse($success_array['last_30_days'])) !!};
    var options = {


            series: [{
                    name: "Patient By LOS 7 To 13 Days",
                    data: {!! json_encode(array_reverse(array_values($success_array["7_13_patients_los"]))) !!},
                    color: "#008000"
                },
                {
                    name: "Patient By LOS 14 To 20 Days",
                    data: {!! json_encode(array_reverse(array_values($success_array["14_20_patients_los"]))) !!},
                    color: "#FFA500"
                },
                {
                    name: "Patient By LOS 21+ Days",
                    data: {!! json_encode(array_reverse(array_values($success_array["20_over_patients_los"]))) !!},
                    color: "#FF0000"
                }
            ],
            chart: {
                toolbar: {
                show: false,
            },
            height: 297,
            type: 'line',
                    fontFamily: 'Poppins, sans-serif',
            zoom: {
                enabled: false
            }
            },

            dataLabels: {
            enabled: false
            },
            stroke: {
            curve: 'straight'
            },
            grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.5
            },
            },
            xaxis: {
            categories: date_list,
            }
            };

            if (document.querySelector("#ward-data")) {
        var chart = new ApexCharts(document.querySelector("#ward-data"), options);
        chart.render();
    }



    var options = {
          series: [{
          name: 'Patients',
          data: {!! json_encode(array_values($success_array["total_los_daywise"])) !!}
        }, ],
          chart: {
                  toolbar: {
            show: false,
        },
          type: 'bar',
            fontFamily: 'Poppins, sans-serif',
          height: 150
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['0-4', '5-6', '7-14', '15-21', '22+'],
        },
        yaxis: {
          title: {
            text: ' (Patients)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return " " + val + " Patients"
            }
          }
        }
        };

        if (document.querySelector("#patients-data")) {
    var chart = new ApexCharts(document.querySelector("#patients-data"), options);
    chart.render();
        }
</script>
