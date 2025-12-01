

<script type="text/javascript">
    $(document).ready(function () {
        var chart = bb.generate({
            bindto: '#task-response-chart',
            size: {
                height: 318
            },
            data: {
                x: 'x',
                columns: [
                    {!! json_encode($success_array['list_task_time_keys']) !!},
                    {!! json_encode($success_array['list_task_time_averages']) !!}
                ],
                type: 'bar',
                colors: function (color, d) {
                    var colors = ['#C54E4E', '#EE3B3B', '#FF944D', '#BAD350', '#7BDCA6', '#01C5BB', '#388E8E', '#42C0FB', '#42647F', '#8470FF', '#990099', '#D4318C', '#E31230', '#EE7942', '#4EDFD7', '#81B0B4', '#3ABEFE', '#ACB6DD'];

                    if (d && d.index !== undefined && d.index < colors.length) {
                        return colors[d.index];
                    }

                    return color;
                }
            },
            axis: {
                rotated: true,
                x: {
                    type: 'category',
                    tick: {
                        width: 150
                    }
                },
                y: {
                    label: 'Hours'
                }
            },
            legend: {
                show: false
            },
            bar: {
                width: {
                    ratio: 0.6
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var chart = bb.generate({
            bindto: '#response-line-chart',
            data: {
                columns: [{!! json_encode($success_array['average_times_in_minutes']) !!}],
                type: 'spline'
            },
            axis: {
                x: {
                    type: 'category',
                    tick: {
                        rotate: 75,
                        multiline: false
                    },
                    height: 75,
                    label: '',
                    categories: {!! json_encode($success_array['date_list']) !!}
                },
                y: {
                    label: ''
                }
            },
            color: {
                pattern: ['#0c6eaa', '#FF0000', '#F6C600', '#60B044']
            },
            size: {
                height: 360
            },
            legend: {
                show: true,
                position: 'inset',
                inset: {
                    anchor: 'top-right'
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var chart = bb.generate({
            bindto: '#response-time-chart',
            data: {
                columns: [
                    {!! json_encode($success_array['average_times_in_hours']) !!},
                    {!! json_encode($success_array['patient_counts']) !!}
                ],
                type: 'bar',
                types: {
                    'Number Of Patients': 'spline' // Keeping the mixed type
                }
            },
            axis: {
                x: {
                    type: 'category',
                    tick: {
                        rotate: 75,
                        multiline: false
                    },
                    height: 75,
                    label: '',
                    categories: {!! json_encode($success_array['date_list']) !!}
                },
                y: {
                    label: ''
                }
            },
            color: {
                pattern: ['#0c6eaa', '#FF0000', '#F6C600', '#60B044']
            },
            size: {
                height: 300
            },
            legend: {
                show: true,
                position: 'inset',
                inset: {
                    anchor: 'top-right'
                }
            }
        });
    });
</script>
