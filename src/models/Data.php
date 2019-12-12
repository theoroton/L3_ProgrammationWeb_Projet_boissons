<?php

namespace cocktails\models;


abstract class Data
{

  private $cle;

  public function __construct($cle)
  {
    $this->cle = $cle;
  }

  public static function getRecettes()
  {
    require('src/data/Donnees.inc.php');
    return $Recettes;
  }

  public static function getIngredients()
  {
    require('src/data/Donnees.inc.php');
    return $Hierarchie;
  }

  public function getCle()
  {
    return $this->cle;
  }
}
