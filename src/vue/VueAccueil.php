<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

/*
La vue accueil affiche l'accueil du site sur lequel
se trouve des informations sur le site
*/

//Vue accueil
class  VueAccueil
{

    /*
    Méthode render qui affiche l'accueil
    */
    public function render()
    {
        //Ajout du header
        $vue = new VueHeader();
        $header = $vue->render();

        //Contenu à afficher
        $html = <<<END
        <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" type="text/css" href="css/VueAccueil.css">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
          <title>Accueil</title>
        </head>
        $header
        <body>
            <div class="bienvenue">
                <h2>Bienvenue sur Cocktails, la meilleure application pour créer des cocktails raffraichissants !</h2>
                <h3>Cliquez sur <strong>Ingrédients</strong> dans la barre de navigation pour commencer l'aventure.</h3>
                <img id="accueil" src="img/accueil.jpg" alt="Photo de cocktails" />
            </div>
        </body>
END;
        echo $html;
    }
}
