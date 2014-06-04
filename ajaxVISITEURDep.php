<?php
include("./scripts/parametres.php");
include("./scripts/fonction.php");
?>
<form name="formChoixVisiteur" id="ajaxFormVisiteur">
	<select name="lstVisiteur" class="zone" id="visiteur">
	<option values="" selected></option>
	<?
	$req="select VIS_MATRICULE, VIS_NOM, VIS_PRENOM from VISITEUR where DEP_CODE='".$_POST['lstDept']."';";
	//echo $req;
	$resultat=mysql_query($req);
	while($maLigne=mysql_fetch_array($resultat))
	{//début while
		?>
		<option value="<?=$maLigne["VIS_MATRICULE"];?>"><?echo $maLigne["VIS_NOM"]." ".$maLigne["VIS_PRENOM"];?></option>
		<?
	}//fin while
	?>
	</select>
</form>