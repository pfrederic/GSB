<?php
include("./scripts/parametres.php");
include("./scripts/fonction.php");

$matriculeVisiteur=$_SESSION['login'];
$codeRapport=$_POST['inputCodeRap'];
$codePraticien=$_POST['lstPrat'];
$dateDeVisite=$_POST['inputDateVisite'];
$bilanDuRapport=$_POST['inputBilan'];
$motifDeVisite=$_POST['lstMotif'];
$coefficiantDeConfiance=$_POST['lstCoeff'];
$dateDuJour=date("Y-m-d");
$presenceConcurrence=$_POST['lstConcurrence'];
//Si on coche la case remplaçant
if(isset($_POST['checkBoxRemplacant']))
{//début if
	//On affiche dans le bilan que la visite a été réalisé par un remplaçant
	$bilanDuRapport.=" Visite réalisé auprès d'un remplacant (praticien absent)";
}//fin if

$bilanDuRapport=filtrerChainePourBD($bilanDuRapport);
//Requête qui permet d'insérer les informations récupérer dans la base de données
$req="insert into RAPPORT_VISITE(VIS_MATRICULE, RAP_CODE, PRA_CODE, RAP_DATEVISITE, RAP_BILAN, MOT_CODE, RAP_COEFCONFIANCE, RAP_DATESAISIE, RAP_CONCURRENCE) values('".$matriculeVisiteur."',".$codeRapport.",".$codePraticien.",'".$dateDeVisite."','".$bilanDuRapport."','".$motifDeVisite."',".$coefficiantDeConfiance.",'".$dateDuJour."','".$presenceConcurrence."');";
//echo $req;
mysql_query($req);
//boucle qui permet d'insérer les produits qui ont été présenté au cours de la visite dans la base de données
for($i=1;$i<3;$i++)
{//début for
	$produitPresente=$_POST['lstProd'.$i];
	$connaissanceProduitPresente=$_POST['lstNoteProd'.$i];
	if($produitPresente!='0')
	{//début if
		$req="insert into PRESENTE values('".$produitPresente."',".$codeRapport.",".$connaissanceProduitPresente.");";
		//echo $req;
		mysql_query($req);
	}//fin if
}//fin for

$bool=false;
$i=1;
//Boucle qui insère dans la base de données les informations sur les échantillons
while($bool==false)
{//début while
	//Si il y a des échantillons alors
	if(isset($_POST['lstEchantillon'.$i]))
	{//début if
		$codeEchantillon=$_POST['lstEchantillon'.$i];
		$quantiteEchantillon=$_POST['inputQteEchantillon'.$i];
		$req="insert into OFFRIR values('".$matriculeVisiteur."',".$codeRapport.",'".$codeEchantillon."',".$quantiteEchantillon.");";
		//echo $req;
		mysql_query($req);
	}//fin if
	else
	{//début else
		$bool=true;
	}//fin else
	$i++;
}//fin while
?>