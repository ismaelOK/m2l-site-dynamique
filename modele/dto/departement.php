<?php
class Departement {
    use Hydrate;

    private ?string $codeDepartement;
    private ?string $nomDepartement;

    // Constructor now accepts parameters relevant to a Departement
    public function __construct(?string $unCodeDepartement, ?string $unNomDepartement) {
        $this->codeDepartement = $unCodeDepartement;
        $this->nomDepartement = $unNomDepartement;
    }

    public function getCodeDepartement(): ?string {
        return $this->codeDepartement;  // Getter for codeDepartement
    }

    public function setCodeDepartement(?string $unCodeDepartement): void {
        $this->codeDepartement = $unCodeDepartement;  // Setter for codeDepartement
    }

    public function getNomDepartement(): ?string {
        return $this->nomDepartement;  // Getter for nomDepartement
    }

    public function setNomDepartement(?string $unNomDepartement): void {
        $this->nomDepartement = $unNomDepartement;  // Setter for nomDepartement
    }
}
?>
