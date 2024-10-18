<?php
if(isset($_SESSION['identification']) && $_SESSION['identification']['typeUser'] == 'Benevole'){
    $idBenevole = $_SESSION['identification']['idUser'];
}

//Récupération des données
$dataUser = UtilisateurDAO::getUserDetailsById($idBenevole);

$tabUser = new Tableau("tabUser", $dataUser);

$tabUser->setTitreTab("Informations Personnelles");

$tabTitreUser[] = "Nom";
$tabTitreUser[] = "Prénom";
$tabTitreUser[] = "Type de Personnel";

$tabUser->setTitreCol($tabTitreUser);
$tabUser->setTaille(3);

include_once 'vue/benevole/vueBenevole.php';
?>