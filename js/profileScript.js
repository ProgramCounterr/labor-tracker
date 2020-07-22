// authors: Rowan Dakota and Peter Chen
function drawChart(data, xLabel) {

    let datatable = new google.visualization.DataTable();
    datatable.addColumn('number', xLabel);
    datatable.addColumn('number', 'Amount Worked');
    datatable.addRows(data);

    let options = {
        chart: {
        title: `Hours Worked per ${xLabel}`
        },
        width: 900,
        height: 500,
        vAxis: { title: 'Hours'},
        hAxis: { title: xLabel }
    };

    let chart = new google.charts.Line(document.getElementById('chart'));

    chart.draw(datatable, google.charts.Line.convertOptions(options));
}

(function () {
    let perWeekData = [
        [1,  37.8],
        [2,  30.9],
        [3,  25.4],
        [4,  11.7],
        [5,  11.9],
        [6,   8.8],
        [7,   7.6],
        [8,  12.3],
        [9,  16.9],
        [10, 12.8],
        [11,  5.3],
        [12,  6.6],
        [13,  4.8],
        [14,  55],
        [15,  55],
        [16,  45]
    ];

    let perDayData = [
        [1,  7.6],
        [2,  7.4],
        [3,  6.9],
        [4,  6.5],
        [5,  6.4],
        [6,   6.0],
        [7,   5.9],
        [8,  8.8],
        [9,  5.2],
        [10, 3.9],
        [11,  3.4],
        [12,  3.4],
        [13,  6.0],
        [14,  8.2],
        [15,  9.1],
        [16,  12.3]
    ];
    let data = perWeekData;
    let label = "Week";
    const changeView = document.querySelector('#change-view');
    changeView.addEventListener('click', () => {
        if(changeView.checked) {
            data = perDayData;
            label = "Day";
        }
        else {
            data = perWeekData;
            label = "Week";
        }
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(() => { drawChart(data, label); });
    });
    
    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(() => { drawChart(data, label); });
})();