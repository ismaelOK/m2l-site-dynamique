<?php
if(isset($_GET['m2lMP'])){
	$_SESSION['m2lMP']= $_GET['m2lMP'];
}
else
{

	if(!isset($_SESSION['m2lMP'])){
		$_SESSION['m2lMP']="accueil";
	}
}

// Si le formulaire a été soumis (vérifie la présence de 'submitConnex')
$messageErreurConnexion = null;

if (isset($_POST['submitConnex'])) {
	// Récupérer le login et le mdp fournis par l'utilisateur
	$login = $_POST['login'];
	$mdp = $_POST['mdp'];

	// Créer une instance d'Utilisateur pour vérifier les informations
	$utilisateur = new Utilisateur('', '', '', $login, $mdp, '', '', '', '');

	// Utilisation de la classe UtilisateurDAO pour vérifier l'utilisateur
	$_SESSION['identification'] = UtilisateurDAO::verification($utilisateur);

	// Si l'utilisateur n'est pas trouvé dans la base de données
	if (!$_SESSION['identification']) {
		//Alors une message d'erreur affiche.
		$messageErreurConnexion = "Mot de passe ou login incorrect !";
	}
	//Sinon
	else{
		//On se dirige vers la page selon le type de l'utilisateur.
		$_SESSION['m2lMP'] = $_SESSION['identification']['typeUser'] ;
	}
	
}




$m2lMP = new Menu("m2lMP");

$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));

if(!$_SESSION['identification']){
	$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se connecter"));
}
else{

	$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se déconnecter"));
	if($_SESSION['identification']['typeUser'] === "Salarie"){
	
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("salarie", "Salarie"));
	}
	elseif ($_SESSION['identification']['typeUser'] === "Benevole"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("benevole", "Benevole"));
	}
	elseif ($_SESSION['identification']['typeUser'] === "Responsable de formation"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("responsableFormation", "Responsable de formations"));
	}
	elseif($_SESSION['identification']['typeUser'] === "Responsable RH"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("rh", "Responsable RH"));
	}
	else{
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("secretariat", "Secrétaire"));
	}
	

}

$menuPrincipalM2L = $m2lMP->creerMenu($_SESSION['m2lMP'],'m2lMP');

include_once dispatcher::dispatch($_SESSION['m2lMP']);

?>
