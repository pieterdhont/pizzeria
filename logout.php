<?php
// logout.php


session_start();

if (isset($_SESSION["mandje"])) {
    $mandjeData = json_encode($_SESSION["mandje"]);
    setcookie('mandje', $mandjeData, time() + (86400 * 30), "/"); 
}

unset($_SESSION["klant"]);
unset($_SESSION["mandje"]);

header("Location: index.php"); 
exit;

