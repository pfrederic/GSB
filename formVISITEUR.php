<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté
if ( ! estVisiteurConnecte() ) 
{
	header("Location:login.php");  
}

include("./scripts/entete.html");
include("./scripts/menuGauche.html");
?>
<div id="contenu">
	<form name="formVISITEUR" method="post" action="">
		<h1> Visiteurs </h1>
		<?
		// récupération des département
		// il faut faire la table DEPARTEMENT
		$req="Select DEP_CODE,DEP_NOM from VISITEUR natural join DEPARTEMENT order by DEP_NOM";
		echo $req;
		$resultat=mysql_query($req);
		?>
		<select name="lstDept" class="titre">
		<?
		while($ligne=mysql_fetch_array($resultat))
		{
		$nomDep=$ligne['DEP_NOM'];
		$codeDep=$ligne['DEP_CODE'];
		?>
		<option value="<?=$codeDep?>"><?=$nomDep?></option>
		<?
		}
		?>
		</select>
		<input type="submit" name="Selectionner" value="Selectionner"/>
		</form>
		<form action="" method="POST">
		<select name="lstVisiteur" class="zone"><option value=""></option></select>
		<label class="titre">NOM :</label><input type="text" size="25" name="VIS_NOM" class="zone" />
		<label class="titre">PRENOM :</label><input type="text" size="50" name="Vis_PRENOM" class="zone" />
		<label class="titre">ADRESSE :</label><input type="text" size="50" name="VIS_ADRESSE" class="zone" />
		<label class="titre">CP :</label><input type="text" size="5" name="VIS_CP" class="zone" />
		<label class="titre">VILLE :</label><input type="text" size="30" name="VIS_VILLE" class="zone" />
		<label class="titre">SECTEUR :</label><input type="text" size="1" name="SEC_CODE" class="zone" />
		<label class="titre">&nbsp;</label><input class="zone"type="button" value="<"></input><input class="zone"type="button" value=">"></input>
	</form>
	</div>
<?
include("./scripts/pied.html");
?>
