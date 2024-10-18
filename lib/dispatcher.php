<?php
class dispatcher{

	public static function dispatch($unMenuP){
		if (empty($unMenuP)) {
            $unMenuP = "accueil";  
        }

		$unMenuP = "controleur" . ucfirst($unMenuP) ;
		$unMenuP .= ".php";
		$unMenuP = "controleur/" . $unMenuP;
		return $unMenuP ;
	}
	
}
