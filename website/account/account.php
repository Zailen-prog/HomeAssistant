<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('location:../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style/account.css">
    <link rel="stylesheet" href="../nav/style/nav-body.css">
    <title>Home Page</title>
</head>

<body>
    <nav class="menu">
        <div class="logo">Home Assistant</div>
        <ul class="nav-links">
            <li><a href="../home/home.php">Home</a></li>
            <li><a href="../relays/relays.php">Relays</a></li>
            <li><a href="account.php">My Account</a></li>
            <li>
                <form action="/db_handlers/logout.php" method="POST">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div class="content-wrapper">
        <h1>Account</h1>
        <form id="save_info" method="POST">
            <div>
                <label for="name">
                    Name:
                </label>
                <input type="text" id="name" name="name" pattern="[A-Za-z]{1,32}" disabled>
            </div>

            <div>
                <label for="last-name">
                    Last Name:
                </label>
                <input type="text" id="last-name" name="last-name" pattern="[A-Za-z]{1,32}" disabled>
            </div>

            <div>
                <label for="mail">
                    E-mail:
                </label>
                <input type="text" id="mail" name="mail" maxlength=64 disabled>
            </div>
            <div><span id="message"></span></div>
            <button id="edit" type="button" class="btn edit">Edit</button>
            <button id="save" type="submit" class="btn save">Save</button>
            <button id="cancel" type="button" class="btn cancel">Cancel</button>
        </form>
        <h2>Change password</h2>
        <form id="change-psw" method="POST">
            <div>
                <label for="Current">
                    Current password:
                </label>
                <input type="password" id="curr-psw" name="curr-psw" require>

                <div>
                    <label for="new-psw">
                        New password:
                    </label>
                    <input type="password" oninput="setPasswordConfirmValidity();" id="new-psw" name="new-psw" maxlength=20 require pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}">
                </div>
                <div>
                    <label for="new-psw-confirm">
                        Confirm password:
                    </label>
                    <input type="password" oninput="setPasswordConfirmValidity();" id="new-psw-confirm" name="new-psw-confirm" maxlength=20 require pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}">
                </div>
                <div><span id="message-psw"></span></div>
                <button id="change" type="submit" class="btn change">Change</button>
        </form>
    </div>

    <script src="../nav/js/nav.js"></script>
    <script src="js/account.js"></script>
</body>

</html>