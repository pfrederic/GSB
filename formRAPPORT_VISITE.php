<?
include("./scripts/parametres.php");
include("./scripts/fonction.php");

// page inaccessible si visiteur non connecté ou différent d'un visiteur ou d'un délégué
if ( ! estVisiteurConnecte() || $_SESSION['hierarchie']==2) 
{
	header("Location:index.php");
}
//Si on appuye sur le bouton alors
if(isset($_POST['btActionFormRapportVisite']))
{//début if
	$matriculeVisiteur=$_SESSION['login'];
	$codeRapport=$_POST['inputCodeRap'];
	$codePraticien=$_POST['lstPrat'];
	$dateDeVisite=$_POST['inputDateVisite'];
	$bilanDuRapport=$_POST['inputBilan'];
	$motifDeVisite=$_POST['lstMotif'];
	$coefficiantDeConfiance=$_POST['lstCoeff'];
	$dateDuJour=date("Y-m-d");
	$presenceConcurrence=$_POST['lstConcurrence'];
	//Si on coche la case remplaçant
	if(isset($_POST['checkBoxRemplacant']))
	{//début if
		//On affiche dans le bilan que la visite a été réalisé par un remplaçant
		$bilanDuRapport.=" Visite réalisé auprès d'un remplacant (praticien absent)";
	}//fin if

	$bilanDuRapport=filtrerChainePourBD($bilanDuRapport);
	//Requête qui permet d'insérer les informations récupérer dans la base de données
	$req="insert into RAPPORT_VISITE(VIS_MATRICULE, RAP_CODE, PRA_CODE, RAP_DATEVISITE, RAP_BILAN, MOT_CODE, RAP_COEFCONFIANCE, RAP_DATESAISIE, RAP_CONCURRENCE) values('".$matriculeVisiteur."',".$codeRapport.",".$codePraticien.",'".$dateDeVisite."','".$bilanDuRapport."','".$motifDeVisite."',".$coefficiantDeConfiance.",'".$dateDuJour."','".$presenceConcurrence."');";
	mysql_query($req);
	//boucle qui permet d'insérer les produits qui ont été présenté au cours de la visite dans la base de données
	for($i=1;$i<3;$i++)
	{//début for
		$produitPresente=$_POST['lstProd'.$i];
		$connaissanceProduitPresente=$_POST['lstNoteProd'.$i];
		if($produitPresente!='0')
		{//début if
			$req="insert into PRESENTE values('".$produitPresente."',".$codeRapport.",".$connaissanceProduitPresente.");";
			mysql_query($req);
		}//fin if
	}//fin for

	$bool=false;
	$i=1;
	//Boucle qui insère dans la base de données les informations sur les échantillons
	while($bool==false)
	{//début while
		//Si il y a des échantillons alors
		if(isset($_POST['lstEchantillon'.$i]))
		{//début if
			$codeEchantillon=$_POST['lstEchantillon'.$i];
			$quantiteEchantillon=$_POST['inputQteEchantillon'.$i];
			$req="insert into OFFRIR values('".$matriculeVisiteur."',".$codeRapport.",'".$codeEchantillon."',".$quantiteEchantillon.");";
			mysql_query($req);
		}//fin if
		else
		{//début else
			$bool=true;
		}//fin else
		$i++;
	}//fin while
	echo("<h3>Rapport de visite enregistre dans la base de donnees</h3>");	
}//fin if

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
		<form name="formRapportVisite" method="post" action="formRAPPORT_VISITE.php">
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
			$req="select * from MOTIF_VISITE;";
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
<?
include("./scripts/pied.html");
?>
