<?php

namespace App\Repositories;

use App\Models\CategoryOfRecipe;
use App\Models\CategoryRecipe;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Mark;
use App\Models\Meal;
use App\Models\Recipe;
use App\Models\TypeOfRecipe;
use App\Models\User;
use App\Models\UserRecipeComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserDao
{
    protected Repository $repository;
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function countUserRecipes(int $userId): int
    {
        return Recipe::where('user_id', $userId)->count();
    }

    public function countUserMeals(int $userId): int
    {
        return Meal::where('user_id', $userId)->count();
    }

    public function countUserFavoriteRecipes(int $userId): int
    {
        return User::findOrFail($userId)->favorites()->count();
    }

    public function getThreeLastUserMeals($user_id)
    {
        return User::findOrFail($user_id)
                     ->meals()
                     ->orderBy('created_at', 'DESC')
                     ->take(3)
                     ->get();
    }

    public function getTheThreeLastMealsCategoriesOfUser($userId)
    {
        $result = array();
        $userMeals = $this->getThreeLastUserMeals($userId);
        foreach ($userMeals as $meal) {
            $categories = $this->repository->getCategoriesOfOneMeal($meal->id);
            $result[$meal->id] = $categories;
        }
        return $result;
    }

    public function getFavoriteRecipesOfUser($user_id)
    {
        return User::findOrFail($user_id)->favorites()->orderBy('created_at', 'DESC')->paginate(2);
    }

    public function getUserRecipes($user_id)
    {
        return User::findOrFail($user_id)
                     ->recipes()
                     ->orderBy('created_at', 'DESC')
                     ->paginate(2);
    }

    public function getUserMeals($user_id)
    {
        return User::findOrFail($user_id)
                     ->meals()
                     ->orderBy('created_at', 'DESC')
                     ->paginate(2);
    }

    public function getMealsCategoriesOfUser($user_id)
    {
        $result = array();
        $userMeals = $this->getUserMeals($user_id);
        foreach ($userMeals as $meal) {
            $categories = $this->repository->getCategoriesOfOneMeal($meal->id);
            $result[$meal->id] = $categories;
        }
        return $result;
    }

    public function getUserMealsWithRecipes($user_id)
    {
        $result = array();
        $userMeals = $this->getThreeLastUserMeals($user_id);
        foreach ($userMeals as $meal) {
            $recipes = $this->repository->getMealRecipes($meal->id);
            $result[$meal->id] = $recipes;
        }
        return $result;
    }

    public function deleteUser($user_id): bool
    {
        $recipes = User::findOrFail($user_id)->recipes()->get();

        foreach($recipes as $recipe)
        {
            $this->deleteRecipe($recipe->id);
        }

        Favorite::where('user_id', $user_id)->delete();

        $meals = User::findOrFail($user_id)->meals()->get();
        foreach($meals as $meal)
        {
            $this->repository->deleteMeal($meal->id);
        }

        $userRecipeComment = UserRecipeComment::where('user_id', $user_id)->get();
        $commentsIds = array();
        for($i = 0; $i < sizeof($userRecipeComment); $i++){
            $commentsIds[$i] = $userRecipeComment[$i]->comment_id;
        }
        for($i = 0; $i < sizeof($commentsIds); $i++){
            Comment::findOrFail($commentsIds[$i])->delete();
        }

        $marks = Mark::where('user_id', $user_id)->get();
        foreach($marks as $mark){
            Mark::findOrFail($mark->id)->delete();
        }

        $picture = User::findOrFail($user_id)->picture;
        if(File::exists(public_path('/assets/img/user/' . $picture))){
            File::delete(public_path('/assets/img/user/' . $picture));
        }

        return User::findOrFail($user_id)->delete();
    }

    public function addFavoriteRecipe(int $recipe_id)
    {
        $data = ['user_id' => Auth::user()->id,
                'recipe_id' => $recipe_id];
        return Favorite::create($data);
    }

    public function deleteFavoriteRecipe(int $recipe_id)
    {
        Favorite::where('recipe_id', $recipe_id)->where('user_id', Auth::user()->id)->delete();
    }

    public function deleteRecipe($recipe_id)
    {
        // delete it categories
        CategoryOfRecipe::where('recipe_id', $recipe_id)->delete();

        // delete it types
        TypeOfRecipe::where('recipe_id', $recipe_id)->delete();

        // delete from favorites table
        Favorite::where('recipe_id', $recipe_id)->delete();

        // delete meals contain it
        $meals = Recipe::findOrFail($recipe_id)->meals()->get();
        foreach($meals as $meal){
            Meal::findOrFail($meal->id)->delete();
        }

        // delete its comments
        $userRecipeComment = UserRecipeComment::where('recipe_id', $recipe_id)->get();
        $commentsIds = array();
        for($i = 0; $i < sizeof($userRecipeComment); $i++){
            $commentsIds[$i] = $userRecipeComment[$i]->comment_id;
        }
        foreach($userRecipeComment as $row){
            UserRecipeComment::findOrFail($row->id)->delete();
        }

        for($i = 0; $i < sizeof($commentsIds); $i++){
            Comment::findOrFail($commentsIds[$i])->delete();
        }

        // delete it marks
        $marks = Mark::where('recipe_id', $recipe_id)->get();
        foreach($marks as $mark){
            Mark::findOrFail($mark->id)->delete();
        }

        // delete the picture
        $picture = Recipe::findOrFail($recipe_id)->picture;
        if(File::exists(public_path('/assets/img/recipe/' . $picture))){
            File::delete(public_path('/assets/img/recipe/' . $picture));
        }

        // delete it
        Recipe::findOrFail($recipe_id)->delete();

    }
}
