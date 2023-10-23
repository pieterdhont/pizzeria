<?php 
//App/Data/BestellingDAO.php
declare(strict_types=1);

namespace App\Data;

use App\Entities\Bestelling;
use App\Data\KlantDAO;
use PDO;

class BestellingDAO {

  private PDO $db;

  public function __construct() {
    $this->db = DatabaseConnection::getInstance();
  } 

public function getBestellingById(int $id): ?Bestelling {
    $stmt = $this->db->prepare("SELECT * FROM bestelling WHERE bestelid = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $klantDAO = new KlantDAO();
        $klant = $klantDAO->getKlantViaId($row['klantid']);
        return new Bestelling(
            $row['bestelid'],
            $klant,
            new \DateTime($row['datumuur']),
            $row['opmerking']
        );
    }
    return null;
}
public function voegBestellingToe(Bestelling $bestelling): ?Bestelling {
  $stmt = $this->db->prepare("INSERT INTO bestelling (klantid, datumuur, opmerking) VALUES (:klantid, :datumuur, :opmerking)");
  $stmt->bindValue(':klantid', $bestelling->getKlant()->getKlantid());
  $stmt->bindValue(':datumuur', $bestelling->getDatumuur()->format('Y-m-d H:i:s'));
  $stmt->bindValue(':opmerking', $bestelling->getOpmerking());

  if ($stmt->execute()) {
      $bestelid = (int) $this->db->lastInsertId();
      return new Bestelling(
          $bestelid,
          $bestelling->getKlant(),
          $bestelling->getDatumuur(),
          $bestelling->getOpmerking()
      );
  }
  return null;
}

public function getBestellingenPerKlant(int $klantId): array {
  $stmt = $this->db->prepare("SELECT * FROM bestelling WHERE klantid = :klantId ORDER BY datumuur DESC");
  $stmt->bindParam(':klantId', $klantId);
  $stmt->execute();

  $bestellingen = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $klantDAO = new KlantDAO();
      $klant = $klantDAO->getKlantViaId($row['klantid']);
      $bestelling = new Bestelling(
          $row['bestelid'],
          $klant,
          new \DateTime($row['datumuur']),
          $row['opmerking']
      );
      $bestellingen[] = $bestelling;
  }
  return $bestellingen;
}
}
?>