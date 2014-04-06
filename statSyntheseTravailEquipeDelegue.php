<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");
include("./scripts/entete.html");
include("./scripts/menuGauche.php");

//page inaccessible si visiteur non connecté et aux personnes autres que les délégué
estVisiteurConnecte();
verifDroitAcces(1);

?>
<div id="contenu">
<img src="./statistique/graphiqueCirculaireMedicamentPresenteEquipe.php" alt="graphique représentant les médicaments présentés">
<img src="./statistique/graphiqueLigneNombreVisite.php" alt="graphique représentant le nombre de visite">
</div>
<?
include("./scripts/pied.html");
?>
