<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connect�
estVisiteurConnecte();

include("./scripts/entete.html");
include("./scripts/menuGauche.php");
?>
<div id="contenu">
	<div id="msg"></div>
		<h1> Praticiens </h1>
		<form name="formListeRecherche"	id="ajaxForm" >
			<select name="lstPrat" class="titre">
			<?
			// fonctions qui permet de r�cup�rer la liste des praticiens
			optionListDesPraticien();
			?>
			</select>
		<input type="submit" name="Rechercher" value="Rechercher"/>	
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
			url: "ajaxPRATICIEN.php",
			type: 'POST',
			data: values,
			success: function(data){
				$("#resultat").html(data);
			},
			error: function(){
				$("#msg").html('Erreur d�tect�, contact� l\'administrateur');
			}
		});
	});
});
</script>

<?
include("./scripts/pied.html");
?>
