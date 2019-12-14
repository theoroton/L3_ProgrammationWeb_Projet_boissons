<?php

namespace cocktails\models;

class Recette extends Data
{

  private $titre;
  private $ingrs;
  private $preparation;
  private $ingredients_requis;

  public function __construct($cle)
  {
    parent::__construct($cle);
    $recette = $this->getRecettes()[$cle];
    $this->titre = $recette['titre'];
    $this->ingrs = $recette['ingredients'];
    $this->preparation = $recette['preparation'];
    $this->ingredients_requis = $recette['index'];
  }

  public function getTitre()
  {
    return $this->titre;
  }

  public function getIngrs()
  {
    return $this->ingrs;
  }

  public function getPreparation()
  {
    return $this->preparation;
  }

  public function getIngredientsRequis()
  {
    return $this->ingredients_requis;
  }

  public function getImage()
  {
    $path = "data/Photos/";

    $table = array(
      'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E',
      'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
      'Ö' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
      'ä' => 'a', 'å' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
      'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ù' => 'u', 'ú' => 'u',
      'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', ' ' => '_', '\'' => ''
    );

    $t = strtr($this->titre, $table);
    $t = ucwords($t);

    $path .= $t . ".jpg";
    return $path;
  }
}
