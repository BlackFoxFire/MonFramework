<?php

/*
*
* Requete.php
* @Auteur : Christophe Dufour
*
* Classe modélisant une requête HTTP entrante.
*
*/

// Espace de nom
namespace MonFramework;

/* Début de la classe. */
class Requete {
	
	// Teste si un élément du tableau $_GET existe.
	// Renvoie true s'il existe, sinon false.
	public function _isset($key) {
		return isset($_GET[$key]);
	}
	
	// Teste si un élément du tableau du *_GET est vide.
	// Renvoie true s'il est vide, sinon false.
	public function _empty($key) {
		return empty($_GET[$key]);
	}
	
	// Teste si un élément du tableau $_GET existe.
	// Renvoie true s'il existe, sinon false.
	public function existe($nom) {
		return(isset($_GET[$nom]) && $_GET[$nom] != "");
	}
	
	// Retourne la valeur d'un des éléments du tableau $_GET.
	public function get($nom) {
		if($this->existe($nom))
			return $_GET[$nom];
		
		throw new \Exception("Parametre $nom absent de la requête.");
	}
	
}
/* Fin de la classe. */
