<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté
if ( ! estVisiteurConnecte() ) 
{
	header("Location:login.php");  
}

include("./scripts/entete.html");
include("./scripts/menuGauche.html");
?>
	<script language="javascript">
		function selectionne(pValeur, pSelection,  pObjet) {
			//active l'objet pObjet du formulaire si la valeur sélectionnée (pSelection) est égale à la valeur attendue (pValeur)
			if (pSelection==pValeur) 
				{ formRAPPORT_VISITE.elements[pObjet].disabled=false; }
			else { formRAPPORT_VISITE.elements[pObjet].disabled=true; }
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
			titre.innerHTML= "   Produit : ";
			var liste = document.createElement("select");	//ajoute une liste pour proposer les produits
			laDiv.appendChild(liste) ;
			liste.setAttribute("name","PRA_ECH"+pNumero) ;
			liste.setAttribute("class","zone");
			//remplit la liste avec les valeurs de la première liste construite en PHP à partir de la base
			liste.innerHTML=formRAPPORT_VISITE.elements["PRA_ECH1"].innerHTML;
			var qte = document.createElement("input");
			laDiv.appendChild(qte);
			qte.setAttribute("name","PRA_QTE"+pNumero);
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
<div id="contenu">
		<form name="formRAPPORT_VISITE" method="post" action="recupRAPPORT_VISITE.php">
			<h1> Rapport de visite </h1>
			<p>
			NUMERO :<input type="text" size="10" name="RAP_NUM" class="zone" />
			DATE VISITE :<input type="text" size="10" name="RAP_DATEVISITE" class="zone" />
			</p>
			<p>
			PRATICIEN :<select  name="lstPrat" class="zone" ><?optionListDerPraticien();?></select>
			</p>
			<p>
			COEFFICIENT :<input type="text" size="6" name="PRA_COEFF" class="zone" />
			REMPLACANT :<input type="checkbox" class="zone" checked="false" onClick="selectionne(true,this.checked,'PRA_REMPLACANT');"/><select name="PRA_REMPLACANT" disabled="disabled" class="zone" ></select>
			</p>
			DATE :<input type="text" size="19" name="RAP_DATE" class="zone" />
			MOTIF :<select  name="RAP_MOTIF" class="zone" onClick="selectionne('AUT',this.value,'RAP_MOTIFAUTRE');">
											<option value="PRD">Periodicite</option>
											<option value="ACT">Actualisation</option>
											<option value="REL">Relance</option>
											<option value="SOL">Sollicitation praticien</option>
											<option value="AUT">Autre</option>
										</select><input type="text" name="RAP_MOTIFAUTRE" class="zone" disabled="disabled" />
			<p>
			BILAN :
			</p>
			<p>
			<textarea rows="5" cols="50" name="RAP_BILAN" class="zone" ></textarea>
			</p>
			<h3> Elements presentes </h3></label>
			PRODUIT 1 : <select name="PROD1" class="zone"><?optionListDerMedicament();?></select>
			PRODUIT 2 : <select name="PROD2" class="zone"><?optionListDerMedicament();?></select>
			DOCUMENTATION OFFERTE :<input name="RAP_DOC" type="checkbox" class="zone" checked="false" />
			<h3>Echantillons</h3>
			<div class="titre" id="lignes">
				<label class="titre" >Produit : </label>
				<select name="PRA_ECH1" class="zone"><option>Produits</option></select><input type="text" name="PRA_QTE1" size="2" class="zone"/>
				<input type="button" id="but1" value="+" onclick="ajoutLigne(1);" class="zone" />			
			</div>		
			SAISIE DEFINITIVE :<input name="RAP_LOCK" type="checkbox" class="zone" checked="false" />
			</form>
</div>
<?
include("./scripts/pied.html");
?>
