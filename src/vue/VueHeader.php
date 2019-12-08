<?php

namespace cocktails\vue;


class VueHeader
{
    public function render()
    {
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
        <header>

        <h1>Cocktails</h1>
        <div class="contenant-nav">
            <nav>
                    <a href="accueil">Accueil</a>
                    <a href="ingredient?name=Aliment">Ingrédients</a>
                    <a href="#">Recettes</a>
                    <a href="panier">Mes recettes préférées</a>
                    $liens
            </nav>
        </div>

        </header>

END;
        return $html;
    }
}
//href=\"ingredient?name=Aliment\">Ingrédient</a><br>"
