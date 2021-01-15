<?php

/**
 * zwraca dane pomiarowe z danego przedziału czasowego
 */
include '../../db_handlers/db_connection.php';
session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../../index.php');
}

$con = OpenCon();
$sql = "SELECT  " . $_POST['chart'] . " as series, Date FROM Data WHERE ID = '" . $_SESSION['user'] . "' AND Date > FROM_UNIXTIME(" . $_POST['start'] . ") AND Date < FROM_UNIXTIME(" . $_POST['end'] . ")";
if ($result = $con->query($sql)) {
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

    $json_data['series'] = array_column($sensor_data, 'series');
    $json_data['reading_time'] = $readings_time;
    echo json_encode($json_data, JSON_NUMERIC_CHECK);
}
CloseCon($con);
