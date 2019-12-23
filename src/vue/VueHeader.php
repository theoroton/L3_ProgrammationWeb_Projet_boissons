<?php

namespace cocktails\vue;

/*
La vue header affiche l'header du site sur lequel se
trouve les liens permettant de rejoindre :
l'accueil, la hiérarchie des ingrédients, la recherche
de recettes, le panier, le profil et la connexion.

L'header sera afficher sur les toutes les pages du site.
*/

//Vue header
class VueHeader
{

    /*
    Méthode render qui affiche le header
    */
    public function render()
    {

        /*
        Si l'utilisateur est connecté, on a le lien vers le profil
        et la déconnexion dans le header. Sinon, on a le lien vers
        la connexion.
        */
        if (isset($_COOKIE['CookieCocktails'])){
          $liens = <<<END
            <a href="profil">Profil</a>
            <a href="connexion">Déconnexion</a>
END;
        } else {
          $liens = <<<END
            <a href="connexion">Connexion</a>
END;
        }

        $html = <<<END

        <link rel="stylesheet" type="text/css" href="css/VueHeader.css">
        <header>

        <h1>Cocktails</h1>
        <div id='contenant-nav'>
            <nav>
                    <a href="accueil">Accueil</a>
                    <a href="ingredient?name=Aliment">Ingrédients</a>
                    <a href="recettes">Recettes</a>
                    <a href="panier">Mes recettes préférées</a>
                    $liens
            </nav>
        </div>

        </header>

END;
        return $html;
    }
}
