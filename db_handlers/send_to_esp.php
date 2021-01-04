<?php

/**
 * skrypt wysyłający dane do esp
 */
include 'db_connection.php';
$con = OpenCon();
if ($con) {
    if (isset($_GET['id'])) {

        $sql = "select relay_nr, state from relays where ID = '" . $_GET['id'] . "' order by relay_nr";
        $result = $con->query($sql);
        while ($data = $result->fetch_assoc()) {
            $relays[] = $data;
        }
        $relays[]["send"] = 1;
        echo json_encode($relays, JSON_NUMERIC_CHECK);
    }
}
