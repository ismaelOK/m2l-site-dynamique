<?php 
class DemandeInscriptionDAO{
    
    public static demandeInscription($unIdUtilisateur, $unIdFormation){

        
        $requetePrepa = DBConnex::getInstance()->prepare("
            INSERT INTO inscrit_a ('idUser', 'idForma', 'etat')
            VALUES (':user', ':forma', '0')
        ");

        $requetePrepa->bindParam(":user", $unIdUtilisateur);
        $requetePrepa->bindParam(":forma", $unIdFormation);

        
        $requetePrepa->execute();

    }
    
    public static getAllDemandes(){
        
        $requetePrepa = DBConnex::getInstance()->prepare("
            SELECT U.prenom, U.nom, F.intitule
            FROM inscrit_a AS I, utilisateur AS U, formation AS F
            WHERE U.idUser = I.idUser
            AND I.idUser
            
        ");

        

        
        $requetePrepa->execute();

        $demandes = [];



        while ($row = $requetePrepa->fetch(PDO::FETCH_ASSOC)) {
        
            $demandes[] = new DemandeInscription($row['idUser'],$row['idForma'],$row['etat']);
        }

        return $demandes;
    }

    



    
}