<?php
//include 'get_data.php';
session_start();
if (!isset($_SESSION['logged'])) {
    header('location:index.php');
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
    <link rel="stylesheet" href="relays.css">
    <link rel="stylesheet" href="nav-body.css">
    <title>Relays</title>
</head>

<body>
    <nav class="menu">
        <div class="logo">Home Assistant</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="relays.php">Relays</a></li>
            <li><a href="account.php">My Account</a></li>
            <li>
                <form action="logout.php" method="POST">
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
        <div class="relay-box">
            <div class="relays nr-1">
                <span>relay 1</span>
            </div>
            <div class="relays nr-2">
                <span>relay 2</span>
            </div>
            <div class="relays nr-3">
                <span>relay 3</span>
            </div>
            <div class="relays nr-4">
                <span>relay 4</span>
            </div>
            <div class="relays nr-5">
                <span>relay 5</span>
            </div>
            <div class="relays nr-6">
                <span>relay 6</span>
            </div>
            <div class="relays nr-7">
                <span>relay 7</span>
            </div>
            <div class="relays nr-8">
                <span>relay 8</span>
            </div>
            <div class="relays nr-9">
                <span>relay 9</span>
            </div>
            <div class="relays nr-10">
                <span>relay 10</span>
            </div>
        </div>
        <div class="relay-info">
        </div>
    </div>

    <script src="nav.js"></script>

</body>

</html>