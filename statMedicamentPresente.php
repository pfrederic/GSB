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
<img src="./statistique/graphiqueCirculaireMedicamentPresente.php" alt="graphique représentant les médicaments présentés">
</div>
<?
include("./scripts/pied.html");
?>
