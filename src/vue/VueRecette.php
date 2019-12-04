<?php

namespace cocktails\vue;

class VueRecette  {

  private $id;
  private $titre;
  private $ingrs;
  private $preparation;
  private $ingredients_requis;
  private $image;
  private $favori;

  public function __construct($i, $t, $in, $p, $ir, $im, $f){
    $this->id = $i;
    $this->titre = $t;
    $this->ingrs = $in;
    $this->preparation = $p;
    $this->ingredients_requis = $ir;
    $this->image = $im;
    $this->favori = $f;
  }

  public function render(){
      $content = <<<END
        <input type="hidden" id="id" value=$this->id>
        <strong>Titre :</strong> $this->titre<br><br>
        <strong>Quantités :</strong><br>
        <ul>
END;

///////////////////////////////////////////////////////////////////////
//Quantités
///////////////////////////////////////////////////////////////////////

      if (sizeof($this->ingrs) == 0){
        $content .= "Aucun ingrédient";
      } else {
        foreach ($this->ingrs as $value) {
          $content .= <<<END
          <li>$value</li><br>
END;
        }
      }

      $content .= <<<END
        </ul>
        <strong>Préparation :</strong> $this->preparation<br><br>
        <strong>Ingrédients requis :</strong><br><br>
END;

///////////////////////////////////////////////////////////////////////
//Ingrédients requis
///////////////////////////////////////////////////////////////////////

      if (sizeof($this->ingredients_requis) == 0){
        $content .= "Aucun ingrédient";
      } else {
        foreach ($this->ingredients_requis as $value) {
          $content .= <<<END
          <a href="ingredient?name=$value">$value</a><br>
END;
        }
      }

///////////////////////////////////////////////////////////////////////
//Image
///////////////////////////////////////////////////////////////////////

      if (file_exists($this->image)){
        $content .= <<<END
          <br><strong>Image</strong><br><br>
          <img src=$this->image width=100 height=150>
END;
      }

///////////////////////////////////////////////////////////////////////
//Favori
///////////////////////////////////////////////////////////////////////

      $content .= "<span id='imgFav'><br>";

      if ($this->favori){
        $content .= <<<END
        <img id=delFav src=img/broken_heart.png width=50 height = 50>
END;

      } else {
        $content .= <<<END
        <img id=addFav src=img/heart.png width=50 height = 50>
END;
      }

      $content .= "</span>";


      $html = <<<END
      <!DOCTYPE html>
        <head>
          <meta charset="utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
          <script src='js/fav.js'></script>
          <title>$this->titre</title>
        </head>

        <body>

          $content

        </body>
      </html>
END;

      echo $html;
  }

}
