<?php

/**
 * skrypt zapisujący do bazy danych informacje o koncie
 */
include '../../db_handlers/db_connection.php';

session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../../index.php');
}

$email = $_POST['mail'];
if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+./', $email)) {
    $con = OpenCon();

    $sqe = "select * from users where EMAIL=? and LOGIN != '" . $_SESSION['user'] . "'";
    $sE = mysqli_prepare($con, $sqe);
    $sE->bind_param("s", $email);
    $sE->execute();
    $result = $sE->get_result();

    if ($result->num_rows == 0) {
        $sql = "update users set NAME= '" . $_POST['name'] . "', LASTNAME =  '" . $_POST['last-name'] . "' , EMAIL = '" . $email . "' where LOGIN = '" . $_SESSION['user'] . "'";
        $con->query($sql);
        echo '<label class="text-success">Changes successfully saved</label>';
    } else {
        echo '<label class="text-danger">E-mail aldredy taken</label>';
    }
    CloseCon($con);
} else {
    echo '<label class="text-danger">Invalid e-mail address</label>';
}
