<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\UserController;
use App\http\Controllers\RecipeController;
use App\http\Controllers\IngredientController;

use App\http\Controllers\MealController;
use Illuminate\Auth\Events\Login;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomeController::class, 'home'])->name('app_home');

Route::get('/user_recipes/{id}', [UserController::class, 'getUserRecipes'])->name('app_user_recipes');

Route::get('/user_favorite_recipes/{id}', [UserController::class, 'userFavoriteRecipes'])->name('app_user_favorite_recipes');

Route::get('/details_recipe/{id}', [RecipeController::class, 'detailsRecipe'])->name('app_details_recipe');

Route::get('/comments_recipe/{id}', [RecipeController::class, 'commentsRecipe'])->name('app_comments_recipe');

Route::get('/ingredients_recipe/{id}', [RecipeController::class, 'ingredientsRecipe'])->name('app_ingredients_recipes');

Route::get('/userMeals/{id}', [UserController::class, 'userMeals'])->name('app_user_meals');

Route::get('/meal_recipe/{id}', [RecipeController::class, 'mealsRecipe'])->name('app_meal_recipe');

Route::get('/meal_category/{id}', [MealController::class, 'mealsCategory'])->name('app_category_meal');

Route::get('/recipe_category/{id}', [RecipeController::class, 'recipeCategories'])->name('app_category_recipe');

Route::get('/meal_recipes/{id}', [MealController::class, 'mealsRecipes'])->name('app__meal_recipes');

Route::get('/meal_recipes/{id}', [MealController::class, 'mealsRecipes'])->name('app_meal_recipes');
/*
Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('app_login');

Route::match(['get', 'post'], '/register', [LoginController::class, 'register'])->name('app_register');
*/
Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->middleware(['auth', 'verified'])
        ->name('app_dashboard');

Route::get('/meal/create', [MealController::class, 'showAddMealForm'])->name('app_meal_create')->middleware(['auth', 'verified']);

Route::post('/meal/add', [MealController::class, 'storeMeal'])->name('app_meal_store')->middleware(['auth', 'verified']);

Route::get('/recipe/create', [MealController::class, 'addMeal'])->name('app_recipe_create'); //oumaima

Route::get('/tag/entress', [HomeController::class, 'tagEntrees'])->name('app_tag_entrees');

Route::get('/tag/salades', [HomeController::class, 'tagSalades'])->name('app_tag_salades');

Route::get('/tag/gratins', [HomeController::class, 'tagGratins'])->name('app_tag_gratins');

Route::get('/tag/soupes', [HomeController::class, 'tagSoupes'])->name('app_tag_soupes');

Route::get('/tag/pates', [HomeController::class, 'tagPates'])->name('app_tag_pates');

Route::get('/tag/poulet', [HomeController::class, 'tagPoulets'])->name('app_tag_poulets');

Route::get('/tag/riz', [HomeController::class, 'tagRiz'])->name('app_tag_riz');

Route::get('/tag/poisson', [HomeController::class, 'tagPoissons'])->name('app_tag_poissons');

Route::get('/tag/petit_dejeuner', [HomeController::class, 'tagPetitDejeuners'])->name('app_tag_petit_dejeuners');

Route::post('/search', [HomeController::class, 'search'])
        ->name('app_search');
Route::get('/search/field={search_field}&for={whatSearching}', [HomeController::class, 'searchingSomething'])
        ->name('app_searchedRecipes');


Route::match(['get', 'post'], '/my_account', [LoginController::class, 'myAccount'])->name('app_my_account')->middleware(['auth', 'verified']);
Route::match(['get', 'post'],'/modificating_account', [LoginController::class, 'modificationsAccount'])
        ->name('app_modificating_account')
        ->middleware(['auth', 'verified']);

Route::get('/my_account/update_password', [LoginController::class, 'updatePasswordForm'])
        ->name('app_update_password_form')
        ->middleware(['auth', 'verified']);
Route::match(['get', 'post'], '/updating', [LoginController::class, 'updatePassword'])
        ->name('app_update_password')
        ->middleware(['auth', 'verified']);

