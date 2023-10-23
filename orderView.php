<?php
// orderView.php
declare(strict_types=1);

session_start();

require_once("bootstrap.php");

use App\Business\ProductService;
use App\Business\KlantService;

try {
    
    if (!isset($_SESSION["klant"])) {
        throw new Exception("NotLoggedIn");
    }

    

    $productService = new ProductService();
    $klantService = new KlantService();

    $klantId = $_SESSION["klant"];
    $klant = $klantService->getKlantById($klantId);

    $opmerkingen = $_POST['opmerkingen'] ?? ''; 
    $confirmationMessage = ($_SERVER["REQUEST_METHOD"] === "POST") ? "Bedankt voor je bestelling! Je bestelling is geplaatst en wordt verwerkt." : "";

    $mandjeData = $productService->getMandjeData($_SESSION["mandje"] ?? [], $klantService, $klantId);

    echo $twig->render('orderView.twig', [
        'adresgegevens' => $klant,
        'confirmationMessage' => $confirmationMessage,
        'opmerkingen' => $opmerkingen  
    ] + $mandjeData);

} catch (Exception $e) {
    if ($e->getMessage() === "NotLoggedIn") {
        header("Location: loginController.php");
        exit;
    } else {
        echo "Er is een fout opgetreden: " . $e->getMessage();
    }
}
?>
