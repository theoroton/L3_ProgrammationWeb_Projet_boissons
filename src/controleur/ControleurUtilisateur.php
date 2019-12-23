<?php

namespace cocktails\controleur;

use \cocktails\vue\VueUtilisateur;
use \cocktails\vue\VueAccueil;
use \cocktails\models\Utilisateur;

//Controleur Utilisateur
class ControleurUtilisateur {

  /*
  Méthode qui crée la vue de l'accueil et
  l'affiche.
  */
  public function afficherAccueil(){
    //Création de la vue et affichage
    $vue = new VueAccueil();
    $vue->render();
  }

  /*
  Méthode qui crée la vue de connexion et
  l'affiche.
  */
  public function afficherConnexion(){
    /*
    Si l'utiliasteur est déjà connecté, on supprime
    son cookie.
    */
    if (isset($_COOKIE['CookieCocktails'])){
      unset($_COOKIE['CookieCocktails']);
      setcookie("CookieCocktails", "", time()-3600);
    }

    //Création de la vue et affichage
    $vue = new VueUtilisateur(NULL);
    $vue->render(1);
  }

  /*
  Méthode qui crée la vue de l'inscription et
  l'affiche.
  */
  public function afficherInscription(){
    //Création de la vue et affichage
    $vue = new VueUtilisateur(NULL);
    $vue->render(2);
  }

  /*
  Méthode qui permet de tester si l'on est connecté
  ou pas afin de savoir si on doit créer la variable
  de sessions.
  */
  public static function testConnexion(){
    if (isset($_COOKIE['CookieCocktails'])) {
      $_SESSION['favoris'] = null;
    } else if (!isset($_SESSION['favoris'])){
      $_SESSION['favoris'] = array();
    }
  }

  /*
  Méthode qui permet d'afficher le profil.
  */
  public function afficherProfil(){
    //On récupère les informations de l'utilisateur dans la BDD
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();

    //Création de la vue et affichage
    $vue = new VueUtilisateur($utilisateur);
    $vue->render(3);
  }

  /*
  Méthode qui permet d'afficher la modification du profil.
  */
  public function afficherModificationProfil(){
    //On récupère les informations de l'utilisateur dans la BDD
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();

    //Création de la vue et affichage
    $vue = new VueUtilisateur($utilisateur);
    $vue->render(4);
  }

  /*
  Méthode qui permet d'afficher la modification du mdp.
  */
  public function afficherModificationMdp(){
    $vue = new VueUtilisateur(NULL);
    $vue->render(5);
  }

  /*
  Méthode qui permet de vérifier si les mots de passes correspondent
  quand on s'inscrit ou que l'on modifie son mdp.
  */
  private function verifMdp(){
    $valide = true;

    if ($_POST['mdp1'] != $_POST['mdp2']){
      $valide = false;
    }

    return $valide;
  }

  /*
  Méthode qui permet de vérifier si les informations sont correctes
  quand on s'inscrit ou que l'on modifie ses informations.
  */
  private function verifInfos(){
    $valide = true;

    /*
    Pour chacune des informations, on vérifie si il est juste, sinon on
    ajoute un message pour chaque erreur à l'utilisateur.
    */
    $incorrectes = "";

    //Vérif mdp
    if (isset($_POST['mdp1']) && isset($_POST['mdp2'])){
      if (!$this->verifMdp()){
        $valide = false;
        $incorrectes .= "Les mots de passes ne correspondent pas<br>";
      }
    }

    //Vérif de l'email
    if (strlen($_POST['email']) > 0){
      if (!preg_match('/^([a-z]|[A-Z]|[0-9]|[\.])*@([a-z]|[A-Z]|[0-9]|[\.])*$/',$_POST['email'])){
        $valide = false;
        $incorrectes .= "L'email doit contenir un seul @ et ne pas contenir de caractères spéciaux<br>";
      }
    }

    //Vérif du numéro de téléphone
    if (strlen($_POST['tel']) > 0){
      if (!preg_match('/^[0-9]{10}$/',$_POST['tel'])){
        $valide = false;
        $incorrectes .= "Le numéro de téléphone doit faire 10 caractères et être constitué uniquement de chiffres<br>";
      }
    }

    return array($valide,$incorrectes);
  }

