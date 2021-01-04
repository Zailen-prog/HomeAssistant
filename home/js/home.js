
/**
 * funckja obsługująca weather widget
 */
! function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (!d.getElementById(id)) {
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://weatherwidget.io/js/widget.min.js';
        fjs.parentNode.insertBefore(js, fjs);
    }
}(document, 'script', 'weatherwidget-io-js');



var Temp = [];          // przechowuje dane temperatury do wykresów
var Humidity = [];      // przechowuje dane wilgotności do wykresów
var times = [];
var interval = 15000;   // czas w milisekundach co ile ma się odświeżać wykres

/**
 * wywołuje funkcje get_data_to_disp() gdy strona się załaduje
 */
$(document).ready(function () {
    $.ajax({
        type: 'GET',
        url: 'php/home_data.php',
        dataType: 'json',
        success: function (data) {
            update_data(data);
            var start = $("#start-time");
            var end = $("#end-time");
            var json_array = data;

            start.val(getDate(new Date(Date.now() - 3600000 + json_array.timezone * 3600000)));
            end.val(getDate(new Date(Date.now() + json_array.timezone * 3600000)));

            if (json_array.timezone < -9.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 12;
            }
            else if (json_array.timezone < -4.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 13;
            }
            else if (json_array.timezone < -3.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 14;
            }
            else if (json_array.timezone < 3.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 15;
            }
            else if (json_array.timezone < 4.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 16;
            }
            else if (json_array.timezone < 5.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 17;
            }
            else if (json_array.timezone < 5.75) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 18;
            }
            else if (json_array.timezone < 6.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 19;
            }
            else if (json_array.timezone < 8.75) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 20;
            }
            else if (json_array.timezone < 9.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 21;
            }
            else if (json_array.timezone < 10.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 22;
            }
            else if (json_array.timezone < 11.5) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 23;
            }
            else if (json_array.timezone < 12.75) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 24;
            }
            else if (json_array.timezone <= 14) {
                document.getElementById("timezone").selectedIndex = json_array.timezone + 25;
            }
            prev_timezone = $('.timezone').val();
        },
        complete: function () {
            setTimeout(get_data_to_disp, interval);
        }
    });
});

function getDate(date) {
    const dateAndTime = date.toISOString().split('T')
    const time = dateAndTime[1].split(':')

    return dateAndTime[0] + 'T' + time[0] + ':' + time[1]
}


/**
 * funckja wykonująca ajax co określony czas (zmianna interval),
 * wywołany plik php home_data.php zwraca w postaci json dane o temperaturze i wilgotności,
 * i wywołuje funkcje update_data()
 */
function get_data_to_disp() {
    $.ajax({
        type: 'GET',
        url: 'php/home_data.php',
        dataType: 'json',
        success: function (data) {
            update_data(data);
        },
        complete: function () {
            setTimeout(get_data_to_disp, interval);
        }
    });
}
/**
 * funckja aktualizaujące dane wyświetlane na stronie
 */
function update_data(json_array) {
    Temp = [];
    Humidity = [];

    times = json_array.reading_time.map(function (val) { return val + (json_array.timezone * 3600000); });
    for (var i = 0; i < times.length; i++) {
        Temp.push([times[i], json_array.Temp[i]]);
        Humidity.push([times[i], json_array.Humidity[i]]);
    }

    chartT.update({
        series: [{
            data: Temp
        }],
    });
    chartH.update({
        series: [{
            data: Humidity
        }],
    });

    setTemperature(json_array.last_reading_temp);
    setHumidity(json_array.last_reading_humi);

    var TempTable = document.getElementById('TempTable');
    var HumidityTable = document.getElementById('HumidityTable');

    TempTable.rows[2].cells[0].innerHTML = json_array.min_temp + "&deg;C";
    TempTable.rows[2].cells[1].innerHTML = json_array.max_temp + "&deg;C";
    TempTable.rows[2].cells[2].innerHTML = json_array.avg_temp + "&deg;C";

    HumidityTable.rows[2].cells[0].innerHTML = json_array.min_humi + "%";
    HumidityTable.rows[2].cells[1].innerHTML = json_array.max_humi + "%";
    HumidityTable.rows[2].cells[2].innerHTML = json_array.avg_humi + "%";
}

/**
 * ustawia temperature na podaną w curVal
 */
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

/**
 * ustawia wilgotność na podaną w curVal
 */
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

/**
 * skaluje wartość w podanym przedziale
 */
function scaleValue(value, from, to) {
    var scale = (to[1] - to[0]) / (from[1] - from[0]);
    var capped = Math.min(from[1], Math.max(from[0], value)) - from[0];
    return ~~(capped * scale + to[0]);
}

/**
 * globalne ustawienia wykresów
 */
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
        tickInterval: 60 * 1000 * 10
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

/**
 * tworzy wykres temperatury
 */
var chartT = new Highcharts.Chart('chart-temp', {
    title: {
        text: "Temperature"
    },

    series: [{
        data: Temp
    }],

    yAxis: {
        title: {
            text: "Temperature (Celcius)",
        },
    },
});

/**
 * tworzy wykres wilgotności
 */
