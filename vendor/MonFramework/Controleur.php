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
		
		// Objet pour la gestion de la session.
		protected $session;
		
		// Objet pour la gestion des formulaires.
		protected $form;
		
		// Action à exécuter
		protected $action;
		
		// Le controleur
		protected $controleur;
		
		// Initialise l'attribut requete
		public function setRequete(Requete $requete) {
			$this->requete = $requete;
		}
		
		// Initialise l'attribut session
		public function setSession(Session $session) {
			$this->session = $session;
		}
		
		// Initialise l'attribut form.
		public function setForm() {
			$this->form = new Form;
		}
		
		public function setControleur($controleur) {
			$this->controleur = $controleur;
		}
		
		// Exécute la méthode de classe demandée si celle ci existe
		public function executerAction($action) {
			if(method_exists($this, $action . "Action")) {
				$this->action = $action;
				
				$action = $action . "Action";
				$this->$action();
			}
			else {
				$classe = get_class($this);
				throw new \Exception("Action '$action' non définie dans la classe '$classe'.");
			}
		}
		
		// Demande l'affichage d'une vue avec un moteur de template
		protected function render(array $donnees = array()) {
			$vue = new Vue($this->action, $this->controleur);
			$vue->render($donnees);
		}
		
		// Redirige vers une autre page
		protected function rediriger($controleur = null, $action = null) {
			if(is_null($controleur))
				header("Location: " . BASEHREF);
			else
				header("Location: " . BASEHREF . $controleur . "/" . $action);
			
			exit;
		}
		
		// Méthode abstraite correspondant à laction par defaut
		public abstract function indexAction();
		
	}
	/* Fin de la définition de la classe. */
