<?php
class ContratDAO{
    public static function getContratsBySalarieId($idSalarie){
        //Requête SQL pour récupérer les contrats d'un salarié
        $sql = "SELECT contrat.idContrat, contrat.dateDebut, contrat.dateFin, contrat.typeContrat, contrat.nbHeures
        FROM contrat, utilisateur
        WHERE contrat.idUser = utilisateur.idUser
        AND utilisateur.typeUser = 'Salarie'
        AND utilisateur.idUser = :idUser";
        
        try{
            //Préparation de la requête/
            $stmt = dbConnex::getInstance()->prepare($sql);

            //Mise en paramètre
            $stmt->bindParam(":idUser", $idSalarie);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }
}
?>