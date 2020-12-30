<?php

/**
 * skrypt obsługujący logowanie sprawdzający czy podane dane są w bazie danych
 * jesli tak to następuje zalogowanie i przekierowanie na 
 * strone home, jeśli nie to wyświetla komunikat o błędnych danych
 */
include '../../db_handlers/db_connection.php';
session_start();
if (!isset($_SESSION['logged'])) {
    if (!(isset($_POST['loginL']) && isset($_POST['passwordL'])))
        header('location: ../index.php');
} else
    header('location:../../home/home.php');
$con = OpenCon();

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
} else {

    $sq = "select * from users where LOGIN =?";
    $ss = mysqli_prepare($con, $sq);
    $ss->bind_param("s", $login);
    $login = $_POST['loginL'];
    $ss->execute();

    $result = $ss->get_result();
    $user = $result->fetch_assoc();

    if ($result->num_rows == 1) {

        $password = $_POST['passwordL'];

        $output = '';
        if (password_verify($password, $user['PASSWORD'])) {
            $_SESSION['user'] = $login;
            $_SESSION['name'] = $user['NAME'];
            $_SESSION['logged'] = true;
        } else {
            $output = '<label class="text-danger">Invalid Login or Password</label>';
        }
    } else {
        $output = '<label class="text-danger">Invalid Login or Password</label>';
    }
    CloseCon($con);
    echo $output;
}
