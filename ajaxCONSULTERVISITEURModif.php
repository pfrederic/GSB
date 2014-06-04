<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

$praCode=$_POST['lstPrat'];
$bool=false;
$i=0;
$req="update RAPPORT_VISITE set PRA_CODE=".$praCode.", RAP_DATEVISITE='".$_POST['dateVisite']."', RAP_BILAN='".$_POST['bilan']."', MOT_CODE='".$_POST['lstMotif']."', RAP_COEFCONFIANCE='".$_POST['coeffConfiance']."', RAP_DATESAISIE='".$_POST['dateSaisie']."', RAP_CONCURRENCE='".$_POST['lstConcurrence']."' where VIS_MATRICULE='".$_SESSION['login']."' and RAP_CODE=".$_POST['rapCode'];
//echo $req;
mysql_query($req);
while($bool==false)
{//début while
	if(isset($_POST['lstMedic'.$i]))
	{//début if
		$req="update PRESENTE set MED_DEPOTLEGAL='".$_POST['lstMedic'.$i]."', PRE_CONNAISSANCE=".$_POST['lstNoteMedic'.$i]." where MED_DEPOTLEGAL='".$_POST['hiddenMedic'.$i]."' and RAP_CODE=".$_POST['rapCode'];
		//echo $req;
		mysql_query($req);
	}//fin if
	else
	{//début else
		$bool=true;
	}//fin else
	$i++;
}//fin while
$bool=false;
$i=0;
while($bool==false)
{//début while
	//Si il y a des échantillons alors
	if(isset($_POST['lstEchantillon'.$i]))
	{//début if
		$req="update OFFRIR set MED_DEPOTLEGAL='".$_POST['lstEchantillon'.$i]."', OFF_QTE=".$_POST['qteEchantillon'.$i]." where VIS_MATRICULE='".$_SESSION['login']."' and RAP_CODE=".$_POST['rapCode']." and MED_DEPOTLEGAL='".$_POST['ancienEchantillon'.$i]."'";
		//echo $req;
		mysql_query($req);
	}//fin if
	else
	{//début else
		$bool=true;
	}//fin else
	$i++;
}//fin while
echo "<h3>Modification apportée avec succès</h3>";
?>