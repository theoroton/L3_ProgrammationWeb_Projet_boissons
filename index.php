<?php

require_once('vendor/autoload.php');
$configuration = ['settings' => ['displayErrorDetails' => true,],];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

use \Illuminate\Database\Capsule\Manager as DB;
use \cocktails\controleur\ControleurIngredients;
use \cocktails\controleur\ControleurRecettes;
use \cocktails\controleur\ControleurPanier;
use \cocktails\controleur\ControleurUtilisateur;
use \cocktails\controleur\ControleurProfil;

$db=new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

session_start();

$app->get('/accueil', function () {
  $con = new ControleurUtilisateur();
  $con->afficherAccueil();
});

$app->get('/connexion', function(){
  $con = new ControleurUtilisateur();
  $con->afficherConnexion();
});

$app->post('/connexion', function(){
  $con = new ControleurUtilisateur();
  $con->connexion();
});

$app->get('/inscription', function(){
  $con = new ControleurUtilisateur();
  $con->afficherInscription();
});

$app->post('/inscription', function(){
  $con = new ControleurUtilisateur();
  $con->inscription();
});

$app->get('/profil', function() use ($app){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherProfil();
  } else {
      $app->redirect('/profil', '/accueil');
  }
});

$app->get('/modifierProfil', function(){
  $con = new ControleurUtilisateur();
  $con->afficherModificationProfil();
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
