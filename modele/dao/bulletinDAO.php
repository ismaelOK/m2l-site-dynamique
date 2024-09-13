<?php
require_once 'dbConnex.php';
require_once 'param.php';

public function addBulletin($idBulletin, $mois, $annee, $bulletinPDF, $idContrat) : void{
    $db = DBConnex::getInstance();

    try{
        //Requête SQL : A NE PAS TOUCHER!
        $sql = "INSERT INTO bullein (idBulletin, mois, annee, bulletinPDF, idContrat) VALUES (:idbulletin, :mois, :annee, :bulletinPDF, :idContrat)";

        //Préparation de la requête;
        $db->prepare($sql);

        //mise en liens des paramètres.
        $stmt->bindParam(":idBulletin", $idBulletin);
        $stmt->bindParam("mois", $mois);
        $stmt->binParam(":annee", $annee);
        $stmt->binParam(":bulleinPDF", $bulletinPDF);
        $stmt->binParam(":idContrat",$idContrat);

        $stmt->execute();
    }
    catch(PDOException $e){
        die($e->getMessage());
    }
}

public function modifyBulletin($idBulletin, $mois, $annee, $bulletinPDF, $idContrat): void{
    $db = DBConnex::getInstance();
    try{
        $db->prepare("UPDATE bulletin SET mois = :mois, annee = :annee, bulletinPDF = :bulletinPDF, idContrat = :idContrat WHERE idBulletin = :idBulletin");

        $db->bindParam(":mois", $mois);
    }
}
?>