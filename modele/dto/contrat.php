<?php

class Contrat{
    private string $idContrat;
    private DateTime $dateDebut;
    private DateTime $dateFin;
    private string $typeContrat;
    private float $nbHeures;
    private string $idUser;

    public function __construct(string $idContrat, DateTime $dateDebut, DateTime $dateFin, string $typeContrat, float $nbHeures, string $idUser)
    {
        $this->idContrat = $idContrat;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateDebut;
        $this->dateFin = $dateFin;
        $this->typeContrat = $typeContrat;
        $this->nbHeures = $nbHeures;
        $this->idUser = $idUser;
    }

    public function getIdContrat(): string{
        return $this->idContrat;
    }

    public function setIdContrat(string $newIdContrat): void{
        $this->idContrat = $newIdContrat;
    }

    public function getDateDebut(): DateTime{
        return $this->dateDebut;
    }

    public function setDateDebut(DateTime $newDateDebut): void{
        $this->dateDebut = $newDateDebut;
    }

    public function getDateFin(): DateTime{
        return $this->dateFin;
    }

    public function setDateFin(DateTime $newDateFin): void{
        $this->dateFin = $newDateFin;
    }

    public function getTypeContrat(): string{
        return $this->typeContrat;
    }

    public function setTypeContrat(string $newTypeContrat): void{
        $this->typeContrat = $newTypeContrat;
    }

    public function getNbHeures(): float{
        return $this->nbHeures;
    }

    public function setNbHeures(float $newNbHeures): void{
        $this->nbHeures = $newNbHeures;
    }

    public function getIdUser(): string{
        return $this->idUser;
    }

    public function setIdUser($newIdUser): void{
        $this->idUser = $newIdUser;
    }
}