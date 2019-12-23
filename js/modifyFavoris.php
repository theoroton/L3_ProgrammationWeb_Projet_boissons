<?php

//Inclusion de l'autoload
require_once('../vendor/autoload.php');

use \cocktails\models\Favori;

use \Illuminate\Database\Capsule\Manager as DB;

//Nouvelle connexion pour manier la BDD
$db=new DB();
$db->addConnection(parse_ini_file('../src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

//Requis pour manier les variables de sessions
session_start();

/*
Fonction delFav qui supprime une recette des favoris,
grâce à son id envoyé par Ajax.
*/
function delFav($num){
  /*
  Si l'utilisateur est connecté, alors on va supprimer cette
  recette de la base de données.
  */
  if (isset($_COOKIE['CookieCocktails'])){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $favori = Favori::where('idUtilisateur' , '=', $id)->where('numRecette', '=' , $num)->first();

    if (isset($favori)){
      $favori->delete();
    }

  /*
  Si l'utilisateur n'est pas connecté, alors on va supprimer cette
  recette de la variable de session 'favoris'.
  */
  } else if (isset($_SESSION['favoris'])){
    if (in_array($num, $_SESSION['favoris'])){
      $key = array_search($num, $_SESSION['favoris']);
      unset($_SESSION['favoris'][$key]);
    }
  }

}

/*
Fonction addFav qui ajoute une recette aux favoris,
grâce à son id envoyé par Ajax.
*/
function addFav($num){
  /*
  Si l'utilisateur est connecté, alors on va ajouter cette
  recette à la base de données, dans la table Favori, afin
  de la mémoriser.
  */
  if (isset($_COOKIE['CookieCocktails'])){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $favori = Favori::where('idUtilisateur' , '=', $id)->where('numRecette', '=' , $num)->first();

    if (!isset($favori)){
      $favori = new Favori();
      $favori->idUtilisateur = $id;
      $favori->numRecette = $num;
      $favori->save();
    }

  /*
  Si l'utilisateur n'est pas connecté, alors on va ajoute
  cette recette à la variable de session 'favoris'.
  Quand la session sera terminer, alors l'utilisateur perdra
  ses recettes.
  */
  } else if (isset($_SESSION['favoris'])) {
    if (!in_array($num, $_SESSION['favoris'])){
      $_SESSION['favoris'][] = intval($num);
    }
  }
}

/*
Si le paramètre envoyer par Ajax correspond
à 'callDelFav', alors on exécute la fonction
qui enlève une recette des favoris.
*/
if (isset($_POST['callDelFav'])) {
  delFav($_POST['callDelFav']);
}

/*
Si le paramètre envoyer par Ajax correspond
à 'callAddFav', alors on exécute la fonction
qui ajoute une recette aux favoris.
*/
if (isset($_POST['callAddFav'])) {
  addFav($_POST['callAddFav']);
}
