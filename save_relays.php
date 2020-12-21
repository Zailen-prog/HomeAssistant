<?php
include 'db_connection.php';

session_start();
if (!isset($_SESSION['logged'])) {
    header('location:index.php');
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
} else if (isset($_POST['show'])) {
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
} else if (isset($_POST['relay_name'])) {
    $sql = "update relays set state = " . $_POST['val'] . " where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['relay_name'] . "'";
    $con->query($sql);
}
CloseCon($con);
