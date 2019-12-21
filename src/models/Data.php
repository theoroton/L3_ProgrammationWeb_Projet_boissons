<?php

namespace cocktails\models;

/*
Classe abstraite Data qui sera hériter
par les objets Ingredient & Recette.
*/
abstract class Data
{

  //Attribut clé d'un objet
  private $cle;

  /*
  Constructeur de l'objet.
  On associe la clé à l'objet.
  */
  public function __construct($cle)
  {
    $this->cle = $cle;
  }

  /*
  Méthode getRecettes qui permet de récupérer l'ensemble
  des recettes contenues dans le fichier de données
  */
  public static function getRecettes()
  {
    require('data/Donnees.inc.php');
    return $Recettes;
  }

  /*
  Méthode getIngredients qui permet de récupérer l'ensemble
  des ingrédients contenus dans le fichier de données
  */
  public static function getIngredients()
  {
    require('data/Donnees.inc.php');
    return $Hierarchie;
  }

  /*
  Méthode qui permet de récupérer la clé de l'objet
  */
  public function getCle()
  {
    return $this->cle;
  }
}
