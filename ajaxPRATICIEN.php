<?php

include("./scripts/parametres.php");
include("./scripts/fonction.php");

//Récupération du code praticien contenu dans la liste déroulante
    $codePrat=$_POST['lstPrat'];
if($codePrat=="0")
{//début if
	echo "<h3>Aucun visiteur selectionne</h3>";
}//fin if
else
{//début else
	//Requête qui permet de récuperer toute les informations
    	$req="select PRA_NOM, PRA_PRENOM, PRA_COEFNOTORIETE, CAB_ADRESSE, CAB_CP, CAB_VILLE from PRATICIEN natural join AFFECTATION natural join CABINET where PRA_CODE='".$codePrat."';";
	//echo $req;
    	$result=mysql_query($req);
	$maLigne=mysql_fetch_array($result);
	// on affiche toute les informations récupérer dans un tableau
	?>
	<p><h4>Nom : </h4><?=$maLigne['PRA_NOM'];?><h4>Prenom : </h4><?=$maLigne['PRA_PRENOM'];?></p>
	<?
   		$result=mysql_query($req);
   		while($ligne=mysql_fetch_array($result))
   		{
            	$adresse=$ligne['CAB_ADRESSE'];
            	$cp=$ligne['CAB_CP'];
           		$ville=$ligne['CAB_VILLE'];
            	$coeffNotoriete=$ligne['PRA_COEFNOTORIETE'];

    	?>

    	<table>
    	<tr>
            	<th>Adresse</th>
            	<th>Code Postal</th>
            	<th>Ville</th>
            	<th>Coefficient</th>
    	</tr>
    	<tr>
            	<td><?=$adresse?></td>
            	<td><?=$cp?></td>
		<td><?=$ville?></td>
		<td><?=$coeffNotoriete?></td>
	</tr>
	</table>
    	<?
    	}//fin while
}//fin else   
?>