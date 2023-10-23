<?php  

session_start();
require_once("bootstrap.php");


if (isset($_SESSION["klant"])) {
    header("Location: orderView.php"); 
    exit;
}


echo $twig->render('checkoutOptions.twig');
?>
