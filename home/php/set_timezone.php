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

if (isset($_POST['timezone'])) {
    $sql = "update users set timezone = " . $_POST['timezone'] . " where LOGIN = '" . $_SESSION['user'] . "'";
    $con->query($sql);
}
CloseCon($con);
