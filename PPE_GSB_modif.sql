-- Script : Script de modification de la base de données pour répondre aux attentes des employés, suite à l'interview des visiteurs
-- Auteur : P.Frédéric
-- Date création : 14/05/2013
-- Date dernière modification : 22/05/2013

-- Attente : Le motif des visites doit être prédéfinis
DROP TABLE if exists MOTIF_VISITE;
CREATE TABLE MOTIF_VISITE
 (
 MOT_CODE	integer primary key,
 MOT_LIB	varchar(30)
 )engine="innodb";

INSERT INTO MOTIF_VISITE
VALUES(1,"Visite annuelle"),(2,"Remontant"),(3,"Autre");

ALTER TABLE RAPPORT_VISITE
DROP COLUMN RAP_MOTIF;

ALTER TABLE RAPPORT_VISITE
ADD COLUMN MOT_CODE integer;

ALTER TABLE RAPPORT_VISITE
ADD foreign key (MOT_CODE) references MOTIF_VISITE(MOT_CODE);

UPDATE RAPPORT_VISITE SET MOT_CODE=1 WHERE VIS_MATRICULE="a131";
UPDATE RAPPORT_VISITE SET MOT_CODE=2 WHERE VIS_MATRICULE="a17";

-- Attente : Gestion des échantillons
DROP TABLE if exists ECHANTILLIONS;
CREATE TABLE ECHANTILLIONS
 (
 ECH_CODE		integer,
 ECH_DEMANDEMENSUEL	integer,
 ECH_ATTRIBUTIONMENSUEL integer,
 ECH_MOIS		varchar(6),
 VIS_MATRICULE		varchar(20),
 MED_DEPOTLEGAL		varchar(20),
 PRIMARY KEY(ECH_CODE,VIS_MATRICULE),
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

-- Attente : Savoir si lors d'une visite, si c'était un remplaçant (gestion de cabinet)
ALTER TABLE RAPPORT_VISITE ADD COLUMN RAP_REMPLACANT integer;

-- Attente : Le visiteur évalue le praticien sur les connaissances des produits & 2 produits max présenté par visite
DROP TABLE if exists PRESENTE;
CREATE TABLE PRESENTE
 ( 
 PRE_CODE integer,
 MED_DEPOTLEGAL varchar(20),
 RAP_CODE integer,
 PRE_CONNAISSANCE integer,
 PRIMARY KEY(PRE_CODE,MED_DEPOTLEGAL),
 foreign key(MED_DEPOTLEGAL) references MEDICAMENT(MED_DEPOTLEGAL),
 foreign key(RAP_CODE) references RAPPORT_VISITE(RAP_CODE)
 )engine="innodb";
 
-- Attente : Coeff de prescription d'un praticien (vérifier si pas déjà gérer dans la base de données)
ALTER TABLE PRATICIEN ADD COLUMN PRA_COEFPRESCRIPTION integer;
