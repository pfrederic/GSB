<?php
session_start();
include "parametres.php";

/*
 * Fonction qui permet de s'assurer de l'identité de la
 * personne qui essaie de se connecter.
 * @param $idUser
 * @param $mdpUser
*/
function authentification($idUser, $mdpUser)
{
	$req="select VIS_MATRICULE, VIS_MDP, VIS_GRAINSEL from VISITEUR where VIS_MATRICULE='".$idUser."';";
	$resultat=mysql_query($req);
	$maLigne=mysql_fetch_array($resultat);
	$mdpUser.=$maLigne["VIS_GRAINSEL"];
	$mdpUser=md5($mdpUser);

	if($mdpUser==$maLigne["VIS_MDP"])
	{//début if
		header('location:index.html');	
	}//fin if
	else
	{
		echo("Problème de connexion");
	}
}

?>
