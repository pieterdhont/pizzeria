<?php 
// App/Data/KlantDAO.php

declare(strict_types=1);
namespace App\Data;

use App\Entities\Klant;
use App\Data\PlaatsDAO;
use PDO;

class KlantDAO {
    
    private PDO $db;
    private PlaatsDAO $plaatsDAO;
    
    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
        $this->plaatsDAO = new PlaatsDAO();
    }
  
    public function emailIsAlGebruikt(string $email): bool {
        $stmt = $this->db->prepare("SELECT * FROM Klant WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
    public function registreer(Klant $klant): Klant {
        $gehashtWachtwoord = password_hash($klant->getWachtwoord(), PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Klant (naam, voornaam, straat, nummer, postid, telnr, email, wachtwoord, bemerkingen, promotie) VALUES (:naam, :voornaam, :straat, :nummer, :postid, :telnr, :email, :wachtwoord, :bemerkingen, :promotie)");
        $stmt->bindValue(":naam", $klant->getNaam());
        $stmt->bindValue(":voornaam", $klant->getVoornaam());
        $stmt->bindValue(":straat", $klant->getStraat());
        $stmt->bindValue(":nummer", $klant->getNummer());
        $stmt->bindValue(":postid", $klant->getPlaats()->getPostid());
        $stmt->bindValue(":telnr", $klant->getTelnr());
        $stmt->bindValue(":email", $klant->getEmail());
        $stmt->bindValue(":wachtwoord", $gehashtWachtwoord);
        $stmt->bindValue(":bemerkingen", $klant->getBemerkingen());
        $stmt->bindValue(":promotie", $klant->hasPromotie(), PDO::PARAM_BOOL);
        $stmt->execute();
        $laatsteNieuweId = (int) $this->db->lastInsertId();
        return new Klant($laatsteNieuweId, $klant->getNaam(), $klant->getVoornaam(), $klant->getStraat(), $klant->getNummer(), $klant->getPlaats(), $klant->getTelnr(), $klant->getEmail(), $klant->getWachtwoord(), $klant->getBemerkingen(), $klant->hasPromotie());
    }
    
    public function getKlantViaEmail(string $email): ?Klant {
        $stmt = $this->db->prepare("SELECT k.* FROM Klant k WHERE k.email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $resultaatSet = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$resultaatSet) {
            return null;
        } else {
            $plaats = $this->plaatsDAO->getPlaatsById($resultaatSet["postid"]);
            return new Klant((int)$resultaatSet["klantid"], $resultaatSet["naam"], $resultaatSet["voornaam"], $resultaatSet["straat"], $resultaatSet["nummer"], $plaats, $resultaatSet["telnr"], $resultaatSet["email"], $resultaatSet["wachtwoord"], $resultaatSet["bemerkingen"], (bool)$resultaatSet["promotie"]);
        }
    }

    public function getKlantViaId(int $klantid): ?Klant {
        $stmt = $this->db->prepare("SELECT k.* FROM Klant k WHERE k.klantid = :klantid");
        $stmt->bindValue(":klantid", $klantid);
        $stmt->execute();
        $resultaatSet = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$resultaatSet) {
            return null;
        } else {
            $plaats = $this->plaatsDAO->getPlaatsById($resultaatSet["postid"]);
            return new Klant((int)$resultaatSet["klantid"], $resultaatSet["naam"], $resultaatSet["voornaam"], $resultaatSet["straat"], $resultaatSet["nummer"], $plaats, $resultaatSet["telnr"], $resultaatSet["email"], $resultaatSet["wachtwoord"], $resultaatSet["bemerkingen"], (bool)$resultaatSet["promotie"]);
        }
    }

    public function updateKlant(Klant $klant): void {
        $stmt = $this->db->prepare("UPDATE Klant SET naam = :naam, voornaam = :voornaam, straat = :straat, nummer = :nummer, postid = :postid, telnr = :telnr, bemerkingen = :bemerkingen WHERE klantid = :klantid");
            
        $stmt->bindValue(":klantid", $klant->getKlantid());
        $stmt->bindValue(":naam", $klant->getNaam());
        $stmt->bindValue(":voornaam", $klant->getVoornaam());
        $stmt->bindValue(":straat", $klant->getStraat());
        $stmt->bindValue(":nummer", $klant->getNummer());
        $stmt->bindValue(":postid", $klant->getPlaats()->getPostid());
        $stmt->bindValue(":telnr", $klant->getTelnr());
        $stmt->bindValue(":bemerkingen", $klant->getBemerkingen());
            
        $stmt->execute();
    }
    
    
}

?>
