<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté
if ( ! estVisiteurConnecte() ) 
{
	header("Location:login.php");  
}

include("./scripts/entete.html");
/*
	<script language = "javascript">
		function chercher($pNumero) {  
			var xhr_object = null; 	    
			if(window.XMLHttpRequest) // Firefox 
				xhr_object = new XMLHttpRequest(); 
			else if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
					alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
					return; 
				}   
			//traitement à la réception des données
		   xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4 && xhr_object.status == 200) { 
				 var formulaire = document.getElementById("formPraticien");
				formulaire.innerHTML=xhr_object.responseText;			} 
		   }
		   //communication vers le serveur
		   xhr_object.open("POST", "cherchePraticien.php", true); 
		   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		   var data = "pratNum=" + $pNumero ;
		   xhr_object.send(data); 
		   
	   }
	</script>
*/
include("./scripts/menuGauche.php");
?>
<div id="contenu">
		<h1> Praticiens </h1>
		<form name="formListeRecherche"	method="POST" action="" >
			<select name="lstPrat" class="titre">
			<?
			optionListDerPraticien();
			?>
			</select>
		<input type="submit" name="Rechercher" value="Rechercher"/>	
		</form>	
<?
if(isset($_POST['Rechercher']))
{
        $codePrat=$_POST['lstPrat'];
        $req="select PRA_NOM, PRA_PRENOM, PRA_COEFNOTORIETE, CAB_ADRESSE, CAB_CP, CAB_VILLE from PRATICIEN natural join AFFECTATION natural join CABINET where PRA_CODE='".$codePrat."';";
        $result=mysql_query($req);
	$maLigne=mysql_fetch_array($result);
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
        }
        
}

?>
</div>
<?
include("./scripts/pied.html");
?>
