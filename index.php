<?php

require_once ('vendor/autoload.php');
$app = new \Slim\App;

use \cocktails\controleur\Controller_test;
use \cocktails\controleur\ControleurIngredients;
use \cocktails\controleur\ControleurRecettes;


$app->get('/', function() {
  echo "<a href=\"ingredient?name=Aliment\">Ingrédient</a>";
});

$app->get('/recette', function() {
  if (isset($_GET['id'])){
    $con = new ControleurRecettes();
    $con->afficherRecette();
  } else {
    echo "Pas de recette";
  }
});

$app->get('/ingredient',function(){
  if (isset($_GET['name'])){
    $con = new ControleurIngredients();
    $con->afficherIngredient();
  } else {
    echo "Pas d'ingrédient";
  }
});

$app->get('/calcul', function(){
  $c = new Controller_test();
  $c->test();
});

$app->run();
