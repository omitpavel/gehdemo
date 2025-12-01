
//   AMBULANCE DASHBOARD - LIVE CHARTS START -

// Ambulance dashboard Box plot chart apexcharts.js
var options = {
  series: [{
      data: [{
              x: '',
              y: [40, 100, 390, 650, 680]
          },

      ]
  }],
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
              upper: '#00D0E2',
              lower: '#00D0E2'
          }
      },

  },
  stroke: {
      colors: ['#6c757d']
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

      min: 00,
      max: 700,
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
if (document.querySelector("#boxplot1")) {
  var chart = new ApexCharts(document.querySelector("#boxplot1"), options);
  chart.render();
}

var options = {
  series: [{
      data: [{
              x: '',
              y: [40, 100, 390, 650, 680]
          },

      ]
  }],
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
              upper: '#00D0E2',
              lower: '#00D0E2'
          }
      },

  },
  stroke: {
      colors: ['#6c757d']
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

      min: 00,
      max: 700,
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
if (document.querySelector("#boxplot2")) {
  var chart = new ApexCharts(document.querySelector("#boxplot2"), options);
  chart.render();
}

var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot3")) {
    var chart = new ApexCharts(document.querySelector("#boxplot3"), options);
    chart.render();
  }

  var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot4")) {
    var chart = new ApexCharts(document.querySelector("#boxplot4"), options);
    chart.render();
  }
// Ambulance dashboard  Donut Chart

var options = {
  series: [44, 55],
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
      colors: ['#C8E0F8','#00CBDD' ],
      gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.5,
          gradientToColors:  ['#8CA5BC','#00666F'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
      
      }
  },
  legend: {
    show:false,
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
if (document.querySelector("#donut1")) {
  var chart = new ApexCharts(document.querySelector("#donut1"), options);
  chart.render();
}

var options = {
  series: [44, 85],
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
      colors: ['#C8E0F8','#00CBDD' ],
      gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.5,
          gradientToColors: ['#8CA5BC','#00666F'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
       
      }
  },
  legend: {
    show:false,
      position: 'top'
  },
  responsive: [{
      breakpoint: 480,
      options: {
          chart: {
              width: 320
          },
          legend: {
              position: 'bottom',
              horizontalAlign: 'left',
          }
      }
  }]
};
if (document.querySelector("#donut2")) {
  var chart = new ApexCharts(document.querySelector("#donut2"), options);
  chart.render();
}

// Ambulance dashboard Combo chart

var options = {
  series: [{
      name: '',
      type: 'column',
      data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160],

  }, {
      name: '',
      type: 'line',
      data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],

  }],
  plotOptions: {
      bar: {
          borderRadius: 3,

      }
  },
  colors: ['#9DB6CD', '#000000'],
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
      enabled: false,
      enabledOnSeries: [1]
  },
  markers: {
      size: 5,
      colors: '#FFFFFF',
  },
  labels: ['01hr', '02hr', '03hr', '04hr', '05hr', '06hr', '07hr', '08hr', '09hr', '10hr', '11hr', '12hr'],
  xaxis: {
      lines: {
          show: false,
      },
      type: 'Number'
  },
  yaxis: [{
      lines: {
          show: false,
      }

  }, {
      show: false,
      opposite: true,

  }]
};
if (document.querySelector("#combochart")) {
  var chart = new ApexCharts(document.querySelector("#combochart"), options);
  chart.render();
}

// Ambulance dashboard Column chart-1


var options = {
  series: [{
      name: '',
      data: [00, 04, 03, 01, 05, 01, 00, 01, 04, 00, 00]
  }],
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
  plotOptions: {
      bar: {
          borderRadius: 3,
          dataLabels: {
              position: 'top', // top, center, bottom
          },
      }
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
      },
  },
  dataLabels: {
      enabled: true,
      formatter: function(val) {
          return val + " ";
      },
      offsetY: -20,
      style: {
          fontSize: '12px',
          colors: ["#304758"]
      }
  },
  labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],

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
      }
  },
  yaxis: {

      min: 00,
      max: 05,
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
      }

  },

};
if (document.querySelector("#columnchart1")) {
  var chart = new ApexCharts(document.querySelector("#columnchart1"), options);
  chart.render();
}
// Ambulance dashboard Column chart-2

var options = {
  series: [{
      name: '',
      data: [00, 04, 03, 01, 05, 01, 00, 01, 03, 00, 00]
  }],
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
  plotOptions: {
      bar: {
          borderRadius: 3,
          dataLabels: {
              position: 'top', // top, center, bottom
          },
      }
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
      },
  },
  dataLabels: {
      enabled: true,
      formatter: function(val) {
          return val + " ";
      },
      offsetY: -20,
      style: {
          fontSize: '12px',
          colors: ["#304758"]
      }
  },

  labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],

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
      crosshairs: {
          fill: {
              type: 'gradient',
              gradient: {
                  colorFrom: '#70C7CB',
                  colorTo: '#0E555D',
                  stops: [0, 100],
                  opacityFrom: 0.4,
                  opacityTo: 0.5,
              }
          }
      },
      tooltip: {
          enabled: true,
      }
  },
  yaxis: {
      min: 0,
      max: 5,
      tickAmount: 5,
      type: 'Number',
      position: 'left',
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
      labels: {
          show: false,
          formatter: function(val) {
              return val + " ";
          }
      }

  },

};
if (document.querySelector("#columnchart2")) {
  var chart = new ApexCharts(document.querySelector("#columnchart2"), options);
  chart.render();
}

//   AMBULANCE DASHBOARD - LIVE CHARTS END -


//   AMBULANCE DASHBOARD - LAST WEEK CHARTS START -

