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
	namespace MonFramework;
	
	/* Définition de la classe. */
	class Routeur {
		
		// Retourne le controlleur de la requete
		public function getControleur(Requete $requete) {
			$controleur = Configuration::getParametre("controleur", "controleur", "defaut");
			$controleur = ucfirst(strtolower($controleur));
			
			if($requete->existe("controleur")) {
				$controleur = $requete->get("controleur");
				$controleur = ucfirst(strtolower($controleur));
			}
			
			$espaceDeNom = Configuration::getParametre("app", "appNamespace");
			// $espaceDeNom = str_replace("/", "\\", $espaceDeNom) . "\\";
			
			// $ctrl = $espaceDeNom . "\\" . $controleur . "\\" . $controleur . "Controleur";
			$ctrl = $espaceDeNom . "\\" . "Controleurs" . "\\" . $controleur . "Controleur";
			$ctrl = new $ctrl();
			
			$ctrl->setRequete($requete);
			$ctrl->setControleur($controleur);
			
			return $ctrl;
		}
		
		// Retourne l'action de la requete
		public function getAction(Requete $requete) {
			$action = "index";
			
			if($requete->existe("action")) {
				$action = $requete->get("action");
			}
			
			return $action;
		}
	}
	/* Fin de la définition de la classe. */
