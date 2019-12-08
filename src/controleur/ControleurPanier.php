<?php

namespace cocktails\controleur;

use \cocktails\vue\VuePanier;
use \cocktails\models\Recette;
use \cocktails\models\Favori;

class ControleurPanier {

  public function afficherPanier(){
    $recettesFavs = array();

    if (isset($_COOKIE['CookieCocktails'])) {
      $cookie = unserialize($_COOKIE['CookieCocktails']);
      $id = $cookie['id'];
      $favoris = Favori::all()->where('idUtilisateur' , '=' , $id);
      foreach ($favoris as $value) {
        $recette = new Recette($value->numRecette);
        $recettesFavs[] = $recette;
      }

    } else if (isset($_SESSION['favoris'])){
      foreach ($_SESSION['favoris'] as $value) {
        $recette = new Recette($value);
        $recettesFavs[] = $recette;
      }

    }

    $vue = new VuePanier($recettesFavs);
    $vue->render();
  }
}
