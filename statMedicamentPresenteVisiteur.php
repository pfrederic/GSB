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
<div width="750px" height="300px">
<img src="./statistique/graphiqueCirculaireMedicamentPresenteVisiteur.php" alt="statistique des medicaments presentes">
</div>
</div>
<?
include("./scripts/pied.html");
?>
