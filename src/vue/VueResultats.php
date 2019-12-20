<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

class VueResultats {

  private $resultats;

  public function __construct($r){
    $this->resultats = $r;
  }

  public function render(){
    $vue = new VueHeader();
    $header = $vue->render();

    $content = "<strong><h2>Résultats</h2></strong><br><center>";

    if (sizeof($this->resultats) > 0){
      foreach ($this->resultats as $value) {
        $id = $value['id'];
        $titre = $value['titre'];

        $content .= <<<END
        <div class="resultat" id='$id' onclick="document.location.href='recette?id=$id'">

          <div class='column'>
            <strong>Titre :</strong> $titre<br><br>
END;

        if (isset($_SESSION['souhaites'])){
          $occurence = $value['occurence'];
          $contient = $value['contient'];

          $content .= <<<END
            Recette possible avec <strong>$occurence</strong> ingrédients souhaités
          </div>

          <div class='column'>
            <strong>Contient :</strong>
END;
          foreach ($contient as $value) {
            $content .= "<div class='contient'>$value</div>";
          }

        }
        $content .= "</div></div>";
      }
    } else {
      $content .= <<<END
      <div id="aucunResultats">

        Aucun résultat de recherche

      </div>
END;
    }

    $html = <<<END
    <!DOCTYPE html>
      <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/VueResultats.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <title>Résultats</title>
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
