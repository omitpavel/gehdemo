$(function() {
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 400) {
            let fixedDivWidth = $(".EDActivityGraphWrap").innerWidth();
            $(".activity_profile_fixed_top_matrix_on_scroll").css("width", fixedDivWidth + "px");
            $(".activity_profile_fixed_top_matrix_on_scroll").addClass("active");
        } else {
            $(".activity_profile_fixed_top_matrix_on_scroll").removeClass("active");
        }
    });
    $(document).on("click", ".EDactivityRowClickTriggerList li", function(e) {
        $(".overlay_selection_box").css({
            left: this.offsetLeft + "px",
            display: "block",
            width: e.target.offsetWidth,
            transform: "translateX(" + ($(".leftcolorDiv").width() + 7) + "px)",
        });
    });
    $(document).on("click", ".activeRowRemovecell", function(e) {
        $(".overlay_selection_box").css("display", "none");
    });
    $(document).on("click", ".EDactivityRowClickTriggerList li", function(e) {
        $(".overlay_selection_box").css({
            left: this.offsetLeft + "px",
            display: "block",
        });
    });

    $(document).on("click", ".drop_down_nav_trigger", function(e) {
        $(".check_box_wrapper").toggleClass("show");
    });
});



jQuery(document).ready(function($) {
    $(document).on("click", ".resetallbar", function(e) {

        $(this).removeClass("active");
        $(".c3-target-breaches").css({
            "opacity": 1
        });
        $(".c3-target-arrivals").css({
            "opacity": 1
        });
        $(".c3-target-leftED").css({
            "opacity": 1
        });
        $(".c3-target-forecast").css({
            "opacity": 1
        });
        $(".c3-target-admitted").css({
            "opacity": 1
        });

        $(".adText").css("opacity", 1);
    });




    $(document).on("click", ".admittedBar", function(e) {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 1
            });
            $(".c3-target-arrivals").css({
                "opacity": 1
            });
            $(".c3-target-leftED").css({
                "opacity": 1
            });
            $(".c3-target-forecast").css({
                "opacity": 1
            });
            $(".c3-target-admitted").css({
                "opacity": 1
            });
        } else {
            $(this).addClass("active");
            $(".breachesBar").removeClass("active");
            $(".dischargeBar").removeClass("active");
            $(".forecastBar").removeClass("active");
            $(".admittedleftBar").removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 0.1
            });
            $(".c3-target-arrivals").css({
                "opacity": 1
            });
            $(".c3-target-admitted").css({
                "opacity": 0.1
            });
            $(".c3-target-leftED").css({
                "opacity": 0.1
            });
            $(".c3-target-forecast").css({
                "opacity": 0.1
            });
        }
        $(".adText").css("opacity", 1);
    });














    $(document).on("click", ".breachesBar", function(e) {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 1
            });
            $(".c3-target-arrivals").css({
                "opacity": 1
            });
            $(".c3-target-leftED").css({
                "opacity": 1
            });
            $(".c3-target-forecast").css({
                "opacity": 1
            });
            $(".c3-target-admitted").css({
                "opacity": 1
            });
        } else {
            $(this).addClass("active");
            $(".admittedBar").removeClass("active");
            $(".dischargeBar").removeClass("active");
            $(".forecastBar").removeClass("active");
            $(".admittedleftBar").removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 1
            });
            $(".c3-target-arrivals").css({
                "opacity": 0.1
            });
            $(".c3-target-admitted").css({
                "opacity": 0.1
            });
            $(".c3-target-leftED").css({
                "opacity": 0.1
            });
            $(".c3-target-forecast").css({
                "opacity": 0.1
            });
        }
    });
    $(document).on("click", ".dischargeBar", function(e) {
        if ($(this).hasClass("active")) {

            $(this).removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 1
            });
            $(".c3-target-arrivals").css({
                "opacity": 1
            });
            $(".c3-target-leftED").css({
                "opacity": 1
            });
            $(".c3-target-forecast").css({
                "opacity": 1
            });
            $(".c3-target-admitted").css({
                "opacity": 1
            });
        } else {
            $(this).addClass("active");
            $(".admittedBar").removeClass("active");
            $(".breachesBar").removeClass("active");
            $(".forecastBar").removeClass("active");
            $(".admittedleftBar").removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 0.1
            });
            $(".c3-target-arrivals").css({
                "opacity": 0.1
            });
            $(".c3-target-admitted").css({
                "opacity": 0.1
            });
            $(".c3-target-leftED").css({
                "opacity": 1
            });
            $(".c3-target-forecast").css({
                "opacity": 0.1
            });
        }
    });
    $(document).on("click", ".forecastBar", function(e) {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 1
            });
            $(".c3-target-arrivals").css({
                "opacity": 1
            });
            $(".c3-target-leftED").css({
                "opacity": 1
            });
            $(".c3-target-forecast").css({
                "opacity": 1
            });
            $(".c3-target-admitted").css({
                "opacity": 1
            });
        } else {
            $(this).addClass("active");
            $(".breachesBar").removeClass("active");
            $(".dischargeBar").removeClass("active");
            $(".admittedBar").removeClass("active");
            $(".admittedleftBar").removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 0.1
            });
            $(".c3-target-arrivals").css({
                "opacity": 0.1
            });
            $(".c3-target-admitted").css({
                "opacity": 0.1
            });
            $(".c3-target-leftED").css({
                "opacity": 0.1
            });
            $(".c3-target-forecast").css({
                "opacity": 1
            });
        }
    });
    $(document).on("click", ".admittedleftBar", function(e) {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 1
            });
            $(".c3-target-arrivals").css({
                "opacity": 1
            });
            $(".c3-target-leftED").css({
                "opacity": 1
            });
            $(".c3-target-forecast").css({
                "opacity": 1
            });
            $(".c3-target-admitted").css({
                "opacity": 1
            });
        } else {
            $(this).addClass("active");
            $(".breachesBar").removeClass("active");
            $(".dischargeBar").removeClass("active");
            $(".admittedBar").removeClass("active");
            $(".forecastBar").removeClass("active");
            $(".c3-target-breaches").css({
                "opacity": 0.1
            });
            $(".c3-target-arrivals").css({
                "opacity": 0.1
            });
            $(".c3-target-admitted").css({
                "opacity": 1
            });
            $(".c3-target-leftED").css({
                "opacity": 0.1
            });
            $(".c3-target-forecast").css({
                "opacity": 0.1
            });
        }
    });

    $(document).on("click", ".scatter_show_hide", function(e) {
        if ($(this).hasClass("close_scatter")) {
            $(this).removeClass("close_scatter");
            $('#scatterChart').fadeOut("slow");
            $('#scttered_legened_bottom').fadeOut("slow");
            $('#lineTriageChart').fadeOut("slow");
            $('#linechart_legened_bottom').fadeOut("slow");
            $(this).prop('title', 'Show Graph');
            $('.BreachesGanntChartWrap .left .yaxisText').css("display", "none");
        } else {
            $(this).addClass("close_scatter");
            $('#scatterChart').fadeIn("slow");
            $('#scttered_legened_bottom').fadeIn("slow");
            $('#lineTriageChart').fadeIn("slow");
            $('#linechart_legened_bottom').fadeIn("slow");
            $(this).prop('title', 'Hide Graph');
            $('.BreachesGanntChartWrap .left .yaxisText').css("display", "block");
        }
        $(".highlight-window").hide();
    });
    $(document).on("click", ".active_row_remove_cell", function(e) {
        $(".overlay_selection_box").css("display", "none");
        var clickedScatterData = [];
        $.each(completeData["breachData"], function(k, v) {

            clickedScatterData.push(v);

        });
        var ArrivalArray = [];
        $.each(clickedScatterData, function(k, v) {
            if (!ArrivalArray.includes(parseInt(v["ARRIVAL_HOUR"]))) {
                ArrivalArray.push(parseInt(v["ARRIVAL_HOUR"]));
            }
        });
        ArrivalArray = ArrivalArray.sort();
        var arrivalTime = ArrivalArray[ArrivalArray.length - 1];
        var actTime = ArrivalArray[ArrivalArray.length - 1];
        var timeArray = [];
        if (ArrivalArray.length > 0) {
            for (var i = 0; i < 24; i++) {
                var val = "0" + arrivalTime;
                if (arrivalTime > 9) {
                    val = arrivalTime + "";
                }
                timeArray.push(val);

                arrivalTime++
                if (arrivalTime == 24) {
                    arrivalTime = 0;
                }
            }
        }
        $("#scatterChart").empty();
        if (ArrivalArray.length > 0) {
            $("#scatterChart").scatterplot({
                "data": clickedScatterData /*xAxisArray:timeArray*/
            });
        } else {
            $("#scatterChart").scatterplot({
                "data": clickedScatterData
            });
        }
    });
    $(document).on("click", ".clickedHour", function(e) {
        var pos = $(this).offset();
        var left = pos["left"];
        left = left - 16;


        var tot_height = $(".chart-Cont").height() + 1120;
        $(".highlight-window").height(tot_height);
        if ($(this).hasClass("ctTblTr1Td")) {
            $(".highlight-window").css({
                "left": $(".categoryType").width() + left,
                width: parseFloat($(".arrivalsBarCls").attr('width')) + 8
            });
        } else {
            $(".highlight-window").css({
                "left": left,
                width: parseFloat($(".arrivalsBarCls").attr('width')) + 8
            });
        }
        $(".highlight-window").show();
    });
    $(document).on('change', '#start_date_day_summary', function() {
        var filter_value = $('#start_date_day_summary').val();
        EdActivityDataLoad(filter_value);
    });
});
