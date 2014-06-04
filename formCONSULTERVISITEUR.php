<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

estVisiteurConnecte();
verifDroitAcces(0, 1);

include("./scripts/entete.html");
include("./scripts/menuGauche.php");

?>
<div id="contenu">
	<div id="msg"></div>
	<form name="formChoixRapport" id="ajaxForm">
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
	<div id="resultat"></div>
</div>
<script>
$(document).ready(function(){
	$("#ajaxForm").submit(function(event){
		event.preventDefault();
		$("#msg").html("");
		var values=$(this).serialize();
		$.ajax({
			url: "ajaxCONSULTERVISITEUR.php",
			type: 'POST',
			data: values,
			success: function(data){
				$("#resultat").html(data);
					$("#ajaxFormResult").submit(function(event){
					event.preventDefault();
					$("#msg").html("");
					var values=$(this).serialize();
					$.ajax({
						url: "ajaxCONSULTERVISITEURModif.php",
						type: 'POST',
						data: values,
						success: function(data){
							$("#msg").html(data);
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
