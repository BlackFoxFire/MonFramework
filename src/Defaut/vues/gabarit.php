<!DOCTYPE html>

<html>
<!-- Début de la pade html -->
<!-- --------------------- -->

	<!-- En-tête de page -->
	<!-- --------------- -->
    <head>
		
		<!-- Jeu de caractère utilisé. -->
        <meta charset="utf-8" />
		<base href="<?= $appDir ?>" />
		
		<!-- Page de style css. -->
		<link rel="stylesheet" href="css/style.css" />
		
		<!-- Titre de la page. -->
        <title><?= $title ?></title>

    </head>

	<!-- Corp de la page. -->
	<!-- ---------------- -->
    <body>
		
		<div id="cadrePrincipal">
			
			<?= $contenu ?>
			
		</div>
		
    </body>
	<!-- Fin du corp de la page. -->
	<!-- ----------------------- -->

<!-- Fin de la page html. -->
<!-- -------------------- -->
</html>