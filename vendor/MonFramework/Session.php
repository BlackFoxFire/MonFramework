<?php

/*
*
* Session.php
* @Auteur : Christophe Dufour
*
* Classe modélisant une session.
* Permet des actions courantes sur les sessions et leurs variables.
*
*/

// Espace de nom.
namespace MonFramework;

/* Définition de la classe. */
class Session {
	
	// Démarre ou restaure un session.
	public function __construct() {
		session_start();
	}
	
	// Détruit la session actuelle.
	public function destroy() {
		session_destroy();
	}
	
	// Teste si une variable de session existe.
	// Renvoie true s'il existe, sinon false.
	public function _isset($key) {
		return isset($_SESSION[$key]);
	}
	
	// Teste si une variable de session est vide.
	// Renvoie true s'il est vide, sinon false.
	public function _empty($key) {
		return empty($_SESSION[$key]);
	}
	
	// Ajoute ou modifie une variable de session.
	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	// Renvoie la valeur d'une variable de session.
	// Si celui ci n'existe pas, c'est returnValue qui est renvoyé.
	public function get($key, $returnValue = false) {
		if($this->_isset($key))
			return $_SESSION[$key];
		
		return $returnValue;
	}
	
}
/* Fin de la classe. */
