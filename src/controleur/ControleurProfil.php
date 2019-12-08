<?php

namespace cocktails\controleur;

use \cocktails\vue\VueProfil;

class ControleurProfil {

  public function afficherProfil(){
    $vue = new VueProfil();
    $vue->render();
  }

}
