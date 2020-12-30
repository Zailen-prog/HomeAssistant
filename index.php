<?php

session_start();
if (isset($_SESSION['logged'])) {
    header('location:home.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Assistant</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="index/style/index.css">
</head>

<body>
    <div class="hero">
        <div class="form-box" id="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>
            </div>
            <form id="login" class="input-group" method="POST">
                <span id="error_message"></span>
                <input id=loginL name="loginL" type="text" class="input-field" placeholder="Login" required>
                <input name="passwordL" type="password" class="input-field" placeholder="Password" required>
                <input type="checkbox" class="check-box" id="rememberMe"><span>Remember Me</span>
                <button type="submit" class="submit-btn" onclick="lsRememberMe()">Log In</button>
            </form>
            <form id="register" class="input-group" method="POST">
                <span id="message"></span>
                <input name="login" type="text" class="input-field" placeholder="Login" required pattern="[a-zA-Z][A-Za-z0-9]{5,15}">
                <input name="email" type="email" class="input-field" placeholder="E-mail" required>
                <input name="name" type="text" class="input-field" placeholder="Name" required pattern="[A-Za-z]{1,32}">
                <input name="lastname" type="text" class="input-field" placeholder="Last Name" required pattern="[A-Za-z]{1,32}">
                <input name="password" id="password1" oninput="setPasswordConfirmValidity();" type="password" class="input-field" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}">
                <input id="password2" oninput="setPasswordConfirmValidity();" type="password" class="input-field" placeholder="Repeat Password" required>
                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>
    </div>

    <script src="index/js/index.js"></script>

</body>

</html>