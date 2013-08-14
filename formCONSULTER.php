<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

if(!estVisiteurConnecte())
{//début if
	header('location: login.php');
}//fin if

include("./scripts/entete.html");
include("./scripts/menuGauche.html");
?>
<div id="contenu">
	<form name="formChoixRapport" method="POST" action="">
		<select name="lstRapport">
		<?
		$req="select RAP_CODE from RAPPORT_VISITE where VIS_MATRICULE='".$_SESSION['login']."';";
		$resultat=mysql_query($req);
		while($ligne=mysql_fetch_array($resultat))
		{//début while
			?>
			<option value="<?=$ligne['RAP_CODE']?>" <?
			if($ligne['RAP_CODE']==$_POST['lstRapport'])
			{//début if
				echo "checked";
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
		<?
	}//fin if
	?>
</div>
<?

include("./scripts/pied.html");
?>
