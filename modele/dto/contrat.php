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
        $this->typeContrat = $typeContrat;
        $this->nbHeures = $nbHeures;
        $this->idUser = $idUser;
    }

    public function getIdContrat(): string{
        return $this->idContrat;
    }

    public function setIdContrat($newIdContrat): void{
        $this->idContrat = $newIdContrat;
    }
}