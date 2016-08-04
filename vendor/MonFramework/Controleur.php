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
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	abstract class Controleur extends MonFramework {
		
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
				$this->action = $action;
				$this->$action();
			}
			else {
				$classe = get_class($this);
				throw new Exception("Action '$action' non définie dans la classe '$classe'.");
			}
		}
		
		// Demande l'affichage d'un vue
		protected function genererVue($donnees = array()) {
			$controleur = get_class($this);
			$controleur = strtolower(str_replace("Controleur", "", $controleur));
			
			$vue = new Vue($this->action, $controleur);
			$vue->generer($donnees);
		}
		
		// Demande l'affichage d'un vue un utilisant le moteur de template
		protected function render($donnees = array()) {
			$controleur = get_class($this);
			$controleur = strtolower(str_replace("Controleur", "", $controleur));
			
			$vue = new Vue($this->action, $controleur);
			$vue->render($donnees);
		}
		
		// Redirige vers une autre page
		protected function rediriger($controleur, $action = null) {
			$appDir = Configuration::getConfig('appDir');
			
			header("Location: " . $appDir . $controleur . "/" . $action);
		}
		
		// Méthode abstraite correspondant à laction par defaut
		public abstract function indexAction();
		
	}
	/* Fin de la définition de la classe. */
