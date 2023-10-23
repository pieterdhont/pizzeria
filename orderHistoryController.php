<?php 
// OrderHistoryController.php
declare(strict_types=1);

require_once("bootstrap.php");

use App\Business\BestellingService;
use App\Business\BestelregelService;
use App\Business\ProductService;
use App\Business\KlantService;

session_start();

try {
    if (!isset($_SESSION["klant"])) {
        throw new Exception("NotLoggedIn");
    }

    $klantId = $_SESSION["klant"];
    $bestellingService = new BestellingService();
    $bestellingen = $bestellingService->getBestellingenPerKlant($klantId);

    $bestelregelService = new BestelregelService();
    $productService = new ProductService();
    $klantService = new KlantService();
    $bestelregelsList = [];
    $bestellingTotaalprijzen = [];

    foreach ($bestellingen as $bestelling) {
        $bestelregels = $bestelregelService->getBestelregelsPerBestelling($bestelling->getBestelid());
        $bestelregelsList[$bestelling->getBestelid()] = $bestelregels;
        $bestellingTotaalprijzen[$bestelling->getBestelid()] = $bestellingService->berekenTotaalprijsVanBestelling($bestelling->getBestelid(), $productService, $klantService);
    }

    echo $twig->render('orderHistory.twig', [
        'bestellingen' => $bestellingen,
        'bestelregelsList' => $bestelregelsList,
        'bestellingTotaalprijzen' => $bestellingTotaalprijzen
    ]);
} catch (Exception $e) {
    if ($e->getMessage() === "NotLoggedIn") {
        header("Location: loginController.php");
        exit;
    } else {
        echo "Er is een fout opgetreden: " . $e->getMessage();
    }
}
?>
