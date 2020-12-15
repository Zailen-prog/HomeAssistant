var Temp = [];
var Humidity = [];
var Temp2 = [];
var Light = [];
var Distance = [];

var interval = 15000; // 1000 = 1 second, 3000 = 3 seconds

! function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (!d.getElementById(id)) {
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://weatherwidget.io/js/widget.min.js';
        fjs.parentNode.insertBefore(js, fjs);
    }
}(document, 'script', 'weatherwidget-io-js');

$(document).ready(function () {
    $.ajax({
        type: 'GET',
        url: 'home_data.php',
        dataType: 'json',
        success: function (data) {
            update_data(data);
        },
        complete: function (data) {
            setTimeout(get_data_to_disp, interval);
        }
    });

    $(".chart-btn").click(function () {
        $('.chart').toggle();
        if ($('.chart').is(':visible'))
            $('.chart').css('display', 'inline-block');
        $(this).text(function (i, text) {
            return text === "Show Charts" ? "Hide Charts" : "Show Charts";
        })
    });
});

function get_data_to_disp() {
    $.ajax({
        type: 'GET',
        url: 'home_data.php',
        dataType: 'json',
        success: function (data) {
            update_data(data);
        },
        complete: function () {
            setTimeout(get_data_to_disp, interval);
        }
    });
}

function update_data(json_array) {
    Temp = [];
    Humidity = [];
    Temp2 = [];
    Light = [];
    Distance = [];

    for (var i = 0; i < json_array.reading_count; i++) {
        Temp.push([json_array.reading_time[i], json_array.Temp[i]]);
        Humidity.push([json_array.reading_time[i], json_array.Humidity[i]]);
        Temp2.push([json_array.reading_time[i], json_array.Temp2[i]]);
        Light.push([json_array.reading_time[i], json_array.Light[i]]);
        Distance.push([json_array.reading_time[i], json_array.Distance[i]]);
    }

    setTemperature(json_array.last_reading_temp);
    setHumidity(json_array.last_reading_humi);
    setTemperature2(json_array.last_reading_Temp2);
    setLight(json_array.last_reading_Light);
    setDistance(json_array.last_reading_Distance);

    var TempTable = document.getElementById('TempTable');
    var HumidityTable = document.getElementById('HumidityTable');
    var Temp2Table = document.getElementById('Temp2Table');
    var LightTable = document.getElementById('LightTable');
    var DistTable = document.getElementById('DistTable');

    TempTable.rows[0].cells[0].innerHTML = "Temperature " + json_array.reading_count + " readings";
    TempTable.rows[2].cells[0].innerHTML = json_array.min_temp + "&deg;C";
    TempTable.rows[2].cells[1].innerHTML = json_array.max_temp + "&deg;C";
    TempTable.rows[2].cells[2].innerHTML = json_array.avg_temp + "&deg;C";

    HumidityTable.rows[0].cells[0].innerHTML = "Humidity " + json_array.reading_count + " readings";
    HumidityTable.rows[2].cells[0].innerHTML = json_array.min_humi + "%";
    HumidityTable.rows[2].cells[1].innerHTML = json_array.max_humi + "%";
    HumidityTable.rows[2].cells[2].innerHTML = json_array.avg_humi + "%";

    Temp2Table.rows[0].cells[0].innerHTML = "Temperature " + json_array.reading_count + " readings";
    Temp2Table.rows[2].cells[0].innerHTML = json_array.min_Temp2 + "&deg;C";
    Temp2Table.rows[2].cells[1].innerHTML = json_array.max_Temp2 + "&deg;C";
    Temp2Table.rows[2].cells[2].innerHTML = json_array.avg_Temp2 + "&deg;C";

    LightTable.rows[0].cells[0].innerHTML = "Light " + json_array.reading_count + " readings";
    LightTable.rows[2].cells[0].innerHTML = json_array.min_Light + "%";
    LightTable.rows[2].cells[1].innerHTML = json_array.max_Light + "%";
    LightTable.rows[2].cells[2].innerHTML = json_array.avg_Light + "%";

    DistTable.rows[0].cells[0].innerHTML = "Distance " + json_array.reading_count + " readings";
    DistTable.rows[2].cells[0].innerHTML = json_array.min_Distance + "cm";
    DistTable.rows[2].cells[1].innerHTML = json_array.max_Distance + "cm";
    DistTable.rows[2].cells[2].innerHTML = json_array.avg_Distance + "cm";
}

