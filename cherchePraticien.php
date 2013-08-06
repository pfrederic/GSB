<?php 
	include ("scripts/parametres.php");
	//on interroge la base
	$req="select * from PRATICIEN  where PRA_CODE='".$_POST["pratNum"]."';";
	$curseur=mysql_query($req); 
	$res=mysql_fetch_array($curseur);
	$reqType="select TYP_LIBELLE from TYPE_PRATICIEN where TYP_CODE='".$res["TYP_CODE"]."'";
	$resType=mysql_fetch_array($reqType);
	//s'il reste un enregistrement non lu
	if ($res != "") {
		//on positionne les champs avec les valeurs de la table
		echo '
		<label class="titre">NUMERO :</label><label size="5" name="PRA_NUM" class="zone" >'.$res["PRA_NUM"].'</label>
		<label class="titre">NOM :</label><label size="25" name="PRA_NOM" class="zone" >'.$res["PRA_NOM"].'</label>
		<label class="titre">PRENOM :</label><label size="30" name="PRA_PRENOM" class="zone" >'.$res["PRA_PRENOM"].'</label>
		<label class="titre">ADRESSE :</label><label size="50" name="PRA_ADRESSE" class="zone" >'.$res["PRA_ADRESSE"].'</label>
		<label class="titre">CP :</label><label size="5" name="PRA_CP" class="zone" >'.$res["PRA_CP"].' '.$res["PRA_VILLE"].'</label>
		<label class="titre">COEFF. NOTORIETE :</label><label size="7" name="PRA_COEFNOTORIETE" class="zone" >'.$res["PRA_COEFNOTORIETE"].'</label>
		<label class="titre">TYPE :</label><label size="3" name="TYP_CODE" class="zone" >'.$resType["typ_libelle"].'</label>
		<label class="titre">&nbsp;</label><div class="zone"><input type="button" value="<" onClick="precedent();"></input><input type="button" value=">" onClick="suivant();"></input>
		';
	}	
?>
