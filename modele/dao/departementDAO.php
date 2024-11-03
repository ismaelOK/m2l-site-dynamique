<?php

class DepartementDAO {

    // Méthode pour récupérer tous les départements
    public static function lesDepartements(): array {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM departement ORDER BY nomDepartement");

        try {
            $requetePrepa->execute();
            $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);

            foreach ($liste as $departementData) {
                $departement = new Departement($departementData['codeDepartement'], $departementData['nomDepartement']);
                $result[] = $departement; // Ajoute le département à la liste
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des départements : " . $e->getMessage();
        }

        return $result; // Retourne le tableau des départements
    }

    // Méthode pour insérer un nouveau département
    public static function insertDepartement(Departement $departement): bool {
        try {
            $requetePrepa = DBConnex::getInstance()->prepare("
                INSERT INTO departement (codeDepartement, nomDepartement) 
                VALUES (:codeDepartement, :nomDepartement)
            ");

            $requetePrepa->bindValue(':codeDepartement', $departement->getCodeDepartement(), PDO::PARAM_STR);
            $requetePrepa->bindValue(':nomDepartement', $departement->getNomDepartement(), PDO::PARAM_STR);

            return $requetePrepa->execute(); // Retourne true si l'insertion a réussi
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion du département : " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }

    // Méthode pour mettre à jour un département
    public static function updateDepartement(Departement $departement): bool {
        try {
            $requetePrepa = DBConnex::getInstance()->prepare("
                UPDATE departement 
                SET nomDepartement = :nomDepartement
                WHERE codeDepartement = :codeDepartement
            ");

            $requetePrepa->bindValue(':nomDepartement', $departement->getNomDepartement(), PDO::PARAM_STR);
            $requetePrepa->bindValue(':codeDepartement', $departement->getCodeDepartement(), PDO::PARAM_STR);

            return $requetePrepa->execute(); // Retourne true si la mise à jour a réussi
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du département : " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }

    // Méthode pour supprimer un département
    public static function deleteDepartement(string $codeDepartement): bool {
        try {
            $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM departement WHERE codeDepartement = :codeDepartement");
            $requetePrepa->bindValue(':codeDepartement', $codeDepartement, PDO::PARAM_STR);
            return $requetePrepa->execute(); // Retourne true si la suppression a réussi
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression du département : " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }

    // Méthode pour récupérer un département par son code
    public static function chercherDepartementParId(string $idDepartement): ?Departement {
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM departement WHERE idDepartement = :idDepartement");
        $requetePrepa->bindValue(':idDepartement', $idDepartement, PDO::PARAM_INT);
        
        try {
            $requetePrepa->execute();
            $departementData = $requetePrepa->fetch(PDO::FETCH_ASSOC);

            if ($departementData) {
                return new Departement($departementData['codeDepartement'], $departementData['nomDepartement']);
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche du département : " . $e->getMessage();
        }
        
        return null; // Retourne null si aucun département n'est trouvé
    }
}
?>
