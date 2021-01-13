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

$sql = "select LOGIN, EMAIL, NAME, LASTNAME from users where LOGIN = '" . $_SESSION['user'] . "'";
if ($result = $con->query($sql)) {
    $data = $result->fetch_assoc();
    $json_data['login'] = $data['LOGIN'];
    $json_data['email'] = $data['EMAIL'];
    $json_data['name'] = $data['NAME'];
    $json_data['lastname'] = $data['LASTNAME'];
    echo json_encode($json_data, JSON_NUMERIC_CHECK);
}
