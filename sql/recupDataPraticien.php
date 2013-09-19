<?
	//Attente : Gérer les cabinets, en affectant des praticiens à des cabinets, et en sachant si lors de la visite si c'était un remplaçant
	//Connexion à la base
	
	$host="127.0.0.1";
	$user="technicien";
	$mdp="ini01";
	$db="db_gestionCR";
	mysql_connect($host,$user,$mdp);
	mysql_select_db($db);

	//Suppression d'une table
	mysql_query("DROP TABLE if exists CABINET");
	//Création d'une table
	mysql_query("CREATE TABLE CABINET(CAB_CODE integer primary key, CAB_ADRESSE varchar(30), CAB_CP varchar(5), CAB_VILLE varchar(30))engine=\"innodb\"");

	//Suppresion d'une table
	mysql_query("DROP TABLE if exists AFFECTATION");
	//Création d'une table
	mysql_query("CREATE TABLE AFFECTATION(PRA_CODE integer, CAB_CODE integer, PRIMARY KEY(PRA_CODE,CAB_CODE), foreign key(PRA_CODE) references PRATICIEN(PRA_CODE), foreign key(CAB_CODE) references CABINET(CAB_CODE))engine=innodb");


	//Requête permettant de récupérer les données du cabinet (adresse...)
	$requetePourData="SELECT PRA_CODE, PRA_ADRESSE, PRA_CP, PRA_VILLE FROM PRATICIEN";
	$resultatPourData=mysql_query($requetePourData) or die(mysql_error());

	//initialisation
	$i=1;

	//boucle qui parcours les occurences
	while($rowPourData=mysql_fetch_array($resultatPourData))
	{//début while
		$adresse=$rowPourData['PRA_ADRESSE'];
		$cp=$rowPourData['PRA_CP'];
		$ville=$rowPourData['PRA_VILLE'];
		//J'insère les données des cabinet dans la table "CABINET", selon les données dans la table "PRATICIEN"
		$requeteInsertionData="INSERT INTO CABINET VALUES($i, '$adresse', '$cp', '$ville')";
		mysql_query($requeteInsertionData);
		$i=$i+1;//incrémentation

	}//fin while

	//Je récupère les données des cabinets pour les comparer avec celle des praticiens afin de d'affecter le bon praticien au bon cabinet

	$requetePourData="SELECT PRA_CODE, PRA_ADRESSE, PRA_CP, PRA_VILLE FROM PRATICIEN";
	$resultatPourData=mysql_query($requetePourData) or die(mysql_error());

	//boucle qui parcours les praticien
	while($rowPourData2=mysql_fetch_array($resultatPourData))
	{//début while
		$requetePourAffection="SELECT * FROM CABINET";
		$resultatPourAffection=mysql_query($requetePourAffection);
		//boucle qui parcours les cabinets
		while($rowPourAffectation=mysql_fetch_array($resultatPourAffection))
		{//debut while
			//comparaison des cabinets et des praticiens pour voir si ca correspond
			if(($rowPourData2['PRA_ADRESSE']==$rowPourAffectation['CAB_ADRESSE']) && ($rowPourData2['PRA_CP']==$rowPourAffectation['CAB_CP']) && ($rowPourData2['PRA_VILLE']==$rowPourAffectation['CAB_VILLE']))
			{//début if
				//si bon, alors j'affecte les bons praticiens aux bons cabinets
				$praCode=$rowPourData2['PRA_CODE'];
				$cabCode=$rowPourAffectation['CAB_CODE'];
				mysql_query("INSERT INTO AFFECTATION VALUES($praCode,$cabCode)");
			}//fin if
		}//fin while
	}//fin while

	//Suppression dans champs en trop dans praticiens
	mysql_query("ALTER TABLE PRATICIEN DROP COLUMN PRA_ADRESSE");
	mysql_query("ALTER TABLE PRATICIEN DROP COLUMN PRA_CP");
	mysql_query("ALTER TABLE PRATICIEN DROP COLUMN PRA_VILLE");

?>
