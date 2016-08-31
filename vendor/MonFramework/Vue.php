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
	namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	class Vue {
		
		// Chemin vers le fichier contenant la vue à afficher
		private $fichier;
		private $dossier;
		
		// Controleur de classe
		public function __construct($action, $controleur = null) {
			$appSrc = str_replace("/", "", Configuration::getParametre("app", "appSrc"));
			
			$this->dossier = "../src/" . $appSrc . "/vues/";
			
			if(is_null($controleur))
				$dossier = $this->dossier;
			else
				$dossier = "../src/" . $appSrc . "/" . $controleur . "/vues/";
			
			$this->fichier = $dossier . $action . ".php";
		}
		
		// Génère et affiche la vue
		public function generer($donnees) {
			$donnees['contenu'] = $this->genererFichier($this->fichier, $donnees);
			$donnees['appDir'] = Configuration::getParametre("app", "appDir", "/");
			$vue = $this->genererFichier($this->dossier . 'gabarit.php', $donnees);
			echo $vue;
		}
		
		// Génère un fichier vue et renvoie le résultat produit
		private function genererFichier($fichier, $donnees) {
			if(file_exists($fichier)) {
				extract($donnees);
				ob_start();
				require($fichier);
				return ob_get_clean();
			}
			else {
				throw new Exception("Fichier '$fichier' introuvable.");
			}
		}
		
		// Nettoie une valeur insérée dans une page HTML
		// Permet d'éviter les problèmes d'exécution de code indésirable (XSS) dans les vues générées
		private function nettoyer($donnees) {
			return htmlspecialchars($donnees, ENT_QUOTES, 'UTF-8', false);
		}
	}
	/* Fin de la définition de la classe. */
