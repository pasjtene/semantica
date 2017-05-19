$(function(){
	
	var elt = {
		logement_photos : "#web_entitybundle_projet_files",
		ajouter : '#ajout_fichier'
	}
	var loale ="";
	var $container = $('div#web_entitybundle_projet_files');
	var $lienAjout = $('<a href="" id="ajout_fichier" class="btn ajout blue waves-effect waves-dark">Nouvelle Fichier</a> <br/><br/>');
	$container.append($lienAjout);
	$lienAjout.click(function(e) {
		ajouterphoto($container);
		e.preventDefault();
		return false;
	});

	var index = $container.find(':input').length;

	if (index == 0) {
		ajouterphoto($container);
	} else {
		$container.children('div').each(function() {
			ajouterLienSuppression($(this));
		});
	}

	function ajouterphoto($container) {
		var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Fichier n°' + (index + 1))
			                                                .replace(/__name__/g, index));
	//	alert(JSON.stringify($container.attr('data-prototype')));


		ajouterLienSuppression($prototype);
		$container.append($prototype);

		index++;
	}


	function ajouterLienSuppression($prototype) {
		$lienSuppression = $('<br/> <a href="" class="btn red waves-effect waves-dark delete">Supprimer</a> <br/> <br/>');
		$prototype.append($lienSuppression);
		$lienSuppression.click(function(e) {
			$prototype.remove();
			e.preventDefault(); 
			return false;
		});
	}

});