<?php

//Inclusion de l'autoload
require_once('vendor/autoload.php');

/*
Configuration de Slim
*/
$configuration = ['settings' => ['displayErrorDetails' => true,],];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);


/*
Utilisation d'alias pour retrouver les classes
dans l'arborescence.
Dans chaque classe on commence par indiquer
le namespace de celle-ci en fonction du dossier
où elle se trouve:

namespace cocktails\<dossier>;

*/
use \Illuminate\Database\Capsule\Manager as DB;
use \cocktails\controleur\ControleurIngredients;
use \cocktails\controleur\ControleurRecettes;
use \cocktails\controleur\ControleurPanier;
use \cocktails\controleur\ControleurUtilisateur;

/*
Création de la base de données et connexion avec les
informations de connexion du fichier 'conf.ini'
*/
$db=new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
//Démarrage d'Eloquent
$db->bootEloquent();

//Création de la session
session_start();

/*
Ceci est le fichier principale qui va permettre de
naviguer sur le site.
Grâce à Slim, quand une des urls ci-dessous sera entré,
Slim se chargera automatiquement de trouver le chemin
et exécutera les opérations liés à ces chemins.
On utilise aussi Slim dans certains cas afin de rediriger
l'utilisateur.
*/


/*
Url : accueil
Méthode : GET

On appelle le contrôleur qui permet d'afficher la page
d'accueil.
*/
$app->get('/accueil', function () {
  ControleurUtilisateur::testConnexion();

  $con = new ControleurUtilisateur();
  $con->afficherAccueil();
});

$app->get('/', function($request, $response, $next) {
  return $response->withRedirect("accueil");
});


/*
Url : connexion
Méthode : GET

On appelle le contrôleur qui permet d'afficher la page
de connexion.
*/
$app->get('/connexion', function(){
  $con = new ControleurUtilisateur();
  $con->afficherConnexion();
});

/*
Url : connexion
Méthode : POST

On appelle le contrôleur qui permet de gérer la connexion
d'un utilisateur au site.
*/
$app->post('/connexion', function(){
  $con = new ControleurUtilisateur();
  $con->connexion();
});

/*
Url : inscription
Méthode : GET

Si l'utilisateur dispose déjà du cookie du site, alors on
le redirige vers l'accueil car il est déjà connecté.
Sinon on appelle le controleur qui affiche l'inscription.
*/
$app->get('/inscription', function($request, $response, $next){
  if (!isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherInscription();
  } else {
      return $response->withRedirect("accueil");
  }
});

/*
Url : inscription
Méthode : POST

Si l'utilisateur dispose déjà du cookie du site, alors on
le redirige vers l'accueil car il est déjà connecté.
Sinon on appelle le controleur qui permet de gérer l'inscription
d'un utilisateur.
*/
$app->post('/inscription', function($request, $response, $next){
  if (!isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->inscription();
  } else {
      return $response->withRedirect("accueil");
  }
});

/*
Url : profil
Méthode : GET

Si l'utilisateur ne dispose pas du cookie du site, alors on
le redirige vers l'accueil car il n'est pas connecté.
Sinon on appelle le controleur qui affiche le profil.
*/
$app->get('/profil', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherProfil();
  } else {
      return $response->withRedirect("accueil");
  }
});

/*
Url : modifierProfil
Méthode : GET

Si l'utilisateur ne dispose pas du cookie du site, alors on
le redirige vers l'accueil car il n'est pas connecté.
Sinon on appelle le controleur qui affiche la page
de modification du profil.
*/
$app->get('/modifierProfil', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherModificationProfil();
  } else {
      return $response->withRedirect("accueil");
  }
});

/*
Url : modifierProfil
Méthode : POST

Si l'utilisateur ne dispose pas du cookie du site, alors on
le redirige vers l'accueil car il n'est pas connecté.
Sinon on appelle le controleur qui permet de gérer la
modification du profil de l'utilisateur.
*/
$app->post('/modifierProfil', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->modification();
  } else {
      return $response->withRedirect("accueil");
  }
});

/*
Url : modifierMdp
Méthode : GET

Si l'utilisateur ne dispose pas du cookie du site, alors on
le redirige vers l'accueil car il n'est pas connecté.
Sinon on appelle le controleur qui affiche la page
de modification du mot de passe.
*/
$app->get('/modifierMdp', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->afficherModificationMdp();
  } else {
      return $response->withRedirect("accueil");
  }
});

/*
Url : modifierMdp
Méthode : POST

Si l'utilisateur ne dispose pas du cookie du site, alors on
le redirige vers l'accueil car il n'est pas connecté.
Sinon on appelle le controleur qui permet de gérer
la modification du profil de l'utilisateur.
*/
$app->post('/modifierMdp', function($request, $response, $next){
  if (isset($_COOKIE['CookieCocktails'])) {
      $con = new ControleurUtilisateur();
      $con->modificationMdp();
  } else {
      return $response->withRedirect("accueil");
  }
});

/*
Url : recettes
Méthode : GET


On appelle le controleur qui affiche la page
de recherche de recettes.
*/
$app->get('/recettes', function(){
  ControleurUtilisateur::testConnexion();

  $con = new ControleurRecettes();
  $con->afficherRecherche();
});

/*
Url : search
Méthode : GET


On appelle le controleur qui affiche la page
de résultats de recherche.
*/
$app->get('/search', function (){
  ControleurUtilisateur::testConnexion();

  $con = new ControleurRecettes();
  $con->recherche();
});

/*
Url : recette
Méthode : GET


On appelle le controleur qui affiche la page
d'une recette.
Si on ne détecte pas l'id dans l'url, alors on
dirige l'utilisateur sur la page de recherche de
recettes.
*/
$app->get('/recette', function ($request, $response, $next){
  ControleurUtilisateur::testConnexion();

  if (isset($_GET['id'])) {
    $con = new ControleurRecettes();
    $con->afficherRecette();
  } else {
    return $response->withRedirect("recettes");
  }
});

/*
Url : ingredient
Méthode : GET


On appelle le controleur qui affiche la page
d'un ingrédient.
Si on ne détecte pas le nom dans l'url, alors on
dirige l'utilisateur sur l'ingrédient père de tous :
Aliment.
*/
$app->get('/ingredient', function ($request, $response, $next){
  ControleurUtilisateur::testConnexion();

  if (isset($_GET['name'])) {
    $con = new ControleurIngredients();
    $con->afficherIngredient();
  } else {
    return $response->withRedirect("ingredient?name=Aliment");
  }
});

/*
Url : panier
Méthode : GET


On appelle le controleur qui affiche la page
du panier
*/
$app->get('/panier', function () {
  ControleurUtilisateur::testConnexion();

  $con = new ControleurPanier();
  $con->afficherPanier();
});

//On lance Slim
$app->run();
?>
