<?php

	/*
	*
	* Configuration.php
	* @Auteur : Christophe Dufour
	*
	* Classe de gestion de paramatres de configuration
	*
	*/
	
	// Définition de l'espace de nom
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	class Configuration {
		
		// Tableau des paramètres de configuration de l'application
		private static $parametres;
		
		// Retourne la valeur d'un parametre
		public static function getParametre($section, $nom, $valeurParDefaut = null) {
			if(isset(self::LoadParametres()[$section][$nom]))
				$valeur = self::$parametres[$section][$nom];
			else
				$valeur = $valeurParDefaut;
			
			return $valeur;
		}
		
		// Charge le fichier des paramètres de configuration de l'application
		private static function loadParametres() {
			if(is_null(self::$parametres)) {
				$fichier = "../app/app.ini";
				
				if(!file_exists($fichier))
					throw new Exception("Aucune fichier de configuration trouvé !");
				else
					self::$parametres = parse_ini_file($fichier, true, INI_SCANNER_RAW);
			}
			
			return self::$parametres;
		}
	}
	/* Fin de la définition de la classe. */
