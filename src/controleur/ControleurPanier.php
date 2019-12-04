<?php

namespace cocktails\controleur;

use \cocktails\vue\VuePanier;
use \cocktails\models\Recette;

class ControleurPanier {

  public function afficherPanier(){
    //var_dump($_SESSION['favoris']);
    // if (isset($_GET['recetteID'])){
    //   echo "<br>ID : " . $_GET['recetteID'];
    // }
    $recettesFavs = array();
    foreach ($_SESSION['favoris'] as $value) {
      $recette = new Recette($value);
      $recettesFavs[] = $recette;
    }
    $vue = new VuePanier($recettesFavs);
    $vue->render();
  }
}
