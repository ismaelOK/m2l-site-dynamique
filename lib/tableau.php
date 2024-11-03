<?php
class Tableau {
	
	private $nbCol;
	private $nbLig;
	private $titreTab;
	private $titreCol;
	private $donneesTab;
	private $idTab;
	private $taille;

	public function __construct($unIdTab , $lesDonnees = array()){
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

	public function setData($data){
		$this->donneesTab = $data;
	}
	
	
	public function afficherTableau() {
        echo "<table id='{$this->idTab}' class='tableau' border='{$this->taille}'>";

        // Afficher le titre du tableau
        if (!empty($this->titreTab)) {
            echo "<caption>{$this->titreTab}</caption>";
        }

        // Afficher les titres des colonnes
        if (!empty($this->titreCol)) {
            echo "<thead><tr>";
            foreach ($this->titreCol as $col) {
                echo "<th>{$col}</th>";
            }
            echo "</tr></thead>";
        }

        // Afficher les données du tableau
        if (!empty($this->donneesTab)) {
            echo "<tbody>";
            foreach ($this->donneesTab as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>{$cell}</td>";
                }
                echo "</tr>";
            }
            echo "</tbody>";
        }

        echo "</table>";
    }
	
}