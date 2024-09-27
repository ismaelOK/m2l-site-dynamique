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
        <div class="user">
            <?php $tabUser->afficherTableau(); ?>
        </div>
    </main>
    <footer>
        <?php include_once 'vue/bas.php'?>
    </footer>
</div>
