//Fonctionnalité : gestion plusieurs catégories d'une seule recette

$(document).ready(function() {
    var selectedCategories = []; //Tableau pour les catégories sélectionnées
    if($('#selected_categories') != undefined){
        var oldSelectedCategories = $('#selected_categories').text().trim().split(',');
        var arrayCatIds = [];
        $.ajax({
            url: '/get_cat_ids',
            method: 'get',
            data: {oldSelectedCategories : oldSelectedCategories},
            success: function(data){
                $.each(data, function(key, value) {
                    arrayCatIds.push(value);
                });
                $('#selected_categories_input').val(arrayCatIds.join(','));
            }
        });
        $('#selected_categories_input').val(oldSelectedCategories.join(','));
        
    }
    
    $("#category-recipe").change(function() { 
        var category = $(this).val(); //Recupère la catégo selectionné
        if (category !== "") {
            if (selectedCategories.includes(category)) {
                selectedCategories.splice(selectedCategories.indexOf(category), 1);//Retirer de mon tableau la catégorie si elle est déjà sélectionnée
                $("#category-msg").text('');
                $("#category-recipe").val('');
            } else {
                selectedCategories.push(category);//Ajout de ma catégorie dans mon tableau
                $("#category-msg").text("Pour retirer une catégorie veuillez la re-sélectionner.");
                $("#category-recipe").val('');
            }
        }
        
        var selectedCategoriesText = selectedCategories.map(function(cat_id) {
            return $('#category-recipe option[value="' + cat_id + '"]').text();
        }).join(", ");
        $("#selected_categories").text(selectedCategoriesText);
        $("#selected_categories_input").val(selectedCategories.join(",")); // Mettre à jour la valeur du champ de formulaire caché
    });  
});







const stars = document.querySelectorAll('.star');
let check = false;

stars.forEach(star => {
    star.addEventListener('mouseover', selectStars);
    star.addEventListener('mouseleave', unSelectStars);
    star.addEventListener('click', activeSelect);

});

function selectStars(e) {
    const data = e.target;
    const mark = previousSibling(data);
    if(!check){
        mark.forEach((e)=>{
            e.classList.add('hover');
        });
    }
}
function unSelectStars(e) {
    const data = e.target;
    const mark = previousSibling(data);
    if(!check){
        mark.forEach((e)=>{
            e.classList.remove('hover');
        });
    }
}
function previousSibling(data) {
    const values = [data];
    while (data = data.previousSibling) {
        if (data.nodeName === "I") {
            values.push(data);
        }
    }
    return values;
}

function activeSelect(e) {
    if(!check){
        check = true;
        $('.note').text(e.target.dataset.note);
    }
    else{
        check = false;
        unSelectAllStars();
    }
}

function unSelectAllStars() {
    stars.forEach(star => {
        star.classList.remove('hover');
    });
}


// add comment

var btnAddComment = $('#add-comment');
var recipeId = $('#recipe-id').val();

btnAddComment.click((e) => {
    var comment = $('#text-comment').val();
    //var markUser = $('.note').text();
    var markUser = $('.note').text() == "" ? "5" : $('.note').text();
    if(comment != ""){
        $('#text-comment').removeClass('is-invalid');
        $.ajax({
            type: 'get',
            url: '/add_comment_and_mark',
            data: {'comment' : comment.trim(), 'mark': markUser, 'recipe_id': recipeId},
            success: function (data) {
                if(data != null){
                    $('#result-comments').html("");
                    $('#result-comments').append(data);
                    $('#text-comment').val("");
                    check = false;
                    unSelectAllStars()
                }
            }
        });
    }
    else{
        $('#text-comment').addClass('is-invalid');
    }
});


// save recipe

var btnSave = $('#save-btn');
if($('#save-btn').attr('data-saved') != undefined)
    var isSaved = $('#save-btn').attr('data-saved').trim();
btnSave.click((e)=>{
    isSaved = $('#save-btn').attr('data-saved').trim();
    // display the popup
    if(isSaved == "0"){
        $('.message').text("Voulez-vous sauvegarder cette recette ?");
    }
    else {
        $('.message').text("Voulez-vous retirer cette recette de votre liste des recettes favorites ?");
    }
    $('.popup-save').css("display", "flex");
});

// confirmation case:
$('#yes-save').click((e)=>{
    isSaved = $('#save-btn').attr('data-saved').trim();
    $.ajax({
        type: 'get',
        url: '/add_favorite_recipe',
        data: {'recipe_id': recipeId, 'isSaved': isSaved},
        success: function (data) {
            if(data != null){
                if(data == 1){
                    $('#save-btn').attr('data-saved', '1');
                    $('#btn-save-style').removeClass('btn-primary');
                    $('#btn-save-style').addClass('btn-success');
                    $('#btn-save-style').text("Retirer");
                }
                if(data == 0){
                    $('#save-btn').attr('data-saved', '0');
                    $('#btn-save-style').removeClass('btn-success');
                    $('#btn-save-style').addClass('btn-primary');
                    $('#btn-save-style').text("Sauvegarder");
                }
            }
            $('.popup-save').css("display", "none");
            $('.message').text("");
        }
    });
});

// cancel case:
$('#no-save').click((e)=>{$('.popup-save').css("display", "none");});

// delete
$('#delete-btn').click((e)=>{
    $('.popup-delete').css("display", "flex");
});

$('#no-delete').click((e)=>{$('.popup-delete').css("display", "none");});
