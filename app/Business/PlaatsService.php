<?php 
// App/Business/PlaatsService.php
declare(strict_types=1);

namespace App\Business;

use App\Data\PlaatsDAO;
use App\Entities\Plaats;

class PlaatsService {
    
    private PlaatsDAO $plaatsDAO;

    public function __construct() {
        $this->plaatsDAO = new PlaatsDAO();
    }

    public function findPlaatsById(int $postid): ?Plaats {
        return $this->plaatsDAO->getPlaatsById($postid);
    }

    public function getAllPlaatsen(): array {
        return $this->plaatsDAO->getAllPlaatsen();
    }

    
}

