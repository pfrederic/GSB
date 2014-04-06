<?php
include("scripts/fonction.php");
// page inaccessible si visiteur non connecté
estVisiteurConnecte();

include("./scripts/entete.html");
include("./scripts/menuGauche.php");
?>
	
	<div id="contenu">
		<h2>Bienvenue sur l'intranet de GSB</h2>
	</div>
<?
include("./scripts/pied.html");
 //fin script
?>
