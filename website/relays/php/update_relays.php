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

    $sql = "update relays set name= '" . $_POST['name-relay'] . "', description = '" . $_POST['description-relay'] . "' where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['update'] . "'";
    $con->query($sql);
}