Highcharts.setOptions({
    chart: {
        type: 'spline',
        backgroundColor: '#1F2833',
        borderRadius: 5,
    },
    title: {
        style: {
            color: '#66FCF1'
        }
    },

    plotOptions: {
        line: {
            animation: false,
        },
        series: {
            color: '#45A29E',
            showInLegend: false
        }
    },
    xAxis: {
        type: 'datetime',
        labels: {
            style: {
                color: 'white'
            },
        },
        tickInterval: 60 * 1000 * 4
    },

    yAxis: {
        title: {
            style: {
                color: 'white'
            }
        },
        labels: {
            style: {
                color: 'white'
            }
        },
        gridLineColor: '#000'
    },
    credits: {
        enabled: false
    },
    tooltip: {
        formatter: function () {
            return '<b>' + Highcharts.dateFormat('%H:%M:%S',
                new Date(this.x)) + ', ' + this.y;
        },

    },
});

var chart;
function generate_chart(serie, msg, msg2) {
    chart = new Highcharts.Chart('modal-chart', {
        title: {
            text: msg
        },

        series: [{
            data: serie
        }],

        yAxis: {
            title: {
                text: msg2,
            },
        },
    });
}

var modal = document.querySelector('.modal');
var modal_chart = document.querySelector('.modal-chart');
var box = document.querySelectorAll('.box');

box.forEach(box => {
    box.addEventListener('click', () => {
        modal.classList.add('open');
        if (box.classList.contains('gauge--1')) {
            generate_chart(Temp, "DHT11 Temp", "Temperature (Celcius)");
        } else if (box.classList.contains('gauge--2')) {
            generate_chart(Humidity, "DHT11 Humidity", "Humidity (%)");
        } else if (box.classList.contains('gauge--3')) {
            generate_chart(Temp2, "LM35DZ Temp", "Temperature (Celcius)");
        } else if (box.classList.contains('gauge--4')) {
            generate_chart(Light, "Light Sensor", "Light (%)");
        } else if (box.classList.contains('gauge--5')) {
            generate_chart(Distance, "Distance Sensor", "Distance (cm)");
        }
    })
})

modal.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        modal.classList.remove('open');
        chart.destroy();
    }
})

function setTemperature(curVal) {
    var minTemp = -5.0;
    var maxTemp = 38.0;

    var newVal = scaleValue(curVal, [minTemp, maxTemp], [0, 180]);
    $('.gauge--1 .semi-circle--mask').attr({
        style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
    });
    $("#temp").text(curVal + ' ºC');
}

function setHumidity(curVal) {
    var minHumi = 0;
    var maxHumi = 100;

    var newVal = scaleValue(curVal, [minHumi, maxHumi], [0, 180]);
    $('.gauge--2 .semi-circle--mask').attr({
        style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
    });
    $("#humi").text(curVal + ' %');
}

function setTemperature2(curVal) {
    var minTemp = -5.0;
    var maxTemp = 38.0;

    var newVal = scaleValue(curVal, [minTemp, maxTemp], [0, 180]);
    $('.gauge--3 .semi-circle--mask').attr({
        style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
    });
    $("#temp2").text(curVal + ' ºC');
}

function setLight(curVal) {
    var minLight = 0.0;
    var maxLight = 100;

    var newVal = scaleValue(curVal, [minLight, maxLight], [0, 180]);
    $('.gauge--4 .semi-circle--mask').attr({
        style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
    });
    $("#light").text(curVal + ' %');
}

function setDistance(curVal) {
    var minDist = 0.0;
    var maxDist = 200.0;

    var newVal = scaleValue(curVal, [minDist, maxDist], [0, 180]);
    $('.gauge--5 .semi-circle--mask').attr({
        style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
    });
    $("#distance").text(curVal + ' cm');
}

function scaleValue(value, from, to) {
    var scale = (to[1] - to[0]) / (from[1] - from[0]);
    var capped = Math.min(from[1], Math.max(from[0], value)) - from[0];
    return ~~(capped * scale + to[0]);
}