<?php
class UtilisateurDAO {
    public static function verification(Utilisateur $utilisateur) {
        $login = $utilisateur->getLogin();
        $mdp = $utilisateur->getMDP();

        // Requête pour récupérer l'utilisateur correspondant au login
        $requetePrepa = DBConnex::getInstance()->prepare("
            SELECT login, typeUser, idUser, nom , prenom
            FROM utilisateur
            WHERE login = :login
            AND mdp = md5(:mdp)
        ");

        // Liaison des paramètres
        $requetePrepa->bindParam(":login", $login);
        $requetePrepa->bindParam(":mdp", $mdp);

        // Exécuter la requête
        $requetePrepa->execute();

        // Renvoyer les informations de l'utilisateur trouvé, s'il existe
        return $requetePrepa->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserDetailsById($id){
        $sql = "SELECT nom, prenom, typeUser FROM utilisateur WHERE idUser = :idUser";

        try{
            $prepared = DBConnex::getInstance()->prepare($sql);

            $prepared->bindParam(":idUser", $id);

            $prepared->execute();

            return $prepared->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }
}
?>
