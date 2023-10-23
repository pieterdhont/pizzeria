<?php 
//App/Entities/Plaats.php
declare(strict_types=1);

namespace App\Entities;

class Plaats {

  private int $postid;
    private string $postcode;
    private string $woonplaats;
    private bool $isleverbaar;

    public function __construct(
        int $postid,
        string $postcode,
        string $woonplaats,
        bool $isleverbaar
    ) {
        $this->postid = $postid;
        $this->postcode = $postcode;
        $this->woonplaats = $woonplaats;
        $this->isleverbaar = $isleverbaar;
    }

    public function getPostid(): int
    {
        return $this->postid;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function getWoonplaats(): string
    {
        return $this->woonplaats;
    }

    public function isLeverbaar(): bool
    {
        return $this->isleverbaar;
    }
}