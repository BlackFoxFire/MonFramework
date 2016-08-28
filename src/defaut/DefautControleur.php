<?php

	/*
	*
	* DefautControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur par défaut pour un nouvelle application
	*
	*/
	
	/* Définition de la classe. */
	class DefautControleur extends Controleur {
		
		// Constructeur de classe
		public function __construct() {
			// Rien pour le moment
		}
		
		// Action par defaut
		// Affiche la liste des catégories
		public function indexAction() {
			$donnees['title'] = "Hello World !";
			$donnees['hello'] = "Hello World !";
			
			$this->genererVue($donnees);
		}
		
	}
	/* Fin de la définition de la classe. */
