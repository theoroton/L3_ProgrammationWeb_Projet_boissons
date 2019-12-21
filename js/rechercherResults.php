<?php

//Requis pour manier les variables de sessions
session_start();

/*
Si des ingrédients ont étaient spécifiés dans la recherche, alors on les
places dans la variable de session pour les récupérer plus tard
pour les résultats.
*/
if (isset($_POST['souhaites']) || isset($_POST['nonsouhaites'])){
  $_SESSION['souhaites'] = $_POST['souhaites'];
  $_SESSION['nonsouhaites'] = $_POST['nonsouhaites'];
}
