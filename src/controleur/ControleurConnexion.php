<?php

namespace cocktails\controleur;

use \cocktails\vue\VueConnexion;

class ControleurConnexion {

  public function afficherConnexion(){
    $vue = new VueConnexion();
    $vue->render(1);
  }

  public function afficherInscription(){
    $vue = new VueConnexion();
    $vue->render(2);
  }

  public function connexion(){
    echo "connexion réussi";
    header("Refresh:4; url=accueil");
  }

  public function inscription(){
    echo "inscription réussi";
    header("Refresh:4; url=connexion");
  }

}
