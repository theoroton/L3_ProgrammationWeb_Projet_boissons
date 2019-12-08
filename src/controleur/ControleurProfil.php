<?php

namespace cocktails\controleur;

use \cocktails\vue\VueProfil;
use \cocktails\models\Utilisateur;

class ControleurProfil {

  public function afficherProfil(){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();

    $vue = new VueProfil($utilisateur);
    $vue->render();
  }

}
