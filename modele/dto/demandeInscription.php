<?php
    class DemandeInscription{
        private string $idUtilisateur;
        private string $idForma;
        private string $etatDemande;
        //0-> En attente
        //1-> Validé
        //2-> Refusée

        // Getters
        public function getIdUtilisateur(): string {
            return $this->idUtilisateur;
        }

        public function getIdForma(): string {
            return $this->idForma;
        }

        public function getEtatDemande(): string {
            return $this->etatDemande;
        }

        // Setters
        public function setIdUtilisateur(string $idUtilisateur): void {
            $this->idUtilisateur = $idUtilisateur;
        }

        public function setIdForma(string $idForma): void {
            $this->idForma = $idForma;
        }

        public function setEtatDemande(string $etatDemande): void {
            $this->etatDemande = $etatDemande;
        }
    }