<?php
/*
    Skrypt php zapisuje stan przekaźnika o danej nazwie
*/
include '../../db_handlers/db_connection.php';

session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../index.php');
}

$con = OpenCon();

if (isset($_POST['relay_name'])) {
    $sql = "update relays set state = " . $_POST['val'] . " where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['relay_name'] . "'";
    $con->query($sql);
}
CloseCon($con);
