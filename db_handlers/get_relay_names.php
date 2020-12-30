<?php

/**
 * skrypt pobierający stan i nazwe przekaźnika o podanym numerze z bazy danych
 * wykorzystywany w home.js i relays.js
 */

include 'db_connection.php';

session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../index.php');
}

$con = OpenCon();

$sql = "select name, state from relays where ID = '" . $_SESSION['user'] . "' AND relay_nr= " . $_POST['relay_nr'] . "";
if ($result = $con->query($sql)) {
    $data = $result->fetch_assoc();
    $json_data['name'] = $data['name'];
    $json_data['state'] = $data['state'];
    echo json_encode($json_data, JSON_NUMERIC_CHECK);
}

CloseCon($con);
