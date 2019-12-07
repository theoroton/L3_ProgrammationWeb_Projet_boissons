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
    <h3>Les règles du jeu :</h3>
    <ul class = "regles">
        <li>Cliquez sur une catégorie pour afficher ses sous-catégories.</li>
        <li>Cliquez sur un ingrédient pour afficher ses recettes.</li>
        <li>Cliquez sur une recette pour l'afficher.</li>
        <li>Mettez une étoile à votre recette pour l'ajouter à votre panie!</li>
    </ul>
    <div class = "ing-show">        
    <article class = "parent-ing">
        <h4>Super-Catégories</h4>
        <br>Ici s'affichent les super-catégories de l'élément en cours.</br>
        <?php
            $keys = array_keys($Hierarchie);
            print_ing_fils($keys);
        ?>
    </article>
    <article class = "current-ing">
        <h4>Elément courrant</h4>
        <br>Ici s'affiche l'élément courrant.</br>
        
    </article>
    <article class = "child-ing">
        <h4>Recette</h4>
        <be>Ici s'affichent les recettes de l'ingrédient demandé.</br>
    </article>
    </div>

</body>
</html>
