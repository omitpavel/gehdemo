var config = {
  type: 'gauge',
  data: {
       datasets: [{
            data: ane_performance_data,
            value: ane_performance_value,
            backgroundColor: guage_colour_codes,
            borderWidth: 2
       }]
  },
  options: {
       responsive: true,
       title: {
            display: false
       },
       layout: {
            padding: {
                 bottom: 30
            }
       },
       needle: {
            radiusPercentage: 2,
            widthPercentage: 3.2,
            lengthPercentage: 80,
            color: 'rgba(0, 0, 0, 1)'
       },
       valueLabel: {
            formatter: Math.round,
            display: false
       }
  }
};