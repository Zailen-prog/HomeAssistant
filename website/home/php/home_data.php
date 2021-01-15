<?php

/**
 * skrypt używający funckji z pliku get_data.php
 * i zapisujący wyniki do zmiennej typu json
 */
include 'get_data.php';

session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../../index.php');
}

$result = getAllReadings();

if ($result->num_rows > 0) {
    $last_reading = getLastReadings();

    $json_data['last_reading_temp'] =  $last_reading["Temp"];
    $json_data['last_reading_humi'] =  $last_reading["Humidity"];

    $last_reading_time =  $last_reading["Date"];
    $last_reading_time = date("Y-m-d H:i:s", strtotime("$last_reading_time + 1 hours"));

    $json_data['last_reading_time'] =  $last_reading_time;

    $json_data['min_temp'] = minReading('Temp');
    $json_data['max_temp'] = maxReading('Temp');
    $json_data['avg_temp'] = round(avgReading('Temp'), 2);

    $json_data['min_humi'] = minReading('Humidity');
    $json_data['max_humi'] = maxReading('Humidity');
    $json_data['avg_humi'] = round(avgReading('Humidity'), 2);
} else {
    $json_data['last_reading_temp'] =  0;
    $json_data['last_reading_humi'] =  0;

    $json_data['last_reading_time'] =  0;


    $json_data['min_temp'] = 0;
    $json_data['max_temp'] = 0;
    $json_data['avg_temp'] = 0;

    $json_data['min_humi'] = 0;
    $json_data['max_humi'] = 0;
    $json_data['avg_humi'] = 0;
}


$sensor_data[] = 0;
while ($data = $result->fetch_assoc()) {
    $sensor_data[] = $data;
}
$readings_time = array_column($sensor_data, 'Date');

$i = 0;
foreach ($readings_time as $reading) {
    $readings_time[$i] = strtotime($reading) * 1000;
    $i += 1;
}

$json_data['Temp'] = array_column($sensor_data, 'Temp');
$json_data['Humidity'] = array_column($sensor_data, 'Humidity');
$json_data['reading_time'] = $readings_time;
$timezone = getTimezone();
$json_data['timezone'] = $timezone['timezone'];

$result->free();
echo json_encode($json_data, JSON_NUMERIC_CHECK);
