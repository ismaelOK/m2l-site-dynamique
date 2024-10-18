<?php
class Departements {
    private array $departements; // Holds an array of Departement objects

    public function __construct(array $array) {
        // Ensure that the passed array contains Departement objects
        $this->departements = $array; // Corrected to use $departements
    }

    // Returns all departments
    public function getDepartements(): array {
        return $this->departements; // Change to return departements
    }

    // Searches for a department by its identifier
    public function chercheDepartement(string $unIdDepartement): ?Departement {
        // Loop through the departements to find the one that matches
        foreach ($this->departements as $departement) {
            if ($departement->getCodeDepartement() === $unIdDepartement) {
                return $departement; // Return the found departement
            }
        }
        return null; // Return null if no departement is found
    }
}
?>
