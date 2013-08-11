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
		$_SESSION['login']=$idUser;
		header('location:index.php');	
	}//fin if
	else
	{
		echo("Problème de connexion");
	}
}

/** 
 * Vérifie si un visiteur s'est connecté sur le site.                     
 *
 * Retourne true si un visiteur s'est identifié sur le site, false sinon. 
 * @return boolean échec ou succès
 */
function estVisiteurConnecte() {
    // actuellement il n'y a que les visiteurs qui se connectent
    return isset($_SESSION["login"]);
}

/**
 * Déconnecte le visiteur, quand celui-ci le souhaite
 * 
 * @void
*/
function deconnexion()
{
	session_destroy();

	header('Location:login.php');
}

/**
 * Fonction qui génère les opitions d'une liste déroulante de tous les
 * praticiens de la base de données
 * 
 * return @void
*/
function optionListDerPraticien()
{
	$req="select PRA_CODE, PRA_NOM from PRATICIEN order by PRA_NOM;";
	$resultat=mysql_query($req);
	?>
	<option>Choisissez un praticien</option>
	<?
	while($ligne=mysql_fetch_array($resultat))
	{
		$codePrat=$ligne['PRA_CODE'];
		?>
		<option value="<?=$codePrat?>"><?=$ligne['PRA_NOM'];?></option>
		<?
	}
}

/**
 * Fonction qui génère les options d'une liste déroulante de tous les
 * médicament de la base de données
 * 
 * return @void
*/
function optionListDerMedicament()
{
	$req="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL from MEDICAMENT;";
	$resultat=mysql_query($req);
	?>
	<option>Choisissez un médicament</option>
	<?
	while($ligne=mysql_fetch_array($resultat))
	{
		$codeMedoc=$ligne['MED_DEPOTLEGAL'];
		?>
		<option value="<?=$codeMedoc?>"><?=$ligne['MED_NOMCOMMERCIAL'];?></option>
		<?
	}
}
?>
