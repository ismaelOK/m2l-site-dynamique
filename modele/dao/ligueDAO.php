<?php
class LigueDAO {

// Méthode pour récupérer toutes les ligues
public static function lesLigues() {
    $result = [];
    $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM ligue ORDER BY nomLigue");

    try {
        $requetePrepa->execute();
        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($liste)) {
            foreach ($liste as $ligue) {
                $uneLigue = new Ligue(null, null, null, null);
                $uneLigue->hydrate($ligue);
                $result[] = $uneLigue;
            }
        }
    } catch (PDOException $e) {
        // Log de l'erreur au lieu de l'afficher
        echo "Erreur lors de la récupération des ligues : " . $e->getMessage();
        // Optionnel : retourner un tableau vide ou une exception personnalisée
    }

    return $result;
}

// Méthode pour récupérer une ligue par son ID
public static function chercherLigueParId($idLigue) {
    $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM ligue WHERE idLigue = :idLigue");
    $requetePrepa->bindValue(':idLigue', $idLigue, PDO::PARAM_INT);

    try {
        $requetePrepa->execute();
        $result = $requetePrepa->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $uneLigue = new Ligue(null, null, null, null);
            $uneLigue->hydrate($result);
            return $uneLigue; // Retourne l'objet Ligue
        }
    } catch (PDOException $e) {
        // Log de l'erreur au lieu de l'afficher
        echo "Erreur lors de la récupération de la ligue : " . $e->getMessage();
    }
    return null; // Retourne null si la ligue n'est pas trouvée
}

// Méthode pour mettre à jour une ligue
public static function updateLigue(Ligue $ligue) {
    try {
        // Requête préparée pour la mise à jour
        $requetePrepa = DBConnex::getInstance()->prepare("
            UPDATE ligue 
            SET nomLigue = :nomLigue,
                site = :site,
                descriptif = :descriptif
            WHERE idLigue = :idLigue
        ");

        // Association des paramètres avec les valeurs de l'objet Ligue
        $requetePrepa->bindValue(':nomLigue', $ligue->getNomLigue(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':site', $ligue->getSite(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':descriptif', $ligue->getDescriptif(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':idLigue', $ligue->getIdLigue(), PDO::PARAM_INT);

        // Exécution de la requête
        return $requetePrepa->execute();
    } catch (PDOException $e) {
        // Log de l'erreur au lieu de l'afficher
        echo  $e->getMessage();
        die();
    }
}

// Méthode pour supprimer une ligue
public static function deleteLigue($idLigue) {
    try {
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM ligue WHERE idLigue = :idLigue");
        $requetePrepa->bindValue(':idLigue', $idLigue, PDO::PARAM_INT);
        return $requetePrepa->execute();
    } catch (PDOException $e) {
        // Log de l'erreur au lieu de l'afficher
        echo "Erreur lors de la suppression de la ligue : " . $e->getMessage();
        return false;
    }
}

// Méthode pour insérer une nouvelle ligue
public static function insertLigue(Ligue $ligue) {
    try {
        // Préparation de la requête SQL pour insérer une nouvelle ligue
        $requetePrepa = DBConnex::getInstance()->prepare("
            INSERT INTO ligue (nomLigue, site, descriptif) 
            VALUES (:nomLigue, :site, :descriptif)
        ");

        // Liaison des valeurs de l'objet Ligue à la requête
        $requetePrepa->bindValue(':nomLigue', $ligue->getNomLigue(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':site', $ligue->getSite(), PDO::PARAM_STR);
        $requetePrepa->bindValue(':descriptif', $ligue->getDescriptif(), PDO::PARAM_STR);

        // Exécution de la requête et retour du résultat (true en cas de succès, false en cas d'échec)
        return $requetePrepa->execute();
    } catch (PDOException $e) {
        // Log de l'erreur au lieu de l'afficher
        echo "Erreur lors de l'insertion de la ligue : " . $e->getMessage();
        return false; // Retourne false en cas d'erreur
    }
}
}
?>