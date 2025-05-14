<?php

class formationManager{
    public static function getFormationsForAdmin($formation, $name){

    $form = new Formulaire('POST', 'controleurGestionFormations.php', $name , 'formation');  

    $form->ajouterComposantLigne($form->creerInputHidden('formation_id', $formation->getIdForma()));

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
    $form->ajouterComposantLigne($form->creerInputSubmit('btnModificationFormation' 'btnModificationFormation', 'Modifier'));
    $form->ajouterComposantLigne($form->creerInputSubmit('btnSuppressionFormation', 'btnSuppressionFormation', 'Supprimer'));
        
    $form->ajouterComposantTab();

    $formulaires[] = $form->creerFormulaire();

    return $formulaires;


    }

    public static function createFormationForm(){

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

    }



}