var chartH = new Highcharts.Chart('chart-humi', {
    title: {
        text: "Humidity"
    },

    series: [{
        data: Humidity
    }],

    yAxis: {
        title: {
            text: "Humidity (%)",
        },
    },
});

var modal = document.querySelector('.modal');
var box = document.querySelectorAll('.box');

/**
 * dla boxa od temperatury i wilgotności dodaje
 * zdarzenie podczas kliknięcia (wykreślenie wyresu na pełnym ekranie)
 */
var chart_id;
box.forEach(box => {
    box.addEventListener('click', () => {
        modal.classList.add('open');
        if (box.classList.contains('gauge--1')) {
            generate_chart(Temp, "DHT11 Temp", "Temperature (Celcius)");
            chart_id = "Temp";
        } else if (box.classList.contains('gauge--2')) {
            generate_chart(Humidity, "DHT11 Humidity", "Humidity (%)");
            chart_id = "Humidity";
        }
    })
})

var chart;

/**
 * funckja wyrysowuje wykres w zaleźności od podanych parametrów
 * serie - dane do wykresów
 * msg - tytuł wykresu
 * msg2 - opis osi Y
 */
function generate_chart(serie, msg, msg2) {
    chart = new Highcharts.Chart('modal-chart', {
        chart: {
            zoomType: 'xy'
        },

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

/**
 * dodaje wydarzenie do obiektu z klasą modal,
 * po naciśnieciu zamyka wykres w pełnym ekranie
 */
modal.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        modal.classList.remove('open');
        chart.destroy();
    }
})

var nr = 1;
/**
 * dla każdego checkboxa od przekaźnika wywołuje ajax do pliku 
 * get_relay_names.php by pobrać nazwy i stan przekaźników
 * oraz dodaje wydarzenie podczas zmiany wartości checkboxa,
 * gdy wartość ta się zmieni wywoułuje ajax do pliku save_relays.php
 * który zapisuje aktualny stan przekaźnika do bazy danych
 */
$('.relays').each(function () {
    var relay = $(this).find('p');
    var check = $(this).find(':checkbox');
    var rel = $(this);
    $.ajax({
        url: "../db_handlers/get_relay_names.php",
        method: "POST",
        dataType: 'json',
        data: "relay_nr=" + nr,
        success: function (data) {
            var json = data;
            relay.html(json.name);
            if (json.state == 1) {
                check.prop('checked', true);
            }
            else {
                check.prop('checked', false);
            }

            if (json.display == 1) {
                rel.css("display", "grid");
            }
            else {
                rel.css("display", "none");
            }
        }
    })
    nr = nr + 1;

    $(this).find(':checkbox').change(function () {
        if ($(this).is(':checked')) {
            var val = 1;
        } else {
            var val = 0;
        }
        $.ajax({
            url: "php/save_relays.php",
            method: "POST",
            data: "relay_name=" + relay.text() + "&val=" + val
        })
    });

});

/**
 * gdy zmienimy strefę czasową zostaje wywołany ajax do pliku set_timezone.php który
 * zapisuje nową strefę czasową do bazy danych, następnie zostają zaktualizowane 
 * wykresy o nową strefę czasową
 */
var prev_timezone;
$('.timezone').change(function () {
    $.ajax({
        url: "php/set_timezone.php",
        method: "POST",
        data: "timezone=" + $('.timezone').val()
    })
    var offest = Math.abs(prev_timezone - $('.timezone').val());
    if (+prev_timezone > +$('.timezone').val()) {
        times = times.map(function (val) { return val - offest * 3600000; });
    } else if (+prev_timezone < +$('.timezone').val()) {
        times = times.map(function (val) { return val + offest * 3600000; });
    }
    prev_timezone = $('.timezone').val();
    for (var i = 0; i < times.length; i++) {
        Temp[i][0] = times[i];
        Humidity[i][0] = times[i];
    }

    chartT.update({
        series: [{
            data: Temp
        }],
    });
    chartH.update({
        series: [{
            data: Humidity
        }],
    });
});

/**
 * podczas kliknięcia przycisku draw wybrany przedział czasowy jest na
 * czas uniksowy, następnie zostaje wywołany ajax do pliku get_data_to_charts.php
 * który zwraca dane pomiarowe z podego przedziału czasowego poczymm zostaje zaktualizowny
 * wykres o nowe dane
 */
$('.draw-btn').click(function () {
    var start_time = (+new Date($('#start-time').val()) - ($('.timezone').val() * 3600000)) / 1000;
    var end_time = (+new Date($('#end-time').val()) - ($('.timezone').val() * 3600000)) / 1000;
    if (start_time < end_time) {
        $.ajax({
            url: "php/get_data_to_charts.php",
            method: "POST",
            data: "chart=" + chart_id + "&start=" + start_time + "&end=" + end_time,
            dataType: "json",
            success: function (data) {
                var series = [];
                times = data.reading_time.map(function (val) { return val + ($('.timezone').val() * 3600000); });
                for (var i = 0; i < times.length; i++) {
                    series.push([times[i], data.series[i]]);
                }
                chart.update({
                    series: [{
                        data: series
                    }],
                });
            }
        })
    }
})
