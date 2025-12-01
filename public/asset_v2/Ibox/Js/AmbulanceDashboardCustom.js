var barData = [
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    2,
    0,
    0,
    4,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var lineData = [
    0,
    0,
    0,
    0,
    5,
    6,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var YaxisArr = []
var HrArr = []
for (let i = 0; i <= 24; i++) {
    if (i < 10) {
        HrArr.push('0' + i + 'hr')
    } else {
        HrArr.push('' + i + 'hr')
    }
}

var chart = c3.generate({
    bindto: '#BarGraphAmbulanceDashboardWithspline_live',
    data: {
        columns: [
            ['data1', ...barData],
            ['data2', ...lineData]
        ],
        types: {
            data2: 'spline'
        },
        type: 'bar',
        onclick: function (d, i) {
           
        },
        
        names: {
            data1: 'No of Patients',
            data2: 'Referred Total'
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 160
    },
    padding: {
        bottom: 0,
        top: 10,
        left: 30,
        right: 10
    },
    legend: {
        show: false
        // position: "inset",
        // inset: {
        //   anchor: "top-right",
        //   x: 20,
        //   y: 20,
        //   step: 1,
        // },
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            type: 'category',
            categories: [...HrArr]
        },
        y: {
            show: true,
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                  
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    // if (YaxisArr.includes(Math.round(d))) {
                    //   return null;
                    // } else {
                    //   YaxisArr = [];
                    //   YaxisArr.push(Math.round(d));
                    //   return Math.round(d);
                    // }
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var barData = [
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    2,
    0,
    0,
    4,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var lineData = [
    0,
    0,
    0,
    0,
    5,
    6,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var YaxisArr = []
var HrArr = []
for (let i = 0; i <= 24; i++) {
    if (i < 10) {
        HrArr.push('0' + i + 'hr')
    } else {
        HrArr.push('' + i + 'hr')
    }
}

var chart = c3.generate({
    bindto: '#BarGraphAmbulanceDashboardWithspline_week',
    data: {
        columns: [
            ['data1', ...barData],
            ['data2', ...lineData]
        ],
        types: {
            data2: 'spline'
        },
        type: 'bar',
        onclick: function (d, i) {
           
        },
     
        names: {
            data1: 'No of Patients',
            data2: 'Referred Total'
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 160
    },
    padding: {
        bottom: 0,
        top: 10,
        left: 30,
        right: 10
    },
    legend: {
        show: false
        // position: "inset",
        // inset: {
        //   anchor: "top-right",
        //   x: 20,
        //   y: 20,
        //   step: 1,
        // },
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            type: 'category',
            categories: [...HrArr]
        },
        y: {
            show: true,
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                   
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    // if (YaxisArr.includes(Math.round(d))) {
                    //   return null;
                    // } else {
                    //   YaxisArr = [];
                    //   YaxisArr.push(Math.round(d));
                    //   return Math.round(d);
                    // }
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var barData = [
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    2,
    0,
    0,
    4,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var lineData = [
    0,
    0,
    0,
    0,
    5,
    6,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var YaxisArr = []
var HrArr = []
for (let i = 0; i <= 24; i++) {
    if (i < 10) {
        HrArr.push('0' + i + 'hr')
    } else {
        HrArr.push('' + i + 'hr')
    }
}

var chart = c3.generate({
    bindto: '#BarGraphAmbulanceDashboardWithspline_lastWS',
    data: {
        columns: [
            ['data1', ...barData],
            ['data2', ...lineData]
        ],
        types: {
            data2: 'spline'
        },
        type: 'bar',
        onclick: function (d, i) {
           
        },
        
        names: {
            data1: 'No of Patients',
            data2: 'Referred Total'
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 160
    },
    padding: {
        bottom: 0,
        top: 10,
        left: 30,
        right: 10
    },
    legend: {
        show: false
        // position: "inset",
        // inset: {
        //   anchor: "top-right",
        //   x: 20,
        //   y: 20,
        //   step: 1,
        // },
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            type: 'category',
            categories: [...HrArr]
        },
        y: {
            show: true,
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                 
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    // if (YaxisArr.includes(Math.round(d))) {
                    //   return null;
                    // } else {
                    //   YaxisArr = [];
                    //   YaxisArr.push(Math.round(d));
                    //   return Math.round(d);
                    // }
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var barData = [
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    2,
    0,
    0,
    4,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var lineData = [
    0,
    0,
    0,
    0,
    5,
    6,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

var YaxisArr = []
var HrArr = []
for (let i = 0; i <= 24; i++) {
    if (i < 10) {
        HrArr.push('0' + i + 'hr')
    } else {
        HrArr.push('' + i + 'hr')
    }
}

var chart = c3.generate({
    bindto: '#BarGraphAmbulanceDashboardWithspline_lastTh',
    data: {
        columns: [
            ['data1', ...barData],
            ['data2', ...lineData]
        ],
        types: {
            data2: 'spline'
        },
        type: 'bar',
        onclick: function (d, i) {
           
        },
      
        names: {
            data1: 'No of Patients',
            data2: 'Referred Total'
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 160
    },
    padding: {
        bottom: 0,
        top: 10,
        left: 30,
        right: 10
    },
    legend: {
        show: false
        // position: "inset",
        // inset: {
        //   anchor: "top-right",
        //   x: 20,
        //   y: 20,
        //   step: 1,
        // },
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            type: 'category',
            categories: [...HrArr]
        },
        y: {
            show: true,
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                  
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    // if (YaxisArr.includes(Math.round(d))) {
                    //   return null;
                    // } else {
                    //   YaxisArr = [];
                    //   YaxisArr.push(Math.round(d));
                    //   return Math.round(d);
                    // }
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var barData = [0, 0, 0, 1, 0, 2, 0, 3, 0, 0, 0, 0]

var YaxisArr = []
var HrArr = []
for (let i = 0; i <= 24; i++) {
    if (i < 10) {
        HrArr.push('0' + i + 'hr')
    } else {
        HrArr.push('' + i + 'hr')
    }
}

var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDLeft',
    data: {
        labels: true,
        columns: [['data1', ...barData]],

        type: 'bar',
        onclick: function (d, i) {
           
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                   
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDRight',
    data: {
        labels: true,
        columns: [['data1', ...barData]],

        type: 'bar',
        onclick: function (d, i) {
         
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                   
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var ctx = document.getElementById('DonutChartBreachsecLeft').getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50, 50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

var ctx = document.getElementById('DonutChartBreachsecRight').getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50, 50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

// Weektab graph custom scripts//////////////////////////////

var barDataweek = [0, 0, 0, 1, 0, 2, 0, 3, 0, 0, 0, 0]
var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDLeftweek',
    data: {
        labels: true,
        columns: [['data1', ...barDataweek]],

        type: 'bar',
        onclick: function (d, i) {
           
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                  
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDRightweek',
    data: {
        labels: true,
        columns: [['data1', ...barData]],

        type: 'bar',
        onclick: function (d, i) {
          
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                   
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var ctx = document
    .getElementById('DonutChartBreachsecLeft_week')
    .getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50, 50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

var ctx = document
    .getElementById('DonutChartBreachsecRight_week')
    .getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50, 50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

// Weektab graph custom scripts//////////////////////////////

// last4 graph custom scripts//////////////////////////////

var barDataweek = [0, 0, 0, 1, 0, 2, 0, 3, 0, 0, 0, 0]
var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDLeftlastf',
    data: {
        labels: true,
        columns: [['data1', ...barDataweek]],

        type: 'bar',
        onclick: function (d, i) {
      
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                  
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDRightlastf',
    data: {
        labels: true,
        columns: [['data1', ...barData]],

        type: 'bar',
        onclick: function (d, i) {
         
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                 
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var ctx = document
    .getElementById('DonutChartBreachsecLeft_lastf')
    .getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50, 50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

var ctx = document
    .getElementById('DonutChartBreachsecRight_lastf')
    .getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50, 50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

// last4 graph custom scripts//////////////////////////////

// lastth graph custom scripts//////////////////////////////

var barDataweek = [0, 0, 0, 1, 0, 2, 0, 3, 0, 0, 0, 0]
var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDLeftlastth',
    data: {
        labels: true,
        columns: [['data1', ...barDataweek]],

        type: 'bar',
        onclick: function (d, i) {
        
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                 
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var chart = c3.generate({
    bindto: '#BottomBarGraphLeftStillInEDRightlastth',
    data: {
        labels: true,
        columns: [['data1', ...barData]],

        type: 'bar',
        onclick: function (d, i) {
         
        },
        colors: {
            data1: '#03a9f4',
            data2: '#4CAF50'
        }
    },
    size: {
        // width: ,
        height: 180
    },
    padding: {
        bottom: 0,
        top: 5,
        left: 50,
        right: 10
    },
    legend: {
        show: false
    },
    tooltip: {
        format: {
            value: function (value, ratio, id, index) {
                return value
            }
        }
    },
    axis: {
        x: {
            show: true,
            label: {
                text: 'Hours In Dept From Arrival To Departure',
                position: 'outer-right'
            }
        },
        y: {
            show: true,
            label: {
                text: 'Patients',
                position: 'outer-top'
            },
            tick: {
                count: function (d) {
                    let maxAxisvalue = Math.max.apply(null, [...YaxisArr])
                 
                    if (maxAxisvalue > 4) {
                        return 6
                    }
                    if (maxAxisvalue === 4) {
                        return 5
                    }
                    if (maxAxisvalue === 3) {
                        return 4
                    }
                    if (maxAxisvalue === 2) {
                        return 3
                    }
                    if (maxAxisvalue === 1) {
                        return 2
                    }
                },
                format: function (d) {
                    YaxisArr.push(Math.round(d))
                    return Math.round(d)
                }
            }
        }
    },
    chart: {
        color: {
            pattern: ['#43A047', '#03a9f4']
        }
    },
    bar: {
        width: {
            ratio: 0.9
        }
    }
})

var ctx = document
    .getElementById('DonutChartBreachsecLeft_lastth')
    .getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50, 50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

var ctx = document
    .getElementById('DonutChartBreachsecRight_lastth')
    .getContext('2d')
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ['Breaches'],
        datasets: [
            {
                data: [50],
                // data: [10, 90],
                backgroundColor: ['#0075be', '#81D4FA'],
                borderColor: ['#0075be', '#81D4FA'],
                borderWidth: 1
            }
        ]
    },

    // Configuration options go here
    options: {}
})

// lastth graph custom scripts//////////////////////////////

var trace1 = {
    x: [1, 2, 3, 4],
    type: 'box',
    name: '1'
}

var dataBoxplot1 = [trace1]

var layout = {
    title: '',
    showlegend: false,
    autosize: true,
    height: 100,
    margin: {
        l: 0,
        r: 0,
        b: 0,
        t: 0
    }
}

Plotly.newPlot('BoxPlotChar_live1', dataBoxplot1, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_live2', dataBoxplot1, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_live3', dataBoxplot1, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_live4', dataBoxplot1, layout, {
    displayModeBar: false
})

var trace2 = {
    x: [1, 2, 3, 4],
    type: 'box',
    name: '2'
}

var dataBoxplot2 = [trace2]

var layout = {
    title: '',
    showlegend: false,
    autosize: true,
    height: 100,
    margin: {
        l: 0,
        r: 0,
        b: 0,
        t: 0
    }
}
Plotly.newPlot('BoxPlotChar_week1', dataBoxplot2, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_week2', dataBoxplot2, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_week3', dataBoxplot2, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_week4', dataBoxplot2, layout, {
    displayModeBar: false
})

var trace2 = {
    x: [1, 2, 3, 4],
    type: 'box',
    name: '2'
}

var dataBoxplot3 = [trace2]

var layout = {
    title: '',
    showlegend: false,
    autosize: true,
    height: 100,
    margin: {
        l: 0,
        r: 0,
        b: 0,
        t: 0
    }
}
Plotly.newPlot('BoxPlotChar_lastf1', dataBoxplot3, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_lastf2', dataBoxplot3, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_lastf3', dataBoxplot3, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_lastf4', dataBoxplot3, layout, {
    displayModeBar: false
})

var trace2 = {
    x: [1, 2, 3, 4],
    type: 'box',
    name: '2'
}

var dataBoxplot4 = [trace2]

var layout = {
    title: '',
    showlegend: false,
    autosize: true,
    height: 100,
    margin: {
        l: 0,
        r: 0,
        b: 0,
        t: 0
    }
}
Plotly.newPlot('BoxPlotChar_lastth1', dataBoxplot4, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_lastth2', dataBoxplot4, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_lastth3', dataBoxplot4, layout, {
    displayModeBar: false
})
Plotly.newPlot('BoxPlotChar_lastth4', dataBoxplot4, layout, {
    displayModeBar: false
})
