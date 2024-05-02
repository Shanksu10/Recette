<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exceptions;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;



class IngredientController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function searchIngredient(Request $request) 
    {
            if($request->get('query'))
            {
                $data = $this->repository->searchIngredientByLetter($request);
                return $data;
                //return view('recipe.ingredient_searched_by_letter',['data'=>$data]);
            }
    }

    public function checkIngredient(Request $request)
    {
        $ingredient_name = $request['ingredient_name'];
        $ingredient = $this->repository->checkIngredientExist($ingredient_name);
        if ($ingredient->count() != 0) {
            return response()->json(['exists' => true, 'unit' => $ingredient[0]->unit,'id'=>$ingredient[0]->id]);
        } else {
            return ['exists' => false];
        }
        dd(response());
    }
    // public function showNewIngredientForm()
    // {
    //     if(Auth::user() == null)
    //         return redirect()->route('login');
    //     return view('recipe.add_new_ingredient');
    // }

    public function createNewIngredient(Request $request)
    {
        $ingredient=[
            'name_ingredient' => $request['nom'],
            'nutri_value' => $request['valeur_nutri'],
            'unit' => $request['unite']
        ];
        if($this->repository->ingredientExists($request['nom'])->count() == 0)
            return $this->repository->addIngredient($ingredient);
        return null;
    }
 
}
