<?php

namespace cocktails\models;

//Classe Recette qui étend Data
class Recette extends Data
{

  ///Titre d'une recette
  private $titre;
  //Quantités des ingrédients d'une recette
  private $ingrs;
  //Préparation d'une recette
  private $preparation;
  //Ingrédients d'une recette
  private $ingredients_requis;

  /*
  Constructeur d'une recette
  On crée l'objet à partir de la clé
  */
  public function __construct($cle)
  {
    parent::__construct($cle);

    //On récupére la recette grâce à sa clé
    $recette = $this->getRecettes()[$cle];
    $this->titre = $recette['titre'];
    $this->ingrs = $recette['ingredients'];
    $this->preparation = $recette['preparation'];
    $this->ingredients_requis = $recette['index'];
  }

  /*
  Méthode getTitre qui permet de récupérer
  le titre d'une recette
  */
  public function getTitre()
  {
    return $this->titre;
  }

  /*
  Méthode getIngrs qui permet de récupérer
  les quantités d'ingrédeints d'une recette
  */
  public function getIngrs()
  {
    return $this->ingrs;
  }

  /*
  Méthode getPreparation qui permet de récupérer
  la préparation d'une recette
  */
  public function getPreparation()
  {
    return $this->preparation;
  }

  /*
  Méthode getIngredientsRequis qui permet de récupérer
  les ingrédients d'une recette
  */
  public function getIngredientsRequis()
  {
    return $this->ingredients_requis;
  }

  /*
  Méthode getImage qui permet de récupérer
  l'image d'une recette
  */
  public function getImage()
  {
    //Chemin du dossier des photos
    $path = "data/Photos/";

    //Table de changement des caractères spéciaux
    $table = array(
      'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E',
      'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
      'Ö' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
      'ä' => 'a', 'å' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
      'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ù' => 'u', 'ú' => 'u',
      'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', ' ' => '_', '\'' => ''
    );

    //Utilisation de la table
    $t = strtr($this->titre, $table);
    //On met en majuscule la première lettre en majuscules et les autres en minuscules
    $t = ucwords($t);

    //Ajout de l'extension de l'image
    $path .= $t . ".jpg";
    return $path;
  }
}
