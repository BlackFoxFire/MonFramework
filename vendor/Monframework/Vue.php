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
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	class Vue extends MonFramework {
		
		// Chemin vers le fichier contenant la vue à afficher
		private $fichierVue;
		
		// Fichier contenant le template
		private $template;
		
		// Controleur de classe
		public function __construct($fichier, $controleur = null) {
			$fichier = str_replace("Action", "", $fichier);
			$this->fichierVue = $fichier . ".html";
			
			$dossierVues1 = "../src/vues/";
			
			if($controleur == null) {
				$this->template = new Foxy($dossierVues1);
			}
			else {
				$dossierVues2 = "../src/" . $controleur . "/vues/";
				$this->template = new Foxy(array($dossierVues1, $dossierVues2));
			}
		}
		
		// Génère et affiche la vue en utilisant le moteur de template
		public function render($donnees) {
			$donnees['racineWeb'] = Configuration::getConfig('appDir');
			
			$this->template->load($this->fichierVue);
			
			$donnees['titrePrincipale'] = Configuration::getConfig('app');
			$donnees['contenu'] = $this->template->render($donnees);
			
			$this->template->load("gabarit.html", false);
			
			echo $this->template->render($donnees);
		}
	}
	/* Fin de la définition de la classe. */
