<?php
// registerController.php
declare(strict_types=1);

session_start();

require_once("bootstrap.php");

use App\Business\KlantService;
use App\Business\PlaatsService;

$klantService = new KlantService();
$plaatsService = new PlaatsService();
$plaatsen = $plaatsService->getAllPlaatsen();

try {
    $errorMessage = "";
    $isKlantLoggedIn = isset($_SESSION["klant"]);
    $klant = $isKlantLoggedIn ? $klantService->getKlantById((int)$_SESSION["klant"]) : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $plaats = $plaatsService->findPlaatsById((int)$_POST["plaats"]);
        
        if (!$plaats->isLeverbaar()) {
            throw new Exception("Bezorging in deze postcode is niet mogelijk.");
        }

        $naam = $_POST["naam"];
        $voornaam = $_POST["voornaam"];
        $straat = $_POST["straat"];
        $nummer = $_POST["nummer"];
        $telnr = $_POST["telnr"];
        $bemerkingen = $_POST["bemerkingen"];
        $email = $_POST["email"];
        $wachtwoord = $_POST["wachtwoord"];
        $promotie = isset($_POST["promotie"]);

        if ($isKlantLoggedIn) {
            $klantService->updateKlant($klant, $naam, $voornaam, $straat, $nummer, $plaats, $telnr, $bemerkingen);
        } else {
            if (isset($_POST["createAccount"])) {
                $klant = $klantService->registreerKlant($naam, $voornaam, $straat, $nummer, $plaats, $telnr, $email, $wachtwoord, $bemerkingen, $promotie);
                $_SESSION["klant"] = $klant->getKlantid();
            }
        }

        header("Location: orderView.php");
        exit;
    }

    echo $twig->render('register.twig', [
        "errorMessage" => $errorMessage,
        "plaatsen" => $plaatsen,
        "isKlantLoggedIn" => $isKlantLoggedIn,
        "adresgegevens" => $klant
    ]);

} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    echo $twig->render('register.twig', [
        "errorMessage" => $errorMessage,
        "plaatsen" => $plaatsen,
        "isKlantLoggedIn" => $isKlantLoggedIn ?? false,
        "adresgegevens" => $klant ?? null
    ]);
}
?>
