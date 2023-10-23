<?php
// App/Business/BestelregelService.php
declare(strict_types=1);

namespace App\Business;

use App\Data\BestelregelDAO;
use App\Entities\Bestelregel;
use App\Entities\Bestelling;

class BestelregelService {

    private BestelregelDAO $bestelregelDAO;

    public function __construct() {
        $this->bestelregelDAO = new BestelregelDAO();
    }

    public function voegBestelregelToe(Bestelregel $bestelregel): ?Bestelregel {
        return $this->bestelregelDAO->voegBestelregelToe($bestelregel);
    }

    public function getBestelregelById(int $id): ?Bestelregel {
        return $this->bestelregelDAO->getBestelregelById($id);
    }

    public function getBestelregelsPerBestelling(int $bestelid): array {
        return $this->bestelregelDAO->getBestelregelsPerBestelling($bestelid);
    }

    public function verwerkBestelregels(array $mandje, Bestelling $bestelling, ProductService $productService, KlantService $klantService): float {
        $totaalprijs = 0.0;
    
        foreach ($mandje as $productId => $aantal) {
            $product = $productService->getProductById((int) $productId);
            if ($product) {
                $bestelregel = new Bestelregel(0, $bestelling, $product, $aantal);
                $this->voegBestelregelToe($bestelregel);
    
                $klant = $bestelling->getKlant();
                $prijs = $klantService->heeftRechtOpPromotie($klant) && $product->getPromotieprijs() ? $product->getPromotieprijs() : $product->getPrijs();
                $totaalprijs += $prijs * $aantal;
            }
        }
    
        return $totaalprijs;
    }
    
    
}
