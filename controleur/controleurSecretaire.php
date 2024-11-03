<?php

/*Instancier un objet contenant la liste des Ligues et le conserver dans une variable de session */
$_SESSION['listeLigues'] = new Ligues(LigueDAO::lesLigues());


/*Instancier un objet contenant la liste des Clubs et le conserver dans une variable de session*/
$_SESSION['listeClubs'] = new Clubs(ClubDAO::lesClubs()); 


/*Conserver dans une variable de session l'item actif du menu ligue*/
if (isset($_GET['ligue'])) {
    $_SESSION['ligue'] = $_GET['ligue'];
} else {
    if (!isset($_SESSION['ligue'])) {
        $_SESSION['ligue'] = "0"; 
    }
}


/* Conserver dans une variable de session l'item actif du menu club*/
if (isset($_GET['club'])) {
    $_SESSION['club'] = $_GET['club'];
} else {
    if (!isset($_SESSION['club'])) {
        $_SESSION['club'] = "0"; 
    }
}


//Appel DAO de la methode de modification dans la bdd
if(isset($_POST['submitEnregModif'])){

    $ligueModif = new Ligue($_SESSION['ligue'], $_POST['nomLigue'], $_POST['siteLigue'],$_POST['descriptif'],1);

    $reponseSGBD = LigueDAO::updateLigue($ligueModif);
    if($reponseSGBD){
        $_SESSION['listeLigues'] = new Ligues(LigueDAO::lesLigues());
    }
    else{
        echo "Modification non effectuée";
    }
}


//Appel DAO de la methode d'ajout dans la bdd
if (isset($_POST['submitEnregAjouter'])) {
  
    $nouvelleLigue = new Ligue(null, $_POST['nomLigue'], $_POST['siteLigue'], $_POST['descriptif'], 1);

    
    $reponseSGBD = LigueDAO::insertLigue($nouvelleLigue);
    if($reponseSGBD){
        $_SESSION['listeLigues'] = new Ligues(LigueDAO::lesLigues());
        echo "Ligue ajoutée avec succès!";
    } else {
        echo "Erreur lors de l'ajout de la ligue.";
    }
}


//Appel DAO de la méthode de suppression dans la bdd

if(isset($_POST['submitSupprimer'])) {
    
    $idLigue = $_SESSION['ligue'];  
    
    $reponseSGBD = LigueDAO::deleteLigue($idLigue);  
    if($reponseSGBD) {
        $_SESSION['listeLigues'] = new Ligues(LigueDAO::lesLigues());
        $_SESSION['ligue'] = "0";
    } else {
        echo "Suppression non effectuée !!!";
    }
}

/* Créer un menu vertical à partir de la liste des ligues*/
$menuLigue = new Menu("menuLigue");

foreach ($_SESSION['listeLigues']->getLigues() as $uneLigue) {
    $menuLigue->ajouterComposant($menuLigue->creerItemLien($uneLigue->getIdLigue(), $uneLigue->getNomLigue()));
}

$leMenuLigues = $menuLigue->creerMenu($_SESSION['ligue'], 'ligue');


/* Créer un menu vertical à partir de la liste des clubs*/
$menuClub = new Menu("menuClub");

foreach ($_SESSION['listeClubs']->getClubs() as $unClub) {
    $menuClub->ajouterComposant($menuClub->creerItemLien($unClub->getIdClub(), $unClub->getNomClub()));
}

$leMenuClubs = $menuClub->creerMenu($_SESSION['club'], 'club');


/* Récupérer la ligue sélectionnée*/
$_SESSION['ligueActive'] = $_SESSION['listeLigues']->chercheLigue($_SESSION['ligue']);


/* Récupérer le club sélectionné*/
$clubActive = $_SESSION['listeClubs']->chercheClub($_SESSION['club']); // Cherche le club actif


/* Créer le formulaire pour afficher les infos de la ligue et du club*/
$formInfosLigue = new Formulaire('post', 'index.php', 'formInfosLigue', 'formInfosLigue');

