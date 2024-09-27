<?php
class Tableau {
	
	private $nbCol;
	private $nbLig;
	private $titreTab;
	private $titreCol;
	private $donneesTab;
	private $idTab;
	private $taille;

	public function __construct($unIdTab , $lesDonnees){
		$this->idTab = $unIdTab;
		$this->donneesTab = $lesDonnees;
	}
			
	public function setTitreTab($unTitreTab){
		$this->titreTab = $unTitreTab;
	}
	
	public function setTitreCol($lesTitreCol){
		$this->titreCol = $lesTitreCol;
	}

	public function setTaille($uneTaille){
		$this->taille = $uneTaille;
	}
	
	
	public function afficherTableau(){
		
		$tabHeadChaine ="";
		$tabChaine = "<table id = '". $this->idTab . "' border = ". $this->taille . " >";
		
		//Afficher le titre du tableau
		if(!empty($this->titreTab) && !empty($this->donneesTab)){
			$tabHeadChaine =  "<thead> <tr> <th colspan = '";
			$tabHeadChaine .= count($this->donneesTab[0]);
			$tabHeadChaine .= "' >";
			$tabHeadChaine .= $this->titreTab;
			$tabHeadChaine .= "</th></tr></thead>";
		}
		
		
		//Afficher les ent�tes des colonnes
		if(!empty($this->titreCol)){
			$tabHeadChaine .= "<thead><tr class='titreCols'>";
			foreach($this->titreCol as $cellule){
				$tabHeadChaine .= "<th>";
				$tabHeadChaine .= $cellule;
				$tabHeadChaine .= "</th>";
			}
			$tabHeadChaine .= "</tr></thead>";
		}
		
		//Afficher le corps du tableau
		$tabBodyChaine = "<tbody>";
		$i=0;
		foreach($this->donneesTab as $ligne){
			if ($i % 2 == 0){
				$tabBodyChaine .=  "<tr class='pair'>";
			}
			else{
				$tabBodyChaine .=  "<tr class='impair'>";
			}
			foreach($ligne as $cellule){
				$tabBodyChaine .=  "<td>";
				$tabBodyChaine .=  $cellule;
				$tabBodyChaine .=  "</td>";
			}
			$tabBodyChaine .=  "</tr>";
			$i++;
		}
		$tabBodyChaine .=  "</tbody></table>";
		
		$tabChaine .= $tabHeadChaine . $tabBodyChaine;
		
		echo $tabChaine;
	}
	
}