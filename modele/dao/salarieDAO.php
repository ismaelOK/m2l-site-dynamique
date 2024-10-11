<?php
class SalarieDAO{
    public static function getAllSalarie() : array{
        $db = DBConnex::getInstance();

        try{
            $sql = "SELECT idUser, nom, prenom FROM utilisateur WHERE typeUser = 'Salarie'";

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function createSalarie(string $id, string $nom, string $prenom, string $login, string $mdp, string $typeUser = "Salarie", string $idLigue = null, string $idClub = null, string $idFonct = "1"): bool{
        $db = DBConnex::getInstance();
        $db->exec('SET AUTOCOMMIT = 0');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $db->beginTransaction();

            $sql = "INSERT INTO utilisateur
            (`idUser`, `nom`, `prenom`, `login`, `mdp`, `typeUser`, `idLigue`, `idClub`, `idFonct`)
            VALUES
            (?, ?, ?, ?, md5(?), ?, ?, ?, ?)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $nom);
            $stmt->bindParam(3, $prenom);
            $stmt->bindParam(4, $login);
            $stmt->bindParam(5, $mdp);
            $stmt->bindParam(6, $typeUser);
            $stmt->bindParam(7, $idLigue);
            $stmt->bindParam(8, $idClub);
            $stmt->bindParam(9, $idFonct);

            $stmt->execute();

            return $db->commit();

        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function modifySalarie(string $id, string $nom, string $prenom, string $login, string $mdp, string $idLigue, string $idClub, string $idFonct): bool{
        $db = DBConnex::getInstance();
        $db->exec('SET AUTOCOMMIT = 0');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $db->beginTransaction();

            $sql = "UPDATE utilisateur
            SET nom = :nom,
            login = :login,
            mdp = md5(:mdp),
            idLigue = :idLigue,
            idClub = :idClub,
            idFonct = :idFonct
            WHERE idUser = :idUser AND typeUser = 'Salarie'";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(":idUser", $id);
            $stmt->bindParam(":nom", $nom);
            $stmt->bindParam(":prenom", $prenom);
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":mdp", $mdp);
            $stmt->bindParam(":idLigue", $idLigue);
            $stmt->bindParam(":idClub", $idClub);
            $stmt->bindParam(":idFonct", $idFonct);

            $stmt->execute();

            return $db->commit();
        }
        catch(PDOException $e){
            $db->rollBack();
            die($e->getMessage());
        }
    }

    public static function deleteSalarie(string $id): bool{
        $db = DBConnex::getInstance();
        $db->exec('SET AUTOCOMMIT = 0');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $db->beginTransaction();

            $sql = "DELETE FROM utilisateur
            WHERE idUser = :idUser
            AND typeUser = 'Salarie'";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idUser", $id);
            $stmt->execute();

            return $db->commit();
        }
        catch(PDOException $e){
            $db->rollBack();
            die($e->getMessage());
        }
    }
}