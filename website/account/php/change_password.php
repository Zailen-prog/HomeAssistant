<?php

/**
 * zapisujący nowe hasło do bazy danych
 */

include '../../db_handlers/db_connection.php';
session_start();
if (!isset($_SESSION['logged'])) {
    header('location: ../index.php');
}
$con = OpenCon();

$sq = "select PASSWORD from users where LOGIN = '" . $_SESSION['user'] . "'";
$result = $con->query($sq);

$psw = $result->fetch_assoc();

$curr = $_POST['curr-psw'];

if (password_verify($curr, $psw['PASSWORD'])) {
    $password = password_hash($_POST['new-psw'], PASSWORD_DEFAULT);
    $sql = "update users set PASSWORD = '" . $password . "' where LOGIN = '" . $_SESSION['user'] . "'";
    $con->query($sql);
    echo '<label class="text-success">Password successfully changed</label>';
} else {
    echo '<label class="text-danger">Invalid Current Password</label>';
}
CloseCon($con);
