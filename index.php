<?php

require_once('vendor/autoload.php');
$app = new \Slim\App;

use \cocktails\controleur\ControleurIngredients;
use \cocktails\controleur\ControleurRecettes;
use \cocktails\controleur\ControleurPanier;
use \cocktails\controleur\ControleurConnexion;
use \cocktails\vue\VueAccueil;

session_start();

$app->get('/accueil', function () {
  if (!isset($_SESSION['favoris'])) {
    $_SESSION['favoris'] = array();
  }
  $vue = new VueAccueil();
  $vue->render();
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

//session_destroy();

$app->run();
