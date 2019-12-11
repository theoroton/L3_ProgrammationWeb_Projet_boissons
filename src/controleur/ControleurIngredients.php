<?php

namespace cocktails\controleur;

use \cocktails\models\Ingredient;
use \cocktails\models\Data;
use \cocktails\vue\VueIngredient;

class ControleurIngredients {

  public function afficherIngredient(){
    if (array_key_exists($_GET['name'], Data::getIngredients())){
      $ingredient = new Ingredient($_GET['name']);

      $nom = $_GET['name'];
      $parents = $ingredient->getParents();
      $fils = $ingredient->getFils();
      $recettesLiees = $ingredient->getRecettesLiees();

      $vue = new VueIngredient($nom, $parents, $fils, $recettesLiees);
      $vue->render();
    } else {
        header("Refresh:0; url=ingredient");
    }
  }
}
