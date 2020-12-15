<?php
include 'db_connection.php';
$con = OpenCon();

foreach ($_REQUEST as $key => $value) {
    switch ($key) {
        case "id":
            $id = $value;
            break;
        case "Temp":
            $Temp = $value;
            break;
        case "Light":
            $Light = $value;
            break;
        case "Humidity":
            $Humidity = $value;
            break;
        case "Temp2":
            $Temp2 = $value;
            break;
        case "Distance":
            $Distance = $value;
            break;
    }
}

$sq = "insert into Data(ID, Temp, Humidity, Temp2, Light, Distance) values (?, ?, ?, ?, ?, ?)";
$ss = mysqli_prepare($con, $sq);
$ss->bind_param("sdidii", $id, $Temp, $Humidity, $Temp2, $Light, $Distance);
$ss->execute();
CloseCon($con);
echo $date;
