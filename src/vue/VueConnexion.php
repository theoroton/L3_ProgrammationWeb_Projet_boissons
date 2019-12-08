<?php

namespace cocktails\vue;

class VueConnexion {

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
                  <input type="date" name="date_naissance"/>
              </label>
            </p>

            <p>
              <label> Adresse
                  <input type="text" name="adresse"/>
              </label>
            </p>

            <p>
              <label> Code postal
                  <input type="text" name="code_postal"/>
              </label>
            </p>

            <p>
              <label> Ville
                  <input type="text" name="ville"/>
              </label>
            </p>

            <p>
              <label> Numéro de téléphone
                  <input type="text" name="tel"/>
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

  public function render($type){
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
    }

    $html = <<<END
    <!DOCTYPE html>
      <head>
        <meta charset="utf-8">
        <title>$title</title>
      </head>

      <body>

      $content

      </body>
    </html>
END;

    echo $html;
  }

}
