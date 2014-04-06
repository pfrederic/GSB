<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");
include("./scripts/entete.html");
include("./scripts/menuGauche.php");

//page inaccessible si visiteur non connecté
estVisiteurConnecte();

?>
<div id="contenu">
<div width="750px" height="300px">
<img src="./statistique/graphiqueCirculaireMedicamentPresenteVisiteur.php" alt="statistique des medicaments presentes">
</div>
</div>
<?
include("./scripts/pied.html");
?>
