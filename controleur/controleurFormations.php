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

        
            
        if (strpos($key, 'btnAccepterDemande_') === 0) {
            list(, $userId, $formationId) = explode('_', $key);
            DemandeInscriptionDAO::accepterDemande($userId, $formationId);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit();
        }
         
        if (strpos($key, 'btnRefuserDemande_') === 0) {
            list(, $userId, $formationId) = explode('_', $key);
            DemandeInscriptionDAO::refuserDemande($userId, $formationId);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit();
        }

        if (strpos($key, 'btnAnnulerModificationFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
            unset($_SESSION['editFormationId']);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit(); 
        }

        if (strpos($key, 'btnAnnulerModificationFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
            unset($_SESSION['editFormationId']);
            header("Location: http://localhost/m2l/index.php?m2lMP=formations");
            exit(); 
        }

        if (strpos($key, 'btnInscriptionFormation_') === 0) {
            $idFormation = explode('_', $key)[1];
            DemandeInscriptionDAO::demanderInscription($_SESSION['identification']['idUser'], $idFormation);
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
 ou
 Uniquement la formation à modifier choisie par le responsable si il est en edit mode
 ou
 Uniquement les formations disponibles pour s'inscrire si on est un utilisateur sans privilèges

 ------

 Edit mode: Activé quand le responsable appuie sur le boutton modification d'une formation,
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
    elseif($isResponsableFormation === FALSE)
        
    {

        if(FormationDAO::isFormationAvailable($formation))
        {
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

            if(UtilisateurDAO::hasPendingOrAcceptedDemand(
                $_SESSION['identification']['idUser'], $formation->getIdForma()))
            {
                $form->ajouterComposantLigne($form->creerLabel('Votre demande pour cette inscription est en attente ou dèja validée'));
            
            }
            else{

                $form->ajouterComposantLigne($form->creerInputSubmit('btnInscriptionFormation_' . $idFormation, 'btnInscriptionFormation', 'Inscription'));
            }
            $form->ajouterComposantTab();
        }
        else{
            continue;
        }

        


    }
    
    
    $formulaires[] = $form->creerFormulaire();

}

if($isResponsableFormation)
{
    

    $formulaireCreationInscription = createFormationForm();




    $demandes = DemandeInscriptionDAO::getAllDemandes();
    foreach($demandes as $demande){

        
        $formDemande = new Formulaire('POST', '', 'demande' , 'demande');
        $formDemande->ajouterComposantTab();
        $formDemande->ajouterComposantLigne($formDemande->creerLabel('Formation: '));
        $formDemande->ajouterComposantLigne($formDemande->creerLabel($demande->getFormation()->getIntitule()));
        $formDemande->ajouterComposantTab();

        $formDemande->ajouterComposantLigne($formDemande->creerLabel($demande->getUtilisateur()->getTypeUser() . ': '));
        $formDemande->ajouterComposantLigne($formDemande->creerLabel($demande->getUtilisateur()->getNom()) . ' ' . $demande->getUtilisateur()->getPrenom());
        $formDemande->ajouterComposantTab();

        $etatDemande = $demande->getEtatDemande();

            switch ($etatDemande){
                case '0':
                    $etatDemande = "En attente";
                    break;
                case '1':
                    $etatDemande = "Refusée";
                    break;
                case '2':
                    $etatDemande = "Validée";
                    break;
                default:
                    $etatDemande = "N/A";
            }
            $formDemande->ajouterComposantLigne($formDemande->creerLabel($etatDemande));
            $formDemande->ajouterComposantTab();


        if ($demande->getEtatDemande() == 0){
            $formDemande->ajouterComposantLigne($formDemande->creerInputSubmit('btnAccepterDemande_' . $demande->getUtilisateur()->getIdUser() . '_' . $demande->getFormation()->getIdForma(), 'btnAccepterDemande', 'Accepter'));
            $formDemande->ajouterComposantLigne($formDemande->creerInputSubmit('btnRefuserDemande_' . $demande->getUtilisateur()->getIdUser() . '_' . $demande->getFormation()->getIdForma(), 'btnRefuserDemande', 'Refuser'));
            $formDemande->ajouterComposantTab();

        }

        $formDemandes[] = $formDemande->creerFormulaire(); 

    }

}
else {
    $demandes = DemandeInscriptionDAO::getDemandesByUserId($_SESSION['identification']['idUser']);
    $formDemandes = []; 

    if (!empty($demandes)) { 
        foreach ($demandes as $demande) {
            $formDemande = new Formulaire('POST', '', 'demande' , 'demande');
            $formDemande->ajouterComposantTab();
            $formDemande->ajouterComposantLigne($formDemande->creerLabel('Formation: '));
            $formDemande->ajouterComposantLigne($formDemande->creerLabel($demande->getFormation()->getIntitule()));
            $formDemande->ajouterComposantTab();

            $etatDemande = $demande->getEtatDemande();

            switch ($etatDemande){
                case '0':
                    $etatDemande = "En attente";
                    break;
                case '1':
                    $etatDemande = "Refusée";
                    break;
                case '2':
                    $etatDemande = "Validée";
                    break;
                default:
                    $etatDemande = "N/A";
            }
            $formDemande->ajouterComposantLigne($formDemande->creerLabel($etatDemande));
            $formDemande->ajouterComposantTab();
            
            $formDemandes[] = $formDemande->creerFormulaire(); 
        }
    }
}



require_once 'vue/vueFormations.php';