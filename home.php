<?php
//include 'get_data.php';
session_start();
if (!isset($_SESSION['logged'])) {
    header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="home.css">
    <title>Home Page</title>
</head>

<body>
    <div class="heaader-wrapper">
        <div class="header">
            <form action="logout.php" method="POST">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="weather-wrapper">
        <a class="weatherwidget-io" href="https://forecast7.com/en/50d2918d67/gliwice/" data-label_1="GLIWICE" data-label_2="WEATHER" data-icons="Climacons Animated" data-basecolor="#1f2833" data-accent="#131920" data-textcolor="#ffffff" data-highcolor="#ffffff" data-lowcolor="#8aa6fb" data-suncolor="#ffc900" data-mooncolor="#ffffff" data-cloudcolor="#ffffff" data-cloudfill="#dcdcdc" data-raincolor="#00a5ff" data-snowcolor="#ffffff">GLIWICE WEATHER</a>
    </div>

    <div class="content-wrapper">
        <div class="box gauge--1">
            <h3>DHT11 TEMP</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="temp">--</p>
            <table id="TempTable" cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3"></th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="box gauge--2">
            <h3>HUMIDITY</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="humi">--</p>
            <table id="HumidityTable" cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3"></th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="box gauge--3">
            <h3>LM35DZ TEMP</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="temp2">--</p>
            <table id="Temp2Table" cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3"> </th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="box gauge--4">
            <h3>LIGHT</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="light">--</p>
            <table id="LightTable" cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3"></th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="box gauge--5">
            <h3>DISTANCE</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="distance">--</p>
            <table id="DistTable" cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3"></th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="modal">
        <div id="modal-chart" class="modal-chart"></div>
    </div>

    <script src="home.js"></script>

</body>

</html>