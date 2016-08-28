<?php

	/*
	* AutoLoader.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal en mode de devellopement de mon framework
	*
	*/
	
	// namespace BlackFox\MonFramework;
	
	// use BlackFox\MonFramework\Configuration;
	
	/* Définition de la classe */
	class AutoLoader {
		
		// Charge automatiquement un classe du framework.
		public static function frameworkAutoLoader($classe) {
			// $classe = str_replace("BlackFox\\MonFramework\\", "", $classe);
			
			if(file_exists(__DIR__ . "/$classe" . '.php')) {
				require_once(__DIR__ . "/$classe" . '.php');
			}
		}
		
		// Charge une classe controlleur ou un manager de l'application
		public static function applicationClassAutoLoader($classe) {
			if(self::isControleur($classe)) {
				$dossier = strtolower(str_replace('Controleur', "", $classe));
				
				$fichier = "../src/" . $dossier . '/' . $classe . ".php";
				
				if(file_exists($fichier)) {
					require_once($fichier);
					return true;
				}
			}
			
			if(self::isManager($classe)) {
				$dossier = strtolower(str_replace('Manager', "", $classe));
				
				$fichier = "../src/" . $dossier . '/modele/' . $classe . ".php";
				
				if(file_exists($fichier)) {
					require_once($fichier);
					return true;
				}
			}
			
			if(self::isClasse($classe)) {
				$dossier = strtolower($classe);
				
				$fichier = "../src/" . $dossier . '/classe/' . $classe . ".php";
				
				if(file_exists($fichier)) {
					require_once($fichier);
					return true;
				}
			}
			
			throw new Exception("Impossible de charger le fichier de classe : '$classe'");
		}
		
		// Retourne true si c'est une controleur
		private static function isControleur($classe) {
			$motif = "#Controleur#";
			
			return preg_match($motif, $classe);
		}
		
		// Retourne true si c'est un manager
		private static function isManager($classe) {
			$motif = "#Manager#";
			
			return preg_match($motif, $classe);
		}
		
		// Retourne true si c'est une simple classe
		private static function isClasse() {
			$motif = "#Controleur|Manager#";
			
			return !preg_match($motif, $classe);
		}
	}
	/* Fin de la définition de la classe */
	
	/* Enregistrement des fonctions d'auto chargement */
	// spl_autoload_register('BlackFox\MonFramework\AutoLoader::frameworkAutoLoader');
	spl_autoload_register('AutoLoader::frameworkAutoLoader');
	// spl_autoload_register('BlackFox\MonFramework\AutoLoader::applicationClassAutoLoader');
	spl_autoload_register('AutoLoader::applicationClassAutoLoader');