// Ambulance dashboard Box plot chart apexcharts.js
var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot5")) {
    var chart = new ApexCharts(document.querySelector("#boxplot5"), options);
    chart.render();
  }
  
  var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot6")) {
    var chart = new ApexCharts(document.querySelector("#boxplot6"), options);
    chart.render();
  }
  
  var options = {
      series: [{
          data: [{
                  x: '',
                  y: [40, 100, 390, 650, 680]
              },
    
          ]
      }],
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
                  upper: '#00D0E2',
                  lower: '#00D0E2'
              }
          },
    
      },
      stroke: {
          colors: ['#6c757d']
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
    
          min: 00,
          max: 700,
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
    if (document.querySelector("#boxplot7")) {
      var chart = new ApexCharts(document.querySelector("#boxplot7"), options);
      chart.render();
    }
  
    var options = {
      series: [{
          data: [{
                  x: '',
                  y: [40, 100, 390, 650, 680]
              },
    
          ]
      }],
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
                  upper: '#00D0E2',
                  lower: '#00D0E2'
              }
          },
    
      },
      stroke: {
          colors: ['#6c757d']
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
    
          min: 00,
          max: 700,
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
    if (document.querySelector("#boxplot8")) {
      var chart = new ApexCharts(document.querySelector("#boxplot8"), options);
      chart.render();
    }
  // Ambulance dashboard  Donut Chart
  
  var options = {
    series: [44, 55],
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
        colors: ['#C8E0F8','#00CBDD' ],
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors:  ['#8CA5BC','#00666F'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
        
        }
    },
    legend: {
      show:false,
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
  if (document.querySelector("#donut3")) {
    var chart = new ApexCharts(document.querySelector("#donut3"), options);
    chart.render();
  }
  
  var options = {
    series: [44, 85],
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
        colors: ['#C8E0F8','#00CBDD' ],
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors: ['#8CA5BC','#00666F'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
         
        }
    },
    legend: {
      show:false,
        position: 'top'
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 320
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'left',
            }
        }
    }]
  };
  if (document.querySelector("#donut4")) {
    var chart = new ApexCharts(document.querySelector("#donut4"), options);
    chart.render();
  }
  
  // Ambulance dashboard Combo chart- 2
  
  var options = {
    series: [{
        name: '',
        type: 'column',
        data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160],
  
    }, {
        name: '',
        type: 'line',
        data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],
  
    }],
    plotOptions: {
        bar: {
            borderRadius: 3,
  
        }
    },
    colors: ['#9DB6CD', '#000000'],
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
        enabled: false,
        enabledOnSeries: [1]
    },
    markers: {
        size: 5,
        colors: '#FFFFFF',
    },
    labels: ['01hr', '02hr', '03hr', '04hr', '05hr', '06hr', '07hr', '08hr', '09hr', '10hr', '11hr', '12hr'],
    xaxis: {
        lines: {
            show: false,
        },
        type: 'Number'
    },
    yaxis: [{
        lines: {
            show: false,
        }
  
    }, {
        show: false,
        opposite: true,
  
    }]
  };
  if (document.querySelector("#combochart2")) {
    var chart = new ApexCharts(document.querySelector("#combochart2"), options);
    chart.render();
  }
  
  // Ambulance dashboard Column chart-3
  
  
  var options = {
    series: [{
        name: '',
        data: [00, 04, 03, 01, 05, 01, 00, 01, 04, 00, 00]
    }],
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
    plotOptions: {
        bar: {
            borderRadius: 3,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
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
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function(val) {
            return val + " ";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],
  
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
        }
    },
    yaxis: {
  
        min: 00,
        max: 05,
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
        }
  
    },
  
  };
  if (document.querySelector("#columnchart3")) {
    var chart = new ApexCharts(document.querySelector("#columnchart3"), options);
    chart.render();
  }
  // Ambulance dashboard Column chart-3
  
  var options = {
    series: [{
        name: '',
        data: [00, 04, 03, 01, 05, 01, 00, 01, 03, 00, 00]
    }],
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
    plotOptions: {
        bar: {
            borderRadius: 3,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
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
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function(val) {
            return val + " ";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
  
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],
  
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
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#70C7CB',
                    colorTo: '#0E555D',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                }
            }
        },
        tooltip: {
            enabled: true,
        }
    },
    yaxis: {
        min: 0,
        max: 5,
        tickAmount: 5,
        type: 'Number',
        position: 'left',
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
        labels: {
            show: false,
            formatter: function(val) {
                return val + " ";
            }
        }
  
    },
  
  };
  if (document.querySelector("#columnchart4")) {
    var chart = new ApexCharts(document.querySelector("#columnchart4"), options);
    chart.render();
  }

//   AMBULANCE DASHBOARD - LAST WEEK CHARTS END -



//   AMBULANCE DASHBOARD - LAST 4 WEEK CHARTS START -


// Ambulance dashboard Box plot chart apexcharts.js
var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot9")) {
    var chart = new ApexCharts(document.querySelector("#boxplot9"), options);
    chart.render();
  }
  
  var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot10")) {
    var chart = new ApexCharts(document.querySelector("#boxplot10"), options);
    chart.render();
  }
  
  var options = {
      series: [{
          data: [{
                  x: '',
                  y: [40, 100, 390, 650, 680]
              },
    
          ]
      }],
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
                  upper: '#00D0E2',
                  lower: '#00D0E2'
              }
          },
    
      },
      stroke: {
          colors: ['#6c757d']
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
    
          min: 00,
          max: 700,
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
    if (document.querySelector("#boxplot11")) {
      var chart = new ApexCharts(document.querySelector("#boxplot11"), options);
      chart.render();
    }
  
    var options = {
      series: [{
          data: [{
                  x: '',
                  y: [40, 100, 390, 650, 680]
              },
    
          ]
      }],
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
                  upper: '#00D0E2',
                  lower: '#00D0E2'
              }
          },
    
      },
      stroke: {
          colors: ['#6c757d']
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
    
          min: 00,
          max: 700,
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
    if (document.querySelector("#boxplot12")) {
      var chart = new ApexCharts(document.querySelector("#boxplot12"), options);
      chart.render();
    }
  // Ambulance dashboard  Donut Chart
  
  var options = {
    series: [44, 55],
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
        colors: ['#C8E0F8','#00CBDD' ],
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors:  ['#8CA5BC','#00666F'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
        
        }
    },
    legend: {
      show:false,
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
  if (document.querySelector("#donut5")) {
    var chart = new ApexCharts(document.querySelector("#donut5"), options);
    chart.render();
  }
  
  var options = {
    series: [44, 85],
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
        colors: ['#C8E0F8','#00CBDD' ],
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors: ['#8CA5BC','#00666F'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
         
        }
    },
    legend: {
      show:false,
        position: 'top'
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 320
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'left',
            }
        }
    }]
  };
  if (document.querySelector("#donut6")) {
    var chart = new ApexCharts(document.querySelector("#donut6"), options);
    chart.render();
  }
  
  // Ambulance dashboard Combo chart- 2
  
  var options = {
    series: [{
        name: '',
        type: 'column',
        data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160],
  
    }, {
        name: '',
        type: 'line',
        data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],
  
    }],
    plotOptions: {
        bar: {
            borderRadius: 3,
  
        }
    },
    colors: ['#9DB6CD', '#000000'],
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
        enabled: false,
        enabledOnSeries: [1]
    },
    markers: {
        size: 5,
        colors: '#FFFFFF',
    },
    labels: ['01hr', '02hr', '03hr', '04hr', '05hr', '06hr', '07hr', '08hr', '09hr', '10hr', '11hr', '12hr'],
    xaxis: {
        lines: {
            show: false,
        },
        type: 'Number'
    },
    yaxis: [{
        lines: {
            show: false,
        }
  
    }, {
        show: false,
        opposite: true,
  
    }]
  };
  if (document.querySelector("#combochart3")) {
    var chart = new ApexCharts(document.querySelector("#combochart3"), options);
    chart.render();
  }
  
  // Ambulance dashboard Column chart-3
  
  
  var options = {
    series: [{
        name: '',
        data: [00, 04, 03, 01, 05, 01, 00, 01, 04, 00, 00]
    }],
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
    plotOptions: {
        bar: {
            borderRadius: 3,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
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
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function(val) {
            return val + " ";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],
  
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
        }
    },
    yaxis: {
  
        min: 00,
        max: 05,
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
        }
  
    },
  
  };
  if (document.querySelector("#columnchart5")) {
    var chart = new ApexCharts(document.querySelector("#columnchart5"), options);
    chart.render();
  }
  // Ambulance dashboard Column chart-3
  
  var options = {
    series: [{
        name: '',
        data: [00, 04, 03, 01, 05, 01, 00, 01, 03, 00, 00]
    }],
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
    plotOptions: {
        bar: {
            borderRadius: 3,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
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
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function(val) {
            return val + " ";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
  
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],
  
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
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#70C7CB',
                    colorTo: '#0E555D',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                }
            }
        },
        tooltip: {
            enabled: true,
        }
    },
    yaxis: {
        min: 0,
        max: 5,
        tickAmount: 5,
        type: 'Number',
        position: 'left',
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
        labels: {
            show: false,
            formatter: function(val) {
                return val + " ";
            }
        }
  
    },
  
  };
  if (document.querySelector("#columnchart6")) {
    var chart = new ApexCharts(document.querySelector("#columnchart6"), options);
    chart.render();
  }

