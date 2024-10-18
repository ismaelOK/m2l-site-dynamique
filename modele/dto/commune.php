<?php
class Commune {
    use Hydrate;

    private ?int $idCommune;
    private ?string $codePostal;
    private ?string $nomCommune;
    private ?Departement $departement; // Reference to a Departement object

    public function __construct(?int $unIdCommune, ?string $unCodePostal, ?string $unNomCommune, ?Departement $unDepartement) {
        $this->idCommune = $unIdCommune;
        $this->codePostal = $unCodePostal;
        $this->nomCommune = $unNomCommune;
        $this->departement = $unDepartement;  // Assign the Departement object
    }

    public function getIdCommune(): ?int {
        return $this->idCommune;  
    }

    public function setIdCommune(?int $unIdCommune): void {
        $this->idCommune = $unIdCommune;  
    }

    public function getCodePostal(): ?string {
        return $this->codePostal;  
    }

    public function setCodePostal(?string $unCodePostal): void {
        $this->codePostal = $unCodePostal;  
    }

    public function getNomCommune(): ?string {
        return $this->nomCommune;  
    }

    public function setNomCommune(?string $unNomCommune): void {
        $this->nomCommune = $unNomCommune;  
    }

    public function getDepartement(): ?Departement {
        return $this->departement;  // Getter for the Departement object
    }

    public function setDepartement(?Departement $unDepartement): void {
        $this->departement = $unDepartement;  // Setter for the Departement object
    }

    // Additional method to get the codeDepartement directly
    public function getCodeDepartement(): ?string {
        return $this->departement ? $this->departement->getCodeDepartement() : null; // Return codeDepartement if departement is set
    }
}
?>
