<?php

session_start();

function delFav($id){
  if (in_array($id, $_SESSION['favoris'])){
    $key = array_search($id, $_SESSION['favoris']);
    unset($_SESSION['favoris'][$key]);
  }
}

function addFav($id){
  if (!in_array($id, $_SESSION['favoris'])){
    $_SESSION['favoris'][] = intval($id);
  }
}

if (isset($_POST['callDelFav'])) {
  delFav($_POST['callDelFav']);
}

if (isset($_POST['callAddFav'])) {
  addFav($_POST['callAddFav']);
}