//   AMBULANCE DASHBOARD - LAST 4 WEEK CHARTS END -

//   AMBULANCE DASHBOARD - LAST 1000 ARRIVAL CHARTS START-

// Ambulance dashboard - Box plot chart apexcharts.js
var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot13")) {
    var chart = new ApexCharts(document.querySelector("#boxplot13"), options);
    chart.render();
  }
  
  var options = {
    series: [{
        data: [{
                x: '',
                y: [40, 100, 390, 650, 680]
            },
  
        ]
    }],
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
                upper: '#00D0E2',
                lower: '#00D0E2'
            }
        },
  
    },
    stroke: {
        colors: ['#6c757d']
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
  
        min: 00,
        max: 700,
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
  if (document.querySelector("#boxplot14")) {
    var chart = new ApexCharts(document.querySelector("#boxplot14"), options);
    chart.render();
  }
  
  var options = {
      series: [{
          data: [{
                  x: '',
                  y: [40, 100, 390, 650, 680]
              },
    
          ]
      }],
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
                  upper: '#00D0E2',
                  lower: '#00D0E2'
              }
          },
    
      },
      stroke: {
          colors: ['#6c757d']
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
    
          min: 00,
          max: 700,
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
    if (document.querySelector("#boxplot15")) {
      var chart = new ApexCharts(document.querySelector("#boxplot15"), options);
      chart.render();
    }
  
    var options = {
      series: [{
          data: [{
                  x: '',
                  y: [40, 100, 390, 650, 680]
              },
    
          ]
      }],
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
                  upper: '#00D0E2',
                  lower: '#00D0E2'
              }
          },
    
      },
      stroke: {
          colors: ['#6c757d']
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
    
          min: 00,
          max: 700,
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
    if (document.querySelector("#boxplot16")) {
      var chart = new ApexCharts(document.querySelector("#boxplot16"), options);
      chart.render();
    }
  // Ambulance dashboard  Donut Chart
  
  var options = {
    series: [44, 55],
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
        colors: ['#C8E0F8','#00CBDD' ],
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors:  ['#8CA5BC','#00666F'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
        
        }
    },
    legend: {
      show:false,
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
  if (document.querySelector("#donut7")) {
    var chart = new ApexCharts(document.querySelector("#donut7"), options);
    chart.render();
  }
  
  var options = {
    series: [44, 85],
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
        colors: ['#C8E0F8','#00CBDD' ],
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors: ['#8CA5BC','#00666F'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
         
        }
    },
    legend: {
      show:false,
        position: 'top'
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 320
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'left',
            }
        }
    }]
  };
  if (document.querySelector("#donut8")) {
    var chart = new ApexCharts(document.querySelector("#donut8"), options);
    chart.render();
  }
  
  // Ambulance dashboard Combo chart- 2
  
  var options = {
    series: [{
        name: '',
        type: 'column',
        data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160],
  
    }, {
        name: '',
        type: 'line',
        data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],
  
    }],
    plotOptions: {
        bar: {
            borderRadius: 3,
  
        }
    },
    colors: ['#9DB6CD', '#000000'],
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
        enabled: false,
        enabledOnSeries: [1]
    },
    markers: {
        size: 5,
        colors: '#FFFFFF',
    },
    labels: ['01hr', '02hr', '03hr', '04hr', '05hr', '06hr', '07hr', '08hr', '09hr', '10hr', '11hr', '12hr'],
    xaxis: {
        lines: {
            show: false,
        },
        type: 'Number'
    },
    yaxis: [{
        lines: {
            show: false,
        }
  
    }, {
        show: false,
        opposite: true,
  
    }]
  };
  if (document.querySelector("#combochart4")) {
    var chart = new ApexCharts(document.querySelector("#combochart4"), options);
    chart.render();
  }
  
  // Ambulance dashboard Column chart-3
  
  
  var options = {
    series: [{
        name: '',
        data: [00, 04, 03, 01, 05, 01, 00, 01, 04, 00, 00]
    }],
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
    plotOptions: {
        bar: {
            borderRadius: 3,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
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
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function(val) {
            return val + " ";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],
  
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
        }
    },
    yaxis: {
  
        min: 00,
        max: 05,
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
        }
  
    },
  
  };
  if (document.querySelector("#columnchart7")) {
    var chart = new ApexCharts(document.querySelector("#columnchart7"), options);
    chart.render();
  }
  // Ambulance dashboard Column chart-3
  
  var options = {
    series: [{
        name: '',
        data: [00, 04, 03, 01, 05, 01, 00, 01, 03, 00, 00]
    }],
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
    plotOptions: {
        bar: {
            borderRadius: 3,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
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
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function(val) {
            return val + " ";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
  
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11+"],
  
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
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#70C7CB',
                    colorTo: '#0E555D',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                }
            }
        },
        tooltip: {
            enabled: true,
        }
    },
    yaxis: {
        min: 0,
        max: 5,
        tickAmount: 5,
        type: 'Number',
        position: 'left',
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
        labels: {
            show: false,
            formatter: function(val) {
                return val + " ";
            }
        }
  
    },
  
  };
  if (document.querySelector("#columnchart8")) {
    var chart = new ApexCharts(document.querySelector("#columnchart8"), options);
    chart.render();
  }


//   AMBULANCE DASHBOARD - LAST 1000 ARRIVAL CHARTS END -

// Performance page - Stacked Columns 100 chart


