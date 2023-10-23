<?php
//App/Entities/Klant.php
declare(strict_types=1);

namespace App\Entities;

class Klant {

  private int $klantid;
    private string $naam;
    private string $voornaam;
    private string $straat;
    private string $nummer;
    private Plaats $plaats;
    private string $telnr;
    private string $email;
    private string $wachtwoord;
    private string $bemerkingen;
    private bool $promotie;

    public function __construct(
        int $klantid,
        string $naam,
        string $voornaam,
        string $straat,
        string $nummer,
        Plaats $plaats,
        string $telnr,
        string $email,
        string $wachtwoord,
        string $bemerkingen,
        bool $promotie
    ) {
        $this->klantid = $klantid;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->nummer = $nummer;
        $this->plaats = $plaats;
        $this->telnr = $telnr;
        $this->email = $email;
        $this->wachtwoord = $wachtwoord;
        $this->bemerkingen = $bemerkingen;
        $this->promotie = $promotie;
    }

    public function getKlantid(): int
    {
        return $this->klantid;
    }

    public function getNaam(): string
    {
        return $this->naam;
    }

    public function getVoornaam(): string
    {
        return $this->voornaam;
    }

    public function getStraat(): string
    {
        return $this->straat;
    }

    public function getNummer(): string
    {
        return $this->nummer;
    }

    public function getPlaats(): Plaats
    {
        return $this->plaats;
    }

    public function getTelnr(): string
    {
        return $this->telnr;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getWachtwoord(): string
    {
        return $this->wachtwoord;
    }

    public function getBemerkingen(): string
    {
        return $this->bemerkingen;
    }

    public function hasPromotie(): bool
    {
        return $this->promotie;
    }
}