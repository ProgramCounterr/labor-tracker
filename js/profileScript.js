// author: Peter Chen
// draw the chart
(function () {
    dataTable.sort((row1, row2) => new Date(row1['date']) - new Date(row2['date'])); // sort chronologically
    const dataPoints = [];
    for(let i=0; i<dataTable.length; i++) {
        // append 5:00:00 PM UTC to string before converting to Date object to ensure dates are correct locally
        dataPoints[i] = {t: new Date(`${dataTable[i]['date']} 5:00:00 PM UTC`), y: +dataTable[i]['hours']};
    }
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Hours',
                lineTension: 0, // make lines straight
                data: dataPoints,
                fill: false,
                borderColor: 'blue',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'day',
                        tooltipFormat: "MMM DD", // units shown when point is hovered
                    },
                    //FIXME: points on chart become evenly spaced
                    // make the first tick on x-axis aligned with first data point
                    distribution: 'series',
                    source: 'auto',
                    bounds: 'ticks'
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
})();