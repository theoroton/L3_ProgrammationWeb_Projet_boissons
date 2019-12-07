<?php

namespace cocktails\vue;


class VueHeader
{
    public function render()
    {
        $html = <<<END
        <header>

        <h1>Cocktails</h1>
        <div class="contenant-nav">
            <nav>
                    <a href="accueil">Accueil</a>
                    <a href="ingredient?name=Aliment">Ingrédients</a>
                    <a href="#">Recettes</a>
                    <a href="panier">Mes recettes préférées</a>
                    <a href="profil">Profil</a>
                    <a href="connexion">Déconnexion</a>

            </nav>
        </div>

        </header>

END;
        return $html;
    }
}
//href=\"ingredient?name=Aliment\">Ingrédient</a><br>"
