<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['btnCreationFormation'])) {

        $errors = [];

        $duree = trim($_POST['duree']);
        if (!is_numeric($duree) || intval($duree) <= 0) {
            $errors[] = 'La durée doit être un nombre positif.';
        }

        $ouverture = $_POST['ouverture'];
        if (empty($ouverture)) {
            $errors[] = 'La date d\'ouverture est requise.';
        }

        $cloture = $_POST['cloture'];
        if (empty($cloture)) {
            $errors[] = 'La date de clôture est requise.';
        }

        if ($ouverture > $cloture){
            $errors[] = 'La date de clôture doit être après la date d\'ouverture.';
        }

        $effectifMax = trim($_POST['effectifMax']);
        if (empty($effectifMax) || !is_numeric($effectifMax) || intval($effectifMax) <= 0) {
            $errors[] = 'Le nombre de places disponibles doit être un nombre positif.';
        }

        //S'il n'y a pas d'erreurs, crée la formation
        if (empty($errors)) {
            FormationDAO::creerFormation($_POST['intitule'], $_POST['descriptif'], $_POST['duree'], $_POST['ouverture'], $_POST['cloture'],
            $_POST['effectifMax']);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit();
        }
    }

    
    foreach ($_POST as $key => $value) {

        if (strpos($key, 'btnAnnulerModificationFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
            unset($_SESSION['editFormationId']);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit(); 
        }

        if (strpos($key, 'btnInscriptionFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
            FormationDAO::demandeInscription($_SESSION['identification']['idUser'], $idFormation);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit();
        }

        if (strpos($key, 'btnModificationFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
            $_SESSION['editFormationId'] = $idFormation; 
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit(); 
        }

        if (strpos($key, 'btnSuppressionFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
            FormationDAO::supprimerFormation($idFormation);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit();
        }

        if (strpos($key, 'btnConfirmationFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
        
            // Validate the updated inputs
            $errors = [];
            $duree = trim($_POST['duree']);
            if (!is_numeric($duree) || intval($duree) <= 0) {
                $errors[] = 'La durée doit être un nombre positif.';
            }

            /*if ($_SESSION['effectifActuelFormation'] > $_POST['effectifMax']) {
                $errors[] = 'L\'effectif actuel ne peut pas dépasser l\'effectif maximale';
            }*/




        
            
        
            if (empty($errors)) {
                
                FormationDAO::modifierFormation(
                    $idFormation,
                    $_POST['intitule'],
                    $_POST['descriptif'],
                    $_POST['duree'],
                    $_POST['ouverture'],
                    $_POST['cloture'],
                    $_POST['effectifMax']
                );
                header("Location: http://localhost/m2l/index.php?m2lMP=formations&success=1");
                exit();
            } else {
                // Handle errors (e.g., show them on the form)
            }
        }
    }
}





$editMode = false;
$idFormation = null;

if (isset($_SESSION['editFormationId'])) {
    $idFormationAModifier = $_SESSION['editFormationId'];
    $editMode = true;
}



$formations = FormationDAO::getAllFormations();
$formulaires = [];

$isResponsableFormation = FALSE;
if ($_SESSION['identification']['typeUser'] === "Responsable de formation")
{

    $isResponsableFormation = TRUE;
}

/**********************
 *Cette boucle affichera:
 Toutes les formations si nous sommes responsable ET nous ne sommes pas en "edit mode"
 Uniquement la formation à modifier choisie par le responsable si il est en edit mode
 Uniquement les formations disponibles pour s'inscrire si on est un utilisateur sans privilèges

 ------

 Les variables ($isResponsableFormation, $editMode, $isFull, $isClosed ) 
 sont utilisées pour identifier la façon d'afficher les formations.

 Edit mode: Activé quand le responsable appuie sur le boutton modification d'une formation
 celle ci rechargera la page en affichant uniquement la formation choisie sous un format modifiable.
Le responsable pourra sortir de l'edit mode en rectifiant la modification ou en l'acceptant.


 * 
 */

foreach ($formations as $formation) {

    $form = new Formulaire('POST', '', 'formation' , 'formation');
    $idFormation = $formation->getIdForma();

    if ($editMode && $formation->getIdForma() != $idFormationAModifier) {
        continue; 
    }
    elseif($editMode && $formation->getIdForma() == $idFormationAModifier){
    $form->ajouterComposantLigne($form->creerInputTexte('intitule', 'intitule', $formation->getIntitule(), 0, '', ''));
    $form->ajouterComposantTab();
    
    $form->ajouterComposantLigne($form->creerLabel('Descriptif: '));
    $form->ajouterComposantLigne($form->creerInputTexte('descriptif', 'descriptif', $formation->getDescriptif(), 0, '', ''));
    $form->ajouterComposantTab();
    
    $form->ajouterComposantLigne($form->creerLabel('Durée: '));
    $form->ajouterComposantLigne($form->creerInputTexte('duree', 'duree', $formation->getDureeMinutes(), 0, '', ''));

    $form->ajouterComposantTab();

    $form->ajouterComposantLigne($form->creerLabel('Ouverture: '));
    $form->ajouterComposantLigne($form->creerInputTexte('ouverture', 'ouverture', $formation->getDateOuvertureInscri(), 0, '', ''));
    $form->ajouterComposantLigne($form->creerLabel(' '));
    

    $form->ajouterComposantLigne($form->creerLabel(' Clôture: '));
    $form->ajouterComposantLigne($form->creerInputTexte('cloture', 'cloture', $formation->getDateClotureInscri(), 0, '', ''));
    $form->ajouterComposantLigne($form->creerLabel(' '));
    $form->ajouterComposantTab();

    $form->ajouterComposantLigne($form->creerLabel($formation->getEffectifActuel()));

    $_SESSION['effectifActuelFormation'] = $formation->getEffectifActuel();

    $form->ajouterComposantLigne($form->creerLabel(' / '));
    $form->ajouterComposantLigne($form->creerInputTexte('effectifMax', 'effectifMax', $formation->getEffectifMax(), 0, 'Max Inscriptions', ''));
    $form->ajouterComposantLigne($form->creerLabel(' inscriptions'));
    $form->ajouterComposantTab();
    

    $form->ajouterComposantLigne($form->creerInputSubmit('btnConfirmationFormation_' . $idFormation, 'btnConfirmationFormation', 'Confirmer'));
    $form->ajouterComposantLigne($form->creerInputSubmit('btnAnnulerModificationFormation_' . $idFormation, 'btnAnnulerModificationFormation_', 'Annuler'));
    $form->ajouterComposantTab();
    }
    elseif(!$editMode && $isResponsableFormation){
        $form->ajouterComposantLigne($form->creerLabelClasse($formation->getIntitule(), "intitule"));
        $form->ajouterComposantTab();
        
        $form->ajouterComposantLigne($form->creerLabel('Descriptif: '));
        $form->ajouterComposantLigne($form->creerLabel($formation->getDescriptif()));
        $form->ajouterComposantTab();
        
        $form->ajouterComposantLigne($form->creerLabel('Durée: '));
        $form->ajouterComposantLigne($form->creerLabel(round($formation->getDureeMinutes() / 60, 1) . ' heures'));
        $form->ajouterComposantTab();
    
        $form->ajouterComposantLigne($form->creerLabel('Ouverture: '));
        $form->ajouterComposantLigne($form->creerLabel($formation->getDateOuvertureInscri()));
        $form->ajouterComposantLigne($form->creerLabel(' '));
        
    
        $form->ajouterComposantLigne($form->creerLabel(' Clôture: '));
        $form->ajouterComposantLigne($form->creerLabel($formation->getDateClotureInscri()));
        $form->ajouterComposantLigne($form->creerLabel(' '));
        $form->ajouterComposantTab();
    
        
        $form->ajouterComposantLigne($form->creerLabel($formation->getEffectifMax()));

        $form->ajouterComposantLigne($form->creerLabel('/'));
        $form->ajouterComposantLigne($form->creerLabel($formation->getEffectifActuel()));
        $form->ajouterComposantLigne($form->creerLabel(' inscriptions'));
    
        
        $form->ajouterComposantTab();
        $form->ajouterComposantLigne($form->creerInputSubmit('btnModificationFormation_' . $idFormation, 'btnModificationFormation', 'Modifier'));
        $form->ajouterComposantLigne($form->creerInputSubmit('btnSuppressionFormation_' . $idFormation, 'btnSuppressionFormation', 'Supprimer'));
            
        $form->ajouterComposantTab();

    }
    elseif($isResponsableFormation === FALSE){
        $isFull;
        if($formation->getEffectifActuel() == $formation->getEffectifMax()){
            $isFull = TRUE;
        }
        else{

            $isFull = FALSE;
        }

        $isClosed;
        $today = date("Y-m-d");
        if($today > $formation->getDateClotureInscri()){
            $isClosed = TRUE;
        }
        else{
            $isClosed = FALSE;
        }



        if(($isFull || $isClosed) && $isResponsableFormation == FALSE){
            continue;

            /*N'affiche que les formations disponibles (places disponibles + ouverte)
            pour tout utilisateur sauf le Responsable de formation
            */
        }
        $form->ajouterComposantLigne($form->creerLabelClasse($formation->getIntitule(), "intitule"));
        $form->ajouterComposantTab();
        
        $form->ajouterComposantLigne($form->creerLabel('Descriptif: '));
        $form->ajouterComposantLigne($form->creerLabel($formation->getDescriptif()));
        $form->ajouterComposantTab();
        
        $form->ajouterComposantLigne($form->creerLabel('Durée: '));
        $form->ajouterComposantLigne($form->creerLabel(round($formation->getDureeMinutes() / 60, 1) . ' heures'));
    
        $form->ajouterComposantTab();

        $form->ajouterComposantLigne($form->creerLabel('Ouverture: '));
        $form->ajouterComposantLigne($form->creerLabel($formation->getDateOuvertureInscri()));
        $form->ajouterComposantLigne($form->creerLabel(' '));
        

        $form->ajouterComposantLigne($form->creerLabel(' Clôture: '));
        $form->ajouterComposantLigne($form->creerLabel($formation->getDateClotureInscri()));
        $form->ajouterComposantLigne($form->creerLabel(' '));
        $form->ajouterComposantTab();

        
        $form->ajouterComposantLigne($form->creerLabel($formation->getEffectifMax()));

        $form->ajouterComposantLigne($form->creerLabel('/'));
        $form->ajouterComposantLigne($form->creerLabel($formation->getEffectifActuel()));
        $form->ajouterComposantLigne($form->creerLabel(' inscriptions'));

        $form->ajouterComposantLigne($form->creerInputSubmit('btnInscriptionFormation_' . $idFormation, 'btnInscriptionFormation', 'S\'inscrire'));
        $form->ajouterComposantTab();



    }
    
    
    $formulaires[] = $form->creerFormulaire();

}



$formCreationFormation = new Formulaire('POST', '', 'formation' , 'formation');
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerLabelClasse('Ajouter une formation', 'intitule'));
$formCreationFormation->ajouterComposantTab();
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerLabel('Intitulé: '));
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerInputTexte('intitule', 'intitule', '', 1, '', '' ));
$formCreationFormation->ajouterComposantTab();

$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerLabel('Descriptif: '));
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerInputTexte('descriptif', 'descriptif', '', 1, '', '' ));
$formCreationFormation->ajouterComposantTab();

$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerLabel('Durée (en minutes): '));
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerInputTexte('duree', 'duree', '', 1, '', '' ));
$formCreationFormation->ajouterComposantTab();

$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerLabel('Ouverture: '));
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerInputTexte('ouverture', 'ouverture', '', 1, 'AAAA-mm-jj', '' ));
$formCreationFormation->ajouterComposantTab();

$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerLabel('Clôture: '));
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerInputTexte('cloture', 'cloture', '', 1, 'AAAA-mm-jj', '' ));
$formCreationFormation->ajouterComposantTab();

$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerLabel('Places disponibles: '));
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerInputTexte('effectifMax', 'effecticMax', '', 1, '', '' ));
$formCreationFormation->ajouterComposantTab();
$formCreationFormation->ajouterComposantLigne($formCreationFormation->creerInputSubmit('btnCreationFormation', 'btnCreationFormation', 'Créer formation'));
$formCreationFormation->ajouterComposantTab();

$formulaireCreationIscription = $formCreationFormation->creerFormulaire();


require_once 'vue/vueFormations.php';