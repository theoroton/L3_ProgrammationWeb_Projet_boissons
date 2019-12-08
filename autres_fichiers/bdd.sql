CREATE TABLE Utilisateur ( 
idUtilisateur INT NOT NULL AUTO_INCREMENT, 
 login VARCHAR(50), 
 mdp VARCHAR(255), 
 nom VARCHAR(50), 
 prenom VARCHAR(50), 
 sexe VARCHAR(10), 
 email VARCHAR(100), 
 dateNaiss DATE, 
 adresse VARCHAR(100), 
 codePostal VARCHAR(5), 
 ville VARCHAR(50), 
 tel VARCHAR(10), 
PRIMARY KEY(idUtilisateur)
);

CREATE TABLE Favori (
 idFavori INT NOT NULL AUTO_INCREMENT,
 idUtilisateur INT,
 numRecette INT,
 PRIMARY KEY(idFavori),
 Foreign Key (idUtilisateur) References utilisateur(idUtilisateur)
);