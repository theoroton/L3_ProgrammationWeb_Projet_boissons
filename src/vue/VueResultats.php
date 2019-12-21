<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

/*
La vue accueil affiche les recettes trouvées
après avoir effectuer une recherche.
*/

//Vue resultats
class VueResultats {

  //Recettes résultantes de la recherche
  private $resultats;

  /*
  Constructeur de la vue à laquelle
  on donne les recettes issues de la
  recherche.
  */
  public function __construct($r){
    $this->resultats = $r;
  }

  /*
  Méthode render qui affiche les résultats
  */
  public function render(){
    //Ajout du header
    $vue = new VueHeader();
    $header = $vue->render();

    $content = "<strong><h2>Résultats</h2></strong><br><center>";

    /*
    Si il y a des recettes trouvées, alors on va les affichées, avec
    les ingrédients souhaités données lors de la recherche et leurs
    nombre d'occurence afin de savoir qu'elle recette correspond
    le plus aux critères donnés.
    Sinon, on affiche qu'il n'y a aucun résultat de recherche.
    */
    if (sizeof($this->resultats) > 0){
      foreach ($this->resultats as $value) {
        $id = $value['id'];
        $titre = $value['titre'];

        /*
        Pour chaque recette, on met un lien vers
        celle-ci pour l'afficher.
        */
        $content .= <<<END
        <div class="resultat" id='$id' onclick="document.location.href='recette?id=$id'">

          <div class='column'>
            <strong>Titre :</strong> $titre<br><br>
END;

        if (isset($_SESSION['souhaites'])){
          /*
          On récupère le nombre d'occurence de la recette
          et les ingrédients qu'elle contient afin d'afficher
          ces informations.
          */
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

    //Contenu à afficher
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
