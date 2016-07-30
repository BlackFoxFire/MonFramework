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
	class Configuration extends MonFramework {
		
		// Tableau de la configuration de l'application.
		// Contient les modules autorisés et disponibles 
		// suivant l'environnement de travail
		private static $config;
		
		// Tableau des paramètres de la base de données
		private static $parametresBdd;
		
		public static function getConfig($config, $valeurParDefaut) {
			if(isset(self::$config['app'][$config])) {
				return self::$config['app'][$config];
			}
			
			return $valeurParDefaut;
		}
		
		// Vérifie si un module est présent
		public static function moduleExiste($module) {
			if(is_null(self::$config))
				self::loadConfig();
			
			// foreach(self::$config[self::setEnvironnement()] as $key => $valeur) {
			foreach(self::$config[self::$environnement] as $key => $valeur) {
				if(strcasecmp($key, $module) == 0)
					return true;
			}
			
			return false;
		}
		
		// Routourne le module par defaut
		public static function moduleParDefaut() {
			if(is_null(self::$config))
				self::loadConfig();
			
			// if($module = array_search('defaut', self::$config[self::setEnvironnement()]))
			if($module = array_search('defaut', self::$config[self::$environnement]))
				return $module;
			else
				throw new Exception("Aucun module n'est marqué par defaut.");
		}
		
		// Charge le fichier des modules autorisés/disponibles
		private static function loadConfig() {
			$fichier = "../app/app.ini";
			
			if(file_exists($fichier))
				self::$config = parse_ini_file($fichier, true, INI_SCANNER_RAW);
			else
				// exit("Fichier de configuration manquant : '" . basename($fichier) . "'.");
				throw new Exception("Fichier de configuration manquant : '" . basename($fichier) . "'.");
			
			return self::$config;
		}
		
		// Retourne la valeur d'un parametre
		public static function getParametre($nom, $valeurParDefaut = null) {
			if(isset(self::loadParametres()[$nom]))
				$valeur = self::LoadParametres()[$nom];
			else
				$valeur = $valeurParDefaut;
			
			return $valeur;
		}
		
		// Charge le fichier des paramètres pour la base de données
		private static function loadParametres() {
			/*if(self::$parametres == null) {
				$fichier = "../app/dev.ini";
				
				if(!file_exists($fichier))
					$fichier = "../app/prod.ini";
				
				if(!file_exists($fichier))
					throw new Exception("Aucune fichier de configuration trouvé !");
				else
					self::$parametres = parse_ini_file($fichier);
			}*/
			
			if(self::$parametresBdd == null) {
				if(self::setEnvironnement() == 'dev')
					$fichier = "../app/dev.ini";
				elseif (self::setEnvironnement() == 'prod')
					$fichier = "../app/prod.ini";
				else
					throw new Exception("Mauvais paramètre d'environnement !");
				
				if(file_exists($fichier))
					self::$parametresBdd = parse_ini_file($fichier);
				else throw new Exception("Aucune fichier de configuration trouvé !");
			}
			
			return self::$parametresBdd;
		}
	}
	/* Fin de la définition de la classe. */
