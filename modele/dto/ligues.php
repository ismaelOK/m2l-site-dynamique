<?php
class Ligues {
    private array $ligues;

    public function __construct(array $array) {
        $this->ligues = $array; // Always an array; PHP 7.4+ syntax allows this
    }

    // Retourne toutes les ligues
    public function getLigues(): array {
        return $this->ligues;
    }

    // Cherche une ligue par son identifiant
    public function chercheLigue($unIdLigue): ?Ligue { // Assumes Ligue is the class for a league object
        foreach ($this->ligues as $ligue) {
            /*echo "<br>" . $ligue->getIdLigue() . "-  "  . $unIdLigue ;*/

            if ($ligue->getIdLigue() == $unIdLigue) {
                return $ligue; // Retourne la ligue trouvée
            }
        }
        return null; // Retourne null si aucune ligue n'est trouvée
    }
}
?>