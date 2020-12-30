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

$readings_count = 100;
$result = getAllReadings($readings_count);
$readings_count = $result->num_rows;

if ($result->num_rows > 0) {
    $last_reading = getLastReadings();

    $json_data['last_reading_temp'] =  $last_reading["Temp"];
    $json_data['last_reading_humi'] =  $last_reading["Humidity"];

    $last_reading_time =  $last_reading["Date"];
    $last_reading_time = date("Y-m-d H:i:s", strtotime("$last_reading_time + 1 hours"));

    $json_data['last_reading_time'] =  $last_reading_time;

    $json_data['min_temp'] = minReading($readings_count, 'Temp');
    $json_data['max_temp'] = maxReading($readings_count, 'Temp');
    $json_data['avg_temp'] = round(avgReading($readings_count, 'Temp'), 2);

    $json_data['min_humi'] = minReading($readings_count, 'Humidity');
    $json_data['max_humi'] = maxReading($readings_count, 'Humidity');
    $json_data['avg_humi'] = round(avgReading($readings_count, 'Humidity'), 2);
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
    $readings_time[$i] = strtotime("$reading + 1 hours") * 1000;
    $i += 1;
}

$json_data['Temp'] = array_reverse(array_column($sensor_data, 'Temp'));
$json_data['Humidity'] = array_reverse(array_column($sensor_data, 'Humidity'));
$json_data['reading_time'] = array_reverse($readings_time);
$json_data['reading_count'] = $readings_count;

$result->free();
echo json_encode($json_data, JSON_NUMERIC_CHECK);
