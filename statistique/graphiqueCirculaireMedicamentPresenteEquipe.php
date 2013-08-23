<?
// Ce script est un génére un graphique grâce à la librairie pChart, des médicament présenté par le visiteur connecté

include("../scripts/parametres.php");
include("../scripts/fonction.php");

//Catégorie graphique : graphique circulaire

//Appel des fichiers de la librairie nécessaire
 include("../pChart/class/pData.class.php"); 
 include("../pChart/class/pDraw.class.php"); 
 include("../pChart/class/pPie.class.php"); 
 include("../pChart/class/pImage.class.php");

//Requête pour données
$region=$_SESSION['region'];
$req="select MED_NOMCOMMERCIAL, count(*) nbFois from MEDICAMENT inner join PRESENTE on MEDICAMENT.MED_DEPOTLEGAL=PRESENTE.MED_DEPOTLEGAL inner join RAPPORT_VISITE on RAPPORT_VISITE.RAP_CODE=PRESENTE.RAP_CODE inner join TRAVAILLER on TRAVAILLER.VIS_MATRICULE=RAPPORT_VISITE.VIS_MATRICULE where REG_CODE='".$region."' and RAP_DATEVISITE>CURRENT_DATE-interval 3 month group by MEDICAMENT.MED_DEPOTLEGAL;";
$resultat=mysql_query($req);
while($ligne=mysql_fetch_array($resultat))
{//début while
	$nomMedoc[]=$ligne['MED_NOMCOMMERCIAL'];
	$nbMedoc[]=$ligne['nbFois'];
}//fin while

//Création d'un objet contenant mes données pour le graphique
 $MyData = new pData();
 $MyData->addPoints($nbMedoc,"ScoreA");
 $MyData->setSerieDescription("ScoreA","Application A");

//Je présente la série de données à utiliser pour le graphique et je détermine le nom de l'axe verticale
 $MyData->addPoints($nomMedoc,"Labels"); 
 $MyData->setAbscissa("Labels"); 

//Création de l'objet qui contiendra l'image
 $myPicture = new pImage(650,300,$MyData,TRUE);

//Dessine un cadre
// $myPicture->drawRectangle(0,0,300,100,array("R"=>0,"G"=>0,"B"=>0));

//Définition du fond
 $Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237); 
 $myPicture->drawFilledRectangle(0,0,750,300,$Settings); 

//Fond en dégradé avec un style de révêtement
 $Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50); 
 $myPicture->drawGradientArea(0,0,750,300,DIRECTION_VERTICAL,$Settings); 
 $myPicture->drawGradientArea(0,0,750,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); 

//Ajout d'une bordure pour l'image
 $myPicture->drawRectangle(0,0,649,299,array("R"=>0,"G"=>0,"B"=>0)); 

//Ecriture d'un titre de l'image 
 $myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/Silkscreen.ttf","FontSize"=>6)); 
 $myPicture->drawText(10,13,"Medicament presente pendant les visites",array("R"=>255,"G"=>255,"B"=>255)); 

//Définition de la police d'écriture par défaut
 $myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80)); 

 //Création de l'objet du graphique circulaire 
 $PieChart = new pPie($myPicture,$MyData); 

//Cadre avec la légendre
 $PieChart->drawPieLegend(450,90,array("BoxSize"=>15,"FontSize"=>13));

//Définition de la tranche de couleur
 $PieChart->setSliceColor(0,array("R"=>143,"G"=>197,"B"=>0)); 
 $PieChart->setSliceColor(1,array("R"=>97,"G"=>77,"B"=>63)); 
 $PieChart->setSliceColor(2,array("R"=>97,"G"=>113,"B"=>63)); 

//Dessin du graphique circulaire en version explosé
 $PieChart->draw3DPie(200,165,array("Radius"=>160,"WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE)); 

//Ecriture de la légende du graphique
 $myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/pf_arma_five.ttf","FontSize"=>6)); 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20)); 
 $myPicture->drawText(325,275,"Pourcentage des medicaments presente lors des visites de ces 3 derniers mois par vos collaborateurs",array("FontSize"=>8,"DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

//Rendu de l'image
  $myPicture->autoOutput("../images/medicamentPresente.png");
?>
