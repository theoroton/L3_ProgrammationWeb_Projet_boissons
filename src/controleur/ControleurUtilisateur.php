<?php

namespace cocktails\controleur;

use \cocktails\vue\VueUtilisateur;
use \cocktails\vue\VueAccueil;
use \cocktails\models\Utilisateur;

class ControleurUtilisateur {

  public function afficherConnexion(){
    if (isset($_COOKIE['CookieCocktails'])){
      unset($_COOKIE['CookieCocktails']);
      setcookie("CookieCocktails", "", time()-3600);
    }

    $vue = new VueUtilisateur(NULL);
    $vue->render(1);
  }

  public function afficherInscription(){
    $vue = new VueUtilisateur(NULL);
    $vue->render(2);
  }

  public static function testConnexion(){
    if (isset($_COOKIE['CookieCocktails'])) {
      session_unset();
    } else if (!isset($_SESSION['favoris'])){
      $_SESSION['favoris'] = array();
    }
  }

  public function afficherProfil(){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();

    $vue = new VueUtilisateur($utilisateur);
    $vue->render(3);
  }

  public function afficherModificationProfil(){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();

    $vue = new VueUtilisateur($utilisateur);
    $vue->render(4);
  }

  public function afficherModificationMdp(){
    $vue = new VueUtilisateur(NULL);
    $vue->render(5);
  }

  public function afficherAccueil(){
    $vue = new VueAccueil();
    $vue->render();
  }

  private function verifMdp(){
    $valide = true;

    if ($_POST['mdp1'] != $_POST['mdp2']){
      $valide = false;
    }

    return $valide;
  }

  private function verifInfos(){
    $valide = true;

    $incorrectes = "";

    if (isset($_POST['mdp1']) && isset($_POST['mdp2'])){
      if (!$this->verifMdp()){
        $valide = false;
        $incorrectes .= "Les mots de passes ne correspondent pas<br>";
      }
    }

    if (strlen($_POST['tel']) > 0){
      if (strlen($_POST['tel']) != 10){
        $valide = false;
        $incorrectes .= "Le numéro de téléphone doit faire 10 caractères<br>";
      } else if (!is_numeric($_POST['tel'])){
        $valide = false;
        $incorrectes .= "Le numéro de téléphone doit être constituer uniquement de chiffres";
      }
    }

    return array($valide,$incorrectes);
  }

  public function connexion(){
    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();
    if (isset($utilisateur)){
      if(password_verify($_POST['mdp'],$utilisateur->mdp)){
        $cookie = array('id' => $utilisateur->idUtilisateur);
        setcookie("CookieCocktails", serialize($cookie));

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

  private function operationUtilisateur($add){
    if ($add) {
      $utilisateur = new Utilisateur();
      $utilisateur->login = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
      $utilisateur->mdp = password_hash(filter_var($_POST['mdp1'],FILTER_SANITIZE_STRING),PASSWORD_DEFAULT,[ 'cost' => 12]);
    } else {
      $cookie = unserialize($_COOKIE['CookieCocktails']);
      $id = $cookie['id'];
      $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();
    }

    if (strlen($_POST['nom'])  > 0){
      $utilisateur->nom = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->nom = NULL;
    }

    if (strlen($_POST['prenom'])  > 0){
      $utilisateur->prenom = filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->prenom = NULL;
    }

    if (isset($_POST['sexe'])){
      $utilisateur->sexe = filter_var($_POST['sexe'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->sexe = NULL;
    }

    if (strlen($_POST['email'])  > 0){
      $utilisateur->email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->email = NULL;
    }

    if (strlen($_POST['date_naissance']) > 0){
      $utilisateur->dateNaiss = filter_var($_POST['date_naissance'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->dateNaiss = NULL;
    }

    if (strlen($_POST['adresse'])  > 0){
      $utilisateur->adresse = filter_var($_POST['adresse'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->adresse = NULL;
    }

    if (strlen($_POST['code_postal']) > 0){
      $utilisateur->codePostal = filter_var($_POST['code_postal'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->codePostal = NULL;
    }

    if (strlen($_POST['ville'])  > 0){
      $utilisateur->ville = filter_var($_POST['ville'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->ville = NULL;
    }

    if (strlen($_POST['tel'])  > 0){
      $utilisateur->tel = filter_var($_POST['tel'],FILTER_SANITIZE_STRING);
    } else {
      $utilisateur->tel = NULL;
    }

    $utilisateur->save();
  }

  public function inscription(){
    $array = $this->verifInfos();
    $valide = $array[0];
    $incorrectes = $array[1];

    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();


    if (!isset($utilisateur)){
      if ($valide){
        $this->operationUtilisateur(true);

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
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:100px'>Informations incorrectes :</p>
               <p style='font-family: Georgia, Times, serif;font-size:15px'>$incorrectes</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page d'inscription.</p>
        </center>
  END;

        echo $redirection;
        header("Refresh:3; url=inscription");
      }
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

  public function modification(){
    $array = $this->verifInfos();
    $valide = $array[0];
    $incorrectes = $array[1];

    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();

    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateurCourant = Utilisateur::where('idUtilisateur', '=', $id)->first();

    if (!isset($utilisateur) || ($utilisateur->login == $utilisateurCourant->login)){
      if ($valide){
        $this->operationUtilisateur(false);

        $redirection = <<<END
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Modification réussie.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers votre profil.</p>
        </center>
  END;

        echo $redirection;
        header("Refresh:3; url=profil");

      } else {
        $redirection = <<<END
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:100px'>Informations incorrectes :</p>
               <p style='font-family: Georgia, Times, serif;font-size:15px'>$incorrectes</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du profil.</p>
        </center>
  END;

        echo $redirection;
        header("Refresh:3; url=modifierProfil");

      }
    } else {
      $redirection = <<<END
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Login déjà utilisé.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du profil.</p>
      </center>
  END;

      echo $redirection;
      header("Refresh:3; url=modifierProfil");
    }
  }

  public function modificationMdp(){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();

    if (password_verify($_POST['amdp'],$utilisateur->mdp)){
      if ($this->verifMdp()){
        $utilisateur->mdp = password_hash(filter_var($_POST['mdp1'],FILTER_SANITIZE_STRING),PASSWORD_DEFAULT,[ 'cost' => 12]);
        $utilisateur->save();

        $redirection = <<<END
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Modification réussie.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers votre profil.</p>
        </center>
END;

        echo $redirection;
        header("Refresh:3; url=profil");

      } else {
        $redirection = <<<END
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Les mots de passes ne correspondent pas.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du mot de passe.</p>
        </center>
END;

        echo $redirection;
        header("Refresh:3; url=modifierMdp");

      }
    } else {
      $redirection = <<<END
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Ancien mot de passe incorrect.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du mot de passe.</p>
      </center>
END;

      echo $redirection;
      header("Refresh:3; url=modifierMdp");

    }
  }

}
