// var admitted_non_admitted_barchart_options = {
// colors: ['#9DB6CD'],
// tooltip: { enabled: false, },
// fill: { type: 'gradient', gradient: { shade: 'light', type: "horizontal", shadeIntensity: 1, gradientToColors: ['#9DB6CD'], inverseColors: true, opacityFrom: 0.5, opacityTo: 1, stops: [0, 95, 100], colorStops: [] }, },
// chart: { toolbar: { show: false, }, height: 200, type: 'bar', fontFamily: 'Poppins, sans-serif' },
// plotOptions: { bar: { borderRadius: 1, dataLabels: { position: 'top', }, } },
// grid: { show: true, xaxis: { lines: { show: false } }, yaxis: { lines: { show: false } }, },
// labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12+"],
// dataLabels: { enabled: true, formatter: function(val) { if (val > 0) { return val } }, offsetY: 3, style: { fontSize: '11px', colors: ["#000000"] } },
// xaxis: { type: 'Number', position: 'bottom', axisBorder: { show: true, color: '#707070', height: 1, }, axisTicks: { show: true, borderType: 'solid', color: '#707070', }, crosshairs: { fill: { type: 'gradient', gradient: { colorFrom: '#70C7CB', colorTo: '#0E555D', stops: [0, 100], opacityFrom: 0.4, opacityTo: 0.5, } } }, tooltip: { enabled: false, } },
// yaxis: { type: 'Number', position: 'left', axisBorder: { show: true, color: '#707070', height: 1, }, axisTicks: { show: false, borderType: 'solid', color: '#707070', }, labels: { show: false, formatter: (value) => { return value.toFixed(0) }, } },
// };

//new chart
var admitted_non_admitted_barchart_options = {
    // Ambulance dashboard Column chart-1
    colors: ['#9DB6CD'],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.6,
            gradientToColors: ['#C2DAF2'], // optional, if not defined - uses the shades of same color in series
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 95, 100],
            colorStops: []
        },
    },
    chart: {
        toolbar: {
            show: false,
        },
        height: 200,
        type: 'bar',
        fontFamily: 'Poppins, sans-serif'
    },
    plotOptions: { bar: { borderRadius: 1, dataLabels: { position: 'top', }, } },
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
        },
    },
    dataLabels: { enabled: true, formatter: function(val) { if (val > 0) { return val } }, offsetY: 3, style: { fontSize: '11px', colors: ["#000000"] } },
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12+"],
    xaxis: {
        type: 'Number',
        position: 'bottom',
        axisBorder: {
            show: true,
            color: '#707070',
            height: 1,
        },
        axisTicks: {
            show: true,
            borderType: 'solid',
            color: '#707070',

        },
        tooltip: {
            enabled: true,
        },
        title: {
            text: 'Hours in dept from arrival to departure', // X-axis title
            style: {
                fontSize: '12px',
                fontWeight: '500',
                color: '#304758',
            },
        },
    },
    yaxis: {
        tickAmount: 5,
        axisBorder: {
            show: true,
            color: '#707070',
        },
        axisTicks: {
            show: true,
            borderType: 'solid',
            color: '#707070',
            width: 6,

        },
        labels: {
            show: false,
            formatter: function(val) {
                return val + " ";
            }
        },
        title: {
            text: 'Patients', // Y-axis title
            style: {
                fontSize: '12px',
                fontWeight: '500',
                color: '#304758',
            },
        },

    },


}


// old chart

var admitted_non_admitted_box_plot_options = {
    chart: {
        toolbar: {
            show: false,
        },
        type: 'boxPlot',
        fontFamily: 'Poppins, sans-serif',
        height: 200
    },
    plotOptions: {
        bar: {
            horizontal: true,
            barHeight: '30%'
        },
        boxPlot: {
            colors: {
                upper: '#0066FF',
                lower: '#0066FF'
            }
        },
    },
    stroke: {
        colors: ['#000000']
    },
    grid: {
        show: true,
        borderColor: '#90A4AE',
        strokeDashArray: 0,
        position: 'back',
        xaxis: {
            lines: {
                show: false
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        },
    },
    xaxis: {
        tickAmount: 7,
        min: 0,
        axisBorder: {
            show: true,
            color: '#707070',
            height: 1,
            width: '100%',
            offsetX: 0,
            offsetY: 0
        },
        axisTicks: {
            show: true,
            borderType: 'solid',
            color: '#707070',
            height: 6,
            offsetX: 0,
            offsetY: 0
        },
        labels: {
            formatter: (value) => {
                return value.toFixed(0)
            },
        }
    },
    yaxis: {
        axisBorder: {
            show: true,
            color: '#707070',
            offsetX: 0,
            offsetY: 0
        },
        axisTicks: {
            show: true,
            borderType: 'solid',
            color: '#707070',
            width: 6,
            offsetX: 0,
            offsetY: 0
        },
    }
};

var ambulance_arrival_hourly_graph_options = {

    plotOptions: {
        bar: {
            borderRadius: 3
        }
    },
    colors: ['#9DB6CD', '#00C5D6'],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.6,
            gradientToColors: ['#C2DAF2'], // optional, if not defined - uses the shades of same color in series
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 95, 100],
            colorStops: []
        },
    },
    chart: {
        toolbar: {
            show: false,
        },
        height: 300,
        type: 'line',
        fontFamily: 'Poppins, sans-serif',
    },

    stroke: {
        width: [0, 2]
    },
    legend: {
        show: false,
    },
    grid: {
        show: false,
    },

    dataLabels: {
        enabled: true,
        enabledOnSeries: [0],
        formatter: function(val) {
            if (val > 0) {
                return val + " ";
            }
        },
        offsetY: 3,
        style: {
            fontSize: '11px',
            colors: ["#000000"]
        }
    },
    markers: {
        size: 5,
        colors: '#FFFFFF',
        strokeColors: '#00C5D6',
        strokeWidth: 1,
    },
    labels: ['00hr','01hr', '02hr', '03hr', '04hr', '05hr', '06hr', '07hr', '08hr', '09hr', '10hr', '11hr', '12hr', '13hr', '14hr', '15hr', '16hr', '17hr', '18hr', '19hr', '20hr', '21hr', '22hr', '23hr'],
    xaxis: {
        lines: {
            show: false,
        },
        type: 'Number'
    },
    yaxis: {
        labels: {
            formatter: (value) => {
                return value.toFixed(0)
            },
        }
    }
};


//new dount chart
var admitted_breach_non_admitted_dount_chart_options = {
    series: [44, 56],
    labels: ['Breaches', 'Total'],
    chart: {
        type: 'donut',
        fontFamily: 'Poppins, sans-serif',
        height: '150px'
    },
    colors: ['#C8E0F8', '#00CBDD'],
    plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 270
        }
    },
    dataLabels: {
        enabled: false
    },
    fill: {
        type: 'gradient',
        colors: ['#C8E0F8', '#00CBDD'],
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors: ['#8CA5BC', '#00666F'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,

        }
    },
    legend: {
        show: false,
        position: 'top',
        horizontalAlign: 'left',


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
