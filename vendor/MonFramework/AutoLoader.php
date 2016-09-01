<?php

	/*
	* AutoLoader.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal en mode de devellopement de mon framework
	*
	*/
	
	// Définition de l'espace de nom
	namespace MonFramework;
	
	/* Définition de la classe */
	class AutoLoader {
		// Enregistre les fonctions d'auto chargement
		public function enregistrement() {
			spl_autoload_register(array(__CLASS__, 'frameworkAutoLoader'));
			spl_autoload_register(array(__CLASS__, 'applicationClassAutoLoader'));
		}
		
		// Charge automatiquement un classe du framework.
		public static function frameworkAutoLoader($classe) {
			$classe = str_replace("\\", DIRECTORY_SEPARATOR, $classe);
			
			$fichier = VENDOR . $classe . ".php";
			
			if(file_exists($fichier))
				require_once($fichier);
		}
		
		// Charge une classe controlleur ou un manager de l'application
		public static function applicationClassAutoLoader($classe) {
			$classe = str_replace("\\", DIRECTORY_SEPARATOR, $classe);
			
			$fichier = SRC . $classe . ".php";
			
			if(file_exists($fichier))
				require_once($fichier);
			else
				throw new \Exception("Impossible de charger le fichier de classe : '$classe'");
		}
		
	}
	/* Fin de la définition de la classe */
