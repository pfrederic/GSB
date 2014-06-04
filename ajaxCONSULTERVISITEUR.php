<?php
include("./scripts/parametres.php");
include("./scripts/fonction.php");
?>
	<h2>Synthèse de la visite</h2>
	<form name="formSyntheseVisite" id="ajaxFormResult">
	<?
	$req="select RAP_CODE, PRA_CODE, RAP_DATEVISITE, RAP_BILAN, RAP_COEFCONFIANCE, RAP_DATESAISIE, RAP_CONCURRENCE, MOT_CODE from RAPPORT_VISITE natural join MOTIF_VISITE where RAP_CODE='".$_POST['lstRapport']."';";
	//echo $req;
	$resultat=mysql_query($req);
	$ligne=mysql_fetch_array($resultat);
	$praCode=$ligne['PRA_CODE'];
	$motifCode=$ligne['MOT_CODE'];
	$req2="select PRA_NOM,PRA_PRENOM from PRATICIEN where PRA_CODE='$praCode';";
	//echo $req;
	$resultat2=mysql_query($req2);
	$ligne2=mysql_fetch_array($resultat2);
	?>
	<table>
	  <tr>
	    <th>CODE</th>
	    <td><input type="text" STYLE="text-align:center" name="rapCode" value="<?echo $ligne['RAP_CODE']?>" READONLY></td>
	  </tr>
	  <tr>
	    <th>PRATICIEN</th>
	    <td><select name="lstPrat"><?echo optionListDesPraticienAvecPraticienSelected($praCode);?></select></td>
	  </tr>
	  <tr>
	    <th>DATE DE VISITE</th>
	    <td><input STYLE="text-align:center" type="date" value="<?=$ligne['RAP_DATEVISITE']?>" name="dateVisite"</td>
	  </tr>
	  <tr>
	    <th>BILAN</th>
	    <td><textArea STYLE="resize:none" name="bilan" cols="40" rows="6"><?echo $ligne['RAP_BILAN'];?></textArea></td>
	  </tr>
	  <tr>
	    <th>COEFFICIENT DE CONFIANCE</th>
	    <td><input type="text" STYLE="text-align:center;" name="coeffConfiance" value="<?echo $ligne['RAP_COEFCONFIANCE']?>" READONLY></td>
	  </tr>
	  <tr>
	    <th>DATE DE SAISIE</th>
            <td><input type="date" STYLE="text-align:center" name="dateSaisie" value="<?=$ligne['RAP_DATESAISIE']?>" READONLY></td>
	  </tr>
	  <tr>
	    <th>PRESENCE DE LA CONCURRENCE</th>
	<td>
		<select name="lstConcurrence">
		<option value="Rien"<?if($ligne['RAP_CONCURRENCE']=="Rien") echo " selected";?> >Rien</option>
		<option value="Affiche"<?if($ligne['RAP_CONCURRENCE']=="Affiche") echo " selected";?>>Affiche</option>
		<option value="Prospectus"<?if($ligne['RAP_CONCURRENCE']=="Prospectus") echo " selected";?>>Prospectus</option>
		<option value="Documentation"<?if($ligne['RAP_CONCURRENCE']=="Documentation") echo " selected";?>>Documentation</option>
		</select>
	</td>
	  </tr>
	  <tr>
	    <th>MOTIF DE LA VISITE</th>
	    <td><select name="lstMotif">
		<?
		$req="select * from MOTIF_VISITE;";
		//echo $req;
		$resultat=mysql_query($req);
		while($ligne=mysql_fetch_array($resultat))
		{
			?>
			<option value="<?=$ligne['MOT_CODE']?>"<?if($ligne['MOT_CODE']==$motifCode) echo " selected";?> ><?echo $ligne['MOT_LIB'];?></option>
			<?
		}
		?>
		</select></td>
	  </tr>
	</table>
	<p></p>
	<h2>Médicament présenté</h2>
	<?
	$req="select MED_DEPOTLEGAL, PRE_CONNAISSANCE from MEDICAMENT natural join PRESENTE where RAP_CODE=".$_POST['lstRapport'].";";
	//echo $req;
	$resultat=mysql_query($req);
	$ligne=mysql_fetch_array($resultat);
	if(empty($ligne))
	{//début if
		echo ("<div class=\"erreur\" >Aucun médicament présenté</div>");
	}//fin if
	else
	{//début else
		?>
		<table>
			<thead>
				<th>NOM DU MEDICAMENT</th>
				<th>NOTE DE CONNAISSANCE</th>
			</thead>
			<tbody>
		<?
		$resultat=mysql_query($req);
		$numMedocPresente=0;
		while($ligne=mysql_fetch_array($resultat))
		{//début while
			?>
			<input type="hidden" name="hiddenMedic<?=$numMedocPresente?>" value="<?=$ligne['MED_DEPOTLEGAL']?>"/>
			<tr>
		  	  <td><select name="lstMedic<?=$numMedocPresente?>"> <?optionListDerMedicamentAvecMedicamentSelected($ligne['MED_DEPOTLEGAL'])?></select></td>
		  	  <td><select name="lstNoteMedic<?=$numMedocPresente?>"><?optionDerNumeriqueAvecNumeroSelected($ligne['PRE_CONNAISSANCE'])?></select></td>
			</tr>
			<?
			$numMedocPresente++;
		}//fin while
		?>
			</tbody>
		<table>
		<?
	}//fin else
	?>
	<p></p>
	<h2>Echantillon offert</h2>
	<?
	$req="select MED_DEPOTLEGAL, OFF_QTE from MEDICAMENT natural join OFFRIR where RAP_CODE=".$_POST['lstRapport'].";";
	//echo $req;
	$resultat=mysql_query($req);
	$ligne=mysql_fetch_array($resultat);
	if(empty($ligne))
	{//début if
		echo "<div class=\"erreur\">Aucun échantillon distribué</div>";
	}//fin if
	else
	{//début else
	$resultat=mysql_query($req);
	?>
	<table>
		<thead>
			<th>NOM DE L'ECHANTILLON</th>
			<th>QUANTITE OFFERTE</th>
		</thead>
		<tbody>
	<?
	$numEcht=0;
	while($ligne=mysql_fetch_array($resultat))
	{//début while
		?>
		<input type="hidden" name="ancienEchantillon<?=$numEcht?>" value="<?=$ligne['MED_DEPOTLEGAL']?>">
		<tr>
		  <td><select name="lstEchantillon<?=$numEcht?>"><?optionListDerMedicamentAvecMedicamentSelected($ligne['MED_DEPOTLEGAL'])?></select></td>
		  <td><input type="text" name="qteEchantillon<?=$numEcht?>" value="<?echo $ligne['OFF_QTE']?>"/></td>
		</tr>
		<?
		$numEcht++;
	}//fin while
	?>
		</tbody>
	</table>
	<?
	}//fin else
	?>
	<center><input type="submit" name="Modifier" value="Modifier"></center>
</form>