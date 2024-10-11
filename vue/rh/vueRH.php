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
                    echo "<label class='idLigue'>ID Ligue : </label>";
                    echo "<input type='text' name='idLigue' id='idLigue' required='1'/>";
                    echo "<br>";
                    echo "<label class='idClub'>ID Club : </label>";
                    echo "<input type='text' name='idClub' id='idClub' required='1'/>";
                }
                else{
                    $tabSalarie->afficherTableau();
                    echo "<input type='submit' value='Ajouter Salarie' id='ajouterSalarie' name = 'ajouterSalarie'/>";
                    echo "<input type='submit' value='Modifier Salarie', id='modifierSalarie' name='modifierSalarie'/>";
                }
                ?>
            </form>
            <br>
            <br>
            <?php $tabBulletin->afficherTableau();?>
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