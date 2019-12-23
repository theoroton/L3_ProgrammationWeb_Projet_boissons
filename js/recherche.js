$(document).ready(function(){

	//On récupère l'input de recherche
	var search = document.getElementById('search');
	//On récupère la div pour stocker les résultats
	var results = document.getElementById('results');
	//On stocke la requete précédente afin de l'annuler quand on ajoute une lettre à l'ingrédient recherché
	var previousRequest;
	//On stocke la valeur précédente
  var previousValue = search.value;

	/*
	Fonction qui effectue une recherche et récupère les résultat.
	*/
	function getResults(mot) {

	    var xhr = new XMLHttpRequest();
			//On utilise le fichier autocomplete.php auquel on donne le mot écrit
	    xhr.open('GET', 'js/autocomplete.php?nom='+ encodeURIComponent(mot));

    	xhr.addEventListener('readystatechange', function() {
        	if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
	            displayResults(xhr.responseText);
        	}
	    });

	    xhr.send(null);

	    return xhr;

	}

	/*
	Fonction qui affiche les résultats
	*/
	function displayResults(rep) {

			/*
			Si on a des résultats alors on modifie la div contenant les résultats.
			*/
	    if (rep.length) {
				  results.style.display = 'block';

					//On enlève les précédents résultats.
	        results.innerHTML = '';


					rep = rep.split('|');
					//On ajoute chacun des ingrédients trouver à la div des résultats.
	        for (var i = 0, div ; i < rep.length ; i++) {

            	div = results.appendChild(document.createElement('div'));
            	div.innerHTML = rep[i];

							//Quand on clique sur un élément, on le choisit
            	div.addEventListener('click', function(e) {
                	chooseResult(e.target);
	            });

	        }

	    } else {
					results.style.display = 'none';
			}

	}

	/*
	Fonction qui est appeler quand on choisit un ingrédient.
	*/
	function chooseResult(res) {
		  //On change la valeur du champ de recherche
	    search.value = previousValue = res.innerHTML;
	    results.style.display = 'none';
	    search.focus();
	}

	//Quand on appuie sur une touche dans le champ de recherche
	search.addEventListener('keyup', function(e) {
			document.getElementById('erreur').innerHTML = "";
			//Si la valeur afficher est nouvelle
      if (search.value != previousValue) {
	        previousValue = search.value;

					//On arrête la recherche précédente
	        if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
	            previousRequest.abort();
        	}

					//On récupère les résultats de la recherche
	        previousRequest = getResults(previousValue);
    	}

	});

	//Quand on ajoute un ingrédient à la liste des souhaités, on vérifie si il existe
	$(document).on('click','#addIngreSouhaiter', function(){
		check(true);
	});

	//Quand on ajoute un ingrédient à la liste des non souhaités, on vérifie si il existe
	$(document).on('click','#addIngrePasSouhaiter', function(){
		check(false);
	});

	/*
	Fonction qui permet de vérifier si un ingrédient existe.
	*/
	function check(div){
		let key = document.getElementById('search').value

		let x = new XMLHttpRequest();
		x.open('GET', 'js/autocomplete.php?key='+ encodeURIComponent(key));
		x.addEventListener('readystatechange', function() {
				if (x.readyState == XMLHttpRequest.DONE && x.status == 200) {
						/*
						Si l'ingrédient existe, on l'ajoute bien dans la div souhaité.
						Sinon on affiche une erreur.
						*/
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

	/*
	Fonction qui ajoute un élément à une div d'ingrédient.
	*/
	function addIngredient(div){
		let ingredients = document.getElementsByClassName('ingr');
		let res = true;
		let ingre = document.getElementById('search').value;

		/*
		On regarde si l'ingrédient n'est pas déjà présent dans une
		des divs.
		*/
		for (let i of ingredients) {
    	if (i.innerHTML == ingre){
				res = false;
			}
		}

		/*
		Si l'ingrédient n'est pas déjà présent, alors on l'ajoute.
		Sinon on affiche une erreur.
		*/
		if (res){
			let d;
			let ingredient;

			if (div){
				d = document.getElementById('souhaite');
				ingredient = "<div class='ingr +ingr'>" + ingre + "</div>";
			} else {
				d = document.getElementById('nesouhaitepas');
				ingredient = "<div class='ingr -ingr'>" + ingre + "</div>";
			}

			d.innerHTML += ingredient;

		} else {
			document.getElementById('erreur').innerHTML = "Cet ingrédient est déjà présent dans la recherche";
		}

		document.getElementById('search').value = "";
	}

	/*
	Quand on clique sur réinitialiser, on vide les 2 divs
	des ingrédients.
	*/
	$(document).on('click','#reinit', function(){
		document.getElementById('souhaite').innerHTML = "";
		document.getElementById('nesouhaitepas').innerHTML = "";
	});

	/*
	Quand on clique sur recherche, on effectue la recherche avec
	les ingrédients spécifiés.
	*/
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

		/*
		On effectue une requête Ajax en donnant
		les ingrédients.
		*/
		$.ajax({
      method: "POST",
      url: 'js/rechercherResults.php',
      data: {
        "souhaites": souhaites,
				"nonsouhaites": nonsouhaites
      },
      success:function(data){
				//On redirige vers la page des résultats.
				window.location.href = "search";
			}
    });

	});

});
