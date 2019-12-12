<?php

function autocomplete(){
  require_once('../src/data/Donnees.inc.php');

	$data = array_keys($Hierarchie); // Récupération de la liste complète des villes
	$dataLen = count($data);

	sort($data); // On trie les villes dans l'ordre alphabétique

	$results = array(); // Le tableau où seront stockés les résultats de la recherche

	// La boucle ci-dessous parcourt tout le tableau $data, jusqu'à un maximum de 10 résultats

	for ($i = 0 ; $i < $dataLen && count($results) < 10 ; $i++) {
	    if (stripos($data[$i], $_GET['nom']) === 0) { // Si la valeur commence par les mêmes caractères que la recherche

	        array_push($results, $data[$i]); // On ajoute alors le résultat à la liste à retourner

	    }
	}

	echo implode('|', $results); // Et on affiche les résultats séparés par une barre verticale |
}

function existe(){
  require_once('../src/data/Donnees.inc.php');

  if (array_key_exists($_GET['key'],$Hierarchie)){
    echo 'true';
  } else {
    echo 'false';
  }
}

if (isset($_GET['nom'])){
  autocomplete();
}

if (isset($_GET['key'])){
  existe();
}
