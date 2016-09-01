<?php

	/*
	* AutoLoader.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal en mode de devellopement de mon framework
	*
	*/
	
	// Définition de l'espace de nom
	namespace BlackFox\MonFramework;
	
	define("DS", DIRECTORY_SEPARATOR);
	
	define("ROOT", ".." . DS);
	define("SRC", ROOT . "src" . DS);
	
	/* Définition de la classe */
	class AutoLoader {
		// Enregistre les fonctions d'auto chargement
		public function enregistrement() {
			spl_autoload_register(array(__CLASS__, 'frameworkAutoLoader'));
			spl_autoload_register(array(__CLASS__, 'applicationClassAutoLoader'));
		}
		
		// Charge automatiquement un classe du framework.
		public static function frameworkAutoLoader($classe) {
			$classe = str_replace("BlackFox\\MonFramework\\", "", $classe);
			
			if(file_exists(__DIR__ . "/" . $classe . ".php"))
				require_once(__DIR__ . "/" . $classe . ".php");
		}
		
		// Charge une classe controlleur ou un manager de l'application
		public static function applicationClassAutoLoader($classe) {
			$appSrc = str_replace("/", "", Configuration::getParametre("app", "appSrc"));
			
			if(self::isControleur($classe)) {
				$classe = str_replace("\\", DIRECTORY_SEPARATOR, $classe);
				
				$fichier = SRC . $classe . ".php";
				
				if(file_exists($fichier)) {
					require_once($fichier);
					return true;
				}
			}
			
			if(self::isManager($classe)) {
				$dossier = strtolower(str_replace('Manager', "", $classe));
				
				$fichier = SRC . $appSrc . DS . $dossier . '/modele/' . $classe . ".php";
				
				if(file_exists($fichier)) {
					require_once($fichier);
					return true;
				}
			}
			
			if(self::isClasse($classe)) {
				$dossier = strtolower($classe);
				
				$fichier = SRC . $appSrc . DS . $dossier . '/classe/' . $classe . ".php";
				
				if(file_exists($fichier)) {
					require_once($fichier);
					return true;
				}
			}
			
			throw new \Exception("Impossible de charger le fichier de classe : '$classe'");
		}
		
		// Retourne true si c'est une controleur
		private static function isControleur($classe) {
			$motif = "#Controleur$#";
			
			return preg_match($motif, $classe);
		}
		
		// Retourne true si c'est un manager
		private static function isManager($classe) {
			$motif = "#Manager$#";
			
			return preg_match($motif, $classe);
		}
		
		// Retourne true si c'est une simple classe
		private static function isClasse($classe) {
			$motif = "#Controleur|Manager$#";
			
			return !preg_match($motif, $classe);
		}
	}
	/* Fin de la définition de la classe */
