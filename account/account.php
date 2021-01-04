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
    <link rel="stylesheet" href="style/myaccount.css">
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



    <script src="../nav/js/nav.js"></script>
    <script src="js/myaccount.js"></script>
</body>

</html>