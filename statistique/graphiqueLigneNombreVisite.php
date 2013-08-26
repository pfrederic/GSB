<?php    
 //Graphique linéaire des visites réalisé par les visiteurs ces 12 derniers mois

 //Fichier permettant l'appel de fonction et des variables sessions
 include("../scripts/parametres.php");
 include("../scripts/fonction.php");

 //Appel des fichiers de la librairie nécessaire
 include("../pChart/class/pData.class.php"); 
 include("../pChart/class/pDraw.class.php"); 
 include("../pChart/class/pImage.class.php"); 

 //Récupération de la region de l'utilisateur connecté
 $region=$_SESSION['region'];

 //Tableau des mois de l'année, utilisé plus tard connaître le nom des mois selon leur numéro
 $mois=array(1=>"Jan", 2=>"Fev", 3=>"Mar", 4=>"Avr", 5=>"Mai", 6=>"Jun", 7=>"Jui", 8=>"Aou", 9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec");

 //Requête permettant de connaître selon le mois de l'années le nombre de visites réalisé par les visiteur d'une région
 $req="select substring(RAP_DATEVISITE,6,2) mois, count(*) nbVisite from RAPPORT_VISITE inner join VISITEUR on RAPPORT_VISITE.VIS_MATRICULE=VISITEUR.VIS_MATRICULE inner join TRAVAILLER on VISITEUR.VIS_MATRICULE=TRAVAILLER.VIS_MATRICULE where REG_CODE='".$region."' and RAP_DATEVISITE>CURRENT_DATE-interval 1 year group by mois;";
 //Envoie de la requête
 $resultat=mysql_query($req);
 //Boucle qui parcours les occurences
 while($ligne=mysql_fetch_array($resultat))
 {//début while
	//Récupération du numéro de mois en convertion en entier
	$numMois=intval($ligne['mois']);
	//Mise dans un tableau du nom du mois retouné par la base
	$nomMois[]=$mois[$numMois];
	//Mise dans un tableau du nombre de visite retourné par la base
	$nombreVisite[]=$ligne['nbVisite'];
 }//fin while
 
 //Création d'un objet contenant mes données pour le graphique
 $MyData = new pData();   
 $MyData->addPoints($nombreVisite,"Nombre de visites"); 
 $MyData->setSerieWeight("Nombre de visites",2); 
 $MyData->setAxisName(0,"Nombre de visite"); 
 $MyData->addPoints($nomMois,"Labels"); 
 $MyData->setSerieDescription("Labels","Months"); 
 $MyData->setAbscissa("Labels");

 //Création de l'objet qui contiendra l'image
 $myPicture = new pImage(650,300,$MyData); 

 //Désactivation de l'antialiasing
 $myPicture->Antialias = FALSE; 

 //Ajout d'une bordure d'image
 $myPicture->drawRectangle(0,0,649,299,array("R"=>0,"G"=>0,"B"=>0)); 
  
 //Ecriture du titre du graphique 
 $myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/Forgotte.ttf","FontSize"=>11)); 
 $myPicture->drawText(150,35,"Nombre de visites",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

 //Définition de la police d'écriture par défaut
 $myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/pf_arma_five.ttf","FontSize"=>6)); 

 //Définition de la zone du graphique
 $myPicture->setGraphArea(60,40,600,240); 

 //Dessin de l'échelle
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Factors"=>array(1)); 
 $myPicture->drawScale($scaleSettings); 

 //Activation de l'anti-aliasing
 $myPicture->Antialias = TRUE; 

 //Dessin de la ligne du graphique
 $myPicture->drawLineChart(); 

 //Ecriture de la légende du graphique
 $myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

 //Ecriture de la légende du graphique dans un encadré
 $myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/pf_arma_five.ttf","FontSize"=>6)); 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20)); 
 $myPicture->drawText(325,275,"Nombre de visites sur ces 12 derniers mois",array("FontSize"=>8,"DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

 //Rendu de l'image
 $myPicture->autoOutput("../images/nombreVisiteEquipe.png"); 
?>
