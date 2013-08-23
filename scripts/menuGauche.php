<?
include("./scripts/parametres.php");
?>
<div id="menuGauche">
<h2>Gestion des visites</h2>
<h3>Outils</h3>
	<ul id="menuList">
		<li><a href="index.php" >Accueil</a></li>
		<li><a href="deconnexion.php" >Deconnexion</a></li>
	</ul>
	<?
	if($_SESSION['hierarchie']==0 || $_SESSION['hierarchie']==1)
	{//début if
	?>
	<ul id="menuListTitle">Comptes-Rendus</ul>
		<ul id="menuList">
			<li><a href="formRAPPORT_VISITE.php" >Nouveaux</a></li>
			<li><a href="formCONSULTERVISITEUR.php" >Consulter</a></li>
			<?
			if($_SESSION['hierarchie']==1)
			{//début if
			?>
			<li><a href="formCONSULTER.php" >Consulter rapport d'un autre visiteur</a></li>
			<?
			}//fin if
			?>
		</ul>
	<?
	}//fin if
	?>
		<ul id="menuListTitle">Consulter</ul>
		<ul id="menuList"><li><a href="formMEDICAMENT.php" >Medicaments</a></li>
			<li><a href="formPRATICIEN.php" >Praticiens</a></li>
			<li><a href="formVISITEUR.php" >Autres visiteurs</a></li>
		</ul>
		<ul id="menuListTitle">Statistique</ul>
		<ul id="menuList">
		<?
		if($_SESSION['hierarchie']==0||$_SESSION['hierarchie']==1)
		{//début if
		?>
		<li><a href="statSyntheseTravailVisiteur.php">Synthèse du travail</a></li>
		<?
		}//fin if
		if($_SESSION['hierarchie']==1)
		{//début if
		?>
		<li><a href="statSyntheseTravailEquipeDelegue.php">Synthèse de l'équipe de la région</a></li>
		<?
		}//fin if
		if($_SESSION['hierarchie']==2)
		{//début if
		?>
		<li><a href="statMedicamentPresente.php">Medicament presente</a></li>
		<?
		}//fin if
		?>
		</ul>
</div>
<?
//fin script
?>
