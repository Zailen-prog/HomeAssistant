<?php

/**
 * skrypt zapisujący do bazy danych informacje o danym przekaźniku
 */
include '../../db_handlers/db_connection.php';

session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../../index.php');
}

$con = OpenCon();

if (isset($_POST['update'])) {
    if (isset($_POST['temp-control'])) {
        $temp_control = 1;
    } else {
        $temp_control = 0;
    }

    if (isset($_POST['humi-control'])) {
        $humi_control = 1;
    } else {
        $humi_control = 0;
    }

    $sql = "update relays set name= '" . $_POST['name-relay'] . "', Temp_control =  " . $temp_control . " , Temp_value = " . $_POST['temp-value-relay'] . ", Humi_control = " . $humi_control . ", Humi_value = " . $_POST['humi-value-relay'] . ", description = '" . $_POST['description-relay'] . "' where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['update'] . "'";
    $con->query($sql);
}
