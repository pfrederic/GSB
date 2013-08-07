<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté
if ( ! estVisiteurConnecte() ) 
{
	header("Location:login.php");  
}

if(!isset($_SESSION['numMed']))
{
	$_SESSION['numMed']=0;
}
include("./scripts/entete.html");
?>
<div id="menuGauche">
<h2>Gestion des visites</h2>
<h3>Outils</h3>
	<ul id="menuListTitle">Comptes-Rendus</ul>
		<ul id="menuList">
			<li><a href="formRAPPORT_VISITE.php" >Nouveaux</a></li>
			<li>Consulter</li>
		</ul>
		<ul id="menuListTitle">Consulter</ul>
		<ul id="menuList"><li><a href="formMEDICAMENT.php" >Medicaments</a></li>
			<li><a href="formPRATICIEN.php" >Praticiens</a></li>
			<li><a href="formVISITEUR.php" >Autres visiteurs</a></li>
		</ul>
</div>
<div id="contenu">
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
		<table>
		<tr>
		<th>DEPOT LEGAL :</th><td><input type="text" size="10" name="MED_DEPOTLEGAL" class="zone" value="<?=$depotLegal?>" /></td>
		</tr>
		<tr>
		<th>NOM COMMERCIAL :</th><td><input type="text" size="25" name="MED_NOMCOMMERCIAL" class="zone" value="<?=$nomCommercial?>"/></td>
		</tr>
		<tr>
		<th>FAMILLE :</th><td><input type="text" size="3" name="FAM_CODE" class="zone" value="<?=$famille?>"/></td>
		</tr>
		<tr>
		<th>COMPOSITION :</th><td><textarea rows="5" cols="50" name="MED_COMPOSITION" class="zone" ><?=$composition?></textarea></td>
		</tr>
		<tr>
		<th>EFFETS :</th><td><textarea rows="5" cols="50" name="MED_EFFETS" class="zone" ><?=$effets?></textarea></td>
		</tr>
		<tr>
		<th>CONTRE INDIC. :</th><td><textarea rows="5" cols="50" name="MED_CONTREINDIC" class="zone" ><?=$contrIndic?></textarea></td>
		</tr>
		<tr>
		<th>PRIX ECHANTILLON :</th><td><input type="text" size="7" name="MED_PRIXECHANTILLON" class="zone" value="<?=$prixEchantillon?>"/></td>
		</tr>
		</table>
		<input class="zone" type="submit" name="precedent" value="<"></input><input class="zone" type="submit" value=">" name="suivant"></input>
	</form>
</div>
<?
include("./scripts/pied.html");
?>
