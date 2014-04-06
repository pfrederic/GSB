<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté
estVisiteurConnecte();

if(!isset($_SESSION['numMed']))
{
	$_SESSION['numMed']=0;
}

include("./scripts/entete.html");
include("./scripts/menuGauche.php");
?>
<div id="contenu">
	<h1> Pharmacopee </h1>
	<form name="formRechercheMedicament" method="POST" action="">
	<p>Numero dépôt légal : <input type="text" name="inputDepotLegal" /></p>
	<p>Nom commercial : <input type="text" name="inputNomCommercial" /></p>
	<p>Famille : <input type="text" name="inputFamille" /></p>
	<p>Composition : <input type="text" name="inputComposition" />
	<p>Prix echantillon : <select name="lstOperateur">
				<option value=""></option>
				<option value=">">Prix superieur à</option>
				<option value="=">Prix egale à</option>
				<option value="<">Prix inferieur à</option>
			      </select>
	<input type="text" name="inputPrixEchantillon" /></p>
	<p><input type="submit" name="btActionFormRechercheMedicament" value="Rechercher" /></p>
	</form>
	<?
	if(isset($_POST['btActionFormRechercheMedicament']))
	{//début if
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
			}//fin if
			elseif($operateurPrix=='=')
			{//début elseif
				$requeteRechercheMedicament="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL like '%".$depotLegal."%' and MED_NOMCOMMERCIAL like '%".$nomCommercial."%' and FAM_CODE like '%".$familleMedicament."%' and MED_COMPOSITION like '%".$compositionMedicament."%' and MED_PRIXECHANTILLON =".$prixEchantillon.";";
			}//fin elseif
			elseif($operateurPrix=='<')
			{//début elseif
				$requeteRechercheMedicament="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL like '%".$depotLegal."%' and MED_NOMCOMMERCIAL like '%".$nomCommercial."%' and FAM_CODE like '%".$familleMedicament."%' and MED_COMPOSITION like '%".$compositionMedicament."%' and MED_PRIXECHANTILLON < ".$prixEchantillon.";";
			}//fin elseif
			else
			{//début else
				$requeteRechercheMedicament="select MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, FAM_CODE, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL like '%".$depotLegal."%' and MED_NOMCOMMERCIAL like '%".$nomCommercial."%' and FAM_CODE like '%".$familleMedicament."%' and MED_COMPOSITION like '%".$compositionMedicament."%';";
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
	}//fin if
		?>
</div>
<?
include("./scripts/pied.html");
?>
