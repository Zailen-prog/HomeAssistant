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
    $sql = "select description from relays where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['show'] . "'";
    if ($result = $con->query($sql)) {
        $data = $result->fetch_assoc();
        $json_data['description'] = $data['description'];
        echo json_encode($json_data, JSON_NUMERIC_CHECK);
    }
}
