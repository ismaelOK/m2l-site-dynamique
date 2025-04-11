<?php
class formationManager{
    public static getFormationsForAdmin($formation, $name){

    $form = new Formulaire('POST', 'controleurGestionFormations.php', 'formation' , 'formation');  

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

    $formulaires[] = $form->creerFormulaire();

    return $formulaires;


    }
}



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
   
    //AQUI

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

$formulaireCreationInscription = $formCreationFormation->creerFormulaire();




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