  /*
  Méthode qui permet de se connecter au site.
  */
  public function connexion(){
    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();
    /*
    Si on trouve l'utilisateur grâce au login, alors on continue.
    Sinon on affiche que le login n'existe pas.
    */
    if (isset($utilisateur)){
      /*
      Si le mot de passe correspond au login, alors on affiche que la
      connexion est réussie et on crée le cookie du site.
      Sinon on affiche que le mot de passe est incorrecte.
      */
      if(password_verify($_POST['mdp'],$utilisateur->mdp)){
        $cookie = array('id' => $utilisateur->idUtilisateur);
        setcookie("CookieCocktails", serialize($cookie));

        $redirection = <<<END
        <title>Connexion réussie</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Connexion réussie.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers la page d'accueil.</p>
        </center>
END;

        //Redirection à l'accueil
        echo $redirection;
        header("Refresh:3; url=accueil");

      } else {
        $redirection = <<<END
        <title>Erreur de connexion</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Mot de passe incorrect.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de connexion.</p>
        </center>
END;

        //Redirection sur la page de connexion
        echo $redirection;
        header("Refresh:3; url=connexion");

      }
    } else {
      $redirection = <<<END
      <title>Erreur de connexion</title>
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Login inexistant.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de connexion.</p>
      </center>
END;

      //Redirection sur la page de connexion
      echo $redirection;
      header("Refresh:3; url=connexion");
    }

  }

  /*
  Méthode qui permet d'effectuer une opération d'ajout ou
  de modification.
  */
  public function operationUtilisateur($add){
    /*
    Si on effectue un ajout d'un utilisateur, on crée un nouvel utilisateur.
    Sinon pour la modification, on récupère l'utilisateur.
    */
    if ($add) {
      $utilisateur = new Utilisateur();
      $utilisateur->login = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
      $utilisateur->mdp = password_hash(filter_var($_POST['mdp1'],FILTER_SANITIZE_STRING),PASSWORD_DEFAULT,[ 'cost' => 12]);
    } else {
      $cookie = unserialize($_COOKIE['CookieCocktails']);
      $id = $cookie['id'];
      $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();
    }

    /*
    Pour chacun des attributs, si il existe, alors on l'ajoute à l'utilisateur.
    Sinon, on met NULL à cet attribut.
    */
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

    //On sauvegarde l'utilisateur dans la BDD
    $utilisateur->save();
  }

  /*
  Méthode qui permet de s'inscrire au site.
  */
  public function inscription(){
    //On vérifie les infos d'inscription
    $array = $this->verifInfos();
    $valide = $array[0];
    $incorrectes = $array[1];

    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();

    /*
    Si l'utilisateur identifié par son login existe déjà, on indique
    que le login est déjà pris. Sinon on continue.
    */
    if (!isset($utilisateur)){
      /*
      Si il n'y a aucune erreur, alors on peut ajouter l'utilisateur à la BDD.
      Sinon, on affiche les erreurs.
      */
      if ($valide){
        $this->operationUtilisateur(true);

        $redirection = <<<END
        <title>Inscription réussie</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Inscription réussie.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers la page de connexion.</p>
        </center>
END;

        //Redirection sur la page de connexion
        echo $redirection;
        header("Refresh:3; url=connexion");
      } else {
        $redirection = <<<END
        <title>Erreur d'inscription</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:100px'>Informations incorrectes :</p>
               <p style='font-family: Georgia, Times, serif;font-size:15px'>$incorrectes</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page d'inscription.</p>
        </center>
END;

        //Redirection sur la page d'inscription
        echo $redirection;
        header("Refresh:6; url=inscription");
      }
    } else {
      $redirection = <<<END
      <title>Erreur d'inscription</title>
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Login déjà utilisé.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page d'inscription.</p>
      </center>
END;

      //Redirection sur la page d'inscription
      echo $redirection;
      header("Refresh:3; url=inscription");
    }
  }

