<?php

	/*
	*
	* Vue.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant une vue
	*
	*/
	
	// Définition de l'espace de nom
	namespace MonFramework;
	
	// Importation
	use Foxy\Foxy;
	
	/* Définition de la classe. */
	class Vue {
		
		// Chemin vers le fichier contenant la vue à afficher
		private $fichier;
		private $path;
		
		// Controleur de classe
		public function __construct($action, $controleur = null) {
			$appSrc = Configuration::getParametre("app", "appSrc");
			$this->path['dossier1'] = SRC . $appSrc . DS . "vues" . DS;
			
			if(!is_null($controleur)) {
				$ctrl = substr(strrchr($controleur, "\\"), 1);
				$controleur = str_replace($ctrl, "", $controleur);
				$controleur = str_replace("\\", DIRECTORY_SEPARATOR, $controleur);
				$this->path['dossier2'] = SRC . $controleur . "vues" . DS;
			}
			
			$this->fichier = $action . ".html";
		}
		
		// Génère et affiche la vue
		public function render($donnees, $genererFichier = true) {
			$donnees['appDir'] = Configuration::getParametre("app", "appDir");
			
			if($genererFichier) {
				$vue = new Foxy($this->path);
				$vue->load($this->fichier);
				
				$donnees['contenu'] = $vue->render($donnees);
			}
			
			$vue->load("gabarit.html", false);
			echo $vue->render($donnees);
			
		}
		
	}
	/* Fin de la définition de la classe. */
