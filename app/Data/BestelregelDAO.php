<?php
// App/Data/BestelregelDAO.php
declare(strict_types=1);

namespace App\Data;

use App\Entities\Bestelregel;
use App\Data\BestellingDAO;
use App\Data\ProductDAO;
use PDO;

class BestelregelDAO {

    private PDO $db;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }

    public function getBestelregelById(int $id): ?Bestelregel {
        $stmt = $this->db->prepare("SELECT * FROM bestelregel WHERE bestelregid = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $bestellingDAO = new BestellingDAO();
            $bestelling = $bestellingDAO->getBestellingById($row['bestelid']);
            
            $productDAO = new ProductDAO();
            $product = $productDAO->getProductById($row['prodid']);

            return new Bestelregel(
                $row['bestelregid'],
                $bestelling,
                $product,
                $row['aantal']
            );
        }
        return null;
    }

    public function voegBestelregelToe(Bestelregel $bestelregel): ?Bestelregel {
        $stmt = $this->db->prepare("INSERT INTO bestelregel (bestelid, prodid, aantal) VALUES (:bestelid, :prodid, :aantal)"); // aangepast hier
        $stmt->bindValue(':bestelid', $bestelregel->getBestelling()->getBestelid());
        $stmt->bindValue(':prodid', $bestelregel->getProduct()->getProdid()); 
        $stmt->bindValue(':aantal', $bestelregel->getAantal());

        if ($stmt->execute()) {
            $bestelregid = (int) $this->db->lastInsertId();
            return new Bestelregel(
                $bestelregid,
                $bestelregel->getBestelling(),
                $bestelregel->getProduct(),
                $bestelregel->getAantal()
            );
        }
        return null;
    }

    public function getBestelregelsPerBestelling(int $bestelid): array {
        $stmt = $this->db->prepare("SELECT * FROM bestelregel WHERE bestelid = :bestelid");
        $stmt->bindParam(':bestelid', $bestelid);
        $stmt->execute();
    
        $bestelregels = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bestellingDAO = new BestellingDAO();
            $bestelling = $bestellingDAO->getBestellingById($row['bestelid']);
            
            $productDAO = new ProductDAO();
            $product = $productDAO->getProductById($row['prodid']);
    
            $bestelregels[] = new Bestelregel(
                $row['bestelregid'],
                $bestelling,
                $product,
                $row['aantal']
            );
        }
        return $bestelregels;
    }
    
}
