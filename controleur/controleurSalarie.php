<?php
if (isset($_SESSION['identification']) && S_SESSION['identification']['typeUser'] === 'Salarie'){
    //Récupération de l'ID du salarié à partir de la session
    $idSalarie = $_SESSION['identification']['id'];
}
    include_once 'vue/salarie/vueSalarie.php';
?>