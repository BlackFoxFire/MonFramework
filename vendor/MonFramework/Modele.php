<?php

	/*
	*
	* Manager.php
	* @Auteur : Christophe Dufour
	*
	* Classe abstraite manager
	* Centralise les services d'accès à une base de données
	*
	*/
	
	// Définition de l'espace de nom
	namespace MonFramework;
	
	/* Définition de la classe. */
	abstract class Modele {
		
		// Lien vers la base de données
		private static $bdd;
		
		// Initialise la connexion vers la base de données
		static private function getBdd() {
			if(self::$bdd === null) {
				$dsn = Configuration::getParametre("bdd", "dsn");
				$login = Configuration::getParametre("bdd", "login");
				$password = Configuration::getParametre("bdd", "password");
				
				self::$bdd = new \PDO($dsn, $login, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
			}
			
			return self::$bdd;
		}
		
		// 
		protected function executerRequete($sql, $parametres = null) {
			if($parametres == null) {
				$resultat = self::getBdd()->query($sql);
			}
			else {
				$resultat = self::getBdd()->prepare($sql);
				$resultat->execute($parametres);
			}
			
			return $resultat;
		}
		
	}
	/* Fin de la définition de la classe. */