var options = {
  series: [{
      name: '',
      data: [44, 55, 41, 67, 22, 43, 21, 49, 43, 21, 49,30]
  }, {
      name: '',
      data: [53, 73, 80, 88, 73, 87, 63, 72, 53, 71, 80,55]
  }, ],
  chart: {
      toolbar: {
          show: false,
      },
      type: 'bar',
      height: 300,
      stacked: true,
         fontFamily: 'Poppins, sans-serif'
  },
  plotOptions: {
    bar: {
        borderRadius: 3,
        borderRadiusWhenStacked: 'all',
           }
  
},
  dataLabels: {
      enabled: true,
      // position: 'bottom'
  },

  grid: {
    show: false,
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
    },  },
  colors: [ '#00D6E9','#C2DAF2'],
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
      categories: ['APR ', 'MAY ', 'JUN ', 'JUL ', 'AUG ', 'SEP ', 'OCT ', 'NOV ', 'DEC ', 'JAN ', 'FEB ', 'MAR '],
      labels: {
        show: true,
        // position:top,
            style: {
            fontWeight: 600,
        },},
       
  },
  yaxis: {
    show: true,
    labels: {
        show: false,
    },
    title: {
        text: 'Elective Non Elective',
        rotate: -90,
        offsetX: 0,
        offsetY: 0,
        style: {
                        fontSize: '14px',
                    fontWeight: 500,
          
        },
    },
  },
  fill: {
      type: 'gradient',
      gradient: {
        colors: [ '#00D6E9','#C2DAF2'],
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.5,
          gradientToColors: ['#009EAC','#9DB6CD' ], // optional, if not defined - uses the shades of same color in series
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
if (document.querySelector("#stackedchart")) {
  var chart = new ApexCharts(document.querySelector("#stackedchart"), options);
  chart.render();
}

// Performance page - Dounut chart


var options = {
  series: [44, 55, 41],
  labels: ['Surgeries Scheduled', 'Surgeries Completed', 'Surgeries Cancelled'],
  chart: {
      toolbar: {
          show: false,
      },
      width: 430,
      type: 'donut',
      fontFamily: 'Poppins, sans-serif'
  },
  colors:['#D9D9D9', '#C8E0F8','#00CBDD' ] ,
  plotOptions: {
      pie: {

          startAngle: -90,
          endAngle: 270
      }
  },
  dataLabels: {
      enabled: true,
      offsetX:-20,
      offsetY:-30
  },
  fill: {
    type: 'gradient',
    gradient: {
        shade: 'light',
        type: "horizontal",
              gradientToColors:['#bebebe', '#8CA5BC','#00666F' ]  ,
              inverseColors: true,
              opacityFrom: 1,
              opacityTo: 1,
                        
      
    }
  },
  legend: {
    show: true,
    markers: {
        width: 15,
        height: 15,
        strokeWidth: 0,
        fillColors: undefined,
        radius: 2,
        offsetX: 0,
        offsetY: 0
    },
      formatter: function(val, opts) {

          return val
      }
  },
  stroke: {
    show: false,
     
},
  responsive: [{
      breakpoint: 480,
      options: {
          chart: {
              width: 300
          },
          legend: {
              position: 'bottom'
          }
      }
  }]
};
if (document.querySelector("#surgerychart")) {
  var chart = new ApexCharts(document.querySelector("#surgerychart"), options);
  chart.render();
}

// Performance page - Line chart


var options = {
  series: [{
          name: "Overall",
          data: [28, 29, 33, 36, 32, 32, 33,33, 36, 32, 32, 33]
      },
     

  ],
  chart: {
      height: 100,
      type: 'line',
      fontFamily: 'Poppins, sans-serif',
      dropShadow: {
          enabled: false,
          color: '#000',
          top: 8,
          left: 7,
          blur: 10,
          opacity: 0.2
      },
      toolbar: {
          show: false
      }
  },
  colors: ['#707070'],
  dataLabels: {
      enabled: false,
  },
  stroke: {
      curve: 'smooth',
      width:2,
  },

  grid: {
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
  markers: {
    size: 6,
    colors: '#00BDCE',
  },
  xaxis: {
    categories: ['APR ', 'MAY ', 'JUN ', 'JUL ', 'AUG ', 'SEP ', 'OCT ', 'NOV ', 'DEC ', 'JAN ', 'FEB ', 'MAR '],
    labels: {
      show: false,
      // position:top,
          style: {
          fontWeight: 600,
      },},
     
  },
  yaxis: {
    show: true,
    labels: {
        show: false,
    },
      title: {
          text: ' Overall',
          rotate: -90,
          offsetX: 0,
          offsetY: 0,
          style: {
                          fontSize: '14px',
                      fontWeight: 500,
            
          },
      },
  
  },
  legend: {
    show:false,
     
  }
};
if (document.querySelector("#chart-line")) {
  var chart = new ApexCharts(document.querySelector("#chart-line"), options);
  chart.render();
}

// Performance page - Line chart


var options = {
    series: [
        {
            name: "Non Elective",
            data: [24,33, 36, 32, 32, 33, 19, 23, 26, 22, 27, 23]
        },
    
  
    ],
    chart: {
        height: 100,
        type: 'line',
        fontFamily: 'Poppins, sans-serif',
        dropShadow: {
            enabled: false,
            color: '#000',
            top: 8,
            left: 7,
            blur: 10,
            opacity: 0.2
        },
        toolbar: {
            show: false
        }
    },
    colors: ['#707070'],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth',
        width:2,
    },
  
    grid: {
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
    markers: {
      size: 6,
      colors: '#00BDCE',
    },
    xaxis: {
      categories: ['APR ', 'MAY ', 'JUN ', 'JUL ', 'AUG ', 'SEP ', 'OCT ', 'NOV ', 'DEC ', 'JAN ', 'FEB ', 'MAR '],
      labels: {
        show: false,
        // position:top,
            style: {
            fontWeight: 600,
        },},
       
    },
    yaxis: {
      show: true,
      labels: {
          show: false,
      },
        title: {
            text: '  Non Elective  ',
            rotate: -90,
            offsetX: 0,
            offsetY: 0,
            style: {
                            fontSize: '14px',
                        fontWeight: 500,
              
            },
        },
    
    },
    legend: {
      show:false,
       
    }
  };
  if (document.querySelector("#chart-line-1")) {
    var chart = new ApexCharts(document.querySelector("#chart-line-1"), options);
    chart.render();
  }
  
// Performance page - Line chart


var options = {
    series: [
        {
          name: "Elective",
          data: [14, 29, 33, 46, 33, 36, 32, 32, 33,12, 24, 29]
      },
  
    ],
    chart: {
        height: 100,
        type: 'line',
        fontFamily: 'Poppins, sans-serif',
        dropShadow: {
            enabled: false,
            color: '#000',
            top: 8,
            left: 7,
            blur: 10,
            opacity: 0.2
        },
        toolbar: {
            show: false
        }
    },
    colors: ['#707070'],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth',
        width:2,
    },
  
    grid: {
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
    markers: {
      size: 6,
      colors: '#00BDCE',
    },
    xaxis: {
      categories: ['APR ', 'MAY ', 'JUN ', 'JUL ', 'AUG ', 'SEP ', 'OCT ', 'NOV ', 'DEC ', 'JAN ', 'FEB ', 'MAR '],
      labels: {
        show: true,
        // position:top,
            style: {
            fontWeight: 600,
        },},
       
    },
    yaxis: {
      show: true,
      labels: {
          show: false,
      },
        title: {
            text: 'Elective  ',
            rotate: -90,
            offsetX: 0,
            offsetY: 0,
            style: {
                            fontSize: '14px',
                        fontWeight: 500,
              
            },
        },
    
    },
    legend: {
      show:false,
       
    }
  };
  if (document.querySelector("#chart-line-2")) {
    var chart = new ApexCharts(document.querySelector("#chart-line-2"), options);
    chart.render();
  }
  
// Performance page - Tree chart

var options = {
  series: [{
      data: [{
              x: 'Test',
              y: 218
          },
          {
              x: 'Test',
              y: 149
          },
          {
              x: 'Test',
              y: 184
          },
          {
              x: 'Test',
              y: 55
          },
          {
              x: 'Test',
              y: 84
          },
          {
              x: 'Test',
              y: 31
          },
          {
              x: 'Test',
              y: 70
          },
          {
              x: 'Test',
              y: 130
          },
          {
              x: 'Test',
              y: 44
          },
          {
              x: 'Test',
              y: 168
          },
          {
              x: 'Test',
              y: 28
          },
          {
              x: 'Test',
              y: 19
          },
          {
              x: 'Test',
              y: 129
          }
      ]
  }],
  legend: {
      show: false
  },
  chart: {
      toolbar: {
          show: false,
      },
      height: 350,
      type: 'treemap',
      fontFamily: 'Poppins, sans-serif'
  },
  colors: [
    '#B9B9B9',
      '#00C0D2',
     
  ],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.5,
          gradientToColors: undefined, // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 50, 100],
          colorStops: []
      }
  },
  plotOptions: {
      treemap: {
          distributed: true,
          enableShades: false
      }
  }
};
if (document.querySelector("#treechart")) {
  var chart = new ApexCharts(document.querySelector("#treechart"), options);
  chart.render();
}


// COMPLEX DISCHARGE DASHBOARD Column chart -1
var options = {
  series: [{
      name: '',
      data: [44, 55, 41, 67, 22]
  }, {
      name: '',
      data: [53, 73, 80, 88, 73]
  }, ],
  chart: {
      toolbar: {
          show: false,
      },
      type: 'bar',
      height: 300,
      stacked: true,
        fontFamily: 'Poppins, sans-serif',
   
  },



  plotOptions: {
    bar: {
        borderRadius: 3,
        borderRadiusWhenStacked: 'all',
        dataLabels: {
                        total: {
             
              enabled: true,
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
    show:false,
    },
  colors: ['#00D6E9', '#C2DAF2'],
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
      categories: ['P TBC ', 'P0 Home ', 'P1 Home', 'P2 Rehab ', 'P3 Care Home'],
      labels: {
        show: true,
            style: {
            fontWeight: 600,
        },}
  },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.5,
          gradientToColors: ['#009EAC', '#9DB6CD'], // optional, if not defined - uses the shades of same color in series
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
if (document.querySelector("#complex-dashboard-chart1")) {
  var chart = new ApexCharts(document.querySelector("#complex-dashboard-chart1"), options);
  chart.render();
}


// COMPLEX DISCHARGE DASHBOARD Column chart -2

var options = {
  series: [{
      name: '',
      data: [44, 55, 41, 67, 22]
  }, {
      name: '',
      data: [53, 73, 80, 88, 73]
  }, ],
  chart: {
      toolbar: {
          show: false,
      },
      type: 'bar',
      height: 300,
      stacked: true,
      fontFamily: 'Poppins, sans-serif'
  },
  plotOptions: {
    bar: {
        borderRadius: 3,
        borderRadiusWhenStacked: 'all',
        dataLabels: {
                        total: {
             
              enabled: true,
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
    show:false,
    },
  colors: ['#00D6E9', '#C2DAF2'],
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
    categories: ['P TBC ', 'P0 Home ', 'P1 Home', 'P2 Rehab ', 'P3 Care Home'], 
    labels: {
        show: true,
            style: {
            fontWeight: 600,
        },} },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.5,
          gradientToColors: ['#009EAC', '#9DB6CD'], // optional, if not defined - uses the shades of same color in series
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
if (document.querySelector("#complex-dashboard-chart2")) {
  var chart = new ApexCharts(document.querySelector("#complex-dashboard-chart2"), options);
  chart.render();
}

// COMPLEX DISCHARGE DASHBOARD Donut chart

var options = {
  series: [20, 44, 85],
  labels: ['Super Standard', 'Stranded', 'Not Stranded'],
  chart: {
      width: 250,
      type: 'donut',
      fontFamily: 'Poppins, sans-serif'
  },
  colors:['#D9D9D9', '#C8E0F8','#00CBDD' ] ,
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
    gradient: {
        shade: 'light',
        type: "horizontal",
              gradientToColors:['#bebebe', '#8CA5BC','#00666F' ]  ,
              inverseColors: true,
              opacityFrom: 1,
              opacityTo: 1,
                        
      
    }
  },
  legend: {
    show:false,

  },
  stroke: {
    show: false,
     
},

  responsive: [{
      breakpoint: 480,
      options: {
          chart: {
              width: 300
          },
        
      }
  }]
};
if (document.querySelector("#complex-dashboard-donut")) {
  var chart = new ApexCharts(document.querySelector("#complex-dashboard-donut"), options);
  chart.render();
}




// ED Activity Conversion rate


var options = {
  series: [24.79],
  chart: {
      height: 150,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};

if (document.querySelector("#conversion-chart")) {
  var chart = new ApexCharts(document.querySelector("#conversion-chart"), options);
  chart.render();
}


// ED Activity Performance chart-1

var options = {
  series: [100],
  chart: {
      height: 150,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#performance-chart1")) {
  var chart = new ApexCharts(document.querySelector("#performance-chart1"), options);
  chart.render();
}

// ED Activity Performance chart-2

var options = {
  series: [88],
  chart: {
      height: 150,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#performance-chart2")) {
  var chart = new ApexCharts(document.querySelector("#performance-chart2"), options);
  chart.render();
}

// ED Activity Ambulance Arrival chart-1

var options = {
  series: [22],
  chart: {
      height: 150,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#ambulance-chart1")) {
  var chart = new ApexCharts(document.querySelector("#ambulance-chart1"), options);
  chart.render();
}

// ED Activity Ambulance Arrival chart-2

var options = {
  series: [44],
  chart: {
      height: 150,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#ambulance-chart2")) {
  var chart = new ApexCharts(document.querySelector("#ambulance-chart2"), options);
  chart.render();
}
// ED Activity Walk In chart-1

var options = {
  series: [50],
  chart: {
      height: 150,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#walkin-chart1")) {
  var chart = new ApexCharts(document.querySelector("#walkin-chart1"), options);
  chart.render();
}

// ED Activity Walk In chart-2

var options = {
  series: [5],
  chart: {
      height: 150,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#walkin-chart2")) {
  var chart = new ApexCharts(document.querySelector("#walkin-chart2"), options);
  chart.render();
}


// ED Activity ADMITTED BY SPECIALITY chart


var options = {
  series: [{
      data: [04, 06, 04, 10, 08, 30, 20],

  }],
  chart: {
      toolbar: {
          show: false
      },
      type: 'bar',
      fontFamily: 'Poppins, sans-serif',
      height: 350
  },
  plotOptions: {
      bar: {
          distributed: true,
          borderRadius: 2,
          horizontal: true,
      }
  },
  colors: ['#A2BBD2', '#891E55', '#8C21EF', '#008D9A', '#AF8CCE', '#5F87F6', '#918624'],
  dataLabels: {
      enabled: false
  },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.6,
          gradientToColors: ['#515E69', '#450F2B', '#382C44', '#00474D', '#584667', '#30447B', '#494312'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 80, 100],
          colorStops: []
      },
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
      },
  },
  xaxis: {
      categories: ['A&E (NGH)', 'Acute Stroke Team', 'Cardiology', 'General Medical', 'Home', 'Paediatric', 'Vascular',

      ],
      min: 00,
      max: 26,
      tickAmount: 13,
      axisBorder: {
          show: true,
          color: '#707070',
          height: 1,
          width: '100%',
          offsetX: 0,
          offsetY: 0
      },
      axisTicks: {
          show: false,
      },
  }
};
if (document.querySelector("#special-admit-chart")) {
  var chart = new ApexCharts(document.querySelector("#special-admit-chart"), options);
  chart.render();
}
// ED Activity TRIAGE CATEGORY chart


var options = {
  series: [{
      data: [40, 00, 40, 30, 20, 05],

  }],
  chart: {
      toolbar: {
          show: false
      },
      type: 'bar',
      fontFamily: 'Poppins, sans-serif',
      height: 350
  },
  plotOptions: {
      bar: {
          distributed: true,
          borderRadius: 2,
          horizontal: true,
      }
  },
  colors: ['#382C44', '#891E55', '#008D9A', '#584667', '#30447B', '#494312'],
  dataLabels: {
      enabled: false
  },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.6,
          gradientToColors: ['#8C21EF', '#891E55', '#00474D', '#AF8CCE', '#5F87F6', '#918624'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 80, 100],
          colorStops: []
      },
  },
  legend: {
      show: false
  },
  grid: {
      show: true,
      yaxis: {
          lines: {
              show: false
          },


      },
      xaxis: {
          lines: {
              show: false
          }
      },
  },
  xaxis: {
      categories: ['00', '01', '02', '03', '04', '05', ],
      min: 00,
      tickAmount: 10,
      max: 50,
      axisBorder: {
          show: true,
          color: '#707070',
          height: 1,
          width: '100%',
          offsetX: 0,
          offsetY: 0
      },
      axisTicks: {
          show: false,
      },
  }
};
if (document.querySelector("#triage-chart")) {
  var chart = new ApexCharts(document.querySelector("#triage-chart"), options);
  chart.render();
}
// ED Activity DTA Waits chart

var options = {
  series: [{
      name: 'DTA Waits',
      data: [5, 00, 13]
  }],
  chart: {
      toolbar: {
          show: false
      },
      type: 'bar',
      fontFamily: 'Poppins, sans-serif',
      height: 350
  },
  plotOptions: {
      bar: {
          borderRadius: 3,
      },
  },
  colors: ['#9DB6CD'],
  dataLabels: {
      enabled: false
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
      },
  },
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
          stops: [0, 70, 100],
          colorStops: []
      },
  },
  stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
  },
  xaxis: {
      categories: ['>2 Hours', '2 to 4 Hours', '<4 Hours'],
      axisBorder: {
          show: false,
      },
      axisTicks: {
          show: false,
      }
  },
  yaxis: {
      title: {
          text: ''
      },
      tickAmount: 10,
      min: 00,
      max: 50,
      axisBorder: {
          show: true,
          color: '#707070',
          offsetX: 0,
          offsetY: 0
      },

  },
  legend: {
      show: false
  },
  tooltip: {
      y: {
          formatter: function(val) {
              return "$ " + val + " "
          }
      }
  }
};
if (document.querySelector("#dta-chart")) {
  var chart = new ApexCharts(document.querySelector("#dta-chart"), options);
  chart.render();
}


// Breach Dashboard chart-1

var options = {
  series: [50],
  chart: {
      height: 250,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#breach-chart1")) {
  var chart = new ApexCharts(document.querySelector("#breach-chart1"), options);
  chart.render();
}


// Breach Dashboard chart-2

var options = {
  series: [100],
  chart: {
      height: 250,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#breach-chart2")) {
  var chart = new ApexCharts(document.querySelector("#breach-chart2"), options);
  chart.render();
}

// Breach Dashboard chart-3

var options = {
  series: [33],
  chart: {
      height: 250,
      type: 'radialBar',
      fontFamily: 'Poppins, sans-serif',
  },
  plotOptions: {
      radialBar: {
          track: {
              background: '#C8E0F8',
          },
          hollow: {
              size: '30%',
          },
          dataLabels: {
              show: true,
              value: {
                  formatter: function(val) {
                      return parseInt(val) + "%";
                  },
                  color: '#000',
                  fontSize: '14px',
                  fontWeight: 'bold',
                  show: true,
                  offsetY: -12,
              }
          }
      },
  },
  colors: ['#00666F', '#C8E0F8'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#00CBDD', '#8CA5BC'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
      }
  },
  labels: [''],
};
if (document.querySelector("#breach-chart3")) {
  var chart = new ApexCharts(document.querySelector("#breach-chart3"), options);
  chart.render();
}


// Breach Monthly Dashboard chart-1

var options = {
    series: [100],
    chart: {
        height: 250,
        type: 'radialBar',
        fontFamily: 'Poppins, sans-serif',
    },
    plotOptions: {
        radialBar: {
            track: {
                background: '#C8E0F8',
            },
            hollow: {
                size: '30%',
            },
            dataLabels: {
                show: true,
                value: {
                    formatter: function(val) {
                        return parseInt(val) + "%";
                    },
                    color: '#000',
                    fontSize: '14px',
                    fontWeight: 'bold',
                    show: true,
                    offsetY: -12,
                }
            }
        },
    },
    colors: ['#00666F', '#C8E0F8'],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#00CBDD', '#8CA5BC'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    labels: [''],
  };
  if (document.querySelector("#breach-monthly-chart1")) {
    var chart = new ApexCharts(document.querySelector("#breach-monthly-chart1"), options);
    chart.render();
  }


// Breach Monthly Dashboard chart-2

var options = {
    series: [100],
    chart: {
        height: 250,
        type: 'radialBar',
        fontFamily: 'Poppins, sans-serif',
    },
    plotOptions: {
        radialBar: {
            track: {
                background: '#C8E0F8',
            },
            hollow: {
                size: '30%',
            },
            dataLabels: {
                show: true,
                value: {
                    formatter: function(val) {
                        return parseInt(val) + "%";
                    },
                    color: '#000',
                    fontSize: '14px',
                    fontWeight: 'bold',
                    show: true,
                    offsetY: -12,
                }
            }
        },
    },
    colors: ['#00666F', '#C8E0F8'],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#00CBDD', '#8CA5BC'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    labels: [''],
  };
  if (document.querySelector("#breach-monthly-chart2")) {
    var chart = new ApexCharts(document.querySelector("#breach-monthly-chart2"), options);
    chart.render();
  }
  
  // Breach Monthly Dashboard chart-3
  
  var options = {
    series: [33],
    chart: {
        height: 250,
        type: 'radialBar',
        fontFamily: 'Poppins, sans-serif',
    },
    plotOptions: {
        radialBar: {
            track: {
                background: '#C8E0F8',
            },
            hollow: {
                size: '30%',
            },
            dataLabels: {
                show: true,
                value: {
                    formatter: function(val) {
                        return parseInt(val) + "%";
                    },
                    color: '#000',
                    fontSize: '14px',
                    fontWeight: 'bold',
                    show: true,
                    offsetY: -12,
                }
            }
        },
    },
    colors: ['#00666F', '#C8E0F8'],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#00CBDD', '#8CA5BC'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    labels: [''],
  };
  if (document.querySelector("#breach-monthly-chart3")) {
    var chart = new ApexCharts(document.querySelector("#breach-monthly-chart3"), options);
    chart.render();
  }


// Performance Dashboard Patients by Ward and Flow Delay Group chart


var options = {
  series: [{
          name: 'Cavell',
          data: [44, 00, 23, 43, 00, 78, 55, 0, 37, 22, 12, 34]
      },
      {
          name: 'CCU',
          data: [53, 00, 33, 52, 0, 00, 0, 78, 55, 0, 45, 0]
      },
      {
          name: 'Cloudesley',
          data: [12, 00, 11, 9, 15, 33, 52, 13, 43, 56, 78]
      },
      {
          name: 'Coyle',
          data: [0, 00, 0, 0, 6, 9, 0, 5, 8, 6, 0, 54]
      },


  ],
  chart: {
      toolbar: {
          show: false
      },
      type: 'bar',
      stacked: true,
      fontFamily: 'Poppins, sans-serif',
      height: 380
  },
  colors: ['#00C0D2', '#AE125B', '#F0F0F0', '#424141'],
  plotOptions: {
      bar: {
          // borderRadius: 2,
          horizontal: true,
      }
  },
  stroke: {
      width: 1,
      colors: ['#fff']
  },

  dataLabels: {
      enabled: false
  },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.6,
          gradientToColors: ['#00A6B6', '#57092E', '#86B4E1', '#161616'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 80, 100],
          colorStops: []
      },
  },

  legend: {
      show: false,
      position: 'bottom',
      horizontalAlign: 'left',
      offsetX: 60,

  },
  grid: {
      show: true,
      yaxis: {
          lines: {
              show: false
          },


      },
  },
  xaxis: {
      categories: ['Cavell', 'CCU', 'Cloudesley', 'Coyle', 'Mercers', 'Meyrick', 'Montuschi', 'MSN', 'MSS', 'Nightingale', 'Thorogood', 'Victoria'

      ],
      lines: {
          show: false,
      }
  }
};
if (document.querySelector("#ward-flow-chart")) {
  var chart = new ApexCharts(document.querySelector("#ward-flow-chart"), options);
  chart.render();
}



// Performance Dashboard Patients by Ward and Flow Delay Group chart-1


var options = {
  series: [{
          name: 'Cavell',
          data: [44, 20, 23, 43, 30, 78, 55, 10, 37, 22, 12, 34]
      },



  ],
  chart: {
      toolbar: {
          show: false
      },
      type: 'bar',
      fontFamily: 'Poppins, sans-serif',
      height: 475
  },
  colors: ['#86B4E1'],
  plotOptions: {
      bar: {
          borderRadius: 2,
          horizontal: true,
      }
  },

  dataLabels: {
      enabled: false
  },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.6,
          gradientToColors: ['#F0F0F0'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 95, 100],
          colorStops: []
      },
  },

  legend: {
      enabled: false,
      position: 'bottom',
      horizontalAlign: 'left',
      offsetX: 60,

  },
  grid: {
      show: true,
      yaxis: {
          lines: {
              show: false
          },


      },
  },
  xaxis: {
      categories: ['Cavell', 'CCU', 'Cloudesley', 'Coyle', 'Mercers', 'Meyrick', 'Montuschi', 'MSN', 'MSS', 'Nightingale', 'Thorogood', 'Victoria'

      ],
      lines: {
          show: false,
      }
  }
};
if (document.querySelector("#ward-flow-chart-1")) {
  var chart = new ApexCharts(document.querySelector("#ward-flow-chart-1"), options);
  chart.render();
}

// Performance Dashboard Patients by Ward and Flow Delay Group chart-2


var options = {
  series: [{
          name: 'Cavell',
          data: [44, 20, 23, 43, 30, 78, 55, 10, 37, 22, 12, 34]
      },



  ],
  chart: {
      toolbar: {
          show: false
      },
      type: 'bar',
      fontFamily: 'Poppins, sans-serif',
      height: 475
  },
  colors: ['#86B4E1'],
  plotOptions: {
      bar: {
          borderRadius: 2,
          horizontal: true,
      }
  },

  dataLabels: {
      enabled: false
  },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.6,
          gradientToColors: ['#F0F0F0'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 95, 100],
          colorStops: []
      },
  },

  legend: {
      enabled: false,
      position: 'bottom',
      horizontalAlign: 'left',
      offsetX: 60,

  },
  grid: {
      show: true,
      yaxis: {
          lines: {
              show: false
          },


      },
  },
  xaxis: {
      categories: ['Cavell', 'CCU', 'Cloudesley', 'Coyle', 'Mercers', 'Meyrick', 'Montuschi', 'MSN', 'MSS', 'Nightingale', 'Thorogood', 'Victoria'

      ],
      lines: {
          show: false,
      }
  }
};
if (document.querySelector("#ward-flow-chart-2")) {
  var chart = new ApexCharts(document.querySelector("#ward-flow-chart-2"), options);
  chart.render();
}

