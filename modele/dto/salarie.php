<?php

class Salarie{
    use Hydrate;
    private string $idUser;
    private string $nom;
    private string $prenom;

    public function __construct(string $id, string $nom, string $prenom)
    {
        $this->idUser = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function getIdUser(): string{
        return $this->idUser;
    }

    public function setIdUser(string $newIdUser): void{
        $this->idUser = $newIdUser;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function setNom(string $newNom): void{
        $this->nom = $newNom;
    }

    public function getPrenom(): string{
        return $this->prenom;
    }

    public function setPrenom(string $newPrenom): void{
        $this->prenom = $newPrenom;
    }
}