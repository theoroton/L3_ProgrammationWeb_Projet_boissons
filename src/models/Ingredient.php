<?php

namespace cocktails\models;

//Classe Ingredient qui étend Data
class Ingredient extends Data {

  //Ingrédients parents d'un ingrédient
  private $parents;
  //Ingrédients fils d'un ingrédient
  private $fils;

  /*
  Constructeur d'un ingrédient
  On crée l'objet à partir de la clé
  */
  public function __construct($cle){
    parent::__construct($cle);

    //On récupére l'ingrédient grâce à sa clé
    $ingredient = $this->getIngredients()[$cle];

    /*
    Si l'ingrédient à des parents, alors on les ajoutent.
    Sinon on met null
    */
    if (isset($ingredient['super-categorie'])){
      $this->parents = $ingredient['super-categorie'];
    } else {
      $this->parents = null;
    }

    /*
    Si l'ingrédient à des fils, alors on les ajoutent.
    Sinon on met null
    */
    if (isset($ingredient['sous-categorie'])){
      $this->fils = $ingredient['sous-categorie'];
    } else {
      $this->fils = null;
    }
  }

  /*
  Méthode getParents qui permet de récupérer
  les parents d'un ingrédient
  */
  public function getParents(){
    return $this->parents;
  }

  /*
  Méthode getFils qui permet de récupérer
  les fils d'un ingrédient
  */
  public function getFils(){
    return $this->fils;
  }

  /*
  Méthode getRecettesLiees qui permet de récupérer
  les recettes où cet ingrédient est utilisé
  */
  public function getRecettesLiees(){
    //On récupére les recettes données
    $Recettes = $this->getRecettes();

    $recettesAvecIngredient = array();

    /*
    Pour chaque recette, si l'ingrédient courant est
    utilisé dans celle-ci, alors on récupère la recette
    */
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