// Performance Dashboard coloumn stacked chart-2


var options = {
  series: [{
      name: 'PRODUCT A',
      data: [0, 25, 11, 67, 22, 0, 35, 65]
  }, {
      name: 'PRODUCT B',
      data: [0, 0, 20, 0, 0, 30, 15, 35]
  }, {
      name: 'PRODUCT C',
      data: [10, 57, 55, 15, 21, 14, 10, 30]
  }, {
      name: 'PRODUCT D',
      data: [10, 7, 0, 0, 0, 0, 0, 0]
  }],
  colors: ['#00C0D2', '#AE125B', '#F0F0F0', '#424141'],
  chart: {
      type: 'bar',
      height: 200,
      fontFamily: 'Poppins, sans-serif',
      stacked: true,
      toolbar: {
          show: false
      },
      zoom: {
          enabled: true
      }
  },
  dataLabels: {
      enabled: false,
  },
  responsive: [{
      breakpoint: 480,
      options: {
          legend: {
              show: false,
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
          }
      }
  }],
  plotOptions: {
      bar: {
          horizontal: false,
          // borderRadius: 2,
      },
  },
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.6,
          gradientToColors: ['#00A6B6', '#57092E', '#86B4E1', '#161616'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 80, 100],
          colorStops: []
      },
  },
  grid: {
      show: true,
      yaxis: {
          lines: {
              show: false
          },
      }
  },
  xaxis: {
      type: 'number',
      categories: ['10', '1-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30+'],
  },

  legend: {
      show: false,

  },
};
if (document.querySelector("#column-stacked-chart")) {
  var chart = new ApexCharts(document.querySelector("#column-stacked-chart"), options);
  chart.render();
}



