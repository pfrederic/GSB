<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté
if ( ! estVisiteurConnecte() ) 
{
	header('location: https://127.0.0.1/GSB/login.php');
}

include("./scripts/entete.html");
include("./scripts/menuGauche.php");
if(isset($_POST['btActionFormChoixDep']))
{//début if
		$_SESSION['departement']=$_POST['lstDept'];	
}//fin if

if(isset($_POST['btActionFormChoixVisiteur']))
{//début if
		$_SESSION['visiteur']=$_POST['lstVisiteur'];	
}//fin if
?>
<div id="contenu">
	<form name="formChoixDep" method="post" action="">
		<h1> Visiteurs </h1>
		<?
		// récupération des département
		$req="select distinct DEP_CODE, DEP_NOM from VISITEUR natural join DEPARTEMENT order by DEP_NOM;";
		$resultat=mysql_query($req);
		?>
		<select name="lstDept" class="titre">
		<?
		while($ligne=mysql_fetch_array($resultat))
		{//début while
			$nomDep=$ligne['DEP_NOM'];
			$codeDep=$ligne['DEP_CODE'];
			?>
			<option value="<?=$codeDep?>"
			<?
			if($_SESSION['departement']==$codeDep)
			{//début if
				echo "selected";
			}//fin if
			?>
			><?=$nomDep?></option>
		<?
		}//fin while
		?>
		</select>
		<input type="submit" name="btActionFormChoixDep" value="Selectionner"/>
		</form>
		<?
		if((isset($_POST['btActionFormChoixDep']))||(isset($_POST['btActionFormChoixVisiteur'])))
		{//début if
		?>
			<form name="formChoixVisiteur" method="POST">
				<select name="lstVisiteur" class="zone">
				<?
				$req="select VIS_MATRICULE, VIS_NOM, VIS_PRENOM from VISITEUR where DEP_CODE='".$_SESSION['departement']."';";
				$resultat=mysql_query($req);
				while($maLigne=mysql_fetch_array($resultat))
				{//début while
					?>
					<option value="<?=$maLigne["VIS_MATRICULE"];?>" 
					<?
					if($_SESSION['visiteur']==$maLigne["VIS_MATRICULE"])
					{//début if
						echo "selected";
					}//fin if
					?>><?echo $maLigne["VIS_NOM"]." ".$maLigne["VIS_PRENOM"];?></option>
					<?
				}//fin while
				?>
				</select>
				<input type="submit" name="btActionFormChoixVisiteur" value="Séléctionner" />
			</form>
			<?
		}//fin if
		if(isset($_POST['btActionFormChoixVisiteur']))
		{//début if
			?>
			<form name="formAffiVisiteur" method="POST" action="">
				<?
				$req="select VIS_NOM, VIS_PRENOM, VIS_ADRESSE, VIS_CP, VIS_VILLE, SEC_CODE from VISITEUR where VIS_MATRICULE='".$_SESSION['visiteur']."';";
				$resultat=mysql_query($req);
				$maLigne=mysql_fetch_array($resultat);
				?>
				<p><h4>NOM : </h4><?=$maLigne['VIS_NOM']?></p>
				<p><h4>PRENOM : </h4><?=$maLigne['VIS_PRENOM']?></p>
				<p>
				<table>
				<tr>
					<th>Adresse</th>
					<th>Code Postal</th>
					<th>Ville</th>
					<th>Secteur</th>
				</tr>
				<tr>
					<td><?=$maLigne['VIS_ADRESSE']?></td>
					<td><?=$maLigne['VIS_CP']?></td>
					<td><?=$maLigne['VIS_VILLE']?></td>
					<td><?=$maLigne['SEC_CODE']?></td>
				</tr>
				</table>
				<!-- ADRESSE :<input type="text" size="20" name="VIS_ADRESSE" class="zone" value="<?=$maLigne['VIS_ADRESSE']?>"/>
				CP :<input type="text" size="5" name="VIS_CP" class="zone" value="<?=$maLigne['VIS_CP']?>"/>
				VILLE :<input type="text" size="20" name="VIS_VILLE" class="zone" value="<?=$maLigne['VIS_VILLE']?>"/>
				</p>
				<p>
				SECTEUR :<input type="text" size="1" name="SEC_CODE" class="zone" value="<?=$maLigne['VIS_SECTEUR']?>"/>
				</p> -->
			</form>
		<?
		}//fin if
		?>
</div>
<?
include("./scripts/pied.html");
?>