if ($_SESSION['ligue'] != "0") {
    if (isset($_POST['submitModif'])) { 
 

    $imagePath = $_SESSION['ligueActive']->getImage();
    
    // Display image path for debugging
    if (!file_exists($imagePath)) {
        echo "Image not found: " . $imagePath . "<br>";
        // Set a default image if the specific image is not found
        $imagePath = 'images/default.jpg'; // Set a default image path here
    }

    // Create an image input for the league logo
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputImage('Logo de ligue', 'imageLigue', $imagePath));


    /*$formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel($_SESSION['ligueActive']->getNomLigue(), 'nomLigueLabel'), 1);
    $formInfosLigue->ajouterComposantTab();*/

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Nom ligue : ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputTexte('nomLigue', 'nomLigue', $_SESSION['ligueActive']->getNomLigue(),0,'',0), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Site ligue: ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputTexte('siteLigue', 'siteLigue', $_SESSION['ligueActive']->getSite(),0,'',0), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Descriptif ligue : ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputTexte('descriptif', 'descriptif', $_SESSION['ligueActive']->getDescriptif(),0,'',0), 1);
    $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitEnregModif', 'submitEnregModif', 'Enregistrer'), 2);
     $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitAnnuler', 'submitAnnuler', 'Annuler'), 2);
     $formInfosLigue->ajouterComposantTab();
    }

    else if(isset($_POST['submitAjouter'])){
       
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Nom ligue : ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputTexte('nomLigue', 'nomLigue','',0,'',0), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Site ligue: ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputTexte('siteLigue', 'siteLigue','',0,'',0), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Descriptif ligue : ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputTexte('descriptif', 'descriptif','',0,'',0), 1);
    $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitEnregAjouter', 'submitEnregAjouter', 'Enregistrer'), 2);
     $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitAnnuler', 'submitAnnuler', 'Annuler'), 3);
     $formInfosLigue->ajouterComposantTab();
    }

    else {
    $imagePath = $_SESSION['ligueActive']->getImage();
 // Display image path for debugging
    if (!file_exists($imagePath)) {
        echo "Image not found: " . $imagePath . "<br>";
        // Set a default image if the specific image is not found
        $imagePath = 'images/default.jpg'; // Set a default image path here
    }

    // Create an image input for the league logo
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerInputImage('Logo de ligue', 'imageLigue', $imagePath));

    // Informations sur la ligue
    /*$formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel($_SESSION['ligueActive']->getNomLigue(), 'nomLigueLabel'), 1);
    $formInfosLigue->ajouterComposantTab();*/

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Nom ligue : ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel($_SESSION['ligueActive']->getNomLigue(), 'infosLiguesLabel'), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Site ligue: ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel($_SESSION['ligueActive']->getSite(), 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Descriptif ligue : ', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel($_SESSION['ligueActive']->getDescriptif(), 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitModif', 'submitModif', 'Modifier'), 2);
     $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitAjouter', 'submitAjouter', 'Ajouter'), 2);
     $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitSupprimer', 'submitSupprimer', 'Supprimer'), 3);
     $formInfosLigue->ajouterComposantTab();
    
    } 
}
else{
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Veuillez sélectionner une ligue', 'infosLigueLabel'), 1);
    $formInfosLigue->ajouterComposantTab();
}



// Informations sur le club
if ($_SESSION['club'] != "0") { 
    if (isset($_POST['submitModif'])) { 
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Nom club : ', 'infosClubLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel($clubActive->getNomClub(), 'infosClubsLabel'), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Adresse club : ', 'infosClubLabel'), 1);
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel($clubActive->getAdresseClub(), 'infosClubLabel'), 1);
    $formInfosLigue->ajouterComposantTab();

    $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitModif', 'submitModif', 'Modifier'), 2);
     $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitAjouter', 'submitAjouter', 'Ajouter'), 2);
     $formInfosLigue->ajouterComposantTab();

     $formInfosLigue->ajouterComposantLigne( $formInfosLigue->creerInputSubmit('submitSupprimer', 'submitSupprimer', 'Supprimer'), 3);
     $formInfosLigue->ajouterComposantTab();
} 
else if(isset($_POST['submitAjouter'])){
}
else {
    $formInfosLigue->ajouterComposantLigne($formInfosLigue->creerLabel('Veuillez sélectionner un club', 'infosClubLabel'), 1);
    $formInfosLigue->ajouterComposantTab();
}
}

// Créer le formulaire
$formInfosLigue->creerFormulaire();

require_once 'vue/ligue/vueLigues.php';
?>
