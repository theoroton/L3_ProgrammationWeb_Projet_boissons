<?php

namespace cocktails\vue;

use \cocktails\models\Recette;

class VuePanier {

  private $recettesFavs;

  public function __construct($rF){
    $this->recettesFavs = $rF;
  }

  public function render(){
      $content = "<strong><h2>Panier</h2></strong><br><br><center>";

      if (sizeof($this->recettesFavs) > 0){
        foreach ($this->recettesFavs as $value) {
          $id = $value->getCle();
          $titre = $value->getTitre();
          $content .= <<<END
          <div class="recette" id='$id' onclick="document.location.href='recette?id=$id'">

            <strong>Titre :</strong> $titre<br>

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

      $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link rel="stylesheet" href="css/VuePanier.css">
          <title>Panier</title>
        </head>

        <body>

          $content

        </body>
      </html>
END;

      echo $html;
  }

}
