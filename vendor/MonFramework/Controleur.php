<?php

	/*
	*
	* Controleur.php
	* @Auteur : Christophe Dufour
	*
	* Classe abstraite des controleurs
	* Fournit des services communs aux classes dérivées
	*
	*/
	
	// Définition de l'espace de nom
	namespace MonFramework;
	
	/* Définition de la classe. */
	abstract class Controleur {
		
		// Requete http
		protected $requete;
		
		// Objet de la session
		protected $session;
		
		// Action à exécuter
		protected $action;
		
		// Initialise l'attribut requete
		public function setRequete(Requete $requete) {
			$this->requete = $requete;
		}
		
		// Initialise l'attribut session
		public function setSession(Session $session) {
			$this->session = $session;
		}
		
		// Exécute la méthode de classe demandée si celle ci existe
		public function executerAction($action) {
			$action = $action . "Action";
			
			if(method_exists($this, $action)) {
				$this->action = str_replace("Action", "", $action);
				$this->$action();
			}
			else {
				$classe = get_class($this);
				throw new \Exception("Action '$action' non définie dans la classe '$classe'.");
			}
		}
		
		// Demande l'affichage d'une vue avec un moteur de template
		protected function render($donnees = array(), $genererFichier = true) {
			$controleur = get_class($this);
			
			$vue = new Vue($this->action, $controleur);
			$vue->render($donnees, $genererFichier);
		}
		
		// Redirige vers une autre page
		protected function rediriger($controleur, $action = null) {
			$appDir = Configuration::getParametre("app", "appDir", "");
			
			header("Location: " . $appDir . $controleur . "/" . $action);
		}
		
		// Méthode abstraite correspondant à laction par defaut
		public abstract function indexAction();
		
	}
	/* Fin de la définition de la classe. */
