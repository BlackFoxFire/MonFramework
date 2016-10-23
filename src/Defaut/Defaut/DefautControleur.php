<?php

	/*
	*
	* DefautControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur par défaut pour une nouvelle application
	*
	*/
	
	// Définition de l'espace de nom
	namespace Defaut\Defaut;
	
	// Importation
	use MonFramework\Controleur;
	
	/* Définition de la classe. */
	class DefautControleur extends Controleur {
		
		// Action par defaut
		public function indexAction() {
			$donnees['title'] = "Hello World !";
			$donnees['hello'] = "Bonjour tout le monde !";
			
			$this->render($donnees);
		}
		
	}
	/* Fin de la définition de la classe. */
