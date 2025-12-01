const data = [
  { startTime: 2, midTime: 5, endTime: 6, hours_next_day: 6 },
  { startTime: 5, midTime: 10, endTime: 12, hours_next_day: 12 },
  { startTime: 15, midTime: 17, endTime: 19, hours_next_day: 19 },
  { startTime: 2, midTime: 5, endTime: 6, hours_next_day: 6 },
  { startTime: 5, midTime: 10, endTime: 12, hours_next_day: 12 },
  { startTime: 15, midTime: 17, endTime: 19, hours_next_day: 19 },
];
// cx="38.3" cy="154.2" r="3.3"

const RowHeight = 30;
const width =
  document.getElementById("gannetChartinBarGrpahunder").clientWidth + 3;
const colWidth = width / 24;

const DotRadious = 8;

const WIDTH = width;

const HEIGHT = RowHeight * data.length;
const MARGIN = { top: 0, right: 0, bottom: 0, left: 40 };
const INNER_WIDTH = WIDTH - MARGIN.left - MARGIN.right;
const INNER_HEIGHT = HEIGHT - MARGIN.top - MARGIN.bottom;

const svgHeight = data.length * RowHeight;
// if (GanntChart.current.childElementCount > 0) {
//   GanntChart.current.childNodes[0].remove();
// }

const graph = d3
  .select("#gannetChartinBarGrpahunder")
  .append("svg")
  // .attr("class", "BreachesGanntChart")
  .attr("class", function () {
    return "BreachesGanntChart pad" + 0 + "";
  })
  .attr("width", "100%")
  .attr("height", "100%")
  .attr("xmlSpace", "preserve")
  .attr("enableBackground", "new 0 0 " + width + " " + svgHeight + " ")
  .attr("viewBox", "0 0 " + width + " " + svgHeight + "");

var yscale = d3.scaleBand().domain([0, 1]).range([INNER_HEIGHT, 0]);
var y_axis = d3.axisLeft().scale(yscale).tickFormat("");
graph
  .append("g")
  .attr("class", "yaxisline")
  .attr("transform", "translate(" + 0 + ",0)")
  .call(y_axis);

const BarRow = graph
  .selectAll("svg")
  .data(data)
  .enter()
  .append("g")
  // .attr("class", "boxrow")
  .attr("class", function (d) {
    if (d.startTime === 0) {
      return "boxrow startFromfirstcell";
    } else {
      return "boxrow";
    }
  })
  .attr("transform", function (d, i) {
    var startPos = d.startTime * colWidth;
    var spaces = d.startTime;
    startPos = startPos - spaces;
    startPos = startPos + 5;
    return "translate( " + startPos + " , " + i * RowHeight + ")";
  });

const DataLine = BarRow.data(data)
  .append("line")
  .attr("class", "MainLine")
  .attr("x1", "0")
  .attr("x2", function (d, i) {
    var timeGap = d.endTime - d.startTime;

    return colWidth * timeGap;
  })
  .attr("y1", "20")
  .attr("y2", "20");

const dataCircleFirst = BarRow.data(data)
  .append("circle")
  .attr("class", function (d, i) {
    if (d.startTime == 0 && d.midTime == 0) {
      return "cir cir_first noval";
    } else {
      return "cir cir_first";
    }
  })
  .attr("cx", DotRadious)
  .attr("cy", "20")
  .attr("r", DotRadious);

const dataCircleLast = BarRow.data(data)
  .append("circle")
  // .attr("class", "cir cir_last")
  .attr("class", function (d, i) {
    if (d.haveLeftEDtommorrow) {
      return "cir cir_last leftEDTommarrow";
    }

    if (d.haveLeftEDDischarged) {
      return "cir cir_last leftEDDischarge";
    }

    if (d.haveLeftEDAdmitted) {
      return "cir cir_last leftEDAdmitted";
    }

    return "cir cir_last";
  })
  .attr("cx", function (d, i) {
    var timeGap = d.endTime - d.startTime;
    if (d.midTime === d.endTime) {
      return colWidth * timeGap + DotRadious + 20;
    } else {
      return colWidth * timeGap + DotRadious;
    }
  })

  .attr("cy", "20")
  .attr("r", DotRadious);

