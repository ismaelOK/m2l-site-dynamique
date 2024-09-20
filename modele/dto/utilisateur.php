<?php
class Utilisateur{
    use Hydrate;
    private string $idUser;
    private string $nom;
    private string $prenom;
    private string $login;
    private string $mdp;
    private string $typeUser;
    private string $idLigue;
    private string $idClub;
    private string $idFonct;

    public function __construct(string $idUser, string $nom, string $prenom, string $login, string $mdp, string $typeUser, string $idLigue, string $idClub, string $idFonct){
        $this->idUser = $idUser;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->mdp = $mdp;
        $this->typeUser = $typeUser;
        $this->idLigue = $idLigue;
        $this->idClub = $idClub;
        $this->idFonct = $idFonct;
    }

    //Getter et Setter de l'IdUser
    public function getIdUser(): string{
        return $this->idUser;
    }

    public function setIdUser(string $newIdUser): void{
        $this->idUser = $newIdUser;
    }

    //Getter et Setter du nom
    public function getNom(): string{
        return $this->nom;
    }

    public function setNom(string $newNom) : void{
        $this->nom = $newNom;
    }

    //Getter et Setter du prénom
    public function getPrenom() : string{
        return $this->prenom;
    }

    public function setPrenom(string $newPrenom) : void{
        $this->prenom = $newPrenom;
    }

    //Getter et Setter du login
    public function getLogin(): string{
        return $this->login;
    }

    public function setLogin($newLogin): void{
        $this->login = $newLogin;
    }

    //Getter et Setter du MDP
    public function getMDP(): string{
        return $this->mdp;
    }

    public function setMDP(string $newMDP) : void{
        $this->mdp = $newMDP;
    }

    //Getter et Setter du type de L'utilisateur
    public function getTypeUser(): string{
        return $this->typeUser;
    }

    public function setTypeUser(string $newTypeUser) : void{
        $this->typeUser = $newTypeUser;
    }

    //Getter et Setter du ligue de l'Utilisateur
    public function getIdLigue(): string{
        return $this->idLigue;
    }

    public function setIdLigue(string $newIdLigue): void{
        $this->idLigue = $newIdLigue;
    }

    //Getter et Setter de l'id du Club
    public function getIdClub(): string{
        return $this->idClub;
    }

}

