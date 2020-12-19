<?php
include 'db_connection.php';

function getAllReadings($limit)
{
    $con = OpenCon();
    $sql = "SELECT  Temp, Humidity, Date FROM Data WHERE ID = '" . $_SESSION['user'] . "' order by Date desc limit " . $limit;
    if ($result = $con->query($sql)) {
        return $result;
    } else {
        return false;
    }
    CloseCon($con);
}

function getLastReadings()
{
    $con = OpenCon();

    $sql = "SELECT  Temp, Humidity, Date FROM Data WHERE ID = '" . $_SESSION['user'] . "' order by Date desc limit 1";
    if ($result = $con->query($sql)) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
    CloseCon($con);
}

function minReading($limit, $value)
{
    $con = OpenCon();

    $sql = "SELECT MIN(" . $value . ") AS min_amount FROM (SELECT " . $value . " FROM Data order by Date desc limit " . $limit . ") AS min";
    if ($result = $con->query($sql)) {
        $ret = $result->fetch_assoc();
        return $ret['min_amount'];
    } else {
        return false;
    }
    CloseCon($con);
}

function maxReading($limit, $value)
{
    $con = OpenCon();

    $sql = "SELECT MAX(" . $value . ") AS max_amount FROM (SELECT " . $value . " FROM Data order by Date desc limit " . $limit . ") AS max";
    if ($result = $con->query($sql)) {
        $ret = $result->fetch_assoc();
        return $ret['max_amount'];
    } else {
        return false;
    }
    CloseCon($con);
}

function avgReading($limit, $value)
{
    $con = OpenCon();

    $sql = "SELECT AVG(" . $value . ") AS avg_amount FROM (SELECT " . $value . " FROM Data order by Date desc limit " . $limit . ") AS avg";
    if ($result = $con->query($sql)) {
        $ret = $result->fetch_assoc();
        return $ret['avg_amount'];
    } else {
        return false;
    }
    CloseCon($con);
}
