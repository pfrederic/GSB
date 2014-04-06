<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

estVisiteurConnecte();
verifDroitAcces(0, 1);

if(isset($_POST['Modifier']))
{
	//A finir!!!
	//RAPPORT_VISITE, OFFRIR (echantillon), PRESENTE(medicaments)
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
}

include("./scripts/entete.html");
include("./scripts/menuGauche.php");

?>
<div id="contenu">
	<form name="formChoixRapport" method="POST" action="">
		<select name="lstRapport">
		<?
		$req="select RAP_CODE, RAP_DATESAISIE from RAPPORT_VISITE where VIS_MATRICULE='".$_SESSION['login']."' AND RAP_DATEVISITE>CURRENT_DATE-interval 3 month;";
		//echo $req;
		$resultat=mysql_query($req);
		while($ligne=mysql_fetch_array($resultat))
		{//début while
			?>
			<option value="<?=$ligne['RAP_CODE']?>" <?
			if($_POST['lstRapport']==$ligne['RAP_CODE'])
			{//début if
				echo "selected";
			}//fin if
			?>
			>
			<?
			echo $ligne['RAP_CODE']." ".convertirDateAnglaisVersFrancais($ligne['RAP_DATESAISIE']);
			?>
			</option>
			<?
		}//fin while
		?>
		</select>
		<input type="submit" name="btActionFormChoixRapport" value="Consulter" />
	</form>
	<?
	if(isset($_POST['btActionFormChoixRapport']))
	{//début if
		?>
		<h2>Synthèse de la visite</h2>
		<form name="formSyntheseVisite" action="" method="POST">
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
	            <td><input type="date" STYLE="text-align:center" name="dateSaisie" value="<?=$ligne['RAP_DATESAISIE']?>"</td>
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
</div>
</form>
		<?
	}//fin if

include("./scripts/pied.html");
?>
