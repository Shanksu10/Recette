<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\RecipeDao;
use App\Repositories\Repository;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected Repository $repository;
    protected RecipeDao $recipeDao;


    public function __construct(Repository $repository, RecipeDao $recipeDao)
    {
        $this->repository = $repository;
        $this->recipeDao = $recipeDao;
    }

    public function home(){
        $users = $this->repository->getUsers();
        $lastThreeRecipes = $this->repository->getThreeLastAddedRecipes();
        $threeBestMarkedRecipes = $this->repository->getBestThreeMarkedRecipes();
        return view("home.home", [
            'users' => $users,
            'lastThreeRecipes' => $lastThreeRecipes,
            'threeBestMarkedRecipes' => $threeBestMarkedRecipes
        ]);
    }

    public function tagEntrees()
    {
        $entrees = $this->repository->getTagEntrees();
        return view('home.jaiEnvie.jaiEnvieEntree', ['entrees' => $entrees]);
    }

    public function tagSalades()
    {
        $salades = $this->repository->getTagSalades();
        return view('home.jaiEnvie.jaiEnvieSalade', ['salades' => $salades]);
    }

    public function tagGratins()
    {
        $gratins = $this->repository->getTagGratins();
        return view('home.jaiEnvie.jaiEnvieGratin', ['gratins' => $gratins]);
    }

    public function tagSoupes()
    {
        $soupes = $this->repository->getTagSoupes();
        return view('home.jaiEnvie.jaiEnvieSoupe', ['soupes' => $soupes]);
    }

    public function tagPates()
    {
        $pates = $this->repository->getTagPates();
        return view('home.jaiEnvie.jaiEnviePate', ['pates' => $pates]);
    }

    public function tagPoulets()
    {
        $poulets = $this->repository->getTagPoulets();
        return view('home.jaiEnvie.jaiEnviePoulet', ['poulets' => $poulets]);
    }

    public function tagRiz()
    {
        $riz = $this->repository->getTagRiz();
        return view('home.jaiEnvie.jaiEnvieRiz', ['riz' => $riz]);
    }

    public function tagPoissons()
    {
        $poissons = $this->repository->getTagPoissons();
        return view('home.jaiEnvie.jaiEnviePoisson', ['poissons' => $poissons]);
    }

    public function tagPetitDejeuners()
    {
        $petitDejeuners = $this->repository->getTagPetitDejeuners();
        return view('home.jaiEnvie.jaiEnviePetitDejeuner', ['petitDejeuners' => $petitDejeuners]);
    }
    public function search(Request $request)
    {
        $rules = [
            'search' => ['required', 'regex:/[^\s+]/'],
            'search_fields' => ['required', 'regex:/[^0]/']
        ];
        $messages = [
            'search.regex' => 'Vous devez tapez une chaine de caractères',
            'search_fields.required' => 'Ce champ est obligatoire'
        ];

        $validatedData = $request->validate($rules, $messages);
        try {
            $searchField = $validatedData['search_fields'];
            $whatSearching = $validatedData['search'];
            return redirect()->route('app_searchedRecipes', ['search_field' => $searchField,
                                                            'whatSearching' => $whatSearching]);
        } catch (Exception $exception) {
            return redirect()->back()->withInput();
        }
    }

    public function searchingSomething(String $searchField, String $whatSearching)
    {
        $whatSearching = trim($whatSearching);
        if($searchField == "1")
        {
            $recipes = $this->repository->getRecipesSearchedByName($whatSearching);
        }
        elseif($searchField == "2")
        {
            $recipes = $this->repository->getRecipesSearchedByIngredient($whatSearching);
        }
        else
            return redirect()->route('app_home');
        return view('search.search', [
            'whatSearching' => $whatSearching,
            'recipes' => $recipes
        ]);
    }

    public function searchAjax(Request $request)
    {

        $recipes = $request->field == "1" ?
        $this->repository->getFirstFiveRecipesSearchedByName($request->search)
        : $this->repository->getFirstFiveRecipesSearchedByIngredient($request->search);
        return $recipes;
    }

    public function allRecipes()
    {
        $recipes = $this->recipeDao->getRecipes();
        return view('recipe.all_recipes', compact('recipes'));
    }

    public function categoryRecipes($category_id)
    {
        $category = $this->repository->getOneCategoryRecipes($category_id);
        $recipes = $this->repository->getAllRecipesOfOneCategory($category_id);
        return view('recipe.recipes_of_category', compact('category', 'recipes'));
    }

    public function categoryMeals($category_id)
    {
        $data = array();
        $category = $this->repository->getOneCategoryMeals($category_id);
        $meals = $this->repository->getAllMealsOfOneCategory($category_id);
        $arrayIdMealsWithRecipes = $this->repository->arrayMealIdsWithTheireRecipes($meals);
        $arrayIdMealsWithCategories = $this->repository->arrayMealIdsWithTheireCategories($meals);

        foreach($meals as $meal)
        {
            $data[$meal->id] = [
                'id_meal' => $meal->id, 
                'name_meal' => $meal->name_meal,
                'picture_meal' => $meal->picture_meal,
                'categories' => $arrayIdMealsWithCategories[$meal->id],
                'recipes' => $arrayIdMealsWithRecipes[$meal->id]
            ];
        }
        
        $result = $this->repository->paginate($data);
        return view('meal.meals_of_category', compact('category', 'result'));
    }

    public function mealRecipes($meal_id){
        $meal = $this->repository->getMeal($meal_id);
        $recipes = $this->repository->getMealRecipes($meal_id);
        $arrayIdRecipesWithCategories = $this->repository->arrayRecipeIdsWithTheireCategories($recipes);
        
        $data = array();
        foreach($recipes as $recipe)
        {
            $data[$recipe->id] = [
                'id_recipe' => $recipe->id, 
                'name_recipe' => $recipe->name,
                'picture_recipe' => $recipe->picture,
                'categories' => $arrayIdRecipesWithCategories[$recipe->id]
            ];
        }
        
        return view('meal.meal_recipes', ['recipes' => $data,
                                            'name_meal' => $meal['name_meal'], 
                                            'id_meal' => $meal_id, 
                                            'meal_owner' => $meal['user_id']]);
    }
}
