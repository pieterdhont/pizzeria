<?php 
// placeOrderController.php
declare(strict_types=1);

session_start();

require_once("bootstrap.php");

use App\Business\BestellingService;
use App\Business\BestelregelService;
use App\Business\ProductService;
use App\Business\KlantService;

try {
    if (!isset($_SESSION["klant"])) {
        throw new Exception("NotLoggedIn");
    }

    $klantService = new KlantService();
    $klant = $klantService->getKlantById($_SESSION["klant"]);

    $opmerkingen = $_POST['opmerkingen'] ?? '';

    $bestellingService = new BestellingService();
    $bestelling = $bestellingService->verwerkBestelling($klant, $opmerkingen);

    $bestelregelService = new BestelregelService();
    $productService = new ProductService();
    $totaalprijs = $bestelregelService->verwerkBestelregels($_SESSION["mandje"], $bestelling, $productService, $klantService);

    $_SESSION["mandje"] = [];

    $_SESSION["recenteBestelling"] = $bestelling;
    $_SESSION["recenteBestelregels"] = $bestelregelService->getBestelregelsPerBestelling($bestelling->getBestelid());
    $_SESSION["recenteTotaalprijs"] = $totaalprijs;

    header("Location: orderConfirmation.php");
    exit;
} catch (Exception $e) {
    if ($e->getMessage() === "NotLoggedIn") {
        header("Location: loginController.php");
        exit;
    } else {
        echo "Er is een fout opgetreden: " . $e->getMessage();
    }
}
?>
