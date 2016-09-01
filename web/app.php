<?php

	/*
	* app.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal du framework
	*
	*/
	
	// Importation de classe
	use MonFramework\AutoLoader;
	use MonFramework\MonFramework;
	
	$fichierAutoload = "../vendor/MonFramework/AutoLoader.php";
	
	if(DIRECTORY_SEPARATOR == "\\")
		$fichierAutoload = str_replace("/", DIRECTORY_SEPARATOR, $fichierAutoload);
	
	// Charge la fonction d'autochargement des classes du framework
	require_once($fichierAutoload);
	
	// Enregistrement des fonctions d'auto chargement.
	AutoLoader::enregistrement();
	
	// Chargement du framework
	MonFramework::chargement();
