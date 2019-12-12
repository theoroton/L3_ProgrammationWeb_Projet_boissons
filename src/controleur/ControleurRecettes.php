<?php

namespace cocktails\controleur;

use \cocktails\models\Recette;
use \cocktails\models\Ingredient;
use \cocktails\models\Favori;
use \cocktails\models\Data;
use \cocktails\vue\VueRecette;
use \cocktails\vue\VueRecherche;
use \cocktails\vue\VueResultats;

class ControleurRecettes {

  public function afficherRecette(){
    if (array_key_exists($_GET['id'], Data::getRecettes())){
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
        if (in_array($num,$_SESSION['favoris'])){
          $fav = true;
        }

      }


      $vue = new VueRecette($num, $titre, $ingrs, $preparation, $ingredients_requis, $image, $fav);
      $vue->render();
    } else {
      header("Refresh:0; url=recettes");
    }
  }

  public function afficherRecherche(){
    $ingredients = Data::getIngredients();
    $_SESSION['souhaites'] = null;
    $_SESSION['nonsouhaites'] = null;

    $vue = new VueRecherche($ingredients);
    $vue->render();
  }

  private function getAllRecettesFils($igr){
    $ingredient = new Ingredient($igr);

    $recettesFinales = $ingredient->getRecettesLiees();

    if (!is_null($ingredient->getFils())){
      $fils = $ingredient->getFils();
    } else {
      $fils = array();
    }

    while (sizeof($fils) > 0){
      $nouveauxFils = array();

      foreach ($fils as $value) {
        $ingredient = new Ingredient($value);

        $recettes = $ingredient->getRecettesLiees();

        foreach ($recettes as $key => $value) {
          if (!in_array($value['id'], $recettesFinales)){
            $recettesFinales[] = $value;
          }
        }

        if (!is_null($ingredient->getFils())){
          $nouveauxFils = array_merge ($nouveauxFils, $ingredient->getFils());
        }
      }

      $fils = $nouveauxFils;
    }

    return $recettesFinales;
  }

  public function recherche(){
    $recettes = array();

    if (isset($_SESSION['souhaites'])){
      foreach ($_SESSION['souhaites'] as $igr) {
        $recettesLiees = $this->getAllRecettesFils($igr);

        foreach ($recettesLiees as $value) {
          $id = $value['id'];
          $contient = $value['ingredient'];

          if (!array_key_exists($id, $recettes)){
            $recettes[$id] = array('id' => $id, 'titre' => $value['titre'], 'occurence' => 1, 'contient' => array($contient));

          } else if (!in_array($contient, $recettes[$id]['contient'])) {
            $recettes[$id]['contient'][] = $contient;
            $recettes[$id]['occurence']++;
          }
        }
      }
    } else {
      $allRecettes = Data::getRecettes();

      foreach ($allRecettes as $key => $value) {
        $recettes[$key] = array('id' => $key, 'titre' => $value['titre']);
      }
    }

    if (isset($_SESSION['nonsouhaites'])){
      foreach ($_SESSION['nonsouhaites'] as $igr) {
        $recettesLiees = $this->getAllRecettesFils($igr);

        foreach ($recettesLiees as $value) {
          $id = $value['id'];
          if (array_key_exists($id, $recettes)){
            unset($recettes[$id]);
          }
        }
      }
    }

    if (isset($_SESSION['souhaites'])){
      usort($recettes, function($a, $b) {
        $a = $a['occurence'];
        $b = $b['occurence'];
        if ($a == $b){
          return 0;
        }
          return ($a < $b) ? 1 : -1;
        });
    } else {
      usort($recettes, function($a, $b) {
        return strnatcasecmp($a['titre'], $b['titre']);
      });
    }

    //echo "<pre>" , var_dump($recettes) , "</pre>";


    $vue = new VueResultats($recettes);
    $vue->render();
  }

}
