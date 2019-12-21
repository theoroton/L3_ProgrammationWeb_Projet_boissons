<?php
require_once('../data/Donnees.inc.php');

/*
Méthode qui permet de compléter automatiquement un ingrédient
*/
function autocomplete(){
  global $Hierarchie;

  //On récupère tous les ingrédients
	$ingredients = array_keys($Hierarchie);
	$nbIngrs = count($ingredients);

  //On trie les ingrédients par ordre alphabétique
	sort($ingredients);

	$results = array();

	//On parcours les 20 premiers ingrédients
	for ($i = 0 ; $i < $nbIngrs && count($results) < 20 ; $i++) {
      /*
      Si l'ingrédient courant commence par les mêmes caractères que celui recherché,
      on l'ajoute au tableau des résultats.
      */
	    if (stripos($ingredients[$i], $_GET['nom']) === 0) {
	        array_push($results, $ingredients[$i]);
	    }
	}

  //On affiche les résultats séparés par '|'
	echo implode('|', $results);
}

/*
Méthode qui permet de savoir si un ingrédient existe.
*/
function existe(){
  global $Hierarchie;

  /*
  Si l'ingrédient existe, on renvoie true. Sinon false.
  */
  if (array_key_exists($_GET['key'],$Hierarchie)){
    echo 'true';
  } else {
    echo 'false';
  }
}

/*
Si le paramètre envoyer par Ajax correspond
à 'nom', alors on exécute la fonction
qui complète la recherche.
*/
if (isset($_GET['nom'])){
  autocomplete();
}

/*
Si le paramètre envoyer par Ajax correspond
à 'key', alors on exécute la fonction
qui vérifie si un ingrédient existe.
*/
if (isset($_GET['key'])){
  existe();
}
