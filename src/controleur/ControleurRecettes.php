<?php

namespace cocktails\controleur;

use \cocktails\models\Recette;
use \cocktails\models\Favori;
use \cocktails\vue\VueRecette;

class ControleurRecettes {

  public function afficherRecette(){
    $recette = new Recette($_GET['id']);

    $num = $_GET['id'];
    $titre = $recette->getTitre();
    $ingrs = explode('|',$recette->getIngrs());
    $preparation = $recette->getPreparation();
    $ingredients_requis = $recette->getIngredientsRequis();
    $image = $recette->getImage();
    $fav = false;

    if (isset($_COOKIE['CookieCocktails'])){
      $cookie = unserialize($_COOKIE['CookieCocktails']);
      $id = $cookie['id'];
      $favori = Favori::where('idUtilisateur' , '=', $id)->where('numRecette', '=' , $num)->first();
      if (isset($favori)){
        $fav = true;
      }

    } else if (isset($_SESSION['favoris'])){
      if (in_array($id,$_SESSION['favoris'])){
        $fav = true;
      }

    }


    $vue = new VueRecette($num, $titre, $ingrs, $preparation, $ingredients_requis, $image, $fav);
    $vue->render();
  }

}
