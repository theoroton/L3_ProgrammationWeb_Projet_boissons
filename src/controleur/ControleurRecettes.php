<?php

namespace cocktails\controleur;

use \cocktails\models\Recette;
use \cocktails\models\Ingredient;
use \cocktails\models\Favori;
use \cocktails\models\Data;
use \cocktails\vue\VueRecette;
use \cocktails\vue\VueRecherche;
use \cocktails\vue\VueResultats;

//Controleur Recettes
class ControleurRecettes {

  /*
  Méthode qui récupére les informations d'une recette,
  crée la vue correspondante et l'affiche.
  */
  public function afficherRecette(){
    /*
    Si l'id de la recette donnée existe dans les données,
    alors on peut afficher cette recette.
    */
    if (array_key_exists($_GET['id'], Data::getRecettes())){
      //On crée la recette grâce à son id
      $recette = new Recette($_GET['id']);

      //Récupération des informations
      $num = $_GET['id'];
      $titre = $recette->getTitre();
      $ingrs = explode('|',$recette->getIngrs());
      $preparation = $recette->getPreparation();
      $ingredients_requis = $recette->getIngredientsRequis();
      $image = $recette->getImage();
      $fav = false;

      /*
      Si l'utilisateur est connecté, on regarde dans la BDD
      si la recette courante est en favori.
      */
      if (isset($_COOKIE['CookieCocktails'])){
        $cookie = unserialize($_COOKIE['CookieCocktails']);
        $id = $cookie['id'];
        $favori = Favori::where('idUtilisateur' , '=', $id)->where('numRecette', '=' , $num)->first();
        if (isset($favori)){
          $fav = true;
        }

      /*
      Sinon on regarde dans la variable de sessions.
      */
      } else if (isset($_SESSION['favoris'])){
        if (in_array($num,$_SESSION['favoris'])){
          $fav = true;
        }
      }

      //Création de la vue et affichage
      $vue = new VueRecette($num, $titre, $ingrs, $preparation, $ingredients_requis, $image, $fav);
      $vue->render();
    } else {
      /*
      Si l'id donné n'existe pas, on redirige l'utilisateur
      sur la recherche des recettes.
      */
      header("Refresh:0; url=recettes");
    }
  }

  /*
  Méthode qui crée la vue de la recherche
  et l'affiche
  */
  public function afficherRecherche(){
    $_SESSION['souhaites'] = null;
    $_SESSION['nonsouhaites'] = null;

    $vue = new VueRecherche();
    $vue->render();
  }

  /*
  Méthode qui permet de récupérer les recettes d'un ingrédient
  et celles de tous les ingrédients fils dans la hiérarchie.
  */
  private function getAllRecettesFils($igr){
    //Ingrédient de base
    $ingredient = new Ingredient($igr);

    //Tableau de résultat
    $recettesFinales = $ingredient->getRecettesLiees();

    if (!is_null($ingredient->getFils())){
      $fils = $ingredient->getFils();
    } else {
      $fils = array();
    }

    //Si l'ingrédient à des fils
    while (sizeof($fils) > 0){
      //Fils des fils et etc...
      $nouveauxFils = array();

      //Pour chaque fils
      foreach ($fils as $value) {
        //Nouvel ingrédient
        $ingredient = new Ingredient($value);

        //On récupère les recettes de l'ingrédient courant
        $recettes = $ingredient->getRecettesLiees();

        //Pour chacune des recettes
        foreach ($recettes as $key => $value) {
          //Si la recette n'est pas déjà dans le tableau de résultat, on l'ajoute
          if (!in_array($value['id'], $recettesFinales)){
            $recettesFinales[] = $value;
          }
        }

        //Si l'ingrédient a des fils, ils deviennent les nouveaux fils
        if (!is_null($ingredient->getFils())){
          $nouveauxFils = array_merge ($nouveauxFils, $ingredient->getFils());
        }
      }
      //On recommence jusqu'à être à la fin de la hiérarchie
      $fils = $nouveauxFils;
    }

    return $recettesFinales;
  }

  /*
  Méthode qui permet de faire la recherche à partir des ingrédients
  souhaités et non souhaités.
  */
  public function recherche(){
    $recettes = array();

    /*
    Si il y a des ingrédients souhaités, on récupère les recettes
    pour chacun de ces ingrédients.
    */
    if (isset($_SESSION['souhaites'])){
      foreach ($_SESSION['souhaites'] as $igr) {
        $recettesLiees = $this->getAllRecettesFils($igr);

        //Pour chacune des recettes de l'ingrédient courant
        foreach ($recettesLiees as $value) {
          $id = $value['id'];
          $contient = $value['ingredient'];

          /*
          Si la recette n'est pas dans le tableau, on l'ajoute en indiquant que c'est
          la première occurence de cette recette et le premier ingrédient utilisé dans
          cette recette.
          */
          if (!array_key_exists($id, $recettes)){
            $recettes[$id] = array('id' => $id, 'titre' => $value['titre'], 'occurence' => 1, 'contient' => array($contient));

          /*
          Sinon, on a déjà la recette dans le tableau, on augmente le nombre d'occurence de
          1 et on ajoute l'ingrédient courant.
          */
          } else if (!in_array($contient, $recettes[$id]['contient'])) {
            $recettes[$id]['contient'][] = $contient;
            $recettes[$id]['occurence']++;
          }
        }
      }
    /*
    Si aucun ingrédient est souhaité, on récupère toutes les recettes.
    */
    } else {
      $allRecettes = Data::getRecettes();

      foreach ($allRecettes as $key => $value) {
        $recettes[$key] = array('id' => $key, 'titre' => $value['titre']);
      }
    }

    /*
    Si il y a des ingrédients non souhaités, on récupère les recettes
    pour chacun de ces ingrédients.

    Si il y a aucune ingrédient souhaités mais des ingrédients non souhaités,
    alors on récupère l'ensemble des recettes moins celles non souhaités.
    */
    if (isset($_SESSION['nonsouhaites'])){
      foreach ($_SESSION['nonsouhaites'] as $igr) {
        $recettesLiees = $this->getAllRecettesFils($igr);

        //Pour chacune des recettes de l'ingrédient courant
        foreach ($recettesLiees as $value) {
          $id = $value['id'];
          //Si la recette est dans le tableau des recettes, on l'enlève
          if (array_key_exists($id, $recettes)){
            unset($recettes[$id]);
          }
        }
      }
    }

    /*
    Si on a des ingrédients souhaités, alors on va trier
    les recettes par le nombre d'ingrédients souhaités
    dans celle-ci.
    */
    if (isset($_SESSION['souhaites'])){
      usort($recettes, function($a, $b) {
        $a = $a['occurence'];
        $b = $b['occurence'];
        if ($a == $b){
          return 0;
        }
          return ($a < $b) ? 1 : -1;
        });

    /*
    Sinon, on trie les recettes par ordre alphabétique.
    */
    } else {
      usort($recettes, function($a, $b) {
        return strnatcasecmp($a['titre'], $b['titre']);
      });
    }

    //Création de la vue et affichage
    $vue = new VueResultats($recettes);
    $vue->render();
  }

}
