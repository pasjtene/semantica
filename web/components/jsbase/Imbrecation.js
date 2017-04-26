/**
 * Created by Danick takam on 10/03/2016.
 */
$(function(){

    var elt = {
        logement_photos : "#produits_photos",
        ajouter : '#ajout_photo'
    }
    var $container = $('div#produits_photos');
    var $lienAjout = $('<a href="" id="ajout_fichiers" class="btn btn-flat waves-effect waves-dark">Nouveau fichier</a> <br/><br/>');
    $container.append($lienAjout);
    $lienAjout.click(function(e) {
        ajouterphoto($container);
        e.preventDefault();
        return false;
    });

    var index = $container.find(':input').length;
    console.log("index : "+ index);

    if (index == 0  ) {
        ajouterphoto($container);
        console.log(10);
    }
    else
    {
        $container.children('div').each(function() {
            ajouterLienSuppression($(this));
            console.log(12);
        });
    }

    function ajouterphoto($container) {
        var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Photo n°' + (index + 1))
            .replace(/__name__/g, index));
        //	alert(JSON.stringify($container.attr('data-prototype')));


        ajouterLienSuppression($prototype);
        $container.append($prototype);

        index++;
    }


    function ajouterLienSuppression($prototype) {
        $lienSuppression = $('<br/> ' +
            '<a href="" class="btn red waves-effect waves-dark">Supprimer</a> <br/> <br/>');
        $prototype.append($lienSuppression);
        $lienSuppression.click(function(e) {
            $prototype.remove();
            e.preventDefault();
            return false;
        });
    }

});