// Performance Dashboard coloumn chart

var options = {
  series: [{
      name: 'Age',
      data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
  }],
  chart: {
      toolbar: {
          show: false
      },
      type: 'bar',
      fontFamily: 'Poppins, sans-serif',
      height: 200
  },
  colors: ['#9DB6CD'],
  plotOptions: {
      bar: {
          borderRadius: 3,
          horizontal: false,

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
  grid: {
      show: true,
      yaxis: {
          lines: {
              show: false
          },
      }
  },
  xaxis: {
      categories: ['10', '20', '30', '40', '50', '60', '70', '80', '90'],

  },
  lines: {
      show: false,
  },

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
  tooltip: {
      y: {
          formatter: function(val) {
              return " " + val + " "
          }
      }
  }
};
if (document.querySelector("#age-chart")) {
  var chart = new ApexCharts(document.querySelector("#age-chart"), options);
  chart.render();
}


// Site overview Medical Admission & Discharge  chart

 
var options = {
    series: [{
    name: 'Admissions ',
    data: [0.4, 0.65, 0.76, 0.88, 1.5, 2.1, 2.9, 3.8, 3.9, 4.2, 4, 4.3, 4.1, 4.2, 4.5,
      3.9, 3.5, 3
    ]
  },
  {
    name: 'Discharges',
    data: [-0.8, -1.05, -1.06, -1.18, -1.4, -2.2, -2.85, -3.7, -3.96, -4.22, -4.3, -4.4,
      -4.1, -4, -4.1, -3.4, -3.1, -2.8
    ]
  }
  ],
    chart: {
        toolbar: {
            show: false
        },
    type: 'bar',
    height: 440,
    stacked: true,
    fontFamily: 'Poppins, sans-serif',
  },
  colors: ['#C2DAF2','#E2E2E2'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.6,
          gradientToColors: ['#9DB6CD','#9A9A9A'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 95, 100],
          colorStops: []
      },
  },
  plotOptions: {
    bar: {
        borderRadius: 3,
      horizontal: true,
      barHeight: '80%',
    },
  },
   dataLabels: {
    enabled: true,
    style: {
        colors: ['#000'],
        fontSize:'10',
        fontWeight:'400'
    },
    offsetX: 30
  },
  stroke: {
    width: 2,
    colors: ["#fff"]
  },
  
  grid: {
    xaxis: {
      lines: {
        show: false
      }
    },
    yaxis: {
        lines: {
          show: false,
        }}
  },
  yaxis: {
    min: -5,
    max: 5,
  },
  tooltip: {
    shared: false,
    x: {
      formatter: function (val) {
        return val
      }
    },
    y: {
      formatter: function (val) {
        return Math.abs(val) + "%"
      }
    }
  },
 
  xaxis: {
    categories: ['ALLE', 'BECK', 'BENH', 'BRM', ':RAMF', 'COLA', 'COLB', 'COMP',
      'CREA', 'DRYD', 'EAU', 'ELEA', 'ESTW', 'FINE', 'HOLC', 'KNIG', 'VICT',
      'WALT'
    ],
  
    labels: {
      formatter: function (val) {
        return Math.abs(Math.round(val)) + "%"
      }
    }
  },
  legend: {
    show: false
  }
  };

  if (document.querySelector("#medical-chart")) {
    var chart = new ApexCharts(document.querySelector("#medical-chart"), options);
    chart.render();
  }

 // Site overview surgery Admission & Discharge  chart

 
var options = {
    series: [{
    name: 'Admissions ',
    data: [  2.1, 2.9, 3.8, 3.9, 4.2, 4, 4.3, 4.1, 4.2, 4.5,]
  },
  {
    name: 'Discharges',
    data: [  -3.96, -4.22, -4.3, -4.4,-4.1, -4, -4.1, -3.4, -3.1, -2.8 ]
  }
  ],
    chart: {
        toolbar: {
            show: false
        },
    type: 'bar',
    height: 440,
    stacked: true,
    fontFamily: 'Poppins, sans-serif',
  },
  colors: ['#C2DAF2','#E2E2E2'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "vertical",
          shadeIntensity: 0.6,
          gradientToColors: ['#9DB6CD','#9A9A9A'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 95, 100],
          colorStops: []
      },
  },
  plotOptions: {
    bar: {
        borderRadius: 3,
      horizontal: true,
      barHeight: '80%',
    },
  },
   dataLabels: {
    enabled: true,
    style: {
        colors: ['#000'],
        fontSize:'10',
        fontWeight:'400'
    },
    offsetX: 30
  },
  stroke: {
    width: 2,
    colors: ['transparent']
  },
  
  grid: {
    xaxis: {
      lines: {
        show: false
      }
    },
    yaxis: {
        lines: {
          show: false,
        }}
  },
  yaxis: {
    min: -5,
    max: 5,
  },
  tooltip: {
    shared: false,
    x: {
      formatter: function (val) {
        return val
      }
    },
    y: {
      formatter: function (val) {
        return Math.abs(val) + "%"
      }
    }
  },
 
  xaxis: {
    categories: ['ABIN', 'ALTP', 'CEDA', 'HAWT', 'HENE', 'MDSU', 'ROWA', 'SPEN',
      'TALB', 'WILL', 
    ],
  
    labels: {
      formatter: function (val) {
        return Math.abs(Math.round(val)) + "%"
      }
    }
  },
  legend: {
    show: false
  }
  };

  if (document.querySelector("#surgery-chart")) {
    var chart = new ApexCharts(document.querySelector("#surgery-chart"), options);
    chart.render();
  }

