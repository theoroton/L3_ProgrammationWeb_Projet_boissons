$(document).ready(function(){

	var search = document.getElementById('search');
	var results = document.getElementById('results');
	var previousRequest;
  var previousValue = search.value;

	function getResults(mot) {

	    var xhr = new XMLHttpRequest();
	    xhr.open('GET', 'js/autocomplete.php?nom='+ encodeURIComponent(mot));

    	xhr.addEventListener('readystatechange', function() {
        	if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
	            displayResults(xhr.responseText);
        	}
	    });

	    xhr.send(null);

	    return xhr;

	}

	function displayResults(rep) {

	    if (rep.length) {
				  results.style.display = 'block';

	        rep = rep.split('|');
	        results.innerHTML = '';

	        for (var i = 0, div ; i < rep.length ; i++) {

            	div = results.appendChild(document.createElement('div'));
            	div.innerHTML = rep[i];

            	div.addEventListener('click', function(e) {
                	chooseResult(e.target);
	            });

	        }

	    } else {
					results.style.display = 'none';
			}

	}

	function chooseResult(res) {

	    search.value = previousValue = res.innerHTML;
	    results.style.display = 'none';
	    res.className = '';
	    search.focus();

	}

	search.addEventListener('keyup', function(e) {
			document.getElementById('erreur').innerHTML = "";

      if (search.value != previousValue) {

	        previousValue = search.value;

	        if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
	            previousRequest.abort();
        	}

	        previousRequest = getResults(previousValue); 
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
				window.location.href = "search";
			}
    });

	});

});
