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

    public static function addContrat($idContrat, $dateDebut, $dateFin, $typeContrat, $nbHeures, $idUser): void{
        $db = DBConnex::getInstance();

        try{
            $sql = "INSERT INTO contrat(idContrat, dateDebut, dateFin, typeContrat, nbHeures, idUser) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(1, $idContrat);
            $stmt->bindParam(2, $dateDebut);
            $stmt->bindParam(3, $dateFin);
            $stmt->bindParam(4, $typeContrat);
            $stmt->bindParam(5, $nbHeures);
            $stmt->bindParam(6, $idUser);

            $stmt->execute();
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function modifyBulletin($idContrat, $dateDebut, $dateFin, $typeContrat, $nbHeures, $idUser): void{
        $db = DBConnex::getInstance();

        try{
            $sql = "UPDATE contrat
            SET dateDebut = :dateDebut,
            dateFin = :dateFin,
            typeContrat = :typeContrat,
            nbHeures = :nbHeures,
            idUser = :idUser
            WHERE idContrat = :idContrat";

            $db->beginTransaction();
            
            $stmt = $db->prepare($sql);

            $stmt->bindParam(":idContrat", $idContrat);
            $stmt->bindParam(":dateDebut", $dateDebut);
            $stmt->bindParam(":dateFin", $dateFin);
            $stmt->bindParam(":typeContrat", $typeContrat);
            $stmt->bindParam(":nbHeures", $nbHeures);
            $stmt->bindparam(":idUser", $idUser);

            $stmt->execute();

            $db->commit();
        }
        catch(PDOException $e){
            $db->rollBack();
            die($e->getMessage());
        }
    }

    public static function deleteContrat($idContrat): void{
        $db = DBConnex::getInstance();

        try{
            $db->beginTransaction();

            $sql = "DELETE FROM contrat WHERE idContrat = :idContrat";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(":idContrat", $idContrat);

            $stmt->execute();

            $db->commit();
        }
        catch(PDOException $e){
            $db->rollBack();
            die($e->getMessage());
        }
    }

    public static function getContrat(): array{
        $db = DBConnex::getInstance();
        try{
            $sql = "SELECT * FROM contrat";

            $stmt = $db->prepare($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }
}
?>