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
<h2>Medicament Presente</h2>
<img src="./statistique/graphiqueCirculaireMedicamentPresenteVisiteur.php" alt="statistique des médicament présenté lors des visites de ces 3 derniers mois" />
<h2>Nombre de visite</h2>
<img src="./statistique/graphiqueNbVisiteMotif.php" alt="statistique du nombre de visite par motif de ces 3 derniers mois" />
</div>
<?
include("./scripts/pied.html");
?>
