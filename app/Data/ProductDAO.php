<?php 
//App/Data/ProductDAO.php
declare(strict_types=1);

namespace App\Data;

use App\Entities\Product;
use PDO;

class ProductDao {

  private PDO $db;

  public function __construct() {
    $this->db = DatabaseConnection::getInstance(); 
  }

  public function getAllProducts(): array {
    $stmt = $this->db->prepare("SELECT * FROM product");
    $stmt->execute();

    $products = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product = new Product(
            (int)$row['prodid'],
            $row['naam'],
            $row['productinformatie'],
            (float)$row['prijs'],
            $row['promotieprijs'] !== null ? (float)$row['promotieprijs'] : null,
            (bool)$row['beschikbaar']
        );
        $products[] = $product;
    }
    return $products;
}

public function getProductById(int $id): ?Product {
  $stmt = $this->db->prepare("SELECT * FROM product WHERE prodid = :id");
  $stmt->bindValue(":id", $id, PDO::PARAM_INT);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
      return new Product(
          $row['prodid'],
          $row['naam'],
          $row['productinformatie'],
          (float) $row['prijs'],
          $row['promotieprijs'] !== null ? (float) $row['promotieprijs'] : null,
          (bool) $row['beschikbaar']
      );
  }

  return null; 
}

}
