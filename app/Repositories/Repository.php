<?php

namespace App\Repositories;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


use App\Models\Meal;
use App\Models\Recipe;
use App\Models\MealRecipe;
use App\Models\User;
use App\Models\UserRecipeComment;
use App\Models\CategoryMeal;
use App\Models\CategoryOfMeal;
use App\Models\CategoryOfRecipe;
use App\Models\CategoryRecipe;
use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\TypeOfRecipe;
use App\Models\TypeRecipe;
use App\Models\Comment;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\Storage;


class Repository
{
    public function getThreeLastAddedRecipes()
    {
        return Recipe::orderBy('created_at', 'desc')->take(3)->get();
    }

    public function getBestThreeMarkedRecipes()
    {
        // la variable $mark est une table qui contient deux attribut recipe_id et mark
        $mark = DB::table('marks')
                   ->select('recipe_id', DB::raw('avg(mark) as mark'))
                   ->groupBy('recipe_id');

        // on fera une jointure avec la table recipes pour récupérer les autres informations
        return DB::table('recipes')
                        ->joinSub($mark, 'mark', function ($join) {
                            $join->on('recipes.id', '=', 'mark.recipe_id');
                        })
                        ->orderBy('mark', 'desc')
                        ->take(3)
                        ->get();
    }

    public function getRecipe($recipe_id)
    {
        return Recipe::findOrFail($recipe_id);
    }

