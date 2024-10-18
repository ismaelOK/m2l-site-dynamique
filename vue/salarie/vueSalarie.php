<div class="container">
    <header>
        <?php include_once 'vue/haut.php'?>
    </header>
    <main>
        <div class="bulletin">
            <?php $tabSalarie->afficherTableau(); ?>
        </div>
        <p></p>;
        <p></p>;
        <div class="contrat">
            <?php $tabContrat->afficherTableau(); ?>
        </div>
        <p></p>
        <p></p>
        <div class="user" style="font-size:50px; margin-top:150px; margin-left:500px; margin-bottom:80px;">
            <?php $tabUser->afficherTableau(); ?>
        </div>
    </main>
    <footer>
        <?php include_once 'vue/bas.php'?>
    </footer>
</div>
