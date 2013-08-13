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
	<option value="0">Choisissez un médicament</option>
	<?
	while($ligne=mysql_fetch_array($resultat))
	{//début while
		$codeMedoc=$ligne['MED_DEPOTLEGAL'];
		?>
		<option value="<?=$codeMedoc?>"><?echo $ligne['MED_NOMCOMMERCIAL'];?></option>
		<?
	}//fin while
}

/** 
 * Fonction qui génére les options d'une liste déroulante
 * qui contient des valeurs numérique allant de 0 à 20.
 * Ces options serviront notament pour noter le praticien sur 
 * la connaissance du produit en autre.
 * 
 * return @void
*/
function optionDerNumerique()
{
	for($i=0;$i<21;$i++)
	{//début for
		?>
		<option value="<?=$i?>" ><?echo $i;?></option>
		<?
	}//fin for
}

/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
 * @param $date au format  jj/mm/aaaa
 * @return string la date au format anglais aaaa-mm-jj
*/
function convertirDateFrancaisVersAnglais($date){
	@list($jour,$mois,$annee) = explode('/',$date);
	return date("Y-m-d", mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format 
 * français jj/mm/aaaa 
 * @param $date au format  aaaa-mm-jj
 * @return string la date au format format français jj/mm/aaaa
*/
function convertirDateAnglaisVersFrancais($date){
    @list($annee,$mois,$jour) = explode('-',$date);
	return date("d/m/Y", mktime(0, 0, 0, $mois, $jour, $annee));
}
?>
