<?php


// Vérification de la clé 'm2lMP' dans la requête GET
if (isset($_GET['m2lMP'])) {
    $_SESSION['m2lMP'] = $_GET['m2lMP'];
} else {
    if (!isset($_SESSION['m2lMP'])) {
        // Définir la page d'accueil par défaut si aucune clé 'm2lMP' n'est présente
        $_SESSION['m2lMP'] = "accueil";
    }
}

// Si le formulaire a été soumis (vérifie la présence de 'submitConnex')
$messageErreurConnexion = null;

if (isset($_POST['submitConnex'])) {
    // Récupérer le login et le mot de passe fournis par l'utilisateur
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Créer une instance d'Utilisateur pour vérifier les informations
    $utilisateur = new Utilisateur('', '', '', $login, $mdp, '', '', '', '');

    // Utilisation de la classe UtilisateurDAO pour vérifier l'utilisateur
    $_SESSION['identification'] = UtilisateurDAO::verification($utilisateur);

    // Si l'utilisateur n'est pas trouvé dans la base de données
    if (!$_SESSION['identification']) {
        // Alors une message d'erreur est affiché.
        $messageErreurConnexion = "Mot de passe ou login incorrect !";
    } else {
        // On se dirige vers la page selon le type de l'utilisateur.
        $_SESSION['m2lMP'] = $_SESSION['identification']['typeUser'];
    }
}

// Création du menu principal
$m2lMP = new Menu("m2lMP");

$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['identification']) || !$_SESSION['identification']) {
    $m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se connecter"));
} else {
    $m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se déconnecter"));

    // Vérification du type d'utilisateur et ajout d'éléments spécifiques au menu
    if ($_SESSION['identification']['typeUser'] === "Salarie") {
        $m2lMP->ajouterComposant($m2lMP->creerItemLien("salarie", "Salarie"));
    } elseif ($_SESSION['identification']['typeUser'] === "Benevole") {
        $m2lMP->ajouterComposant($m2lMP->creerItemLien("benevole", "Benevole"));
    } elseif ($_SESSION['identification']['typeUser'] === "Responsable de formation") {
        $m2lMP->ajouterComposant($m2lMP->creerItemLien("Formations", "Responsable de formation"));
    } elseif ($_SESSION['identification']['typeUser'] === "Responsable RH") {
        $m2lMP->ajouterComposant($m2lMP->creerItemLien("rh", "Responsable RH"));
    }
}

// Création du menu principal à partir de la session
$menuPrincipalM2L = $m2lMP->creerMenu($_SESSION['m2lMP'], 'm2lMP');

// Inclure le fichier de contrôle en fonction de la clé 'm2lMP'
include_once Dispatcher::dispatch($_SESSION['m2lMP']);
