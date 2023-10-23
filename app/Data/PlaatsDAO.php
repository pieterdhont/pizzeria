<?php 
// App/Data/PlaatsDAO.php
declare(strict_types=1);

namespace App\Data;

use App\Entities\Plaats;
use PDO;

class PlaatsDAO {
    
    private PDO $db; 
    
    public function __construct() {
        $this->db = DatabaseConnection::getInstance(); 
    }
  
    public function getPlaatsById(int $postid): ?Plaats {
        $stmt = $this->db->prepare("SELECT * FROM plaats WHERE postid = :postid");
        $stmt->bindValue(":postid", $postid);
        $stmt->execute();
        $resultaatSet = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$resultaatSet) {
            return null;
        } else {
            return new Plaats($resultaatSet["postid"], $resultaatSet["postcode"], $resultaatSet["woonplaats"], (bool)$resultaatSet["isleverbaar"]);
        }
    }

    public function getAllPlaatsen(): array {
        $stmt = $this->db->prepare("SELECT * FROM plaats");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $plaatsen = [];
        foreach ($results as $row) {
            $plaatsen[] = new Plaats($row["postid"], $row["postcode"], $row["woonplaats"], (bool)$row["isleverbaar"]);
        }
    
        return $plaatsen;
    }

    
}
