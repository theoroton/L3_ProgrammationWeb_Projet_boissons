<?php

namespace cocktails\vue;

use \cocktails\vue\VueHeader;

class VueUtilisateur {

  private $utilisateur;

  public function __construct($u){
    $this->utilisateur = $u;
  }

  private function afficherConnexion(){
    $content = <<<END
    <form id="connexion" method="post" action="connexion">
            <div class='form-group'>
              <label> Login </label>
              <input type="text" name="login" required>
            </div>

            <div class='form-group'>
              <label> Mot de passe </label>
              <input type="password" name="mdp" required>
            </div>

            <div class='form-button'>
              <button id="bvalide" type="submit">Se connecter</button>
            </div>
    </form>

    <div class='form-button'>
      <a href="inscription">Pas de compte ? S'inscrire</a><br>
    </div>
END;

    return $content;
  }

  private function afficherInscription(){
    $content = <<<END
    <form id="inscription" method="post" action="inscription">
            <div class='form-group'>
              <label> Login <span style="color:red">*</span> </label>
              <input type="text" name="login" required>
            </div>

            <div class='form-group'>
              <label> Mot de passe <span style="color:red">*</span> </label>
              <input type="password" name="mdp1" required>
            </div>

            <div class='form-group'>
              <label> Confirmer le mot de passe <span style="color:red">*</span> </label>
              <input type="password" name="mdp2" required>
            </div>

            <div class='form-group'>
              <label> Nom </label>
              <input type="text" name="nom">
            </div>

            <div class='form-group'>
              <label> Prénom </label>
              <input type="text" name="prenom">
            </div>

            <div class='form-group'>
             <label> Sexe </label>
             <input type="radio" name="sexe" value="F"> Femme
             <input type="radio" name="sexe" value="H"> Homme
            </div>

            <div class='form-group'>
              <label> Email </label>
              <input type="text" name="email">
            </div>

            <div class='form-group'>
              <label> Date de naissance </label>
              <input type="date" name="date_naissance">
            </div>

            <div class='form-group'>
              <label> Adresse </label>
              <input type="text" name="adresse">
            </div>

            <div class='form-group'>
              <label> Code postal </label>
              <input type="text" name="code_postal">
            </div>

            <div class='form-group'>
              <label> Ville </label>
              <input type="text" name="ville">
            </div>

            <div class='form-group'>
              <label> Numéro de téléphone </label>
              <input type="text" name="tel">
            </div>

            <div class='infos'>
              <span>* Informations obligatoires</span>
            </div>

            <div class='form-button'>
              <button id="bvalide" type="submit">S'inscrire</button>
            </div>
    </form>
END;

    return $content;
  }

  private function afficherModification(){
    $login = $this->utilisateur->login;
    $nom = $this->utilisateur->nom;
    $prenom = $this->utilisateur->prenom;
    $sexe = $this->utilisateur->sexe;
    if ($sexe == 'H') {
      $sexeH = 'checked';
      $sexeF = '';
    } else if ($sexe == 'F') {
      $sexeF = 'checked';
      $sexeH = '';
    } else {
      $sexeF = '';
      $sexeH = '';
    }
    $email = $this->utilisateur->email;
    $dateNaiss = $this->utilisateur->dateNaiss;
    $adresse = $this->utilisateur->adresse;
    $codePostal = $this->utilisateur->codePostal;
    $ville = $this->utilisateur->ville;
    $tel = $this->utilisateur->tel;

    $content = <<<END
    <form id="modification" method="post" action="modifierProfil">
            <div class='form-group'>
              <label> Login <span style="color:red"> * requis</span> </label>
              <input type="text" name="login" value="$login" required>
            </div>

            <div class='form-group'>
              <label> Nom </label>
              <input type="text" name="nom" value="$nom">
            </div>

            <div class='form-group'>
              <label> Prénom </label>
              <input type="text" name="prenom" value="$prenom">
            </div>

            <div class='form-group'>
             <label>Sexe</label>
             <input type="radio" name="sexe" value="F" $sexeF> Femme
             <input type="radio" name="sexe" value="H" $sexeH> Homme
            </div>

            <div class='form-group'>
              <label> Email </label>
              <input type="text" name="email" value="$email">
            </div>

            <div class='form-group'>
              <label> Date de naissance </label>
              <input type="date" name="date_naissance" value=$dateNaiss>
            </div>

            <div class='form-group'>
              <label> Adresse </label>
              <input type="text" name="adresse" value="$adresse">
            </div>

            <div class='form-group'>
              <label> Code postal </label>
              <input type="text" name="code_postal" value="$codePostal">
            </div>

            <div class='form-group'>
              <label> Ville </label>
              <input type="text" name="ville" value="$ville">
            </div>

            <div class='form-group'>
              <label> Numéro de téléphone </label>
              <input type="text" name="tel" value="$tel">
            </div>

            <div class='form-button'>
              <button id="bvalide" type="submit">Modifier</button>
            </div>
    </form>
END;

    return $content;
  }

