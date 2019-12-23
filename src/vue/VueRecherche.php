<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

/*
La vue recherche affiche l'interface de recherche

La vue recherche contient :
- 2 div qui contienent respectivement les
ingrédients souhaités et les ingrédients non
souhaités.
- 1 bouton pour Réinitialiser les ingrédients dans
ces div.
- 1 champ de recherche pour trouver un ingrédient
- 2 boutons qui permettent d'ajouter l'ingrédient
recherché dans une div
- 1 bouton pour effectuer la recherche
*/

//Vue recherche
class VueRecherche {

  /*
  Méthode render qui affiche l'accueil
  */
  public function render(){
      //Ajout du header
      $vue = new VueHeader();
      $header = $vue->render();

      $content = <<<END
      <div id='contenu'>
        <div id='ingredients'>
          <label class='label' for="souhaite">Ingrédients souhaités</label>
          <label class='label' for="nesouhaitepas">Ingrédients non souhaités</label>

          <div id='souhaite' class='divContenu'>
          </div>

          <div id='nesouhaitepas' class='divContenu'>
          </div>
        </div>

        <button id="reinit" type="button">Réinitialiser</button>

        <div id='recherche'>
          <label class='label' for="search">Recherche d'un ingrédient</label><br>
          <input id="search" type="text" autocomplete="off" />
          <div id='results'></div>
          <div id='erreur'></div>
        </div>

        <div id='actions'>
          <button id="addIngreSouhaiter" type="button">Souhaiter</button>
          <button id="addIngrePasSouhaiter" type="button">Non souhaiter</button>
        </div>

        <button id="effectuerRecherche" type="button">Recherche</button>
      </div>
END;

      //Contenu à afficher
      $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="css/VueRecherche.css">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
          <script src='js/recherche.js'></script>
          <title>Recherche</title>
        </head>
        $header
        <body>

        <h2>Recherche</h2><br>

        $content

        </body>
      </html>
END;

      echo $html;
  }

}
