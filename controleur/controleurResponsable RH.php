<?php
if(isset($_SESSION['identification']) && $_SESSION['identification']['typeUser'] === 'Responsable RH'){
    $idRH = $_SESSION['identification']['typeUser'];
}

//Récupération des données
$dataBulletin = BulletinDAO::getBulletin();
$dataContrat = ContratDAO::getContrat();
$dataUser = UtilisateurDAO::getUserDetailsById($idRH);

//Création du tableau concernant les bulletins
$tabSalarie = new Tableau("tabBulletin", $dataBulletin);

$tabSalarie->setTitreTab("Bulletins");

$tabTitreBulletin[] = "Contrat";
$tabTitreBulletin[] = "Mois";
$tabTitreBulletin[] = "Annee";
$tabTitreBulletin[] = "Bulletin en PDF";

$tabSalarie->setTitreCol($tabTitreBulletin);
$tabSalarie->setTaille(3);


//Création du tableau concernant les contrats
$tabContrat = new Tableau("tabContrat", $dataContrat);
$tabContrat->setTitreTab("Contrats");

$tabTitreContrat[] = "N° Contrat";
$tabTitreContrat[] = "Date de Début";
$tabTitreContrat[] = "Date de Fin";
$tabTitreContrat[] = "Type de Contrat";
$tabTitreContrat[] = "Nombre d'heures";

$tabContrat->setTitreCol($tabTitreContrat);
$tabContrat->setTaille(3);

//Création du Tableau concernant les informations personnelles
$tabUser = new Tableau("tabUser", $dataUser);

$tabUser->setTitreTab("Informations Personnelles");

$tabTitreUser[] = "Nom";
$tabTitreUser[] = "Prénom";
$tabTitreUser[] = "Type de Personnel";

$tabUser->setTitreCol($tabTitreUser);
$tabUser->setTaille(3);

include_once 'vue/rh/vueRH.php';
?>