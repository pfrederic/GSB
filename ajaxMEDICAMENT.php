<?php
include("./scripts/parametres.php");
include("./scripts/fonction.php");

	$depotLegal=$_POST['inputDepotLegal'];
	$nomCommercial=$_POST['inputNomCommercial'];
	$familleMedicament=$_POST['inputFamille'];
	$compositionMedicament=$_POST['inputComposition'];
	$operateurPrix=$_POST['lstOperateur'];
	$prixEchantillon=$_POST['inputPrixEchantillon'];	
	if($operateurPrix!="" && $prixEchantillon=="")
	{//début if
		echo "<h3>Vous n'avez pas saisi de prix</h3>";
	}//fin if
	else
	{//début else
		if($operateurPrix=='>')
		{//début if
			$requeteRechercheMedicament="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL like '%".$depotLegal."%' and MED_NOMCOMMERCIAL like '%".$nomCommercial."%' and FAM_CODE like '%".$familleMedicament."%' and MED_COMPOSITION like '%".$compositionMedicament."%' and MED_PRIXECHANTILLON >".$prixEchantillon.";";
			//echo $requeteRechercheMedicament;
		}//fin if
		elseif($operateurPrix=='=')
		{//début elseif
			$requeteRechercheMedicament="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL like '%".$depotLegal."%' and MED_NOMCOMMERCIAL like '%".$nomCommercial."%' and FAM_CODE like '%".$familleMedicament."%' and MED_COMPOSITION like '%".$compositionMedicament."%' and MED_PRIXECHANTILLON =".$prixEchantillon.";";
			//echo $requeteRechercheMedicament;
		}//fin elseif
		elseif($operateurPrix=='<')
		{//début elseif
			$requeteRechercheMedicament="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL like '%".$depotLegal."%' and MED_NOMCOMMERCIAL like '%".$nomCommercial."%' and FAM_CODE like '%".$familleMedicament."%' and MED_COMPOSITION like '%".$compositionMedicament."%' and MED_PRIXECHANTILLON < ".$prixEchantillon.";";
			//echo $requeteRechercheMedicament;
		}//fin elseif
		else
		{//début else
			$requeteRechercheMedicament="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL like '%".$depotLegal."%' and MED_NOMCOMMERCIAL like '%".$nomCommercial."%' and FAM_CODE like '%".$familleMedicament."%' and MED_COMPOSITION like '%".$compositionMedicament."%';";
			//echo $requeteRechercheMedicament;
		}//fin else
		$resultatRechercheMedicament=mysql_query($requeteRechercheMedicament);
		$tabRechercheMedicament=mysql_fetch_array($resultatRechercheMedicament);
		if(empty($tabRechercheMedicament))
		{//début if
			echo "<h3>Aucun médicament correspondant à vos critères</h3>";
		}//fin if
		else
		{//début else
			$resultatRechercheMedicament=mysql_query($requeteRechercheMedicament);
			while($tabRechercheMedicament=mysql_fetch_array($resultatRechercheMedicament))
			{//début while
			?>
				<form name="formMEDICAMENT" method="post" action="">
				<table>
				<tr>
				<th>DEPOT LEGAL :</th><td><input type="text" size="10" name="MED_DEPOTLEGAL" class="zone" value="<?=$tabRechercheMedicament['MED_DEPOTLEGAL']?>" /></td>
				</tr>
				<tr>
				<th>NOM COMMERCIAL :</th><td><input type="text" size="25" name="MED_NOMCOMMERCIAL" class="zone" value="<?=$tabRechercheMedicament['MED_NOMCOMMERCIAL']?>"/></td>
				</tr>
				<tr>
				<th>FAMILLE :</th><td><input type="text" size="3" name="FAM_CODE" class="zone" value="<?=$tabRechercheMedicament['FAM_CODE']?>"/></td>
				</tr>
				<tr>
				<th>COMPOSITION :</th><td><textarea rows="5" cols="50" name="MED_COMPOSITION" class="zone" ><?=$tabRechercheMedicament['MED_COMPOSITION']?></textarea></td>
				</tr>
				<tr>
				<th>EFFETS :</th><td><textarea rows="5" cols="50" name="MED_EFFETS" class="zone" ><?=$tabRechercheMedicament['MED_EFFETS']?></textarea></td>
				</tr>
				<tr>
				<th>CONTRE INDIC. :</th><td><textarea rows="5" cols="50" name="MED_CONTREINDIC" class="zone" ><?=$tabRechercheMedicament['MED_CONTREINDIC']?></textarea></td>
				</tr>
				<tr>
				<th>PRIX ECHANTILLON :</th><td><input type="text" size="7" name="MED_PRIXECHANTILLON" class="zone" value="<?=$tabRechercheMedicament['MED_PRIXECHANTILLON']?>"/></td>
				</tr>
				</table>
				</form>
				<?
			}//fin while
		}//fin else
	}//fin else
?>