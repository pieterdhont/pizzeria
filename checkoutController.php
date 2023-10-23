<?php  
// checkoutController.php
session_start();
require_once("bootstrap.php");

// Als de gebruiker al is ingelogd, stuur hem/haar dan rechtstreeks naar het overzicht
if (isset($_SESSION["klant"])) {
    header("Location: orderView.php"); // Veronderstellend dat orderOverview.php het overzicht toont
    exit;
}

// Render de Twig-template voor de checkout-opties
echo $twig->render('checkoutOptions.twig');
?>
