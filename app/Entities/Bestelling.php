<?php 
//App/Entities/Bestelling.php
declare(strict_types=1);

namespace App\Entities;

class Bestelling {

  private int $bestelid;
    private Klant $klant;  
    private \DateTime $datumuur;
    private string $opmerking;

    public function __construct(
        int $bestelid,
        Klant $klant,
        \DateTime $datumuur,
        string $opmerking
    ) {
        $this->bestelid = $bestelid;
        $this->klant = $klant;
        $this->datumuur = $datumuur;
        $this->opmerking = $opmerking;
    }

    public function getBestelid(): int
    {
        return $this->bestelid;
    }

    public function getKlant(): Klant
    {
        return $this->klant;
    }

    public function getDatumuur(): \DateTime
    {
        return $this->datumuur;
    }

    public function getOpmerking(): string
    {
        return $this->opmerking;
    }
}


