<?php

	/*
	* AutoLoader.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal en mode de devellopement de mon framework
	*
	*/
	
	/* Définition de la classe */
	class AutoLoader {
		// Enregistre les fonctions d'auto chargement
		public function enregistrement() {
			spl_autoload_register(array(__CLASS__, 'frameworkAutoLoader'));
			spl_autoload_register(array(__CLASS__, 'applicationClassAutoLoader'));
			
			self::inclusionExterne();
		}
		
		// Inclusion des librairies externes au framework
		private function inclusionExterne() {
			// Moteur de template Twig
			require_once(VENDOR . DS . "Twig" . DS . "lib" . DS . "Twig" . DS . "Autoloader.php");
			// Enregistrement de l'auto-chargement de Twig
			\Twig_Autoloader::register();
		}
		
		// Charge automatiquement un classe du framework.
		private static function frameworkAutoLoader($classe) {
			$classe = str_replace("\\", DIRECTORY_SEPARATOR, $classe);
			
			$fichier = VENDOR . $classe . ".php";
			
			if(file_exists($fichier))
				require_once($fichier);
		}
		
		// Charge une classe controlleur ou un manager de l'application
		private static function applicationClassAutoLoader($classe) {
			$classe = str_replace("\\", DIRECTORY_SEPARATOR, $classe);
			
			$fichier = SRC . $classe . ".php";
			
			if(file_exists($fichier))
				require_once($fichier);
		}
		
	}
	/* Fin de la définition de la classe */
