<?php

class Formation{

    private string $intitule;
    private string $descriptif;
    private string $dureeMinutes;
    private string $dateOuvertureInscri;
    private string $dateClotureInscri;
    private int $effectifMax;

     // Constructor
     public function __construct(
        string $intitule, 
        string $descriptif, 
        float $dureeMinutes, 
        string $dateOuvertureInscri, 
        string $dateClotureInscri, 
        int $effectifMax
    ) {
        $this->intitule = $intitule;
        $this->descriptif = $descriptif;
        $this->dureeMinutes = $dureeMinutes;
        $this->dateOuvertureInscri = $dateOuvertureInscri;
        $this->dateClotureInscri = $dateClotureInscri;
        $this->effectifMax = $effectifMax;
    }

    // Getters
    public function getIntitule(): string {
        return $this->intitule;
    }

    public function getDescriptif(): string {
        return $this->descriptif;
    }

    public function getDureeMinutes(): float {
        return $this->dureeMinutes;
    }

    public function getDateOuvertureInscri(): string {
        return $this->dateOuvertureInscri;
    }

    public function getDateClotureInscri(): string {
        return $this->dateClotureInscri;
    }

    public function getEffectifMax(): int {
        return $this->effectifMax;
    }

    // Setters
    public function setIntitule(string $intitule): void {
        $this->intitule = $intitule;
    }

    public function setDescriptif(string $descriptif): void {
        $this->descriptif = $descriptif;
    }

    public function setDureeMinutes(float $dureeMinutes): void {
        $this->dureeMinutes = $dureeMinutes;
    }

    public function setDateOuvertureInscri(string $dateOuvertureInscri): void {
        $this->dateOuvertureInscri = $dateOuvertureInscri;
    }

    public function setDateClotureInscri(string $dateClotureInscri): void {
        $this->dateClotureInscri = $dateClotureInscri;
    }

    public function setEffectifMax(int $effectifMax): void {
        $this->effectifMax = $effectifMax;
    }
}
