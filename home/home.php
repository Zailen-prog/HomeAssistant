<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="/nav/style/nav-body.css">
    <title>Home Page</title>
</head>

<body>
    <nav class="menu">
        <div class="logo">Home Assistant</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="../relays/relays.php">Relays</a></li>
            <li><a href="../account/account.php">My Account</a></li>
            <li>
                <form action="/db_handlers/logout.php" method="POST">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div class="content-wrapper">

        <select name="timezone" id="timezone" class="timezone">
            <option value=-12>(GMT -12:00) Eniwetok, Kwajalein</option>
            <option value=-11>(GMT -11:00) Midway Island, Samoa</option>
            <option value=-10>(GMT -10:00) Hawaii</option>
            <option value=-9.5>(GMT -9:30) Taiohae</option>
            <option value=-9>(GMT -9:00) Alaska</option>
            <option value=-8>(GMT -8:00) Pacific Time (US &amp; Canada)</option>
            <option value=-7>(GMT -7:00) Mountain Time (US &amp; Canada)</option>
            <option value=-6>(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
            <option value=-5>(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
            <option value=-4.5>(GMT -4:30) Caracas</option>
            <option value=-4>(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
            <option value=-3.5>(GMT -3:30) Newfoundland</option>
            <option value=-3>(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
            <option value=-2>(GMT -2:00) Mid-Atlantic</option>
            <option value=-1>(GMT -1:00) Azores, Cape Verde Islands</option>
            <option value=0 selected="selected">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
            <option value=1>(GMT +1:00) Brussels, Copenhagen, Madrid, Paris</option>
            <option value=2>(GMT +2:00) Kaliningrad, South Africa</option>
            <option value=3>(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
            <option value=3.5>(GMT +3:30) Tehran</option>
            <option value=4>(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
            <option value=4.5>(GMT +4:30) Kabul</option>
            <option value=5>(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
            <option value=5.5>(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
            <option value=5.75>(GMT +5:45) Kathmandu, Pokhara</option>
            <option value=6>(GMT +6:00) Almaty, Dhaka, Colombo</option>
            <option value=6.5>(GMT +6:30) Yangon, Mandalay</option>
            <option value=7>(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
            <option value=8>(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
            <option value=8.75>(GMT +8:45) Eucla</option>
            <option value=9>(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
            <option value=9.5>(GMT +9:30) Adelaide, Darwin</option>
            <option value=10>(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
            <option value=10.5>(GMT +10:30) Lord Howe Island</option>
            <option value=11>(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
            <option value=11.5>(GMT +11:30) Norfolk Island</option>
            <option value=12>(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
            <option value=12.75>(GMT +12:45) Chatham Islands</option>
            <option value=13>(GMT +13:00) Apia, Nukualofa</option>
            <option value=14>(GMT +14:00) Line Islands, Tokelau</option>
        </select>

        <div class="weather-wrapper">
            <a class="weatherwidget-io" href="https://forecast7.com/en/50d2918d67/gliwice/" data-label_1="GLIWICE" data-label_2="WEATHER" data-icons="Climacons Animated" data-basecolor="#1f2833" data-accent="#131920" data-textcolor="#ffffff" data-highcolor="#ffffff" data-lowcolor="#8aa6fb" data-suncolor="#ffc900" data-mooncolor="#ffffff" data-cloudcolor="#ffffff" data-cloudfill="#dcdcdc" data-raincolor="#00a5ff" data-snowcolor="#ffffff">GLIWICE WEATHER</a>
        </div>

        <div class="box gauge--1">
            <h3>TEMPERATURE</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>

            <div class="disp-value">
                <p id="temp">--</p>
            </div>

            <table id="TempTable" cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3">Temperature last hour</th>
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

        <div id="chart-temp" class="chart"></div>

        <div class="box gauge--2">
            <h3>HUMIDITY</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <div class="disp-value">
                <p id="humi">--</p>
            </div>
            <table id="HumidityTable" cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3">Humidity last hour</th>
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

        <div id="chart-humi" class="chart"></div>
        <div class="relays nr-1">
            <div class="relay-label">
                <input type="checkbox" id="relay1">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay1">
                    <p class="relays-text">relay1</p>
                </label>
            </div>
        </div>
        <div class="relays nr-2">
            <div class="relay-label">
                <input type="checkbox" id="relay2">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay2">
                    <p class="relays-text">relay2</p>
                </label>
            </div>
        </div>
        <div class="relays nr-3">
            <div class="relay-label">
                <input type="checkbox" id="relay3">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay3">
                    <p class="relays-text">relay3</p>
                </label>
            </div>
        </div>
        <div class="relays nr-4">
            <div class="relay-label">
                <input type="checkbox" id="relay4">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay4">
                    <p class="relays-text">relay4</p>
                </label>
            </div>
        </div>
        <div class="relays nr-5">
            <div class="relay-label">
                <input type="checkbox" id="relay5">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay5">
                    <p class="relays-text">relay5</p>
                </label>
            </div>
        </div>
        <div class="relays nr-6">
            <div class="relay-label">
                <input type="checkbox" id="relay6">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay6">
                    <p class="relays-text">relay6</p>
                </label>
            </div>
        </div>
        <div class="relays nr-7">
            <div class="relay-label">
                <input type="checkbox" id="relay7">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay7">
                    <p class="relays-text">relay7</p>
                </label>
            </div>
        </div>
        <div class="relays nr-8">
            <div class="relay-label">
                <input type="checkbox" id="relay8">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay8">
                    <p class="relays-text">relay8</p>
                </label>
            </div>
        </div>
        <div class="relays nr-9">
            <div class="relay-label">
                <input type="checkbox" id="relay9">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay9">
                    <p class="relays-text">relay9</p>
                </label>
            </div>
        </div>
        <div class="relays nr-10">
            <div class="relay-label">
                <input type="checkbox" id="relay10">
                <div class="sliding-relay"> </div>
                <label class="relay-label" for="relay10">
                    <p class="relays-text">relay10</p>
                </label>
            </div>
        </div>
    </div>
    <div class="modal">
        <div class="times-wrapper">
            <input type="datetime-local" class="times" id="start-time" name="star-time">
            <input type="datetime-local" class="times" id="end-time" name="end-time">
        </div>
        <div class="draw-chart">
            <button class="draw-btn">Draw</button>
        </div>
        <div id="modal-chart" class="modal-chart"></div>
    </div>

    <script src="/nav/js/nav.js"></script>
    <script src="js/home.js"></script>


</body>

</html>