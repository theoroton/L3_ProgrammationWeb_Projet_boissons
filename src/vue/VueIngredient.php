<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

class VueIngredient
{

  private $nom;
  private $parents;
  private $fils;
  private $recettesLiees;

  public function __construct($n, $p, $f, $r)
  {
    $this->nom = $n;
    $this->parents = $p;
    $this->fils = $f;
    $this->recettesLiees = $r;
  }

  public function render()
  {
    $vue = new VueHeader();
    $header = $vue->render();

    ///////////////////////////////////////////////////////////////////////
    //Parents
    ///////////////////////////////////////////////////////////////////////

    $content = <<<END
      <div class="ing-show">
      <article>
            <h2>Parents</h2>
END;

    if (is_null($this->parents)) {
      $content .= "Aucun parents";
    } else {
      foreach ($this->parents as $value) {
        $content .= <<<END
          <a href="ingredient?name=$value">$value</a><br>
END;
      }
    }

    $content .= "</article>";

    ///////////////////////////////////////////////////////////////////////
    //Nom & chemin
    ///////////////////////////////////////////////////////////////////////

    $content .= <<<END
    <article>
      <h2>Ingrédient</h2>
      <strong>Nom :</strong> $this->nom
      <br><br>
      <strong>Chemin :</strong>
      <br><br>
    </article>
END;

    ///////////////////////////////////////////////////////////////////////
    //Fils
    ///////////////////////////////////////////////////////////////////////

    $content .= <<<END
    <article>
      <h2>Fils</h2>

END;

    if (is_null($this->fils)) {
      $content .= "Aucun fils";
    } else {
      foreach ($this->fils as $value) {
        $content .= <<<END
        <a href="ingredient?name=$value">$value</a><br>
END;
      }
    }
    $content .= "</article></div>";


    $content .= <<<END
    <div class="recette">
      <h2>Recettes :</h2> <br>

END;

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

    $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <title>Cocktails</title>
          <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link rel="stylesheet" href="style/cocktails.css">
          <title>$this->nom</title>
        </head>
        $header
        <body>
          <div class = "body-container">
          $content
          </div>
        </body>
      </html>
END;
    echo $html;
  }
}
