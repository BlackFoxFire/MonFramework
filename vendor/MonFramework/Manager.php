<?php

	/*
	*
	* Manger.php
	* @Auteur : Christophe Dufour
	*
	* Classe abstraite manager
	* Centralise les services d'accès à une base de données
	*
	*/
	
	// Définition de l'espace de nom
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	abstract class Manager extends MonFramework {
		
		// Lien vers la base de données
		private static $bdd;
		
		// Initialise la connexion vers la base de données
		static private function getBdd() {
			if(self::$bdd === null) {
				$dsn = Configuration::getParametre('dsn');
				$login = Configuration::getParametre("login");
				$password = Configuration::getParametre("password");
				
				self::$bdd = new PDO($dsn, $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			
			return self::$bdd;
		}
		
		// Retourne le nombre de ligne dans un table
		public function count() {
			$resultat = self::getBdd()->query("select * from $this->table");
			
			$nombreDeLigne = $resultat->rowCount();
			$resultat->closeCursor();
			
			return $nombreDeLigne;
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
		
		//
		// abstract public function save();
		
		// 
		// abstract public function read();
		
		//
		// abstract public function delete();
		
		// 
		// abstract protected function add();
		
		// 
		// abstract protected function update();
		
	}
	/* Fin de la définition de la classe. */
