<?php
 //Graphique du nombre de visite par motif

include("../scripts/parametres.php");
include("../scripts/fonction.php");

 //Catégorie graphique : graphique à barre

//Appel des fichiers de la librairie nécessaire
 
 include("../pChart/class/pData.class.php"); 
 include("../pChart/class/pDraw.class.php"); 
 include("../pChart/class/pImage.class.php"); 


//Requete pour les données

$visiteur=$_SESSION['login'];
//$req="select MOT_LIB, count(*) nbFois from MOTIF_VISITE inner join RAPPORT_VISITE on RAPPORT_VISITE.MOT_CODE=MOTIF_VISITE.MOT_CODE where VIS_MATRICULE='".$visiteur."' and RAP_DATEVISITE>CURRENT_DATE-interval 3 month group by MOTIF_VISITE.MOT_CODE;";
$req="select MOT_LIB, count(*) nbFois from MOTIF_VISITE inner join RAPPORT_VISITE on RAPPORT_VISITE.MOT_CODE=MOTIF_VISITE.MOT_CODE where RAP_DATEVISITE>CURRENT_DATE-interval 3 month group by MOTIF_VISITE.MOT_CODE;";
$resultat=mysql_query($req);

while($ligne=mysql_fetch_array($resultat))
{//début while
	$nomMotif[]=$ligne['MOT_LIB'];
	$nbVisite[]=$ligne['nbFois'];
}//fin while

 //Création d'un objet contenant mes données pour le graphique
 $MyData = new pData();   
 $MyData->addPoints($nbVisite,"Nb Visite"); 
 $MyData->setAxisName(0,"Nombre de visites"); 
 $MyData->addPoints($nomMotif,"Motifs"); 
 $MyData->setSerieDescription("Motifs","Motif"); 
 $MyData->setAbscissa("Motifs"); 

 //Creation d'un objet qui contiendra une image
 $myPicture = new pImage(650,300,$MyData); 

 //Désactivation de l'anti-aliasing
 $myPicture->Antialias = FALSE; 

 //Ajout d'une bordure à l'image
 $myPicture->drawRectangle(0,0,649,299,array("R"=>0,"G"=>0,"B"=>0)); 

 //Définition de la police de caractère par défaut
 $myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/pf_arma_five.ttf","FontSize"=>6)); 

 //Définition de la zone du graphique
 $myPicture->setGraphArea(60,40,650,200); 

 //Déssin de l'échelle
 $scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
 $myPicture->drawScale($scaleSettings); 

 //Ecriture de la légende du graphique
 $myPicture->drawLegend(580,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

 //Ajout de l'ombre à l'image 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

 //Dessin du graphique
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
 $settings = array("Gradient"=>TRUE,"GradientMode"=>GRADIENT_EFFECT_CAN,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
 $myPicture->drawBarChart(); 

 //Rendu de l'image
 $myPicture->autoOutput("../images/motifVisite.png"); 
?>
