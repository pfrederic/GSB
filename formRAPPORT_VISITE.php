<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté ou différent d'un visiteur ou d'un délégué
estVisiteurConnecte();
verifDroitAcces(0, 1);
include("./scripts/entete.html");
include("./scripts/menuGauche.php");
?>
	<script language="javascript">
		function selectionne(pValeur, pSelection,  pObjet) {
			//active l'objet pObjet du formulaire si la valeur sélectionnée (pSelection) est égale à la valeur attendue (pValeur)
			if (pSelection==pValeur) 
				{ formRapportVisite.elements[pObjet].disabled=false; }
			else { formRapportVisite.elements[pObjet].disabled=true; }
		}
	</script>
	 <script language="javascript">
        function ajoutLigne( pNumero){//ajoute une ligne de produits/qté à la div "lignes"     
			//masque le bouton en cours
			document.getElementById("but"+pNumero).setAttribute("hidden","true");	
			pNumero++;										//incrémente le numéro de ligne
            var laDiv=document.getElementById("lignes");	//récupère l'objet DOM qui contient les données
			var titre = document.createElement("label") ;	//crée un label
			laDiv.appendChild(titre) ;						//l'ajoute à la DIV
			titre.setAttribute("class","titre") ;			//définit les propriétés
			titre.innerHTML= "   Echantillon : ";
			var liste = document.createElement("select");	//ajoute une liste pour proposer les produits
			laDiv.appendChild(liste) ;
			liste.setAttribute("name","lstEchantillon"+pNumero) ;
			liste.setAttribute("class","zone");
			//remplit la liste avec les valeurs de la première liste construite en PHP à partir de la base
			liste.innerHTML=formRapportVisite.elements["lstEchantillon1"].innerHTML;
			var qte = document.createElement("input");
			laDiv.appendChild(qte);
			qte.setAttribute("name","inputQteEchantillon"+pNumero);
			qte.setAttribute("size","2"); 
			qte.setAttribute("class","zone");
			qte.setAttribute("type","text");
			var bouton = document.createElement("input");
			laDiv.appendChild(bouton);
			//ajoute une gestion évenementielle en faisant évoluer le numéro de la ligne
			bouton.setAttribute("onClick","ajoutLigne("+ pNumero +");");
			bouton.setAttribute("type","button");
			bouton.setAttribute("value","+");
			bouton.setAttribute("class","zone");	
			bouton.setAttribute("id","but"+ pNumero);				
        }
    </script>
<?
//On récupère le le numéro max des rapports visite
$requeteRecupNbMax="select max(RAP_CODE) 'nbMax' from RAPPORT_VISITE;";
$resultat=mysql_query($requeteRecupNbMax);
$tabNbMax=mysql_fetch_array($resultat);
$nbMax=$tabNbMax['nbMax']+1;
//On lui ajoute 1 et on l'affiche
?>
<div id="contenu">
		<div id="msg"></div>
		<form name="formRapportVisite" id="ajaxForm">
			<h1> Rapport de visite </h1>
			<p>
			NUMERO :<input type="text" size="10" name="inputCodeRap" class="zone" value="<?=$nbMax?>" READONLY/>
			DATE VISITE :<input type="date" size="10" name="inputDateVisite" class="zone"  />
			</p>
			<p>
			PRATICIEN :<select  name="lstPrat" class="zone" ><?optionListDesPraticien();?></select>
			</p>
			<p>
			COEFFICIENT :<select name="lstCoeff"><?optionDerNumerique();?></select>
			REMPLACANT :<input type="checkbox" class="zone" name="checkBoxRemplacant" onClick="selectionne(true,this.checked,'PRA_REMPLACANT');"/>
			PRESENCE CONCURRENCE :<select name="lstConcurrence"><option value="Rien">Rien</option>
									    <option value="Affiche">Affiche</option>
									    <option value="Prospectus">Prospectus</option>
									    <option value="Documentation">Documentation</option>
						</select>
			</p>
			MOTIF :<select  name="lstMotif" class="zone" onClick="selectionne('AUT',this.value,'inputMotifAutre');">
			<?
			//On fait la requête qui permet de récupérer les différents motifs des visistes et ensuite on les affiche dans une liste déroulante
			$req="select MOT_CODE, MOT_LIB from MOTIF_VISITE;";
			//echo $req;
			$resultat=mysql_query($req);
			while($ligne=mysql_fetch_array($resultat))
			{//début while
				?>
				<option value="<?=$ligne['MOT_CODE']?>" ><?echo $ligne['MOT_LIB'];?></option>
				<?
			}//fin while
			?>
			</select><input type="text" name="inputMotifAutre" class="zone" disabled="disabled" />
			<p>
			BILAN :
			</p>
			<p>
			<textarea rows="5" cols="50" name="inputBilan" class="zone" ></textarea>
			</p>
			<h3> Elements presentes </h3></label>
			<p>
			PRODUIT 1 : <select name="lstProd1" class="zone"><?optionListDerMedicament();?></select>
			CONNAISSANCE PRODUIT : <select name="lstNoteProd1"><?optionDerNumerique();?></select>
			</p>
			<p>
			PRODUIT 2 : <select name="lstProd2" class="zone"><?optionListDerMedicament();?></select>
			CONNAISSANCE PRODUIT : <select name="lstNoteProd2"><?optionDerNumerique();?></select>
			</p>
			<h3>Echantillons</h3>
			<div class="titre" id="lignes">
				<label class="titre" >Produit : </label>
				<select name="lstEchantillon1" class="zone"><?optionListDerMedicament();?></select> Quantite :<input type="text" name="inputQteEchantillon1" size="2" class="zone"/>
				<input type="button" id="but1" value="+" onclick="ajoutLigne(1);" class="zone" />			
			</div>
			<p>
			<input type="submit" name="btActionFormRapportVisite" value="Enregistrer" />
			</p>
			</form>
</div>
 <script>
$(document).ready(function(){
	$("#ajaxForm").submit(function(event){
		event.preventDefault();
		$("#msg").html("");
		var values=$(this).serialize();
		$.ajax({
			url: "ajaxRAPPORT_VISITE.php",
			type: "post",
			data: values,
			success: function(){
				$("#msg").html('<h3>Rapport de visite enregistre dans la base de donnees</h3>');
			},
			error:function(){
				$("#msg").html('<h3>Problème de l'enregistrement dans la base de données</h3>');
			}
		});
	});
});
</script>
<?
include("./scripts/pied.html");
?>
