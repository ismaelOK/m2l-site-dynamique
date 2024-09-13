<?php
class UtilisateurDAO{
    public static function verification(Utilisateur $utilisateur){
        
        $login = $utilisateur->getLogin();
        $mdp = $utilisateur->getMDP();
        

        $requetePrepa = DBConnex::getInstance()->prepare("select login from utilisateur where login = :login and  mdp = md5(:mdp)");
        $requetePrepa->bindParam( ":login", $login);
        $requetePrepa->bindParam( ":mdp" ,  $mdp);
        
        $requetePrepa->execute();
        
        return $requetePrepa->fetch();
       
    }

}
?>
