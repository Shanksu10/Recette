<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryOfMeal;
use App\Models\Meal;
use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Exception;
use Illuminate\Support\Facades\Auth;


class MealController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function mealsCategory($meal_id){
        $categories = $this->repository->getCategoriesOfOneMeal($meal_id);
        return view('meal.category_meal', ['categories' => $categories]);
    }

    public function showAddMealForm(Request $request) // plus besoin de request !
    {
        $categoriesOfMeal = $this->repository->getMealCategories();
        return view('meal.add_meal', compact('categoriesOfMeal'));
    }

    public function mealAutoComplete(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
        $autoCompleteCategory = $this->repository->getMealAutoComplete($request);
        return view('meal.autoCompleteAjax', compact('autoCompleteCategory'));
    }

    public function mealAdded(){

        return view('meal.meal_added');
    }

    public function storeMeal(Request $request)
    {
        if(Auth::user() == null)
                return redirect()->route('login');
        $rules = [
            'nom_plat' => ['required'],
            'category_meal' => ['required'],
            'entree' => ['required'],
            'plat_principal' => ['required'],
            'dessert' => ['required'],
            'picture_meal' => ['required']

        ];

        $messages = [
            'nom_plat.required' => 'Veuillez entrer un nom de plat',
            'category_meal.required' => 'Veuillez sélectionner une categorie',
            'entree.required' => 'Veuillez sélectionner une entrée',
            'plat_principal.required' => 'Veuillez sélectionner un plat principal',
            'dessert.required' => 'Veuillez sélectionner un dessert',
            'picture_meal.required' => 'Veuillez insérer une image du plat'
        ];

        $validatedData = $request->validate($rules, $messages);

        try
        {
            $image = $request->picture_meal;
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('/assets/img/meal'), $imageName);

            $row = [
                'user_id' => Auth::user()->id,
                'name_meal' => $validatedData['nom_plat'],
                'picture_meal' => $imageName
            ];

            $meal = $this->repository->addMeal($row);

            $entreeId = $this->repository->getRecipeIdByName($validatedData['entree'])->first()->id;
            $platPrincipalId = $this->repository->getRecipeIdByName($validatedData['plat_principal'])->first()->id;
            $dessertId = $this->repository->getRecipeIdByName($validatedData['dessert'])->first()->id;

            $entree = $this->repository->addRecipeIntoMeal($meal['id'], $entreeId);
            $platPrincipal = $this->repository->addRecipeIntoMeal($meal['id'], $platPrincipalId );
            $dessert = $this->repository->addRecipeIntoMeal($meal['id'], $dessertId);

            $categoriesId = explode(',',$validatedData['category_meal']);
            foreach ($categoriesId as $categoryId) {
                $this->repository->addMealIntoCategory($meal['id'], $categoryId);
            }
            return redirect()->route('app_meal_added');
        }
        catch (Exception $e)
        {
           return redirect()->back()->withInput()->withErrors("Impossible d'ajouter le plat");
        }
    }

    public function getOldMeal($meal_id)
    {
        //old meal data
        $meal = $this->repository->getMeal($meal_id);
        $mealRecipes = $this->repository->getMealRecipes($meal_id);
        $mealCategories = $this->repository->getMealCategoriesByMealId($meal_id);

        //data for form
        $categoriesOfMeal = $this->repository->getMealCategories();

        return view('meal.update_meal', ['meal' => $meal,
                                        'mealRecipes' => $mealRecipes,
                                        'mealCategories' => $mealCategories,
                                        'categoriesOfMeal' => $categoriesOfMeal
                                        ]);
    }

    public function updateMeal(Request $request, int $meal_id)
    {
        if(Auth::user() == null)
                return redirect()->route('login');
        $rules = [
            'nom_plat' => ['required'],
            'category_meal' =>['required'],
            'entree' => ['required'],
            'plat_principal' => ['required'],
            'dessert' => ['required']

        ];

        $messages = [
            'nom_plat.required' => 'Veuillez entrer un nom de plat',
            'category_meal.required' => 'Veuillez selectionner une categorie de plat',
            'entree.required' => 'Veuillez sélectionner une entrée',
            'plat_principal.required' => 'Veuillez sélectionner un plat principal',
            'dessert.required' => 'Veuillez sélectionner un dessert'
        ];

        $validatedData = $request->validate($rules, $messages);
        try
        {
            $oldMeal = $this->repository->getMeal($meal_id);
            $oldMealRecipes = $this->repository->getMealRecipes($meal_id);
            $oldMealCategories = $this->repository->getMealCategoriesByMealId($meal_id);

            if($request->picture_meal != null){
                $image = $request->picture_meal;
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('/assets/img/meal'), $imageName);
                $img = true;
            }
            else{
                $imageName = $oldMeal->picture_meal;
                $img = false;
            }

            $modif = [
                'name_meal' => $validatedData['nom_plat'],
                'picture_meal' => $imageName
            ];

            $this->repository->updateMeal($meal_id, $modif, $oldMeal, $img);

            //modify entree

            $entreeId = $this->repository->getRecipeIdByName($validatedData['entree'])->first()->id;
            $rowEntree = [
                'meal_id' => $meal_id,
                'recipe_id' => $entreeId
            ];

            $this->repository->updateRecipeIntoMeal($meal_id, $oldMealRecipes[0]->id, $rowEntree);
            //modify plat principel
            $platPrincipalId = $this->repository->getRecipeIdByName($validatedData['plat_principal'])->first()->id;
            $rowPlatPrincipal = [
                'meal_id' => $meal_id,
                'recipe_id' => $platPrincipalId
            ];
            $this->repository->updateRecipeIntoMeal($meal_id, $oldMealRecipes[1]->id, $rowPlatPrincipal);

            //modify dessert
            $dessertId = $this->repository->getRecipeIdByName($validatedData['dessert'])->first()->id;
            $rowDessert = [
                'meal_id' => $meal_id,
                'recipe_id' => $dessertId
            ];
            $this->repository->updateRecipeIntoMeal($meal_id, $oldMealRecipes[2]->id, $rowDessert);
            $categoriesId = explode(',', $validatedData['category_meal']);

            $this->repository->updateMealIntoCategory($meal_id, $categoriesId);

            return redirect()->route('app_meal_recipes', $meal_id);
        }
        catch (Exception $e)
        {
           return redirect()->back()->withInput()->withErrors("Impossible de modifier le plat");
        }
    }

    public function deleteMeal(int $meal_id)
    {
        if(Auth::user() == null)
            return redirect()->route('login');

        try {
            $this->repository->deleteMeal($meal_id);
            return redirect()->route('app_dashboard');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

}
