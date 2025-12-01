$(function () {
  // chart.update();
  $("#responsiveSideNavTrigger").click(function () {
    $("#resLeftSlideNavWrap").toggleClass("active");
  });

  $("#rightNavTriggerButton").click(function () {
    $("#rightSideNavWrapInnernav").toggleClass("active");
  });

  if ($("#datepicker").length > 0) {
    $(".datepickerInput").datepicker({
      format: "mm/dd/yyyy",
      startDate: "-3d",
    });
  }

  $(".nav-tabs .nav-link").click(function () {
    $("#BottomBarGraphLeftStillInEDLeftweek").empty();

    setTimeout(function () {
      if (chart) {
        chart.update();
        drawChart();
      }
    }, 200);
  });



  // FixedTabletop

  $(window).load(function () {
    let fixedDivWidth = $(".EDActivityGraphWrap").innerWidth();
    $(".FixedTabletop").css("width", fixedDivWidth + "px");
  });

  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 500) {
      $(".FixedTabletop").addClass("active");
    } else {
      $(".FixedTabletop").removeClass("active");
    }
  });

  //   $(window).on("scroll", function () {

  //     var hT = $('#scroll-to').offset().top,
  //     hH = $('#scroll-to').outerHeight(),
  //     wH = $(window).height(),
  //     wS = $(this).scrollTop();
  // if (wS > (hT+hH-wH)){
  //     console.log('H1 on the view!');
  // }

  //     if ($(".heatMeaterBubbleBoxWrap").length > 0) {
  //       if ($(".heatMeaterBubbleBoxWrap").offset().top < 0) {
  //         alert(0);
  //       }
  //     }
  //   });

  $(".EDactivityRowClickTriggerList li").on("click", function (e) {
    // this.offsetLeft

    // $(".leftcolorDiv").width();

    $(".overlaySelectionBox").css({
      // left: this.offsetLeft + "px",
      left: this.offsetLeft + "px",
      display: "block",
      width: e.target.offsetWidth,
      transform: "translateX(" + ($(".leftcolorDiv").width() + 7) + "px)",
    });
  });

  $(".activeRowRemovecell").on("click", function () {
    $(".overlaySelectionBox").css("display", "none");
  });

  $(".dropDownNavTigger").on("click", function () {
    $(".CheckBoxWrapper").toggleClass("show");
  });
});

// function TabClicked() {
//   setTimeout(function () {
//     // alert(0);
//     chart.update();
//   }, 1000);
// }

