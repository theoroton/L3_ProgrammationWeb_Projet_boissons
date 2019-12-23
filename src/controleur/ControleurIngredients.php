<?php

namespace cocktails\controleur;

use \cocktails\models\Ingredient;
use \cocktails\models\Data;
use \cocktails\vue\VueIngredient;

//Controleur Ingrédients
class ControleurIngredients {

  /*
  Méthode qui récupére les informations d'un ingrédient,
  crée la vue correspondante et l'affiche.
  */
  public function afficherIngredient(){
    /*
    Si le nom d'ingrédient donnée existe dans les données,
    alors on peut afficher cet ingrédient.
    */
    if (array_key_exists($_GET['name'], Data::getIngredients())){
      //Création de l'ingrédient
      $ingredient = new Ingredient($_GET['name']);

      //Récupération des informations
      $nom = $_GET['name'];
      $parents = $ingredient->getParents();
      $fils = $ingredient->getFils();
      $recettesLiees = $ingredient->getRecettesLiees();

      //Création de la vue et affichage
      $vue = new VueIngredient($nom, $parents, $fils, $recettesLiees);
      $vue->render();
    } else {
        /*
        Si le nom donné n'existe pas, on redirige l'utilisateur
        sur l'ingrédient père de tous : Aliment.
        */
        header("Refresh:0; url=ingredient");
    }
  }
}
