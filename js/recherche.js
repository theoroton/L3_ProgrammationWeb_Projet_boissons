$(document).ready(function(){

	var searchElement = document.getElementById('search');
	var results = document.getElementById('results');
	var previousRequest;
  var previousValue = searchElement.value;

	function getResults(keywords) { // Effectue une requête et récupère les résultats

	    var xhr = new XMLHttpRequest();
	    xhr.open('GET', 'js/autocomplete.php?nom='+ encodeURIComponent(keywords));

    	xhr.addEventListener('readystatechange', function() {
        	if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
	            displayResults(xhr.responseText);

        	}
	    });

	    xhr.send(null);

	    return xhr;

	}

	function displayResults(response) { // Affiche les résultats d'une requête

    	results.style.display = response.length ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultats

	    if (response.length) { // On ne modifie les résultats que si on en a obtenu

	        response = response.split('|');
	        var responseLen = response.length;

	        results.innerHTML = ''; // On vide les résultats

	        for (var i = 0, div ; i < responseLen ; i++) {

            	div = results.appendChild(document.createElement('div'));
            	div.innerHTML = response[i];

            	div.addEventListener('click', function(e) {
                	chooseResult(e.target);
	            });

	        }

	    }

	}

	function chooseResult(result) { // Choisi un des résultats d'une requête et gère tout ce qui y est attaché

	    searchElement.value = previousValue = result.innerHTML; // On change le contenu du champ de recherche et on enregistre en tant que précédente valeur
	    results.style.display = 'none'; // On cache les résultats
	    result.className = ''; // On supprime l'effet de focus
	    searchElement.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue

	}

	searchElement.addEventListener('keyup', function(e) {
			document.getElementById('erreur').innerHTML = "";

      if (searchElement.value != previousValue) { // Si le contenu du champ de recherche a changé

	        previousValue = searchElement.value;

	        if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
	            previousRequest.abort(); // Si on a toujours une requête en cours, on l'arrête
        	}

	        previousRequest = getResults(previousValue); // On stocke la nouvelle requête
    	}

	});

	$(document).on('click','#addIngreSouhaiter', function(){
		check(true);
	});

	$(document).on('click','#addIngrePasSouhaiter', function(){
		check(false);
	});

	function check(div){
		let key = document.getElementById('search').value

		let x = new XMLHttpRequest();
		x.open('GET', 'js/autocomplete.php?key='+ encodeURIComponent(key));
		x.addEventListener('readystatechange', function() {
				if (x.readyState == XMLHttpRequest.DONE && x.status == 200) {
						if (x.responseText == "true"){
							addIngredient(div);
						} else {
							document.getElementById('erreur').innerHTML = "Cet ingrédient n'existe pas";
							document.getElementById('search').value = "";
						}
				}
		});
		x.send(null);
	}

	function addIngredient(div){
		let ingredients = document.getElementsByClassName('ingr');
		let res = true;
		let ingre = document.getElementById('search').value;

		for (let i of ingredients) {
    	if (i.innerHTML == ingre){
				res = false;
			}
		}

		if (res){
			let d;

			if (div){
				d = document.getElementById('souhaite');
				d.innerHTML += "<div class='ingr +ingr'>" + ingre + "</div>";
			} else {
				d = document.getElementById('nesouhaitepas');
				d.innerHTML += "<div class='ingr -ingr'>" + ingre + "</div>";
			}

		} else {
			document.getElementById('erreur').innerHTML = "Cet ingrédient est déjà présent dans la recherche";
		}

		document.getElementById('search').value = "";
	}

	$(document).on('click','#reinit', function(){
		document.getElementById('souhaite').innerHTML = "";
		document.getElementById('nesouhaitepas').innerHTML = "";
	});

	$(document).on('click','#effectuerRecherche', function(){
		var s = document.getElementsByClassName("+ingr");
		var n = document.getElementsByClassName("-ingr");

		var souhaites = [];
		var nonsouhaites = [];

		for (let i of s) {
    	souhaites.push(i.innerHTML);
		}

		for (let i of n) {
			nonsouhaites.push(i.innerHTML);
		}

		$.ajax({
      method: "POST",
      url: 'js/rechercherResults.php',
      data: {
        "souhaites": souhaites,
				"nonsouhaites": nonsouhaites
      },
      success:function(data){
				console.log(data);
				window.location.href = "search";
			}
    });

	});

});
