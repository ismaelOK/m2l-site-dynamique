<?php
if(isset($_SESSION['identification']) && $_SESSION['identification']['typeUser'] === 'Responsable RH'){
    $idRH = $_SESSION['identification']['idUser'];
}

$formModifierSalarie = new Formulaire("post", "index.php", "formModifierSalarie", "formModifierSalarie");

//Contrôle de l'affichage des formulaire d'ajout, de modif et de supprimer
if(isset($_POST['enregAjouter'])){
    $SGBD = SalarieDAO::createSalarie($_POST['idUser'], $_POST['nom'], $_POST['prenom'], $_POST['login'], $_POST['mdp']);
    if($SGBD){
        echo "Création Réussite";
    }
}
elseif(isset($_POST['enregModifier'])){
    $SGBD = SalarieDAO::modifySalarie($_POST['idUser'], $_POST['nom'], $_POST['prenom'], $_POST['login'], $_POST['mdp'], $_POST['idLigue'], $_POST['idClub'], $_POST['idFonct']);
    if($SGBD){
        echo "Modification Réussi";
    }
}
elseif(isset($_POST['supprimerSalarie'])){
    $SGBD = SalarieDAO::deleteSalarie($_POST['idSalarie']);
    if($SGBD){
        echo "Suppression Réussi";
    }
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
$tabTitreContrat[] = "Actions";

$tabContrat->setTitreCol($tabTitreContrat);
$tabContrat->setTaille(3);

$tableauContrat = [];
foreach($dataContrat as $contrat){
    $idContrat = $contrat->getIdContrat();
    $dateDebut = $contrat->getDateDebut();
    $dateFin = $contrat->getDateFin();
    $typeContrat = $contrat->getTypeContrat();
    $nbHeures = $contrat->getNbHeures();
    $idUser = $contrat->getIdUser();

    $actions = "
        <form method='post' action='index.php'>
            <input type='hidden' name='idSalarie' value='$idSalarie'/>
            <input type='submit' name='modifierSalarie' value='Modifier'/>
            <input type='submit' name='supprimerSalarie' value='Supprimer'/>
        </form>
    ";

    $tableauContrat[] = [
        "N° de contrat" => $idContrat,
        "Date de Début" => $dateDebut,
        "Date de Fin" => $dateFin,
        "Type de Contrat" => $typeContrat,
        "Nombre d'heures" => $nbHeures,
        "ID de l'utilisateur" => $idUser,
        "Actions" => $actions
    ];
}
$tabContrat->setData($tableauContrat);
//Création de la table de salarié
$tabSalarie = new Tableau("tabSalarie", $dataSalarie);
$tabSalarie->setTitreTab("Salariés");

$tabTitreSalarie[] = "ID";
$tabTitreSalarie[] = "Nom";
$tabTitreSalarie[] = "Prénom";
$tabTitreSalarie[] = "Actions";

$tabSalarie->setTitreCol($tabTitreSalarie);
$tabSalarie->setTaille(3);

$tableauSalarie = [];

foreach ($dataSalarie as $salarie) {
    $idSalarie = $salarie->getIdUser();
    $nomSalarie = $salarie->getNom();
    $prenomSalarie = $salarie->getPrenom();

    // Génération des boutons "Modifier" et "Supprimer"
    $actions = "
        <form method='post' action='index.php'>
            <input type='hidden' name='idSalarie' value='$idSalarie'/>
            <input type='submit' name='modifierSalarie' value='Modifier'/>
            <input type='submit' name='supprimerSalarie' value='Supprimer'/>
        </form>
    ";

    // Ajouter les informations au tableau pour l'affichage
    $tableauSalarie[] = [
        'ID' => $idSalarie,
        'Nom' => $nomSalarie,
        'Prenom' => $prenomSalarie,
        'Actions' => $actions
    ];
}
$tabSalarie->setData($tableauSalarie);

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