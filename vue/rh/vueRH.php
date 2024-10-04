<div class="container">
    <header>
        <?php include_once 'vue/haut.php';?>
    </header>
    <main>
        <div class="rh">
            <?php
            $tabSalarie->afficherTableau();
            $tabContrat->afficherTableau();
            ?>
        </div>
    </main>
    <footer>
        <?php include_once 'vue/bas.php';?>
    </footer>
</div>