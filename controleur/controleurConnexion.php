<?php

// Show the form if the user is not logged in
if (!isset($_SESSION['identification']) || !$_SESSION['identification']) {

    // Create the form for login
    $formulaireConnexion = new Formulaire('post', 'index.php', 'fConnexion', 'fConnexion');
    
    $formulaireConnexion->ajouterComposantLigne($formulaireConnexion->creerLabel('Identifiant :'));
    $formulaireConnexion->ajouterComposantLigne($formulaireConnexion->creerInputTexte('login', 'login', '', 1, 'Entrez votre identifiant', ''));
    $formulaireConnexion->ajouterComposantTab();

    $formulaireConnexion->ajouterComposantLigne($formulaireConnexion->creerLabel('Mot de Passe :'));
    $formulaireConnexion->ajouterComposantLigne($formulaireConnexion->creerInputMdp('mdp', 'mdp',  1, 'Entrez votre mot de passe', ''));
    $formulaireConnexion->ajouterComposantTab();

    $formulaireConnexion->ajouterComposantLigne($formulaireConnexion->creerInputSubmit('submitConnex', 'submitConnex', 'Valider'));
    $formulaireConnexion->ajouterComposantTab();
    
    // Display the error message if login fails
    
    $formulaireConnexion->ajouterComposantLigne($formulaireConnexion->creerMessage($messageErreurConnexion));
    $formulaireConnexion->ajouterComposantTab();
    

    // Render the form
    $formulaireConnexion->creerFormulaire();

    // Include the view that shows the form
    require_once 'vue/vueConnexion.php';

} else {
    // User is already logged in, redirect to the home page
	$_SESSION['identification']=[];
    $_SESSION['m2lMP'] = "accueil";
    header('location: index.php');
    
}
?>