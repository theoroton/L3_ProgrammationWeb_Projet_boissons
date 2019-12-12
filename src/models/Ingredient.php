<?php

namespace cocktails\models;

class Ingredient extends Data {

  private $parents;
  private $fils;

  public function __construct($cle){
    parent::__construct($cle);
    $ingredient = $this->getIngredients()[$cle];

    if (isset($ingredient['super-categorie'])){
      $this->parents = $ingredient['super-categorie'];
    } else {
      $this->parents = null;
    }

    if (isset($ingredient['sous-categorie'])){
      $this->fils = $ingredient['sous-categorie'];
    } else {
      $this->fils = null;
    }
  }

  public function getParents(){
    return $this->parents;
  }

  public function getFils(){
    return $this->fils;
  }

  public function getRecettesLiees(){
    $Recettes = $this->getRecettes();

    $recettesAvecIngredient = array();

    foreach ($Recettes as $key => $value) {
      if (in_array($this->getCle(), $value['index'])){
        $recettesAvecIngredient[] = array('id' => $key,
                                          'titre' => $value['titre'],
                                          'ingredient' => $this->getCle());
      }
    }

    return $recettesAvecIngredient;
  }
}
