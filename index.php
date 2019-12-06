<?php

require_once('vendor/autoload.php');
$app = new \Slim\App;

use \cocktails\controleur\Controller_test;
use \cocktails\controleur\ControleurIngredients;
use \cocktails\controleur\ControleurRecettes;
use \cocktails\controleur\ControleurPanier;
use \cocktails\vue\VueAccueil;

session_start();

$app->get('/', function () {
  if (!isset($_SESSION['favoris'])) {
    $_SESSION['favoris'] = array(99, 1, 2);
  } else {
    echo "<pre>", var_dump($_SESSION['favoris']), "</pre>";
  }
  $vue = new VueAccueil();
  $vue->render();
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

$app->get('/calcul', function () {

  $c = new Controller_test();
  $c->test();
});

//session_destroy();

$app->run();
