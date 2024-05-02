<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use App\Http\Controllers\Controller;
use App\Repositories\RecipeDao;
use App\Exceptions;
use Illuminate\Http\Request;
use App\Models\IngredientRecipe;
use Illuminate\Support\Facades\DB;
use App\Models\MealRecipe;
use App\Models\TypeRecipe;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\CategoryRecipe;
use App\Repositories\Repository;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;



class RecipeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected Repository $repository;
    protected RecipeDao $recipeDao;

    public function __construct(Repository $repository, RecipeDao $recipeDao)
    {
        $this->repository = $repository;
        $this->recipeDao = $recipeDao;
    }

    public function ingredientsRecipe($recipe_id){

        $ingredients = $this->repository->getRecipeIngredients($recipe_id);

        return view('recipe.ingredients_recipe', ['ingredients' => $ingredients]);
    }

    public function mealsRecipe($recipe_id){

        $meals = $this->repository->getMealsContainsRecipeWithNames($recipe_id);

        return view('recipe.meal_recipe', ['meals' => $meals]);
    }

    public function recipeCategories($recipe_id){

        $categories = $this->repository->getCategoriesOfOneRecipe($recipe_id);

        return view('recipe.category_recipe', ['categories' => $categories]);
    }

    public function commentsRecipe($recipe_id)
    {
        $comments = $this->repository->getCommentsOfOneRecipe($recipe_id);

        return view('recipe.comments_recipe', ['comments' => $comments]);
    }



    public function addNewRecipe()
    {
        if(Auth::user() == null)
            return redirect()->route('login');
        $allIngredients = $this->repository->getIngredients();
        $allCategories=  $this->repository->getCategoriesOfRecipes();
        $units = $this->repository->getUnits();
        return view('recipe.add_new_recipe', [
            'allIngredients' => $allIngredients,
            'allCategories'=> $allCategories,
            'units' => $units
        ]);
    }

    private $submitForm = false ;

    public function successAddRecipe()
    {
        return view('recipe.recipe_added_success');
    }

    public function submitNewRecipe(Request $request)
    {
        if(Auth::user() == null)
            return redirect()->route('login');
        $validatedData = $this->validateNewRecipeRequest($request);
        try
        {

                $image = $validatedData['picture'];
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/img/recipe');
                $image->move($destinationPath, $name);

                $recipe=[
                    'name'  =>$validatedData['name_recipe'],
                    'description_recipe'=> $validatedData['description'],
                    'preparation_steps'=> $validatedData['preparation'],
                    'preparation_time'=> $validatedData['preparation_time'],
                    'cooking_time'=> $validatedData['cooking_time'],
                    'number_per'=> $request['number_per'],
                    'picture'=> $name,
                    'user_id' => Auth::user()->id
                ];

                $recipeId = $this->repository->addRecipe($recipe)['id'];

                // Récupérer la valeur de l'input caché "selected_ingredients"
                $selectedIngredients = json_decode($validatedData['selected_ingredients'], true);
                $ingredientNames = array_keys($selectedIngredients);

                $tempArray = array_values($selectedIngredients);

                $quantities = array();
                for($i=0; $i < sizeof($tempArray); $i++)
                {
                    $quantities[$i] = $tempArray[$i]['quantity'];
                }
                for ($j=0; $j < sizeof($ingredientNames); $j++) {
                    $ingredientName = $ingredientNames[$j];
                    $quantity = intval($quantities[$j]);
                    $this->repository->addIngredientToRecipeByNameOfIngredient($recipeId, $ingredientName, $quantity);
                }

                $categoryIds = explode(',',$validatedData['category_recipe']);
                foreach ($categoryIds as $categoryId) {
                    $row = $this->repository->addRecipeIntoCategory($recipeId, $categoryId);
                }

                $selectedTypes = $validatedData['type_recipe'];

                $selectedTypeIds = $this->repository->getSelectedTypeRows($selectedTypes);
                foreach ($selectedTypeIds as $selectedTypeId) {
                    $row = $this->repository->addRecipeIntoType($recipeId, $selectedTypeId->id);
                }
                return redirect()->route('app_recipe_added_success');
        }
        catch (Exception $e ){

            return redirect()->back()->withInput()->withErrors("Impossible d'ajouter la recette");
        }

    }

    private function validateNewRecipeRequest(Request $request)
    {

        $rules = [
            'name_recipe' => 'required|string|max:255|unique:recipes,name',
            'description' => 'required',
            'type_recipe' => 'required',
            'category_recipe' => 'required',
            'preparation_time' => 'required|gt:0',
            'cooking_time' => 'nullable|gt:0',
            'number_per' => 'required|integer|gt:0',
            'preparation' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_ingredients'=>'min:1'
        ];

        $messages = [
            'name_recipe.required' => 'Champ requis',
            'name_recipe.unique' => 'Veuillez insérer un nom de recette distinct',
            'name_ingredient.exists' => 'Ingrédient non existant',
            'name_recipe.string' => 'Le champ doit être une chaîne de caractères',
            'name_recipe.max' => 'Le champ nom ne doit pas dépasser 100 caractères',
            'description.required' => 'Champ requis',
            'type_recipe.required' => 'Champ requis',
            'cooking_time.gt' => 'Le champ doit être un nombre positif',
            'category_recipe.required' => 'Champ requis',
            'preparation_time.required' => 'Champ requis',
            'preparation_time.integer' => 'Le champ doit être un nombre entier',
            'preparation_time.gt' => 'Le champ doit être un nombre positif',
            'number_per.required' => 'Champ requis',
            'number_per.integer' => 'Le champ doit être un nombre entier',
            'number_per.gt' => 'Le champ doit être un nombre positif',
            'preparation.required' => 'Champ requis',
            'picture.required' => 'Champ requis',
            'picture.image' => 'Le fichier doit être une image',
            'picture.mimes' => 'Le fichier doit être de type jpeg, png, jpg ou gif',
            'picture.max' => 'La taille du fichier ne doit pas dépasser 2MB',
            'selected_ingredients'=>'Vous devez sélectionner au moins un ingrédient'
        ];

        return $request->validate($rules, $messages);
    }

    public function modifyRecipeShowForm(int $recipe_id)
    {
        $isEntree = false;
        $isPlatPrincipal = false;
        $isDessert = false;
        $recipe = $this->repository->getRecipe($recipe_id);
        $types = $this->repository->getRecipeTypes($recipe_id);
        $categories = $this->repository->getCategoriesOfOneRecipe($recipe_id);
        $ingredients = $this->repository->getRecipeIngredients($recipe_id);
        $allCategories = $this->repository->getCategoriesOfRecipes();
        $units = $this->repository->getUnits();
        foreach($types as $type){
            if($type->name_type_recipe == 'entrée')
                $isEntree = true;
            if($type->name_type_recipe == 'plat principal')
                $isPlatPrincipal = true;
            if($type->name_type_recipe == 'dessert')
                $isDessert = true;
        }
        //dd([$recipe, $types, $categories, $ingredients, $isEntree, $isPlatPrincipal, $isDessert]);
        return view('recipe.modify_recipe_form', compact(
            'recipe',
            'types',
            'categories',
            'ingredients',
            'allCategories',
            'units',
            'isEntree',
            'isPlatPrincipal',
            'isDessert'
        ));
    }

    public function modifiyingRecipe(Request $request, $id)
    {
        if(Auth::user() == null)
          return redirect()->route('login');
          $rules = [
            'name_recipe' => 'required|string|max:255',
            'description' => 'required',
            'type_recipe' => 'required',
            'category_recipe' => 'required',
            'preparation_time' => 'required|gt:0',
            'cooking_time' => 'nullable|gt:0',
            'number_per' => 'required|integer|gt:0',
            'preparation' => 'required',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_ingredients'=>'min:1'
        ];

        $messages = [
            'name_recipe.required' => 'Champ requis',
            'name_ingredient.exists' => 'Ingrédient non existant',
            'name_recipe.string' => 'Le champ doit être une chaîne de caractères',
            'name_recipe.max' => 'Le champ nom ne doit pas dépasser 255 caractères',
            'description.required' => 'Champ requis',
            'type_recipe.required' => 'Champ requis',
            'cooking_time.gt' => 'Le champ doit être un nombre positif',
            'category_recipe.required' => 'Champ requis',
            'preparation_time.required' => 'Champ requis',
            'preparation_time.integer' => 'Le champ doit être un nombre entier',
            'preparation_time.gt' => 'Le champ doit être un nombre positif',
            'number_per.required' => 'Champ requis',
            'number_per.integer' => 'Le champ doit être un nombre entier',
            'number_per.gt' => 'Le champ doit être un nombre positif',
            'preparation.required' => 'Champ requis',
            'picture.image' => 'Le fichier doit être une image',
            'picture.mimes' => 'Le fichier doit être de type jpeg, png, jpg ou gif',
            'picture.max' => 'La taille du fichier ne doit pas dépasser 2MB',
            'selected_ingredients'=>'Vous devez sélectionner au moins un ingrédient'
        ];

        $validatedData= $request->validate($rules, $messages);
        try{
            if($request->picture != null){
                $image = $request->picture;
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/img/recipe');
                $image->move($destinationPath, $name);
                $this->repository->updatePictureRecipe($id, $name);
            }
            $recipe = [
                'name'  =>$validatedData['name_recipe'],
                'description_recipe'=> $validatedData['description'],
                'preparation_steps'=> $validatedData['preparation'],
                'preparation_time'=> $validatedData['preparation_time'],
                'cooking_time'=> $validatedData['cooking_time'],
                'number_per'=> $request['number_per']
            ];
            $this->repository->updateRecipe($id, $recipe);

            $selectedTypes = $validatedData['type_recipe'];
            $selectedTypeRows = $this->repository->getSelectedTypeRows($selectedTypes);
            $this->repository->updateRecipeTypes($id, $selectedTypeRows);

            $categoryIds = explode(',', $validatedData['category_recipe']);
            $this->repository->deleteOldCategoriesOfRecipe($id);
            foreach ($categoryIds as $categoryId) {
                $this->repository->addRecipeIntoCategory($id, $categoryId);
            }

            $selectedIngredients = json_decode($validatedData['selected_ingredients'], true);
            $ingredientNames = array_keys($selectedIngredients);
            $tempArray = array_values($selectedIngredients);
            $quantities = array();
            for($i=0; $i < sizeof($tempArray); $i++)
            {
                $quantities[$i] = $tempArray[$i]['quantity'];
            }

            $this->repository->updateIngredientsRecipe($id, $ingredientNames, $quantities);

            return redirect()->route('app_home');
        }
        catch(Exception $e){
            return redirect()->back()->withInput()->with('error','Recette n\'a été modifiée');
        }
    }

    public function getCatIds(Request $request)
    {
        $result = array();
        foreach($request->oldSelectedCategories as $cat){
            dd($request->oldSelectedCategories);
            $tempId = $this->repository->getCatId($cat);
            $result[$cat] = $tempId;
        }
        return $result;
    }

    public function displayRecipe($recipe_id)
    {
        $dataCommentsNoPaginate = array();

        $recipe = $this->recipeDao->getRecipe($recipe_id);
        $recipeMaker = $this->recipeDao->getRecipeMaker($recipe_id);
        $categories = $this->recipeDao->getCategoriesOfOneRecipe($recipe_id);
        $types = $this->recipeDao->getRecipeTypes($recipe_id);
        $ingredients = $this->recipeDao->getRecipeIngredientsWithQuantities($recipe_id);
        $mark = $this->recipeDao->getRecipeMark($recipe_id);
        $nutriVal = $this->recipeDao->getNutriValRecipe($recipe_id);
        $dataComments = $this->recipeDao->getRecipeCommentsWithMars($recipe_id);
        if(Auth::user())
            $isSaved = $this->recipeDao->isSaved(Auth::user()->id, $recipe_id);
        else
            $isSaved = null;
        foreach ($dataComments as $key => $comment) {
            $dataCommentsNoPaginate[$key] = [
                'comment' => $comment->comment,
                'first_name' => $comment->first_name,
                'last_name' => $comment->last_name,
                'picture' => $comment->picture,
                'mark' => round($comment->mark)
            ];
        }
        $comments = $this->recipeDao->paginate($dataCommentsNoPaginate);
        $myRecipe = false;
        if(Auth::user())
            $myRecipe = $this->recipeDao->myRecipe($recipe_id, Auth::user()->id)->count() != 0;
        return view('recipe.recipe', compact(
                                            'recipe',
                                            'recipeMaker',
                                            'categories',
                                            'types',
                                            'ingredients',
                                            'mark',
                                            'nutriVal',
                                            'myRecipe',
                                            'comments',
                                            'isSaved'
                                        ));
    }

    public function addCommentAndMark(Request $request)
    {
        if(Auth::user() != null){
            $recipe_id = intval($request['recipe_id']);
            if($request['comment'] != ""){
                $comment = $this->recipeDao->addComment($request['comment']);
                $recipeCommentedBy = $this->recipeDao->addRecipeCommentedBy(Auth::user()->id,
                                                                            $recipe_id,
                                                                            $comment->id);
                if($request['mark'] != ""){
                    $mark = intval($request['mark']);
                    if($this->recipeDao->isUserMaredRecipe(Auth::user()->id, $recipe_id)){
                        $markRow = $this->recipeDao->updateMark($recipe_id, Auth::user()->id, $mark);
                    }
                    else
                        $markRow = $this->recipeDao->addMark($recipe_id, Auth::user()->id, $mark);
                }
                else
                    $markRow = null;
            }
            $dataCommentsNoPaginate = array();
            $dataComments = $this->recipeDao->getRecipeCommentsWithMars($recipe_id);
            foreach ($dataComments as $key => $comment) {
                $dataCommentsNoPaginate[$key] = [
                    'comment' => $comment->comment,
                    'first_name' => $comment->first_name,
                    'last_name' => $comment->last_name,
                    'mark' => round($comment->mark),
                    'picture' => $comment->picture
                ];
            }
        $comments = $this->recipeDao->paginate($dataCommentsNoPaginate);
            return view('recipe.display_comments_recipe', compact('comments'));
        }
    }

}
