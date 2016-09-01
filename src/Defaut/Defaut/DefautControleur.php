<?php

	/*
	*
	* DefautControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur par défaut pour un nouvelle application
	*
	*/
	
	// Définition de l'espace de nom
	namespace Defaut\Defaut;
	
	use BlackFox\MonFramework\Controleur;
	// use Defaut\DefautControleur;
	
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
			// echo __NAMESPACE__;
			$this->genererVue($donnees);
		}
		
	}
	/* Fin de la définition de la classe. */