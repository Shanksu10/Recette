<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientRecipe extends Model
{
    use HasFactory;
    protected $table = "ingredient_recipe";

    protected $primaryKey = 'id';

    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'quantity_ingredient'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
