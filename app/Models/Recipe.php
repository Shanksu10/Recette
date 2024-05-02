<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Recipe extends Model
{
    use HasFactory;
    protected $table = "recipes";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description_recipe',
        'preparation_steps',
        'preparation_time',
        'cooking_time',
        'number_per',
        'picture',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function marks()
    {
        return $this->belongsToMany(User::class, 'marks','recipe_id','user_id')->withPivot('mark');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class,'ingredient_recipe','recipe_id','ingredient_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class,'favorites','recipe_id','user_id');
    }
    
    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_recipe', 'recipe_id', 'meal_id');
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryRecipe::class, 'categories_of_recipes', 'recipe_id', 'category_recipe_id');
    }

    public function types()
    {
        return $this->belongsToMany(TypeRecipe::class, 'types_of_recipes','recipe_id','type_recipe_id');
    }

}

