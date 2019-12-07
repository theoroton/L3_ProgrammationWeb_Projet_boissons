<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>My wonderful first web page</title>
  <link rel="stylesheet" type="text/css" href="../../style/cocktails.css">
  <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
</head>

<?php
require_once "../Donnees.inc.php";
require_once "./ajax.php"
?>

<body>
  <?php
  require "./header.php";
  ?>
  <div class="favoris">
    <article>
      <h4>Mes recettes préférées</h4>
    </article>
  </div>
</body>