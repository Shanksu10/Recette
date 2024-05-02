<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Repository;
use App\Repositories\UserDao;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected Repository $repository;
    protected UserDao $userDao;

    public function __construct(Repository $repository, UserDao $userDao)
    {
        $this->repository = $repository;
        $this->userDao = $userDao;
    }

    public function dashboard()
    {

        $user = Auth::user();

        if($user == null)
            return redirect()->route('login');

        $userAge = $this->repository->ageOfUser($user->id);
        $userRecipes = $this->repository->getThreeLastUserRecipes($user->id);
        $userMeals = $this->repository->getThreeLastUserMeals($user->id);

        // tableau assosiatif de clés l'id des plats et de valeurs un tableau des catédories de ce plat
        $mealsWithCategories = $this->userDao->getTheThreeLastMealsCategoriesOfUser($user->id);
        $userFavoriteRecipes = $this->userDao->getFavoriteRecipesOfUser($user->id);
        $userFavoriteRecipes = $this->userDao->getFavoriteRecipesOfUser($user->id);
        $countUserRecipes = $this->userDao->countUserRecipes($user->id);
        $countUserMeals = $this->userDao->countUserMeals($user->id);
        $countUserFavoriteRecipes = $this->userDao->countUserFavoriteRecipes($user->id);

        return view('user.dashboard', [
            'user' => $user,
            'age' => $userAge,
            'userRecipes' => $userRecipes,
            'userMeals' => $userMeals,
            'userFavoriteRecipes' => $userFavoriteRecipes,
            'countUserRecipes' => $countUserRecipes,
            'countUserMeals' => $countUserMeals,
            'countUserFavoriteRecipes' => $countUserFavoriteRecipes,
            'mealsWithCategories' => $mealsWithCategories
        ]);
    }

    public function favoritesRecipesOfUser($user_id)
    {
        if(Auth::user() == null)
            return redirect()->route('login');

        $recipes = $this->userDao->getFavoriteRecipesOfUser($user_id);
        return view('user.favorites_recipes', compact('recipes'));
    }

    public function getUserRecipes($user_id)
    {
        if(Auth::user() == null)
            return redirect()->route('login');

        $recipes = $this->userDao->getUserRecipes($user_id);
        return view("user.userRecipes", compact('recipes'));
    }

    public function getUserMeals($user_id){
        if(Auth::user() == null)
            return redirect()->route('login');

        $meals = $this->userDao->getUserMeals($user_id);
        $arrayIdMealsWithCategories = $this->userDao->getMealsCategoriesOfUser($user_id);
        $arrayIdmealsWithRecipes = $this->userDao->getUserMealsWithRecipes($user_id);

        return view('user.userMeals', compact('meals', 'arrayIdMealsWithCategories', 'arrayIdmealsWithRecipes'));
    }

    public function showDeleteForm()
    {
        if(Auth::user() == null)
            return redirect()->route('login');
        return view('user.delete_form');
    }

    public function deleteAccount(Request $request)
    {
        if(Auth::user() == null)
            return redirect()->route('login');

        $rules = [
            'email' => ['required', 'in:'. Auth::user()->email],
            'password' => ['required', new MatchOldPassword()],
        ];
        $messages = [
            'email.required' => 'Vous devez mentionner votre adresse mail.',
            'email.in' => 'Tapez la bonne adresse mail.',
            'password.required' => 'La mot de passe est obligatoire pour valider cette opération.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try {

            $deleted = $this->userDao->deleteUser(Auth::user()->id);
            if(!$deleted)
                return redirect()->back()->withInput()->withErrors("Nous n'avons pas pu supprimer votre compte !");
            return redirect()->route('login');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Nous n'avons pas pu supprimer votre compte !");
        }
    }

    public function addFavoriteRecipe(Request $request)
    {
        if(Auth::user() == null)
            return null;

        if($request['isSaved'] == '0')
        {
            $row = $this->userDao->addFavoriteRecipe($request['recipe_id']);
            return 1;
        }
        else{
            $this->userDao->deleteFavoriteRecipe($request['recipe_id']);
            return 0;
        }
    }

    public function deleteRecipe(int $recipe_id)
    {
        if(Auth::user() == null)
            return redirect()->route('login');

        try {
            $this->userDao->deleteRecipe($recipe_id);
            return redirect()->route('app_dashboard');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function userFavoriteRecipes($user_id)
    {
        $favorites = $this->userDao->getFavoriteRecipesOfUser($user_id);
        return view("user.favorite_recipes", ['favorites' => $favorites]);
    }


}
