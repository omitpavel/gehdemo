var box_plot_var_chart = { type: 'boxplot', inverted: true };
var box_plot_var_title = { text: '' };
var box_plot_var_legend = { enabled: true };
var box_plot_var_xaxis = { visible: false };
var box_plot_var_yaxis = { visible: true, labels: { enabled: true }, title: { text: null } };
var box_plot_var_plot_options = { boxplot: { fillColor: '#000000', lineWidth: 1, medianColor: '#FFFFFF', medianWidth: 2, stemColor: '#000000', stemWidth: 1, whiskerColor: '#000000', whiskerWidth: 2 } };



function DrawBoxPlotCharts(chart_id, minimum_val, lower_quartile_val, midian_val, upper_quartile_val, maximum_val, ) {
    Highcharts.chart(chart_id, {
        boost: {
            useGPUTranslations: true,
            // Chart-level boost when there are more than 5 series in the chart
            seriesThreshold: 5
        },
        chart: box_plot_var_chart,
        title: box_plot_var_title,
        legend: box_plot_var_legend,
        xAxis: box_plot_var_xaxis,
        yAxis: box_plot_var_yaxis,
        plotOptions: box_plot_var_plot_options,

        series: [{
            color: '#419BFF',
            showInLegend: false,
            name: '',
            data: [
                [minimum_val, lower_quartile_val, midian_val, upper_quartile_val, maximum_val]
            ],
            fillColor: '#419BFF',
            tooltip: {
                headerFormat: '',
                pointFormatter: function() {
                    const x = this.x;
                    const currentData = this.series.data.find(data => data.x === x);
                    const boxplotValues = currentData ? currentData.options : {};
                    return `Maximum: ${boxplotValues.high}<br>Upper Quartile: ${boxplotValues.q3}<br>Median: ${boxplotValues.median}<br>Lower Quartile: ${boxplotValues.q1}<br>Minimum: ${boxplotValues.low}<br>`;
                }
            }
        }]
    });
}