Route::get('/search', [HomeController::class, 'searchAjax']);

Route::get('/all_recipes', [HomeController::class, 'allRecipes'])->name('app_all_recipes');

Route::get('/users/{user_id}/favorites_recipes', [UserController::class, 'favoritesRecipesOfUser'])
                ->middleware(['auth', 'verified'])
                ->name('app_favorites_recipes_of_user');
Route::get('/users/{user_id}/recipes', [UserController::class, 'getUserRecipes'])
                ->middleware(['auth', 'verified'])
                ->name('app_recipes_of_user');
Route::get('/users/{user_id}/meals', [UserController::class, 'getUserMeals'])->name('app_meals_of_user');

Route::get('/my_account/deleting', [UserController::class, 'showDeleteForm'])
                    ->middleware(['auth', 'verified'])
                    ->name('app_delete_account_form');

Route::match(['get', 'post'], '/my_account/deleted', [UserController::class, 'deleteAccount'])
                    ->name('app_delete_account');

Route::get('/categories_of_recipes/category={id}/recipes', [HomeController::class, 'categoryRecipes'])->name('app_recipes_of_category');

Route::get('/categories_of_meals/category={id}/meals', [HomeController::class, 'categoryMeals'])->name('app_meals_of_category');

Route::get('/recipes/id={id}', [RecipeController::class, 'displayRecipe'])->name('app_recipe');

Route::get('/add_comment_and_mark', [RecipeController::class, 'addCommentAndMark']);

Route::get('/add_favorite_recipe', [UserController::class, 'addFavoriteRecipe']);
Route::get('/recipes/id={recipe_id}/delete', [UserController::class, 'deleteRecipe'])
        ->name('app_delete_recipe')
        ->middleware(['auth', 'verified']);

Route::get('/autocomplet', [MealController::class, 'mealAutoComplete'])->name('autocomplete');

Route::get('/meal_Added', [MealController::class, 'mealAdded'])->name('app_meal_added');

Route::get('/meal_recipes/{id}', [HomeController::class, 'mealRecipes'])->name('app_meal_recipes');

Route::get('/meal/{id}/delete', [MealController::class, 'deleteMeal'])
        ->name('app_delete_meal')
        ->middleware(['auth', 'verified']);

Route::get('/meal/{id}/old', [MealController::class, 'getOldMeal'])
        ->name('app_old_meal')
        ->middleware(['auth', 'verified']);

Route::post('/meal/{id}/update', [MealController::class, 'updateMeal'])
        ->name('app_update_meal')
        ->middleware(['auth', 'verified']);






Route::get('/show_add_recipe_form',[RecipeController::class, 'addNewRecipe'])->name('app_add_new_recipe');

Route::get('/recipe_added_success',[RecipeController::class, 'successAddRecipe'])->name('app_recipe_added_success');

Route::post('/add_new_recipe',[RecipeController::class, 'submitNewRecipe'])->name('app_submit_new_recipe');

Route::get('/ingredients/search', [IngredientController::class, 'searchIngredient'])->name('app_ingredients_search');

Route::get('/show_add_recipe_form/check-ingredient', [IngredientController::class, 'checkIngredient'])->name('app_check_ingredient_exist');

// Route::get('/ajouter-new-ingredient-form', [IngredientController::class, 'showNewIngredientForm'])->name('app_show_ingredient.creation');

Route::get('/ajouter-new-ingredient', [IngredientController::class, 'createNewIngredient'])->name('app_ingredient.creation');

Route::get('/recipes/id={id}/modify', [RecipeController::class, 'modifyRecipeShowForm'])
                                ->middleware(['auth', 'verified'])
                                ->name('app_modify_recipe_form');

Route::post('/recipes/id={id}/modifiying', [RecipeController::class, 'modifiyingRecipe'])
        ->middleware(['auth', 'verified'])
        ->name('app_modifiying_recipe');

Route::get('/get_cat_ids', [RecipeController::class, 'getCatIds'])->middleware(['auth', 'verified']);
