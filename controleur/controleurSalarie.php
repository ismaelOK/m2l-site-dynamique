<?php
if (isset($_SESSION['identification']) && $_SESSION['identification']['typeUser'] === 'Salarie'){
    //Récupération de l'ID du salarié à partir de la session
    $idSalarie = $_SESSION['identification']['idUser'];
}

//Récupération des données
$dataBulletin = BulletinDAO::getBulletinsBySalarieId($idSalarie);
$dataContrat = ContratDAO::getContratsBySalarieId($idSalarie);
$dataUser = UtilisateurDAO::getUserDetailsById($idSalarie);

//Création du tableau concernant les bulletins

$dataBulletin2 = [];
foreach($dataBulletin as $bulletin){
    $bulletin[] = "<a href='bulletinPDF/" . $idSalarie ."/" . $bulletin['bulletinPDF'] . "'>". $bulletin['bulletinPDF']."</a>";
    $dataBulletin2[] = $bulletin;
}

$tabSalarie = new Tableau("tabBulletin", $dataBulletin2);

$tabSalarie->setTitreTab("Bulletins");

$tabTitreBulletin[] = "Contrat";
$tabTitreBulletin[] = "Mois";
$tabTitreBulletin[] = "Annee";
$tabTitreBulletin[] = "Bulletin en PDF";
$tabTitreBulletin[] = "Lien PDF";

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

include_once 'vue/salarie/vueSalarie.php';
?>