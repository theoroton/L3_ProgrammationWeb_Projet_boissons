<?php

namespace cocktails\vue;


class VueHeader
{
    public function render()
    {
        $html  = "";
        $html .= <<<END
        <header>
        <h1>Cocktails</h1>
        <div class="contenant-nav">
            <nav>
                  
            <a href="./accueil.php">Accueil</a>
                    <a href="ingredient?name=Aliment">Ingrédients</a>
                    <a href="#">Recettes</a>
                    <a href="./panier.php">Mon panier de recettes</a>
                    <a href="#">Déconnexion</a>
                
            </nav>
        </div>

        </header>
            
END;
        return $html;
    }
}
//href=\"ingredient?name=Aliment\">Ingrédient</a><br>"
