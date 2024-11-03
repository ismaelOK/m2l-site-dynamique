<?php

class ClubDAO {

    // Méthode pour récupérer tous les clubs
    public static function lesClubs() {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM club ORDER BY nomClub");

        try {
            $requetePrepa->execute();
            $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);

            foreach ($liste as $clubData) {
                // Récupération de la ligue et de la commune associées
                $uneLigue = LigueDAO::chercherLigueParId($clubData['idLigue']);
                $uneCommune = CommuneDAO::chercherCommuneParId($clubData['idCommune']);
                
                // Création d'un nouvel objet Club
                $unClub = new Club(
                    $clubData['idClub'], 
                    $clubData['nomClub'], 
                    $clubData['adresseClub'], 
                    $uneLigue, 
                    $uneCommune
                );

                $result[] = $unClub; // Ajoute le club à la liste
            }
        } catch (PDOException $e) {
            // Gestion d'erreur améliorée
            echo "Erreur lors de la récupération des clubs : " . $e->getMessage();
        }

        return $result; // Retourne le tableau des clubs
    }

    // Méthode pour insérer un nouveau club
    public static function insertClub(Club $club): bool {
        try {
            $requetePrepa = DBConnex::getInstance()->prepare("
                INSERT INTO club (nomClub, adresseClub, idLigue, idCommune) 
                VALUES (:nomClub, :adresseClub, :idLigue, :idCommune)
            ");

            // Liaison des valeurs de l'objet Club à la requête
            $requetePrepa->bindValue(':nomClub', $club->getNomClub(), PDO::PARAM_STR);
            $requetePrepa->bindValue(':adresseClub', $club->getAdresseClub(), PDO::PARAM_STR);
            $requetePrepa->bindValue(':idLigue', $club->getIdLigue(), PDO::PARAM_INT);
            $requetePrepa->bindValue(':idCommune', $club->getIdCommune(), PDO::PARAM_INT);

            return $requetePrepa->execute(); // Retourne true si l'insertion a réussi
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion du club : " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }

    // Méthode pour mettre à jour un club
    public static function updateClub(Club $club): bool {
        try {
            $requetePrepa = DBConnex::getInstance()->prepare("
                UPDATE club 
                SET nomClub = :nomClub,
                    adresseClub = :adresseClub,
                    idLigue = :idLigue,
                    idCommune = :idCommune
                WHERE idClub = :idClub
            ");

            // Liaison des valeurs de l'objet Club à la requête
            $requetePrepa->bindValue(':nomClub', $club->getNomClub(), PDO::PARAM_STR);
            $requetePrepa->bindValue(':adresseClub', $club->getAdresseClub(), PDO::PARAM_STR);
            $requetePrepa->bindValue(':idLigue', $club->getIdLigue(), PDO::PARAM_INT);
            $requetePrepa->bindValue(':idCommune', $club->getIdCommune(), PDO::PARAM_INT);
            $requetePrepa->bindValue(':idClub', $club->getIdClub(), PDO::PARAM_INT);

            return $requetePrepa->execute(); // Retourne true si la mise à jour a réussi
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du club : " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }

    // Méthode pour supprimer un club
    public static function deleteClub(int $idClub): bool {
        try {
            $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM club WHERE idClub = :idClub");
            $requetePrepa->bindValue(':idClub', $idClub, PDO::PARAM_INT);

            return $requetePrepa->execute(); // Retourne true si la suppression a réussi
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression du club : " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }
}
?>
