<?php

	/*
	* app.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal du framework
	*
	*/
	
	// Importation de classe
	use MonFramework\MonFramework;
	
	define("DS", DIRECTORY_SEPARATOR);
	define("ROOT", dirname(__DIR__) . DS);
	define("VENDOR", ROOT . "vendor" . DS);
	
	// Charge la fonction d'autochargement des classes du framework
	require_once(VENDOR . "MonFramework" . DS . "AutoLoader.php");
	
	// Enregistrement des fonctions d'auto chargement.
	AutoLoader::enregistrement();
		
	// Chargement du framework
	MonFramework::chargement();
