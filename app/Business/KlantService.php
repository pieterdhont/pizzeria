<?php
// App/Business/KlantService.php

namespace App\Business;

use App\Data\KlantDAO;
use App\Entities\Klant;
use App\Entities\Plaats;
use App\Exceptions\KlantBestaatAlException;
use App\Exceptions\OngeldigEmailadresException;
use App\Exceptions\KlantNietGevondenException;
use App\Exceptions\IncorrectWachtwoordException;

class KlantService {
    private KlantDAO $klantDAO;

    public function __construct() {
        $this->klantDAO = new KlantDAO();
    }

    public function registreerKlant(string $naam, string $voornaam, string $straat, string $nummer, Plaats $plaats, string $telnr, string $email, string $wachtwoord, string $bemerkingen, bool $promotie): Klant {
        $this->valideerEmail($email);
        
        if ($this->klantDAO->emailIsAlGebruikt($email)) {
            throw new KlantBestaatAlException("Er bestaat al een klant met dit e-mailadres.");
        }
        
        $klant = new Klant(0, $naam, $voornaam, $straat, $nummer, $plaats, $telnr, $email, $wachtwoord, $bemerkingen, $promotie); 

        return $this->klantDAO->registreer($klant);
    }

    private function valideerEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new OngeldigEmailadresException("Het ingevoerde e-mailadres is ongeldig.");
        }
    }

    public function inloggen(string $email, string $wachtwoord): Klant {
        $klant = $this->klantDAO->getKlantViaEmail($email);

        if (!$klant) {
            throw new KlantNietGevondenException("Klant met e-mail $email bestaat niet.");
        }

        $hashedWachtwoord = $klant->getWachtwoord(); 
        if (!password_verify($wachtwoord, $hashedWachtwoord)) {
            throw new IncorrectWachtwoordException("Het ingevoerde wachtwoord is onjuist.");
        }

        return $klant; 
    }
    
    public function verifieerKlant(string $email, string $wachtwoord): ?Klant {
        $klant = $this->klantDAO->getKlantViaEmail($email);
        if (!$klant || !password_verify($wachtwoord, $klant->getWachtwoord())) {
            return null;
        }
        return $klant;
    }

    public function updateKlant(Klant $klant, string $naam, string $voornaam, string $straat, string $nummer, Plaats $plaats, string $telnr, string $bemerkingen): void {
        $updatedKlant = new Klant(
            $klant->getKlantid(), 
            $naam, 
            $voornaam, 
            $straat, 
            $nummer, 
            $plaats, 
            $telnr, 
            $klant->getEmail(),
            $klant->getWachtwoord(),
            $bemerkingen, 
            $klant->hasPromotie()
        );
        $this->klantDAO->updateKlant($updatedKlant);
    }
    

    public function getKlantById(int $klantid): ?Klant {
        return $this->klantDAO->getKlantViaId($klantid);
    }
    
    public function heeftRechtOpPromotie($klant): bool {
        return $klant && $klant->hasPromotie();
    }
}

?>
 