    public function getRecipeTypes($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)->types()->get();
    }


    public function getMeals()
    {
        return Meal::all();
    }
    public function getIngredients()
    {
        return Ingredient::all();
    }
    public function getMeal($meal_id)
    {
        return Meal::findOrFail($meal_id);
    }

    public function getThreeLastUserRecipes($user_id)
    {
        return User::findOrFail($user_id)
                     ->recipes()
                     ->orderBy('created_at', 'DESC')
                     ->take(3)
                     ->get();
    }

    public function getThreeLastUserMeals($user_id)
    {
        return User::findOrFail($user_id)
                     ->meals()
                     ->orderBy('created_at', 'DESC')
                     ->take(3)
                     ->get();
    }

    public function getMealsContainsRecipeWithNames($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)->meals()
                        ->join('meals as M', 'meal_id','=', 'M.id')
                        ->get();
    }

    public function getMealRecipes($meal_id)
    {
        return Meal::findOrFail($meal_id)
                      ->recipes()
                      ->get();
    }
    public function getRecipeMark($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)
                        ->users()
                        ->avg('mark');
    }

    public function getRecipeIngredients($recipe_id)
    {
        return DB::table('ingredient_recipe as ir')
                    ->select('i.id', 'i.name_ingredient', 'ir.quantity_ingredient', 'i.unit')
                    ->join('ingredients as i', 'ir.ingredient_id', '=', 'i.id')
                    ->where('ir.recipe_id', $recipe_id)
                    ->get();
    }

    public function getIngredientId($name_ingredient): int
    {
        $ingredient = Ingredient::where('name_ingredient', $name_ingredient)->first();
        if ($ingredient) {
            return $ingredient->id;
        } else {
            return -1;
        }
    }

    public function getRecipesSearchedByName(String $string)
    {
        return Recipe::where('name', 'like', "%$string%")->orderBy('created_at', 'DESC')->paginate(10);
    }
    public function getRecipeIngredientsWithQuantities($recipe_id)
    {
        return DB::table('ingredient_recipe')
                    ->where('recipe_id', $recipe_id)
                    ->join('ingredients as i', 'i.id', '=', 'ingredient_id')
                    ->get();
    }

    public function getNutriValRecipe($recipe_id): int
    {
        $ingredients = $this->getRecipeIngredientsWithQuantities($recipe_id);
        $nutVal = 0;
        foreach($ingredients as $ingredient)
        {
            if($ingredient->unit == 'g')
            {
                $nutVal += $ingredient->nutri_value * $ingredient->quantity_ingredient / 100;
            }
            if($ingredient->unit == 'ml')
            {
                $nutVal += $ingredient->nutri_value  * $ingredient->quantity_ingredient / 100;
            }
            if($ingredient->unit == 'portion')
            {
                $nutVal += $ingredient->nutri_value  * $ingredient->quantity_ingredient;
            }
        }
        return $nutVal;
    }


    public function getFirstFiveRecipesSearchedByName(String $string)
    {
        return Recipe::where('name', 'like', "%$string%")->orderBy('name')->take(5)->get();
    }
    public function getRecipeComments($recipe_id)
    {
        return UserRecipeComment::join('comments as c', 'c.id', '=', 'comment_id')
                                    ->join('users as u', 'user_is', '=', 'u.id')
                                    ->where('recipe_id', $recipe_id)
                                    ->get();
    }

    // public function getRecipesSearchedByName(String $string)
    // {
    //     return Recipe::where('name', 'like', "%$string%")->orderBy('name')->get();
    // }

    public function getRecipesSearchedByIngredient(String $string)
    {
        return Ingredient::where('name_ingredient', 'like', "%$string%")
                            ->join('ingredient_recipe as ri', 'ri.ingredient_id', '=', 'ingredients.id')
                            ->join('recipes as r', 'r.id', '=', 'ri.recipe_id')
                            ->paginate(10);
    }

    public function getFirstFiveRecipesSearchedByIngredient(String $string)
    {
        return Ingredient::where('name_ingredient', 'like', "%$string%")
                            ->join('ingredient_recipe as ri', 'ri.ingredient_id', '=', 'ingredients.id')
                            ->join('recipes as r', 'r.id', '=', 'ri.recipe_id')
                            ->take(5)
                            ->get();
    }

    public function getUsers()
    {
        return User::all()->sortBy('first_name');
    }

    public function getUser($user_id)
    {
        return User::findOrFail($user_id);
    }

    public function getRecipeIdByName($name_recipe)
    {
        return Recipe::where('name', $name_recipe)
                    ->get();
    }

    public function getCategoriesOfRecipes()
    {
        return CategoryRecipe::all();
    }

    public function getAllUnits()
    {
        return Ingredient::distinct()->select('unit')->get();
    }

    public function getCategoriesOfMeals()
    {
        return CategoryMeal::all();
    }


    public function getSpecificRecipe($recipe_id)
    {
        return Recipe::where('id', $recipe_id)->firstOrFail();
    }

    public function getCategoriesOfOneRecipe($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)
                        ->categories()
                        ->get();
    }


    public function getCategoriesOfOneMeal($meal_id)
    {
        return Meal::findOrFail($meal_id)
                     ->categories()
                     ->get();
    }

    public function getOneCategoryRecipes($category_id)
    {
        return CategoryRecipe::findOrFail($category_id);
    }

    public function getAllRecipesOfOneCategory($category_recipe_id)
    {
        return CategoryRecipe::findOrFail($category_recipe_id)
                                ->recipes()
                                ->orderBy('created_at', 'DESC')
                                ->paginate(2);
    }

    public function getOneCategoryMeals($category_id)
    {
        return CategoryMeal::findOrFail($category_id);
    }

    public function getAllMealsOfOneCategory($category_meal_id)
    {
        return CategoryMeal::findOrFail($category_meal_id)
                             ->meals()
                             ->orderBy('created_at', 'DESC')
                             ->get();
    }

    public function arrayMealIdsWithTheireRecipes($meals)
    {
        $result = array();
        foreach ($meals as $meal) {
            $recipes = $this->getMealRecipes($meal->id);
            $result[$meal->id] = $recipes;
        }
        return $result;
    }

    public function arrayMealIdsWithTheireCategories($meals)
    {
        $result = array();
        foreach ($meals as $meal) {
            $categories = $this->getCategoriesOfOneMeal($meal->id);
            $result[$meal->id] = $categories;
        }
        return $result;
    }

    public function arrayRecipeIdsWithTheireCategories($recipes)
    {
        $result = array();
        foreach ($recipes as $recipe) {
            $categories = $this->getCategoriesOfOneRecipe($recipe->id);
            $result[$recipe->id] = $categories;
        }
        return $result;
    }

    public function paginate($items, $perPage = 2, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    public function getUserMarkOfRecipe($user_id, $recipe_id)
    {
        return DB::table('marks')->where([
            ['user_id', '=', $user_id],
            ['recipe_id', '=', $recipe_id]
        ])->get();
    }
    public function getMark($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)->marks()->avg('mark');
    }

    public function addComment($comment) : object
    {
        return Comment::create($comment);
    }

    public function addRecipe(array $recipe) : Recipe
    {
        return Recipe::create($recipe);
    }

    public function addMeal(array $meal): Meal
    {
        return Meal::create($meal);
    }

    public function addMealIntoCategory($meal_id, $category_meal_id): object
    {
        $row = [
            'meal_id' => $meal_id,
            'category_meal_id' => $category_meal_id
        ];

        return CategoryOfMeal::create($row);
    }

    public function getUnits()
    {
        return Ingredient::orderBy('unit', 'DESC')->distinct()->get('unit');
    }


    public function addRecipeIntoMeal($meal_id, $recipe_id): object
    {
        $row = [
            'meal_id' => $meal_id,
            'recipe_id' => $recipe_id
        ];

        return MealRecipe::create($row);
    }

    public function addRecipeCommentedBy($user_id, $recipe_id, $comment_id): object
    {
        $row = [
            'user_id' => $user_id,
            'recipe_id' => $recipe_id,
            'comment_id' => $comment_id
        ];

        return UserRecipeComment::create($row);
    }

    public function ingredientExists(String $name)
    {
        return Ingredient::where('name_ingredient', $name)->get();
    }

    public function addIngredient($ingredient)
    {
        return Ingredient::create($ingredient);
    }

    public function addUser($user): object
    {
        return User::create($user);
    }

    public function addIngredientToRecipe($ingredient_id, $recipe_id, $quantity): IngredientRecipe
    {
        $row = [
            'recipe_id' => $recipe_id,
            'ingredient_id' => $ingredient_id,
            'quantity_ingredient' => $quantity
        ];

        return IngredientRecipe::create($row);
    }

    public function ageOfUser($user_id) : int
    {
        $user = User::findOrFail($user_id);
        $timestamp = strtotime($user['birthday']);
        return date('Y') - idate('Y', $timestamp);
    }
    /*
    public function getMealStarters(Request $request)
    {

        $data = Recipe::select("name")
                    ->where('name','LIKE','%'. $request->get('query'). '%')
                    ->get();

        return response()->json($data);
    }
    */
    public function getMealCategories()
    {
        return CategoryMeal::all();
    }

    public function getMealAutoComplete(Request $request)
    {
        if($request->get('query'))
        {
            $dish = 'i';
            switch($request->numero){
                case '1':
                    $dish ='entrée';
                    break;
                case '2':
                    $dish='plat principal';
                    break;
                case '3':
                    $dish = 'dessert';
                    break;
            }

            $query = $request->get('query');
            $data = DB::table('recipes')
                ->join('types_of_recipes', 'recipes.id','=','types_of_recipes.recipe_id')
                ->join('type_recipes', 'types_of_recipes.type_recipe_id','=','type_recipes.id')
                ->where('recipes.name', 'LIKE', "%{$query}%")
                ->where('type_recipes.name_type_recipe', '=', $dish)
                ->orderBy('recipes.name')
                ->take(5)
                ->get();

            return $data;
        }
    }
    /*
    public function getMealMainCourses(Request $request)
    {
        $data = Recipe::select("name")
                    ->where('name', 'LIKE', '%{$request->query}%')
                    ->get();

        return response()->json($data);
    }

    public function getMealDesserts(Request $request)
    {
        $data = Recipe::orderby('name','asc')
                    ->select("name")
                    ->where('name', 'LIKE', '%'. $request->get('query'). '%')
                    ->limit(5)
                    ->get();

        return response()->json($data);
    }
    */
    public function getCommentsOfOneRecipe($recipe_id)
    {
        return UserRecipeComment::join('comments as c', 'comment_id','=', 'c.id')
                        ->join('users as u', 'user_id', '=', 'u.id')
                         ->where('recipe_id', $recipe_id)
                         ->get();
    }

    public function getTagEntrees()
    {
        return DB::table('recipes')
                    ->join('types_of_recipes', 'recipes.id','=','types_of_recipes.recipe_id')
                    ->join('type_recipes', 'types_of_recipes.type_recipe_id','=','type_recipes.id')
                    ->where('name_type_recipe', 'entrée')
                    ->paginate(2);
    }

    public function getTagSalades()
    {
        return DB::table('recipes')
                    ->whereRaw("LOWER(name) LIKE '%salade%'")
                    ->paginate(2);
    }

    public function getTagGratins()
    {
        return DB::table('recipes')
                    ->whereRaw("LOWER(name) LIKE '%gratin%'")
                    ->paginate(2);
    }

    public function getTagSoupes()
    {
        return DB::table('recipes')
                    ->whereRaw("LOWER(name) LIKE '%soupe%'")
                    ->paginate(2);
    }

    public function getTagPates()
    {
        return DB::table('recipes')
                    ->whereRaw("REPLACE(LOWER(name), 'â', 'a') LIKE '%pate%'")
                    ->paginate(2);
    }

    public function getTagPoulets()
    {
        return DB::table('recipes')
                    ->whereRaw("LOWER(name) LIKE '%poulet%'")
                    ->paginate(2);
    }

    public function getTagRiz()
    {
        return DB::table('recipes')
                    ->whereRaw("LOWER(name) LIKE '%riz%'")
                    ->paginate(2);
    }

    public function getTagPoissons()
    {
        return DB::table('recipes')
                    ->whereRaw("LOWER(name) LIKE '%poisson%'")
                    ->paginate(2);
    }

    public function getTagPetitDejeuners()
    {
        return DB::table('recipes')
                    ->whereRaw("LOWER(name) LIKE '%petit dej%' OR INSTR(LOWER(name), '%petit-dej%') > 0 OR INSTR(LOWER(name), '%petitdej%') > 0")
                    ->paginate(2);
    }

    public function updateUser(int $user_id, array $modif)
    {
        return User::where('id', $user_id)->update($modif);
    }

    function changePassword(int $userId, string $oldPassword, string $newPassword): void
    {
        $user = User::findOrFail($userId);
        $passwordHash = $user['password'];
        $ok = Hash::check($oldPassword, $passwordHash);
        if($ok){
            $newPasswordHash = Hash::make($newPassword);
            User::where('id', $userId)
                        ->update(['password' => $newPasswordHash]);
            return;
        }
        else
            throw new Exception("Mot de passe incorrecte");
    }

    public function getMealCategoriesByMealId($meal_id)
    {
        return Meal::findOrFail($meal_id)
                        ->categories()
                        ->get();
    }

    public function checkIngredientExist($name)
    {
        return Ingredient::where('name_ingredient',$name)->get();
    }

    public function addIngredientToRecipeByNameOfIngredient($recipeId, $ingredientName, $quantity)
    {
        $ingredientId = $this->getIngredientId($ingredientName);
        if($ingredientId != -1)
        {
            $row = $this->addIngredientToRecipe($ingredientId, $recipeId, $quantity);
        }
        else
            return null;
    }

    public function searchIngredientByLetter(Request $request)
    {
        $query = $request->get('query');
        return Ingredient::where('name_ingredient', 'LIKE', "%{$query}%")
                            ->orderBy('name_ingredient')
                            ->take(5)
                            ->get();
    }
    public function updateIngredientsRecipe($recipeId, $ingredientNames, $quantities)
    {
        DB::table('ingredient_recipe')->where('recipe_id', $recipeId)->delete();

        for ($index = 0; $index < sizeof($ingredientNames); $index++) {
            $this->addIngredientToRecipeByNameOfIngredient($recipeId, $ingredientNames[$index], $quantities[$index]);
        }
    }

    public function addRecipeIntoCategory($recipe_id,$category_recipe_id): CategoryOfRecipe
    {
        $row =[
            'recipe_id' => $recipe_id,
            'category_recipe_id' => $category_recipe_id
        ];
     return CategoryOfRecipe::create($row);
    }

    public function getSelectedTypeRows($selectedTypes)
    {
        return DB::table('type_recipes')->whereIn('name_type_recipe', $selectedTypes)
                         ->get();
    }
    public function updatePictureRecipe($recipe_id, $name)
    {
        $recipe = Recipe::findOrFail($recipe_id);
        $oldName = $recipe->picture;
        $recipe->update(['picture' => $name]);
        if($oldName != null)
        {
            if(File::exists(public_path('assets/img/recipe/' . $oldName)))
                File::delete(public_path('assets/img/recipe/' . $oldName));
            else
                dd('file not found');
        }
    }
    public function addRecipeIntoType($recipe_id, $type_recipe_id): TypeOfRecipe
    {
        $row =[
            'recipe_id' => $recipe_id,
            'type_recipe_id'=>$type_recipe_id
        ];
     return TypeOfRecipe::create($row);
    }
    public function updateRecipe($id, $recipe)
    {
        Recipe::findOrFail($id)->update($recipe);
    }
    public function updateRecipeTypes($id, $selectedTypeRows)
    {
        TypeOfRecipe::where('recipe_id', $id)->delete();

        foreach ($selectedTypeRows as $selectedTypeRow) {
            $this->addRecipeIntoType($id, $selectedTypeRow->id);
        }
    }
    public function deleteOldCategoriesOfRecipe($id)
    {
        DB::table('categories_of_recipes')->where('recipe_id', $id)->delete();
    }

    public function getCatId($cat): int
    {
        $row = CategoryRecipe::where('name_category_recipe', $cat)->get();
        dd($row);
        return $row[0]->id;
    }

    public function updateMeal(int $meal_id, array $modif, $oldMeal, $img)
    {
        if($img)
            if(File::exists(public_path('assets/img/meal/' . $oldMeal->picture_meal)))
                File::delete(public_path('assets/img/meal/' . $oldMeal->picture_meal));

        Meal::where('id', $meal_id)->update($modif);
    }

    public function updateRecipeIntoMeal(int $meal_id, int $recipe_id, array $row)
    {
        MealRecipe::where('meal_id', $meal_id)
                    ->where('recipe_id', $recipe_id)
                    ->update($row);
    }

    public function updateMealIntoCategory($meal_id, $categoriesId)
    {
        CategoryOfMeal::where('meal_id', $meal_id)->delete();
        foreach($categoriesId as $cat)
        {
            CategoryOfMeal::create([
                'meal_id' => $meal_id,
                'category_meal_id' => $cat
            ]);
        }
    }

    public function deleteMeal($meal_id)
    {
        Meal::findOrFail($meal_id)->delete();
        MealRecipe::where('meal_id', $meal_id)->delete();

    }





}
