<?php

	/*
	*
	* Routeur.php
	* @Auteur : Christophe Dufour
	*
	* Analyse une requete et renvoie au kernel
	* le controleur à charger et l'action à exécuter
	*
	*/
	
	// Définition de l'espace de nom
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	class Routeur extends MonFramework {
		
		// Tableau des parametres controleur/action/id
		private $parametres;
		
		// Retourne le controlleur de la requete
		public function getControleur(Requete $requete) {
			$controleur = Configuration::moduleParDefaut();
			$controleur = ucfirst(strtolower($controleur));
			
			if($requete->parametreExiste("controleur")) {
				$controleur = $requete->getParametre("controleur");
				$controleur = ucfirst(strtolower($controleur));
			}
			
			if(Configuration::moduleExiste($controleur)) {
				$controleur = $controleur . "Controleur";
				$controleur = new $controleur();
				$controleur->setRequete($requete);
				
				return $controleur;
			}
			else {
				throw new Exception("Module non reconnu : '$controleur'.");
			}
		}
		
		// Retourne l'action de la requete
		public function getAction(Requete $requete) {
			$action = "index";
			
			if($requete->parametreExiste("action")) {
				$action = $requete->getParametre("action");
			}
			
			return $action;
		}
	}
	/* Fin de la définition de la classe. */
