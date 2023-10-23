<?php 
//App/Entities/Product.php
declare(strict_types=1);

namespace App\Entities;


class Product {
    private int $prodid;
    private string $naam;
    private string $productinformatie;
    private float $prijs;
    private ?float $promotieprijs;
    private bool $beschikbaar;

    public function __construct(
        int $prodid,
        string $naam,
        string $productinformatie,
        float $prijs,
        ?float $promotieprijs,
        bool $beschikbaar
    ) {
        $this->prodid = $prodid;
        $this->naam = $naam;
        $this->productinformatie = $productinformatie;
        $this->prijs = $prijs;
        $this->promotieprijs = $promotieprijs;
        $this->beschikbaar = $beschikbaar;
    }

    public function getProdid(): int
    {
        return $this->prodid;
    }

    public function getNaam(): string
    {
        return $this->naam;
    }

    public function getProductinformatie(): string
    {
        return $this->productinformatie;
    }

    public function getPrijs(): float
    {
        return $this->prijs;
    }

    public function getPromotieprijs(): ?float
    {
        return $this->promotieprijs;
    }

    public function isBeschikbaar(): bool
    {
        return $this->beschikbaar;
    }

    
}






