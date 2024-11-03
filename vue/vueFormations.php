<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	
	<main>
	<div class='gauche'>
		<div class='formFormation'>


			<?php 
			if ($_SESSION['identification']['typeUser'] === "Responsable de formation"){
			
			echo $formulaireCreationInscription;
			if (!empty($errors)) {
				echo '<div class="error-messages" style="color: red;">';
				foreach ($errors as $error) {
					echo '<p>' . htmlspecialchars($error) . '</p>';
				}
				echo '</div>';
			
			} 
			
		}?>
		</div>
	</div>

		<div class='droite'>
			<h1>Les Formations</h2>
			<br>

			<?php
				if (!empty($formulaires)){
				foreach ($formulaires as $form) {
					echo $form;

					echo "</br></br></br>";

				}
			}
			else{
				echo "</br></br></br></br></br></br></br></br></br>";
			}
				

				
			?>

			<h1>Demandes d'inscription</h2>
						<br>

						<?php

						if (!empty($formDemandes)){
							foreach ($formDemandes as $form) {
								echo $form;
			
								echo "</br></br></br>";
			
							}
						}
				
			?>

						
		</div>
	</main>
	
</div>