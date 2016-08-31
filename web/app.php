<?php

	/*
	* app.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal en mode production de mon framework
	*
	*/
	
	// Importation de la classe MonFramework
	use BlackFox\MonFramework\AutoLoader;
	use BlackFox\MonFramework\MonFramework;
	
	// Charge la fonction d'autochargement des classes du framework
	require_once('../vendor/MonFramework/AutoLoad.php');
	AutoLoader::enregistrement();
	
	// Chargement du coeur
	MonFramework::chargement();