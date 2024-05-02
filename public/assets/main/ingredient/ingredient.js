$(document).ready(function() {

    $('#myform').submit(function(event){
        var ingredientList = $('#ingredient-list').val();
        if (ingredientList == '') {
            event.preventDefault();
            $('#ingredient-list-error').text('La liste des ingrédients est vide.');
        }
    });

    var mouse_is_inside_search_list_item_for_ingredient = false;
    //Gestion de la fonctionnalité de recherche d'ingrédient par lettre
    $('#name_ingredient_input').on('input', function() {
        var query = $(this).val(); // Récupère la lettre tapée
        if (query !== '' && isNaN(query)) {
            var _token = $('input[name="_token"]').val(); // Récupère le token puis envoie la requête
            $.ajax({
                url: "/ingredients/search",
                method: "GET",
                data: {query: query, _token: _token}, // Passe la lettre saisie et le token CSRF
                success: function(data) {
                    if (data != null && data.length > 0) {
                        let content = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
                        data.forEach((e) => {
                            content += '<li class="dropdown-item" data-unit-ingredient="'+e['unit']+'">'+e['name_ingredient']+'</li>';
                        });
                        content += '</ul>';
                        $('#ingredientList').html(content); // Insère le contenu retourné par le serveur

                        if ($('#ingredientList').length) { // Vérifie si la liste déroulante contient des éléments
                            $('#ingredientList').hover(function(){
                                mouse_is_inside_search_list_item_for_ingredient = true;
                            }, function(){
                                mouse_is_inside_search_list_item_for_ingredient  = false;
                            });

                            $('#ingredientList').fadeIn(); // Affiche la liste déroulante si elle contient des éléments
                            $('#ingredientList').on('click', 'li', function() {
                                $('#name_ingredient_input').val($(this).text()); // Met le texte de l'élément cliqué dans l'input
                                $('#unit-label').val($(this).attr('data-unit-ingredient'));
                                $('#ingredientList').fadeOut(); // Cache la liste déroulante
                            });
                        } else {
                            $('#ingredientList').fadeOut(); // Cache la liste déroulante
                            $('#name_ingredient_exist_error').text('Ingrédient non existant.');
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        } else {
            $('#ingredientList').fadeOut(); // Masque la liste déroulante
            $('#name_ingredient_exist_error').text('Veuillez saisir une lettre.'); // Affiche le message d'erreur
        }
    });

   // Ajouter les ingrédients et leurs quantités à la base de données
    var selectedIngredients = {};  // Créer un objet pour stocker les ingrédients sélectionnés
    var rows = $('#table-ingredient-list tr');

    jQuery.each( rows, function( i, val ) {

        var id = $(val).find('td:first').find('div:first').attr('data-ingredient-name-id');
        $('#'+id).click(function() {
            var ingredient_name_val = $('#ingredient-name-div-'+id).text();
            console.log(name);
            console.log(ingredient_name_val);
            delete selectedIngredients[ingredient_name_val];


            $(this).parent().parent().parent().remove();
            updateSelectedIngredients();
            if (jQuery.isEmptyObject(selectedIngredients)) {
                $('#ingredient-list-title').text('');
                $('#selected_ingredients_hidden').val('');
            }

        });
        var name = $(val).find('td:first').find('div:first').text().trim();
        var quantity = $(val).find('td:nth-child(2)').find('div:first').text().split(' ')[0];
        var unit = $(val).find('td:nth-child(2)').find('div:first').text().split(' ')[1];
        selectedIngredients[name] = {quantity: quantity, unit: unit};
    });
    $('#selected_ingredients_hidden').val(JSON.stringify(selectedIngredients));

    // Fonction pour ajouter un ingrédient à la liste
    function addIngredientToList(ingredient_id,ingredient_name, quantity, unit) {
        selectedIngredients[ingredient_name] = { quantity: quantity, unit: unit };
        $('#table-ingredient-list').append(
            $('<tr>').attr('id', 'list-ingredient-result-'+ingredient_name)
                     .attr('data-ingredient-id', ingredient_id)
                     .append(
                        $('<td>').append(
                            $('<div>').attr('id', 'ingredient-name-div-'+ingredient_id).attr('data-ingredient-name-id', ingredient_name).text(ingredient_name)
                                )
                            )
                     .append(
                        $('<td>').append($('<div>').text(quantity + ' ' + unit))
                        )
                     .append(
                        $('<td>').addClass('ingredient-trash').html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="'+ingredient_id+'" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>')
                        )
            );
        // $('#ingredient-list').append($('<div>').addClass('d-flex').addClass('ingredient').addClass('justify-content-between').attr('id', 'list-ingredient-result-'+ingredient_name).attr('data-ingredient-id', ingredient_id));
        // $('#list-ingredient-result-'+ingredient_name).append($('<div>').attr('id', 'ingredient-name-div-'+ingredient_name).attr('data-ingredient-name-id', ingredient_name).text(ingredient_name))
        //                             .append($('<div>').text(quantity + ' ' + unit))
        //                             .append($('<div>').addClass('ingredient-trash').html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>'));


        //var newIngredient = '<div class="ingredient" data-ingredient-id="' + ingredient_id + '">' + ingredient_name + '-' + quantity + ' ' + unit + '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>'+'</div>';
        //$('#ingredient-list').append(newIngredient);
    }
    $('#ajout-ingredient-button').click(function() {
        var ingredient_name = $('#name_ingredient_input').val();
        var quantity = $('#quantity').val();
        if (ingredient_name == '') {
            $('#name_ingredient_exist_error').text('Champ requis');
        }
        else if ($.isNumeric(ingredient_name)) {
            $('#name_ingredient_exist_error').text('Le nom de l\'ingrédient ne peut pas être un nombre');
        }
        else if (quantity == '') {
            $('#quantity_error').text('Champ requis');
        }
        else if (parseFloat(quantity) <= 0) {
            $('#quantity_error').text('La quantité doit être supérieure à zéro');
        }

       // Vérifier l'existence de l'ingrédient dans la liste sélectionnée
        if (selectedIngredients[ingredient_name]) {
            var msgError = $('#name_ingredient_exist_error').text('Cet ingrédient a déjà été ajouté à la liste');
            setTimeout(function(){ msgError.fadeOut('slow'); }, 3000);
        } else {
            // Vérifie l 'existance de l'ingrédient
            $.ajax({
                url: '/show_add_recipe_form/check-ingredient',
                type: 'get',
                data: {ingredient_name : ingredient_name},
                success: function(response) {
                        if (response['exists']) {
                            var ingredient_id = response.id;
                            var unit = response.unit;
                            addIngredientToList(ingredient_id, ingredient_name, quantity, unit);
                            // Mettre à jour la valeur du champ caché avec les ingrédients sélectionnés
                            updateSelectedIngredients();
                        } else {
                            $('#name_ingredient_exist_error').text('Ingrédient non existant.');

                        }
                        $('svg#'+ingredient_id).click(function() {
                            var ingredient_name_val = $('#ingredient-name-div-'+ingredient_id).attr('data-ingredient-name-id');
                            delete selectedIngredients[ingredient_name_val];
                            updateSelectedIngredients();

                            $(this).parent().parent().remove();

                            if (jQuery.isEmptyObject(selectedIngredients)) {
                                $('#ingredient-list-title').text('');
                                $('#selected_ingredients_hidden').val('');
                            }
                        });
                        $('#name_ingredient_input').val('');
                        setTimeout(function(){  $('#name_ingredient_exist_error').text(''); }, 3000);
                        $('#quantity').val('');
                        $('#unit-label').val('');
                },
                error: function(xhr) {
                    console.log(xhr);
                    alert('Erreur lors de la vérification de l\'existance de l\'ingrédient.');
                }
            });
        }
        if (selectedIngredients.length != 0) {
            $('#ingredient-list-title').text('Liste des ingrédients :');
        }
    });
    function updateSelectedIngredients() {
        var hiddenInput = $('#selected_ingredients_hidden');
        var selectedIngredientsJson = JSON.stringify(selectedIngredients);
        hiddenInput.val(selectedIngredientsJson);
    }
    $('#name_ingredient_input').on('input', function() {
        $('#name_ingredient_exist_error').text('');
    });

    $('#quantity').on('input', function() {
        $('#quantity_error').text('');
    });




    // // Parcourir tous les messages d'erreur et ajouter un délai de 5 secondes pour les masquer
    // var errors = $('.error');
    // errors.each(function() {
    //     var error = $(this);
    //     setTimeout(function() {
    //     error.hide();
    //     $('.is-invalid').removeClass('is-invalid');
    //     }, 5000); // Délai de 5 secondes
    // });

    $('input[type="checkbox"]').on('input', function() {
        // supprimer la classe d'erreur et le message associé
        $('.error').hide();
        $('#type_recipe').removeClass('is-invalid');
    });

    $('#category-recipe').change(function() {
        $('.error').hide();
        $('#category-recipe').removeClass('is-invalid');
    });

    $('input[name="picture"]').on('change', function() {
        $('.error').hide(); // Cacher tous les messages d'erreur
        $(this).removeClass('is-invalid'); // Enlever la classe 'is-invalid' pour supprimer la bordure rouge
    });

    $('#ajout-ingredient-button').click(function() {
        $('.error').hide();
        $('#ingredient-list').removeClass('is-invalid');
    });

    // parcourir tous les champs
    $(':input').each(function() {
        // ajouter un gestionnaire d'événements sur chaque champ
        $(this).on('input', function() {
        // supprimer la classe d'erreur et le message associé
        $(this).removeClass('is-invalid');
        $(this).next('.error').hide();
        });
    });



    //Affichage fenêtre modale

     $('#openModal').on('click', function(e) {
        e.preventDefault();
        $('#myModal').show();
    });

    // Cacher
    $('#annuler-ing-button').on('click', function() {
        $('#myModal').hide();
    });

    $('#annuler-ing-button, .close').on('click', function() {
        $('#myModal').hide();
    });

    //Essai insertion nouveau ingredient avec ajax
     $('#ajout-ing-button').click(function() {
        var nom = $('#new_ingredient_name').val();
        var unite =  $('#unite').val();
        var valeur_nutri = $('#nutri').val();

        name_ingredient_valid = false;
        unite_valid = false;
        valeur_nutri_valid= false;

        if (nom != '') {
            if (!$.isNumeric(nom)) {
                name_ingredient_valid = true;
            } else {
                $('#name_new_ingredient_error').text('Le nom de l\'ingrédient ne peut pas être un nombre');
                $('#new_ingredient_name').addClass('is-invalid');
            }
        } else {
            $('#name_new_ingredient_error').text('Champ requis');
            $('#new_ingredient_name').addClass('is-invalid');
        }

        if (valeur_nutri != '') {
            if (parseInt(valeur_nutri) > 0) {
                valeur_nutri_valid = true;
            } else {
                $('#value_nutri_error').text('La valeur nutritionnelle doit être supérieure à zéro');
                $('#nutri').addClass('is-invalid');
            }
        } else {
            $('#value_nutri_error').text('Champ requis');
            $('#nutri').addClass('is-invalid');
        }

        if (unite != '') {
            unite_valid = true;
        } else {
            $('#unite_error').text('Champ requis');
            $('#unite').addClass('is-invalid');
        }

        if(name_ingredient_valid && valeur_nutri && unite_valid){
            $.ajax({
                url: '/ajouter-new-ingredient',
                type: 'get',
                data: {nom : nom, unite : unite, valeur_nutri : valeur_nutri},
                success: function(response) {
                    if(response != ''){
                        console.log(response);
                        $('#ingredient-added').addClass('alert alert-success').text('Ingrédient ajouté avec succès');
                        setTimeout(()=>{
                            $('#ingredient-added').removeClass('alert alert-success').text('');
                        }, 2000);
                        $('#unite').val('');
                        $('#new_ingredient_name').val('');
                        $('#unite_error').text('');
                        $('#nutri').val('');
                        $('#value_nutri_error').text('');
                        $('#new_ingredient_name').removeClass('is-invalid');
                        $('#nutri').removeClass('is-invalid');
                        $('#unite').removeClass('is-invalid');
                    }else {
                        $('#ingredient-added').addClass('alert alert-danger').text('Ingrédient déjà existe');
                        setTimeout(()=>{
                            $('#ingredient-added').removeClass('alert alert-danger').text('');
                        }, 2000);
                        $('#unite').val('');
                        $('#new_ingredient_name').val('');
                        $('#unite_error').text('');
                        $('#nutri').val('');
                        $('#value_nutri_error').text('');
                        $('#new_ingredient_name').removeClass('is-invalid');
                        $('#nutri').removeClass('is-invalid');
                        $('#unite').removeClass('is-invalid');
                    }
                    $('#myModal').hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                    alert('Erreur insertion ingredient.');
                }
            });
        }
    });
    $('#annuler-ing-button').click(function() {
        $('#name_new_ingredient_error').text('');
        $('#unite').val('');
        $('#unite_error').text('');
        $('#nutri').val('');
        $('#value_nutri_error').text('');
        $('#new_ingredient_name').removeClass('is-invalid');
        $('#nutri').removeClass('is-invalid');
        $('#unite').removeClass('is-invalid');
    });

    $("body").mouseup(function(){
        if(! mouse_is_inside_search_list_item_for_ingredient) $('#ingredientList').fadeOut(100);
    });

});


