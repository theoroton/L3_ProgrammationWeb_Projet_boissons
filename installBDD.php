<?php
	//Il faut l'extension mysqli dans php.ini
  function query($link,$requete)
  {
    $resultat=mysqli_query($link,$requete) or die("$requete : ".mysqli_error($link));
	  return($resultat);
  }


$mysqli=mysqli_connect('127.0.0.1', 'root', '') or die("Erreur de connexion");
$base="cocktails";
$mdp = password_hash('test',PASSWORD_DEFAULT,[ 'cost' => 12]);
$Sql="
		DROP DATABASE IF EXISTS $base;
		CREATE DATABASE $base;
		USE $base;

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
      idUtilisateur INT NOT NULL,
      numRecette INT,
      PRIMARY KEY(idFavori),
      FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
    );

    INSERT INTO Utilisateur
    VALUES (1, 'test', '$mdp', 'nom', 'prenom', NULL, 'test@gmail.com', NULL, NULL, NULL, NULL, '0123456789');

    INSERT INTO Favori VALUES (1, 1, 1);
    INSERT INTO Favori VALUES (2, 1, 2)";

foreach(explode(';',$Sql) as $Requete){
  echo $Requete;
  query($mysqli,$Requete);
}

mysqli_close($mysqli);
