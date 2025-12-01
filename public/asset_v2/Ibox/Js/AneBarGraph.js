
var colorsBar = {
    green: "#2fb07d",
    yellow: "#ffe44a",
    orange: "#fc8432",
    red: "#ff695d",
    black: "#000000",
};
var data = [];
for (var i = 0; i < barData.length; i++) {
    var min = barData[i].minutes;
    var a = min / 60;
    var str_a = a.toString();
    var result = Number(str_a.slice(0, 4));
    data.push(result);
}
var maxDataVal = Math.max.apply(null, data);
if (window.innerWidth > 2000 && window.innerWidth < 3000) {
    var calcuBarHeight = 565 / data.length;
    var barHeightSvg = 585;
} else if (window.innerWidth > 1600 && window.innerWidth < 2000) {
    var calcuBarHeight = 565 / data.length;
    var barHeightSvg = 585;
} else if (window.innerWidth > 1368 && window.innerWidth < 1600) {
    var calcuBarHeight = 565 / data.length;
    var barHeightSvg = 585;
} else {
    var calcuBarHeight = 565 / data.length;
    var barHeightSvg = 585;
}

var width = "100%";
var scaleFactor = 10;
if (calcuBarHeight < 15) {
    var barHeight = 15;
    barHeightSvg = 15 * data.length + 20;
} else {
    var barHeight = calcuBarHeight;
}

var leftRectW = 50;

var graph = d3
    .select("#BarGraphWrap")
    .append("svg")
    .attr("class", "DtaSvgGraph")
    .attr("width", width)
    .attr("height", "100%")
    .attr("xmlSpace", "preserve")
    .attr("enableBackground", "new 0 0 473 " + barHeightSvg + "")
    .attr("viewBox", "0 0 473 " + barHeightSvg + "");

var WIDTH = 423;

var HEIGHT = barHeight * data.length;
var MARGIN = { top: 0, right: 0, bottom: 0, left: 40 };
var INNER_WIDTH = WIDTH - MARGIN.left - MARGIN.right;
var INNER_HEIGHT = HEIGHT - MARGIN.top - MARGIN.bottom;

var DomainWidth = WIDTH / maxDataVal;

var x = d3.scaleLinear().domain([0, DomainWidth]).range([0, WIDTH]);
var xAxisGrid = d3
    .axisBottom(x)
    .tickSize(-INNER_HEIGHT)
    .tickFormat("")
    .ticks(maxDataVal);

var gridLineouterWrap = graph
    .append("g")
    .attr("style", "opacity:0.4")
    .attr("id", "gridLinewrap")
    .attr("transform", "translate( " + 55 + "," + 20 + ")");

var gridLineWrapinner = gridLineouterWrap
    .selectAll("svg")
    .data(data)
    .enter()
    .append("g")
    .attr("class", "gridLineWrapinner");

gridLineWrapinner
    .append("line")
    .data(data)
    .attr("class", "gridLines")
    .attr("x1", function(d, i) {
        var totDiv = WIDTH / maxDataVal;
        return totDiv * i;
    })
    .attr("x2", function(d, i) {
        var totDiv = WIDTH / maxDataVal;
        return totDiv * i;
    })
    .attr("y1", 0)
    .attr("y2", barHeight * data.length)
    .attr("class", "limitLine_grid");

var bar = graph
    .selectAll("svg")
    .data(data)
    .enter()
    .append("g")
    .attr("transform", function(d, i) {
        return "translate(0," + i * barHeight + ")";
    });

bar
    .append("g")
    .attr("id", "leftBox")
    .attr("style", "transform:translateY(20px)");

graph
    .selectAll("#leftBox")
    .data(barData)
    .append("rect")
    .attr("height", barHeight - 1)
    .attr("width", "50")
    .attr("fill", function(d, i) {
        switch (d.show_location_group) {
            case "Majors":
                return "black";
                break;
            case "Paeds":
                return "#0091c9";
                break;
            case "Others":
                return "#8b1e42";
                break;
            case "Minors":
                return "#00aa9e";
                break;
            case "UTC":
                return "#00aa9e";
                break;
            case "Resus":
                return "#003893";
                break;
            default:
                return "black";
        }
    });

var leftBox = graph.selectAll("#leftBox");
leftBox
    .append("text")
    .data(barData)
    .attr(
        "style",
        "transform:translate(" + leftRectW / 2 + "px, " + barHeight / 2 + "px)"
    )
    .attr("dominant-baseline", "middle")
    .attr("text-anchor", "middle")
    .text(function(d, i) {
        return d.show_location_group;
    })
    .attr("font-size", "10px")
    .attr("class", "bar bar_pointer graphMajResTxt");

    graph.selectAll('.graphMajResTxt').on('click', function() {
        const d = d3.select(this).datum();  // <- always works
        const attendance_id = d.symphony_attendance_id;
        const clickedLocationGroup = d.show_location_group;
        const minutes = d.show_text_bar_left_end;
        const urlOfAttendance = $('#url_of_attendance').attr('data-url');

        console.log('Clicked on attendance Id: ' + attendance_id + ' with  group: ' + clickedLocationGroup + ',,' + minutes);
        GetAttandaceDetailsById(attendance_id, urlOfAttendance);
      });




var divi = WIDTH / maxDataVal;
var fhourLeftPad = divi * 4 + 25;
var fhourTopPad = divi * 4;

var totDivhourTxtgap = WIDTH / maxDataVal;
totDivhourTxtgap = totDivhourTxtgap * 4 + 55 - 22;

