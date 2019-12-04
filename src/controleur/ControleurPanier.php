<?php

namespace cocktails\controleur;

use \cocktails\vue\VuePanier;
use \cocktails\models\Recette;

class ControleurPanier {

  public function afficherPanier(){
    $recettesFavs = array();
    foreach ($_SESSION['favoris'] as $value) {
      $recette = new Recette($value);
      $recettesFavs[] = $recette;
    }
    $vue = new VuePanier($recettesFavs);
    $vue->render();
  }
}
