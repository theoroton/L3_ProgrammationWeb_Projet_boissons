<?php

namespace cocktails\vue;

class Vue_test {

  protected $calcul;

  public function __construct($t){
    $this->calcul = $t;
  }

  private function ajouterCalcul(){

    $html = <<<END
    <p>
      $this->calcul
    </p>
END;

  return $html;
  }

  public function render($i){
    switch ($i) {
      case 1 : {
        $content = $this->ajouterCalcul();
        break;
      }
    }

    $html = <<<END
    <!DOCTYPE html>
    <html>
    <head> Calcul</head>

    <body>

      <div class="content">

        $content

      </div>
    </body><html>
END;

    return $html;
  }
}
