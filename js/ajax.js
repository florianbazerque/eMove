
$( document ).ready(function() {
	/*$('.formulaire').submit(function(e){
		$.ajax({
	       url : 'post.php',
	       type : 'POST',
	       dataType : 'html',
	       success : function(data, statut){
	           $('.afficher').text(data); // On passe code_html à jQuery() qui va nous créer l'arbre DOM !
	       },

	       error : function(resultat, statut, erreur){
	       		alert('error');
	       },

	       complete : function(resultat, statut){
	       		alert('complete');
	       }

	    });
		return false;
	});*/

	$('.bar_search').submit(function(e){
		$.ajax({
	       	url : 'post.php',
	       	type : 'POST',
	      	dataType : 'html',
	       	success : function(data, statut){
	       		$('.shop .col-lg-10').empty();
	           	$('.shop .col-lg-10').text(data);
	       	},

	       	error : function(resultat, statut, erreur){
	       		alert('error');
	       	},

	       	complete : function(resultat, statut){
	       	}

	    });
		return false;
	});
});

