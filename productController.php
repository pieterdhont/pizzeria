<?php
// productController.php
declare(strict_types=1);

session_start();

require_once("bootstrap.php");

use App\Business\ProductService;
use App\Business\KlantService;

try {
    $productService = new ProductService();
    $klantService = new KlantService();

    $mandje = $_SESSION["mandje"] ?? [];
    $klantId = $_SESSION["klant"] ?? null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $redirectPage = $productService->handleMandjePostRequest($mandje, $_POST + ["klant" => $klantId], $klantService);
        $_SESSION["mandje"] = $mandje;  
        if ($redirectPage) {
            header("Location: " . $redirectPage);
            exit;
        }
    }

    $jsondata = file_get_contents("pizzas.json");
    $pizza = json_decode($jsondata, true);
    $products = $productService->getAllProducts();
    $mandjeData = $productService->getMandjeData($mandje, $klantService, $klantId);

    echo $twig->render('product_overview.twig', $mandjeData + ['products' => $products] + ['pizza' => $pizza]);
} catch (Exception $e) {
    echo "Er is een fout opgetreden: " . $e->getMessage();
}

