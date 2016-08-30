<?php

	/*
	* app.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal en mode production de mon framework
	*
	*/
	
	// Importation de la classe Kernel
	// use BlackFox\MonFramework\Kernel;
	
	// Charge la fonction d'autochargement des classes du framework
	require_once('../vendor/MonFramework/AutoLoad.php');
	
	// Chargement du coeur
	MonFramework::chargement();