const dataCircleCenter = BarRow.data(data)
  .append("circle")
  .attr("class", function (d, i) {
    if (d.startTime == 0 && d.midTime == 0) {
      return "cir cir_mid willbeFirst";
    } else {
      if (d.startTime === 0) {
        return "cir cir_mid firstvalueEndAlign";
      } else {
        return "cir cir_mid";
      }
    }
  })
  .attr("cx", function (d, i) {
    var timeGap = d.midTime - d.startTime;
    var pos = timeGap * colWidth;

    if (d.midTime === d.endTime) {
      return pos + DotRadious * 2 - 5;
    } else {
      return pos + DotRadious * 2 + 4;
    }
  })
  .attr("cy", "20")
  .attr("r", DotRadious);

BarRow.append("text")
  .data(data)
  .attr("dominant-baseline", "middle")
  .attr("text-anchor", "middle")
  .attr("class", function (d, i) {
    if (d.startTime == 0 && d.midTime == 0) {
      return "startCircleTxt noval";
    } else {
      return "startCircleTxt";
    }
  })
  .text(function (d, i) {
    if (d.haveArrivalYesterday) {
      return "Y";
    } else {
      return null;
    }
  });

BarRow.append("text")
  .data(data)
  .attr("dominant-baseline", "middle")
  .attr("text-anchor", "middle")
  .attr("class", function (d, i) {
    if (d.haveLeftEDtommorrow) {
      return "endCircleTxt leftEDtommarow";
    }

    if (d.haveLeftEDDischarged) {
      return "endCircleTxt leftEDDischarge";
    }

    if (d.haveLeftEDAdmitted) {
      return "endCircleTxt leftEDAdmitted";
    }
  })

  .attr("style", function (d, i) {
    var timeGap = d.endTime - d.startTime;
    var pos = colWidth * timeGap + DotRadious;
    if (d.midTime === d.endTime) {
      pos = pos + 20;
    }

    return "transform:translate(" + pos + "px, " + 21 + "px)";
  })
  .text(function (d, i) {
    if (d.haveLeftEDtommorrow) {
      return "T";
    }

    if (d.haveLeftEDDischarged) {
      return "H";
    }

    if (d.haveLeftEDAdmitted) {
      return "A";
    }
  });

BarRow.append("text")
  .data(data)
  .attr("dominant-baseline", "middle")
  .attr("text-anchor", "middle")
  .attr("class", function (d, i) {
    return "endnextCircleTxt";
  })

  .attr("style", function (d, i) {
    var timeGap = d.endTime - d.startTime;
    var pos = colWidth * timeGap + DotRadious;
    return "transform:translate(" + (pos + 20) + "px, " + 21 + "px)";
  })
  .text(function (d, i) {
    if (d.hours_next_day !== "") {
      return "+" + d.hours_next_day;
    }
  });

BarRow.append("text")
  .data(data)
  .attr("dominant-baseline", "middle")
  .attr("text-anchor", "middle")
  .attr("class", function (d, i) {
    if (d.startTime == 0 && d.midTime == 0) {
      return "midCircleTxt willbeFirsttxt";
    } else {
      if (d.startTime === 0) {
        return "firstvalueEndAlign midCircleTxt";
      } else {
        return "midCircleTxt";
      }
    }
  })

  .attr("style", function (d, i) {
    var timeGap = d.midTime - d.startTime;
    var pos = timeGap * colWidth;
    if (d.midTime === d.endTime) {
      pos = pos + 11;
    } else {
      pos = pos + 20;
    }
    return "transform:translate(" + pos + "px, " + 21 + "px)";
  })
  .text(function (d, i) {
    return "X";
  });
