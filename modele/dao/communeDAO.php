<?php
class CommuneDAO {

// Méthode pour récupérer toutes les communes
public static function lesCommunes() {
    $result = [];
    $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM commune ORDER BY nomCommune");

    try {
        $requetePrepa->execute();
        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($liste)) {
            foreach ($liste as $commune) {
                // On suppose que la classe Departement est déjà définie et gérée
                $unDepartement = DepartementDAO::chercherDepartementParId($commune['idDepartement']);
                $uneCommune = new Commune(null, null, null, null);
                $uneCommune->hydrate($commune);
                $result[] = $uneCommune; // Ajoute la commune à la liste
            }
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des communes : " . $e->getMessage();
    }

    return $result; // Retourne le tableau des communes
}

// Méthode pour insérer une nouvelle commune
public static function insertCommune(Commune $commune) {
    try {
        $requetePrepa = DBConnex::getInstance()->prepare("
            INSERT INTO commune (codePostal, nomCommune, idDepartement) 
            VALUES (:codePostal, :nomCommune, :idDepartement)
        ");

        $requetePrepa->bindValue(':codePostal', $commune->getCodePostal(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':nomCommune', $commune->getNomCommune(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':idDepartement', $commune->getDepartement()->getIdDepartement(), PDO::PARAM_INT); // Assurez-vous que getDepartement() retourne un objet

        return $requetePrepa->execute(); // Retourne true si l'insertion a réussi
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion de la commune : " . $e->getMessage();
        return false; // Retourne false en cas d'erreur
    }
}

// Méthode pour mettre à jour une commune
public static function updateCommune(Commune $commune) {
    try {
        $requetePrepa = DBConnex::getInstance()->prepare("
            UPDATE commune 
            SET codePostal = :codePostal,
                nomCommune = :nomCommune,
                idDepartement = :idDepartement
            WHERE idCommune = :idCommune
        ");

        $requetePrepa->bindValue(':codePostal', $commune->getCodePostal(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':nomCommune', $commune->getNomCommune(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':idDepartement', $commune->getDepartement()->getIdDepartement(), PDO::PARAM_INT);
        $requetePrepa->bindValue(':idCommune', $commune->getIdCommune(), PDO::PARAM_INT);

        return $requetePrepa->execute(); // Retourne true si la mise à jour a réussi
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour de la commune : " . $e->getMessage();
        return false; // Retourne false en cas d'erreur
    }
}

// Méthode pour supprimer une commune
public static function deleteCommune(string $idCommune) {
    try {
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM commune WHERE idCommune = :idCommune");
        $requetePrepa->bindValue(':idCommune', $idCommune, PDO::PARAM_INT);

        return $requetePrepa->execute(); // Retourne true si la suppression a réussi
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de la commune : " . $e->getMessage();
        return false; // Retourne false en cas d'erreur
    }
}

// Méthode pour chercher une commune par ID
public static function chercherCommuneParId(string $idCommune): ?Commune {
    $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM commune WHERE idCommune = :idCommune");
    $requetePrepa->bindValue(':idCommune', $idCommune, PDO::PARAM_INT);

    try {
        $requetePrepa->execute();
        $communeData = $requetePrepa->fetch(PDO::FETCH_ASSOC);

        if ($communeData) {
            // Vérifiez si idDepartement est défini
            if (isset($communeData['idDepartement'])) {
                $departement = DepartementDAO::chercherDepartementParId($communeData['idDepartement']);
            } else {
                $departement = null; // Ou gérez cela selon vos besoins
            }

            return new Commune($communeData['idCommune'], $communeData['codePostal'], $communeData['nomCommune'], $departement);
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la recherche de la commune : " . $e->getMessage();
    }

    return null; // Retourne null si la commune n'est pas trouvée
}
}
?>