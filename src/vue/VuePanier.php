<?php

namespace cocktails\vue;

use \cocktails\models\Recette;
use \cocktails\vue\VueHeader;

/*
La vue panier affiche les recettes favorites
de l'utilisateur.
*/

//Vue accueil
class VuePanier {

  //Recette favorites
  private $recettesFavs;

  /*
  Constructeur de la vue à laquelle on donne
  les recettes favorites à afficher.
  */
  public function __construct($rF){
    $this->recettesFavs = $rF;
  }

  /*
  Méthode render qui affiche le panier
  */
  public function render(){
      //Ajout du header
      $vue = new VueHeader();
      $header = $vue->render();

      $content = "<h2>Mes recettes préférées</h2><br><center>";

      /*
      Si on a des recettes favorites, alors on les affiche.
      Sinon on affiche que l'utilisateur n'a aucune recettes
      favorites.
      */
      if (sizeof($this->recettesFavs) > 0){
        foreach ($this->recettesFavs as $value) {
          $id = $value->getCle();
          $titre = $value->getTitre();
          $content .= <<<END
          <div class='recette'>
            <div class='lienR' id='$id' onclick="document.location.href='recette?id=$id'">
              <strong>Titre :</strong> $titre<br>
            </div>
            <img class=delFavPanier src=img/croix.png width=40 height=40 value='$id'>
          </div>

END;
        }
      } else {
        $content .= <<<END
        <div id="recetteVide">

          Aucune recettes favorites

        </div>
END;
      }


      $content .= "</center>";

      //Contenu à afficher
      $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="css/VuePanier.css">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
          <script src='js/fav.js'></script>
          <title>Panier</title>
        </head>
        $header
        <body>

          $content

        </body>
      </html>
END;

      echo $html;
  }

}
