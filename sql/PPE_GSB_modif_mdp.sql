-- Script : modification de la base de données pour accueillir les hashs des mots passes des visiteurs
-- en utilisant la technique du grain de sel
-- Auteur : F.Pignoly
-- Date création : 06/08/2013
-- Date modification : 06/08/2013

-- Ajout d'un champs dans la table "VISITEUR"
ALTER TABLE VISITEUR
ADD COLUMN VIS_MDP varchar(50) not null;

ALTER TABLE VISITEUR
ADD COLUMN VIS_GRAINSEL varchar(10) not null;

-- Ajout du même mot de passe (hash du mot de passe "ini01");
UPDATE VISITEUR SET VIS_MDP="e3badfdb3a304199740a6d0022977329";
