<?php
class Club {
    use Hydrate;

    private ?int $idClub;
    private ?string $nomClub;
    private ?string $adresseClub;
    private ?Ligue $ligue;          // Reference to a Ligue object
    private ?Commune $commune;      // Reference to a Commune object

    public function __construct(?int $unIdClub, ?string $unNomClub, ?string $unAdresseClub, ?Ligue $uneLigue, ?Commune $uneCommune) {
        $this->idClub = $unIdClub;
        $this->nomClub = $unNomClub;
        $this->adresseClub = $unAdresseClub;
        $this->ligue = $uneLigue;      // Assign the Ligue object
        $this->commune = $uneCommune;  // Assign the Commune object
    }

    public function getIdClub(): ?int {
        return $this->idClub;
    }

    public function setIdClub(?int $unIdClub): void {
        $this->idClub = $unIdClub;
    }

    public function getNomClub(): ?string {
        return $this->nomClub;
    }

    public function setNomClub(?string $unNomClub): void {
        $this->nomClub = $unNomClub;
    }

    public function getAdresseClub(): ?string {
        return $this->adresseClub;
    }

    public function setAdresseClub(?string $unAdresseClub): void {
        $this->adresseClub = $unAdresseClub;
    }

    public function getLigue(): ?Ligue {
        return $this->ligue;  // Getter for the Ligue object
    }

    public function setLigue(?Ligue $uneLigue): void {
        $this->ligue = $uneLigue;  // Setter for the Ligue object
    }

    public function getCommune(): ?Commune {
        return $this->commune;  // Getter for the Commune object
    }

    public function setCommune(?Commune $uneCommune): void {
        $this->commune = $uneCommune;  // Setter for the Commune object
    }

    // Example method to get Ligue ID
    public function getIdLigue(): ?string {
        return $this->ligue ? $this->ligue->getIdLigue() : null; // Return idLigue if ligue is set
    }

    // Example method to get Commune ID
    public function getIdCommune(): ?string {
        return $this->commune ? $this->commune->getIdCommune() : null; // Return idCommune if commune is set
    }
}
?>
