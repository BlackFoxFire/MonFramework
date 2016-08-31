<?php

	/*
	* Session.php
	* @Auteur : Christophe Dufour
	* 
	* Classe modélisant une session.
	*
	*/
	
	// Définition de l'espace de nom
	namespace BlackFox\MonFramework;
	
	/* Définition de la classe */
	class Session {
	
		// Démarre ou restaure un session
		public function __construct() {
			session_start();
		}
		
		// Détruit la session actuelle
		public function detruire() {
			session_destroy();
		}
		
		// Ajoute un variable de session
		public function setAttribut($nom, $valeur) {
			$_SESSION[$nom] = $valeur;
		}
		
		// Renvoie true si une variable de session existe
		public function existeAttribut($nom) {
			return(!empty($_SESSION[$nom]));
		}
		
		// Renvoie la valeur d'une variable de session
		public function getAttribut($nom) {
			if(existeAttribut($nom)) {
				return($_SESSION[nom]);
			}
			else {
				throw new Exception("Attribut '$nom' absent de la session.");
			}
		}
	
	}
	/* Fin de la définition de la classe. */
