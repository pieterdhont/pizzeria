<?php 
// App/Entities/Bestelregel.php
declare(strict_types=1);

namespace App\Entities;

class Bestelregel {

    private int $bestelregid;
    private Bestelling $bestelling; 
    private Product $product;       
    private int $aantal;

    public function __construct(
        int $bestelregid,
        Bestelling $bestelling,
        Product $product,
        int $aantal
    ) {
        $this->bestelregid = $bestelregid;
        $this->bestelling = $bestelling;
        $this->product = $product;
        $this->aantal = $aantal;
    }

    public function getBestelregid(): int
    {
        return $this->bestelregid;
    }

    public function getBestelling(): Bestelling
    {
        return $this->bestelling;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAantal(): int
    {
        return $this->aantal;
    }
}
