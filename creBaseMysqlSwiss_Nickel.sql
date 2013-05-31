-- -----------------------------------------------------------
-- MDB Tools - A library for reading MS Access database files
-- Copyright (C) 2000-2004 Brian Bruns
-- Files in libmdb are licensed under LGPL and the utilities under
-- the GPL, see COPYING.LIB and COPYING files respectively.
-- Check out http://mdbtools.sourceforge.net
-- ------------------------------------------------------------
-- Date création : 10/05/2013 G.Thomassin & J.Legrand
-- Date dernière modification : 10/05/2013

 create database if not exists db_gestionCR;

-- grant all privileges on *.* to technicien@localhost identified by 'ini01';

 use db_gestionCR;


 ALTER Table VISITEUR 	drop foreign key VISITEUR_FK_SECTEUR,
 			drop foreign key VISITEUR_FK_LABO,
			drop foreign key VISITEUR_FK_DEPARTEMENT;

DROP TABLE IF EXISTS TRAVAILLER;
DROP TABLE IF EXISTS POSSEDER;
DROP TABLE IF EXISTS CONSTITUER;
DROP TABLE IF EXISTS `Switchboard Items`;
DROP TABLE IF EXISTS OFFRIR;
DROP TABLE IF EXISTS REALISER;
DROP TABLE IF EXISTS PRESCRIRE;
DROP TABLE IF EXISTS RAPPORT_VISITE;
DROP TABLE IF EXISTS INVITER;
DROP TABLE IF EXISTS INTERAGIR;
DROP TABLE IF EXISTS FORMULER;

DROP TABLE IF EXISTS SPECIALITE;
DROP TABLE IF EXISTS REGION;
DROP TABLE IF EXISTS DEPARTEMENT;
DROP TABLE IF EXISTS VISITEUR;
DROP TABLE IF EXISTS LABO;
DROP TABLE IF EXISTS SECTEUR;
DROP TABLE IF EXISTS PRATICIEN;
DROP TABLE IF EXISTS MEDICAMENT;
DROP TABLE IF EXISTS FAMILLE;
DROP TABLE IF EXISTS DOSAGE;
DROP TABLE IF EXISTS COMPOSANT;
DROP TABLE IF EXISTS ACTIVITE_COMPL;
DROP TABLE IF EXISTS PRESENTATION;
DROP TABLE IF EXISTS TYPE_PRATICIEN;
DROP TABLE IF EXISTS TYPE_INDIVIDU;

-- les types d'individu
CREATE TABLE TYPE_INDIVIDU
 (
  TIN_CODE         varchar (10) primary key, 
  TIN_LIBELLE      varchar (100)
)engine="innodb";
-- les types de praticien

CREATE TABLE TYPE_PRATICIEN
 (
  TYP_CODE         varchar (6) primary key, 
  TYP_LIBELLE      varchar (50), 
  TYP_LIEU         varchar (70)
)engine="innodb";

-- une présentation

