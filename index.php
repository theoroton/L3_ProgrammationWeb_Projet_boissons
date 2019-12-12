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

$db=new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

session_start();

$app->get('/accueil', function () {
  ControleurUtilisateur::testConnexion();

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

$app->get('/inscription', function($request, $response, $next){
  if (!isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherInscription();
  } else {
      return $response->withRedirect("accueil");
  }
});

$app->post('/inscription', function($request, $response, $next){
  if (!isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->inscription();
  } else {
      return $response->withRedirect("accueil");
  }
});

$app->get('/profil', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherProfil();
  } else {
      return $response->withRedirect("accueil");
  }
});

$app->get('/modifierProfil', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherModificationProfil();
  } else {
      return $response->withRedirect("accueil");
  }
});

$app->post('/modifierProfil', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->modification();
  } else {
      return $response->withRedirect("accueil");
  }
});

$app->get('/modifierMdp', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherModificationMdp();
  } else {
      return $response->withRedirect("accueil");
  }
});

$app->post('/modifierMdp', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->modificationMdp();
  } else {
      return $response->withRedirect("accueil");
  }
});

$app->get('/recettes', function(){
  ControleurUtilisateur::testConnexion();

  $con = new ControleurRecettes();
  $con->afficherRecherche();
});

$app->get('/search', function (){
  ControleurUtilisateur::testConnexion();

  $con = new ControleurRecettes();
  $con->recherche();
});

$app->get('/recette', function ($request, $response, $next){
  ControleurUtilisateur::testConnexion();

  if (isset($_GET['id'])) {
    $con = new ControleurRecettes();
    $con->afficherRecette();
  } else {
    return $response->withRedirect("recettes");
  }
});

$app->get('/ingredient', function ($request, $response, $next){
  ControleurUtilisateur::testConnexion();

  if (isset($_GET['name'])) {
    $con = new ControleurIngredients();
    $con->afficherIngredient();
  } else {
    return $response->withRedirect("ingredient?name=Aliment");
  }
});

$app->get('/panier', function () {
  ControleurUtilisateur::testConnexion();

  $con = new ControleurPanier();
  $con->afficherPanier();
});

$app->run();
?>