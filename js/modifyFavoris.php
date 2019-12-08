<?php

require_once('../vendor/autoload.php');

use \cocktails\models\Favori;

use \Illuminate\Database\Capsule\Manager as DB;

$db=new DB();
$db->addConnection(parse_ini_file('../src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

session_start();

function delFav($num){
  if (isset($_COOKIE['CookieCocktails'])){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $favori = Favori::where('idUtilisateur' , '=', $id)->where('numRecette', '=' , $num)->first();
    
    if (isset($favori)){
      $favori->delete();
    }


  } else if (isset($_SESSION['favoris'])){
    if (in_array($num, $_SESSION['favoris'])){
      $key = array_search($num, $_SESSION['favoris']);
      unset($_SESSION['favoris'][$key]);
    }
  }

}

function addFav($num){
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

  } else if (isset($_SESSION['favoris'])) {
    if (!in_array($num, $_SESSION['favoris'])){
      $_SESSION['favoris'][] = intval($num);
    }
  }
}

if (isset($_POST['callDelFav'])) {
  delFav($_POST['callDelFav']);
}

if (isset($_POST['callAddFav'])) {
  addFav($_POST['callAddFav']);
}
