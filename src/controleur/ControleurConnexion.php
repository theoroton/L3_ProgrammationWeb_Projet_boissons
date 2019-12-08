<?php

namespace cocktails\controleur;

use \cocktails\vue\VueConnexion;
use \cocktails\vue\VueAccueil;
use \cocktails\models\Utilisateur;

class ControleurConnexion {

  public function afficherConnexion(){
    $vue = new VueConnexion();
    $vue->render(1);
  }

  public function afficherInscription(){
    $vue = new VueConnexion();
    $vue->render(2);
  }

  public function afficherAccueil(){
    if (!isset($_SESSION['favoris'])) {
      $_SESSION['favoris'] = array();
    }
    $vue = new VueAccueil();
    $vue->render();
  }

  public function connexion(){
    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();
    if (isset($utilisateur)){
      if(password_verify($_POST['mdp'],$utilisateur->mdp)){
        $redirection = <<<END
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Connexion réussie.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers la page d'accueil.</p>
        </center>
  END;

        echo $redirection;
        header("Refresh:3; url=accueil");

      } else {
        $redirection = <<<END
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Mot de passe incorrect.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de connexion.</p>
        </center>
  END;

        echo $redirection;
        header("Refresh:3; url=connexion");

      }
    } else {
      $redirection = <<<END
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Login inexistant.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de connexion.</p>
      </center>
END;

      echo $redirection;
      header("Refresh:3; url=connexion");
    }

  }

  public function inscription(){
    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();

    if (!isset($utilisateur)){
      $utilisateur = new Utilisateur();
      $utilisateur->login = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
      $utilisateur->mdp = password_hash(filter_var($_POST['mdp1'],FILTER_SANITIZE_STRING),PASSWORD_DEFAULT,[ 'cost' => 12]);
      if (strlen($_POST['nom']) != 0){
        $utilisateur->nom = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
      }

      if (strlen($_POST['prenom']) != 0){
        $utilisateur->prenom = filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
      }

      if (isset($_POST['sexe'])){
        $utilisateur->sexe = filter_var($_POST['sexe'],FILTER_SANITIZE_STRING);
      }

      if (strlen($_POST['email']) != 0){
        $utilisateur->email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
      }

      if (strlen($_POST['date_naissance']) != 0){
        $utilisateur->dateNaiss = filter_var($_POST['date_naissance'],FILTER_SANITIZE_STRING);
      }

      if (strlen($_POST['adresse']) != 0){
        $utilisateur->adresse = filter_var($_POST['adresse'],FILTER_SANITIZE_STRING);
      }

      if (strlen($_POST['code_postal']) != 0){
        $utilisateur->codePostal = filter_var($_POST['code_postal'],FILTER_SANITIZE_STRING);
      }

      if (strlen($_POST['ville']) != 0){
        $utilisateur->ville = filter_var($_POST['ville'],FILTER_SANITIZE_STRING);
      }

      if (strlen($_POST['tel']) != 0){
        $utilisateur->tel = filter_var($_POST['tel'],FILTER_SANITIZE_STRING);
      }

      $utilisateur->save();

      $redirection = <<<END
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Inscription réussie.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers la page de connexion.</p>
      </center>
END;

      echo $redirection;
      header("Refresh:3; url=connexion");

    } else {
      $redirection = <<<END
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Login déjà utilisé.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page d'inscription.</p>
      </center>
END;

      echo $redirection;
      header("Refresh:3; url=inscription");
    }
  }

}
