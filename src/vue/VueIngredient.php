<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

/*
La vue ingrédient affiche un ingrédient et
toutes ses informations
*/

//Vue ingrédient
class VueIngredient
{

  //Nom de l'ingrédient
  private $nom;
  //Parents de l'ingrédient
  private $parents;
  //Fils de l'ingrédient
  private $fils;
  //Recettes liées à l'ingrédient
  private $recettesLiees;

  /*
  Constructeur de la vue à laquelle on donne
  le nom, les parents, les fils et les recettes
  liées à l'ingrédient.
  */
  public function __construct($n, $p, $f, $r)
  {
    $this->nom = $n;
    $this->parents = $p;
    $this->fils = $f;
    $this->recettesLiees = $r;
  }

  /*
  Méthode render qui affiche l'ingrédient
  */
  public function render()
  {
    //Ajout du header
    $vue = new VueHeader();
    $header = $vue->render();

    $content = "";

    //Affichage du nom de l'ingrédient
    $content .= <<<END
          <div id='ing-show'>
    <article>
      <h2>Ingrédient</h2>
      <strong>Nom :</strong> $this->nom
      <br><br>
    </article>
END;
    $content .= <<<END
END;

    //Affichage des parents
    $content .= <<<END
    <article>
        <h2>Parents</h2>
END;

    /*
    Si il n'y a pas de parents, alors on affiche qu'il y en a aucun.
    Sinon, pour chaque parent, on va créer un lien vers ce parent
    afin de parcourir l'aborescence.
    */
    if (is_null($this->parents)) {
      $content .= "Aucun parents";
    } else {
      foreach ($this->parents as $value) {
        $content .= <<<END
          <a href="ingredient?name=$value">$value</a><br>
END;
      }
    }

    $content .= <<<END
    </article>
END;

    //Affichage des fils
    $content .= <<<END
    <article>
      <h2>Fils</h2>

END;

    /*
    Si il n'y a pas de fils, alors on affiche qu'il y en a aucun.
    Sinon, pour chaque fils, on va créer un lien vers ce fils
    afin de parcourir l'aborescence.
    */
    if (is_null($this->fils)) {
      $content .= "Aucun fils";
    } else {
      foreach ($this->fils as $value) {
        $content .= <<<END
      <a href="ingredient?name=$value">$value</a><br>
END;
      }
    }
    $content .= <<<END
    </article>
    </div>
END;

    //Affichage des recettes liées
    $content .= <<<END
<div id='recette'>
  <h2>Recettes :</h2> <br>

END;

    /*
    Si il n'y a pas de recettes liées, alors on affiche qu'il y en a aucune.
    Sinon, pour chaque recette, on va créer un lien vers cette recette
    afin de visualiser cette recette.
    */
    if (sizeof($this->recettesLiees) == 0) {
      $content .= "Cet aliment n'est utilisé dans aucune recette";
    } else {
      foreach ($this->recettesLiees as $value) {
        $id = $value['id'];
        $titre = $value['titre'];
        $content .= <<<END
      <a href="recette?id=$id">$titre</a><br>

END;
      }
    }
    $content .= "</div>";

    //Contenu à afficher
    $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" type="text/css" href="css/VueIngredient.css">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
          <title>$this->nom</title>
        </head>
        $header
        <body>
          <div id="body-container">
          $content
          </div>
        </body>
      </html>
END;
    echo $html;
  }
}