function drawChart() {
  var barDataweek = [0, 0, 0, 1, 0, 2, 0, 3, 0, 0, 0, 0];
  var chart = c3.generate({
    bindto: "#BottomBarGraphLeftStillInEDLeftweek",
    data: {
      labels: true,
      columns: [["data1", ...barDataweek]],

      type: "bar",
      onclick: function (d, i) {
        // setCount(count++);
        console.log("onclick", d, i);
      },
      colors: {
        data1: "#03a9f4",
        data2: "#4CAF50",
      },
    },
    size: {
      // width: ,
      height: 180,
    },
    padding: {
      bottom: 0,
      top: 5,
      left: 50,
      right: 10,
    },
    legend: {
      show: false,
    },
    tooltip: {
      format: {
        value: function (value, ratio, id, index) {
          return value;
        },
      },
    },
    axis: {
      x: {
        show: true,
        label: {
          text: "Hours In Dept From Arrival To Departure",
          position: "outer-right",
        },
      },
      y: {
        show: true,
        label: {
          text: "Patients",
          position: "outer-top",
        },
        tick: {
          count: function (d) {
            let maxAxisvalue = Math.max.apply(null, [...YaxisArr]);
            console.log(maxAxisvalue, "max axis value");
            if (maxAxisvalue > 4) {
              return 6;
            }
            if (maxAxisvalue === 4) {
              return 5;
            }
            if (maxAxisvalue === 3) {
              return 4;
            }
            if (maxAxisvalue === 2) {
              return 3;
            }
            if (maxAxisvalue === 1) {
              return 2;
            }
          },
          format: function (d) {
            YaxisArr.push(Math.round(d));
            return Math.round(d);
          },
        },
      },
    },
    chart: {
      color: {
        pattern: ["#43A047", "#03a9f4"],
      },
    },
    bar: {
      width: {
        ratio: 0.9,
      },
    },
  });

  var chart = c3.generate({
    bindto: "#BottomBarGraphLeftStillInEDRightweek",
    data: {
      labels: true,
      columns: [["data1", ...barData]],

      type: "bar",
      onclick: function (d, i) {
        // setCount(count++);
        console.log("onclick", d, i);
      },
      colors: {
        data1: "#03a9f4",
        data2: "#4CAF50",
      },
    },
    size: {
      // width: ,
      height: 180,
    },
    padding: {
      bottom: 0,
      top: 5,
      left: 50,
      right: 10,
    },
    legend: {
      show: false,
    },
    tooltip: {
      format: {
        value: function (value, ratio, id, index) {
          return value;
        },
      },
    },
    axis: {
      x: {
        show: true,
        label: {
          text: "Hours In Dept From Arrival To Departure",
          position: "outer-right",
        },
      },
      y: {
        show: true,
        label: {
          text: "Patients",
          position: "outer-top",
        },
        tick: {
          count: function (d) {
            let maxAxisvalue = Math.max.apply(null, [...YaxisArr]);
            console.log(maxAxisvalue, "max axis value");
            if (maxAxisvalue > 4) {
              return 6;
            }
            if (maxAxisvalue === 4) {
              return 5;
            }
            if (maxAxisvalue === 3) {
              return 4;
            }
            if (maxAxisvalue === 2) {
              return 3;
            }
            if (maxAxisvalue === 1) {
              return 2;
            }
          },
          format: function (d) {
            YaxisArr.push(Math.round(d));
            return Math.round(d);
          },
        },
      },
    },
    chart: {
      color: {
        pattern: ["#43A047", "#03a9f4"],
      },
    },
    bar: {
      width: {
        ratio: 0.9,
      },
    },
  });

  var trace2 = {
    x: [1, 2, 3, 4],
    type: "box",
    name: "2",
  };

  var dataBoxplot2 = [trace2];

  var layout = {
    title: "",
    showlegend: false,
    autosize: true,
    height: 100,
    margin: {
      l: 0,
      r: 0,
      b: 0,
      t: 0,
    },
  };
  Plotly.newPlot("BoxPlotChar_week1", dataBoxplot2, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_week2", dataBoxplot2, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_week3", dataBoxplot2, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_week4", dataBoxplot2, layout, {
    displayModeBar: false,
  });

  var trace2 = {
    x: [1, 2, 3, 4],
    type: "box",
    name: "2",
  };

  var dataBoxplot3 = [trace2];

  var layout = {
    title: "",
    showlegend: false,
    autosize: true,
    height: 100,
    margin: {
      l: 0,
      r: 0,
      b: 0,
      t: 0,
    },
  };
  Plotly.newPlot("BoxPlotChar_lastf1", dataBoxplot3, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_lastf2", dataBoxplot3, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_lastf3", dataBoxplot3, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_lastf4", dataBoxplot3, layout, {
    displayModeBar: false,
  });

  var barDataweek = [0, 0, 0, 1, 0, 2, 0, 3, 0, 0, 0, 0];
  var chart = c3.generate({
    bindto: "#BottomBarGraphLeftStillInEDLeftlastf",
    data: {
      labels: true,
      columns: [["data1", ...barDataweek]],

      type: "bar",
      onclick: function (d, i) {
        // setCount(count++);
        console.log("onclick", d, i);
      },
      colors: {
        data1: "#03a9f4",
        data2: "#4CAF50",
      },
    },
    size: {
      // width: ,
      height: 180,
    },
    padding: {
      bottom: 0,
      top: 5,
      left: 50,
      right: 10,
    },
    legend: {
      show: false,
    },
    tooltip: {
      format: {
        value: function (value, ratio, id, index) {
          return value;
        },
      },
    },
    axis: {
      x: {
        show: true,
        label: {
          text: "Hours In Dept From Arrival To Departure",
          position: "outer-right",
        },
      },
      y: {
        show: true,
        label: {
          text: "Patients",
          position: "outer-top",
        },
        tick: {
          count: function (d) {
            let maxAxisvalue = Math.max.apply(null, [...YaxisArr]);
            console.log(maxAxisvalue, "max axis value");
            if (maxAxisvalue > 4) {
              return 6;
            }
            if (maxAxisvalue === 4) {
              return 5;
            }
            if (maxAxisvalue === 3) {
              return 4;
            }
            if (maxAxisvalue === 2) {
              return 3;
            }
            if (maxAxisvalue === 1) {
              return 2;
            }
          },
          format: function (d) {
            YaxisArr.push(Math.round(d));
            return Math.round(d);
          },
        },
      },
    },
    chart: {
      color: {
        pattern: ["#43A047", "#03a9f4"],
      },
    },
    bar: {
      width: {
        ratio: 0.9,
      },
    },
  });

  var chart = c3.generate({
    bindto: "#BottomBarGraphLeftStillInEDRightlastf",
    data: {
      labels: true,
      columns: [["data1", ...barData]],

      type: "bar",
      onclick: function (d, i) {
        // setCount(count++);
        console.log("onclick", d, i);
      },
      colors: {
        data1: "#03a9f4",
        data2: "#4CAF50",
      },
    },
    size: {
      // width: ,
      height: 180,
    },
    padding: {
      bottom: 0,
      top: 5,
      left: 50,
      right: 10,
    },
    legend: {
      show: false,
    },
    tooltip: {
      format: {
        value: function (value, ratio, id, index) {
          return value;
        },
      },
    },
    axis: {
      x: {
        show: true,
        label: {
          text: "Hours In Dept From Arrival To Departure",
          position: "outer-right",
        },
      },
      y: {
        show: true,
        label: {
          text: "Patients",
          position: "outer-top",
        },
        tick: {
          count: function (d) {
            let maxAxisvalue = Math.max.apply(null, [...YaxisArr]);
            console.log(maxAxisvalue, "max axis value");
            if (maxAxisvalue > 4) {
              return 6;
            }
            if (maxAxisvalue === 4) {
              return 5;
            }
            if (maxAxisvalue === 3) {
              return 4;
            }
            if (maxAxisvalue === 2) {
              return 3;
            }
            if (maxAxisvalue === 1) {
              return 2;
            }
          },
          format: function (d) {
            YaxisArr.push(Math.round(d));
            return Math.round(d);
          },
        },
      },
    },
    chart: {
      color: {
        pattern: ["#43A047", "#03a9f4"],
      },
    },
    bar: {
      width: {
        ratio: 0.9,
      },
    },
  });

  var trace2 = {
    x: [1, 2, 3, 4],
    type: "box",
    name: "2",
  };

  var dataBoxplot4 = [trace2];

  var layout = {
    title: "",
    showlegend: false,
    autosize: true,
    height: 100,
    margin: {
      l: 0,
      r: 0,
      b: 0,
      t: 0,
    },
  };
  Plotly.newPlot("BoxPlotChar_lastth1", dataBoxplot4, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_lastth2", dataBoxplot4, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_lastth3", dataBoxplot4, layout, {
    displayModeBar: false,
  });
  Plotly.newPlot("BoxPlotChar_lastth4", dataBoxplot4, layout, {
    displayModeBar: false,
  });

  var barDataweek = [0, 0, 0, 1, 0, 2, 0, 3, 0, 0, 0, 0];
  var chart = c3.generate({
    bindto: "#BottomBarGraphLeftStillInEDLeftlastth",
    data: {
      labels: true,
      columns: [["data1", ...barDataweek]],

      type: "bar",
      onclick: function (d, i) {
        // setCount(count++);
        console.log("onclick", d, i);
      },
      colors: {
        data1: "#03a9f4",
        data2: "#4CAF50",
      },
    },
    size: {
      // width: ,
      height: 180,
    },
    padding: {
      bottom: 0,
      top: 5,
      left: 50,
      right: 10,
    },
    legend: {
      show: false,
    },
    tooltip: {
      format: {
        value: function (value, ratio, id, index) {
          return value;
        },
      },
    },
    axis: {
      x: {
        show: true,
        label: {
          text: "Hours In Dept From Arrival To Departure",
          position: "outer-right",
        },
      },
      y: {
        show: true,
        label: {
          text: "Patients",
          position: "outer-top",
        },
        tick: {
          count: function (d) {
            let maxAxisvalue = Math.max.apply(null, [...YaxisArr]);
            console.log(maxAxisvalue, "max axis value");
            if (maxAxisvalue > 4) {
              return 6;
            }
            if (maxAxisvalue === 4) {
              return 5;
            }
            if (maxAxisvalue === 3) {
              return 4;
            }
            if (maxAxisvalue === 2) {
              return 3;
            }
            if (maxAxisvalue === 1) {
              return 2;
            }
          },
          format: function (d) {
            YaxisArr.push(Math.round(d));
            return Math.round(d);
          },
        },
      },
    },
    chart: {
      color: {
        pattern: ["#43A047", "#03a9f4"],
      },
    },
    bar: {
      width: {
        ratio: 0.9,
      },
    },
  });

  var chart = c3.generate({
    bindto: "#BottomBarGraphLeftStillInEDRightlastth",
    data: {
      labels: true,
      columns: [["data1", ...barData]],

      type: "bar",
      onclick: function (d, i) {
        // setCount(count++);
        console.log("onclick", d, i);
      },
      colors: {
        data1: "#03a9f4",
        data2: "#4CAF50",
      },
    },
    size: {
      // width: ,
      height: 180,
    },
    padding: {
      bottom: 0,
      top: 5,
      left: 50,
      right: 10,
    },
    legend: {
      show: false,
    },
    tooltip: {
      format: {
        value: function (value, ratio, id, index) {
          return value;
        },
      },
    },
    axis: {
      x: {
        show: true,
        label: {
          text: "Hours In Dept From Arrival To Departure",
          position: "outer-right",
        },
      },
      y: {
        show: true,
        label: {
          text: "Patients",
          position: "outer-top",
        },
        tick: {
          count: function (d) {
            let maxAxisvalue = Math.max.apply(null, [...YaxisArr]);
            console.log(maxAxisvalue, "max axis value");
            if (maxAxisvalue > 4) {
              return 6;
            }
            if (maxAxisvalue === 4) {
              return 5;
            }
            if (maxAxisvalue === 3) {
              return 4;
            }
            if (maxAxisvalue === 2) {
              return 3;
            }
            if (maxAxisvalue === 1) {
              return 2;
            }
          },
          format: function (d) {
            YaxisArr.push(Math.round(d));
            return Math.round(d);
          },
        },
      },
    },
    chart: {
      color: {
        pattern: ["#43A047", "#03a9f4"],
      },
    },
    bar: {
      width: {
        ratio: 0.9,
      },
    },
  });

  var ctx = document
    .getElementById("DonutChartBreachsecLeft_lastth")
    .getContext("2d");
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: "doughnut",

    // The data for our dataset
    data: {
      labels: ["Breaches"],
      datasets: [
        {
          data: [50, 50],
          // data: [10, 90],
          backgroundColor: ["#0075be", "#81D4FA"],
          borderColor: ["#0075be", "#81D4FA"],
          borderWidth: 1,
        },
      ],
    },

    // Configuration options go here
    options: {},
  });

  var ctx = document
    .getElementById("DonutChartBreachsecRight_lastth")
    .getContext("2d");
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: "doughnut",

    // The data for our dataset
    data: {
      labels: ["Breaches"],
      datasets: [
        {
          data: [50, 50],
          // data: [10, 90],
          backgroundColor: ["#0075be", "#81D4FA"],
          borderColor: ["#0075be", "#81D4FA"],
          borderWidth: 1,
        },
      ],
    },

    // Configuration options go here
    options: {},
  });
}
