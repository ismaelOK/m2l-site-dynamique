<?php
class Communes {
    private array $communes;

    public function __construct(array $array) {
        // Use $array directly as the parameter type is enforced
        $this->clubs = $array; // Corrected to use $clubs instead of $ligues
    }

    // Retourne tous les clubs
    public function getClubs(): array {
        return $this->clubs; // Change to return clubs
    }

    // Cherche un club par son identifiant
    public function chercheClub(string $unIdClub): ?Club {
        // Boucle sur les clubs pour trouver celui qui correspond
        foreach ($this->clubs as $club) {
            if ($club->getIdClub() === $unIdClub) {
                return $club; // Retourne le club trouvé
            }
        }
        return null; // Retourne null si aucun club n'est trouvé
    }
}
?>
