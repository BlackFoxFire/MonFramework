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
	namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	class Routeur {
		
		// Tableau des parametres controleur/action/id
		private $parametres;
		
		// Retourne le controlleur de la requete
		public function getControleur(Requete $requete) {
			$controleur = Configuration::getParametre("mod", "defaut", "defaut");
			$controleur = ucfirst(strtolower($controleur));
			
			if($requete->parametreExiste("controleur")) {
				$controleur = $requete->getParametre("controleur");
				$controleur = ucfirst(strtolower($controleur));
			}
			
			$espaceDeNom = Configuration::getParametre("app", "appSrc");
			$espaceDeNom = ucfirst(str_replace("/", "\\", $espaceDeNom)) . "\\";
			
			$controleur = $espaceDeNom . $controleur . "\\" . $controleur . "Controleur";
			$controleur = new $controleur();
			$controleur->setRequete($requete);
			
			return $controleur;
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
