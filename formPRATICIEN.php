<?
include("scripts/parametres.php");
?>
<html>
<head>
	<title>formulaire PRATICIEN</title>
	<LINK REL=StyleSheet HREF="site.css" TYPE="text/css"/>
	<style type="text/css">
		<!-- body {background-color: white; color:5599EE; } 
			label.titre { width : 180 ;  clear:left; float:left; } 
			.zone { width : 300 ; float : left; color:white } -->
	</style>
	<?/*
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
*/?>
</head>
<body>	
<div name="haut" style="margin: 2 2 2 2 ;height:6%;"><h1><img src="logo.jpg" width="100" height="60"/>Gestion des visites</h1></div>
<div name="gauche" style="float:left;width:18%; background-color:white; height:100%;">
	<h2>Outils</h2>
	<ul><li>Comptes-Rendus</li>
		<ul>
			<li><a href="formRAPPORT_VISITE.php" >Nouveaux</a></li>
			<li>Consulter</li>
		</ul>
		<li>Consulter</li>
		<ul><li><a href="formMEDICAMENT.php" >Medicaments</a></li>
			<li><a href="formPRATICIEN.php" >Praticiens</a></li>
			<li><a href="formVISITEUR.php" >Autres visiteurs</a></li>
		</ul>
	</ul>
</div>
<div name="droite" style="float:left;width:80%;">
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:88%;">
		<h1> Praticiens </h1>
		<form name="formListeRecherche"	method="POST" action="" >
		<?
			$req="select PRA_NOM from PRATICIEN order by PRA_NOM";
			$resultat=mysql_query($req);
		?>
			<select name="lstPrat" class="titre">
				<option>Choisissez un praticien</option>
		<?
			while($ligne=mysql_fetch_array($resultat))
			{
				$nomPrat=$ligne['PRA_NOM'];
		?>
				<option value="<?=$nomPrat?>"><?=$nomPrat?></option>
		<?
			}
		?>
			</select>
		<input type="submit" name="Rechercher" value="Rechercher"/>	
		</form>	
<?
if(isset($_POST['Rechercher']))
{
        $nomPrat=$_POST['lstPrat'];
        $req="select * from PRATICIEN where PRA_NOM='$nomPrat'";
        $result=mysql_query($req);
        while($ligne=mysql_fetch_array($result))
        {
                $prenom=$ligne['PRA_PRENOM'];
                $adresse=$ligne['PRA_ADRESSE'];
                $cp=$ligne['PRA_CP'];
                $ville=$ligne['PRA_VILLE'];
                $coeffNotoriete=$ligne['PRA_COEFNOTORIETE'];

        ?>
        <table>
        <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Ville</th>
                <th>Coefficient</th>
        </tr>
        <tr>
                <td><?=$nomPrat?></td>
                <td><?=$prenom?></td>
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
</div>
</body>
</html>
