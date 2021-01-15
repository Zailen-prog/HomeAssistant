<?php

/**
 * zestaw funkcji wykorzystywanych do wyciągniącia odpowiednich wartości z bazy danych
 * wykorzystywany w pliku home_data.php
 */
include '../../db_handlers/db_connection.php';

/**
 * zwraca ostatnie ($limit) pomiarów temperatury i wilgotności jak i data ich wykonania
 * limit - ilość pomiarów
 */
function getAllReadings()
{
    $con = OpenCon();
    $sql = "SELECT  Temp, Humidity, Date FROM Data WHERE ID = '" . $_SESSION['user'] . "' AND Date > DATE_SUB(NOW(),INTERVAL 1 HOUR)";
    if ($result = $con->query($sql)) {
        return $result;
    } else {
        return false;
    }
    CloseCon($con);
}
/**
 * zwraca ostatni pomiar temperatury i wilgotności i date ich wykonania
 */
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

/**
 * zwraca minimalną wartośc w ($limit) ostatnich pomiarach 
 * limit - ilość pomiarów
 * value - temp albo wilgotność
 */
function minReading($value)
{
    $con = OpenCon();

    $sql = "SELECT MIN(" . $value . ") AS min_amount FROM (SELECT " . $value . " FROM Data WHERE ID = '" . $_SESSION['user'] . "' AND Date > DATE_SUB(NOW(),INTERVAL 1 HOUR)) AS min";
    if ($result = $con->query($sql)) {
        $ret = $result->fetch_assoc();
        return $ret['min_amount'];
    } else {
        return false;
    }
    CloseCon($con);
}

/**
 * zwraca maksymalną wartośc w ($limit) ostatnich pomiarach 
 * limit - ilość pomiarów
 * value - temp albo wilgotność
 */
function maxReading($value)
{
    $con = OpenCon();

    $sql = "SELECT MAX(" . $value . ") AS max_amount FROM (SELECT " . $value . " FROM Data WHERE ID = '" . $_SESSION['user'] . "' AND Date > DATE_SUB(NOW(),INTERVAL 1 HOUR)) AS max";
    if ($result = $con->query($sql)) {
        $ret = $result->fetch_assoc();
        return $ret['max_amount'];
    } else {
        return false;
    }
    CloseCon($con);
}

/**
 * zwraca średnią wartośc w ($limit) ostatnich pomiarach 
 * limit - ilość pomiarów
 * value - temp albo wilgotność
 */
function avgReading($value)
{
    $con = OpenCon();

    $sql = "SELECT AVG(" . $value . ") AS avg_amount FROM (SELECT " . $value . " FROM Data WHERE ID = '" . $_SESSION['user'] . "' AND Date > DATE_SUB(NOW(),INTERVAL 1 HOUR)) AS avg";
    if ($result = $con->query($sql)) {
        $ret = $result->fetch_assoc();
        return $ret['avg_amount'];
    } else {
        return false;
    }
    CloseCon($con);
}

/**
 * zwraca aktualnie ustawioną strefe czasową
 */
function getTimezone()
{
    $con = OpenCon();

    $sql = "select timezone from users where LOGIN = '" . $_SESSION['user'] . "'";
    if ($result = $con->query($sql)) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
    CloseCon($con);
}