  private function afficherModifMdp(){
    $content = <<<END
    <form id="modificationMdp" method="post" action="modifierMdp">
            <div class='form-group'>
              <label> Ancien mot de passe <span style="color:red">*</span>  </label>
              <input type="password" name="amdp" required>
            </div>

            <div class='form-group'>
              <label> Nouveau mot de passe <span style="color:red">*</span>   </label>
              <input type="password" name="mdp1" required>
            </div>

            <div class='form-group'>
              <label> Confirmer le nouveau mot de passe <span style="color:red">*</span>   </label>
              <input type="password" name="mdp2" required>
            </div>

            <div class='infos'>
              <span>* Informations obligatoires</span>
            </div>

            <div class='form-button'>
              <button id="bvalide" type="submit">Modifier</button>
            </div>
    </form>
END;

    return $content;
  }

  private function afficherProfil(){
    $login = $this->utilisateur->login;
    $nom = $this->utilisateur->nom;
    $prenom = $this->utilisateur->prenom;
    $sexe = $this->utilisateur->sexe;
    if ($sexe == 'H') {
      $sexe = 'Homme';
    } else if ($sexe == 'F') {
      $sexe = 'Femme';
    }
    $email = $this->utilisateur->email;
    $dateNaiss = $this->utilisateur->dateNaiss;
    $adresse = $this->utilisateur->adresse;
    $codePostal = $this->utilisateur->codePostal;
    $ville = $this->utilisateur->ville;
    $tel = $this->utilisateur->tel;

    $content = <<<END
        <p><strong>Login : </strong>$login</p>
        <p><strong>Nom : </strong>$nom</p>
        <p><strong>Prénom : </strong>$prenom</p>
        <p><strong>Sexe : </strong>$sexe</p>
        <p><strong>Email : </strong>$email</p>
        <p><strong>Date de naissance : </strong>$dateNaiss</p>
        <p><strong>Adresse : </strong>$adresse</p>
        <p><strong>Code postal : </strong>$codePostal</p>
        <p><strong>Ville : </strong>$ville</p>
        <p><strong>Téléphone : </strong>$tel</p>

        <form action="modifierProfil" method="get">
          <div class='form-button'>
            <input id="bmodifierInfos" type="submit" value="Modifier le profil">
          </div>
        </form>

        <br>

        <form action="modifierMdp" method="get">
          <div class='form-button'>
            <input id="bmodifierMdp" type="submit" value="Modifier le mot de passe">
          </div>
        </form>
END;

    return $content;
  }

  public function render($type){
    $vue = new VueHeader();
    $header = $vue->render();

    switch ($type) {
      case 1 : {
        $content = $this->afficherConnexion();
        $title = "Connexion";
        break;
      }
      case 2 : {
        $content = $this->afficherInscription();
        $title = "Inscription";
        break;
      }
      case 3 : {
        $content = $this->afficherProfil();
        $title = "Profil";

        break;
      }
      case 4 : {
        $content = $this->afficherModification();
        $title = "Modifier le profil";
        break;
      }
      case 5 : {
        $content = $this->afficherModifMdp();
        $title = "Modifier le mot de passe";
        break;
      }
    }

    $html = <<<END
    <!DOCTYPE html>
      <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/VueUtilisateur.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
        <title>$title</title>
      </head>
      $header
      <body>

      <h2>$title</h2><br>

      <div id='divUt'>
        $content
      </div>

      </body>
    </html>
END;

    echo $html;
  }

}
