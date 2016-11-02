<?php

	/*
	*
	* Vue.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant une vue
	*
	*/
	
	// Définition de l'espace de nom
	namespace MonFramework;
	
	// Importation
	use Foxy\Foxy;
	
	/* Définition de la classe. */
	class Vue {
		
		// Chemin vers le fichier contenant la vue à afficher
		private $fichier;
		private $path;
		
		// Controleur de classe
		public function __construct($action, $controleur = null) {
			$path = Configuration::getParametre("app", "appNamespace");
			$path = str_replace('\\', DS, $path);
			
			$this->path[] = SRC . $path . DS . "Ressources" . DS . "Vues" . DS;
			
			if(!is_null($controleur)) {
				$this->path[] = $this->path[0] . $controleur . DS;
			}
			
			$this->fichier = $action . ".html";
		}
		
		// Génère et affiche la vue
		public function render($donnees, $genererFichier = true) {
			$donnees['appDir'] = Configuration::getParametre("app", "appDir");
			
			$loader = new \Twig_Loader_Filesystem($this->path);
			$twig = new \Twig_Environment($loader, array('cache' => false));
			
			echo $twig->render($this->fichier, $donnees);
		}
		
	}
	/* Fin de la définition de la classe. */
