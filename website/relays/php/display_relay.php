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

if (isset($_POST['display'])) {
    if ($_POST['display'] == 0)
        $sql = "update relays set display = '" . $_POST['display'] . "', state = '" . $_POST['display'] . "' where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['name'] . "'";
    else {
        $sql = "update relays set display = '" . $_POST['display'] . "' where ID = '" . $_SESSION['user'] . "' AND name= '" . $_POST['name'] . "'";
    }
    $con->query($sql);
} else if (isset($_POST['check'])) {
    $sql = "select display from relays where ID = '" . $_SESSION['user'] . "' AND relay_nr= " . $_POST['check'] . "";
    $result = $con->query($sql);
    $ret = $result->fetch_assoc();
    echo $ret['display'];
}
