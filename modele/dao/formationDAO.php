<?php

class FormationDAO{

    public static function getAllFormations(){
        

        $requetePrepa = DBConnex::getInstance()->prepare("
            SELECT idForma, intitule, descriptif, duree , dateOuvertInscriptions,
                            dateClotureInscriptions, effectifMax, effectifActuel
            FROM formation
            
        ");

        

        // Exécuter la requête
        $requetePrepa->execute();

        $formations = [];



        while ($row = $requetePrepa->fetch(PDO::FETCH_ASSOC)) {
        
            $formations[] = new Formation($row['idForma'],$row['intitule'],$row['descriptif'],$row['duree'],
            $row['dateOuvertInscriptions'], $row['dateClotureInscriptions'], $row['effectifMax'], 
            $row['effectifActuel']);
        }

        return $formations;
    }

    public static function getFormationsByUserId($unId){

        $requetePrepa = DBConnex::getInstance()->prepare("
            SELECT idForma, intitule, descriptif, duree , dateOuvertInscriptions,
                            dateClotureInscriptions, effectifMax, effectifActuel
            FROM formation, utilisateur AS U, inscrit_a AS I
            WHERE I.idUser = U.idUser
            AND idUser = :id
            
        ");

        $requetePrepa->bindParam(":id", $unId);

        // Exécuter la requête
        $requetePrepa->execute();

        $formations = [];



        while ($row = $requetePrepa->fetch(PDO::FETCH_ASSOC)) {
        
            $formations[] = new Formation($row['idForma'],$row['intitule'],$row['descriptif'],$row['duree'],
            $row['dateOuvertInscriptions'], $row['dateClotureInscriptions'], $row['effectifMax'], 
            $row['effectifActuel']);
        }

        return $formations;


    }


    public static function supprimerFormation($unIdFormation){

        $requetePrepa = DBConnex::getInstance()->prepare("
        DELETE FROM inscrit_a WHERE idForma = :id
        
    ");

    $requetePrepa->bindParam(":id", $unIdFormation);
    $requetePrepa->execute();

        $requetePrepa = DBConnex::getInstance()->prepare("
        DELETE FROM formation WHERE idForma = :id;
        
    ");

    $requetePrepa->bindParam(":id", $unIdFormation);
    $requetePrepa->execute();

    }

    public static function creerFormation(
         $intitule,
         $descriptif,
         $dureeMinutes,
         $dateOuvertureInscri,
         $dateClotureInscri,
         $effectifMax
    ) {
        
        $requetePrepa = DBConnex::getInstance()->prepare("
            INSERT INTO formation (idForma, intitule, descriptif, duree, dateOuvertInscriptions, dateClotureInscriptions, effectifMax)
            VALUES (NULL, :intitule, :descriptif, :duree, :dateOuvertInscriptions, :dateClotureInscriptions, :effectifMax)
        ");
    
        
        $requetePrepa->bindParam(":intitule", $intitule);
        $requetePrepa->bindParam(":descriptif", $descriptif);
        $requetePrepa->bindParam(":duree", $dureeMinutes);
        $requetePrepa->bindParam(":dateOuvertInscriptions", $dateOuvertureInscri);
        $requetePrepa->bindParam(":dateClotureInscriptions", $dateClotureInscri);
        $requetePrepa->bindParam(":effectifMax", $effectifMax);
    
       
        $requetePrepa->execute();
    }

    public static function getFormationById($idFormation) {
 
        $requetePrepa = DBConnex::getInstance()->prepare("
            SELECT * FROM formation WHERE idForma = :id
        ");
    
      
        $requetePrepa->bindParam(':id', $idFormation);
    

        $requetePrepa->execute();
    
        $result = $requetePrepa->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return new Formation(
                $result['idForma'],
                $result['intitule'],
                $result['descriptif'],
                $result['duree'],
                $result['dateOuvertInscriptions'],
                $result['dateClotureInscriptions'],
                $result['effectifMax'],
                $result['effectifActuel'] 
            );
        }
    
        return null;
    }

    public static function modifierFormation($idFormation, $intitule, $descriptif, $duree, $ouverture, $cloture, $effectifMax) {
        
        $requetePrepa = DBConnex::getInstance()->prepare("
        UPDATE formation SET 
        intitule = :intitule, 
        descriptif = :descriptif, 
        duree = :duree, 
        dateOuvertInscriptions = :ouverture, 
        dateClotureInscriptions = :cloture, 
        effectifMax = :effectifMax 
        WHERE idForma = :idFormation
        ");
    
        $requetePrepa->bindParam(':intitule', $intitule);
        $requetePrepa->bindParam(':descriptif', $descriptif);
        $requetePrepa->bindParam(':duree', $duree);
        $requetePrepa->bindParam(':ouverture', $ouverture);
        $requetePrepa->bindParam(':cloture', $cloture);
        $requetePrepa->bindParam(':effectifMax', $effectifMax);
        $requetePrepa->bindParam(':idFormation', $idFormation);
    
        if ($requetePrepa->execute()) {
            return true; 
        } else {
            return false; 
        }
    }

    public static function isFormationAvailable($formation) {
        
        $isFormationFull = $formation->getEffectifActuel() == $formation->getEffectifMax();
        if ($isFormationFull) {
            return false; 
        }
        
        
        $today = date("Y-m-d");
        if ($today > $formation->getDateClotureInscri()) {
            return false; 
        }
        
        
        return true;
    }

}

    