graph
    .append("g")
    .attr("class", "foHourTxtarea")
    .attr("id", "foHourTxt")
    .attr("transform", "translate( " + totDivhourTxtgap + "," + 10 + ")");

var fhourBox = graph.selectAll("#foHourTxt");

fhourBox.append("text").attr("class", "foHourTxt").text("4 Hours");

graph
    .append("line")
    .data(data)
    .attr("x1", function(d) {
        var totDiv = WIDTH / maxDataVal;
        return totDiv * 4 + 55;
    })
    .attr("x2", function(d) {
        var totDiv = WIDTH / maxDataVal;
        return totDiv * 4 + 55;
    })
    .attr("y1", 0)
    .attr("y2", barHeight * data.length)
    .attr("class", "limitLine");

bar
    .append("rect")
    .data(data)
    .attr("x", 55)
    .attr("y", 20)
    .attr("width", function(d, i) {
        var totDiv = WIDTH / maxDataVal;
        return totDiv * d;
    })
    .attr("height", barHeight - 1)
    .attr("style", function(d, i) {
        if (d * 60 >= 720) {
            return "fill:" + colorsBar.black + "";
        } else if (d * 60 >= 240) {
            return "fill:" + colorsBar.red + "";
        } else if (d * 60 >= 210) {
            return "fill:" + colorsBar.orange + "";
        } else if (d * 60 >= 90) {
            return "fill:" + colorsBar.yellow + "";
        } else {
            return "fill:" + colorsBar.green + "";
        }
    });

bar
    .append("text")
    .data(barData)

    .attr("class", function(d, i) {

        var count_of_array_det = barData.length;

        var colour_text_acc_bar;
        if (d.minutes >= 720) {
            colour_text_acc_bar = "colour_text_acc_bar_black";
        } else if (d.minutes >= 240) {
            colour_text_acc_bar = "colour_text_acc_bar_maroon";
        } else if (d.minutes >= 210) {
            colour_text_acc_bar = "colour_text_acc_bar_orange";
        } else if (d.minutes >= 90) {
            colour_text_acc_bar = "colour_text_acc_bar_yellow";
        } else {
            colour_text_acc_bar = "colour_text_acc_bar_green";
        }

        if (count_of_array_det < 35) {
            return "barNibTxt in " + colour_text_acc_bar;
        } else {
            if (data[i] > 4) {
                return "barNibTxt in " + colour_text_acc_bar;
            } else {
                return "barNibTxt out ";
            }
        }
    })
    .attr("x", function(d, i) {
        var aaa = WIDTH / maxDataVal;
        return data[i] * aaa + 40;
    })
    .attr("y", barHeight / 2 + 20)
    .attr("dy", ".35em")
    .text(function(d, i) {
        var aaa = WIDTH / maxDataVal;
        var position = data[i] * aaa + 40;

        var maxBarWidth = d3.max(data) * aaa;

        var barWidth = data[i] * aaa;

        var bar_percent = (barWidth / maxBarWidth) * 100;

        var hasLeftText = d.show_text_bar_left_end && d.show_text_bar_left_end.trim() !== "";


        if(bar_percent > 30){
            return '(' + d.show_text_bar_right_end + ')';
        }

    });

bar
    .append("circle")
    .data(barData)
    .attr("class", "circleDot")
    .attr("cx", 63)
    .attr("cy", barHeight / 2)
    .attr("r", 4)
    .attr("style", function(d, i) {
        if (d.check_grey == 0 && d.check_blue == 0) {
            return "display:none";
        }
        if (d.check_grey == 1 && d.check_blue == 0) {
            return "fill:grey";
        }
        if (d.check_grey == 0 && d.check_blue == 1) {
            return "fill:#17539a";
        }
    });
bar
    .append("text")
    .data(barData)
    // .attr("class", "DTAText")
    .attr("class", function(d, i) {
        var colour_text_acc_bar;
        if (d.minutes >= 720) {
            colour_text_acc_bar = "colour_text_acc_bar_black";
        } else if (d.minutes >= 240) {
            colour_text_acc_bar = "colour_text_acc_bar_maroon";
        } else if (d.minutes >= 210) {
            colour_text_acc_bar = "colour_text_acc_bar_orange";
        } else if (d.minutes >= 90) {
            colour_text_acc_bar = "colour_text_acc_bar_yellow";
        } else {
            colour_text_acc_bar = "colour_text_acc_bar_green";
        }

        if (data[i] > 4) {
            return "DTAText in " + colour_text_acc_bar;
        } else {
            return "DTAText out";
        }
    })
    .attr("x", 70)
    .attr("y", function(i) {
        return (barHeight + 5) / 2;
    })
    .text(function(d, i) {
        var aaa = WIDTH / maxDataVal;
        var position = data[i] * aaa + 40;

        var maxBarWidth = d3.max(data) * aaa;
        var barWidth = data[i] * aaa;

        var bar_percent = (barWidth / maxBarWidth) * 100;


        if(bar_percent < 31){



            var hasLeftText = d.show_text_bar_left_end && d.show_text_bar_left_end.trim() !== "";
            var dta_time = d.show_text_bar_left_end;
            var seen_minutes = d.show_text_bar_right_end;

            if (hasLeftText) {
                return d.show_text_bar_left_end + ' - (' + seen_minutes + ')';
            } else {
                return '(' + seen_minutes + ')';
            }
        } else {
            return d.show_text_bar_left_end;
        }
    });
