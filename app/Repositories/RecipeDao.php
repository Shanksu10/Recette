<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Mark;
use App\Models\Recipe;
use App\Models\UserRecipeComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class RecipeDao
{
    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    public function getRecipes()
    {
        return Recipe::orderBy('created_at', 'DESC')->paginate(2);
    }

    public function getRecipe($recipe_id)
    {
        return Recipe::findOrFail($recipe_id);
    }

    public function getRecipeMaker($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)->user()->first();
    }

    public function getCategoriesOfOneRecipe($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)
                        ->categories()
                        ->get();
    }

    public function getRecipeIngredientsWithQuantities($recipe_id)
    {
        return DB::table('ingredient_recipe')
                    ->where('recipe_id', $recipe_id)
                    ->join('ingredients as i', 'i.id', '=', 'ingredient_id')
                    ->get();
    }

    public function getNutriValRecipe($recipe_id): Int
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
                $nutVal += $ingredient->nutri_value * $ingredient->quantity_ingredient / 100;
            }
            if($ingredient->unit == 'portion')
            {
                $nutVal += $ingredient->nutri_value * $ingredient->quantity_ingredient;
            }
        }
        return $nutVal;
    }

    public function getRecipeMark($recipe_id)
    {
        return DB::table('marks')->where('recipe_id', $recipe_id)
                        ->avg('mark');
    }

    public function myRecipe($recipe_id, $user_id)
    {
        return Recipe::where('id', $recipe_id)->where('user_id', $user_id)->get();
    }

    public function getRecipeCommentsWithMars($recipe_id)
    {
        return DB::table('user_recipe_comment')
                    ->join('comments as c', 'c.id', '=', 'user_recipe_comment.comment_id')
                    ->join('users as u', 'user_recipe_comment.user_id', '=', 'u.id')
                    ->join('marks as m', function($join){
                        $join->on('m.recipe_id', '=', 'user_recipe_comment.recipe_id')
                             ->on('m.user_id', '=', 'user_recipe_comment.user_id');
                    })
                    ->where('user_recipe_comment.recipe_id', $recipe_id)
                    ->orderBy('user_recipe_comment.created_at', 'DESC')
                    ->get();
    }

    public function addComment($comment): Comment
    {
        $row = ['comment' => $comment];
        return Comment::create($row);
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

    public function addMark($recipe_id, $user_id, $mark)
    {
        $row = [
            'user_id' => $user_id,
            'recipe_id' => $recipe_id,
            'mark' => $mark
        ];
        return Mark::create($row);
    }

    public function isUserMaredRecipe($user_id, $recipe_id): bool
    {
        if(count(Mark::where('user_id', $user_id)->where('recipe_id', $recipe_id)->get()) == 0)
            return false;
        return true;
    }

    public function updateMark($recipe_id, $user_id, $mark)
    {
        Mark::where('user_id', $user_id)->where('recipe_id', $recipe_id)->update(['mark' => $mark]);
    }

    public function isSaved($user_id, $recipe_id)
    {
        return Favorite::where('user_id', $user_id)->where('recipe_id', $recipe_id)->count();
    }

    public function getRecipeTypes($recipe_id)
    {
        return Recipe::findOrFail($recipe_id)->types()->get();
    }
}
