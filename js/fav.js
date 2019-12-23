$(document).ready(function(){

  /*
  Quand on appuie sur l'image de favori (addFav),
  on exécute cette fonction.
  */
  $(document).on('click','#addFav', function(){
    //On récupère l'id de la recette
    var id = document.getElementById("id").value;

    /*
    On exécute une requête Ajax dans laquelle
    on appelle le fichier 'modifyFavoris.php',
    avec l'id de la recette, qui va ajouter la
    recette au favoris.
    */
    $.ajax({
      method: "POST",
      url: 'js/modifyFavoris.php',
      data: {
        "callAddFav": id
      },
      success:function(data){
        /*
        Après le retour, on efface l'image courante et
        on la remplace par celle de l'autre action.
        */
        $("#fav").empty();
        $("#fav").html(
          "<img id=delFav class=fav src=img/broken_heart.png width=30 height=30>"
        );
      }
    });
  });


  /*
  Quand on appuie sur l'image de suppression de
  favori (delFav), on exécute cette fonction.
  */
  $(document).on('click','#delFav', function(){
    //On récupère l'id de la recette
    var id = document.getElementById("id").value;

    /*
    On exécute une requête Ajax dans laquelle
    on appelle le fichier 'modifyFavoris.php',
    avec l'id de la recette, qui va retirer la
    recette des favoris.
    */
    $.ajax({
      method: "POST",
      url: 'js/modifyFavoris.php',
      data: {
        "callDelFav": id
      },
      success:function(data){
        /*
        Après le retour, on efface l'image courante et
        on la remplace par celle de l'autre action.
        */
        $("#fav").empty();
        $("#fav").html(
          "<img id=addFav class=fav src=img/heart.png width=30 height=30>"
        );
      }
    });
  });


  /*
  Quand on appuie sur l'image de suppression de
  favori dans le panier (delFavPanier), on exécute
  cette fonction.
  */
  $(document).on('click','.delFavPanier', function(){
    //On récupère l'id de la recette correspondante
    var id = $(this).attr('value');

    /*
    On exécute une requête Ajax dans laquelle
    on appelle le fichier 'modifyFavoris.php',
    avec l'id de la recette, qui va retirer la
    recette du panier.
    */
    $.ajax({
      method: "POST",
      url: 'js/modifyFavoris.php',
      data: {
        "callDelFav": id
      },
      success:function(data){
        /*
        Après le retour, on recharge le panier
        */
        window.location.href = "panier";
      }
    });
  });
});
