<?php
class Bulletin{
    protected string $idBulletin;
    
    protected int $mois;
    
    protected int $annee;

    protected string $bulletinPDF;

    protected string $idContrat;
    
    //Constructeur
    public function __construct(string $idBulletin, int $mois, int $annee, string $bulletinPDF, $idContrat)
    {
        $this->idBulletin = $idBulletin;
        $this->mois = $mois;
        $this->annee = $annee;
        $this->bulletinPDF = $bulletinPDF;
        $this->idContrat = $idContrat;
    }


    //Getter et Setter de l'id de Bulletin
    public function getIdBulletin() : string{
        return $this->idBulletin;
    }

    public function setIdBulletin(string $newIdBullein) : void {
        $this->idBulletin = $newIdBullein;
    }

    //Getter et setter du mois de bulletin
    public function getMois() : int{
        return $this->mois;
    }

    public function setMois(int $newMois) : void{
        $this->mois = $newMois;
    }

    //Getter et Setter de l'annee de Bulletin
    public function getAnnee(): int{
        return $this->annee;
    }

    public function setAnne(int $newAnnee) : void{
        $this->annee = $newAnnee;
    }

    //Getter et Setter du PDF de Bulletin
    public function getPDFBulletin() : string{
        return $this->bulletinPDF;
    }

    public function setPDFBulletin(string $newBulleinPDF) : void{
        $this->bulletinPDF = $newBulleinPDF;
    }

    //Getter et Setter pour l'id du contrat
    public function getIdContrat() : string{
        return $this->idContrat;
    }

    public function setIdContrat(string $newIdContrat) : void{
        $this->idContrat = $newIdContrat;
    }
}
?>
