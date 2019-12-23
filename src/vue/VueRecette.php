<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

/*
La vue recette affiche une recette et
toutes ses informations
*/

//Vue recette
class VueRecette  {

  //id de la recette
  private $id;
  //Titre de la recette
  private $titre;
  //Quantités des ingrédients de la recette
  private $ingrs;
  //Préparation de la recette
  private $preparation;
  //Ingrédients de la recette
  private $ingredients_requis;
  //Image de la recette
  private $image;
  //Booléen si l'utilisateur a cette recette en favori
  private $favori;

  /*
  Constructeur de la vue à laquelle on donne
  l'id, le titre, les quantités, la préparation,
  les ingrédients, l'image et le favori.
  */
  public function __construct($i, $t, $in, $p, $ir, $im, $f){
    $this->id = $i;
    $this->titre = $t;
    $this->ingrs = $in;
    $this->preparation = $p;
    $this->ingredients_requis = $ir;
    $this->image = $im;
    $this->favori = $f;
  }

  /*
  Méthode render qui affiche la recette
  */
  public function render(){
      $vue = new VueHeader();
      $header = $vue->render();

      //Affichage de la préparation
      $content = <<<END
        <input type="hidden" id="id" value=$this->id>

        <div id='prep'>
          <strong>Préparation :</strong> $this->preparation<br><br>
        </div>

        <div id='ligne'>
          <div class='colonne'>
            <strong>Quantités :</strong><br><br>
END;

      //Affichage des quantités
      if (sizeof($this->ingrs) == 0){
        $content .= "Aucun ingrédient";
      } else {
        foreach ($this->ingrs as $value) {
          $content .= <<<END
          <div class='ingr'>$value</div>
END;
        }
      }

      $content .= <<<END
        </div>

        <div class='colonne'>
          <strong>Ingrédients requis :</strong><br><br>
END;

      //Affichage des ingrédients
      if (sizeof($this->ingredients_requis) == 0){
        $content .= "Aucun ingrédient";
      } else {
        foreach ($this->ingredients_requis as $value) {
          /*
          On met un lien vers chaque ingrédient pour aller
          dans l'arborescence des ingrédients
          */
          $content .= <<<END
          <a href="ingredient?name=$value">$value</a><br>
END;
        }
      }

      $content .= "</div>";

      //Affichage de l'image

      /*
      Si l'image correspond au chemin donnée existe, alors
      on affiche cette image, sinon on affiche rien.
      */
      if (file_exists($this->image)){
        $content .= <<<END
          <div id='image' class='colonne'>
            <strong>Image :</strong><br>
          <img src=$this->image width=100 height=150>
          </div>
END;
      }

      //Affichage du favori
      $content .= "</div><div id='fav'>";

      /*
      Si la recette est déjà en favori, alors on affiche l'image
      pour enlever la recette des favoris
      */
      if ($this->favori){
        $content .= <<<END
        <img id=delFav class=fav src=img/broken_heart.png width=30 height = 30>
END;

      /*
      Si la recette n'est pas en favori, alors on affiche l'image
      pour ajouter la recette aux favoris
      */
      } else {
        $content .= <<<END
        <img id=addFav class=fav src=img/heart.png width=30 height = 30>
END;
      }

      $content .= "</div>";

      //Contenu à afficher
      $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="css/VueRecette.css">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
          <script src='js/fav.js'></script>
          <title>$this->titre</title>
        </head>
        $header
        <body>
          <h2>$this->titre</h2><br>
          <div id='recette'>
            $content
          </div>
        </body>
      </html>
END;

      echo $html;
  }

}
