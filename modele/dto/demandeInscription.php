<?php
   class DemandeInscription {
    private string $codeDemande;
    private Utilisateur $utilisateur;
    private Formation $formation;
    private string $etatDemande;
    //0 -> En attente
    //1 -> Refusée
    //2 -> Validée



    // Constructor
    public function __construct(
        string $codeDemande,
        Utilisateur $utilisateur,
        Formation $formation,
        string $etatDemande  
    ) {
        $this->codeDemande = $codeDemande;
        $this->utilisateur = $utilisateur;
        $this->formation = $formation;
        $this->etatDemande = $etatDemande;
    }

    // Getters
    public function getCodeDemande(): string {
        return $this->codeDemande;
    }

    public function getUtilisateur(): Utilisateur {
        return $this->utilisateur;
    }

    public function getFormation(): Formation {
        return $this->formation;
    }

    public function getEtatDemande(): string {
        return $this->etatDemande;
    }

    // Setters
    public function setCodeDemande(string $codeDemande): void {
        $this->codeDemande = $codeDemande;
    }

    public function setUtilisateur(Utilisateur $utilisateur): void {
        $this->utilisateur = $utilisateur;
    }

    public function setFormation(Formation $formation): void {
        $this->formation = $formation;
    }

    public function setEtatDemande(string $etatDemande): void {
        $this->etatDemande = $etatDemande;
    }
}