<?php 
//App/Business/BestellingService.php
declare(strict_types=1);

namespace App\Business;

use App\Data\BestellingDAO;
use App\Entities\Bestelling;
use App\Entities\Klant;



class BestellingService {
  private BestellingDAO $bestellingDAO;

  public function __construct() {
      $this->bestellingDAO = new BestellingDAO();
  }

  public function getBestellingById(int $id): ?Bestelling {
      return $this->bestellingDAO->getBestellingById($id);
  }

  public function voegBestellingToe(Bestelling $bestelling): ?Bestelling {
      return $this->bestellingDAO->voegBestellingToe($bestelling);
  }

  public function getBestellingenPerKlant(int $klantId): array {
      return $this->bestellingDAO->getBestellingenPerKlant($klantId);
  }

  public function verwerkBestelling(Klant $klant, string $opmerkingen): Bestelling {
    $bestelling = new Bestelling(0, $klant, new \DateTime(), $opmerkingen);
    return $this->voegBestellingToe($bestelling);
}

// App/Business/BestellingService.php

public function berekenTotaalprijsVanBestelling(int $bestelid, ProductService $productService, KlantService $klantService): float {
    $bestelregelService = new BestelregelService();
    $totaalprijs = 0.0;
    
    // Haal de bestelregels op voor de gegeven bestelling.
    $bestelregels = $bestelregelService->getBestelregelsPerBestelling($bestelid);

    foreach ($bestelregels as $bestelregel) {
        $product = $productService->getProductById($bestelregel->getProduct()->getProdId());
        if ($product) {
            $klant = $bestelregel->getBestelling()->getKlant();
            $prijs = $klantService->heeftRechtOpPromotie($klant) && $product->getPromotieprijs() ? $product->getPromotieprijs() : $product->getPrijs();
            $totaalprijs += $prijs * $bestelregel->getAantal();
        }
    }

    return $totaalprijs;
}


}
?>