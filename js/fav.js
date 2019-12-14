$(document).ready(function(){
  $(document).on('click','#addFav', function(){

    var id = document.getElementById("id").value;

    $.ajax({
      method: "POST",
      url: 'js/modifyFavoris.php',
      data: {
        "callAddFav": id
      },
      success:function(data){
        $("#imgFav").empty();
        $("#imgFav").html(
          "<img id=delFav class=fav src=img/broken_heart.png width=30 height=30>"
        );
      }
    });
  });



  $(document).on('click','#delFav', function(){

    var id = document.getElementById("id").value;

    $.ajax({
      method: "POST",
      url: 'js/modifyFavoris.php',
      data: {
        "callDelFav": id
      },
      success:function(data){
        $("#imgFav").empty();
        $("#imgFav").html(
          "<img id=addFav class=fav src=img/heart.png width=30 height=30>"
        );
      }
    });
  });



  $(document).on('click','.delFavPanier', function(){

    var id = $(this).attr('value');

    $.ajax({
      method: "POST",
      url: 'js/modifyFavoris.php',
      data: {
        "callDelFav": id
      },
      success:function(data){
        window.location.href = "panier";
      }
    });
  });
});
