<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");
include("./scripts/entete.html");
include("./scripts/menuGauche.php");

if(!estVisiteurConnecte())
{//début if
	header('location: https://127.0.0.1/GSB/login.php');
}//fin if

?>
<div id="contenu">
<img src="./statistique/graphiqueCirculaireMedicamentPresenteEquipe.php" alt="graphique représentant les médicaments présentés">
<img src="./statistique/graphiqueLigneNombreVisite.php" alt="graphique représentant le nombre de visite">
</div>
<?
include("./scripts/pied.html");
?>
