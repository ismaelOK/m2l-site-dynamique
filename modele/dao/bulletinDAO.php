<?php

class BulletinDAO{
    //AJOUT DU BULLETIN
    public static function addBulletin($idBulletin, $mois, $annee, $bulletinPDF, $idContrat) : void{
        //Instanciation de la connexion
        $db = DBConnex::getInstance();

        try{
            //Requête SQL : A NE PAS TOUCHER!
            $sql = "INSERT INTO bullein (idBulletin, mois, annee, bulletinPDF, idContrat) VALUES (:idbulletin, :mois, :annee, :bulletinPDF, :idContrat)";

            //Préparation de la requête;
            $stmt = $db->prepare($sql);

            //mise en liens des paramètres.
            $stmt->bindParam(":idBulletin", $idBulletin);
            $stmt->bindParam("mois", $mois);
            $stmt->bindParam(":annee", $annee);
            $stmt->bindParam(":bulleinPDF", $bulletinPDF);
            $stmt->bindParam(":idContrat",$idContrat);

            $stmt->execute();
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //MODIFICATION DU BULLETIN
    public static function modifyBulletin($idBulletin, $mois, $annee, $bulletinPDF): void{
        //Instanciation de la connexion
        $db = DBConnex::getInstance();

        try{
            $db->beginTransaction();
            //Préparation de la requête SQL
            $stmt = $db->prepare("UPDATE bulletin SET mois = :mois, annee = :annee, bulletinPDF = :bulletinPDF WHERE idBulletin = :idBulletin");

            $stmt->bindParam(":mois", $mois);
            $stmt->bindParam(":annee", $annee);
            $stmt->bindparam(":bulletinPDF", $bulletinPDF);
            $stmt->bindParam(":idBulletin", $idBulletin);

            $stmt->execute();

            //Fin de la préparation
            $db->commit();
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //SUPPRESSION DU BULLETIN
    public static function deleteBulletin($idBulletin) : void{
        //Instanciation de la connexion
        $db = DBConnex::getInstance();

        try{
            $db->beginTransaction();
            //Requête SQL : AN NE PAS TOUCHER
            $sql = "DELETE FROM bulletin WHERE idBulletin = :idBulletin";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(":idBulletin", $idBulletin);

            $stmt->execute();

            $db->commit();
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //AFFICHAGE DES BULLETINS
    public static function getBulletin() : array{
        //Instanciation de la connexion
        $db = DBConnex::getInstance();

        try{
            $sql = "SELECT * FROM bulletin";

            $stmt = $db->prepare($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getBulletinsBySalarieId($idSalarie){
        $sql = "SELECT bulletin.idContrat, bulletin.mois, bulletin.annee, bulletin.bulletinPDF
        FROM bulletin, contrat
        WHERE bulletin.idContrat = contrat.idContrat
        AND contrat.idUser = :idUser
        ORDER BY contrat.idContrat, bulletin.annee, bulletin.mois";

        try{
            //Préparation de la requête
            $stmt = DBConnex::getInstance()->prepare($sql);

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
