<div class="container">
    <header>
        <?php include_once 'vue/haut.php';?>
    </header>
    <main>
        <div class="rh">
            <form method="post" action="index.php" name="formSalarie" class="formSalarie">
                <?php
                if (isset($_POST['ajouterSalarie'])){
                    echo "<label class='idUser'>ID User : </label>";
                    echo "<input type='text' name='idUser' id='idUser' required='1'/>";
                    echo "<br>";
                    echo "<label class='nom'>Nom : </label>";
                    echo "<input type='text' name='nom' id='nom' required='1'>";
                    echo "<br>";
                    echo "<label class='prenom'>Prenom : </label>";
                    echo "<input type='text' name='prenom' id='prenom' required='1'>";
                    echo "<br>";
                    echo "<label class='login'>Login : </label>";
                    echo "<input type='text' name='login' id='login' required='1'>";
                    echo "<br>";
                    echo "<label class='mdp'>MDP : </label>";
                    echo "<input type='password' name='mdp' id='mdp' required='1'/>";
                    echo "<br>";
                    echo "<input type='submit' value='Enregistrer' name='enregAjouter'/>";
                    echo "<input type='submit' value='annuler' name='Annuler'/>";
                }
                if (isset($_POST['modifierSalarie'])) {
                    // Récupérer l'ID du salarié à modifier à partir de la requête POST
                    $idSalarie = $_POST['idSalarie'];
                
                    // Récupérer tous les salariés (ou utiliser une méthode plus ciblée pour ne récupérer que celui que vous voulez modifier)
                    $dataSalarie = SalarieDAO::getAllSalarie();
                
                    // Trouver le salarié correspondant à l'ID
                    $salarieToEdit = null;
                    foreach ($dataSalarie as $salarie) {
                        if ($salarie->getIdUser() === $idSalarie) {
                            $salarieToEdit = $salarie;
                            break;
                        }
                    }
                
                    // Si le salarié a été trouvé, afficher les informations dans le formulaire
                    if ($salarieToEdit !== null) {
                        // Pré-remplir les champs du formulaire avec les informations du salarié à modifier
                        echo "<label class='idUser'>ID User : </label>";
                        echo "<input type='text' name='idUser' id='idUser' required='1' value='" . $salarieToEdit->getIdUser() . "' readonly/>";
                        echo "<br>";
                        echo "<label class='nom'>Nom : </label>";
                        echo "<input type='text' name='nom' id='nom' required='1' value='" . $salarieToEdit->getNom() . "'/>";
                        echo "<br>";
                        echo "<label class='prenom'>Prenom : </label>";
                        echo "<input type='text' name='prenom' id='prenom' required='1' value='" . $salarieToEdit->getPrenom() . "'/>";
                        echo "<br>";
                        echo "<label class='login'>Login : </label>";
                        echo "<input type='text' name='login' id='login' required='1' value=''/>"; // Login non présent dans les données actuelles
                        echo "<br>";
                        echo "<label class='mdp'>MDP : </label>";
                        echo "<input type='password' name='mdp' id='mdp' required='1' value=''/>";
                        echo "<br>";
                        echo "<label class='idLigue'>ID Ligue : </label>";
                        echo "<input type='text' name='idLigue' id='idLigue' required='1' value=''/>";
                        echo "<br>";
                        echo "<label class='idClub'>ID Club : </label>";
                        echo "<input type='text' name='idClub' id='idClub' required='1' value=''/>";
                        echo "<br>";
                        echo "<label class='idFonct'>ID Fonctionnaire : </label>";
                        echo "<input type='text' name='idFonct' id='idFonct' required='1' value=''/>";
                        echo "<br>";
                        echo "<input type='submit' value='Enregistrer' name='enregModifier'/>";
                        echo "<input type='submit' value='Annuler' name='Annuler'/>";
                    } else {
                        echo "Le salarié n'a pas été trouvé.";
                    }
                }
                else{
                    $tabSalarie->afficherTableau();
                    echo "<input type='submit' value='Ajouter Salarie' id='ajouterSalarie' name = 'ajouterSalarie'/>";
                }
                ?>
            </form>
            <br>
            <br>
            <form method="POST" action="index.php" name="formBulletin" id="formBulletin">
                <?php
                if(isset($_POST['ajouterBulletin'])){
                    echo "<label class='idBulletin'>Contrat : </label>";
                    echo "<input type='text' name = 'idBulletin' id='idBulletin' required='1' value=''/>";
                    echo "<br>";
                    echo "<label class='moisBulletin'>Mois : </label>";
                    echo "<input type='texte' name='moisBulletin' required='1' id='idBulletin' value=''/>";
                    echo "<br>";
                    echo "<label class='anneeBulletin'></label>";
                    echo "<input type='text' name='anneeBulletin' required='1' id='anneeBulletin' value''/>";
                    echo "<br>";
                    echo "<label class='bulletinPDF'>Bulletin PDF : </label>";
                    echo "<input type='text' name='bulletinPDF required='1' id='BulletinPDF' value=''/>";
                    echo "<br>";
                    echo "<label class='idContrat'>N° Contrat : </label>";
                    echo "<input type='text' name='idContrat' required='1' id='bulletinPDF' value=''/>";
                    echo "<br>";
                    echo "<input type='submit' id='enregAjouterBulletin' value='Enregistrer'/>";
                    echo "<input type='submit' value='Annuler' name='Annuler'/>";
                }
                else{
                    $tabBulletin->afficherTableau();
                    echo "<input type='submit' value='Ajouter Bulletin' id='ajouterBulleitn' name='ajouterBulletin'/>";
                }
                ?>
            </form>
            <br>
            <br>
            <?php $tabContrat->afficherTableau(); ?>
            <br>
            <br>
            <?php $tabUser->afficherTableau(); ?>
        </div>
    </main>
    <footer>
        <?php include_once 'vue/bas.php';?>
    </footer>
</div>