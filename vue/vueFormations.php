<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	
	<main>
	<div class='gauche'>
		<div class='formFormation'>
			<?php echo $formulaireCreationIscription;
			if (!empty($errors)) {
				echo '<div class="error-messages" style="color: red;">';
				foreach ($errors as $error) {
					echo '<p>' . htmlspecialchars($error) . '</p>';
				}
				echo '</div>';
			
			} ?>
		</div>
	</div>

		<div class='droite'>
			<h1>Les Formations</h2>
			<br>

			<?php


			

			
			
			
				foreach ($formulaires as $form) {
					echo $form;

					echo "</br></br></br>";

				}
				

				
			?>

			<h1>Demandes d'inscription</h2>
						<br>
		</div>
	</main>
	
</div>