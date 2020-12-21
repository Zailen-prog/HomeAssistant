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
            $result = $s->get_result();

            $reg1 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 1, 'relay1', 0, 0, 0, 0, 0, 0, '');";
            $reg2 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 2, 'relay2', 0, 0, 0, 0, 0, 0, '');";
            $reg3 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 3, 'relay3', 0, 0, 0, 0, 0, 0, '');";
            $reg4 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 4, 'relay4', 0, 0, 0, 0, 0, 0, '');";
            $reg5 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 5, 'relay5', 0, 0, 0, 0, 0, 0, '');";
            $reg6 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 6, 'relay6', 0, 0, 0, 0, 0, 0, '');";
            $reg7 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 7, 'relay7', 0, 0, 0, 0, 0, 0, '');";
            $reg8 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 8, 'relay8', 0, 0, 0, 0, 0, 0, '');";
            $reg9 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 9, 'relay9', 0, 0, 0, 0, 0, 0, '');";
            $reg10 = "insert into relays(ID, relay_nr, name, State, display, Temp_control, Temp_value, Humi_control, Humi_value, description) values (?, 10, 'relay10', 0, 0, 0, 0, 0, 0, '');";
            $sreg1 = mysqli_prepare($con, $reg1);
            $sreg2 = mysqli_prepare($con, $reg2);
            $sreg3 = mysqli_prepare($con, $reg3);
            $sreg4 = mysqli_prepare($con, $reg4);
            $sreg5 = mysqli_prepare($con, $reg5);
            $sreg6 = mysqli_prepare($con, $reg6);
            $sreg7 = mysqli_prepare($con, $reg7);
            $sreg8 = mysqli_prepare($con, $reg8);
            $sreg9 = mysqli_prepare($con, $reg9);
            $sreg10 = mysqli_prepare($con, $reg10);
            $sreg1->bind_param("s", $login);
            $sreg2->bind_param("s", $login);
            $sreg3->bind_param("s", $login);
            $sreg4->bind_param("s", $login);
            $sreg5->bind_param("s", $login);
            $sreg6->bind_param("s", $login);
            $sreg7->bind_param("s", $login);
            $sreg8->bind_param("s", $login);
            $sreg9->bind_param("s", $login);
            $sreg10->bind_param("s", $login);
            $sreg1->execute();
            $sreg1->get_result();
            $sreg2->execute();
            $sreg2->get_result();
            $sreg3->execute();
            $sreg3->get_result();
            $sreg4->execute();
            $sreg4->get_result();
            $sreg5->execute();
            $sreg5->get_result();
            $sreg6->execute();
            $sreg6->get_result();
            $sreg7->execute();
            $sreg7->get_result();
            $sreg8->execute();
            $sreg8->get_result();
            $sreg9->execute();
            $sreg9->get_result();
            $sreg10->execute();

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
