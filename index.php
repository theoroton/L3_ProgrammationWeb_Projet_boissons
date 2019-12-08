<?php

require_once('vendor/autoload.php');
$app = new \Slim\App;

use \Illuminate\Database\Capsule\Manager as DB;
use \cocktails\controleur\ControleurIngredients;
use \cocktails\controleur\ControleurRecettes;
use \cocktails\controleur\ControleurPanier;
use \cocktails\controleur\ControleurConnexion;
use \cocktails\controleur\ControleurProfil;

$db=new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

session_start();

$app->get('/accueil', function () {
  $con = new ControleurConnexion();
  $con->afficherAccueil();
});

$app->get('/connexion', function(){
  $con = new ControleurConnexion();
  $con->afficherConnexion();
});

$app->post('/connexion', function(){
  $con = new ControleurConnexion();
  $con->connexion();
});

$app->get('/inscription', function(){
  $con = new ControleurConnexion();
  $con->afficherInscription();
});

$app->post('/inscription', function(){
  $con = new ControleurConnexion();
  $con->inscription();
});

$app->get('/profil', function(){
  $con = new ControleurProfil();
  $con->afficherProfil();
});

$app->get('/recette', function () {
  if (isset($_GET['id'])) {
    $con = new ControleurRecettes();
    $con->afficherRecette();
  } else {
    echo "Pas de recette";
  }
});

$app->get('/ingredient', function () {
  if (isset($_GET['name'])) {
    $con = new ControleurIngredients();
    $con->afficherIngredient();
  } else {
    echo "Pas d'ingrédient";
  }
});

$app->get('/panier', function () {
  $con = new ControleurPanier();
  $con->afficherPanier();
});

$app->run();
