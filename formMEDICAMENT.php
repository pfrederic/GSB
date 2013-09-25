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
include("./scripts/menuGauche.php");
if(isset($_POST['btActionFormRechercheMedicament']))
{//début if
	echo "coucou";
}
?>
<div id="contenu">
<?
//Création de la requête pour récupérer le nombre de médicament à afficher
$requete="select count(*) as nbMedic from MEDICAMENT";
$result=mysql_query($requete);
//on récupère le nombre de médicaments
if($ligne=mysql_fetch_array($result))
{
$nbMedic=$ligne['nbMedic'];
}
//on récupère le numéro du médicament contenu dans la variable session
$numMed=$_SESSION['numMed'];
//Si on appuye sur suivant et que le numéro du médicament est inférieur au nombre de médicament -1 alors
if(isset($_POST['suivant']) && $_SESSION['numMed']<$nbMedic-1)
{
	$numMed=$_SESSION['numMed'];
	$numMed=$numMed+1;
	$_SESSION['numMed']=$numMed;
}
//Si on appuye sur précédent et que le numéro du médicament est supérieur ou égale à 1 alors
if(isset($_POST['precedent']) && $_SESSION['numMed']>=1)
{
        $numMed=$_SESSION['numMed'];
	$numMed=$numMed-1;
	$_SESSION['numMed']=$numMed;
}
//Requête qui permet de récupérer les informations à afficher pour le seul médicament
$req="Select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL,FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT limit $numMed,1";
$resultat=mysql_query($req);
if($ligne=mysql_fetch_array($resultat))
{//début if
	//On récupère les informations des médicaments à afficher
	$depotLegal=$ligne['MED_DEPOTLEGAL'];
	$nomCommercial=$ligne['MED_NOMCOMMERCIAL'];
	$famille=$ligne['FAM_CODE'];
	$composition=$ligne['MED_COMPOSITION'];
	$effets=$ligne['MED_EFFETS'];
	$contrIndic=$ligne['MED_CONTREINDIC'];
	$prixEchantillon=$ligne['MED_PRIXECHANTILLON'];
}//fin if

//Puis on les affiches
?>
	<h1> Pharmacopee </h1>
	<form name="formRechercheMedicament" method="POST" action="">
	<p>Numero dépôt légal : <input type="text" name="inputDepotLegal" /></p>
	<p>Nom commercial : <input type="text" name="inputNomCommercial" /></p>
	<p>Famille : <input type="text" name="inputFamille" /></p>
	<p>Composition : <input type="text" name="inputComposition" /></p>
	<p><input type="submit" action="btActionFormRechercheMedicament" value="Rechercher" /></p>
	</form>
	<form name="formMEDICAMENT" method="post" action="">
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
