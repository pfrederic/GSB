<?php
include("./scripts/parametres.php");
include("./scripts/fonction.php");

$req="select VIS_NOM, VIS_PRENOM, VIS_ADRESSE, VIS_CP, VIS_VILLE, SEC_CODE from VISITEUR where VIS_MATRICULE='".$_POST['lstVisiteur']."';";
//echo $req;
$resultat=mysql_query($req);
$maLigne=mysql_fetch_array($resultat);
?>

<p><h4>NOM : </h4><?=$maLigne['VIS_NOM']?></p>
<p><h4>PRENOM : </h4><?=$maLigne['VIS_PRENOM']?></p>
<p>
<table>
<tr>
	<th>Adresse</th>
	<th>Code Postal</th>
	<th>Ville</th>
	<th>Secteur</th>
</tr>
<tr>
	<td><?=$maLigne['VIS_ADRESSE']?></td>
	<td><?=$maLigne['VIS_CP']?></td>
	<td><?=$maLigne['VIS_VILLE']?></td>
	<td><?=$maLigne['SEC_CODE']?></td>
</tr>
</table>