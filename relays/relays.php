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
    <link rel="stylesheet" href="style/relays.css">
    <link rel="stylesheet" href="../nav/style/nav-body.css">
    <title>Relays</title>
</head>

<body>
    <nav class="menu">
        <div class="logo">Home Assistant</div>
        <ul class="nav-links">
            <li><a href="../home/home.php">Home</a></li>
            <li><a href="relays.php">Relays</a></li>
            <li><a href="../account/account.php">My Account</a></li>
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
        <div class="relay-box">
            <div class="relays nr-1">
                <span>relay1</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-2">
                <span>relay2</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-3">
                <span>relay3</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-4">
                <span>relay4</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-5">
                <span>relay5</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-6">
                <span>relay6</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-7">
                <span>relay7</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-8">
                <span>relay8</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-9">
                <span>relay9</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
            <div class="relays nr-10">
                <span>relay10</span>
                <div class="active">
                    <button class="relay-btn">Acitve</button>
                </div>
            </div>
        </div>
        <div class="relay-info">
            <form id="save_values" method="POST">
                <div>
                    <label for="name-relay">
                        Name:
                    </label>
                    <input type="text" id="name-relay" name="name-relay" class="change-input" maxlength=15 disabled>
                </div>
                <div class="temp-control">
                    <div class="relay-label">
                        <input type="checkbox" id="temp-control" name="temp-control" disabled>
                        <div class="sliding-relay"> </div>
                        <label class="relay-label" for="temp-control">
                            <p class="relays-text">Temp Control</p>
                        </label>
                    </div>
                    <div>
                        <label for="temp-value-relay">
                            Ref value:
                        </label>
                        <input type="number" min=-10 max=150 id="temp-value-relay" name="temp-value-relay" class="change-input" disabled>
                    </div>

                </div>

                <div class="humi-control">
                    <div class="relay-label">
                        <input type="checkbox" id="humi-control" name="humi-control" disabled>
                        <div class="sliding-relay"> </div>
                        <label class="relay-label" for="humi-control">
                            <p class="relays-text">Humidity Control</p>
                        </label>
                    </div>
                    <div>
                        <label for="humi-value-relay">
                            Ref value:
                        </label>
                        <input type="number" min=0 max=100 id="humi-value-relay" name="humi-value-relay" class="change-input" disabled>
                    </div>
                </div>

                <div>
                    <label for="description-relay">
                        <p>Description</p>
                    </label>
                    <textarea id="description-relay" maxlength=255 name="description-relay" disabled></textarea>
                </div>

                <button id="edit" type="button" class="btn edit">Edit</button>
                <button id="save" type="submit" class="btn save">Save</button>
                <button id="cancel" type="button" class="btn cancel">Cancel</button>

            </form>
        </div>
    </div>

    <script src="js/relays.js"></script>
    <script src="../nav/js/nav.js"></script>

</body>

</html>