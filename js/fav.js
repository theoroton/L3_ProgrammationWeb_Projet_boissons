$(document).ready(function(){
  $(document).on('click','#addFav', function(){

    var id = document.getElementById("id").value;

    $.ajax({
      method: "POST",
      url: './js/test.php',
      data: {
        "callAddFav": id
      },
      success:function(data){
        $("#imgFav").empty();
        $("#imgFav").html(
          "<img id=delFav src=img/broken_heart.png width=50 height = 50>"
        );
      }
    });
  });



  $(document).on('click','#delFav', function(){

    var id = document.getElementById("id").value;

    $.ajax({
      method: "POST",
      url: './js/test.php',
      data: {
        "callDelFav": id
      },
      success:function(data){
        $("#imgFav").empty();
        $("#imgFav").html(
          "<img id=addFav src=img/heart.png width=50 height = 50>"
        );
      }
    });
  });



  $(document).on('click','.delFavPanier', function(){

    var id = $(this).attr('value');

    $.ajax({
      method: "POST",
      url: './js/test.php',
      data: {
        "callDelFav": id
      },
      success:function(data){
        window.location.href = "panier";
      }
    });
  });
});
