<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

class  VueAccueil
{

    public function render()
    {
        $vue = new VueHeader();
        $header = $vue->render();
        $html = <<<END
        <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <title>Accueil</title>
          <link rel="stylesheet" type="text/css" href="css/cocktails.css">
          <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link rel="stylesheet" href="style/cocktails.css">
        </head>
        $header
        <body>
            <div class="bienvenue">
                <h2>Bienvenue sur Cocktails, la meilleure application pour créer des cocktails raffraichissants!</h2>
                <h3>Cliquez sur <strong>Ingrédients</strong> dans la barre de navigation pour commencer l'aventure.</h3>
                <img class="acceuil " src="img/acceuil.jpg" alt="Photo de cocktails" />
            </div>
        </body>
END;
        echo $html;
    }
}
