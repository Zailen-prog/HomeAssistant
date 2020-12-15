<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['logged'])) {
    if (!(isset($_POST['login']) && isset($_POST['password'])))
        header('location:index.php');
} else
    header('location:home.php');

$email = $_POST['email'];
if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+./', $email)) {
    $con = OpenCon();

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    } else {

        $sqe = "select * from users where EMAIL=?";
        $sE = mysqli_prepare($con, $sqe);
        $sE->bind_param("s", $email);
        $sE->execute();
        $result = $sE->get_result();

        $sq = "select * from users where LOGIN =?";
        $s = mysqli_prepare($con, $sq);
        $s->bind_param("s", $login);
        $login = $_POST['login'];
        $s->execute();
        $result2 = $s->get_result();

        $output = '';

        if ($result->num_rows == 0 && $result2->num_rows == 0) {
            $reg = "insert into users(LOGIN, EMAIL, NAME, LASTNAME, PASSWORD) values (?, ?, ?, ?, ?)";
            $sreg = mysqli_prepare($con, $reg);
            $sreg->bind_param("sssss", $login, $email, $name, $lastname, $password);
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sreg->execute();

            $output = '<label class="text-success">Registation Successful</br>You can Log In now</label>';
        } else if ($result2->num_rows == 1) {
            $output = '<label class="text-danger">Registation Failed</br>Login already taken</label>';
        } else {
            $output = '<label class="text-danger">Registation Failed</br>This E-mail is already used</label>';
        }
    }
} else {
    $output = '<label class="text-danger">Registation Failed</br>Invalid E-mail address</label>';
}
CloseCon($con);
echo $output;
