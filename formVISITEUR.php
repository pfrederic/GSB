<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté
estVisiteurConnecte();

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
	<div id="msg"></div>
	<form name="formChoixDepartement" id="ajaxFormDepartement">
		<h1> Visiteurs </h1>
		<?
		// récupération des département
		$req="select distinct DEP_CODE, DEP_NOM from VISITEUR natural join DEPARTEMENT order by DEP_NOM;";
		//echo $req;
		$resultat=mysql_query($req);

		$reqDepVisiteur="select DEP_CODE from VISITEUR natural join DEPARTEMENT where VIS_MATRICULE='".$_SESSION['login']."';";
		//echo $reqDepVisiteur;
		$resultatDepVisiteur=mysql_query($reqDepVisiteur);
		$ligneDepVisiteur=mysql_fetch_array($resultatDepVisiteur);
		$depCodeVisiteur=$ligneDepVisiteur['DEP_CODE'];
		?>
		<select name="lstDept" class="titre" id="departement">
		<option values="" selected></option>
		<?
		while($ligne=mysql_fetch_array($resultat))
		{//début while
			$nomDep=$ligne['DEP_NOM'];
			$codeDep=$ligne['DEP_CODE'];
			?>
			<option value="<?=$codeDep?>"><?=$nomDep?></option>
		<?
		}//fin while
		?>
		</select>
		</form>
	<div id="resultatLstVis"></div>
	<div id="resultatTabVis"></div>
</div>
 <script>
$(document).ready(function(){
	$("#departement").click(function(event){
		event.preventDefault();
		$("#msg").html("");
		var values=$(this).serialize();
		$.ajax({
			url: "ajaxVISITEURDep.php",
			type: 'POST',
			data: values,
			success: function(data){
				$("#resultatLstVis").html(data);
				$("#visiteur").change(function(event){
				event.preventDefault();
				$("#msg").html("");
				var values=$(this).serialize();
				$.ajax({
					url: "ajaxVISITEURVis.php",
					type: 'POST',
					data: values,
					success: function(data){
						$("#resultatTabVis").html(data);
					},
					error: function(){
						$("#msg").html('Erreur détecté, contacté l\'administrateur');
					}
				});
				});
			},
			error: function(){
				$("#msg").html('Erreur détecté, contacté l\'administrateur');
			}
		});
	});
});
</script>
<?
include("./scripts/pied.html");
?>
