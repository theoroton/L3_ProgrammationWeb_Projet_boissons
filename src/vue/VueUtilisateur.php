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
            <p>
              <label> Login
                  <input type="text" name="login" required>
              </label>
            </p>

            <p>
              <label> Mot de passe
                  <input type="password" name="mdp" required>
              </label>
            </p>

            <p>
              <button id="bvalide" type="submit">Se connecter</button>
            </p>
    </form>

    <a href="inscription">Pas de compte ? S'inscrire</a><br>
END;

    return $content;
  }

  private function afficherInscription(){
    $content = <<<END
    <form id="inscription" method="post" action="inscription">
            <p>
              <label> Login <span style="color:red">*</span>
                  <input type="text" name="login" required>
              </label>
            </p>

            <p>
              <label> Mot de passe <span style="color:red">*</span>
                  <input type="password" name="mdp1" required>
              </label>
            </p>

            <p>
              <label> Confirmer le mot de passe <span style="color:red">*</span>
                  <input type="password" name="mdp2" required>
              </label>
            </p>

            <p>
              <label> Nom
                  <input type="text" name="nom">
              </label>
            </p>

            <p>
              <label> Prénom
                  <input type="text" name="prenom">
              </label>
            </p>

            <span>
             <label>Sexe</label>
             <input type="radio" name="sexe" value="F"> Femme
             <input type="radio" name="sexe" value="H"> Homme
            </span>

            <p>
              <label> Email
                  <input type="text" name="email">
              </label>
            </p>

            <p>
              <label> Date de naissance
                  <input type="date" name="date_naissance">
              </label>
            </p>

            <p>
              <label> Adresse
                  <input type="text" name="adresse">
              </label>
            </p>

            <p>
              <label> Code postal
                  <input type="text" name="code_postal">
              </label>
            </p>

            <p>
              <label> Ville
                  <input type="text" name="ville">
              </label>
            </p>

            <p>
              <label> Numéro de téléphone
                  <input type="text" name="tel">
              </label>
            </p>

            <p><span style="color:red">* Informations obligatoires</span></p>

            <p>
              <button id="bvalide" type="submit">S'inscrire</button>
            </p>
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
            <p>
              <label> Login
                  <input type="text" name="login" value="$login" required>
                  <span style="color:red"> * requis</span>
              </label>
            </p>

            <p>
              <label> Nom
                  <input type="text" name="nom" value="$nom">
              </label>
            </p>

            <p>
              <label> Prénom
                  <input type="text" name="prenom" value="$prenom">
              </label>
            </p>

            <span>
             <label>Sexe</label>
             <input type="radio" name="sexe" value="F" $sexeF> Femme
             <input type="radio" name="sexe" value="H" $sexeH> Homme
            </span>

            <p>
              <label> Email
                  <input type="text" name="email" value="$email">
              </label>
            </p>

            <p>
              <label> Date de naissance
                  <input type="date" name="date_naissance" value=$dateNaiss>
              </label>
            </p>

            <p>
              <label> Adresse
                  <input type="text" name="adresse" value="$adresse">
              </label>
            </p>

            <p>
              <label> Code postal
                  <input type="text" name="code_postal" value="$codePostal">
              </label>
            </p>

            <p>
              <label> Ville
                  <input type="text" name="ville" value="$ville">
              </label>
            </p>

            <p>
              <label> Numéro de téléphone
                  <input type="text" name="tel" value="$tel">
              </label>
            </p>

            <p>
              <button id="bvalide" type="submit">Modifier</button>
            </p>
    </form>
END;

    return $content;
  }

  private function afficherModifMdp(){
    $content = <<<END
    <form id="modificationMdp" method="post" action="modifierMdp">
            <p>
              <label> Ancien mot de passe <span style="color:red">*</span>
                  <input type="password" name="amdp" required>
              </label>
            </p>

            <p>
              <label> Nouveau mot de passe <span style="color:red">*</span>
                  <input type="password" name="mdp1" required>
              </label>
            </p>

            <p>
              <label> Confirmer le nouveau mot de passe <span style="color:red">*</span>
                  <input type="password" name="mdp2" required>
              </label>
            </p>

            <p><span style="color:red">* Informations obligatoires</span></p>

            <p>
              <button id="bvalide" type="submit">Modifier</button>
            </p>
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
          <input id="bmodifierInfos" type="submit" value="Modifier le profil">
        </form>

        <br>

        <form action="modifierMdp" method="get">
          <input id="bmodifierMdp" type="submit" value="Modifier le mot de passe">
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
        <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
        <title>$title</title>
      </head>
      $header
      <body>

      $content

      </body>
    </html>
END;

    echo $html;
  }

}