  /*
  Méthode qui permet de modifier son profil.
  */
  public function modification(){
    //On vérifie les infos d'inscription
    $array = $this->verifInfos();
    $valide = $array[0];
    $incorrectes = $array[1];

    $utilisateur = Utilisateur::where('login', '=', $_POST['login'])->first();

    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateurCourant = Utilisateur::where('idUtilisateur', '=', $id)->first();

    /*
    Si le nouveau login est déjà pris, on l'indique.
    Sinon on continue.
    */
    if (!isset($utilisateur) || ($utilisateur->login == $utilisateurCourant->login)){
      /*
      Si il n'y a aucune erreur, alors on peut modifier l'utilisateur dans la BDD.
      Sinon, on affiche les erreurs.
      */
      if ($valide){
        $this->operationUtilisateur(false);

        $redirection = <<<END
        <title>Modification réussie</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Modification réussie.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers votre profil.</p>
        </center>
END;

        //Redirection sur le profil
        echo $redirection;
        header("Refresh:3; url=profil");

      } else {
        $redirection = <<<END
        <title>Erreur de modification</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:100px'>Informations incorrectes :</p>
               <p style='font-family: Georgia, Times, serif;font-size:15px'>$incorrectes</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du profil.</p>
        </center>
END;

        //Redirection sur la page de modification du profil
        echo $redirection;
        header("Refresh:6; url=modifierProfil");

      }
    } else {
      $redirection = <<<END
      <title>Erreur de modification</title>
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Login déjà utilisé.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du profil.</p>
      </center>
END;

      //Redirection sur la page de modification du profil
      echo $redirection;
      header("Refresh:3; url=modifierProfil");
    }
  }

  /*
  Méthode qui permet de modifier son mdp.
  */
  public function modificationMdp(){
    $cookie = unserialize($_COOKIE['CookieCocktails']);
    $id = $cookie['id'];
    $utilisateur = Utilisateur::where('idUtilisateur', '=', $id)->first();

    /*
    Si l'ancien mot de passe n'est pas bon, alors on l'indique.
    Sinon on continue.
    */
    if (password_verify($_POST['amdp'],$utilisateur->mdp)){
      /*
      Si les 2 mots de passe correspondent, alors on modifie le mot de
      passe de l'utilisateur.
      Sinon on affiche que les mdps ne correspondant pas.
      */
      if ($this->verifMdp()){
        $utilisateur->mdp = password_hash(filter_var($_POST['mdp1'],FILTER_SANITIZE_STRING),PASSWORD_DEFAULT,[ 'cost' => 12]);
        $utilisateur->save();

        $redirection = <<<END
        <title>Modification réussie</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Modification réussie.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être dirigé vers votre profil.</p>
        </center>
END;

        //Redirection sur le profil
        echo $redirection;
        header("Refresh:3; url=profil");

      } else {
        $redirection = <<<END
        <title>Erreur de modification</title>
        <center>
               <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Les mots de passes ne correspondent pas.</p>
               </br>
               <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du mot de passe.</p>
        </center>
END;

        //Redirection sur la page de modification du mdp
        echo $redirection;
        header("Refresh:3; url=modifierMdp");

      }
    } else {
      $redirection = <<<END
      <title>Erreur de modification</title>
      <center>
             <p style='font-family: Georgia, Times, serif;font-size:30px;margin-top:250px'>Ancien mot de passe incorrect.</p>
             </br>
             <p style='font-family: Georgia, Times, serif;font-size:25px;margin-top:200px'>Vous allez être redirigé vers la page de modification du mot de passe.</p>
      </center>
END;

      //Redirection sur la page de modification du mdp
      echo $redirection;
      header("Refresh:3; url=modifierMdp");

    }
  }

}
