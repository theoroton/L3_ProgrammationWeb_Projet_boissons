<?php

namespace cocktails\vue;

class VueIngredient  {

  private $nom;
  private $parents;
  private $fils;
  private $recettesLiees;

  public function __construct($n,$p,$f,$r){
    $this->nom = $n;
    $this->parents = $p;
    $this->fils = $f;
    $this->recettesLiees = $r;
  }

  public function render(){
      $content = "";

///////////////////////////////////////////////////////////////////////
//Parents
///////////////////////////////////////////////////////////////////////

      $content .= <<<END
      <div class="colonne">
            <center>
            <h2>Parents</h2>

END;

      if (is_null($this->parents)){
        $content .= "Aucun parents";
      } else {
        foreach ($this->parents as $value) {
          $content .= <<<END
          <a href="ingredient?name=$value">$value</a><br>
END;
        }
      }

      $content .= <<<END
            </center>
      </div>
END;

///////////////////////////////////////////////////////////////////////
//Nom & chemin
///////////////////////////////////////////////////////////////////////

      $content .= <<<END
      <div class="colonne">
            <center>
            <h2>Ingrédient</h2>

            <strong>Nom :</strong> $this->nom
            <br><br>
            <strong>Chemin :</strong>
            <br><br>
            <strong>Recettes :</strong> <br>
END;

      if (sizeof($this->recettesLiees) == 0){
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


      $content .= <<<END
            </center>
      </div>
END;

///////////////////////////////////////////////////////////////////////
//Fils
///////////////////////////////////////////////////////////////////////

      $content .= <<<END
      <div class="colonne">
            <center>
            <h2>Fils</h2>

END;

      if (is_null($this->fils)){
        $content .= "Aucun fils";
      } else {
        foreach ($this->fils as $value) {
          $content .= <<<END
          <a href="ingredient?name=$value">$value</a><br>
END;
        }
      }

      $content .= <<<END
            </center>
      </div>
END;


      $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link rel="stylesheet" href="css/VueIngredient.css">
          <title>$this->nom</title>
        </head>

        <body>

          $content

        </body>
      </html>
END;

      echo $html;
  }
}
