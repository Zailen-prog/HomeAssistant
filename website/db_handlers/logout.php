<?php

/**
 * skrypt odpalany podczas wciśnięcia przycisku logout,
 * czyści wszystkie sesje i przekierowuje do strony logowania
 */

session_start();
$_SESSION = array();
session_destroy();

header('Location:../index.php');
