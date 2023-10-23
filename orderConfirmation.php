<?php 
// orderConfirmation.php
declare(strict_types=1);

require_once("bootstrap.php");

use App\Business\KlantService;

session_start();

try {
    if (!isset($_SESSION["klant"])) {
        throw new Exception("NotLoggedIn");
    }

    if (!isset($_SESSION["recenteBestelling"]) || !isset($_SESSION["recenteBestelregels"])) {
        throw new Exception("Ontbrekende sessiegegevens");
    }

    $klantService = new KlantService();
    $klantId = $_SESSION["klant"];
    $klant = $klantService->getKlantById($klantId);
    
    $recenteBestelling = $_SESSION["recenteBestelling"];
    $recenteBestelregels = $_SESSION["recenteBestelregels"];
    $recenteTotaalprijs = $_SESSION["recenteTotaalprijs"];
    
    echo $twig->render('orderConfirmation.twig', [
        'adresgegevens' => $klant,
        'bestelling' => $recenteBestelling,
        'bestelregels' => $recenteBestelregels,
        'totaalprijs' => $recenteTotaalprijs
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
