<?php

namespace cocktails\controleur;

use \cocktails\models\Recette;
use \cocktails\vue\VueRecette;

class ControleurRecettes {

  public function afficherRecette(){
    $recette = new Recette($_GET['id']);

    $id = $_GET['id'];
    $titre = $recette->getTitre();
    $ingrs = explode('|',$recette->getIngrs());
    $preparation = $recette->getPreparation();
    $ingredients_requis = $recette->getIngredientsRequis();
    $image = $recette->getImage();
    $fav = false;
    if (in_array($id,$_SESSION['favoris'])){
      $fav = true;
    }

    $vue = new VueRecette($id, $titre, $ingrs, $preparation, $ingredients_requis, $image, $fav);
    $vue->render();
  }

}