CREATE TABLE PRESENTATION
 (
  PRE_CODE         varchar (4) primary key, 
  PRE_LIBELLE      varchar (40)
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE ACTIVITE_COMPL
 (
  AC_CODE      integer primary key, 
  AC_DATE      date, 
  AC_LIEU      varchar (50), 
  AC_THEME     varchar (20), 
  AC_MOTIF     varchar (100)
)engine="innodb";
-- composant de médicament

CREATE TABLE COMPOSANT
 (
  CMP_CODE         varchar (8) primary key, 
  CMP_LIBELLE      varchar (50)
)engine="innodb";
-- dosage de médicament

CREATE TABLE DOSAGE
 (
  DOS_CODE          varchar (20) primary key, 
  DOS_QUANTITE      varchar (20), 
  DOS_UNITE         varchar (20)
)engine="innodb";

-- les familles de médicament

CREATE TABLE FAMILLE
 (
  FAM_CODE         varchar (6) primary key, 
  FAM_LIBELLE      varchar (160)
)engine="innodb";

-- CREATE ANY INDEXES ...
CREATE TABLE MEDICAMENT
 (
  MED_DEPOTLEGAL       varchar (20) primary key, 
  MED_NOMCOMMERCIAL    varchar (50), 
  FAM_CODE             varchar (6) , 
  MED_COMPOSITION      text, 
  MED_EFFETS           text, 
  MED_CONTREINDIC      text, 
  MED_PRIXECHANTILLON  float,
  foreign key(FAM_CODE) references FAMILLE(FAM_CODE) 
) engine="innodb";
-- CREATE ANY INDEXES ...
CREATE TABLE PRATICIEN
 (
  PRA_CODE             integer primary key, 
  PRA_NOM              varchar (50), 
  PRA_PRENOM           varchar (60), 
  PRA_ADRESSE          varchar (100), 
  PRA_CP               varchar (10), 
  PRA_VILLE            varchar (50), 
  PRA_COEFNOTORIETE    float, 
  TYP_CODE             varchar (6),
  foreign key(TYP_CODE) references TYPE_PRATICIEN(TYP_CODE)
)engine="innodb";
-- le secteur (une region est dans un secteur
CREATE TABLE SECTEUR
 (
  SEC_CODE         varchar (2) primary key, 
  SEC_LIBELLE      varchar (30)
)engine="innodb";
-- CREATE ANY INDEXES ...
CREATE TABLE REGION
 (
  REG_CODE      varchar (4), 
  SEC_CODE      varchar (2), 
  REG_NOM       varchar (100),
  primary key(REG_CODE),
  foreign key (SEC_CODE) references SECTEUR(SEC_CODE) 
)engine="innodb";

-- CREATE ANY INDEXES ...

CREATE TABLE LABO
 (
  LAB_CODE      varchar (4) primary key, 
  LAB_NOM       varchar (20), 
  LAB_CHEFVENTE varchar (40)
)engine="innodb";

CREATE TABLE VISITEUR
 (
  VIS_MATRICULE      varchar (20) primary key, 
  VIS_NOM            varchar (50), 
  VIS_PRENOM         varchar (100), 
  VIS_ADRESSE        varchar (100), 
  VIS_CP             varchar (10), 
  VIS_VILLE          varchar (60), 
  VIS_DATEEMBAUCHE   date, 
  SEC_CODE           varchar (2),
  LAB_CODE           varchar (4),
  DEP_CODE           varchar (3) 
  
) engine="innodb";

-- specialité des praticiens
CREATE TABLE SPECIALITE
 (
  SPE_CODE         varchar (10) primary key, 
  SPE_LIBELLE      text
)engine="innodb";
-- CREATE ANY INDEXES ...

-- CREATE ANY INDEXES ...


CREATE TABLE DEPARTEMENT
(
       DEP_CODE          varchar(3) primary key,
       DEP_NOM           varchar(30),
       DEP_CHEFVENTE     varchar(20),
	foreign key(DEP_CHEFVENTE) references VISITEUR(VIS_MATRICULE)  
)engine="innodb";
-- CREATE ANY INDEXES ...


ALTER Table VISITEUR	add constraint VISITEUR_FK_SECTEUR foreign key(SEC_CODE) references SECTEUR(SEC_CODE) ON DELETE CASCADE, 
			add constraint VISITEUR_FK_LABO foreign key(LAB_CODE) references LABO(LAB_CODE) ON DELETE CASCADE, 
			add constraint VISITEUR_FK_DEPARTEMENT foreign key(DEP_CODE) references DEPARTEMENT(DEP_CODE) ON DELETE CASCADE;


CREATE TABLE FORMULER
 (
  MED_DEPOTLEGAL      varchar (20), 
  PRE_CODE            varchar (4) ,
        primary key(MED_DEPOTLEGAL,PRE_CODE)  ,
  foreign key (MED_DEPOTLEGAL) references MEDICAMENT(MED_DEPOTLEGAL), 
  foreign key(PRE_CODE) references PRESENTATION(PRE_CODE)
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE INTERAGIR
 (
  MED_PERTURBATEUR      varchar (20), 
  MED_MED_PERTURBE      varchar (20),
  PRIMARY KEY(MED_PERTURBATEUR,MED_MED_PERTURBE),
  foreign key(MED_PERTURBATEUR) references MEDICAMENT(MED_DEPOTLEGAL), 
  foreign key(MED_MED_PERTURBE) references MEDICAMENT(MED_DEPOTLEGAL)
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE INVITER
 (
  AC_CODE          integer , 
  PRA_CODE         integer , 
  SPECIALISTEON    Boolean,
  primary key(AC_CODE,PRA_CODE),
  foreign key (AC_CODE) references ACTIVITE_COMPL(AC_CODE), 
  foreign key (PRA_CODE) references PRATICIEN(PRA_CODE)
)engine="innodb";
-- CREATE ANY INDEXES ...


CREATE TABLE PRESCRIRE
 (
  MED_DEPOTLEGAL      varchar (20), 
  TIN_CODE            varchar (10) , 
  DOS_CODE            varchar (20) , 
  PRE_POSOLOGIE       varchar (80),
  primary key(MED_DEPOTLEGAL,TIN_CODE,DOS_CODE),
  foreign key(MED_DEPOTLEGAL) references MEDICAMENT(MED_DEPOTLEGAL), 
  foreign key(TIN_CODE) references TYPE_INDIVIDU(TIN_CODE), 
  foreign key(DOS_CODE) references DOSAGE(DOS_CODE) 
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE RAPPORT_VISITE
 (
  VIS_MATRICULE      varchar (20), 
  RAP_CODE           integer not null, 
  PRA_CODE           integer , 
  RAP_DATE           date, 
  RAP_BILAN          text, 
  RAP_MOTIF          text,
        primary key(RAP_CODE,VIS_MATRICULE),
  	foreign key(VIS_MATRICULE) references VISITEUR(VIS_MATRICULE), 
  foreign key(PRA_CODE) references PRATICIEN(PRA_CODE) 
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE OFFRIR
 (
  VIS_MATRICULE      varchar (20), 
  RAP_CODE           integer, 
  MED_DEPOTLEGAL     varchar (20), 
  OFF_QTE            integer,
  primary key(MED_DEPOTLEGAL,RAP_CODE,VIS_MATRICULE),
  foreign key (VIS_MATRICULE, RAP_CODE) references RAPPORT_VISITE(VIS_MATRICULE,RAP_CODE), 
  foreign key(MED_DEPOTLEGAL) references MEDICAMENT(MED_DEPOTLEGAL)
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE REALISER
 (
  AC_CODE      integer , 
  VIS_MATRICULE      varchar (20) , 
  REA_MTTFRAIS      float,
        primary key(AC_CODE,VIS_MATRICULE),
  foreign key(AC_CODE) references ACTIVITE_COMPL(AC_CODE), 
 foreign key(VIS_MATRICULE) references VISITEUR(VIS_MATRICULE)
)engine="innodb";
-- CREATE ANY INDEXES ...



CREATE TABLE CONSTITUER
 (
  MED_DEPOTLEGAL      varchar (20), 
  CMP_CODE      varchar (8) , 
  CST_QTE      float,
        primary key (MED_DEPOTLEGAL,CMP_CODE),
  foreign key(MED_DEPOTLEGAL) references MEDICAMENT(MED_DEPOTLEGAL), 
  foreign key(CMP_CODE) references COMPOSANT(CMP_CODE)
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE POSSEDER
 (
  PRA_CODE      integer, 
  SPE_CODE      varchar (10), 
  POS_DIPLOME      varchar (20), 
  POS_COEFPRESCRIPTION    float,
        primary key(PRA_CODE,SPE_CODE),
  foreign key(PRA_CODE) references PRATICIEN(PRA_CODE), 
  foreign key(SPE_CODE) references SPECIALITE(SPE_CODE)
)engine="innodb";
-- CREATE ANY INDEXES ...

CREATE TABLE TRAVAILLER
 (
  VIS_MATRICULE varchar (20), 
  JJMMAA      	date , 
  REG_CODE      varchar (4), 
  TRA_ROLE      varchar (22),
        primary key(VIS_MATRICULE,JJMMAA,REG_CODE),
	foreign key (VIS_MATRICULE) references VISITEUR(VIS_MATRICULE),
	foreign key (REG_CODE) references REGION(REG_CODE)
)engine="innodb";

CREATE TABLE `Switchboard Items`
 (
  SwitchboardID      integer, 
  ItemNumber         integer, 
  ItemText           varchar(100), 
  Command            integer, 
  Argument           varchar(100)
)engine="innodb";
-- CREATE ANY INDEXES ...
