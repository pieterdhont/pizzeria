<?php 
//App/Business/ProductService.php
declare(strict_types=1);

namespace App\Business;

use App\Data\ProductDAO;
use App\Entities\Product;
class ProductService {

  private ProductDAO $productDAO;

    public function __construct() {
        $this->productDAO = new ProductDAO();
    }

    public function getAllProducts(): array {
        return $this->productDAO->getAllProducts();
    }

    public function getProductById(int $id): ?Product {
      return $this->productDAO->getProductById($id);
  }

  
  public function getFinalProductPrice(Product $product): float {
      if ($product->getPromotieprijs()) {
          return $product->getPromotieprijs();
      }
      return $product->getPrijs();
  }

 


  public function addToMandje(array &$mandje, string $productId): void {
    $mandje[$productId] = ($mandje[$productId] ?? 0) + 1;
}

public function removeFromMandje(array &$mandje, string $productId): void {
    unset($mandje[$productId]);
}

public function removeOneFromMandje(array &$mandje, string $productId): void {
    if (--$mandje[$productId] <= 0) {
        unset($mandje[$productId]);
    }
}

public function getMandjeData(array $mandje, KlantService $klantService, ?int $klantId = null): array {
    $mandjeItems = [];
    $totaalprijs = 0.0;
    $klant = $klantId ? $klantService->getKlantById($klantId) : null;

    foreach ($mandje as $productId => $aantal) {
        $product = $this->getProductById((int) $productId);
        if ($product) {
            $mandjeItems[] = $product;
            $prijs = $klantService->heeftRechtOpPromotie($klant) && $product->getPromotieprijs() ? $product->getPromotieprijs() : $product->getPrijs();
            $totaalprijs += $prijs * $aantal;
        }
    }

    return [
        'mandje' => $mandje,
        'mandjeItems' => $mandjeItems,
        'totaalprijs' => $totaalprijs,
        'heeftRechtOpPromotie' => $klantService->heeftRechtOpPromotie($klant)
    ];
}

public function handleMandjePostRequest(array &$mandje, array $postData, KlantService $klantService): ?string {
    if (isset($postData["product_id"])) {
        $product = $this->getProductById((int) $postData["product_id"]);
        if ($product && $product->isBeschikbaar()) {
            $this->addToMandje($mandje, $postData["product_id"]);
        }
    }

    if (isset($postData["increase_product_id"])) {
        $this->addToMandje($mandje, $postData["increase_product_id"]);
    }
    

    if (isset($postData["remove_product_id"])) {
        $this->removeFromMandje($mandje, $postData["remove_product_id"]);
    }

    if (isset($postData["remove_one_product_id"])) {
        $this->removeOneFromMandje($mandje, $postData["remove_one_product_id"]);
    }

    if (isset($postData["checkout"])) {
        if (isset($postData["klant"])) {
            return "orderView.php";
        } else {
            return "checkoutController.php";
        }
    }

    return "ProductController.php";
}


}

