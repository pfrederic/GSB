<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

if(!estVisiteurConnecte()||$_SESSION['hierarchie']!=1)
{//début if
	header('location: index.php');
}//fin if

include("./scripts/entete.html");
include("./scripts/menuGauche.php");

?>
<div id="contenu">
	<form name="formChoixRapport" method="POST" action="">
		<select name="lstRapport">
		<?
		$req="select RAP_CODE from RAPPORT_VISITE inner join VISITEUR on RAPPORT_VISITE.VIS_MATRICULE=VISITEUR.VIS_MATRICULE inner join TRAVAILLER on VISITEUR.VIS_MATRICULE=TRAVAILLER.VIS_MATRICULE where REG_CODE='".$_SESSION['region']."' and RAP_DATEVISITE>CURRENT_DATE-interval 3 month;";
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
			echo $ligne['RAP_CODE'];
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
		<?
		$req="select RAP_CODE, PRA_CODE, RAP_DATEVISITE, RAP_BILAN, RAP_COEFCONFIANCE, RAP_DATESAISIE, RAP_CONCURRENCE, MOT_LIB from RAPPORT_VISITE natural join MOTIF_VISITE where RAP_CODE='".$_POST['lstRapport']."';";
		$resultat=mysql_query($req);
		$ligne=mysql_fetch_array($resultat);
		?>
		<table>
		  <tr>
		    <th>CODE</th>
		    <td><?echo $ligne['RAP_CODE'];?></td>
		  </tr>
		  <tr>
		    <th>PRATICIEN</th>
		    <td><?echo $ligne['PRA_CODE'];?></td>
		  </tr>
		  <tr>
		    <th>DATE DE VISITE</th>
		    <td><?echo $ligne['RAP_DATEVISITE'];?></td>
		  </tr>
		  <tr>
		    <th>BILAN</th>
		    <td><?echo $ligne['RAP_BILAN'];?></td>
		  </tr>
		  <tr>
		    <th>COEFFICIEN DE CONFIANCE</th>
		    <td><?echo $ligne['RAP_COEFCONFIANCE'];?></td>
		  </tr>
		  <tr>
		    <th>DATE DE SAISIE</th>
		    <td><?echo $ligne['RAP_DATESAISIE']?></td>
		  </tr>
		  <tr>
		    <th>PRESENCE DE LA CONCURRENCE</th>
		    <td><?echo $ligne['RAP_CONCURRENCE'];?></td>
		  </tr>
		  <tr>
		    <th>MOTIF DE LA VISITE</th>
		    <td><?echo $ligne['MOT_LIB'];?></td>
		  </tr>
		</table>
		<p></p>
		<h2>Médicament présenté</h2>
		<?
		$req="select MED_NOMCOMMERCIAL, PRE_CONNAISSANCE from MEDICAMENT natural join PRESENTE where RAP_CODE=".$_POST['lstRapport'].";";
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
			while($ligne=mysql_fetch_array($resultat))
			{//début while
				?>
				<tr>
			  	  <td><?echo $ligne['MED_NOMCOMMERCIAL'];?></td>
			  	  <td><?echo $ligne['PRE_CONNAISSANCE'];?></td>
				</tr>
				<?
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
		$req="select MED_NOMCOMMERCIAL, OFF_QTE from MEDICAMENT natural join OFFRIR where RAP_CODE=".$_POST['lstRapport'].";";
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
		while($ligne=mysql_fetch_array($resultat))
		{//début while
			?>
			<tr>
			  <td><?echo $ligne['MED_NOMCOMMERCIAL'];?></td>
			  <td><?echo $ligne['OFF_QTE'];?></td>
			</tr>
			<?	
		}//fin while
		?>
			</tbody>
		</table>
		<?
		}//fin else
	}//fin if
	?>
</div>
<?

include("./scripts/pied.html");
?>
