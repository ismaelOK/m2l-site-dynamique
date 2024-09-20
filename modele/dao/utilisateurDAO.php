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
}
?>
