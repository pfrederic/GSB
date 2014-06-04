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
	<div id="msg"></div>
	<h1> Pharmacopee </h1>
	<form name="formRechercheMedicament" id="ajaxForm">
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
	<div id="resultat"></div>
</div>
 <script>
$(document).ready(function(){
	$("#ajaxForm").submit(function(event){
		event.preventDefault();
		$("#msg").html("");
		var values=$(this).serialize();
		$.ajax({
			url: "ajaxMEDICAMENT.php",
			type: 'POST',
			data: values,
			success: function(data){
				$("#msg").html('Ca marche');
				$("#resultat").html(data);
			},
			error: function(){
				$("#msg").html('MARCHE PAS');
			}
		});
	});
});
</script>
<?
include("./scripts/pied.html");
?>
