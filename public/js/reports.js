$(function () {
    var dateFormat = "yy-mm-dd",
            from = $("#from")
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: "yy-mm-dd"
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = $("#to").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd"
    })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }
});

function get_data(event) {
    event.preventDefault();
    var req = new XMLHttpRequest();
    var form_data = new FormData(this);
    var path = "/report/getData";
    req.open("POST", path, true);
    req.send(form_data);

    req.onload = function (event) {
        if (req.status == 200) {
            console.log("Ok!", req.responseText);
            var data = JSON.parse(req.responseText);

            getChart(data);
        } else {
            console.log("error!");
        }
    };
}

var report_form = document.getElementById('report_form');
if (report_form) {

    report_form.removeEventListener("submit", sendForm);
    report_form.addEventListener("submit", get_data);
}

var myChartObj = {};


function getChart(data) {
    var labels = [];
    var dataset = [];
    var time_str = '';
    var type = 'bar';
    var title = '';
    for (var i = 0; i < data.length; i++) {
        if (!data[i].date_entry) {
            labels.push(data[i].title);
            type = 'doughnut';
        } else {
            labels.push(data[i].date_entry);
            type = 'bar';
            title = data[0].title;
        }
        time_str = +data[i].time_sum.slice(0, 2);
        time_str += data[i].time_sum.slice(3, 5) / 60;
        dataset.push(+time_str);
    }
    var ctx = document.getElementById("myChart").getContext('2d');
    if (myChartObj instanceof Chart) {
        myChartObj.destroy();
        console.log('chart object destroyed');
    }

    myChartObj = new Chart(ctx, {
        type: type,
        data: {
            //        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            labels:  labels,

            datasets: [{
                    label: title,
                    //            data: [12, 19, 3, 5, 2, 3],
                    data: dataset,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
    console.log(myChartObj);
}