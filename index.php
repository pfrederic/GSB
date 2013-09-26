<?php
include("scripts/fonction.php");
// page inaccessible si visiteur non connecté
if ( ! estVisiteurConnecte() ) 
{
	header('location: https://127.0.0.1/GSB/login.php');
}

include("./scripts/entete.html");
include("./scripts/menuGauche.php");
?>
	
	<div id="contenu">
		<h2>bienvenue sur l'intranet de GSB</h2>
	</div>
<?
include("./scripts/pied.html");
 //fin script
?>
