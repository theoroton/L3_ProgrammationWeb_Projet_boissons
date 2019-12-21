<?php

namespace cocktails\controleur;

use \cocktails\vue\VuePanier;
use \cocktails\models\Recette;
use \cocktails\models\Favori;

//Controleur Panier
class ControleurPanier {

  /*
  Méthode qui récupére les favoris d'un utilisateur
  non connecté ou connecté, crée la vue du panier
  et l'affiche.
  */
  public function afficherPanier(){
    $recettesFavs = array();

    /*
    Si l'utilisateur est connecté, on récupère les recettes
    favorites dans la base de données.
    */
    if (isset($_COOKIE['CookieCocktails'])) {
      //On désérialise le cookie afin de récupérer l'id
      $cookie = unserialize($_COOKIE['CookieCocktails']);
      $id = $cookie['id'];

      //On récupère les recettes favorites de l'utilisateur dans la base
      $favoris = Favori::all()->where('idUtilisateur' , '=' , $id);

      /*
      Pour chaque recette, on crée un objet recette avec le numéro de
      celle-ci et on l'ajoute dans le tableau de résultats.
      */
      foreach ($favoris as $value) {
        $recette = new Recette($value->numRecette);
        $recettesFavs[] = $recette;
      }

    /*
    Sinon on récupère les recettes contenues dans la variable
    de session.
    */
    } else if (isset($_SESSION['favoris'])){
      /*
      Pour chaque recette, on crée un objet recette avec le numéro de
      celle-ci et on l'ajoute dans le tableau de résultats.
      */
      foreach ($_SESSION['favoris'] as $value) {
        $recette = new Recette($value);
        $recettesFavs[] = $recette;
      }

    }

    //Création de la vue et affichage
    $vue = new VuePanier($recettesFavs);
    $vue->render();
  }
}
