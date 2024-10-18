<?php
class Ligue {
    use Hydrate;

    private ?int $idLigue;
    private ?string $nomLigue;
    private ?string $site;
    private ?string $descriptif;

    public function __construct(?int $unIdLigue, ?string $unNomLigue, ?string $unSite, ?string $unDescriptif) {
        $this->idLigue = $unIdLigue;
        $this->nomLigue = $unNomLigue;
        $this->site = $unSite;
        $this->descriptif = $unDescriptif;
    }

    public function getIdLigue(): ?int {
        return $this->idLigue;
    }

    public function setIdLigue(int $unIdLigue): void {
        $this->idLigue = $unIdLigue;
    }

    public function getNomLigue(): ?string {
        return $this->nomLigue;
    }

    public function setNomLigue(string $unNomLigue): void {
        $this->nomLigue = $unNomLigue;
    }

    public function getSite(): ?string {
        return $this->site;
    }

    public function setSite(string $unSite): void {
        $this->site = $unSite;
    }

    public function getDescriptif(): ?string {
        return $this->descriptif;
    }

    public function setDescriptif(string $unDescriptif): void {
        $this->descriptif = $unDescriptif;
    }
    
    public function getImage(): string {
        // Récupérer le dernier mot du nom de la ligue
        $lastWord = strrchr(trim($this->nomLigue), ' '); // Trouver le dernier espace
        $lastWord = ltrim($lastWord); // Enlever l'espace pour obtenir juste le mot
    
        // Convertir en minuscules et construire le chemin de l'image
        $imageFileName = strtolower($lastWord) . '.jpg'; // Assurez-vous que les images soient en .jpg
        $imagePath = 'images/' . $imageFileName; // Retourne le chemin complet de l'image
    
        // Debugging output
        if (!file_exists($imagePath)) {
            echo "Image not found: " . $imagePath . "<br>";
        }
    
        return $imagePath; // Retourne le chemin complet de l'image
    }
    
}
?>