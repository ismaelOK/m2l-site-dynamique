<?php

class Formation{
    private string $idForma;
    private string $intitule;
    private string $descriptif;
    private string $dureeMinutes;
    private string $dateOuvertureInscri;
    private string $dateClotureInscri;
    private int $effectifActuel;
    private int $effectifMax;

     // Constructor
     public function __construct(
        string $idForma,
        string $intitule, 
        string $descriptif, 
        string $dureeMinutes, 
        string $dateOuvertureInscri, 
        string $dateClotureInscri, 
        int $effectifActuel,
        int $effectifMax
    ) {
        $this->idForma = $idForma;
        $this->intitule = $intitule;
        $this->descriptif = $descriptif;
        $this->dureeMinutes = $dureeMinutes;
        $this->dateOuvertureInscri = $dateOuvertureInscri;
        $this->dateClotureInscri = $dateClotureInscri;
        $this->effectifActuel = $effectifActuel;
        $this->effectifMax = $effectifMax;
    }

    // Getters
    public function getIdForma(): string {
        return $this->idForma;
    }


    public function getIntitule(): string {
        return $this->intitule;
    }

    public function getDescriptif(): string {
        return $this->descriptif;
    }

    public function getDureeMinutes(): string {
        return $this->dureeMinutes;
    }

    public function getDateOuvertureInscri(): string {
        return $this->dateOuvertureInscri;
    }

    public function getDateClotureInscri(): string {
        return $this->dateClotureInscri;
    }

    public function getEffectifActuel(): int {
        return $this->effectifActuel;
    }

    public function getEffectifMax(): int {
        return $this->effectifMax;
    }

    // Setters
    public function setIdForma(string $idForma): void {
        $this->idForma = $idForma;
    }

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

    public function setEffectifActuel(int $effectifMax): void {
        $this->effectifActuel = $effectifActuel;
    }

    public function setEffectifMax(int $effectifMax): void {
        $this->effectifMax = $effectifMax;
    }
}
