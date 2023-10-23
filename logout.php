<?php
// logout.php

session_start();


unset($_SESSION["klant"]);


header("Location: index.php"); 
exit;
?>
