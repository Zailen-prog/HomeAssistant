<?php

/**
 * skrypt pobierający z bazy danych informacje o przekaźniku i danej nazwie
 * i zwraca te dane w postacji zmiennej typu json
 */
include '../../db_handlers/db_connection.php';

session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../../index.php');
}

$con = OpenCon();

if (isset($_POST['show'])) {
    $sql = "select Temp_control, Temp_value, Humi_control, Humi_value, description from relays where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['show'] . "'";
    if ($result = $con->query($sql)) {
        $data = $result->fetch_assoc();
        $json_data['Temp_control'] = $data['Temp_control'];
        $json_data['Temp_value'] = $data['Temp_value'];
        $json_data['Humi_control'] = $data['Humi_control'];
        $json_data['Humi_value'] = $data['Humi_value'];
        $json_data['description'] = $data['description'];
        echo json_encode($json_data, JSON_NUMERIC_CHECK);
    }
}
