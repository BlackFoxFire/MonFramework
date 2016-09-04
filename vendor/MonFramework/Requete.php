<?php

	/*
	*
	* Requete.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant une requête HTTP entrante
	*
	*/
	
	// Définition de l'espace de nom
	namespace MonFramework;
	
	/* Définition de la classe. */
	class Requete {
		
		// Tableau des paramètres d'un requête http
		private $parametres;
		
		// Constructeur de classe
		// Initialise l'attribut parametres
		public function __construct($parametres) {
			$this->parametres = $parametres;
		}
		
		// Renvoie true si un parametre existe dans le tableau des paramètres
		public function existe($nom) {
			return(isset($this->parametres[$nom]) && $this->parametres[$nom] != "");
		}
		
		// Retourne la valeur d'un paramètre
		public function get($nom) {
			if($this->existe($nom))
				return $this->parametres[$nom];
			else
				throw new \Exception("Parametre $nom absent de la requête.");
		}
		
	}
	/* Fin de la définition de la classe. */