// Site overview Radial  chart

  var options = {
    series: [70],
    chart: {
        height: 180,
        type: 'radialBar',
        fontFamily: 'Poppins, sans-serif',
    },
    plotOptions: {
        radialBar: {
            track: {
                background: '#C8E0F8',
            },
            hollow: {
                size: '30%',
            },
            dataLabels: {
                show: false,
                value: {
                    formatter: function(val) {
                        return parseInt(val) + "%";
                    },
                    color: '#000',
                    fontSize: '14px',
                    fontWeight: 'bold',
                    show: true,
                    offsetY: -12,
                }
            }
        },
    },
    colors: ['#00666F', '#C8E0F8'],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#00CBDD', '#8CA5BC'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
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
        },
    },
    labels: [''],
  };
  if (document.querySelector("#overview-radial-chart")) {
    var chart = new ApexCharts(document.querySelector("#overview-radial-chart"), options);
    chart.render();
  }

// Overview Dashboard Boxplot  chart

  var options = {
    series: [
    {
      type: 'boxPlot',
      data: [
        {
          x: '00',
          y: [54, 66, 69, 75, 88]
        },
        {
            x: '0.2',
            y: [43, 65, 69, 76, 81]
          },
          {
            x: '0.4',
            y: [31, 39, 45, 51, 59]
          },
          {
            x: '0.6',
            y: [39, 46, 55, 65, 71]
          },
          {
            x: '0.8',
            y: [29, 31, 35, 39, 44]
          },
          {
            x: '1',
            y: [41, 49, 58, 61, 67]
          },
   
           ]
    }
  ],
    chart: {
        toolbar: {
            show: false,
        },
        type: 'boxPlot',
        fontFamily: 'Poppins, sans-serif',
        height: 100,
   },

  plotOptions: {
    boxPlot: {
        colors: {
            upper: '#00D0E2',
            lower: '#00D0E2'
        }
    }
  },
  stroke: {
    colors: ['#6c757d']
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
    // tickAmount: 6,
    // min: 00,
    // max: 01,
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
},
yaxis: {
    show:false,
}
  };
  if (document.querySelector("#overview-boxplot-chart")) {
    var chart = new ApexCharts(document.querySelector("#overview-boxplot-chart"), options);
    chart.render();
  }


