<?php

namespace cocktails\controleur;

use \cocktails\models\Ingredient;
use \cocktails\vue\VueIngredient;

class ControleurIngredients {

  public function afficherIngredient(){
    $ingredient = new Ingredient($_GET['name']);

    $nom = $_GET['name'];
    $parents = $ingredient->getParents();
    $fils = $ingredient->getFils();
    $recettesLiees = $ingredient->getRecettesLiees();

    $vue = new VueIngredient($nom, $parents, $fils, $recettesLiees);
    $vue->render();
  }
}
