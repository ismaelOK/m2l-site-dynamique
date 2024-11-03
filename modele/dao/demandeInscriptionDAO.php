<?php 
class DemandeInscriptionDAO{
    
    public static function demanderInscription($unIdUtilisateur, $unIdFormation){

        
        $requetePrepa = DBConnex::getInstance()->prepare("
            INSERT INTO inscrit_a (idUser, idForma, etat)
            VALUES (:user, :forma, '0')
        ");

        $requetePrepa->bindParam(":user", $unIdUtilisateur);
        $requetePrepa->bindParam(":forma", $unIdFormation);

        
        $requetePrepa->execute();

    }
    
    public static function getAllDemandes() {
        $requetePrepa = DBConnex::getInstance()->prepare("
            SELECT I.codeDemande, I.idUser, I.idForma, I.etat, 
                   U.nom AS nomUtilisateur, 
                   U.prenom AS prenomUtilisateur,
                   U.login AS login,
                   U.mdp AS mdp,
                   U.typeUser AS typeUser,
                   U.idLigue AS idLigue,
                   U.idClub AS idClub,
                   U.idFonct AS idFonct,
                   F.intitule AS intituleFormation,
                   F.descriptif AS descriptifFormation,
                   F.duree AS dureeFormation,
                   F.dateOuvertInscriptions AS dateOuvertureInscri,
                   F.dateClotureInscriptions AS dateClotureInscri,
                   F.effectifActuel AS effectifActuel,
                   F.effectifMax AS effectifMax
            FROM inscrit_a AS I
            JOIN utilisateur AS U ON U.idUser = I.idUser
            JOIN formation AS F ON I.idForma = F.idForma
        ");
    
        $requetePrepa->execute();
    
        $demandes = [];
    
        while ($row = $requetePrepa->fetch(PDO::FETCH_ASSOC)) {
            
            $idUser = isset($row['idUser']) ? $row['idUser'] : null;
            $nomUtilisateur = isset($row['nomUtilisateur']) ? $row['nomUtilisateur'] : '';
            $prenomUtilisateur = isset($row['prenomUtilisateur']) ? $row['prenomUtilisateur'] : '';
            $login = '';
            $mdp = '';
            $typeUser = isset($row['typeUser']) ? $row['typeUser'] : '';
            $idLigue = isset($row['idLigue']) ? $row['idLigue'] : '';
            $idClub = isset($row['idClub']) ? $row['idClub'] : '';
            $idFonct = isset($row['idFonct']) ? $row['idFonct'] : '';
    
            $idForma = isset($row['idForma']) ? $row['idForma'] : null;
            $intituleFormation = isset($row['intituleFormation']) ? $row['intituleFormation'] : '';
            $descriptifFormation = isset($row['descriptifFormation']) ? $row['descriptifFormation'] : '';
            $dureeFormation = isset($row['dureeFormation']) ? $row['dureeFormation'] : '';
            $dateOuvertureInscri = isset($row['dateOuvertureInscri']) ? $row['dateOuvertureInscri'] : '';
            $dateClotureInscri = isset($row['dateClotureInscri']) ? $row['dateClotureInscri'] : '';
            $effectifActuel = isset($row['effectifActuel']) ? $row['effectifActuel'] : 0;
            $effectifMax = isset($row['effectifMax']) ? $row['effectifMax'] : 0;
    
            $etat = isset($row['etat']) ? $row['etat'] : null;
            $codeDemande = isset($row['codeDemande']) ? $row['codeDemande'] : null;
    
            
            $utilisateur = new Utilisateur(
                $idUser,
                $nomUtilisateur,
                $prenomUtilisateur,
                $login,
                $mdp,
                $typeUser,
                $idLigue,
                $idClub,
                $idFonct
            );
    
            
            $formation = new Formation(
                $idForma,
                $intituleFormation,
                $descriptifFormation,
                $dureeFormation,
                $dateOuvertureInscri,
                $dateClotureInscri,
                $effectifActuel,
                $effectifMax
            );
    
            
            $demande = new DemandeInscription(
                $codeDemande,
                $utilisateur,
                $formation,
                $etat
            );
    
            $demandes[] = $demande;
        }
    
        return $demandes;
    }
    


    public static function getDemandesByUserId($idUtilisateur) {
        $requetePrepa = DBConnex::getInstance()->prepare("
            SELECT I.idUser, I.idForma, I.etat, U.prenom, U.nom, U.login, 
            U.mdp, U.typeUser, U.idLigue, U.idClub, U.idFonct, F.intitule, 
            F.descriptif, F.duree, F.dateOuvertInscriptions, F.dateClotureInscriptions, 
            F.effectifActuel, F.effectifMax
            FROM inscrit_a AS I
            JOIN utilisateur AS U ON U.idUser = I.idUser
            JOIN formation AS F ON F.idForma = I.idForma
            WHERE I.idUser = :user
        ");
    
        $requetePrepa->bindParam(":user", $idUtilisateur);
        $requetePrepa->execute();
    
        $demandes = [];
    
        while ($row = $requetePrepa->fetch(PDO::FETCH_ASSOC)) {
            
            $utilisateur = new Utilisateur(
                $row['idUser'],
                $row['nom'],
                $row['prenom'],
                $row['login'],
                $row['mdp'],
                $row['typeUser'],
                $row['idLigue'],
                $row['idClub'],
                $row['idFonct']
            );
    
            
            $formation = new Formation(
                $row['idForma'],
                $row['intitule'],
                $row['descriptif'],
                $row['duree'],
                $row['dateOuvertInscriptions'],
                $row['dateClotureInscriptions'],
                $row['effectifActuel'],
                $row['effectifMax']
            );
    
            
            $demande = new DemandeInscription(
                $row['idUser'], 
                $utilisateur,   
                $formation,     
                $row['etat']    
            );
    
            $demandes[] = $demande;
        }
    
        return $demandes;
    }

    public static function accepterDemande($userId, $formationId) {
        
        $db = DBConnex::getInstance();
        $db->beginTransaction();
        
        try {
            
            $requetePrepa = $db->prepare(
                "UPDATE inscrit_a 
                 SET etat = '2' 
                 WHERE idUser = :user 
                 AND idForma = :formation"
            );
            $requetePrepa->bindParam(":user", $userId);
            $requetePrepa->bindParam(":formation", $formationId);
            $requetePrepa->execute();
    
            
            $requeteUpdateEffectif = $db->prepare(
                "UPDATE formation 
                 SET effectifActuel = effectifActuel + 1 
                 WHERE idForma = :formation"
            );
            $requeteUpdateEffectif->bindParam(":formation", $formationId);
            $requeteUpdateEffectif->execute();
            
            
            $db->commit();
        } catch (Exception $e) {
            
            $db->rollBack();
            throw $e; 
        }
    }
    
    public static function refuserDemande($userId, $formationId) {
        
        $db = DBConnex::getInstance();
        $db->beginTransaction();
        
        try {
            
            $requetePrepa = $db->prepare(
                "UPDATE inscrit_a 
                 SET etat = '1' 
                 WHERE idUser = :user 
                 AND idForma = :formation"
            );
            $requetePrepa->bindParam(":user", $userId);
            $requetePrepa->bindParam(":formation", $formationId);
            $requetePrepa->execute();
    
            
            $requeteUpdateEffectif = $db->prepare(
                "UPDATE formation 
                 SET effectifActuel = effectifActuel - 1 
                 WHERE idForma = :formation"
            );
            $requeteUpdateEffectif->bindParam(":formation", $formationId);
            $requeteUpdateEffectif->execute();
            
            
            $db->commit();
        } catch (Exception $e) {
           
            $db->rollBack();
            throw $e; 
        }
    }
    
}