<?php

	/*
	*
	* Kernel.php
	* @Auteur : Christophe Dufour
	*
	* Coeur du framework.
	* Intéroge le router pour lancer la bonne action d'un controleur.
	*
	*/
	
	// Définition de l'espace de nom
	namespace MonFramework;
	
	/* Définition de la classe. */
	class MonFramework {
		
		// Chargement du framework
		public static function chargement() {
			try {
				$session = new Session;
				
				$requete = new Requete(array_merge($_GET, $_POST));
				$routeur = new Routeur();
				
				$controleur = $routeur->getControleur($requete);
				$action  = $routeur->getAction($requete);
				
				$controleur->setSession($session);
				$controleur->executerAction($action);
			}
			catch(\Exception $exception) {
				$vue = new Vue("erreur");
				$vue->render(array('messageErreur' => $exception->getMessage()));
			}
		}
		
	}
	/* Fin de la définition de la classe. */
