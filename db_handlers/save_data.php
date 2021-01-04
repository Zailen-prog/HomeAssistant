<?php

/**
 * skrypt odbierający dane od esp8266 i zapisujący je do bazy danych
 */
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
        case "Humidity":
            $Humidity = $value;
            break;
    }
}

$sq = "insert into Data(ID, Temp, Humidity) values (?, ?, ?)";
$ss = mysqli_prepare($con, $sq);
$ss->bind_param("sdi", $id, $Temp, $Humidity);
$ss->execute();
CloseCon($con);
$return = "done";
echo json_encode($return);
