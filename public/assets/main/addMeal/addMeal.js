
$(document).ready(function(){
    function autocomplete(inputId, listId) {
        $('#' + inputId).keyup(function() {
            var query = $(this).val();
            var numero = $(this).attr('num');
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                var form = $('#' + inputId).closest('form');
                var hasScrollbar = form.get(0).scrollHeight > form.innerHeight(); // vérifier si la barre de défilement est active
                var position = hasScrollbar ? form.scrollTop() : 0; // enregistrer la position de défilement correcte
                $.ajax({
                    url: "http://localhost:8000/autocomplet",
                    method: "GET",
                    data: {query: query, numero:numero, _token: _token},
                    success: function(data) {
                        var hasLI = $(data).find('li').length > 0;
                        if (hasLI) {
                            $('#' + listId).fadeIn(1);
                            $('#' + listId).html(data);
                        } else {
                            $('#' + listId).fadeOut(1);
                        }

                        form.scrollTop(hasScrollbar ? position : 0); // restaurer la position de défilement correcte
                    }
                });
            }
        });

        // gérer le clic sur un élément de la liste
        $(document).on('click', '#' + listId + ' li', function(e) {
            e.preventDefault();
            //e.stopPropagation();
            $('#' + inputId).val($(this).text());
            $('#' + listId).fadeOut(1);
            /*var form = $('#' + inputId).closest('form');
            var hasScrollbar = form.get(0).scrollHeight > form.innerHeight();
            var position = hasScrollbar ? form.scrollTop() : 0;
            form.submit(function() {
                form.scrollTop(position);
                //return false;
            });*/
        });

    }

    function fadeListes(inputId, listId){
        $('#' + inputId).keyup(function(){
            var query = $(this).val();
            if(query == ''){
                $('#' + listId).fadeOut(1);
            } else{
                $('#' + listId).fadeIn(1);
            }
        })
    }

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#entreeList, #entree, #plat_principal, #mainCourseList, #dessert, #dessertList').length) {
            $('#entreeList, #mainCourseList, #dessertList').fadeOut(1);
        }
    });


    autocomplete('entree', 'entreeList');
    autocomplete('plat_principal', 'mainCourseList');
    autocomplete('dessert', 'dessertList');

    fadeListes('entree', 'entreeList');
    fadeListes('plat_principal', 'mainCourseList');
    fadeListes('dessert', 'dessertList');

    /* categories of meals */

    const selectedCategories = []; // Tableau pour les catégories sélectionnées
    const categoryMealSelect = $('#category-meal');
    const selectedCategoriesElement = $('#selected_categories');
    const selectedCategoriesInputElement = $('#selected_categories_input');

    categoryMealSelect.on('change', () => {
        const category = categoryMealSelect.val();
        if (category) {
            const categoryIndex = selectedCategories.indexOf(category);
            if (categoryIndex === -1) {
                selectedCategories.push(category);
            } else {
                selectedCategories.splice(categoryIndex, 1);
            }
        } else {
            selectedCategories.pop();
        }
        const selectedCategoriesText = selectedCategories.map((categoryId) => {
            const optionElement = categoryMealSelect.find(`option[value="${categoryId}"]`);
            return optionElement ? optionElement.text() : '';
        }).join(', ');
        selectedCategoriesElement.text(selectedCategoriesText);
        selectedCategoriesInputElement.val(selectedCategories.join(','));
        //categoryMealSelect.val(''); // Réinitialiser la valeur du selecteur pour permettre la désélection de la dernière catégorie
    });

});