// Overview Dashboard Column  chart

  var options = {
    series: [{
    name: 'Mon, Tue, Wed, Thu - Current Week',
    data: [44, 55, 57, 56, 61, 58, 63,]
  }, {
    name: 'Mon, Tue, Wed, Thu, Fri, Sat, Sun - Last 4 Weeks',
    data: [76, 85, 101, 98, 87, 105, 91,]
  }],
    chart: {
        toolbar: {
            show: false,
        },
    type: 'bar',
    height: 300,
    fontFamily: 'Poppins, sans-serif',
  },
  colors: ['#00CB0E', '#9DB6CD'],
  fill: {
      type: 'gradient',
      gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.6,
          gradientToColors: ['#83E5AE', '#C2DAF2'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 95, 100],
          colorStops: []
      },
  },
  plotOptions: {
    bar: {
        borderRadius:3,
        horizontal: false,
      columnWidth: '55%',

    },
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: true,
    position:'top'
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  xaxis: {
    categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
    },
  yaxis: {
    title: {
      text: 'Time',
      style: {
        fontSize:'14',
        fontWeight:'500'
    },
    }
  },

  tooltip: {
    y: {
      formatter: function (val) {
        return "$ " + val + " thousands"
      }
    }
  }
  };

  if (document.querySelector("#overview-column-chart")) {
    var chart = new ApexCharts(document.querySelector("#overview-column-chart"), options);
    chart.render();
  }



