(function($) {
    $.fn.scatterplot = function(options) {
        var defaults = {
            height: "100%",
            width: "99.9%",
            marginLeft: "5px",
            marginRight: "0px",
            marginTop: "20",
            marginBottom: "10",
            innerTickSize: 10,
            yAxisKey: "",
            valChart: "val",
            xAxisKey: "hour",
            data: "",
            xAxisArray: ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
            scatterKey: ["ARRIVAL_HOUR", "DEPARTURE_HOUR", "Breach_HOUR"],
            yAxisVal: "PATIENT_HOSP_ID",
            xAxisOpacity: "0",
            colorObj: {
                "ARRIVAL_HOUR": "#00acbc",
                "DEPARTURE_HOUR": "#4865a9",
                "Breach_HOUR": "#8353af"
            },
            crossIcon: "ARRIVAL_HOUR",
            validateOn: "ARRIVAL_HOUR",
            validateCond: "3",
            validateConFor: "Breach_HOUR",
            xAxisLable: "",
            yAxisLable: "",
            leftLine: true,
            distanebetweenCirc: 25,
            onloadFlag: true
        }
        var settings = $.extend(defaults, options);
        var plugin = this;
        var cont_id = this.attr("id");

        if (settings.height.indexOf("%") > -1) {
            settings.height = $("#" + cont_id).height() * ((settings.height.split("%")[0]) / 100);
        };
        if (settings.width.indexOf("%") > -1) {
            settings.width = $("#" + cont_id).width() * ((settings.width.split("%")[0]) / 100);
        };
        if (settings.marginLeft.indexOf("%") > -1) {
            settings.marginLeft = $("#" + cont_id).width() * ((settings.marginLeft.split("%")[0]) / 100);
        };
        if (settings.marginRight.indexOf("%") > -1) {
            settings.marginRight = $("#" + cont_id).width() * ((settings.marginRight.split("%")[0]) / 100);
        };
        if (settings.marginTop.indexOf("%") > -1) {
            settings.marginTop = $("#" + cont_id).height() * ((settings.marginTop.split("%")[0]) / 100);
        };
        if (settings.marginBottom.indexOf("%") > -1) {
            settings.marginBottom = $("#" + cont_id).height() * ((settings.marginBottom.split("%")[0]) / 100);
        };

        settings.height = parseInt(settings.height);
        settings.width = parseInt(settings.width);
        settings.marginLeft = parseInt(settings.marginLeft);
        settings.marginRight = parseInt(settings.marginRight);
        settings.marginTop = parseInt(settings.marginTop);
        settings.marginBottom = parseInt(settings.marginBottom);

        var svg, svgId, x, y, y1, color, xAxis, yAxis, yAxis1, color;
        var colors = ["#b33040", "#d25c4d", "#f2b447", "#d9d574"];

        var dataHeight = settings.data.length * settings.distanebetweenCirc;
        if (settings.data.length < 6) {
            dataHeight = 200;
        }
        settings.height = settings.height + dataHeight;

        svgId = cont_id + "_Main";
        svg = d3.select("#" + cont_id).append("svg").attr("width",
                settings.width + settings.marginLeft + settings.marginRight).attr("height",
                settings.height + settings.marginTop + settings.marginBottom)
            .attr("id", svgId).append("g")
            .attr("transform", "translate(" + (settings.marginLeft) + "," + (settings.marginTop) / 2 + ")")
            .attr("text", JSON.stringify(settings));

        color = d3.scale.category20c();
        //x = d3.time.scale().range([0, settings.width]);
        x = d3.scale.ordinal().rangeBands([0, settings.width]);
        //y = d3.scale.linear().range([(settings.height-settings.marginTop), settings.marginTop]);
        y = d3.scale.ordinal().rangeRoundBands([(settings.height - settings.marginTop), settings.marginTop], 0.1);

        xAxis = d3.svg.axis().scale(x).orient("bottom");
        yAxis = d3.svg.axis().scale(y).orient("left").innerTickSize(-(settings.innerTickSize))

        x.domain(settings.xAxisArray);
        y.domain(settings.data.map(function(d) {
            return d[settings.yAxisVal];
        }));

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + (settings.height - settings.marginTop) + ")")
            .style("opacity", settings.xAxisOpacity)
            .call(xAxis)
            .append("text")
            .attr("transform", "rotate(0)")
            .attr("x", (settings.width - (20)))
            .style("text-anchor", "end")
            .attr("class", "xAxisLableCls")
            .text(function() {
                if (settings.xAxisLable != null && settings.xAxisLable != undefined) {
                    return settings.xAxisLable
                } else {
                    return ""
                }
            });

        if (settings.leftLine) {
            svg.append("line")
                .attr("x1", 0)
                .attr("x2", 0)
                .attr("y1", 0)
                .attr("y2", settings.height)
                .attr("stroke", "#c9c9c9")
                .attr("stroke-width", 2);

        }
        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .style("text-anchor", "end")
            .attr("class", "yAxisLableCls")
            .attr("y", "-15")
            .attr("x", "-90")
            .text(function() {
                if (settings.yAxisLable != null && settings.xAxisLable != undefined) {
                    return settings.yAxisLable
                } else {
                    return ""
                }
            });


        $.each(settings.data, function(k, v) {

            var joinLineData = [];
            $.each(settings.scatterKey, function(k1, v1) {
                if (v[v1] && v[v1] != null) {
                    if (v1 == "ARRIVAL_HOUR") {
                        if (settings.onloadFlag) {
                            if (parseInt(v["Breach_HOUR"]) > parseInt(3)) {
                                joinLineData.push({
                                    "x": v[v1],
                                    "y": v[settings.yAxisVal]
                                });
                            } else {
                                joinLineData.push({
                                    "x": "00",
                                    "y": v[settings.yAxisVal]
                                });
                            }
                        } else {
                            joinLineData.push({
                                "x": v[v1],
                                "y": v[settings.yAxisVal]
                            });
                        }
                    } else if (v1 == "DEPARTURE_HOUR") {
                        if (parseInt(v["DEPARTURE_HOUR"]) > parseInt(v["Breach_HOUR"])) {
                            joinLineData.push({
                                "x": v[v1],
                                "y": v[settings.yAxisVal]
                            });
                        } else if (parseInt(v["DEPARTURE_HOUR"]) == parseInt(v["Breach_HOUR"])) {
                            joinLineData.push({
                                "x": v[v1],
                                "y": v[settings.yAxisVal]
                            });
                        } else {
                            joinLineData.push({
                                "x": settings.xAxisArray[settings.xAxisArray.length - 1],
                                "y": v[settings.yAxisVal]
                            });
                        }
                    } else {
                        joinLineData.push({
                            "x": v[v1],
                            "y": v[settings.yAxisVal]
                        });
                    }

                }
            });
            var line = d3.svg.line()
                .x(function(d) {
                    return x(d["x"]) + x.rangeBand() / 2;
                })
                .y(function(d) {
                    return (y(d["y"]));
                });
            var ArrivalIdentifier = svg.append("g");
            ArrivalIdentifier.append("path")
                .datum(joinLineData)
                .attr("fill", "none")
                .attr("stroke", "steelblue")
                .attr("stroke-linejoin", "round")
                .attr("stroke-linecap", "round")
                .attr("stroke-width", 1.5)
                .attr("d", line);


            $.each(settings.scatterKey, function(k1, v1) {
                if (v[v1] && v[v1] != null) {
                    if (v1 == "ARRIVAL_HOUR") {
                        if (settings.onloadFlag) {
                            if (parseInt(v["Breach_HOUR"]) > parseInt(3)) {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return x(v[v1]) + x.rangeBand() / 2;

                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        if (settings.colorObj[v1]) {
                                            return settings.colorObj[v1]
                                        } else {
                                            return color(k1)
                                        }
                                    });

                            } else {
                                if (parseInt(v["Breach_HOUR"]) > 0) {
                                    ArrivalIdentifier.append("circle")
                                        .attr("r", x.rangeBand() / 6)
                                        .attr("cx", function() {
                                            return x("00") + x.rangeBand() / 2
                                        })
                                        .attr("cy", function() {
                                            return (y(v[settings.yAxisVal]))
                                        })
                                        .attr("fill", function() {
                                            if (settings.colorObj[v1]) {
                                                return settings.colorObj[v1]
                                            } else {
                                                return color(k1)
                                            }
                                        });
                                    ArrivalIdentifier.append("text")
                                        .attr("x", function() {
                                            return x("00") + x.rangeBand() / 2
                                        })
                                        .attr("y", function() {
                                            return (y(v[settings.yAxisVal]))
                                        })
                                        .attr("dy", 4)
                                        .attr("dx", -4)
                                        .text("Y")
                                        .attr("font-weight", "bold")
                                        .attr("fill", function() {
                                            return "#ffffff";
                                        });
                                }
                            }

                        } else {

                            ArrivalIdentifier.append("circle")
                                .attr("r", x.rangeBand() / 6)
                                .attr("cx", function() {
                                    return x(v[v1]) + x.rangeBand() / 2
                                })
                                .attr("cy", function() {
                                    return (y(v[settings.yAxisVal]))
                                })
                                .attr("fill", function() {
                                    if (settings.colorObj[v1]) {
                                        return settings.colorObj[v1]
                                    } else {
                                        return color(k1)
                                    }
                                });


                        }


                    } else if (v1 == "Breach_HOUR") {

                        if (parseInt(v["DEPARTURE_HOUR"]) == parseInt(v["Breach_HOUR"]) && parseInt(v["DEPARTURE_HOUR"]) <= 23) {
                            ArrivalIdentifier.append("circle")
                                .attr("r", x.rangeBand() / 6)
                                .attr("cx", function() {
                                    return (x(v[v1]) + x.rangeBand() / 2) - 7
                                })
                                .attr("cy", function() {
                                    return (y(v[settings.yAxisVal]))
                                })
                                .attr("fill", function() {
                                    if (settings.colorObj[v1]) {
                                        return settings.colorObj[v1]
                                    } else {
                                        return color(k1)
                                    }
                                });

                            ArrivalIdentifier.append("text")
                                .attr("x", function() {
                                    return (x(v[v1]) + x.rangeBand() / 2) - 7
                                })
                                .attr("y", function() {
                                    return (y(v[settings.yAxisVal]))
                                })
                                .attr("dy", 3)
                                .attr("dx", -3)
                                .text("x")
                                .attr("font-weight", "bold")
                                .attr("fill", function() {
                                    return "#ffffff"
                                });
                        } else if (parseInt(v["Breach_HOUR"]) == 23) {
                            ArrivalIdentifier.append("circle")
                                .attr("r", x.rangeBand() / 6)
                                .attr("cx", function() {
                                    return (x(v[v1]) + x.rangeBand() / 2) - 5;
                                })
                                .attr("cy", function() {
                                    return (y(v[settings.yAxisVal]))
                                })
                                .attr("fill", function() {
                                    if (settings.colorObj[v1]) {
                                        return settings.colorObj[v1]
                                    } else {
                                        return color(k1)
                                    }
                                });
                            ArrivalIdentifier.append("text")
                                .attr("x", function() {
                                    return (x(v[v1]) + x.rangeBand() / 2) - 5
                                })
                                .attr("y", function() {
                                    return (y(v[settings.yAxisVal]))
                                })
                                .attr("dy", 3)
                                .attr("dx", -3)
                                .text("x")
                                .attr("font-weight", "bold")
                                .attr("fill", function() {
                                    return "#ffffff"
                                });
                        } else {
                            ArrivalIdentifier.append("circle")
                                .attr("r", x.rangeBand() / 6)
                                .attr("cx", function() {
                                    return x(v[v1]) + x.rangeBand() / 2
                                })
                                .attr("cy", function() {
                                    return (y(v[settings.yAxisVal]))
                                })
                                .attr("fill", function() {
                                    if (settings.colorObj[v1]) {
                                        return settings.colorObj[v1]
                                    } else {
                                        return color(k1)
                                    }
                                });
                            ArrivalIdentifier.append("text")
                                .attr("x", function() {
                                    return x(v[v1]) + x.rangeBand() / 2
                                })
                                .attr("y", function() {
                                    return (y(v[settings.yAxisVal]))
                                })
                                .attr("dy", 3)
                                .attr("dx", -3)
                                .text("x")
                                .attr("font-weight", "bold")
                                .attr("fill", function() {
                                    return "#ffffff"
                                });
                        }

                    } else if (v1 == "DEPARTURE_HOUR") {

                        if (parseInt(v["DEPARTURE_HOUR"]) > parseInt(v["Breach_HOUR"]) && parseInt(v["DEPARTURE_HOUR"]) <= 23) {


                            if (v["Patient_Status"] == 1) {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        return "#ae125b"
                                    });

                                ArrivalIdentifier.append("text")
                                    .attr("x", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) - 6
                                    })
                                    .attr("y", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("dy", 4)
                                    .attr("dx", -3)
                                    .text("A")
                                    .attr("font-weight", "bold")
                                    .attr("fill", function() {
                                        return "#ffffff"
                                    });
                            } else if (v["Patient_Status"] == 2) {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        if (settings.colorObj[v1]) {
                                            return settings.colorObj[v1]
                                        } else {
                                            return color(k1)
                                        }
                                    });

                                ArrivalIdentifier.append("text")
                                    .attr("x", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) - 6
                                    })
                                    .attr("y", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("dy", 4)
                                    .attr("dx", -3)
                                    .text("H")
                                    .attr("font-weight", "bold")
                                    .attr("fill", function() {
                                        return "#ffffff"
                                    });
                            } else {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        if (settings.colorObj[v1]) {
                                            return settings.colorObj[v1]
                                        } else {
                                            return color(k1)
                                        }
                                    });

                            }
                        } else if (parseInt(v["DEPARTURE_HOUR"]) == parseInt(v["Breach_HOUR"]) && parseInt(v["DEPARTURE_HOUR"]) <= 23) {


                            if (v["Patient_Status"] == 1) {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) + 7
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        return "#8353af";
                                    });

                                ArrivalIdentifier.append("text")
                                    .attr("x", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) + 7
                                    })
                                    .attr("y", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("dy", 4)
                                    .attr("dx", -4)
                                    .text("A")
                                    .attr("font-weight", "bold")
                                    .attr("fill", function() {
                                        return "#ffffff"
                                    });
                            } else if (v["Patient_Status"] == 2) {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) + 7
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        if (settings.colorObj[v1]) {
                                            return settings.colorObj[v1]
                                        } else {
                                            return color(k1)
                                        }
                                    });

                                ArrivalIdentifier.append("text")
                                    .attr("x", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) + 7
                                    })
                                    .attr("y", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("dy", 4)
                                    .attr("dx", -4)
                                    .text("H")
                                    .attr("font-weight", "bold")
                                    .attr("fill", function() {
                                        return "#ffffff"
                                    });
                            } else {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(v[v1]) + x.rangeBand() / 2) + 7
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        if (settings.colorObj[v1]) {
                                            return settings.colorObj[v1]
                                        } else {
                                            return color(k1)
                                        }
                                    });



                            }


                        } else {

                            if (v["Patient_Status"] == 1) {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(settings.xAxisArray[settings.xAxisArray.length - 1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        return "#8353af";
                                    });



                                ArrivalIdentifier.append("text")
                                    .attr("x", function() {
                                        return (x(settings.xAxisArray[settings.xAxisArray.length - 1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("y", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("dy", 4)
                                    .attr("dx", -4)
                                    .text("A")
                                    .attr("font-weight", "bold")
                                    .attr("fill", function() {
                                        return "#ffffff"
                                    });
                            } else if (v["Patient_Status"] == 2) {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(settings.xAxisArray[settings.xAxisArray.length - 1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        if (settings.colorObj[v1]) {
                                            return settings.colorObj[v1]
                                        } else {
                                            return color(k1)
                                        }
                                    });



                                ArrivalIdentifier.append("text")
                                    .attr("x", function() {
                                        return (x(settings.xAxisArray[settings.xAxisArray.length - 1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("y", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("dy", 4)
                                    .attr("dx", -4)
                                    .text("H")
                                    .attr("font-weight", "bold")
                                    .attr("fill", function() {
                                        return "#ffffff"
                                    });
                            } else {
                                ArrivalIdentifier.append("circle")
                                    .attr("r", x.rangeBand() / 6)
                                    .attr("cx", function() {
                                        return (x(settings.xAxisArray[settings.xAxisArray.length - 1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("cy", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("fill", function() {
                                        if (settings.colorObj[v1]) {
                                            return settings.colorObj[v1]
                                        } else {
                                            return color(k1)
                                        }
                                    });



                                ArrivalIdentifier.append("text")
                                    .attr("x", function() {
                                        return (x(settings.xAxisArray[settings.xAxisArray.length - 1]) + x.rangeBand() / 2) - 5
                                    })
                                    .attr("y", function() {
                                        return (y(v[settings.yAxisVal]))
                                    })
                                    .attr("dy", 4)
                                    .attr("dx", -3)
                                    .text("T")
                                    .attr("font-weight", "bold")
                                    .attr("fill", function() {
                                        return "#ffffff"
                                    });
                            }

                            ArrivalIdentifier.append("text")
                                .attr("x", function() {
                                    return (x(settings.xAxisArray[settings.xAxisArray.length - 1]) + x.rangeBand() / 2) - 4
                                })
                                .attr("y", function() {
                                    return (y(v[settings.yAxisVal])) + 1
                                })
                                .attr("dy", 3)
                                .attr("dx", 7)
                                .text(function() {
                                    if (parseInt(v["DEPARTURE_HOUR"]) == 0) {
                                        return "+1"
                                    } else {
                                        return "+" + (parseInt(v["DEPARTURE_HOUR"]) + 1)
                                    }
                                })
                                .attr("font-weight", "bold")
                                .attr("fill", function() {
                                    return "#000000"
                                });
                        }
                    }
                }
            });
        });
    };
}(jQuery));