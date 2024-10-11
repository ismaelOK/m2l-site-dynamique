<?php
if(isset($_SESSION['identification']) && $_SESSION['identification']['typeUser'] === 'Responsable RH'){
    $idRH = $_SESSION['identification']['idUser'];
}

$formAjouterSalarie = new Formulaire("post", "index.php", "formAjouterSalarie", "formAjouterSalarie");

//Contrôle de l'affichage des formulaire d'ajout, de modif et de supprimer
if(isset($_POST['ajouterSalarie'])){

    $formAjouterSalarie->ajouterComposantLigne($formAjouterSalarie->creerLabel("idUser : ", "labelIdUser"), 1);
    $formAjouterSalarie->ajouterComposantLigne($formAjouterSalarie->creerInputTexte("inputIdUser", "inputIdUser", "", 1, '', 0), 1);
    $formAjouterSalarie->ajouterComposantTab();

    $formAjouterSalarie->ajouterComposantLigne($formAjouterSalarie->creerLabel(""));

    $formAjouterSalarie->creerFormulaire();
}


//Récupération des données
$dataBulletin = BulletinDAO::getBulletin();
$dataContrat = ContratDAO::getContrat();
$dataSalarie = SalarieDAO::getAllSalarie();
$dataUser = UtilisateurDAO::getUserDetailsById($idRH);

//Création du tableau concernant les bulletins
$tabBulletin = new Tableau("tabBulletin", $dataBulletin);

$tabBulletin->setTitreTab("Bulletins");

$tabTitreBulletin[] = "Contrat";
$tabTitreBulletin[] = "Mois";
$tabTitreBulletin[] = "Annee";
$tabTitreBulletin[] = "Bulletin en PDF";
$tabTitreBulletin[] = "N° Contrat";

$tabBulletin->setTitreCol($tabTitreBulletin);
$tabBulletin->setTaille(3);


//Création du tableau concernant les contrats
$tabContrat = new Tableau("tabContrat", $dataContrat);
$tabContrat->setTitreTab("Contrats");

$tabTitreContrat[] = "N° Contrat";
$tabTitreContrat[] = "Date de Début";
$tabTitreContrat[] = "Date de Fin";
$tabTitreContrat[] = "Type de Contrat";
$tabTitreContrat[] = "Nombre d'heures";
$tabTitreContrat[] = "ID de l'utilisateur";

$tabContrat->setTitreCol($tabTitreContrat);
$tabContrat->setTaille(3);

//Création de la table de salarié
$tabSalarie = new Tableau("tabSalarie", $dataSalarie);
$tabSalarie->setTitreTab("Salariés");

$tabTitreSalarie[] = "ID";
$tabTitreSalarie[] = "Nom";
$tabTitreSalarie[] = "Prénom";

$tabSalarie->setTitreCol($tabTitreSalarie);
$tabSalarie->setTaille(3);

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