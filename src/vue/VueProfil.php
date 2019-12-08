<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

class VueProfil {

  private $etudiant;

  public function __construct($e){
    $this->etudiant = $e;
  }

  public function render(){
    $vue = new VueHeader();
    $header = $vue->render();

    $html = <<<END
    <!DOCTYPE html>
      <head>
        <meta charset="utf-8">
        <title>Profil</title>
      </head>
      $header
      <body>


      </body>
    </html>
END;

    echo $html;
  }

}
