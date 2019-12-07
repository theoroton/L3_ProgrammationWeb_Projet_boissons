<?php

namespace cocktails\models;


abstract class Data
{

  private $cle;

  public function __construct($cle)
  {
    $this->cle = $cle;
  }

  public function getRecettes()
  {
    require('src/Donnees.inc.php');
    return $Recettes;
  }

  public function getIngredients()
  {
    require('src/Donnees.inc.php');
    return $Hierarchie;
  }

  public function getCle()
  {
    return $this->cle;
  }
}
