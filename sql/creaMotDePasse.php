<?php
	
	$host="127.0.0.1";
	$user="technicien";
	$mdp="ini01";
	$db="db_gestionCR";
	mysql_connect($host,$user,$mdp);
	mysql_select_db($db);

$req="select VIS_MATRICULE from VISITEUR";
$resultat=mysql_query($req);
while($maLigne=mysql_fetch_array($resultat))
{//début while
	$nbAleatoire=rand(0,10000000000);
	$motDePasse="ini".$nbAleatoire;
	echo $motDePasse;
	$hashMotDePAsse=md5($motDePasse);
	mysql_query("update VISITEUR set VIS_MDP='".$hashMotDePAsse."', VIS_GRAINSEL='".$nbAleatoire."' where VIS_MATRICULE='".$maLigne["VIS_MATRICULE"]."';");
}//fin while
?>
