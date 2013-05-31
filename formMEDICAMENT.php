<?session_start();
include "parametres.php";
if(!isset($_SESSION['numMed']))
{
$_SESSION['numMed']=0;
}
?>
<html>
<head>
	<title>formulaire MEDICAMENT</title>
	<style type="text/css">
		<!-- body {background-color: white; color:5599EE; } 
			label.titre { width : 180 ;  clear:left; float:left; } 
			.zone { width : 30car ; float : left; color:7091BB } -->
	</style>
</head>
<body>
<div name="haut" style="margin: 2 2 2 2 ;height:6%;"><h1><img src="logo.jpg" width="100" height="60"/>Gestion des visites</h1></div>
<div name="gauche" style="float:left;width:18%; background-color:white; height:100%;">
	<h2>Outils</h2>
	<ul><li>Comptes-Rendus</li>
		<ul>
			<li><a href="formRAPPORT_VISITE.php" >Nouveaux</a></li>
			<li>Consulter</li>
		</ul>
		<li>Consulter</li>
		<ul><li><a href="formMEDICAMENT.php" >Medicaments</a></li>
			<li><a href="formPRATICIEN.php" >Praticiens</a></li>
			<li><a href="formVISITEUR.php" >Autres visiteurs</a></li>
		</ul>
	</ul>
</div>
<div name="droite" style="float:left;width:80%;">
        <div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:88%;">

<?
$requete="select count(*) as nbMedic from MEDICAMENT";
$result=mysql_query($requete);
if($ligne=mysql_fetch_array($result))
{
$nbMedic=$ligne['nbMedic'];
}
$numMed=$_SESSION['numMed'];
if(isset($_POST['suivant']) && $_SESSION['numMed']<$nbMedic-1)
{
	$numMed=$_SESSION['numMed'];
	$numMed=$numMed+1;
	$_SESSION['numMed']=$numMed;
}
if(isset($_POST['precedent']) && $_SESSION['numMed']>=1)
{
        $numMed=$_SESSION['numMed'];
	$numMed=$numMed-1;
	$_SESSION['numMed']=$numMed;
}
$req="Select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL,FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT limit $numMed,1";
$resultat=mysql_query($req);
if($ligne=mysql_fetch_array($resultat))
{
$depotLegal=$ligne['MED_DEPOTLEGAL'];
$nomCommercial=$ligne['MED_NOMCOMMERCIAL'];
$famille=$ligne['FAM_CODE'];
$composition=$ligne['MED_COMPOSITION'];
$effets=$ligne['MED_EFFETS'];
$contrIndic=$ligne['MED_CONTREINDIC'];
$prixEchantillon=$ligne['MED_PRIXECHANTILLON'];
}
?>
	<form name="formMEDICAMENT" method="post" action="">
		<h1> Pharmacopee </h1>
		<label class="titre">DEPOT LEGAL :</label><input type="text" size="10" name="MED_DEPOTLEGAL" class="zone" value="<?=$depotLegal?>" />
		<label class="titre">NOM COMMERCIAL :</label><input type="text" size="25" name="MED_NOMCOMMERCIAL" class="zone" value="<?=$nomCommercial?>"/>
		<label class="titre">FAMILLE :</label><input type="text" size="3" name="FAM_CODE" class="zone" value="<?=$famille?>"/>
		<label class="titre">COMPOSITION :</label><textarea rows="5" cols="50" name="MED_COMPOSITION" class="zone" ><?=$composition?></textarea>
		<label class="titre">EFFETS :</label><textarea rows="5" cols="50" name="MED_EFFETS" class="zone" ><?=$effets?></textarea>
		<label class="titre">CONTRE INDIC. :</label><textarea rows="5" cols="50" name="MED_CONTREINDIC" class="zone" ><?=$contrIndic?></textarea>
		<label class="titre">PRIX ECHANTILLON :</label><input type="text" size="7" name="MED_PRIXECHANTILLON" class="zone" value="<?=$prixEchantillon?>"/> 
		<label class="titre">&nbsp;</label><input class="zone" type="submit" name="precedent" value="<"></input><input class="zone" type="submit" value=">" name="suivant"></input>
	</form>
	</div>
</div>
<?

?>
</body>
</html>
