<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");
include("./scripts/entete.html");
include("./scripts/menuGauche.php");

//page inaccessible si visiteur non connecté et aux personnes autres que les responsables
estVisiteurConnecte();
verifDroitAcces(2);

?>
<div id="contenu">
<img src="./statistique/graphiqueCirculaireMedicamentPresente.php" alt="graphique représentant les médicaments présentés">
</div>
<?
include("./scripts/pied.html");
?>
