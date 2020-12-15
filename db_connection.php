<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "id15593109_esp8266";
    $dbpass = "y0VsM(fBH4Mmo]/4";
    $db = "id15593109_homeassistant";
    $con = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $con->error);

    return $con;
}

function CloseCon($con)
{
    $con->close();
}
