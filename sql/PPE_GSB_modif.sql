-- Script : Script de modification de la base de données pour répondre aux attentes des employés, suite à l'interview des visiteurs
-- Auteur : P.Frédéric
-- Date création : 14/05/2013
-- Date dernière modification : 06/08/2013

-- Attente : Le motif des visites doit être prédéfinis
DROP TABLE if exists MOTIF_VISITE;
CREATE TABLE MOTIF_VISITE
 (
 MOT_CODE	varchar(3) primary key,
 MOT_LIB	varchar(30)
 )engine="innodb";

INSERT INTO MOTIF_VISITE VALUES('PRD','Périodicité'),('ACT','Actualisation'),('REL','Relance'),('SOL','Sollicitation praticien'),('AUT','Autre');

ALTER TABLE RAPPORT_VISITE
DROP COLUMN RAP_MOTIF;

ALTER TABLE RAPPORT_VISITE
ADD COLUMN MOT_CODE varchar(3);

ALTER TABLE RAPPORT_VISITE
ADD foreign key (MOT_CODE) references MOTIF_VISITE(MOT_CODE);

-- Attente : Gestion des échantillons
DROP TABLE if exists ECHANTILLIONS_DISTRIBUES;
CREATE TABLE ECHANTILLIONS_DISTRIBUES
 (
 ECH_CODE		integer,
 ECH_DEMANDEMENSUEL	integer,
 ECH_ATTRIBUTIONMENSUEL integer,
 ECH_MOIS		varchar(6), -- <---------DEMANDER POUR CA --------->
 VIS_MATRICULE		varchar(20),
 MED_DEPOTLEGAL		varchar(20),
 PRIMARY KEY(ECH_CODE),
 foreign key(VIS_MATRICULE) references VISITEUR(VIS_MATRICULE),
 foreign key(MED_DEPOTLEGAL) references MEDICAMENT(MED_DEPOTLEGAL)
 )engine="innodb";

-- Attente : Ajouter un coefficient de confiance sur la visite
ALTER TABLE RAPPORT_VISITE ADD COLUMN RAP_COEFCONFIANCE integer;

-- Attente : Connaitre la date de visite, celle de saisie et la durée de la saisie
ALTER TABLE RAPPORT_VISITE CHANGE COLUMN RAP_DATE RAP_DATEVISITE date;
ALTER TABLE RAPPORT_VISITE ADD COLUMN RAP_DATESAISIE date;
ALTER TABLE RAPPORT_VISITE ADD COLUMN RAP_DUREESAISIE integer;

-- Attente : Noter la présence de la concurrence lors d'une visite
ALTER TABLE RAPPORT_VISITE ADD COLUMN RAP_CONCURRENCE varchar(25);

-- Attente : Le visiteur évalue le praticien sur les connaissances des produits
-- Attente : 2 produits max présenté par visite

DROP TABLE if exists PRESENTE;
CREATE TABLE PRESENTE
 (
 MED_DEPOTLEGAL varchar(20),
 RAP_CODE integer,
 PRE_CONNAISSANCE integer,
 PRIMARY KEY(MED_DEPOTLEGAL,RAP_CODE),
 foreign key(MED_DEPOTLEGAL) references MEDICAMENT(MED_DEPOTLEGAL),
 foreign key(RAP_CODE) references RAPPORT_VISITE(RAP_CODE)
 )engine="innodb";
 
-- Attente : Coeff de prescription d'un praticien (vérifier si pas déjà gérer dans la base de données)

-- Attente : Gérer les responsables, dans une nouvelle table
DROP TABLE if exists RESPONSABLE;
CREATE TABLE RESPONSABLE
 (
 RES_CODE varchar(20),
 VIS_MATRICULE varchar(20),
 PRIMARY KEY(RES_CODE,VIS_MATRICULE)
 )engine="innodb";

ALTER TABLE RESPONSABLE
ADD FOREIGN KEY (VIS_MATRICULE) REFERENCES VISITEUR(VIS_MATRICULE);

INSERT INTO RESPONSABLE VALUES('r01','a17');

-- Attente : Gérer les délégués, dans une nouvelle table
DROP TABLE if exists DELEGUE;
CREATE TABLE DELEGUE
 (
 DEL_CODE varchar(20),
 VIS_MATRICULE varchar(20),
 PRIMARY KEY(DEL_CODE,VIS_MATRICULE)
 )engine="innodb";

ALTER TABLE DELEGUE
ADD FOREIGN KEY (VIS_MATRICULE) REFERENCES VISITEUR(VIS_MATRICULE);

INSERT INTO DELEGUE VALUES('d01','e22');
