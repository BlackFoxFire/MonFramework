<?php

/*
*
* Form.php
* @Auteur : Christophe Dufour
*
* 
*
*/

// Espace de nom.
namespace MonFramework;

/* Définition de la classe. */
class Form {
	
	// Teste si un élément du tableau $_POST existe.
	// Renvoie true s'il existe, sinon false.
	public function _isset($key) {
		return isset($_POST[$key]);
	}
	
	// Teste si un élément du tableau du *_POST est vide.
	// Renvoie true s'il est vide, sinon false.
	public function _empty($key) {
		return empty($_POST[$key]);
	}
	
	// Retourne la valeur d'un des éléments du tableau $_POST.
	// Si celui ci n'existe pas, c'est returnValue qui est renvoyé.
	public function get($key, $returnValue = false) {
		if($this->_isset($key))
			return $_POST[$key];
		
		return $returnValue;
	}
	
	// Teste si un formulaire a été envoyé.
	// Retourne true si c'est le cas, sinon false.
	public function submit() {
		return $this->_isset("submit");
	}
	
}
/* Fin de la classe. */
